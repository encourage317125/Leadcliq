<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MarketplaceTest extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'market:test';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Run various command to test the marketplace api';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		if(is_readable(storage_path().'/meta/cleanup.json'))
			$clean = json_decode(file_get_contents(storage_path().'/meta/cleanup.json'));
		try
		{
			#create seller
			$seller = Sentry::createUser(array(
		        'email'     => 'user-'.uniqid().'@example.com',
                'alias'     => 'JohnDoe',
		        'password'  => 'test1234',
		        'first_name' => 'John',
		        'last_name' => 'Doe',
		        'activated' => true,
		    ));
		    $clean[] = array('table'=>'users','id'=> $seller->id);
		    $this->info('Created Seller ID:'.$seller->id);

		    #create buyer
		    $buyer = Sentry::createUser(array(
		        'email'     => 'user-'.uniqid().'@example.com',
                'alias'     => 'JaneDoe',
                'password'  => 'test1234',
		        'first_name' => 'Jane',
		        'last_name' => 'Doe',
		        'activated' => true,
		    ));
		    $clean[] = array('table'=>'users','id'=> $buyer->id);
		    $this->info('Created Buyer ID:'.$buyer->id);

			#Create ApptShares
		    Sentry::login($seller, false);
			$this->info('Logged in: '.Sentry::getUser()->email);
			
			$single_payment_appt = ApptShare::create(array('title'=>'Sample ApptShare '.uniqid().' with single payment of 500','user_id'=>$seller->id ,'sell_for'=>'money','status'=>'public' ,'pay_option'=>'one_price','price'=>500));
			$clean[] = array('table'=>'apptshares','id'=> $single_payment_appt->id);
			$this->info('Created ApptShare: '.$single_payment_appt->title);
			
			$multiple_payment_appt = ApptShare::create(array('title'=>'Sample ApptShare '.uniqid().' with multiple payments','user_id'=>$seller->id , 'sell_for'=>'money','status'=>'public' ,'pay_option'=>'multiple-payout'));
			$this->info('Created ApptShare: '.$multiple_payment_appt->title);
			$clean[] = array('table'=>'apptshares','id'=> $multiple_payment_appt->id);
			for ($i = 1; $i <=5; $i++)
			{
				$checkpoint = new ApptShareCheckpoint(array('title'=>'Checkpoint '.$i, 'amount'=>rand(1,10)*50));
				$multiple_payment_appt->checkpoints()->save($checkpoint);
				$clean[] = array('table'=>'apptshares_checkpoints','id'=> $checkpoint->id);
				$this->info('Created Checkpoint: '.$checkpoint->title.' for ApptShare'.$multiple_payment_appt->title);
			}


			$marketplace = new Leadcliq\Repositories\Payments\BalancedPayments();
			
			#Purchase workflow
			Sentry::login($buyer, false);

			#1. Create a buyer
			$marketplace->activate();
			$this->info('Buyer Marketplace ID = '.Sentry::getUser()->market_id);

			#2. Add a card 
			/*called via balanced.js in production*/ $card = $marketplace->getMarket()->createCard('123 Fake Street','Jollywood',null,'90210',$buyer->full_name,'4112344112344113',null,12,2016);
			$card = $marketplace->addCard(array('uri'=>$card->id,'last_four'=>substr($card->number,-4),'brand'=>$card->brand));
			$this->info("Added Card: $card->last_four to User: $buyer->email");

			#3. Add a bank account
			/*called via balanced.js in production*/ $bank = $marketplace->getMarket()->createBankAccount($buyer->full_name,'112233a','121042882','checking');
			$bank = $marketplace->addBank($bank->id);
			$this->info("Added Bank: $bank->bank_name ($bank->account_number) to User: $buyer->email");

			#4. Purchase apptshare with default card
			$purchase = array(
				'amount' => $single_payment_appt->price*100,
				'description' => 'Payment for: '.$single_payment_appt->title.'. ApptShare ID: '.$single_payment_appt->id,
				'meta' => array(
					'paid_for' => 'ApptShare',
					'paid_id' => $single_payment_appt->id,
					),
				);
			$payment = $marketplace->putInEscrow($purchase);
			if(is_array($payment))
				$this->info("Debit Status: ".$payment['status'].". Reason: ".$payment['reason']);
			else
				$this->info("Successfully purchased $payment->paid_for: $payment->description ");

			#5. Purchase apptshare with bank
			$purchase = array(
				'amount' => $multiple_payment_appt->checkpoints()->sum('amount')*100,
				'description' => 'Payment for: '.$multiple_payment_appt->title.'. ApptShare ID: '.$multiple_payment_appt->id,
				'meta' => array(
					'paid_for' => 'ApptShare',
					'paid_id' => $multiple_payment_appt->id,
					),
				);
			$payment = $marketplace->putInEscrow($purchase);
			if(is_array($payment))
				$this->info("Debit Status: ".$payment['status'].". Reason: ".$payment['reason']);
			else
				$this->info("Successfully purchased $payment->paid_for: $payment->description ");

			#SELLER'S WORKFLOW

			#Promote to Merchant

			#check balance
			$this->info('Balance in Escrow: '.$marketplace->moneyInEscrow($seller->id));
			$this->info('Balance Available for Withdrawal: '.$marketplace->moneyAvailableForWithdraw($seller->id));
			

			#Withdraw Available funds

			# DISPUTE RESOLUTION

			#Buyer Raise Dispute

			#Seller Agree & Refunds
			$this->info('Refund 50% of '.$payment->amount);
			$refund = $marketplace->returnToBuyer($payment->reference_uri, $payment->amount/2);
			$this->info('Successful: '.$refund->description);
			$this->info('Balance in Escrow: '.$marketplace->moneyInEscrow($seller->id));
			$this->info('Balance Available for Withdrawal: '.$marketplace->moneyAvailableForWithdraw($seller->id));

			#Buyer Raise Dispute

			#Seller Disagree

			#Seller Raise Dispute

			#Buyer Agree & Payout

			#Seller Raise Dispute
			
			#Buyer Disagrees

			$this->info('Successfully completed test');
		}
		catch(Exception $ex)
		{
			$this->info("Error! ".$ex->getMessage());
			// var_dump($ex->getTrace());
		}

		file_put_contents(storage_path().'/meta/cleanup.json', json_encode($clean,JSON_PRETTY_PRINT));
	}

    /**
     * Tests all transactions
     */
    private function calculateBalance(){

    }

    /**
     * Should add money to balance after out of pending period
     */
    private function sellTrasactionAddsMoney(){

    }

    /**
     * At first money should be added as pending
     */
    private function sellTrasactionPendingAddsMoney(){

    }

    /**
     *
     */
    private function sellTrasactionThenInDispute(){

    }

    private function sellTrasactionSolveDispute(){

    }

    private function buyTransactionDeductsMoney(){

    }

    private function sellTransactionThenPutInDisputePutsMoneyIn(){

    }

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			
		);
	}

}