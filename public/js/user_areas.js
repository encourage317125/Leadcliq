var map = null;
var tiles = null;
var areas = 0;
	
function initDashboardMap(){

	tiles = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
		attribution: '© OpenStreetMap contributors'
	});
	
	map = new L.Map('mapContainer', {
		layers: [tiles],
		center: [20.98792,-10],
		zoom: 1
	});
	
	showAreas();

}

function showAreas() {	
    var uid = document.getElementById('uid').innerHTML;
	$.getJSON("php/dbcall6.php?uid=" + uid, function (data) {
		
		var areas = new L.geoJson(data, {
			style: function (feature) {
					return {
							color: '#ff6f52',
							weight: 2,
							opacity: 1
					};
			},
			onEachFeature: function (feature, layer) {
			
				var geojson = layer.toGeoJSON();
				var currentGeom = Terraformer.WKT.convert(geojson.geometry);
				document.getElementById('layerAreas').innerHTML = areas
			
				var areaID = layer.feature.properties.areaid;
				document.getElementById('currentArea').innerHTML = areaID
				
				var content = '<input type="submit" value="Remove territory" id="submitName" onclick="deleteArea()"> ';
				layer.bindPopup(content);
            }
        });
					
		areas.addTo(map);
		map.fitBounds(areas.getBounds());
    }); 
}

function deleteArea() {
	
	var areaID = document.getElementById('currentArea').innerHTML;
	var areas = document.getElementById('layerAreas').innerHTML;

	$.getJSON("php/dbcall7.php?areaID=" + areaID, function (data) {
	});
    
    map.remove();
    
    setTimeout(initDashboardMap(),5000)

  
}