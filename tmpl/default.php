
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
$doc->addStyleSheet(JUri::root().'modules/mod_jmarker/media/css/style.css');
$doc->addStyleSheet(JUri::root().'modules/mod_jmarker/media/css/jqueryui.css');
$doc->addScript(JUri::root().'/modules/mod_jmarker/media/js/jquery-1.9.1.min.js');
$doc->addScript(JUri::root().'/modules/mod_jmarker/media/js/jquery-ui.js');
$doc->addScript(JUri::root().'/modules/mod_jmarker/media/js/gmap3.js');
?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places"></script>

  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script> 
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>  

<!-- <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script> -->
<!-- <script src="http://maps.google.com/maps/api/js?v=3&libraries=geometry"></script>
-->
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
-->
<!-- <script src="http://code.jquery.com/ui/1.8.21/jquery-ui.min.js"></script>
-->
<input id="pac-input" class="controls" type="text" placeholder="Enter a location">
    <div id="type-selector" class="controls">
     
    </div>
    
    <input type="text" value="" id="searchbox" style=" width:800px;height:30px; font-size:15px;">
<div id="map" style="height: 400px;" class="span12"></div>
<input type="text" name="distance" id="distance" value="">
<input type="button" name="search" id="search" onclick="getDistance()" value="search">
<input type="checkbox" name="Lab" value="">Lab
<input type="checkbox" name="Lab" value="">Park
<!-- <div id="slider"></div> -->
<div id="slider" class="slider"></div>
<p><span id="slider-value"></span> Km </p>
<select id="geodistance" name="geodistance">
	<option value="5"><?php echo JText::_('MOD_JMARKER_RADIUS_FIVE_KILOMETER'); ?></option>
	<option value="10"><?php echo JText::_('MOD_JMARKER_RADIUS_TEN_KILOMETER'); ?></option>
	<option value="15"><?php echo JText::_('MOD_JMARKER_RADIUS_FIFTYTEEN_KILOMETER'); ?></option>
	<option value="20"><?php echo JText::_('MOD_JMARKER_RADIUS_TWENTY_KILOMETER'); ?></option>
	<option value="30"><?php echo JText::_('MOD_JMARKER_RADIUS_THIRTY_KILOMETER'); ?></option>
	<option value="40"><?php echo JText::_('MOD_JMARKER_RADIUS_FOURTY_KILOMETER'); ?></option>
	<option value="50"><?php echo JText::_('MOD_JMARKER_RADIUS_FIVENTEEN_KILOMETER'); ?></option>
	<option value="60"><?php echo JText::_('MOD_JMARKER_RADIUS_SIXTEEN_KILOMETER'); ?></option>
	<option value="70"><?php echo JText::_('MOD_JMARKER_RADIUS_SEVENTEEN_KILOMETER'); ?></option>
	<option value="80"><?php echo JText::_('MOD_JMARKER_RADIUS_EIGHTYTEEN_KILOMETER'); ?></option>
	<option value="90"><?php echo JText::_('MOD_JMARKER_RADIUS_NIGHTYTEEN_KILOMETER'); ?></option>
	<option value="100"><?php echo JText::_('MOD_JMARKER_RADIUS_HUNDRED_KILOMETER'); ?></option>
</select>	
<!-- <input class="span6" id="geoaddress" type="text" value="Enter an address..."
                       onblur="if (this.value=='') {this.value='Enter an address...';jQuery('#fp_searchAddressBtn').attr('disabled', true);}"
                       onfocus="if (this.value=='Enter an address...') this.value='';jQuery('#fp_searchAddressBtn').attr('disabled', false);">
-->
<input class="span6" id="geoaddress" type="text" value="" placeholder="Enter City,State or Zipcode..">
<input type="button" id="fp_searchAddressBtn" value="search" class="btn" onclick="codeAddress()">


