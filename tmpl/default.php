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
JHtml::_('jquery.framework');
?>
<script src="http://maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script>

<div id="map" style="width: 500px; height: 400px;"></div>

<script type="text/javascript">
		
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
        map: map
      });
          
      google.maps.event.addListener(marker, 'click', (function(marker, i) {
		
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
  </script>
