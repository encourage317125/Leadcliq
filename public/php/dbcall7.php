<?php
/**
 * Title:   MySQL to GeoJSON (Requires https://github.com/phayes/geoPHP)
 * Notes:   Query a MySQL table or view and return the results in GeoJSON format, suitable for use in OpenLayers, Leaflet, etc.
 * Author:  Bryan R. McBride, GISP
 * Contact: bryanmcbride.com
 * GitHub:  https://github.com/bmcbride/PHP-Database-GeoJSON
 */

# Include required geoPHP library and define wkb_to_json function
include_once( __DIR__ . '/phayes/geophp/geoPHP.inc');

function wkb_to_json($wkb) {
    $geom = geoPHP::load($wkb,'wkb');
    return $geom->out('json');
}

$areaID = $_GET['areaID'];

# Connect to MySQL database
$conn = new PDO('mysql:host=us-cdbr-east-04.cleardb.com;dbname=heroku_ac91f93835b5206','b9f4160f988271','b35def12');

# Build SQL SELECT statement and return the geometry as a WKB element
	$sql = "DELETE FROM gis_territories WHERE areaid='" .$areaID. "'" ;
	
$conn->query($sql);

$conn = NULL;
?>