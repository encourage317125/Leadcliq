<?php

class BankAccount extends Eloquent
{
	protected $table = 'users_banks';

	protected $guarded = array();

	protected $primaryKey = 'id';
}