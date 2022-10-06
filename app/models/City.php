<?php

class City extends Eloquent
{
    //protected $primaryKey = 'zip';
    protected $primaryKey = 'id';
    public function state()
    {
        return $this->belongsTo('State','state_code');
    }

    public function users()
    {
        return $this->hasMany('User');
    }

    public function userTerritories()
    {
        return $this->hasMany('UserTerritory');

    }
    
     public function listings()
    {
        return $this->hasMany('Listing');
    }


    /**
     * Searches the cities table (which actually should be named zip table)
     * Complex function
     * //todo: cities table should be separated out into zip table, cities table, counties table, and states tables
     * (currently they're all one table so you have to make sure only one result is returned if refers to same)
     *
     * @param $location
     * @return array
     */
    public static function findByLocation($location)
    {
        $locations=array();

        // search by city

        $results = City::where('name', 'like', '%'.$location.'%')->distinct('name')->get(array('name','state','county'));
        $cities=array();

        foreach ($results as $ele){

            $cityForId= City::where('name', '=', $ele->name)->take(1)->first();

            $cities[]=array("id" => $cityForId->id, "name" => $cityForId->name.", ".$cityForId->state, 'areatype'=>'city' ); // get first id
        }


        $results = City::where('county', 'like', '%'.$location.'%')->distinct('county')->get(array('county','state'));
        $counties=array();

        foreach ($results as $ele){

            $countyForId= City::where('county', '=', $ele->county )->take(1)->first();

            $counties[]=array("id" => $countyForId->id, "name" => $countyForId->county.", ".$countyForId->state, 'areatype'=>'county' ); // get first id
        }

        // search by zip
        $results = City::where('zip', 'like', '%'.$location.'%')->distinct()->get(array('zip'));
        $zips=array();

        foreach ($results as $ele){

            $zipForId= City::where('zip', '=', $ele->zip )->take(1)->first();

            $zips[]=array("id" => $zipForId->id, "name" => $ele->zip.", ".$zipForId->name.", ".$zipForId->state, 'areatype'=>'zip' ); // get first id
        }

        // search by state
        $results = City::where('state', 'like', '%'.$location.'%')->distinct()->get(array('state'));
        $states=array();

        foreach ($results as $ele){

            $stateForId= City::where('state', '=', $ele->state)->take(1)->first();

            $states[]=array("id" => $stateForId->id, "name" => $ele->state.", USA", 'areatype'=>'state' ); // get first id
        }

        $locations=array_merge($locations,$states);
        $locations=array_merge($locations,$counties);
        $locations=array_merge($locations,$cities);
        $locations=array_merge($locations,$zips);


        return $locations;

    }
}