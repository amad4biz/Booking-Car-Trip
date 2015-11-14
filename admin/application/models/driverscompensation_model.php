<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Driverscompensation_model extends CI_Model {

	public function __construct(){
		$this->load->database();
	}
	public function get_driverscompensation($driverID){
		$sql = "SELECT 
					booking.bookingID,
					booking.bookingStatusID,
					booking.cost,
					booking.userID,
					bookingTrip.driverID,
					booking.commissionPercentage,
					booking.cost * (dc.commission/100) AS compensation,
					dc.commission,
					booking.isCommissionPaid,
					booking.dateCommissionPaid,
					booking.dateCreated, 				
					driver.firstName,
					driver.lastName,
					driver.email
				FROM 
					booking booking
					INNER JOIN bookingTrip ON bookingTrip.bookingID = booking.bookingId AND bookingTrip.tripLeg = 'first'
					INNER JOIN driver driver ON bookingTrip.driverID = driver.driverID
					INNER JOIN driverscommission dc ON driver.driverID = dc.driverID
				WHERE 
					bookingTrip.driverID = ?"; 
		$query=$this->db->query($sql, array($driverID));
		return $query->result_array();
	}
public function get_driverscompensationTotal($driverID){
		$sql = "SELECT 
					SUM(booking.cost * (dc.commission/100)) AS compensation
				FROM 
					booking booking
					INNER JOIN bookingTrip ON bookingTrip.bookingID = booking.bookingId AND bookingTrip.tripLeg = 'first'
					INNER JOIN driver driver ON bookingTrip.driverID = driver.driverID
					INNER JOIN driverscommission dc ON driver.driverID = dc.driverID
				WHERE 
					bookingTrip.driverID = ?"; 
		$query=$this->db->query($sql, array($driverID));
		return $query->result_array();
	}
	public function get_driverscompensation_by_id_and_dateRange($driverID){
		/*$sql = "SELECT 
					driverID,
					firstName,
					lastName,
					email,
					phone,
					isActive,
					Address,
					City,
					State,
					zipCode,
					socialSecurity,
					license,
					bankName,
					bankAccount,
					commission 
				FROM 
					driver 
				WHERE 
					driverID = ?"; 
		$query=$this->db->query($sql, array($driverID));
		return $query;*/
	}
	public function update_driverscompensation($driver_info){
		/*$sql = "UPDATE	driver
				SET		 firstName		= '{$driver_info['firstName']}'
						,lastName	= '{$driver_info['lastName']}'
						,email	= '{$driver_info['email']}'
						,phone	= '{$driver_info['phone']}'
						,isActive	= '{$driver_info['isActive']}'
						,Address	= '{$driver_info['Address']}'
						,City	= '{$driver_info['City']}'
						,State	= '{$driver_info['State']}'
						,zipCode	= '{$driver_info['zipCode']}'
						,socialSecurity	= '{$driver_info['socialSecurity']}'
						,license	= '{$driver_info['license']}'
						,bankName	= '{$driver_info['bankName']}'
						,bankAccount	= '{$driver_info['bankAccount']}'
						,commission	= '{$driver_info['commission']}'
						
				WHERE	driverID		= '{$driver_info['driverID']}'
				";
		$query=$this->db->query($sql, array());
		return $query;*/
	}
}

?>