<script type="text/javascript">
 $(document).ready(function(){

  var mapOptions = {
       zoom: 10,
       mapTypeId: google.maps.MapTypeId.ROADMAP,
       center: new google.maps.LatLng(41.06000,28.98700)
     };

  var map = new google.maps.Map(document.getElementById("map"),mapOptions);

  var geocoder = new google.maps.Geocoder();  

     $(function() {
         $("#searchbox").autocomplete({
         
           source: function(request, response) {

          if (geocoder == null){
           geocoder = new google.maps.Geocoder();
          }
             geocoder.geocode( {'address': request.term }, function(results, status) {
               if (status == google.maps.GeocoderStatus.OK) {

                  var searchLoc = results[0].geometry.location;
               var lat = results[0].geometry.location.lat();
                  var lng = results[0].geometry.location.lng();
                  var latlng = new google.maps.LatLng(lat, lng);
                  var bounds = results[0].geometry.bounds;

                  geocoder.geocode({'latLng': latlng}, function(results1, status1) {
                      if (status1 == google.maps.GeocoderStatus.OK) {
                        if (results1[1]) {
                         response($.map(results1, function(loc) {
                        return {
                            label  : loc.formatted_address,
                            value  : loc.formatted_address,
                            bounds   : loc.geometry.bounds
                          }
                        }));
                        }
                      }
                    });
            }
              });
           },
           select: function(event,ui){
      var pos = ui.item.position;
      var lct = ui.item.locType;
      var bounds = ui.item.bounds;

      if (bounds){
       map.fitBounds(bounds);
      }
           }
         });
     });   
 });
</script>

    <script>
function initialize() {
	
var locations = jQuery.parseJSON('<?php echo json_encode($finaldatas) ?>');

 geocoder = new google.maps.Geocoder();
             
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(-33.92, 151.25),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });   

