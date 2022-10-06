<?php

use Illuminate\Support\Facades\Auth;
class FeedbackController extends BaseController {

	public function addContactFeedback($feedback_id){
		$feedback = ContactFeedback::find($feedback_id);

		$feedback->points = Input::get('points');
		$feedback->comments = Input::get('comments');
		$feedback->status = ContactFeedback::$STATUS_CLOSED;

		$feedback->update();

		return Redirect::route('my-contacts')->with('message', "Thanks for your feedback!");
	}
}










