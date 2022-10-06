<?php

/**
 * A listing represents a lead in the database.
 * Leads can either be "apptshares", "listings", or "opportunities"
 *
 * Apptshare - Essentally a "ride along", meaning the buyer will go with the seller to a meeting or conference call
 * Opportunity - An individual who is actively seeking a product or service
 * Contact - An individual who is frequently seeking products or services (but may or may not be actively seeking one)
 *
 *
 * FEATURES
 *
 * Bidding:         All transactions take place throuh "offers".
 *                  These can be accepted or rejected.
 *
 * Checkpoints:     TODO: Transactions can have checkpoints
 *                  A typical listing will have only one checkpoint for transaction (purchase)
 *                  Others can have multiple checkpoints for transaction (purchase, meeting, etc.)
 *
 * History:         Records any change in status of the listing.
 *
 * Points or Money: Listings can be for points or money
 *
 *
 */

class Listing extends Eloquent {

    protected $guarded = array('is_published','is_released');


    private static $save_draft_rules = array(
        'listing_type' => 'required'
    );

    /**************************************************
     * Validation Rules
     **************************************************/

    /**
     * Rules for publishing all listings
     * @var array
     */
    public static $publish_listing_rules = array(
        'listing_title' => 'required', //change
        'seller_id' => 'required',
        'listing_title' => 'required',
        'listing_description' => 'required',
//        'company_id'=> 'required',  TODO://add this back on once field added
        'city_id'=> 'required',
        'address'=> 'required',
        'contact_name'=> 'required',
        'title_id'=> 'required',
        'company_size_tier_id'=> 'required',
        'industry_id'=> 'required',
        'deal_size_tier_id' => 'required'
    );

    /**
     * Additional rules for publishing apptshares
     * @var array
     */
    public static $publish_apptshare_rules = array(
        'event_at' => 'required',
    );

    /**
     * Additional rules for publishing contacts
     * @var array
     */
    public static $publish_contact_rules = array(
        'contact_email'=> 'required',
        'contact_phone1'=> 'required'
    );

    /**
     * Additional rules for publishing contacts
     * @var array
     */
    public static $publish_opportunity_rules = array(
        'contact_email'=> 'required',
        'contact_phone1'=> 'required',
        'opportunity_description'=>'required'
    );

    /**
     * Flag additional columns as date columns for formatting
     * @return array|void
     */
    public function getDates (){
        return array('updated_at','created_at','expires_at','event_at');
    }

    /**************************************************
     * Key Functionality
     **************************************************/

    /**
     * Calculates points total (if points)
     * Flags as published
     * Creates a ListingHistory object
     */
    public function publish(){
        if ($this->is_points){
            switch ($this->listing_type){
                case "apptshare" : $this->price = 2; break;
                case "contact" : $this->price = $this->introduction_available ? 2 : 1; break;
                case "opportunity" : $this->price = 3;
            }
        }
        $this->is_published = 1;
        $this->save();
        ListingHistory::create(array('status'=>ListingHistory::$CREATED,'listing_id'=>$this->id));
    }

    /**
     * Make an offer on a listing.
     * This will be accepted automatically if bidding isn't in place
     * If the flag 'variable_price' is in place you can provide an amount
     *
     * @param $user_id - the user making the offer
     * @param null $amount - the amount
     * @throws Exception - if you attempt to provide a
     */
    public function makeOffer($user_id, $amount = null){
        if ($amount!==null && !$this->variable_price){
            Log::warning("Can't provide amount when variable_price isn't true. Amount was $amount");
        }
        $offer = ListingOffer::create(array(
            'user_id'=>$user_id,
            'listing_id'=>$this->id,
            'amount'=>$amount
        ));
        if (!$this->can_bid){
            //todo: currently we're only doing bidding so this won't be called
            $this->acceptOffer($offer->id);
        }
    }

