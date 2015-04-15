<?php
/*------------------------------------------------------------------------
# com_jmarker
# ------------------------------------------------------------------------
# author    Kumar Ramalingam - http://www.w3cert.in
# mail      kumar@w3cert.in
# copyright Copyright (C) 2012 W3cert.in All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://w3cert.in
-------------------------------------------------------------------------*/

// No direct access
defined('_JEXEC') or die;

/**
 * JMarker - Helper class.
 */ 
class ModJMarkerHelper {
	
	function __construct($config=array())
	{		
		$this->app = JFactory::getApplication();
		$this->db = JFactory::getDbo();
	}	
	
	public function getMarkers() {
		
		// Create a new query object.
        $query = $this->db->getQuery(true);        
        $query->select($this->db->quoteName(array('fid','sid','section','baseData')));
		$query->from($this->db->quoteName('#__sobipro_field_data'));
		$query->where('fid=20');
		// Reset the query using our newly populated query object.
		$this->db->setQuery($query);
		$longitude = $this->db->loadObjectList();
		
		$query = $this->db->getQuery(true);		
		$query->select($this->db->quoteName(array('fid','sid','section','baseData')));
		$query->from($this->db->quoteName('#__sobipro_field_data'));
		$query->where('fid=21');
		// Reset the query using our newly populated query object.
		$this->db->setQuery($query);
		$latitude = $this->db->loadObjectList();
		
		$longitudes = json_decode(json_encode($longitude), true);
		$latitudes = json_decode(json_encode($latitude), true);
							
		return $longitude;			
	}
	
	/**
	 * Get the all base datas.
	 */ 
	public function getBaseData() {
	    // Create a new query object.
        $query = $this->db->getQuery(true);        
        $query->select($this->db->quoteName(array('fid','sid','section','baseData')));
		$query->from($this->db->quoteName('#__sobipro_field_data'));
		// Reset the query using our newly populated query object.
		$this->db->setQuery($query);
		$titles = $this->db->loadObjectList();
	    $basedatatitles = json_decode(json_encode($titles),true);	       
	    return $basedatatitles;
	}	
	
	/**
	 * Get the base data titles.
	 */ 
	public function getBaseTitles() {
	    // Create a new query object.
        $query = $this->db->getQuery(true);        
        $query->select($this->db->quoteName(array('fid','sid','section','baseData')));
		$query->from($this->db->quoteName('#__sobipro_field_data'));
		$query->where('fid=1');
		// Reset the query using our newly populated query object.
		$this->db->setQuery($query);
		$titles = $this->db->loadObjectList();
	    $basedatatitles = json_decode(json_encode($titles),true);	
	    return $basedatatitles;
	}
	
	/**
	 * Get longitudes values.
	 */ 
	public function getLongitudes() {
	    // Create a new query object.
        $query = $this->db->getQuery(true);        
        $query->select($this->db->quoteName(array('fid','sid','section','baseData')));
		$query->from($this->db->quoteName('#__sobipro_field_data'));
		$query->where('fid=20');
		// Reset the query using our newly populated query object.
		$this->db->setQuery($query);
		$longitude = $this->db->loadObjectList();
	    $longitudes = json_decode(json_encode($longitude),true);	
	    return $longitudes;
	}
	
	/**
	 * Get latitudes values.
	 */ 
	public function getLatitudes() {
		// Create a new query object.
	    $query = $this->db->getQuery(true);		
		$query->select($this->db->quoteName(array('fid','sid','section','baseData')));
		$query->from($this->db->quoteName('#__sobipro_field_data'));
		$query->where('fid=21');
		// Reset the query using our newly populated query object.
		$this->db->setQuery($query);
		$latitude = $this->db->loadObjectList();
		$latitudes = json_decode(json_encode($latitude),true);
		
		return $latitudes;
	}	
	
		
}


