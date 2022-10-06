<?php

class User extends Cartalyst\Sentry\Users\Eloquent\User {
	protected $guarded = array();

	// Directory Status
	public static $VISIBLE_FOR_ALL = 0; //default
	public static $VISIBLE_ONLY_MY_CIRCLES = 1;
	public static $VISIBLE_ONLY_HIM = 2;

	public static $rules = array(
		'first_name' => 'required|min:2',
		'last_name' => 'required|min:2',
		'email' => 'required|email',
		'password' => 'required|min:8'
	);

	public static $messages = array(
		'required' => 'The :attribute is required for a complete profile.',
		);

	protected $appends = array('full_name');

	/**
	 * Transforms the visibility option into a readable string to render
	 *
	 * @return string
	*/
	public function getDirectoryStatus(){
		switch ($this->directory_status) {
			case User::$VISIBLE_ONLY_HIM:
				return 'Not visible';
				break;

			case User::$VISIBLE_ONLY_MY_CIRCLES:
				return 'Only to my circles';
				break;

			case User::$VISIBLE_FOR_ALL:
				return 'Visible for all';
				break;

			default:
				return $this->directory_status;
				break;
		}
	}

	public static $profile_completed = array(
			'first_name' => 'required',
			'last_name' => 'required',
			'email' => 'required',
			'phone' => 'required',
			'company_id' => 'required',
			'industry_id' => 'required',
			'zip' => 'required|numeric',
			'title_id' => 'required',
            'deal_size_tier_id' => 'required'
    );

	public function totalPointsAllCircles() {
		$sum = 0;
		foreach ($this->points as $points) {
			$sum += $points->sum;
		}
		
		return $sum;
	}

	/**
	 * Get the total points per circle
	 * @param unknown $circle_id
	 * @return number
	 */
	public function pointAmountInCircle($circle_id) {
		$results = DB::table('points')->where('user_id', '=', Sentry::getUser()->id)->where('circle_id', '=', $circle_id)->orderBy('id', 'DESC')->take(1)->get();
		$model = (count($results) == 1) ? $results[0] : new Point();
		 
		return ($model->sum != 0) ? $model->sum : 0;
	}

    public function points()
    {
        return $this->hasMany('Point');
    }

	/**
	 * Bids I have made
	 */
	public function bids() {
		return $this->hasMany('AppointmentTransaction', 'from')->where('operation', '=', AppointmentTransaction::$APPOINTMENT_BID)->orderBy('id', 'DESC');
	}

	public function boughtContacts() {
		return $this->hasMany('ContactTransaction', 'to')->where('operation', '=', ContactTransaction::$CONTACT_SOLD);
	}


	/*
		Shows only the lastest 10 bought contacts
	*/
	public function boughtContactsPreview() {
		return $this->hasMany('ContactTransaction', 'to')->where('operation', '=', ContactTransaction::$CONTACT_SOLD)->limit(10);
	}

	/**
	 * Disputes this User has initiated
	 */
	public function disputes() {
		return $this->hasMany('ContactDispute', 'buyer_id');
	}

	/**
	 * Checks if the User bolongs to a certain circle.
	 *
	 * @param $id of the circle to check
	 * @return true or false
	 */
	public function belongsToCircle($id){
		foreach ($this->circles as $circle) {
			if($circle->id == $id){
				return true;
			}
		}
		return false;
	}

	public function getScoreAsSeller(){
		$sum = 0;
		$count = 0;

		foreach ($this->contactFeedbacksAsSeller as $feedback) {
			$sum += $feedback->points;
			$count++;
		}

		// return $sum/$count; average
		
		return $sum;
	}

	public function contactFeedbacksAsSeller(){
		return $this->hasMany('ContactFeedback', 'seller_id');
	}

	public function milestone() {
		return $this->hasOne('Milestone');
	}

	public function circles() {
		return $this->belongsToMany('Circle')->withTimestamps();
	}

	public function contacts() {
		return $this->hasMany('Contact')->orderBy('first_name', 'ASC');
	}