// Setup the different icons and shadows
    var iconURLPrefix = 'http://maps.google.com/mapfiles/ms/icons/';
    
    var icons = [
      iconURLPrefix + 'red-dot.png',
      iconURLPrefix + 'green-dot.png',
      iconURLPrefix + 'blue-dot.png',
      iconURLPrefix + 'orange-dot.png',
      iconURLPrefix + 'purple-dot.png',
      iconURLPrefix + 'pink-dot.png',      
      iconURLPrefix + 'yellow-dot.png'
    ]
    
    var iconCounter = 0;
       
    var infowindow = new google.maps.InfoWindow();
    var marker, i;
    for (i = 0; i < countlatlngs; i++) {  
        marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][9], locations[i][8]),
        icon: icons[iconCounter],
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
		  	  
		  var contents = "Title        :" + locations[i][0] + "<br/>" + 
		                 "Contact Name :" + locations[i][1] + "<br/>" +
		                 "Email        :" + locations[i][2] + "<br/>" +
		                 "Address      :" + locations[i][3] + "<br/>" + locations[i][4] + "<br/>" + locations[i][5] + "<br/>" +
		                 "Mobile       :" + locations[i][6] + "<br/>";		                 
		                 
          console.log(contents);
			
          infowindow.setContent(contents);        
        
          infowindow.open(map, marker);
                   
            var lat = marker.latLng.lat();
			var lng = marker.latLng.lng();
			var R = 6371; // radius of earth in km
			var distances = [];
			var closest = -1;
			for( i=0;i<map.countlatlngs; i++ ) {
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
      iconCounter++;
     
        function rad(x) {return x*Math.PI/180;}
		
    }

  var input = /** @type {HTMLInputElement} */(
      document.getElementById('pac-input'));

  var types = document.getElementById('type-selector');
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

  var autocomplete = new google.maps.places.Autocomplete(input);
  autocomplete.bindTo('bounds', map);

  var infowindow = new google.maps.InfoWindow();
  var marker = new google.maps.Marker({
    map: map,
    anchorPoint: new google.maps.Point(0, -29)
  });

  google.maps.event.addListener(autocomplete, 'place_changed', function() {
    infowindow.close();
    marker.setVisible(false);
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      return;
    }

    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);  // Why 17? Because it looks good.
    }
    marker.setIcon(/** @type {google.maps.Icon} */({
      url: place.icon,
      size: new google.maps.Size(71, 71),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(17, 34),
      scaledSize: new google.maps.Size(35, 35)
    }));
    marker.setPosition(place.geometry.location);
    marker.setVisible(true);

    var address = '';
    if (place.address_components) {
      address = [
        (place.address_components[0] && place.address_components[0].short_name || ''),
        (place.address_components[1] && place.address_components[1].short_name || ''),
        (place.address_components[2] && place.address_components[2].short_name || '')
      ].join(' ');
    }

    infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
    infowindow.open(map, marker);
  });

  // Sets a listener on a radio button to change the filter type on Places
  // Autocomplete.
  function setupClickListener(id, types) {
    var radioButton = document.getElementById(id);
    google.maps.event.addDomListener(radioButton, 'click', function() {
      autocomplete.setTypes(types);
    });
  }

  setupClickListener('changetype-all', []);
  setupClickListener('changetype-address', ['address']);
  setupClickListener('changetype-establishment', ['establishment']);
  setupClickListener('changetype-geocode', ['geocode']);
}

  function codeAddress() {	
	  
   var locations = jQuery.parseJSON('<?php echo json_encode($finaldatas) ?>');

 geocoder = new google.maps.Geocoder();
             
   
// Setup the different icons and shadows
    var iconURLPrefix = 'http://maps.google.com/mapfiles/ms/icons/';
    
    var icons = [
      iconURLPrefix + 'red-dot.png',
      iconURLPrefix + 'green-dot.png',
      iconURLPrefix + 'blue-dot.png',
      iconURLPrefix + 'orange-dot.png',
      iconURLPrefix + 'purple-dot.png',
      iconURLPrefix + 'pink-dot.png',      
      iconURLPrefix + 'yellow-dot.png'
    ]
    
    var iconCounter = 0;
       
    var infowindow = new google.maps.InfoWindow();
    var marker, i;
    for (i = 0; i < countlatlngs; i++) {  
        marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][9], locations[i][8]),
        icon: icons[iconCounter],
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
		  	  
		  var contents = "Title        :" + locations[i][0] + "<br/>" + 
		                 "Contact Name :" + locations[i][1] + "<br/>" +
		                 "Email        :" + locations[i][2] + "<br/>" +
		                 "Address      :" + locations[i][3] + "<br/>" + locations[i][4] + "<br/>" + locations[i][5] + "<br/>" +
		                 "Mobile       :" + locations[i][6] + "<br/>";		                 
		                 
          console.log(contents);
			
          infowindow.setContent(contents);        
        
          infowindow.open(map, marker);
                   
            var lat = marker.latLng.lat();
			var lng = marker.latLng.lng();
			var R = 6371; // radius of earth in km
			var distances = [];
			var closest = -1;
			for( i=0;i<map.countlatlngs; i++ ) {
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
      iconCounter++;
     
        function rad(x) {return x*Math.PI/180;}
		
    }	   
    
   var input = /** @type {HTMLInputElement} */(
      document.getElementById('pac-input'));

  var types = document.getElementById('type-selector');
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

  var autocomplete = new google.maps.places.Autocomplete(input);
  autocomplete.bindTo('bounds', map);

  var infowindow = new google.maps.InfoWindow();
  var marker = new google.maps.Marker({
    map: map,
    anchorPoint: new google.maps.Point(0, -29)
  });

  google.maps.event.addListener(autocomplete, 'place_changed', function() {
    infowindow.close();
    marker.setVisible(false);
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      return;
    }

    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);  // Why 17? Because it looks good.
    }
    marker.setIcon(/** @type {google.maps.Icon} */({
      url: place.icon,
      size: new google.maps.Size(71, 71),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(17, 34),
      scaledSize: new google.maps.Size(35, 35)
    }));
    marker.setPosition(place.geometry.location);
    marker.setVisible(true);

    var address = '';
    if (place.address_components) {
      address = [
        (place.address_components[0] && place.address_components[0].short_name || ''),
        (place.address_components[1] && place.address_components[1].short_name || ''),
        (place.address_components[2] && place.address_components[2].short_name || '')
      ].join(' ');
    }

    infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
    infowindow.open(map, marker);
  });

  // Sets a listener on a radio button to change the filter type on Places
  // Autocomplete.
  function setupClickListener(id, types) {
    var radioButton = document.getElementById(id);
    google.maps.event.addDomListener(radioButton, 'click', function() {
      autocomplete.setTypes(types);
    });
  }

  setupClickListener('changetype-all', []);
  setupClickListener('changetype-address', ['address']);
  setupClickListener('changetype-establishment', ['establishment']);
  setupClickListener('changetype-geocode', ['geocode']);
		   
   //var address = document.getElementById('geoaddress').value;
   //var address = autocomplete;
   
   console.log(input);
   var slideradius = document.getElementById('slider-value').value;
     
   var radius = parseInt(document.getElementById('geodistance').value, 10)*1000;
        geocoder.geocode({ 'address': address}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            
            map.setCenter(results[0].geometry.location);
            var searchCenter = results[0].geometry.location;
            
            console.log(searchCenter);
                               
            /*
            var marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location
            });
            */
            
            //console.log(marker);       
                       
        if(circle) circle.setMap(null);
                       
        circle = new google.maps.Circle({center:searchCenter,
                                             radius: radius,
                                             fillOpacity: 0.10,
                                             fillColor: "#2AE6F8",
                                             
                                             strokeColor: "#2AE6F8",
											 strokeOpacity: 0.50,
											 strokeWeight: 2,											 
                                             map : map
                                             
                                             });
                                             
            //circle.bindTo('map', marker);                         
                                             
            //circle.setMap(map);                                 
                                                         
           //circle.bindTo('map',map);                                          
                                             
           var circlemarker = isMarkerInArea(circle,marker);   
                         
           var bounds = new google.maps.LatLngBounds();
                     
           map.fitBounds(bounds); 
                    
           //console.log(bounds);
	       var foundMarkers = 0;
	    
	       //float[] distance = new float[2];    
	    
            for (var i=0; i<gmarkers.length;i++) {
              if (google.maps.geometry.spherical.computeDistanceBetween(gmarkers[i].getPosition(),searchCenter) < radius) {
                bounds.extend(gmarkers[i].getPosition())
                gmarkers[i].setMap(map);
               
		        foundMarkers++;
              } else {
                gmarkers[i].setMap(null);
              }
            }          
            
            // put the assembled side_bar_html contents into the side_bar div
            //document.getElementById("side_bar").innerHTML = side_bar_html;
            //console.log(foundMarkers);
            
            if (foundMarkers > 0) {				
				
              map.fitBounds(bounds);
	        } else {
              map.fitBounds(circle.getBounds());
            }
            // makeSidebar();
            //google.maps.event.addListenerOnce(map, 'bounds_changed', makeSidebar);
           
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
}

