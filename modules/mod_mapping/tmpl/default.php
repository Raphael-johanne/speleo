<?php 
// No direct access
defined('_JEXEC') or die;
?>

<?php // adding style
$document->addStyleSheet('/speleo/modules/mod_mapping/src/mapstyle.css');
?>

<div id="map"></div>

<script src="/speleo/modules/mod_mapping/src/mapmaking.js"></script>
<script src="/speleo/modules/mod_mapping/src/markerclusterer.js"></script>
<script> function initMap(){generateMap(<?php echo json_encode($formules)?>);}</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_KEY?>&callback=initMap"></script>
