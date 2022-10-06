<?php

class State extends Eloquent {
    protected $primaryKey = 'code';

   public function cities()
	{
		$this->hasMany('City');
	} 
}