google.maps.event.addDomListener(window, 'load', initialize);

jQuery(function() {	
   var markersData = {
        values: [{
            latLng: [51.506695, -0.147950],
            options: {
                icon: "http://maps.google.com/mapfiles/kml/paddle/blu-circle.png",
            },
            data: 'aaabbb',
            tag: "aaa"
        }, ],
        options: {
            draggable: false
        }
    };
    
    var locations = jQuery.parseJSON('<?php echo json_encode($finaldatas) ?>');
    
    console.log(locations);
    
     /*var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(-33.92, 151.25),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });*/
    
  // Try HTML5 geolocation
  if(navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = new google.maps.LatLng(position.coords.latitude,
                                       position.coords.longitude);
      map.setCenter(pos);
    }, function() {
      handleNoGeolocation(true);
    });
  } else {
    // Browser doesn't support Geolocation
    handleNoGeolocation(false);
  }	
		
  jQuery("#slider").slider({
        range: "min",
        value: 1,
        min: 1,
        max: 100,
        slide: function (event, ui) {
            computedistance(ui.value);
            jQuery("#slider-value").html(ui.value);  
            jQuery("#slider-distance").html(ui.value);          
        }
    }).slider("option", "slide").call(jQuery("#slider"), null, {
        value: jQuery("#slider").slider("value")
    });  
    
   jQuery("#slider-value").html(jQuery('#slider').slider('value'));
   
   function computedistance(km) {
	      
	    console.log(km);
	    
	    console.log(locations[0][7]);    

        var markers = jQuery("#map").gmap3({
            get: {
                name: "marker",
                all: true
            }
        }),
           user = new google.maps.LatLng(locations[0][8],          
           locations[0][9]),
           map = jQuery("#map").gmap3({
                get: {
                    name: 'map'
                }
           });
        jQuery.each(markers, function (i, m) {
            m.setMap((google.maps.geometry.spherical.computeDistanceBetween(user, m.getPosition()) <= km * 1000) ? map : null);
        });
   }  
});
    
    var gmarkers = [];
    var circle = null;
	
	var distance;	

	
	 var gmarkers = []; 

     // global "map" variable
     
      var circle = null;
      var geocoder = new google.maps.Geocoder();
		
	var countlatlngs = '<?php echo $countlnglats ?>';
		
	//console.log(jsonlocations[1][0]);
	//console.log(countlatlngs);
	
	//var locations = jQuery.parseJSON('<?php echo json_encode($finalnglats) ?>');
	
	var locations = jQuery.parseJSON('<?php echo json_encode($finaldatas) ?>');
	
	console.log(locations);
			
    /*var locations = [
      ['<?php echo $markerone ?>','<?php echo $markeronelat ?>','<?php echo $markeronelng ?>' ],
      ['<?php echo $markertwo ?>','<?php echo $markertwolat ?>','<?php echo $markertwolng ?>'],
      ['<?php echo $markerthree ?>','<?php echo $markerthreelat ?>','<?php echo $markerthreelng ?>'],
      ['<?php echo $markerfour ?>','<?php echo $markerfourlat ?>','<?php echo $markerfourlng?>']
    ];*/
       
    //locations = jsonlocations;
    
    geocoder = new google.maps.Geocoder();
             
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(-33.92, 151.25),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });    
    


    


function isMarkerInArea(circle, marker){
   return (circle.getBounds().contains(marker.getPosition()));
};
  </script>
