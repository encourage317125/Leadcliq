<?php

class EloquentAuthenticationRepository implements AuthenticationRepository
{	

	public function getUser($id = null)
	{
		if($id == null)
		{
			return Sentry::getUser();
		}
		else
		{
			return Sentry::findUserByID($id);
		}
	}
	public function login($credentials,$remember)
	{			
		try
		{			
			if($remember)
			{
				$user = Sentry::authenticateAndRemember($credentials);
			}
			else
			{
				$user = Sentry::authenticate($credentials);				
			}
			return $user;
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
			Session::flash('error', 'Email is required.');
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
			Session::flash('error', 'Password is required.');
		}
		catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
		{
			Session::flash('error', 'There was a problem with either the login or password. Please try again.');
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			Session::flash('error', 'There was a problem with either the login or password. Please try again.');
		}
		catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
		{
			Session::flash('error', 'Your account is not activated. Please activate it before proceeding');
		}
		return false;
	}


	public function register($details)
	{
		try
		{
			return Sentry::register($details);
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
			Session::flash('message', 'Email field is required.');
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
			Session::flash('message', 'Password field is required.');
		}
		catch (Cartalyst\Sentry\Users\UserExistsException $e)
		{
			Session::flash('message', 'User with this email already exists.');
		}
		return false;
	}
	public function activate($code)
	{
		try
		{
			$user = Sentry::findUserByActivationCode($code);

		    // Attempt to activate the user
			if ($user->attemptActivation($code))
			{
                /** @var Automatically add user to open market circle */
                $openMarketCircle = Circle::openMarket()->first();
                $user->circles()->sync(array($openMarketCircle->id));

				App::make('ReferralRepository')->referalActivated($user->email);
				 // Log the user in
    			Sentry::login($user);
    			return true;
			}
			else
			{
				Session::flash('error','Invalid activate code');		    
			}
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			Session::flash('error','Activation code does not exist. Please check your email again');
		}
		catch (Cartalyst\Sentry\Users\UserAlreadyActivatedException $e)
		{
			Session::flash('error','Your account has already been activated.');
		}
		return false;
	}


	public function getResetCode($email)
	{
		try
		{			
		    // Find the user using the user email address
			$user = Sentry::findUserByLogin($email);

		    // Get the password reset code
			$resetCode = $user->getResetPasswordCode();

		    // send code via email to user. For now simple show on screen

		    //Show password reset password
			return $resetCode; 
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			Session::flash('error','Sorry that email is not registered in our database.');
		}
		return false;
	}
	public function checkResetCode($code)
	{
		try
		{
			
			return Sentry::findUserByResetPasswordCode($code);
			
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			Session::flash('error','The reset code is invalid. Please request a new code');
		}
		return false;
	}
	public function resetPassword($code,$password)
	{
		try
		{
			$user = Sentry::findUserByResetPasswordCode($code);
		    // Attempt to reset the user password
			if ($user->attemptResetPassword($code, $password))
			{
				Session::flash('success',$user->first_name.', your password has successfully been updated. Login with your new password to access your account');				
				return true;
			}
			else
			{
				Session::flash('error','Your reset code/password were invalid. Please try again');				
			}
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			Session::flash('error','The reset code is invalid. Please request a new code');
		}
		
		return false;
	}

	public function logout()
	{
		Sentry::logout();
	}
	
}