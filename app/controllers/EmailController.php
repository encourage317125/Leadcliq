<?php

class EmailController {

	/**
	 * Returns the logued User using an instance of UserController
	 */
	protected function getLoguedUser(){
		$userConntroller = new UsersController(new User());
		return $userConntroller->getUser(Sentry::getUser()->id);
	}

	public static function sendNotifyBider($bider, $resolution){
		$subject = 'Your bid got ' . $resolution;
		$body =  View::make('emails.NotifyBidder' . $resolution, compact('bider'))->render();
	
		$to_email = $bider->email;
		$to_name = $bider->first_name;
	
		EmailController::sendMail($to_email, $to_name, $subject, $body);
	}
	
	public static function sendNotifyOwnerApptBided($owner, $buyer, $appointment){
		$subject = 'Your appointment got bided';
		$body =  View::make('emails.NotifyOwnerApptBided', compact('owner', 'buyer', 'appointment'))->render();
	
		$to_email = $owner->email;
		$to_name = $owner->first_name;
	
		EmailController::sendMail($to_email, $to_name, $subject, $body);
	}
	
	
	public static function sendNotifyOwnerContactSold($owner, $buyer, $contact){
		$subject = 'You just sold a contact!';		
		$body =  View::make('emails.NotifyOwnerContactSold', compact('owner', 'buyer', 'contact'))->render();

		$to_email = $owner->email;
		$to_name = $owner->first_name;
		
		EmailController::sendMail($to_email, $to_name, $subject, $body);
	}
	
	
	/**
	 * Sends a Test email
	 * 
	 * @param String $to_email
	 * @param String $to_name
	 * @throws Mandrill_Error
	 */
	public static function sendMail($to_email, $to_name, $subject, $body){
		try {
			$mandrill = new Mandrill('3NlEczk7tDtI2-Y4K4tt3w');
			$message = array(
					'html' => $body,
					'text' => '',
					'subject' => $subject,
					'from_email' => 'no-reply@leadcliq.com',
					'from_name' => 'Leadlciq Notifications',
					'to' => array(
							array(
									'email' => "$to_email",
									'name' => "$to_name"
							)
					),
					'headers' => array('Reply-To' => 'no-reply@leadcliq.com'),
					'important' => false,
					'track_opens' => null,
					'track_clicks' => null,
					'auto_text' => null,
					'auto_html' => null,
					'inline_css' => null,
					'url_strip_qs' => null,
					'preserve_recipients' => null,
					'view_content_link' => null,
					'bcc_address' => 'message.bcc_address@example.com',
					'tracking_domain' => null,
					'signing_domain' => null,
					'return_path_domain' => null,
					'merge' => false,
			);
			$async = false;
// 			$ip_pool = 'Main Pool';
// 			$send_at = date('YYYY-MM-DD HH:MM:SS');
			$result = $mandrill->messages->send($message, $async);
			/*
			 Array
			(
					[0] => Array
					(
							[email] => recipient.email@example.com
							[status] => sent
							[reject_reason] => hard-bounce
							[_id] => abc123abc123abc123abc123abc123
					)

			)
			*/
		} catch(Mandrill_HttpError $e) {
			// Mandrill errors are thrown as exceptions
			echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
			// A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
			throw $e;
		}catch(Mandrill_Error $e) {
			// Mandrill errors are thrown as exceptions
			echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
			// A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
			throw $e;
		}
	}

}