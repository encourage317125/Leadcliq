<?php

class Report extends Eloquent 
{
	protected $guarded = array();


    public static $STATUS_OPEN      = 0;
    public static $STATUS_CLOSED    = 1;


    public static $RESOLUTION_PENDING   = 0;
    public static $RESOLUTION_ACCEPTED  = 1;
    public static $RESOLUTION_DECLINED  = 2;	
}