<?php

interface NotificationsRepository
{
	public function send($notice);
	
	public function getUserNotices($user_id);
	
}