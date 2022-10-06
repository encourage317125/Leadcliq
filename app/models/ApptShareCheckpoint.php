<?php

class ApptShareCheckpoint extends Eloquent
{
	protected $table = 'apptshares_checkpoints';

	protected $guarded = array();
	
	public function ApptShare()
	{
		return $this->belongsTo('ApptShare','apptshare_id');
	}
}