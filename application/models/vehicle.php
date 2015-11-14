<?php
class vehicle extends CI_Model {

	public function __construct()
	{
		// Call the Model constructor
        parent::__construct();
	}
	/* === Gateway === */
	public function get_vehicleTypes($sort_by="sortorder",$sorder="ASC") {
		$query = $this->db->query('SELECT vehicleTypeID,vehicleTypeCode,vehicleType,maxPassenger,picture FROM vehicleType where isActive = 1 order by ' .$sort_by .' '.$sorder);
		return $query->result_array();
	}
	public function calculatePrice($vehicleTypeID,$miles) {
		$query = $this->db->query('SELECT price FROM pricing where vehicleTypeID = ' . $vehicleTypeID . ' AND mileFrom = ' . round($miles));
		$result = $query->result_array();
		return $result;
	}
	public function get_vehicle_by_type($vehicle){
		$query = $this->db->query("SELECT vehicleType as vehicleName FROM vehicleType WHERE vehicleTypeID = '{$vehicle}'");
		
		return $query->result_array();
	}
	/* === DAO === */
}
?>