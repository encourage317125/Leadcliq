<?php

class Referal extends Eloquent {
	protected $guarded = array();

	public static $NOT_SIGNED_YET = 1;
	public static $SIGNED = 2;

	public function getStatus(){
		switch ($this->status) {
			case Referal::$NOT_SIGNED_YET:
				return '<div class="text-warning">Not signed yet</div>';
				break;
				
			case Referal::$SIGNED:
				return '<div class="text-success">Signed in</div>';
				break;

			default:
				return 'Unknown status ('.$this->status.')';
				break;
		}
	}

    public function user(){
        return $this->belongsTo('User');
    }
}