<?php

class ApptShareForm
{
	public function compose($view)
	{
		$view->with('company_sizes',Config::get('apptshares.company_sizes'));

		return $view;
	}
}