<?php namespace Leadcliq\Repositories\Payments;

use BankAccount;
use Config;
use CreditCard;
use Sentry;
use User;
use Payment;
use ApptShare;

class BalancedPayments implements PaymentsContract
{
	public function __construct()
	{
		\Httpful\Bootstrap::init();
		\RESTful\Bootstrap::init();
		\Balanced\Bootstrap::init();
		\Balanced\Settings::$url_root = 'https://api.balancedpayments.com';
		\Balanced\Settings::$api_key = Config::get('marketplace.balancedpayments.api_key');
		$this->payments = new \Payment();
	}

	public function marketUri()
	{
		return \Balanced\Marketplace::mine()->href;
	}

	public function getMarket()
	{
		return  \Balanced\Marketplace::mine();
	}
	public function activate()
	{
		$user = Sentry::getUser();
		$details = $user->toArray();
		if(!isset($details['name'])) $details['name'] = $details['first_name'].' '.$details['last_name'];
		$details['city'] = ($user->city != ''?$user->city->name():'');
		$details['state'] = ($user->city != ''?$user->city->state->name():'');
		$details['country'] = 'United States';
		$customer = new \Balanced\Customer($details);
		$customer->save();
		$user->market_id = $customer->id;
		return $user->save();
	}

	public function deactivate()
	{
		$user = Sentry::getUser();
		$customer = \Balanced\Customer::get($user->market_id);
		$customer->delete();
		$user->market_id = NULL;
		$user->save();
	}

	public function getProfile()
	{
		$profile = Sentry::getUser();
		$profile->load('cards','banks','payments');
		$profile->market_active = !is_null($profile->market_id);
		return $profile;
	}

	public function addCard($input)
	{
		$user = Sentry::getUser();
		$card = new CreditCard($input);
		Sentry::getUser()->cards()->save($card);
		$customer = \Balanced\Customer::get($user->market_id);
		$bpcard = \Balanced\Card::get($card->uri);
		$bpcard->associateToCustomer($customer);
		return $card;
	}

	public function deleteCard($uri)
	{
		$card = Sentry::getUser()->cards()->find($uri);
		$card->delete();
		$card = Card::get($uri);
		return $card->unstore();
	}

	public function addBank($bp_id)
	{
		$bpbank = \Balanced\BankAccount::get($bp_id);
		$verification = $bpbank->verify();
		$requested_verification = \Balanced\BankAccountVerification::get($verification->href);
		$bank = new BankAccount(array(
			'id' =>$bpbank->id,
			'bank_name' =>$bpbank->bank_name,
			'account_number' =>$bpbank->account_number,
			'can_credit' => $bpbank->can_credit,
			'can_debit' => $bpbank->can_debit,
			'verification_uri' => $verification->href,
			'verification_status' =>$requested_verification->verification_status));
		Sentry::getUser()->banks()->save($bank);
		return $bank;
	}

	public function deleteBank($uri)
	{
		$bank = Sentry::getUser()->banks()->find($uri);
		$bank->delete();
		$bank_account = BankAccount::get($uri);
		return $bank_account->unstore();
	}


	public function updateCustomer($input)
	{
		
	}

	

	public function getCustomer($id = NULL)
	{	
		if(!isset($this->customer))	
		{
			if(is_null($id))
				$this->customer = \Balanced\Customer::get(Sentry::getUser()->market_id);
			else
				$this->customer = \Balanced\Customer::get(User::find($id)->market_id);
		}
		return $this->customer;
	}

	

	public function putInEscrow($details, $source_type = 'card', $source_id = null)
	{
        if ($source_id!==null){
            if ($source_type==='card'){
                $source = \Balanced\Card::get($source_id);
            }else{
                $source = \Balanced\BankAccount::get($source_id);
            }
        }else{
            $customer =  \Balanced\Customer::get(Sentry::getUser()->market_id);
            if($source_type == 'bank'){
                $source = $customer->bank_accounts;
            }
            else{
                $source = $customer->cards;
            }
            $source = $source->first();
        }

		$debit = $source->debit($details['amount'],Config::get('marketplace.user_statement_desc'),$details['description'],$details['meta']);		
		if($debit->status == 'succeeded')
		{
			$payment = new Payment(array(
			'user_id' => Sentry::getUser()->id,
			'amount' => $debit->amount/100,
			'status' => $debit->status,
			'payment_type' => $details['meta']['paid_for'],
			'payment_id' => $details['meta']['paid_id'],
			'description' => $details['description'],
			'reference_uri' => $debit->href,
			'type'	 => 'debit',
			));
			$payment->save();

			if(strtolower($details['meta']['paid_for']) == 'apptshare'){
                $item = \ApptShare::find($details['meta']['paid_id']);
            }
			elseif(strtolower($details['meta']['paid_for']) == 'contact'){
                $item = \Contact::find($details['meta']['paid_id']);
            }

            /** @var $item ApptShare | \Contact */
            $buyer_id = Sentry::getUser()->getId();
			$item->markSold($buyer_id);
			$item->save();

			$sellers = Payment::create(array(
				'user_id' => $item->user_id,
				'amount' => $debit->amount/100,
				'status' => 'pending',
				'payment_type' => $details['meta']['paid_for'],
				'payment_id' => $details['meta']['paid_id'],
				'description' => $details['description'],
				'reference_uri' => $payment->id,
				'type' => 'sale',
			));
			return $payment;
		}
		return array( 'status'=>$debit->status, 'reason'=>$debit->failure_reason, 'code'=> $debit->failure_reason_code);
	}

	public function returnToBuyer($uri, $amount = null)
	{
		$debit = \Balanced\Debit::get($uri);
		if(!is_null($amount))
			$refund = $debit->refund($amount*100);
		else
			$refund = $debit->refund();
		$payment = Payment::where('reference_uri',$uri)->first();
		$payment->status = 'refunded';
		$payment->save();
		$sellers_payment = Payment::where('reference_uri',$payment->id)->first();
		if($sellers_payment->status == 'pending' || $sellers_payment->status == 'available')
		{
			$sellers_payment->status = 'refunded';
			$sellers_payment->save();
			#partial refund
			if(!is_null($amount) && $amount != $sellers_payment->amount)
			{
				Payment::create(array(
					'user_id' => $sellers_payment->user_id,
					'amount' => $sellers_payment->amount - ($refund->amount/100),
					'status' => 'pending',
					'payment_type' => $payment->payment_type,
					'payment_id' => $payment->payment_id,
					'description' => 'partial - '.$payment->description,
					'reference_uri' => $sellers_payment->id,
					'type'	 => 'sale',
				));
			}
		}
		else
		{
			#Charge seller for the refund??
		}
		
		$payment = new Payment(array(
			'user_id' => $payment->user_id,
			'amount' => $refund->amount/100,
			'status' => $refund->status,
			'payment_type' => $payment->payment_type,
			'payment_id' => $payment->payment_id,
			'description' => 'Refund for: '.$payment->description,
			'reference_uri' => $refund->href,
			'type'	 => 'refund',
		));
		$payment->save();
		return $payment;
	}

	public function releaseToSeller()
	{
		
	}	

	public function moneyAvailableForWithdraw($id)
	{
		$available = Payment::where('user_id',$id)->where('status','available')->sum('amount');
		$available = number_format($available);
		return $available;
	}

	public function moneyInEscrow($id)
	{
		$pending = Payment::where('user_id',$id)->where('status','pending')->sum('amount');
		$pending = number_format($pending);
		return $pending;
	}

	public function withdrawMoney()
	{
		
	}
}