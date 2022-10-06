<?php

class EloquentMessagesRepository implements MessagesRepository
{
	protected $model;
	protected $user;

	
	public function __construct(Message $model)
	{
		$this->model = $model;
		$this->user = App::make('AuthenticationRepository')->getUser();
	}
	
	public function getUsersInboxMessages()
	{

		return;
	}
	
	public function getUsersUnreadMessages()
	{
		return;
	}
	
	public function getUsersSentMessages()
	{
		$messages = $this->model->where('from',$this->user->id)->paginate(2);
		return $messages->toArray();
	}
	
	public function getUsersDraftMessages()
	{
		return;
	}
	
	public function getUsersTrashMessages()
	{
		return;
	}
	
	public function getUsersCircles()
	{
		return;
	}
	
	public function getUsersContacts()
	{
		return;
	}
	
	public function getMessage($id)
	{
		return;
	}

	public function processMessage($message)
	{
		$this->model->id = md5($this->user->id.uniqid());
		$this->model->subject = (isset($message['subject'])?$message['subject']:"");
		$this->model->message = $message['message'];
		$this->model->from = $this->user->id;
		$this->model->to = json_encode($message['to']);
		// $this->model->to_type = $message['to_type'];
		if($message['send'])
		{
			//send email
			$this->model->sent_at = date('Y m d H:m');
		}
		$this->model->save();
		return $this->model;
	}
	
	public function deleteMessage($id)
	{
		return;
	}
	
	public function destroyMessage($id)
	{
		return;
	}
}