    /**
     * Takes the listing off the market
     * marks the buyer_id as the user who made offer
     * release listing if for points
     * if not for points, releases buyer email to seller
     * so they can confirm then manually release
     *
     * @param $offer_id
     */
    public function acceptOffer($offer_id){

        $this->is_published = 0;

        $offer = ListingOffer::find($offer_id);
        $this->buyer_id = $offer->bidder_id;
        $this->solid_in_cirlce = $offer->circle_id;
        $this->save();

        ListingHistory::create(array('status'=>ListingHistory::$OFFERACCEPTED,'listing_id'=>$this->id));

        //if for points release listing to buyer right away
        if ($this->for_points){
            $this->releaseListing();
        }

        //if not for points then release buyer email to seller
        //seller will manually release listing to buyer so he can confirm transaction
        //todo: we'll probably change this once we implement payments
        else{
            $subject = 'Offer Accepted for '.$this->title;
            $body = "To release the details of the lead you must follow up with the seller by email. Their email is\n\n".$this->seller->email."\n\nThanks,\nThe LeadCliq Team";
            EmailController::sendMail($this->buyer->email, $this->buyer->first_name.' '.$this->buyer->last_name, $subject, $body);
        }

    }

    /**
     * Depending upon the way the lead is being sold, it may need to be manually released
     * This is so that the seller can validate the buyer (that their product is relevant, etc) before sharing listing with them
     */
    public function release(){
        $this->is_released = 1;
        if ($this->for_points){
            PointsController::subtractPoints($this->buyer_id, $this->solid_in_cirlce, $this->amount);
        }
    }

    public function relist(){
        //todo: add to revoked buyers table (hasn't been created yet)
    }

    /************************************************
     * Scopes - return chainable queries
     ************************************************/

    /**
     * Listings that have been purchased and released (the buyer can see the listing data)
     *
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @param $user_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePurchasedReleasedListings($query,$user_id){
        return $query->where('buyer_id',$user_id)->where('is_released',1);
    }

    /**
     * Listings that have been sold & release (the buyer can see the listing data)
     *
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @param $user_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSoldReleasedListings($query,$user_id){
        return $query->where('seller_id',$user_id)->where('is_released',1);
    }

    /**
     * Listings that are essentially "on hold" for the buyer
     * but haven't been released to to buyer (the buyer doesn't have access to all their data)
     *
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @param $user_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePurchasedUnreleasedListings($query,$user_id){
        return $query->where('buyer_id',$user_id)->where('is_released',0);
    }

    /**
     * Listings that are essentially "on hold" for the buyer
     * but haven't been released to to buyer (the buyer doesn't have access to all their data)
     *
     * Use this to alert seller that they need to release to buyer
     *
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @param $user_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSoldUnreleasedListings($query,$user_id){
        return $query->where('seller_id',$user_id)->where('is_released',0);
    }


    /************************************************
     * Relationships
     ************************************************/
    public function circles(){
        return $this->belongsToMany('Circle','listing_circles');
    }

    public function history(){
        return $this->hasMany('ListingHistory');
    }

    public function buyer(){
        return $this->belongsTo('User','buyer_id');
    }

    public function seller(){
        return $this->belongsTo('User','seller_id');
    }

    public function industry(){
        return $this->belongsTo('Industry', 'industry_id');
    }

    public function city(){
        return $this->belongsTo('City','city_id');        
    }
    
    public function company(){
        return $this->belongsTo('Company','company_id');
    }

    public function contactTitle(){
        return $this->belongsTo('Title','title_id');
    }

    public function dealSizeTier(){
        return $this->belongsTo('DealSizeTier');
    }

    public function companySizeTier(){
        return $this->belongsTo('CompanySizeTier');
    }

    public function setExpiresAtAttribute($value){
        $this->attributes['expires_at'] = date('Y-m-d H:i:s',strtotime($value));
    }

    public function setEventAtAttribute($value){
        $this->attributes['event_at'] = date('Y-m-d H:i:s',strtotime($value));
    }

    /**************************************************
     * Other
     **************************************************/

    public static function sellingListings($seller_id){
        return Listing::where('seller_id','=',$seller_id)->get();
    }

}