<?php

class MilestonesController extends BaseController{

    //add milestone

	/**
	 * Milestone Repository
	 *
	 * @var Milestone
	 */
	protected $milestone;

	public function __construct(Milestone $milestone)
	{
		$this->milestone = $milestone;
	}

	/**
	* Add points for a User within a spcific Circle
	*/
	public function addPointForContactUpload($user_id, $circle_id){	
        $user = $this->getLoguedUser();
		$milestone = $user->milestone;

		$LIMIT = 20;

		if($milestone->points_for_uploading_contacts <= $LIMIT){
			PointsController::addPoints($user_id, $circle_id, 1);	
			
			$milestone->points_for_uploading_contacts++;
			$milestone->save();

			return true;		
		}else{
			return false;
		}

	}

    //
	

}