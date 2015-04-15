<?php
/*------------------------------------------------------------------------
# mod_jmarker
# ------------------------------------------------------------------------
# author    Kumar Ramalingam - http://www.w3cert.in
# mail      kumar@w3cert.in
# copyright Copyright (C) 2012 W3Cert.in All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://w3cert.in
-------------------------------------------------------------------------*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once __DIR__ . '/helper.php';
$doc = JFactory::getDocument();
//$doc->addStyleSheet(JUri::root().'modules/mod_jmarker/media/css/style.css');
//$doc->addScript(JUri::root().'modules/mod_jmarker/media/js/jquery-1.9.1.min.js');
//$doc->addScript(JUri::root().'modules/mod_jmarker/media/js/jquery-ui.js');
?>
<?php
include_once JPATH_LIBRARIES.'/fof/include.php';
$app = JFactory::getApplication();

/**
 * @var $markerone Get marker name.
 */
$markerone = $params->get('marker_one');
$markeronelat = $params->get('marker_one_lat');
$markeronelng = $params->get('marker_one_lng');

$markertwo = $params->get('marker_two');
$markertwolat = $params->get('marker_two_lat');
$markertwolng = $params->get('marker_two_lng');

$markerthree = $params->get('marker_three');
$markerthreelat = $params->get('marker_three_lat');
$markerthreelng = $params->get('marker_three_lng');

$markerfour = $params->get('marker_four');
$markerfourlat = $params->get('marker_four_lat');
$markerfourlng = $params->get('marker_four_lng');

/**
 * new object create. 
 */ 
$object = new ModJMarkerHelper();

/**
 * Call getMarkers() method.
 */ 
$items = $object->getMarkers();

/**
 * Get the longitudes values.
 */ 
$longitudes = $object->getLongitudes();

/**
 * Get the markers titles.
 */ 
$baseDatas = $object->getBaseTitles();

$alldatas = $object->getBaseData();

//$_image = base64_decode($alldatas['156']['baseData']);
//$baseimg = unserialize($_image);

$datas = array();
foreach($alldatas as $data) {
 foreach($longitudes as $longitude) {
	if(!empty($longitude['baseData']) && isset($longitude['baseData'])) {	
	 if($data['sid'] == $longitude['sid']) {	
	  if($data['fid'] == 1 || $data['fid'] == 4 || $data['fid'] == 7 || $data['fid'] ==10 || $data['fid']== 15 || $data['fid'] == 14 || $data['fid'] == 2 || $data['fid'] == 3 || $data['fid'] ==5 || $data['fid'] ==20 || $data['fid'] == 21) {
	    $datas[] = $data;	
      }
     }
   }
 }
}



$arritems = array();

foreach($datas as $key => $item)
{
   $arritems[$item['sid']][$key] = $item;
}

ksort($arritems, SORT_NUMERIC);

$fdatas = array();
/**
 * With image file.
 */ 
foreach($arritems as $data) {
  foreach($data as $sdata) {
   foreach($longitudes as $longitude) {
	if($sdata['sid'] == $longitude['sid']) {
		$fdatas[] = $sdata['baseData'];
    }
   }
  }
}

/**
 * Without image file.
 */ 
/*$fdatas = array();
foreach($datas as $data) {
  foreach($longitudes as $longitude) {
	if($data['sid'] == $longitude['sid']) {	
     $fdatas[] = $data['baseData'];
    }
  }	
}*/

$finaldatas = array_chunk($fdatas,11);

//print_r(json_encode($finaldatas));
//exit;


$farritems = array();

foreach($arritems as $arritem) {
 foreach($arritem as $item) {
  $farritems[] = $item['baseData'];
 }
}

$basetitles = array();

foreach($baseDatas as $baseData) {
	foreach($longitudes as $longitude) {
	if(!empty($longitude['baseData']) && isset($longitude['baseData'])) {	
	 if($baseData['sid'] == $longitude['sid']) {
	   $basetitles[] = $baseData['baseData'];
	 }
	}
  }
}


$lngtudes = array();
foreach($longitudes as $lng) {
	if(!empty($lng['baseData']) && isset($lng['baseData'])) {
		$lngtudes[] = $lng['baseData'];		
    }
}

/**
 * Get the latitudes values.
 */ 
$latitudes  = $object->getLatitudes(); 
$latudes = array();
foreach($latitudes as $latude) {
	if(!empty($latude['baseData']) && isset($latude['baseData'])) {
		$latudes[] = $latude['baseData'];
    }
}

//print_r($latudes);
//print_r($lngtudes);
//print_r($basetitles);

$lnglats = array();
for($i=0;$i<count($latudes);$i++) {
	$lnglats[$i] = $latudes[$i] .' '.$lngtudes[$i];
}

$flnglats = array();
foreach($lnglats as $lnglat) {
	$flnglats[] = explode(' ',$lnglat);
}

$basevalues = array();
for($i=0;$i<count($flnglats);$i++) {
  array_push($flnglats[$i],$basetitles[$i]);
}

$finalnglats = array();
foreach($flnglats as $flnglat) {
$finalnglats[] = $flnglat;
}



$countlnglats = count($flnglats);

$fjsonlnglats = json_encode($finalnglats);

//$latude = json_encode($latudes);

//$lngtude = json_encode($lngtudes);

require( JModuleHelper::getLayoutPath('mod_jmarker'));
