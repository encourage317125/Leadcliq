<?php


/**
 * Registers Events listeners.
 */

/**
 * POINTS EVENTS
 */

//Add p
Event::listen('eloquent.created: User', function($user){
    PointsController::addPoints($user->id,0,1); //points just for joining
    PointsController::addPointsForReferredMemberJoining($user); //add points for use who referred
});
//Add points when 20 contacts uploaded
Event::listen('eloquent.created: Contact', function($contact){
    PointsController::addPointsForUploadingContact($contact);
});
//Add points for referring user
Event::listen('eloquent.created: Referal', function($referal){
    PointsController::addPointsForReferringMember($referal);
});
//Add points for joining circle
Event::listen('circle.joined', function($circle_id,$user_id){
    PointsController::addPoints($user_id,$circle_id,5);
});