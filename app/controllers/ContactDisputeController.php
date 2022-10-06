<?php

use Illuminate\Support\Facades\Auth;
class ContactDisputeController extends BaseController {

	// Admin view of the dispute to resolve it
	public function showDispute($id)
	{
		$dispute = ContactDispute::find($id);
		$contact = $dispute->contact($dispute->contact_id); 
		$user = $this->getLoguedUser();
	
		$sellerPreviousOffenses = ContactDispute::where('seller_id', '=', $dispute->seller_id)
							 			   ->where('resolution', '=', ContactDispute::$RESOLUTION_ACCEPTED)->count();							 			   

		$message_to_seller = '';
		$message_to_buyer = '';

		return View::make('disputes.show', compact('dispute', 'contact', 'user', 'sellerPreviousOffenses'));	
	}

	public function showAllDisputes()
	{
		$disputes = ContactDispute::all();
		$user = $this->getLoguedUser();
	
		return View::make('disputes.contacts-all-disputes')->with('disputes', $disputes)->with('user', $user);
	}

	public function showOpenDisputes()
	{
		$disputes = ContactDispute::where('status', '=', ContactDispute::$STATUS_OPEN)->get();
		$user = $this->getLoguedUser();
	
		return View::make('disputes.contacts-open-disputes', compact('disputes', 'user'));	
	}

	/**
	 * Show the form for submitting a new dispute
	 *
	 * @param  int  $id ContactTransaction
	 * @return Response
	 */
	public function prepareDispute($id)
	{
		$transaction = ContactTransaction::find($id);
		$contact = $transaction->contact($transaction->contact_id);
	
		if (is_null($contact)){
			return Redirect::route('contacts.index');
		}
		$user = $this->getLoguedUser();
	
		return View::make('contacts.prepare-dispute', compact('transaction', 'contact', 'user'));
	}

    /**
     * Creates the new dispute
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function openDispute($id)
	{
		$transaction = ContactTransaction::find($id);
		$input = array_except(Input::all(), '_method');

        //todo: we should put these into holding
		//Update buyer's points
        PointsController::addPoints($transaction->to,$transaction->circle_id,$transaction->points);

        //Update sellers's points
        PointsController::subtractPoints($transaction->from,$transaction->circle_id,$transaction->points);

		ContactTransaction::create(array(
				'contact_id' => $transaction->contact_id,
				'from' => $transaction->to,
				'to' => $transaction->from,
				'points' => $transaction->points,
				'operation' => ContactTransaction::$CONTACT_DISPUTED
		));
		
		$newDispute = ContactDispute::create(array(
				'contact_id' => $transaction->contact_id,
				'transaction_id' => $transaction->id,
				'buyer_id' => $transaction->to,
				'seller_id' => $transaction->from,
				'status' => ContactDispute::$STATUS_OPEN,
				'reason' => $input['reason'],
				'reason_description' => $input['reason_description']
		));

		$seller = User::find($transaction->from);
		$contact = $transaction->getContact();
		$sellerPreviousOffenses = ContactDispute::where('seller_id', '=', $seller->id)
							 			   ->where('resolution', '=', ContactDispute::$RESOLUTION_ACCEPTED)->count();							 			   

		$body = $this->getEmailSellerNewDisputeOffense($sellerPreviousOffenses, $seller, $contact);
		EmailController::sendMail($seller->email, $seller->first_name, 'New contact dispute opened', $body);

		// Tell the admin
		$body .= '<br><br><br>Reason: ' . $newDispute->reason;
		$body .= '<br>Reason description: ' . $newDispute->reason_description;

		$body .= '<br>Seller email: ' . $seller->email;
		$body .= '<br>Seller name: ' . $seller->first_name . ' ' . $seller->last_name;

		$body .= '<br>Buyer email: ' . $seller->email;
		$body .= '<br>Buyer name: ' . $seller->first_name . ' ' . $seller->last_name;
		EmailController::sendMail('gina@leadcliq.com', 'Gina', 'New contact dispute opened', $body);

		return Redirect::route('my-contacts')->with('message', 'New dispute opened. Your points were temporaly returned until resolution');
	}

	// Resolves a dispute
	public function resolveDispute($id)
	{
		$input = array_except(Input::all(), '_method');
		$dispute = ContactDispute::find($id);
		$transaction = ContactTransaction::find($dispute->transaction_id);

		$seller = User::find($transaction->from);
		$buyer = User::find($transaction->to);
		$contact = $transaction->getContact();

		if($input['resolution'] == ContactDispute::$RESOLUTION_DECLINED){

			//Sutract from buyer's points and Add to seller's points
            PointsController::subtractPoints($transaction->to,$transaction->circle_id,$transaction->points);
            PointsController::addPoints($transaction->from, $transaction->circle_id, $transaction->points);

			$body = View::make('disputes.emails.sellerContactDisputeDeclined', compact('seller', 'contact'))->render();
			EmailController::sendMail($seller->email, $seller->first_name, 'Contact dispute - Resolved', $body);

			$body = View::make('disputes.emails.buyerContactDisputeDeclined', compact('buyer', 'contact'))->render();
			EmailController::sendMail($buyer->email, $buyer->first_name, 'Contact dispute - Resolved', $body);
		}else{
			$body = View::make('disputes.emails.buyerContactDisputeAccepted', compact('buyer', 'contact'))->render();
			EmailController::sendMail($buyer->email, $buyer->first_name, 'Contact dispute - Resolved', $body);
		}

		$input['status'] = ContactDispute::$STATUS_CLOSED;
		$dispute->update($input);

		ContactTransaction::create(array(
				'contact_id' => $contact->id,
				'from' => $seller->id,
				'to' => $buyer->id,
				'points' => $transaction->points,
				'operation' => ContactTransaction::$CONTACT_DISPUTE_CLOSED
		));

		return Redirect::route('contacts-open-disputes')->with('message', 'Dispute closed');
	}


	/**
	* This email is sent after opening a new dispute	
	*/
	private function getEmailSellerNewDisputeOffense($offenseNumber, $user, $contact)
	{
		$offenseNumber = ($offenseNumber > 4) ? 4 : $offenseNumber;
		$offenseNumber = ($offenseNumber == 0) ? 1 : $offenseNumber;

		$body =  View::make('disputes.emails.sellerNewDisputeOffense' . $offenseNumber, 
								compact('user', 'contact'))->render();

		return $body;
	}
}










