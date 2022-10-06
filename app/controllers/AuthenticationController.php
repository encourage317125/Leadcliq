<?php

class AuthenticationController extends BaseController 
{

	protected $repo;

	public function __construct(AuthenticationRepository $repo)
	{
		$this->repo = $repo;
	}

	//Show login form

	public function login_form()
	{
		return View::make('authentication.login');
	}

	/**
	 * Process the login user
	 */
	public function login()
	{		
		$credentials['email'] = Input::get('email');
		$credentials['password'] = Input::get('password');
		$remember = (is_null(Input::get('remember'))?false:true);		

		$user = $this->repo->login($credentials, $remember);		
		if (!$user)
		{
			Redirect::route('login')->withInput(Input::except('password'));
		}
		if(Session::has('redirect'))
		{
			$url  = Session::get('redirect');
			Session::forget('redirect');			
			return Redirect::to(Session::get('redirect'))->with('afterlogin', true);	
		}
		return Redirect::route('home')->with('afterlogin', true);
	}

	 public function registration_form() 
	 { 
	 	return View::make('authentication.register');
	 }

	/**
	 * Porcess a new user
	 * 
	 * TODO Send activation code to the user so he can activate the account
	 */
	public function register()
	{
		$input = Input::All();
		
		$validation = Validator::make($input, User::$rules);
		
		if ($validation->passes() && $data['user'] = $this->repo->register($input))
		{			
			$data['activationCode'] = $data['user']->getActivationCode();
			//Send activation code
			$body = View::make('emails.auth.account_activation',$data);
			EmailController::sendMail($data['user']->email, $data['user']->first_name.' '.$data['user']->last_name, 'Welcome to Leadcliq', $body);
			// Create a Milestones entry to track user's checkpoints.
			Milestone::create(array('user_id' => $data['user']->id));
			
			return View::make('authentication.activation_message',$data);			
		}
		return Redirect::route('register')
		->withInput()
		->withErrors($validation)
		->with('message', 'There were validation errors.');
	}

	public function activate()
	{
		if ($code = Input::get('code'))
		{
			if($this->repo->activate($code))
			{
				return Redirect::to('home');
			}
		}
		return View::make('authentication.activation_failed')->with('reason',Session::get('error'));		
	}


	public function forgot_password_form() 
	{ 
		return View::make('authentication.forgot_password'); 
	}

	/**
	 * Resets the users password
	 * 
	 * TODO send mail
	 */
	public function forgot_password()
	{
		$email = Input::get('email');

		//Get reset code and send email
		if($resetCode = $this->repo->getResetCode($email))
		{
			return View::make('authentication.confirm_reset_code_sent')->with('email',$email)->with('resetCode',$resetCode);
		}
		return View::make('authentication.forgot_password')->withInput(Input::all()); 
	}

	//show password reset form
	public function reset_password_form()
	{
		$code = Input::get('code');
		if($user = $this->repo->checkResetCode($code))
			return View::make('authentication.reset_password')->with('user',$user)->with('code',$code);
		return Redirect::to('forgot_password');
	}
	
	//Reset password if code is valid
	public function reset_password()
	{
		$validation = Validator::make(Input::all(),array('password'=>'required|min:8|confirmed'));
		if($validation->passes())
		{
			$code = Input::get('code');
			$password = Input::get('password');
			if ($this->repo->resetPassword($code,$password))
			{
				return Redirect::to('login');
			}
		}
		else
		{			
			Session::flash('error','There are errors with the password');
			return Redirect::to('user/reset-password?code='.Input::get('code'))->withErrors($validation);
		}
		return Redirect::to('forgot_password');
	}

	/**
	 * Logs out the user
	 */
	public function logout()
	{
		$this->repo->logout();		
		return Redirect::route('login')->with('message', 'See you soon!');
	}
}
























