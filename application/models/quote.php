<?php
class Quote extends CI_Model {

	public function __construct()
	{
		// Call the Model constructor
        parent::__construct();
	}
	/* === Gateway === */
	public function get_quotes($sort_by="name",$sorder="ASC") {
		//$query = $this->db->query('SELECT id,name,airport_code FROM airports');
		//return $query->result_array();
	}
	public function get_airports($sort_by="sortOrder",$sorder="ASC") {
		$query = $this->db->query('SELECT id,name,airport_code,address2 FROM airports ORDER BY '.$sort_by.' '.$sorder);
		return $query->result_array();
	}
	public function get_airport_by_airportCode($airport){
		$query = $this->db->query("
			SELECT	id, name, address, city, state, zip
			FROM	airports
			WHERE	airport_code = '{$airport}'
		");
		return $query->result_array();
	}
	public function select_Price_By_distance($distance, $surcharge){
		if($distance == 0){
			$query = $this->db->query("
			SELECT	(40)+{$surcharge} as economy, 
					(45)+{$surcharge} as private_van, 
					(50)+{$surcharge} as luxury_sedan
			");
		}
		else if ($distance > 0 && $distance < 11)
		{
			$query = $this->db->query("
			SELECT	(40)+{$surcharge} as economy, 
					(45)+{$surcharge} as private_van, 
					(50)+{$surcharge} as luxury_sedan
			");
		}
		else {
			$query = $this->db->query("
				SELECT	({$distance}*economy_price)+{$surcharge} as economy, 
						({$distance}*van_price)+{$surcharge} as private_van, 
						({$distance}*luxury_price)+{$surcharge} as luxury_sedan
				FROM	prices
				WHERE	mile = '{$distance}'
			");
		}
		return $query->result_array();
	} 
	public function select_Surcharge_Pickup($pickUp_zip){
		$query = $this->db->query("
			SELECT	roundTripSurcharge, oneWaySurcharge, surchargeType, personalQuote
			FROM 	surcharge
			WHERE	1=1
			AND '{$pickUp_zip}' BETWEEN startZip and endZip
			ORDER BY sortOrder

		");
		return $query->result_array();
	}
	public function select_Surcharge_Dropoff($dropOff_zip){
		$query = $this->db->query("
			SELECT	roundTripSurcharge, oneWaySurcharge, surchargeType, personalQuote
			FROM 	surcharge
			WHERE	1=1 
			AND '{$dropOff_zip}' BETWEEN startZip and endZip
			ORDER BY sortOrder
		");
		return $query->result_array();
	}
	
	/* === DAO === */
}	
?>