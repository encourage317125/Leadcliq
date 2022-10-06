<?php

class ContactDispute extends Eloquent {
    protected $guarded = array();

    // Disputes Statuses   
    public static $STATUS_OPEN      = 0;
    public static $STATUS_CLOSED    = 1;


    // Disputes Reasons
    public static $REASON_CONTACT_NOT_EXISTS           = 0;
    public static $REASON_CONTACT_NOT_IN_MY_BUSINESS   = 1;
    public static $REASON_OTHER                        = 100;

    
    // Disputes Resolutions
    public static $RESOLUTION_PENDING   = 0;
    public static $RESOLUTION_ACCEPTED  = 1;
    public static $RESOLUTION_DECLINED  = 2;


    // Returns the Contact associated with this dispute
    public function contact($id) {
    	return Contact::findOrFail($id);
    }
    
    // Returns the User associated with this dispute
    public function createdBy($id) {
        return User::findOrFail($id);
    }

    public function getReasonReadable(){
        switch ($this->reason) {
            case ContactDispute::$REASON_CONTACT_NOT_EXISTS:
                return 'Contat does not exists';
            break;

            case ContactDispute::$REASON_CONTACT_NOT_IN_MY_BUSINESS:
                return 'Contact not in my line of business';
            break;
            
            case ContactDispute::$REASON_OTHER:
                return 'Other';
            break;

            default:
                return 'unkown reason (' . $this->reason . ')';
            break;
        }
    }

    public function getResolutionReadable(){
        switch ($this->resolution) {
            case ContactDispute::$RESOLUTION_PENDING:
                return 'Pending';
            break;

            case ContactDispute::$RESOLUTION_ACCEPTED:
                return 'Accpeted';
            break;
            
            case ContactDispute::$RESOLUTION_DECLINED:
                return 'Declined';
            break;

            default:
                return 'unkown resolution (' . $this->resolution . ')';
            break;
        }
    }

    public function getStatusReadable(){
        switch ($this->status) {
            case ContactDispute::$STATUS_OPEN:
                return 'Open';
            break;

            case ContactDispute::$STATUS_CLOSED:
                return 'Closed';
            break;
                
            default:
                 return 'unkown status (' . $this->status . ')';
            break;
        }
    }
}