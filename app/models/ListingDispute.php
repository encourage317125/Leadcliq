<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sabrinagelbart
 * Date: 5/7/14
 * Time: 11:06 AM
 * To change this template use File | Settings | File Templates.
 */

class ListingDispute extends Eloquent {
    protected $guarded = array();

    // Disputes Reasons
    public static $REASON_CONTACT_NOT_EXISTS           = 0;
    public static $REASON_CONTACT_NOT_IN_MY_BUSINESS   = 1;
    public static $REASON_OTHER                        = 100;


    // Disputes Resolutions
    public static $RESOLUTION_PENDING   = 0;
    public static $RESOLUTION_ACCEPTED  = 1;
    public static $RESOLUTION_DECLINED  = 2;


    // Returns the Contact associated with this dispute
    public function listing($id) {
        return Listing::findOrFail($id);
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

}