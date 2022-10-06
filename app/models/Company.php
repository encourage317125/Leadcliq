<?php

class Company extends \Eloquent {
	protected $fillable = ['name'];

	public function users() {
		return $this->belongsToMany('User');
	}
     
     public function listings()
    {
        return $this->hasMany('Listing');
    }
}