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

$county = $_GET['county'];
$state = $_GET['state'];

# Connect to MySQL database
$conn = new PDO('mysql:host=us-cdbr-east-04.cleardb.com;dbname=heroku_ac91f93835b5206','b9f4160f988271','b35def12');

# Build SQL SELECT statement and return the geometry as a WKB element
if (empty($state)) {
	$sql = "SELECT *, AsWKB(SHAPE) AS wkb FROM gis_counties where name='" .$county. "'";
} else {
	$sql = "SELECT *, AsWKB(SHAPE) AS wkb FROM gis_counties where name='" .$county. "' and state_name ='" .$state. "'" ;
}


# Try query or error
$rs = $conn->query($sql);
if (!$rs) {
    echo 'An SQL error occured.\n';
    exit;
}

# Build GeoJSON feature collection array
$geojson = array(
   'type'      => 'FeatureCollection',
   'features'  => array()
);

# Loop through rows to build feature arrays
while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
    $properties = $row;
    # Remove wkb and geometry fields from properties
    unset($properties['wkb']);
    unset($properties['SHAPE']);
    $feature = array(
         'type' => 'Feature',
         'geometry' => json_decode(wkb_to_json($row['wkb'])),
         'properties' => $properties
    );
    # Add feature arrays to feature collection array
    array_push($geojson['features'], $feature);
}

header('Content-type: application/json');
echo json_encode($geojson, JSON_NUMERIC_CHECK);
$conn = NULL;
?>