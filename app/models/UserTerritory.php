<?php

class UserTerritory extends Eloquent{

    protected $table = 'users_territories';

    //todo: should user be fillable? or can we assign this on creation?
    protected $fillable = array('name', 'areatype', 'geom', 'user_id', 'location_id');

    public $timestamps = false;

    public function users()
    {
        return $this->hasOne('User');
    }
    
    public function city()
    {
        return $this->belongsTo('City');
    }

    public static function GeometryToArray($geometry){

    }

    /**
     * Converts an array of coordinates into a string representing a mysql geometry
     * Example: ((GeomFromText('POLYGON((1 2,3 4,5 6,7 8))'))
     * @param $array - Array of coordinates Ex: [[x,y],[x,y],[x,y]] or [[x:x,y:y],[x:x,y:y],[x:x,y:y]]
     * @return string
     */
    public static function ArrayToGeometry($array){
        $stringConversion = [];
        foreach ($array as $coordinates){
            $stringConversion[] = implode(" ",$coordinates);//make [x,y] into 'x y'
        }
        $stringConversion = implode (",",$stringConversion);//makes into 'x y,x y,x y...'
        $geometry = "((GeomFromText('POLYGON((" .$stringConversion. "))'))";
        return $geometry;

    }
    
   
}