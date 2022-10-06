<?php

class NotificationsController extends BaseController
{
	protected $repo;
	public function __construct(NotificationsRepository $repo)
	{
		$this->repo = $repo;
	}

	public function delete($id)
	{
		try
		{
			if($this->repo->delete($id)) return '1';
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
}