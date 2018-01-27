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
    var markers = [];
    var map = new google.maps.Map(document.getElementById("map"), {});
    var image_path = "/speleo/modules/mod_mapping/images/";
    var icons = {
        "1": {icon: image_path + "speleoIcon1.png"},
        "2": {icon: image_path + "speleoIcon2.png"},
        "3": {icon: image_path + "speleoIcon3.png"}
    };

    // main loop creating and placing the markers
    formules.forEach(function(formule) {
        var marker = new google.maps.Marker({
            title: formule.name,
            position: {lat: Number(formule.lat), lng: Number(formule.lng)},
            map: map,
            icon: icons[formule.difficulty].icon
        });
        markers.push(marker);
        bnds.extend(marker.position);// extends the map bounds
        google.maps.event.addListener(marker, "click", function() {
            infowindow.close();
            infowindow.setContent(infoWindowContent(formule.name, formule.short_description));
            infowindow.open(map, marker);
        });
    });

    // marker clusterization
    new MarkerClusterer(map, markers, {imagePath: image_path + "m"});

    // adjust the map to the marker set
    map.setCenter(bnds.getCenter());
    map.fitBounds(bnds);
}

function infoWindowContent(title, description) {
    return '<div id="content">' +
            '<div id="siteNotice"></div>' +
            '<h1 id="firstHeading" class="firstHeading">' + title + '</h1>' +
            '<div id="bodyContent">' +
            '<p>' + description + '</p>' +
            '</div>' +
            '</div>';
}
