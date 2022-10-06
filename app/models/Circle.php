<?php

class Circle extends Eloquent {

    protected $guarded = array();

    /**
     * One circle in the database will be for "open market"
     * (meaning everyone is automatically added to it)
     *
     * @var string - The name of the circle
     */
    public static $OPENMARKET = 'Open Market';

    public static $rules = array(
		'name' => 'required'
	);

    public function users() {
    	return $this->belongsToMany('User')->withTimestamps();
    }

    public function randomUsers($limit = 10)
    {
        return $this->users()->orderBy(DB::raw('RAND()'))->limit($limit)->get();
    }
    
    public function contactsTransactionsFoSell(){
    	return $this->hasMany('ContactTransaction', 'circle_id')->where('operation', '=', ContactTransaction::$CONTACT_FOR_SELL)->orderBy('id', 'DESC');
    }
    
    public function appointmentsTransactionsFoSell(){
    	return $this->hasMany('AppointmentTransaction', 'circle_id')->where('operation', '=', AppointmentTransaction::$APPOINTMENT_FOR_SELL)->orderBy('appointment_transactions.id', 'DESC');
    }
    
    public function contactsForSell(){
    	$result = array();
    	 
    	foreach ($this->contactsTransactionsFoSell as $t) {
    		$contact = $t->contact($t->contact_id);
    
    		if($contact->getRawStatus($this->id) == ContactTransaction::$CONTACT_FOR_SELL){
    			$result[$contact->id] = $contact;
    		}
    	}
    	 
    	return $result;
    }
    
    public function leader(){
        $cleader = null;
        $points = 0;
        foreach ($this->users as $user) {
            $userPoints = $user->points($this->id);
            if($userPoints > $points){
                $points = $userPoints;
                $cleader = $user;
                $cleader->pointsInCircle = $points;                
            }
        }
        return $cleader;
    }

    /**
     * 
     * Returns an array of Appoinment that are for-bidding in this 
     * particular circle.
     * Looks into the transactions o 
     * 
     * @return array: Appointment
     */
    public function appointmentsForBidding(){
    	$result = array();
    	
    	foreach ($this->appointmentsTransactionsFoSell as $t) {
    		$appt = $t->appointment($t->appointment_id);
    		
    		if($appt->getRawStatus() == AppointmentTransaction::$APPOINTMENT_FOR_SELL){
	  			$result[$appt->id] = $appt;
    		}
    	}
    	
    	return $result;
    }

    /**
     * Returns the public circle
     */
    public static function getPublic(){

    }

    /**
     * Adds a user to a circle (fires Circle
     * @fires circle.joined
     * @param $user_id
     */
    public function addUser($user_id){
        $this->users()->attach($user_id);
        $this->save();

        Event::fire('circle.joined',array($this->id,$user_id));
    }

    public function contacts(){
        return $this->belongsToMany('Contact', 'contact_transactions');
    }

    /************************************************
     * Scopes - return chainable queries
     ************************************************/

    /**
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOpenMarket($query){
        return $query->where('name',static::$OPENMARKET);
    }

    /**
     * @param $range
     */
    public static function withRecentUsers(){
        $circles = Circle::with(array('users' => function($query)
        {
            $two_days_ago = time() -  (24*60*60*Config::get('alert.look_back_days'));
            $query->where('circle_user.created_at', '>=',date('Y-m-d H:i:s',$two_days_ago))->get();

        }))->get();

        return $circles;
    }
    
}