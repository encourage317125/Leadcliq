<?php

class EloquentReferralRepository implements ReferralRepository
{
	protected $model;
	public function __construct(Referal $model)
	{
		$this->model = $model;
	}

	public function referalActivated($email)
	{
		$referal = $this->model->where('to', '=', $email)->first();
		if($referal != null)
		{
			Session::flash('success', 'Welcome to leadcliq. You have been refered by ' . $referal->from);
		}
		else
		{
			Session::flash('success', 'Welcome to leadcliq');
		}
	}
}