<?php

class ReportController extends BaseController{


	public function prepareReportModal($user_id){
		return View::make('reports.prepare-report-user', compact('user_id'));
	}

	public function sendReport($id){
		$user = $this->getLoguedUser();

		Report::create(array(
			'from_id' => $user->id,
			'to_id' => $id,
			'description' => Input::get('report_description'),
			'status' => Report::$STATUS_OPEN,
			'resolution' => Report::$RESOLUTION_PENDING
		));

		EmailController::sendMail('cherryl@leadcliq.com', 'Cherryl', 'New user report: ' . $id , 'Description: ' . Input::get('report_description'));

        return Redirect::route('my-contacts')
            ->with('message', 'Thanks. A new report has been filed for this user. We will contact soon.');
	}

}












