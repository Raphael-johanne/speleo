<?php 
// No direct access
defined('_JEXEC') or die;
?>

<?php // adding style
$style = '#map {'
        . 'width: 100%;'
        . 'height: 400px;'
        . 'background-color: grey;'
      	. '}';
$document->addStyleDeclaration($style);
?>

<div id="map"></div>
<script>
	function initMap(){
		
		var bnds = new google.maps.LatLngBounds();// usefull to center the map among the marker set
		var iconImage = {url: 'http://speleo.local/speleo/modules/mod_mapping/images/speleoIcon.png'};
		var infowindow = new google.maps.InfoWindow();
		var markers = new Array();

		var map = new google.maps.Map(document.getElementById('map'), {
      		//zoom: 10,
      		//center: mapCenter,
    	});

	    <?php foreach( $formules as $formule ): ?>
	    	placeMarker('<?php echo $formule->name?>',
	    		Number(<?php echo $formule->lat?>),
	    		Number(<?php echo $formule->lng?>),
	    		'<?php echo $formule->short_description?>'
	    		);
    	<?php endforeach; ?>


		var markerCluster = new MarkerClusterer(map, markers,
			{imagePath: 'http://speleo.local/speleo/modules/mod_mapping/images/m'}
		);

		map.setCenter(bnds.getCenter());
        map.fitBounds(bnds);

    	function placeMarker(name, lat, lng, short_description){
			var marker = new google.maps.Marker({
	          	title: name, 
	          	position: {lat: lat, lng: lng},
	          	map: map,
	          	icon: iconImage,
	        });
	        markers.push(marker);
	        bnds.extend(marker.position); // extends the map bounds
	        google.maps.event.addListener(marker, 'click', function(){
		        infowindow.close(); // Close previously opened infowindow
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
</script>
<script src="http://speleo.local/speleo/modules/mod_mapping/src/markerclusterer.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $gkey?>&callback=initMap"></script>