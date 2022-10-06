<?php

class CreditCardOld extends Eloquent
{
	protected $table = 'users_cards';

	protected $primaryKey = 'uri';

	public $incrementing = false;

	protected $guarded = array();

	public function getLastFourAttribute($value)
	{
		return 'XXXX-XXXX-XXXX-'.$value;
	}
}