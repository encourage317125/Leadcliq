<?php

class PointsController extends BaseController{

    /**
     * Add points for a User within a spcific Circle
     * @param $user_id
     * @param $circle_id
     * @param $points
     */
    public static function addPoints($user_id, $circle_id, $points){

        $pointObj = Point::where('user_id', '=', $user_id)->where('circle_id', '=', $circle_id)->first();

        if (!$pointObj){
            Point::create(array(
                'user_id' => $user_id,
                'circle_id' => $circle_id,
                'sum' => $points
            ));
        }

        else{
            $pointObj->update(array(
                'sum' => ($pointObj->sum + $points)
            ));
        }
	}

    /**
     * Subtract points for a User within a spcific Circle
     * @param $user_id
     * @param $circle_id
     * @param $points
     * @return bool
     */
    public static function subtractPoints($user_id, $circle_id, $points){
        //Get the users current points
        $currentPoints = User::find($user_id)->points()->where('circle_id','=',$circle_id)->first();

        //return false if user doesn't have enough points
        if (!$currentPoints || $currentPoints->sum<$points){
            return false;
        }
        //Add a new entry, with the updated points
        $currentPoints->update(array(
            'sum' => ($currentPoints->sum - $points)
        ));

        return true;
    }


    /**
     * Add points for first 20 contacts uploaded in each circle
     * @param $contact Contact
     */
    public static function addPointsForUploadingContact($contact){
        //todo: This should actually be triggered when a contact is added to a circle
        //todo: we need to create a public circle for all contacts
        //loop through circles
        $owner = $contact->owner;
        $circles = $owner->circles;
        foreach ($circles as $circle){
            $contactsCount = $circle->contacts->count();

            //Points awarded when user upload 20,40,60 & 80 contacts  to circle
            if ($contactsCount%20 === 0 && $contactsCount<=80){
                self::addPoints($contact->owner->id,$circle->id,10);
            }
        }
    }

    /**
     * Add points when user submits a referral
     * @param $referral Referral
     */
    public static function addPointsForReferringMember($referral){
//        $totalReferrals = $referral->user->referals->count;
//        if ($totalReferrals===1){
//            //todo: when we create a public circle we should change this from 0
            self::addPoints($referral->user->id,0,1);
//        }
    }

    /**
     * Add points for members who refered a user when that user joins
     * @param $user User
     */
    public static function addPointsForReferredMemberJoining($user){
        foreach ($user->referringMembers as $referrer){
            self::addPoints($referrer->user,0,1);
        }
    }

}