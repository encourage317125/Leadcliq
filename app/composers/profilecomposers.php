<?php

View::composer('steps.step3',function($view)
{
	$states = State::lists('name','code');
	$view->with('states',$states);

	$countries = Country::lists('name', 'iso2');
	$view->with('countries',$countries);

	return $view;
});
