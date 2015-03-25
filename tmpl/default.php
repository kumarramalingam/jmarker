<?php
/*------------------------------------------------------------------------
# mod_jmarker
# ------------------------------------------------------------------------
# author    Kumar Ramalingam - http://www.w3cert.in
# mail      kumar@w3cert.in
# copyright Copyright (C) 2012 W3cert.in All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://w3cert.in
-------------------------------------------------------------------------*/

// No direct access
defined('_JEXEC') or die;

$doc = JFactory::getDocument();
//$doc->addStyleSheet(JUri::root().'modules/mod_jmarker/media/css/style.css');
$doc->addScript(JUri::root().'/modules/mod_jmarker/media/js/jquery-1.9.1.min.js');
$doc->addScript(JUri::root().'/modules/mod_jmarker/media/js/jquery-ui.js');
$doc->addScript(JUri::root().'/modules/mod_jmarker/media/js/gmap3.js');
?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.8.21/jquery-ui.min.js"></script>


<div id="map" style="height: 400px;" class="span12"></div>
<input type="text" name="distance" id="distance" value="">
<input type="button" name="search" id="search" onclick="getDistance()" value="search">
<input type="checkbox" name="Lab" value="">Lab
<input type="checkbox" name="Lab" value="">Park
<div id="slider" class="slider">
</div>
<p><span id="slider-value"></span> Km </p>
<script>
jQuery(function() {	
    jQuery(".slider").slider();        
});
</script>

<script type="text/javascript">
	
	var distance;
	function getDistance() {
	  distance = document.getElementById('distance').value;
	  
	  var locations = [
      ['<?php echo $markerone ?>','<?php echo $markeronelat ?>','<?php echo $markeronelng ?>',],
      ['<?php echo $markertwo ?>','<?php echo $markertwolat ?>','<?php echo $markertwolng ?>'],
      ['<?php echo $markerthree ?>','<?php echo $markerthreelat ?>','<?php echo $markerthreelng ?>'],
      ['<?php echo $markerfour ?>','<?php echo $markerfourlat ?>','<?php echo $markerfourlng?>']
    ];   

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(-33.92, 151.25),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
   
    var infowindow = new google.maps.InfoWindow();
    var marker, i;
    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map,
        radius: distance * 1000,
        animation: google.maps.Animation.DROP
    });
      
          
      google.maps.event.addListener(marker, 'click', (function(marker, i) {		
        return function() {		  
		  if (marker.getAnimation() != null) {
			marker.setAnimation(null);
		  } else {
			marker.setAnimation(google.maps.Animation.BOUNCE);
		  }	
			
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
          
            var lat = marker.latLng.lat();
			var lng = marker.latLng.lng();
			var R = 6371; // radius of earth in km
			var distances = [];
			var closest = -1;
			for( i=0;i<map.locations.length; i++ ) {
				var mlat = map.locations[i].position.lat();
				var mlng = map.locations[i].position.lng();
				var dLat  = rad(mlat - lat);
				var dLong = rad(mlng - lng);
				var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
					Math.cos(rad(lat)) * Math.cos(rad(lat)) * Math.sin(dLong/2) * Math.sin(dLong/2);
				var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
				var d = R * c;
				distances[i] = d;
				if ( closest == -1 || d < distances[closest] ) {
					closest = i;
				}
			}
        }
      })(marker, i));
      
        function rad(x) {return x*Math.PI/180;}
		
    }
	  
	}
		
    var locations = [
      ['<?php echo $markerone ?>','<?php echo $markeronelat ?>','<?php echo $markeronelng ?>' ],
      ['<?php echo $markertwo ?>','<?php echo $markertwolat ?>','<?php echo $markertwolng ?>'],
      ['<?php echo $markerthree ?>','<?php echo $markerthreelat ?>','<?php echo $markerthreelng ?>'],
      ['<?php echo $markerfour ?>','<?php echo $markerfourlat ?>','<?php echo $markerfourlng?>']
    ];

    

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(-33.92, 151.25),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();
    var marker, i;
    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map,
        radius: '100',
        animation: google.maps.Animation.DROP
    });
      
          
      google.maps.event.addListener(marker, 'click', (function(marker, i) {		
        return function() {		  
		  if (marker.getAnimation() != null) {
			marker.setAnimation(null);
		  } else {
			marker.setAnimation(google.maps.Animation.BOUNCE);
		  }	
			
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
          
            var lat = marker.latLng.lat();
			var lng = marker.latLng.lng();
			var R = 6371; // radius of earth in km
			var distances = [];
			var closest = -1;
			for( i=0;i<map.locations.length; i++ ) {
				var mlat = map.locations[i].position.lat();
				var mlng = map.locations[i].position.lng();
				var dLat  = rad(mlat - lat);
				var dLong = rad(mlng - lng);
				var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
					Math.cos(rad(lat)) * Math.cos(rad(lat)) * Math.sin(dLong/2) * Math.sin(dLong/2);
				var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
				var d = R * c;
				distances[i] = d;
				if ( closest == -1 || d < distances[closest] ) {
					closest = i;
				}
			}
        }
      })(marker, i));
      
        function rad(x) {return x*Math.PI/180;}
		
    }
  </script>
