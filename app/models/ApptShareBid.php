<?php

class ApptShareBid extends Eloquent
{
	protected $table = 'apptshares_bids';

	protected $guarded = array();
	
	public function ApptShare()
	{
		return $this->belongsTo('ApptShare','apptshare_id');
	}

	public function bidder()
	{
		return $this->belongsTo('User','bidder_id');
	}

	public function scopePending($query)
	{
		return $query->where('status','pending');
	}
}