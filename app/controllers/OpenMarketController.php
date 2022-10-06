
<?php

use Illuminate\Support\Facades\Auth;
class OpenMarketController extends BaseController {


	public function index(){
		$user = $this->getLoguedUser();
	
		return View::make('open-market', compact('user'));
	}

	/**
	 * Show the Open Market for Contacts
	 *
	 * @return Response
	 */
	public function showContacts()
	{
		$user = $this->getLoguedUser();
		
		$result = Contact::select('*')->where('sell_open_market', '=', ContactTransaction::$SELL_IN_OPEN_MARKET)->get();
		$contacts = array();
		foreach ($result as $contact) {
			if($contact->getRawStatus() == ContactTransaction::$CONTACT_FOR_SELL){
				array_push($contacts, $contact);
			}
		}
	
		return View::make('contacts.open-market', compact('user', 'contacts'));
	}


	/**
	 * Show the Open Market for Appts
	 *
	 * @return Response
	 */
	public function showAppts()
	{
		$user = $this->getLoguedUser();
		
		$result = Appointment::select('*')->where('sell_open_market', '=', AppointmentTransaction::$SELL_IN_OPEN_MARKET)->get();
		$appointments = array();

		foreach ($result as $appt) {
			if($appt->getRawStatus() == AppointmentTransaction::$APPOINTMENT_FOR_SELL){
				array_push($appointments, $appt);
			}
		}
	
		return View::make('appointments.open-market', compact('user', 'appointments'));
	}


}





