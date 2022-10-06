<?php namespace Notifications;

use Eloquent;

abstract class NotifiableModel extends Eloquent
{
	// Will return the message we want to show in our notifications
    abstract public function getMessageAttribute();

    // Will return a link to an route that handles positive reaction to the notification
    abstract public function getAcceptLinkAttribute();

    // Will return a link to an route that handles negative reaction to the notification
    abstract public function getDeclineLinkAttribute();

    // Gives us the ability to reference back to the parent Notification model
    public function notification()
    {
        return $this->morphOne('Notification');
    }
}