	public function referals() {
		return $this->hasMany('Referal');
	}

	public function appointments() {
		return $this->hasMany('Appointment')->with(array('city','city.state'))->orderBy('id', 'DESC');
	}

	public function cards()
	{
		return $this->hasMany('CreditCard');
	}

	public function banks()
	{
		return $this->hasMany('BankAccount');
	}

	public function payments()
	{
		return $this->hasMany('Payment')->orderBy('created_at','DESC');
	}

	public function city()
	{
		return $this->belongsTo('City','zip');
	}

    public function inbox()
    {
        return $this->hasMany('Message','to')->whereNull('archived_at')->whereNotNull('sent_at');
    }
    
    public function allMessages()
    {
        return $this->hasMany('Message','to')->whereNotNull('sent_at');
    }

	public function getPhotoAttribute($photo)
	{
		if(is_null($photo))
		{
			return "http://www.gravatar.com/avatar/".md5(strtolower(trim($this->attribute['email'])))."?s=60";
		}
		else
		{
			$photo_url = url('/').'/users/'.$photo;
		}
		return $photo_url;
	}

	public function getFullNameAttribute()
	{
		return $this->first_name.' '.$this->last_name;
	}

    public function userTerritories()
    {
        return $this->hasMany('UserTerritory');
    }


    /**
     * @return array|\Illuminate\Database\Eloquent\Collection|static
     */
    public function referringMembers()
    {
        return $this->hasMany('Referal','to','email');
    }

    public function company()
    {
        return $this->belongsTo('Company');
    }

    public function companiesWorkedWith()
    {
        return $this->belongsToMany('Company','user_worked_with_company');
    }

    public function offersServices()
    {
        return $this->belongsToMany('Service','user_offers_services');
    }

    public function complementaryServices()
    {
        return $this->belongsToMany('Service','services_complement_user');
    }

    public function title()
    {
        return $this->belongsTo('Title');
    }

    public function networksWithTitles()
    {
        return $this->belongsToMany('Title','users_network_with_titles');
    }

    public function seekingTitles()
    {
        return $this->belongsToMany('Title','users_seeking_titles');
    }

    public function dealSizeTier()
    {
        return $this->belongsTo('DealSizeTier');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function industry()
    {
        return $this->belongsTo('Industry');
    }

    /**
     * The industries that the user is seeking leads in
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function targetIndustries()
    {
        return $this->belongsToMany('Industry','users_seeking_industries');
    }

    /**
     * This is used in multiple select fields with the ability to "add new" values
     * Values are passed in the form of a unique key that's a string (not a number)
     * This is useful for things like assigning associated companies while creating them if they don't exist
     *
     * @param $connectionModel Eloquent - An eloquent model
     * @param $connectionName - The name of the relation (e.g., for transaction you may want to assign a User model to the connection named Buyer or Seller)
     * @param $values - The values to find
     * @param $field - The field to search for values against
     */
    public function createIfNecessaryAndSyncConnections($connectionModel,$connectionName,$values,$field){

        //retrieve existing value names and ids
        //todo: test with single quotes
        $valuesString = join("','", $values);
        $query = $field." IN ('".$valuesString."')";
        $existing = $connectionModel::whereRaw($query)->get();
        $existingFieldValues = $existing->lists($field);
        $ids = $existing->lists('id');

        //foreach non existing value create and add to ids array
        foreach ($values as $value){
            if (!in_array($value, $existingFieldValues)){
                $new = $connectionModel::create(array($field=>$value));
                $ids[] = $new->id;
            }
        }

        //re-sync connection (add everything in $ids, remove values not in $id - automatic with sync)
        $this->$connectionName()->sync($ids);
    }
    
    /**
       * Create static findByJoinedDate function which retrieves all users within specific dates
       * 
    */
    
    public static function findByJoinedDate($numberOfDays){
                               
         $users=User::where('created_at', '>=',date('Y-m-d H:i:s',time()-  (24*60*60*$numberOfDays)) )->get();
        
         return $users;
         
    }
}
