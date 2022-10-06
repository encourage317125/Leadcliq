<?php

class BaseController extends Controller {

	/**
	 * Returns the logued User using an instance of UserController
	 */
	protected function getLoguedUser(){
		$userConntroller = new UsersController(new User());
		return $userConntroller->getUser(Sentry::getUser()->id);
	}
	
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}