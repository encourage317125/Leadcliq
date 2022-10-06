<?php

class NotificationsComposer
{
	public function compose($view)
	{
		$notifications = App::make('NotificationsRepository')->getUserNotices();
		return $view->with('notifications',$notifications);
	}
}