<?php

class MarketplaceController extends BaseController
{
	private $marketplace;

	public function __construct()
	{
		$this->marketplace = $marketplace = new Leadcliq\Repositories\Payments\BalancedPayments();
    }

/************************************Examples**************************************/
	public function getExample()
	{
		 return View::make('marketplace.example');
	}

	public function getRequestrefund()
	{
		$uri = Input::get('uri');
		$refund = $this->marketplace->refund($uri);
		if($refund)
			return Response::json($refund,201);
		else
			return Response::json(array('error'=>'true',400));
	}

	public function getBuyfixedcontact()
	{
		$card = Input::get('card');
		$contact = array(
			'amount'=>500*100,
			'description' => 'Example contact with fixed price',
			'meta' => array('paid_for'=>'Contact','paid_id'=> rand(1,1000))
			);
		$payment = $this->marketplace->buy($contact, $card);
		if($payment)
			return Response::json($payment,201);
		else
			return Response::json(array('error'=>'true',400));
	}

	public function getBuyfixedappt()
	{
		$card = Input::get('card');
		$appt = array(
			'amount'=>300*100,
			'description' => 'Example appt with fixed price',
			'meta' => array('paid_for'=>'ApptShare','paid_id'=> rand(1,1000))
			);
		$payment = $this->marketplace->buy($appt, $card);
		if($payment)
			return Response::json($payment,201);
		else
			return Response::json(array('error'=>'true',400));
	}
	public function getBuycheckpointcontact()
	{
		$card = Input::get('card');
		$contact = array(
			'amount'=>1500*100,
			'description' => 'Example contact with checkpoints',
			'meta' => array('paid_for'=>'Contact','paid_id'=> rand(1,1000))
			);
		$payment = $this->marketplace->buy($contact, $card);
		if($payment)
			return Response::json($payment,201);
		else
			return Response::json(array('error'=>'true',400));
	}
	public function getBuycheckpointappt()
	{
		$card = Input::get('card');
		$appt = array(
			'amount'=>2500*100,
			'description' => 'Example appt with checkpoints',
			'meta' => array('paid_for'=>'ApptShare','paid_id'=> rand(1,1000))
			);
		$payment = $this->marketplace->buy($appt, $card);
		if($payment)
			return Response::json($payment,201);
		else
			return Response::json(array('error'=>'true',400));
	}
	public function getSellfixedcontact()
	{

	}
	public function getSellfixedappt()
	{

	}
	public function getSellcheckpointcontact()
	{

	}
	public function getSellcheckpointappt()
	{

	}


/******************************End of Examples************************************/

	public function getProfile()
	{
		$profile = $this->marketplace->getProfile();
		if(Request::ajax() || Request::wantsJson() || Request::json())
		{
			return Response::json($profile, 200);
		}
		echo $profile;
	}

	public function postAddcard()
	{
		$card = $this->marketplace->addCard(Input::only('name','uri','last_four'));
		return Response::json($card->toArray(), 201);
	}

	public function addBank()
	{
		$bank = new BankAccount(array_merge(array('user_id'=>Sentry::getUser()->id),Input::only('id','name','uri','type','account_number','bank_code','bank_name','can_debit','is_valid')));
		$bank->save();
		$customer = Balanced\Customer::get(Sentry::getUser()->market_id);
		$customer->addBankAccount($bank->uri);
		User::find(Sentry::getUser()->id)->banks()->save($bank);
		return Response::json($bank->toArray(), 201);
	}

	public function deleteCard()
	{
		$uri = Input::get('uri');
		if ($this->marketplace->deleteCard($uri))
			return Response::json(array('error'=>false), 200);
		else
			return Response::json(array('error'=>true), 400);
	}

	public function getActivate()
	{
		$this->marketplace->activate();
		return $this->getProfile();
	}
	public function getDeactivate()
	{
		$this->marketplace->deactivate();
		return $this->getProfile();
	}

	/**********************************************************************************/

	public function user()
	{
		$user = User::with(array('cards','banks'))->find(Sentry::getUser()->id);
		return Response::json($user->toArray());
	}

	public function profile()
	{
		$user = User::with('cards','banks')->find(Sentry::getUser()->id);
		return View::make('marketplace.profile')->with('user',$user)->with('transactions',array());
	}
}