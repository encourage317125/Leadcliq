<?php

/**
 * Class ListingHistory
 *
 * Tracks milestones for the listing.
 * We can not have this in the listings table,
 * since a listing can have some of these actions done multiple times.
 * E.g., a listing can expire and then be re-listed, then expire again and be re-listed
 *
 */

class ListingHistory extends Eloquent{

    protected $table = 'listing_history';

    protected $guarded = array();

    /**
     * When an item it's given for free, means no cost is involved for neither of them.
     * After this, the item looses all it's value.
     */
    public static $CREATED = 0;

    /**
     * When an item it's given for free, means no cost is involved for neither of them.
     * After this, the item looses all it's value.
     */
    public static $PUBLISHED = 1;

    /**
     * The an offer for a listing was accepted by the buyer
     * This may or may not mean it's released
     * (the buyer may wish to reach out to the bidder to verify them
     * or wait on an external transaction)
     */
    public static $OFFERACCEPTED = 2;

    /**
     * Sell/Buy operation a contact or an appointment.
     */
    public static $RELEASED = 3;

    /**
     * Sell/Buy operation a contact or an appointment.
     */
    public static $DISPUTED = 4;

    /**
     * Listing re-listed after expiring or being disputed ??
     * TODO: outline this better
     */
    public static $RELISTED = 5;

    /**
     * Expired
     */
    public static $EXPIRED = 6;

    /**
     * Returns a human readable version of the status
     *
     * @return string
     */
    public function getStatus(){

        switch($this->status){
            case self::$CREATED       : return "Listing created";
            case self::$PUBLISHED     : return "Listing published";
            case self::$OFFERACCEPTED : return "Offer accepted for listing";
            case self::$RELEASED      : return "Listing released to buyer";
            case self::$RELISTED      : return "Listing re-listed on marketplace";
            case self::$EXPIRED       : return "Listing expired";
        }

        error_log("Unknown status for listing. Status was: ".$this->status." for listing id ".$this->id);
        return "Listing action taken";
    }
}