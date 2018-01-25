/**
 * This function build and place markers over the map.
 * Markers refer to formulas given as parameter.
 * 
 * @param {formules}: an array contaning the formulas
 *
 */
 function generateMap(formules) {
	var bnds = new google.maps.LatLngBounds();// usefull to center the map among the marker set
	var infowindow = new google.maps.InfoWindow();
	var markers = new Array();
	var map = new google.maps.Map(document.getElementById('map'), {});
	var image_path = '/speleo/modules/mod_mapping/images/';
	var icons = {
		'1' : {icon : image_path + 'speleoIcon1.png'},
		'2' : {icon : image_path + 'speleoIcon2.png'},
		'3' : {icon : image_path + 'speleoIcon3.png'}
	};

	// main loop creating and placing the markers
	formules.forEach(function(formule) {
		placeMarker(formule.name,
    		Number(formule.lat),
    		Number(formule.lng),
    		formule.short_description,
    		Number(formule.difficulty)
    	);
	});

	// marker clusterization
	var markerCluster = new MarkerClusterer(map, markers,
		{imagePath: image_path + 'm'}
	);

	// adjust the map to the marker set
	map.setCenter(bnds.getCenter());
    map.fitBounds(bnds);

	function placeMarker(name, lat, lng, short_description, difficulty){
		var marker = new google.maps.Marker({
          	title: name, 
          	position: {lat: lat, lng: lng},
          	map: map,
          	icon: icons[difficulty].icon,
        });
        markers.push(marker);
        bnds.extend(marker.position);// extends the map bounds
        google.maps.event.addListener(marker, 'click', function(){
	        infowindow.close();
	        infowindow.setContent(infoWindowContent(name, short_description));
	        infowindow.open(map, marker);
	    });
	}
}

function infoWindowContent(title, description){
	return '<div id="content">'+
				'<div id="siteNotice"></div>'+
				'<h1 id="firstHeading" class="firstHeading">' + title + '</h1>'+
				'<div id="bodyContent">'+
					'<p>' + description + '</p>'+
				'</div>'+
			'</div>';
}
