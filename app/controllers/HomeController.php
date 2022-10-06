<?php

class HomeController extends BaseController {

	
	public function index()	{
		$user = $this->getLoguedUser();
		return View::make('home-stage1', compact('user'));
	}

}