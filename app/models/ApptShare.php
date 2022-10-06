<?php

class ApptShare extends Eloquent
{
	protected $table = 'apptshares';
	protected $softDelete = TRUE;
	protected $guarded = array();
	public $rules = array(
		'title' => 'required',
		'appt_datetime' => 'required|date',
		'bid_datetime' => 'required|date',
		'address' => 'required',
		'zip' => 'required',
		'manager_name' => 'required',
		'manager_title' => 'required',
		'company_size' => 'required',
		'industry' => 'required',
		'project_size' => 'required',
		'meeting_description' => 'required',
	);

	protected $appends = array('is_owner','is_bidder','ends_in');



	public function instance()
	{
		return $this;
	}

	public function getIsOwnerAttribute()
	{
		return (Sentry::getUser()->id == $this->user_id?:FALSE);
	}

	public function isApproved()
	{
		if($this->isOwner || ($this->isBidder && $this->myBids()->status == 'accepted')) 
			return TRUE;
		return FALSE;
	}

	public function getIsBidderAttribute()
	{
		return in_array(Sentry::getUser()->id, array_fetch($this->bids->toArray(),'bidder_id'));
	}

	public function myBids()
	{
		return $this->bids()->where('bidder_id',Sentry::getUser()->id)->first();
	}

	public function getPendingBidsAttribute()
	{
		return $this->bids()->pending()->count();
	}

	public function getPendingPaymentAttribute()
	{
		$bid = $this->bids()->where('bidder_id',Sentry::getUser()->id)->first();		
		return ($bid && $bid->status=='accepted' && $this->sell_for == 'money')?TRUE:FALSE;
	}

	public function getEndsInAttribute()
	{
		return $this->bid_datetime->diffForHumans();
	}

	public function getDates()
	{
	    return array('created_at','updated_at','bid_datetime', 'appt_datetime');
	}

	public function setApptDatetimeAttribute($value)
	{
		$this->attributes['appt_datetime'] = date('Y-m-d h:i:s',strtotime($value));
	}

	public function setBidDatetimeAttribute($value)
	{
		$this->attributes['bid_datetime'] = date('Y-m-d h:i:s',strtotime($value));
	}

	public function checkpoints()
	{
		return $this->hasMany('ApptShareCheckpoint','apptshare_id');
	}

	public function bids()
	{
		return $this->hasMany('ApptShareBid','apptshare_id');
	}

	public function owner()
	{
		return $this->belongsTo('User','user_id');
	}

	public function city()
	{
		return $this->belongsTo('City','zip');
	}

	public function circle()
	{
		return $this->belongsTo('Circle');
	}

	public function scopeOwnedBy($query,$id)
	{
		$query->where('apptshares.user_id',$id);
		return $query;
	}

    //todo: check this
    public function markSold()
    {
        $this->status = 'paid';
        //todo: add who bought
    }
}