//var map = null;
//var tiles = null;
//var countries = 0;
//
//function initGisMap(){
//
//    var tiles = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
//        attribution: '© OpenStreetMap contributors'
//    });
//
//    //on submit
//    //save geolocation
//    //add field to
//
//    $('#locationText').submit(function(e){
//        e.preventDefault();
//    });
//
//
//    function saveGeometry(){
//
//    }
//
//    function mapGeometry(data){
//        L.geoJson(data).addTo(map);
//    }
//
//
//    $("#dropdown1").change(function () {
//
//        var country = this.value;
//
//        $.getJSON("php/dbcall.php?country=" + country, function (data) {
//
//            var countries = new L.geoJson(data, {
//                style: function (feature) {
//                    return {
//                        color: '#9a9afc',
//                        weight: 2,
//                        opacity: 1
//                    };
//                },
//                onEachFeature: function (feature, layer) {
//
//                    var areaType = 'country';
//                    document.getElementById('areapolygon4').innerHTML = areaType
//
//                    var geojson = layer.toGeoJSON();
//                    var currentArea = Terraformer.WKT.convert(geojson.geometry);
//
//
//                    document.getElementById('areapolygon').innerHTML = currentArea
//
//
//                    var areaName = layer.feature.properties.name;
//                    document.getElementById('areapolygon2').innerHTML = areaName
//
//                    var content = '<input type="submit" value="Save territory" id="submitName" onclick="storeArea();"> ';
//                    layer.bindPopup(content);
//
//                }
//
//            });
//
//            countries.addTo(map);
//            map.fitBounds(countries.getBounds());
//
//            map.on('', function() {
//                map.removeLayer(countries);
//            });
//
//        });
//
//
//    });
//
//    $("#dropdown2").change(function () {
//        var state = this.value;
//        var states = new L.geoJson(null, {
//            style: function (feature) {
//                return {
//                    color: '#9a9afc',
//                    weight: 2,
//                    opacity: 1
//                };
//            },
//            onEachFeature: function (feature, layer) {
//
//                var areaType = 'US state';
//                document.getElementById('areapolygon4').innerHTML = areaType
//
//                var geojson = layer.toGeoJSON();
//                var currentArea = Terraformer.WKT.convert(geojson.geometry);
//
//
//                document.getElementById('areapolygon').innerHTML = currentArea
//
//
//                var areaName = layer.feature.properties.state_name;
//                document.getElementById('areapolygon2').innerHTML = areaName
//
//                var content = '<input type="submit" value="Save territory" id="submitName" onclick="storeArea();"> ';
//                layer.bindPopup(content);
//
//            }
//
//        });
//
//
//        $.getJSON("php/dbcall2.php?state=" + state, function (data) {
//
//            states.addData(data);
//            map.addLayer(states);
//            map.fitBounds(states.getBounds());
//
//            map.on('', function() {
//                map.removeLayer(states);
//            });
//
//        });
//
//
//    });
//
//    map = new L.Map('map', {
//        layers: [tiles],
//        center: [37.770, -122.41],
//        zoom: 1
//    });
//
////    var geoLocation = new L.Control.GeoSearch({
////        provider: new L.GeoSearch.Provider.OpenStreetMap({'polygon':1,'addressdetails':1}),
////        position: 'topcenter',
////        showMarker: true,
////    }).addTo(map);
//
//    var drawnItems = new L.FeatureGroup();
//    map.addLayer(drawnItems);
//
//    var drawControl = new L.Control.Draw({
//        draw: {
//            position: 'topleft',
//            polygon: {
//                title: 'Draw a territory',
//                allowIntersection: false,
//                drawError: {
//                    color: 'red',
//                    timeout: 1000
//                },
//                shapeOptions: {
//                    color: '#bada55'
//                },
//                showArea: true
//            },
//            marker: false,
//            polyline: false,
//            circle: false
//        },
//        edit: {
//            featureGroup: drawnItems
//        }
//    });
//
//    map.addControl(drawControl);
//
//
//    map.on('draw:created', function (e) {
//        var type = e.layerType,
//            layer = e.layer;
//
//        if (type === 'polygon') {
//
//            var areaType = 'custom';
//            document.getElementById('areapolygon4').innerHTML = areaType
//
//
//            document.getElementById('areapolygon3').innerHTML = layer
//
//
//            var currentArea = toWKT(layer);
//
//            document.getElementById('areapolygon').innerHTML = currentArea
//
//            console.log(currentArea);
//
//            layer.bindPopup('Name: <input type="text" name="tname" id="submitName"/><input type="submit" value="Save Territory" onclick="storeDrawnArea();"> ');
//        }
//
//        drawnItems.addLayer(layer);
//    });
//}
//
//function toWKT(layer) {
//    var lng, lat, coords = [];
//    if (layer instanceof L.Polygon || layer instanceof L.Polyline) {
//        var latlngs = layer.getLatLngs();
//        for (var i = 0; i < latlngs.length; i++) {
//            latlngs[i]
//            coords.push(latlngs[i].lng + " " + latlngs[i].lat);
//            if (i === 0) {
//                lng = latlngs[i].lng;
//                lat = latlngs[i].lat;
//            }
//        };
//        if (layer instanceof L.Polygon) {
//            return "POLYGON((" + coords.join(",") + "," + lng + " " + lat + "))";
//        } else if (layer instanceof L.Polyline) {
//            return "LINESTRING(" + coords.join(",") + ")";
//        }
//    } else if (layer instanceof L.Marker) {
//        return "POINT(" + layer.getLatLng().lng + " " + layer.getLatLng().lat + ")";
//    }
//}
//
//function storeArea() {
//    var shapeDiv = document.getElementById('areapolygon').innerHTML;
//    var areaName = document.getElementById('areapolygon2').innerHTML;
//    var areaType = document.getElementById('areapolygon4').innerHTML;
//    var uid = document.getElementById('uid').innerHTML;
//
//    $.getJSON("php/dbcall4.php?shapeDiv=" + shapeDiv + "&areaName=" + areaName + "&areaType=" + areaType + "&uid=" + uid, function (data) {
//        alert('Area is stored!');
//    });
//}
//
//function storeDrawnArea(layer) {
//
//    var areaName = document.getElementById('submitName').value;
//    var shapeDiv = document.getElementById('areapolygon').innerHTML;
//    var areaType = document.getElementById('areapolygon4').innerHTML;
//    var uid = document.getElementById('uid').innerHTML;
//
//    $.getJSON("php/dbcall4.php?shapeDiv=" + shapeDiv + "&areaName=" + areaName + "&areaType=" + areaType + "&uid=" + uid, function (data) {
//        alert('Area is stored!');
//        var layer = document.getElementById('areapolygon3').innerHTML;
//        layer.closePopup();
//    });
//}
//
//function searchCounty() {
//
//    var countyVar = document.getElementById('text').value;
//
//    var result = countyVar.split(",");
//
//    var counties = new L.geoJson(null, {
//        style: function (feature) {
//            return {
//                color: '#9a9afc',
//                weight: 2,
//                opacity: 1
//            };
//        },
//        onEachFeature: function (feature, layer) {
//            var areaType = 'US county';
//            document.getElementById('areapolygon4').innerHTML = areaType
//
//            var geojson = layer.toGeoJSON();
//            var currentArea = Terraformer.WKT.convert(geojson.geometry);
//
//
//            document.getElementById('areapolygon').innerHTML = currentArea
//
//
//            var areaName = layer.feature.properties.name;
//            document.getElementById('areapolygon2').innerHTML = areaName
//
//            var content = '<input type="submit" value="Save territory" id="submitName" onclick="storeArea();"> ';
//            layer.bindPopup(content);
//
//        }
//    });
//
//    var county = '';
//    var state = '';
//
//    if (result.length == 2) {
//        county = result[0];
//        state = result[1].replace(" ","");
//    } else {
//        county = countyVar;
//    }
//
//    $.getJSON("php/dbcall3.php?county=" + county + "&state=" + state, function (data) {
//        counties.addData(data);
//        map.addLayer(counties);
//        map.fitBounds(counties.getBounds());
//        map.on('', function() {
//            map.removeLayer(counties);
//        });
//    });
//}
//
//function searchZipcode() {
//
//    var zipcode = document.getElementById('textzip').value;
//
//    var zipcodes = new L.geoJson(null, {
//        style: function (feature) {
//            return {
//                color: '#9a9afc',
//                weight: 2,
//                opacity: 1
//            };
//        },
//        onEachFeature: function (feature, layer) {
//
//            var areaType = 'US zipcode';
//            document.getElementById('areapolygon4').innerHTML = areaType
//
//            var geojson = layer.toGeoJSON();
//            var currentArea = Terraformer.WKT.convert(geojson.geometry);
//
//
//            document.getElementById('areapolygon').innerHTML = currentArea
//
//
//            var areaName = layer.feature.properties.po_name;
//            document.getElementById('areapolygon2').innerHTML = areaName
//
//            var content = '<input type="submit" value="Save territory" id="submitName" onclick="storeArea();"> ';
//            layer.bindPopup(content);
//
//        }
//    });
//
//
//
//    $.getJSON("php/dbcall5.php?zipcode=" + zipcode, function (data) {
//        zipcodes.addData(data);
//        map.addLayer(zipcodes);
//        map.fitBounds(zipcodes.getBounds());
//        map.on('', function() {
//            map.removeLayer(zipcodes);
//        });
//    });
//}
//
//function searchCities() {
//
//    var cityName = document.getElementById('textcity').value;
//
//    var cities = new L.geoJson(null, {
//        style: function (feature) {
//            return {
//                color: '#9a9afc',
//                weight: 2,
//                opacity: 1
//            };
//        },
//        onEachFeature: function (feature, layer) {
//
//            var areaType = 'US city';
//            document.getElementById('areapolygon4').innerHTML = areaType
//
//            var geojson = layer.toGeoJSON();
//            var currentArea = Terraformer.WKT.convert(geojson.geometry);
//
//
//            document.getElementById('areapolygon').innerHTML = currentArea
//
//
//            var areaName = layer.feature.properties.namelsad10;
//            document.getElementById('areapolygon2').innerHTML = areaName
//
//            var content = '<input type="submit" value="Save territory" id="submitName" onclick="storeArea();"> ';
//            layer.bindPopup(content);
//
//        }
//    });
//
//
//
//    $.getJSON("php/dbcall8.php?cityName=" + cityName, function (data) {
//        cities.addData(data);
//        map.addLayer(cities);
//        map.fitBounds(cities.getBounds());
//        map.on('', function() {
//            map.removeLayer(cities);
//        });
//    });
//}
