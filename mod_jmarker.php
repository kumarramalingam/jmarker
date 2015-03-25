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

require( JModuleHelper::getLayoutPath('mod_jmarker'));
