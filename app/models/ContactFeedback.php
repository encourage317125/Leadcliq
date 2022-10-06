<?php

class ContactFeedback extends Eloquent {
    protected $guarded = array();

    // Feedback Statuses   
    public static $STATUS_OPEN      = 0;
    public static $STATUS_CLOSED    = 1;


    // Feedback Points per Option
    public static $FEEDBACK_EXCELLENT    = 3; 
    public static $FEEDBACK_GOOD         = 2; 
    public static $FEEDBACK_AVERAGE      = 1; 
    public static $FEEDBACK_NOT_GOOD     = -3; 

    
    // Returns the ContactTransaction associated with this feedback
    public function contactTransaction($id) {
    	return ContactTransaction::findOrFail($id);
    }
    
    public function getPointsReadable(){
        switch ($this->points) {
            case ContactFeedback::$FEEDBACK_EXCELLENT:
                return 'Excellent';
            break;

            case ContactFeedback::$FEEDBACK_GOOD:
                return 'Good';
            break;

            case ContactFeedback::$FEEDBACK_AVERAGE:
                return 'Average';
            break;

            case ContactFeedback::$FEEDBACK_NOT_GOOD:
                return 'Not Good';
            break;

            default:
                return 'unkown points (' . $this->points . ')';
            break;
        }
    }
}