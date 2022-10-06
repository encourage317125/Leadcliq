<?php

class GeoDataController extends BaseController
{
	private function wkb_to_json($wkb)
	{
		if(is_null($wkb))
			return NULL;
		$geom = geoPHP::load($wkb,'wkb');
    	return $geom->out('json');
	}

	function getCountry($iso2)
	{
		$countries = DB::select("SELECT *, AsWKB(SHAPE) AS wkb FROM countries where iso2='" .$iso2. "'" );
		$geojson = array(
		   'type'      => 'FeatureCollection',
		   'features'  => array()
		);
		
		foreach ($countries as $country) 
		{
		    $feature ['type'] = 'Feature';
		    $feature ['geometry'] = $this->wkb_to_json($country->wkb);
		    unset($country->wkb);
		    unset($country->SHAPE);
		    $feature ['properties'] = $country;
		    array_push($geojson['features'], $feature);
		}
		return Response::json($geojson);
	}
}