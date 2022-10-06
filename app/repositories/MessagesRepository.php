<?php

interface MessagesRepository
{		
	public function getUsersInboxMessages();
	public function getUsersUnreadMessages();
	public function getUsersSentMessages();
	public function getUsersDraftMessages();
	public function getUsersTrashMessages();
	public function getUsersCircles();
	public function getUsersContacts();
	public function getMessage($id);
	public function processMessage($id);
	public function deleteMessage($id);
	public function destroyMessage($id);	
}