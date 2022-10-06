<?php

class Contact extends Eloquent {
    protected $guarded = array();
    
    public static $SHOW_CALL_LIST = 0;
    public static $REMOVE_CALL_LIST = 1;

    public static $rules = array(
		'user_id' => 'required',
    	'first_name' => 'required',
    	'last_name' => 'required',
    	'company' => 'required',
    	'title' => 'required',
    	'email' => array('required', 'email', 'digits4top', 'alloweddomains'),
    	'direct' => 'required'
	);
    
    public function feedback() {
        return $this->hasOne('ContactFeedback', 'contact_id');
    }

    public function owner() {
    	return $this->belongsTo('User', 'user_id');
    }

    /** Alias for easy access (returns same as owner) */
    public function seller() {
        return $this->belongsTo('User', 'user_id');
    }
    
    public function transactions() {
    	return $this->hasMany('ContactTransaction')->orderBy('id', 'DESC');
    }
    
    public function disputes() {
        return $this->hasMany('ContactDispute')->orderBy('id', 'DESC'); 
    }

    public function getRawStatus(){
    	$operation = $this->transactions()->first();       
        return $operation['operation'];    	
    }
    
    public function introAvailable(){
    	 if($this->intro_available){
    	 	return 'yes';
    	 }else{
    	 	return 'no';
    	 }
    }
    
    public function getOpportunity(){
    	if($this->opportunity){
    		return 'yes';
    	}else{
    		return 'no';
    	}
    }
    
    public function getStatus(){
    	$operation = $this->transactions()->first();               
    	
    	switch ($operation['operation']) {
    		case ContactTransaction::$CONTACT_FOR_SELL:
    			return 'for sale';
    		break;
    			
    		case ContactTransaction::$CONTACT_SOLD:
    			return 'sold';
    		break;
    		
    		case ContactTransaction::$CONTACT_PUBLIC:
    			return 'public';
    		break;

            case ContactTransaction::$CONTACT_PRIVATE:
                return 'private';
            break;
    		
            case ContactTransaction::$CONTACT_DISPUTED:
                return 'disputed';
            break;

    		default:
    			return 'unkown state';
    		break;
    	}
    }

    /**
     * Marks all transactions as sold
     * todo: this needs to be designed better
     * @param $buyer_id
     */
    public function markSold($buyer_id){
        $transactions = $this->transactions;
        foreach ($transactions as $transaction){
            $transaction->operation = ContactTransaction::$CONTACT_SOLD;
            $transaction->to = $buyer_id;
            $transaction->save();
        }
    }
    
}