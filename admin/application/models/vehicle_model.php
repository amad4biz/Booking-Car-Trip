<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Vehicle_model extends CI_Model {

	public function __construct(){
		$this->load->database();
	}
	public function get_driver(){
		$this->db->select('driverID, firstName, lastName');
		$query = $this->db->get('driver'); 
		return $query->result_array();
	}
	public function get_vehicleType(){
		$this->db->select('vehicleTypeID, vehicleTypeCode, vehicleType,');
		$query = $this->db->get('vehicleType'); 
		return $query->result_array();
	}
	public function get_vehicle(){
		$sqlQuery = "SELECT		 V.vehicleID
								,D.driverID
								,D.firstName
								,D.lastName
								,VT.vehicleTypeID
								,VT.vehicleType
								,VT.maxPassenger
								,V.vehicleName
								,V.vehicleCode
								,V.vehiclePlate
								,V.make
								,V.model
								,V.year
							
					FROM 		vehicle V
					LEFT JOIN	driver as D ON D.driverID = V.driverID
					LEFT JOIN	vehicleType as VT ON VT.vehicleTypeID = V.vehicleTypeID
					";
		$query = $this->db->query($sqlQuery)->result_array();
		return $query;
	}
	public function get_vehicle_by_id($vehicleID){
		$sql = "SELECT		 vehicleID
							,driverID
							,vehicleTypeID
							,vehicleName
							,vehiclePlate
							,vehicleCode
							,make
							,model
							,year
							
				FROM 		vehicle
				WHERE 		vehicleID = ?"; 
		$query=$this->db->query($sql, array($vehicleID));
		return $query;
	}
	//Insert Vehicle
	public function insert_vehicle($vehicle_info){
		$data = array(
			'vehicleName' => $vehicle_info['vehicleName'],
			'vehiclePlate' => $vehicle_info['vehiclePlate'],
			'vehicleCode' => $vehicle_info['vehicleCode'],
			'make' => $vehicle_info['make'],
			'model' => $vehicle_info['model'],
			'year' => $vehicle_info['year'],
			'vehicleTypeID' => $vehicle_info['vehicleTypeID'],
			'driverID' => $vehicle_info['driverID'],
			'dateCreated' => 'now()'
		);
		$this->db->insert('vehicle', $data);
	}
	//Update Vehicle
	public function update_vehicle($vehicle_info){
		$sql = "UPDATE	vehicle
				SET		 driverID		= '{$vehicle_info['driverID']}'
						,vehicleTypeID	= '{$vehicle_info['vehicleTypeID']}'
						,vehicleName	= '{$vehicle_info['vehicleName']}'
						,vehiclePlate	= '{$vehicle_info['vehiclePlate']}'
						,vehicleCode	= '{$vehicle_info['vehicleCode']}'
						,make			= '{$vehicle_info['make']}'
						,model			= '{$vehicle_info['model']}'
						,year			= '{$vehicle_info['year']}'
						
				WHERE	vehicleID		= '{$vehicle_info['vehicleID']}'
				";
		$query=$this->db->query($sql, array());
		return $query;
	}
	//Delete Vehicle
	public function delete_vehicle($vehicleID) {
		$this->db->delete('vehicle', array('vehicleID'=>$vehicleID));
	}
}

?>