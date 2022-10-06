<?php

class EloquentNotificationsRepository implements NotificationsRepository
{
	protected $model;

	public function __construct(Notification $model)
	{
		$this->model = $model;
	}

	public function send($notice,$sendemail = true)
	{
		// dd($notice);
		$validation = Validator::make($notice,$this->model->rules);
		
		if($validation->fails())
		{
			throw new Exception(json_encode($validation->messages()->all()), 400);			
		}

		if ($sendemail) $this->sendEmail($notice);
		return $this->model->create(array(
			'subject' => $notice['subject'],
			'message' => htmlentities($notice['message'], ENT_QUOTES),
			'user_id' => $notice['user_id']
			));		
	}

	public function sendEmail($notice)
	{
		$user = Sentry::findUserById($notice['user_id']);		
		return EmailController::sendMail($user->email, $user->first_name.' '.$user->last_name, $notice['subject'], $notice['message']);
	}

	public function getUserNotices($user_id = null)
	{
		if(is_null($user_id))
		{
			$user_id = Sentry::getUser()->id;
		}
		$notices = $this->model->where('user_id',$user_id)->get();

		return $notices;
	}

	public function delete($id)
	{		
		$notice = $this->model->findOrFail($id);
		return $notice->delete();
	}
}