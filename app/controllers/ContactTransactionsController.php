<?php

use Illuminate\Support\Facades\Auth;
class ContactTransactionsController extends BaseController {

	
	public function buyContact($contact_id, $circle_id){
		$helper = new ContactsController(new Contact());
		$contact = $helper->get($contact_id);
		$user_id = $this->getLoguedUser()->id;

		if($contact->user_id == $user_id){
			return Redirect::route('buy-contacts')->with('message', "You can't buy your own contacts.");
		}

		//Create transaction entry
		$t = ContactTransaction::create(array(
				'contact_id' => $contact_id,
				'circle_id' => $circle_id,
				'from' => $contact->user_id,
				'to' => $user_id,
				'points' => $contact->price,
				'operation' => ContactTransaction::$CONTACT_SOLD
		));

		//Open feedback entry
		ContactFeedback::create(array(
				'contact_id' => $contact_id,
				'contact_transaction_id' => $t->id,
				'seller_id' => $contact->user_id,
				'buyer_id' => $user_id,
				'status' => ContactFeedback::$STATUS_OPEN
		));	

		//Update buyer's points
		if($contact->sell_open_market != ContactTransaction::$SELL_IN_OPEN_MARKET){

			if(!PointsController::subtractPoints($user_id,$circle_id,$contact->price)){
				return Redirect::route('buy-contacts')->with('message', "Sorry! You don't have enough points.");
			}

		}
		
		//Update seller's points
		if($contact->sell_open_market != ContactTransaction::$SELL_IN_OPEN_MARKET){
			$seller_id = $contact->user_id;
            PointsController::addPoints($seller_id,$circle_id,$contact->price);
		}

		//Send email
		EmailController::sendNotifyOwnerContactSold($contact->owner, $this->getLoguedUser(), $contact);
		
		return Redirect::route('my-contacts')->with('message', 'Contact bought!');
	}
	
	public function putPrivate($id){
		$input = array_except(Input::all(), '_method');
		$user = $this->getLoguedUser();
	
		$entry = ContactTransaction::create(array(
				'contact_id' => $id,
				'circle_id' => 0,
				'from' => $user->id,
				'to' => $user->id,
				'points' => 0,
				'operation' => ContactTransaction::$CONTACT_PRIVATE
		));

		return Redirect::route('contacts.edit', $id)->with('message', 'Contact has been updated correctly.');
	}
	
	public function putPublic($id){
		$input = array_except(Input::all(), '_method');
		$user = $this->getLoguedUser();
	
		$entry = ContactTransaction::create(array(
				'contact_id' => $id,
				'circle_id' => $input['circle_id'],
				'from' => $user->id,
				'to' => $user->id,
				'points' => 0,
				'operation' => ContactTransaction::$CONTACT_PUBLIC
		));
	
		return Redirect::route('contacts.edit', $id)->with('message', 'Contact has been updated correctly.');
	}

	
	/**
	 * Puts for sell a single contact
	 */
	public function putForSellPoints($contact_id){
		$input = array_except(Input::all(), '_token');

		if(!array_key_exists('circles_id', $input)){
			return Redirect::route('sell-contact-points', $contact_id)
				->with('message', 'Please select at least one circle to sell')
				->withInput();
		}

		$circles_id = $input['circles_id'];
		$contact = Contact::find($contact_id);
		$user = $this->getLoguedUser();

		$contact->update($input['contact']);

		$points = 2;
		if(array_key_exists('intro_available', $input['contact'])){
			$contact->intro_available = 1;
			$points = 4;
		}else{
			$contact->intro_available = 0;
		}
		
		if(array_key_exists('opportunity', $input['contact'])){
			$contact->opportunity = 1;
			$contact->intro_available = 1;
			$points = 5;
		}else{
			$contact->opportunity = 0;
		}
		
		$contact->price = $points;
		$contact->expiration = @$input['contact']['expiration'];
		$contact->relationship = @$input['contact']['relationship'];
		$contact->project_size = @$input['contact']['project_size'];

		$contact->save();
		
		if($contact->opportunity && strlen($contact->opportunity_description) < 40){
			return Redirect::back()->with('message', $contact->first_name .' ' . $contact->last_name . ' needs an <strong>opportunity description</strong>');
		}

		foreach ($circles_id as $circle_id) {
			$entry = ContactTransaction::create(array(
					'contact_id' => $contact_id,
					'circle_id' => $circle_id,
					'from' => $user->id,
					'to' => $user->id,
					'points' => $points,
					'operation' => ContactTransaction::$CONTACT_FOR_SELL
			));
		}
		
		return Redirect::route('my-contacts')->with('message', 'Contact is now on the market');
	}


    /**
	 * Puts for sell a single contact
	 */
	public function putForSellMoney($contact_id){
		$input = array_except(Input::all(), '_token');
		$contact = Contact::find($contact_id);
		$user = $this->getLoguedUser();
		$checkpoints = $input['checkpoints'];

		$contact->sell_open_market = ContactTransaction::$SELL_IN_OPEN_MARKET;

		if(array_key_exists('intro_available', $input)){
			$contact->intro_available = 1;
		}else{
			$contact->intro_available = 0;
		}

		if(array_key_exists('has_checkpoints', $input)){
			$contact->has_checkpoints = 1;
		}else{
			$contact->has_checkpoints = 0;
		}

		$contact->price = $input['price'];

		$contact->save();

		foreach ($checkpoints as $checkpoint) {
			ContactCheckpoint::create(array(
				'contact_id' => $contact_id,
				'title' => $checkpoint['title'],
				'description' => $checkpoint['description'],
				'price' => $checkpoint['price']
			));
		}

		ContactTransaction::create(array(
			'contact_id' => $contact_id,
			'circle_id' => 0,
			'from' => $user->id,
			'to' => $user->id,
			'points' => $contact->price,
			'operation' => ContactTransaction::$CONTACT_FOR_SELL
		));
		
		return Redirect::route('my-contacts')->with('message', 'Contact is now on the open market');
	}

}










