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

$shapeDiv = $_GET['shapeDiv'];
$areaName = $_GET['areaName'];
$areaType = $_GET['areaType'];
$uid = $_GET['uid'];


# Connect to MySQL database
$conn = new PDO('mysql:host=us-cdbr-east-04.cleardb.com;dbname=heroku_ac91f93835b5206','b9f4160f988271','b35def12');

# Build SQL SELECT statement and return the geometry as a WKB element
$sql = "INSERT INTO gis_territories(geom,name,areatype,uid) VALUES ((GeomFromText('" .$shapeDiv. "')), '" .$areaName. "', '" .$areaType. "', " .$uid. ")";


# Try query or error
$rs = $conn->query($sql);
if (!$rs) {
    echo 'An SQL error occured.\n';
    exit;
}

$conn = NULL;
?>