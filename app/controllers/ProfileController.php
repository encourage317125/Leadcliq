<?php

class ProfileController extends UsersController{

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	/**
	 * Renders the mycircles view
	 *
	 */
	public function myCircles(){
		$user = $this->user->findOrFail(Sentry::getUser()->id);
		return View::make('circles.my-circles', compact('user'));
	}

	/**
	 * Renders the mycontacts view
	 *
	 */
	public function myContacts(){
		$user = $this->user->findOrFail(Sentry::getUser()->id);

		echo View::make('contacts.my-contacts', compact('user'));

		return;
	}
    
    /**
     * Renders the mylistings view
     *
     */
    public function myListings(){
      
        $user = $this->user->findOrFail(Sentry::getUser()->id);

        $listings = Listing::sellingListings($user->id);

        return View::make('listings.my-listings', compact('listings'));
    }

	/**
	 * Renders the buy-contacts view
	 *
	 */
	public function buyContacts(){
		$user = $this->user->findOrFail(Sentry::getUser()->id);
		$circle_id = Input::get('circle', false);

		$contacts = array();
		$points = '';

		if($circle_id == 'open-market'){
			$result = Contact::select('*')->where('sell_open_market', '=', ContactTransaction::$SELL_IN_OPEN_MARKET)->get();
			foreach ($result as $contact) {
				if($contact->getRawStatus() == ContactTransaction::$CONTACT_FOR_SELL){
					array_push($contacts, $contact);
				}
			}
			$points = 'Open Market only operates on money';

		}else if($circle_id){
			
			if($circle_id && !$user->belongsToCircle($circle_id)){
				return Redirect::route('my-circles')->with('message', 'You are not part of the requested circle, join it to continue.');
			}

			$circle = $circle_id ? Circle::find($circle_id) : false;
			$contacts = $circle->contactsForSell();
			$points = $user->pointAmountInCircle($circle->id);
		}

		return View::make('contacts.buy-contacts', compact('circle_id', 'user', 'contacts', 'points'));
	}

	/**
	 * Renders the sell-contacts view
	 *
	 */
	public function sellContacts(){
		$user = $this->user->findOrFail(Sentry::getUser()->id);

		echo View::make('contacts.sell-contacts', compact('user'));

		return;
	}


	/**
	 * Renders the myappointments view
	 *
	 */
	public function myAppointments(){
		$user = $this->user->findOrFail(Sentry::getUser()->id);

		echo View::make('appointments.my-appointments', compact('user'));

		return;
	}


	/**
	 * Renders the bid-appointments view
	 *
	 */
	public function bidAppointments(){
		$user = $this->user->findOrFail(Sentry::getUser()->id);

		return View::make('appointments.bid-appointments', compact('user'));		
	}

	/**
	 * Renders the sell-appointments view
	 *
	 */
	public function sellAppointments(){
		$user = $this->user->findOrFail(Sentry::getUser()->id);

		echo View::make('appointments.sell-appointments', compact('user'));

		return;
	}

	/**
	 * Renders the Invite friends page
	 */
	public function inviteFriends(){
		$user = $this->user->findOrFail(Sentry::getUser()->id);

		echo View::make('marketing.invite-friends', compact('user'));

		return;
	}

	/**
	 * Send an Email to invite friends
	 * TODO
	 *
	 */
	public function sendInviteFriends(){
		$input = array_except(Input::all(), '_method');
		$user = $this->getLoguedUser();

		if(Referal::where('to', '=', Input::get('to'))->first() != null){
			return Redirect::route('invite-friends')->with('message', $input['to'] . ' has already been refered.');
		}
		
		$after_message = 'Our portal connects members to contacts and opportunities that drive sales results 
	            	for businesses! The first active network! Working actively in our platform 
	            	will cut down your prospecting process by half the time, thereby 
	            	increasing your productivity!
	             	<br>
					<br>
					Our Site: <a href="www.leadcliq.com">www.leadcliq.com</a>
					<br>
					<br>
					Contact Us: support@leadcliq.com';
		EmailController::sendMail($input['to'], '', $user->first_name . ' ' . $user->last_name . ': ' . Input::get('subject','Join Me At Leadcliq'), Input::get('message') . $after_message);

		$length = 20;
		$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, $length);

		Referal::create(array(
		'user_id' => Sentry::getUser()->id,
		'from' => @$input['from'],
		'to' => $input['to'],
		'subject' => @$input['subject'],
		'message' => @$input['message'],
		'token' => $randomString,
		'status' => Referal::$NOT_SIGNED_YET
		));

		return Redirect::route('home')->with('message', 'Thanks! Invite as many friends as you want.');
	}

	/**
	 * Shows the user's sent referals
	 */
	public function myReferals(){
		$user = $this->user->findOrFail(Sentry::getUser()->id);

		echo View::make('marketing.my-referals', compact('user'));

		return;
	}

	/**
	 * Shows the steps to complete the User profile
	 */
	public function completeSteps(){
		$user = $this->getLoguedUser();
		$circles = Circle::where('name','!=',Circle::$OPENMARKET)->get();
        $dealSizeTiers = DealSizeTier::all();

        $test = $user->title;

        $companiesWorkedWith = $user->companiesWorkedWith->toArray();
        $namesOfCompaniesWorkedWith = $user->companiesWorkedWith->lists('name');

		echo View::make('steps.completeProfileSteps', compact('user', 'circles','companiesWorkedWith','namesOfCompaniesWorkedWith','dealSizeTiers'));

		return;
	}

    public function billing(){
        $redirect = Input::get('redirect');
        $user = User::with('cards','banks','contactTransactionsTo','contactTransactionsFrom','payments')->find(Sentry::getUser()->id);
        return View::make('billing')->with('user',$user)->with('transactions',array())->with('redirect',$redirect);
    }

}










