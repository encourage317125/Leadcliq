<?php

class Notification extends Eloquent
{	
	public $rules = array('subject'=>'required','message'=>'required','user_id'=>'required|exists:users,id');

	protected $softDeletes = true;

	protected $fillable = array('subject','message','user_id');
	public function user()
	{
		return $this->belongsTo('User');
	}	

	public function getMessageAttribute($value)
	{
		return html_entity_decode($value);
	}
}