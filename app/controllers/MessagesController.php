<?php

class MessagesController extends BaseController
{
	protected $repo;

	public function __construct(MessagesRepository $repo)
	{
		$this->repo = $repo;
		View::composer(array('message.compose','messages.index','messages.layout'), function($view)
		{			
			return $view->with('user',App::make('AuthenticationRepository')->getUser());
		});
	}

	public function inbox()
	{
        $user = $this->getLoguedUser();
        $data['messages'] = Message::userInboxMessages($user->id)->get();
		return View::make('messages.index',$data);
	}
    
    // archive all unarchived messages for the logged in user
    public function archive_messages()
    {
         Message::archiveMessages();
         return Response::json(array('success' => true));      
    }

    public function archived()
    {
        $user = $this->getLoguedUser();
        $data['messages'] = Message::userArchivedMessages($user->id)->get();
        return View::make('messages.index',$data);
    }

	public function unread()
	{
		$data['messages'] = $this->repo->getUsersUnreadMessages();
	    return View::make('messages.index',$data);
	}

	public function sent()
	{
        $user = $this->getLoguedUser();
		$data['messages'] = Message::userSentMessages($user->id)->get();
        return View::make('messages.index',$data);
	}

	public function draft()
	{
        $user = $this->getLoguedUser();
        $data['messages'] = Message::userDraftMessages($user->id)->get();
        return View::make('messages.index',$data);
	}

	public function trash()
	{
		$data['messages'] = $this->repo->getUsersTrashMessages();
		$this->layout->title = 'Trash';
		$this->layout->content = View::make('messages.index',$data);
	}


	public function compose($id = null)
	{
        if ($id!==null){
            $data['message'] = Message::find($id);
        }
		$currentUser = User::findOrFail(Sentry::getUser()->id);

//      //todo: this can be integrated later (use message_recipients table)
//		foreach ($currentUser->circles as $circle)
//		{
//			$data['recipients']['Circles']['circle:'.$circle->id] = $circle->name;
//		}
//		foreach ($user->contacts as $contact) {
//			$data['recipients']['Contacts']['user:'.$contact->id] = $contact->first_name.' '.$contact->last_name;
//		}
        foreach (User::all() as $user){
            if ($user->id!==$currentUser->id){
                $data['recipients']['Users'][$user->id] = $user->first_name.' '.$user->last_name;
            }
        }

		return View::make('messages.compose',$data);

	}

    /**
     * Saves a method model in the DB
     * Can send or save draft
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save()
	{
        //get values
        $input = Input::all();
        $attributes = array
        (
            'subject'=>(isset($input['subject'])?$input['subject']:""),
            'to'=>isset($input['to'])?$input['to']:null,
            'from'=>Sentry::getUser()->id,
            'message'=>isset($input['message'])?$input['message']:null
        );

        //make sure validates if attempting to send
        if(isset($input['send']))
        {
            $validation = Validator::make($attributes,Message::$canSend);
            if ($validation->fails()){
                return Redirect::route('messages.compose')->with('message','attributes')->withErrors($validation);
            }
            $attributes['sent_at'] = date('Y-m-d H:m:s');
        }

        //if new
        if (!isset($input['id']))
        {
            Message::create($attributes);
        }
        //if draft
        else
        {
            $message = Message::find($input['id']);
            $message->update($attributes);
        }

        return Redirect::route('message.sent');
	}

	public function read($id)
	{
		$data['message'] = Message::find($id);
        return View::make('messages.show',$data);
    }

	public function reply($id)
	{
        //Disabled while only notifications are enabled
//		$data['messages'] = $this->repo->getMessage($id);
//		$this->layout->content = View::make('messages.compose',$data);
	}

	public function delete($id)
	{
		Message::archive($id);
		return Response::to('messages');
	}

}