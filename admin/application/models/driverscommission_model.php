<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class DriversCommission_model extends CI_Model {

	public function __construct(){
		$this->load->database();
	}
	public function get_driversBookingCommissions($data){
	date_default_timezone_set('America/Los_Angeles');
	$sql = "SELECT
					booking.bookingID,
					booking.cost,
					booking.isCommissionPaid,
					booking.tipAmount,
					0 AS commission,
					bookingTrip.tripLeg,
					DATE_FORMAT(booking.dateCreated,'%m/%d/%Y') AS formattedBookingDate,
					DATE_FORMAT(booking.dateCreated,'%h:%i %p') AS formattedBookingTime,
					booking.dateCreated,
					driver.firstName,
					driver.lastName,
					(
						SELECT COUNT(DISTINCT trip.bookingTripID) FROM bookingTrip trip
						WHERE trip.bookingID = booking.bookingId
					) AS totalLeg,
					COALESCE((
						SELECT COALESCE(commission,0) FROM driverscommission
						WHERE
							driverscommission.driverID = bookingTrip.driverID
						AND
							booking.dateCreated BETWEEN
							driverscommission.startDate
						AND
							driverscommission.endDate
						LIMIT 0 , 1)
					,0) AS commissionPercentage
				FROM
					booking booking
					INNER JOIN bookingTrip ON bookingTrip.bookingID = booking.bookingId
					INNER JOIN driver ON bookingTrip.driverID = driver.driverID
				WHERE 
					booking.bookingStatusID <> 4
				AND
					driver.driverID = ".$data['driverID'];
					if(isset($_REQUEST['startDate']) && $_REQUEST['startDate'] != ''){
						$sql .= " AND booking.dateCreated BETWEEN '" . date('Y-m-d', strtotime($_REQUEST['startDate'])) . " 00:00:00' AND '" . date('Y-m-d', strtotime($_REQUEST['endDate'])) . " 23:59:59' ";		
					}
				$sql .= " ORDER BY
					booking.bookingID DESC,
					bookingTrip.bookingTripID ASC
				";
		$query=$this->db->query($sql);//, array($driverID) 
		return $query->result_array();
	}
	public function get_driversBooking($data){
	$sql = "SELECT
					booking.bookingID,
					booking.cost,
					booking.isCommissionPaid,
					booking.tipAmount,
					0 AS commission,
					DATE_FORMAT(booking.dateCreated,'%m/%d/%Y') AS formattedBookingDate,
					DATE_FORMAT(booking.dateCreated,'%h:%i %p') AS formattedBookingTime,
					booking.dateCreated,
					driver.firstName,
					driver.lastName, 
					driverscommission.driverID,
					driverscommission.driverscommissionID,
					driverscommission.commission,
					driverscommission.startDate,
					driverscommission.endDate,
					driverscommission.isActive
				FROM
					booking booking
					INNER JOIN bookingTrip ON bookingTrip.bookingID = booking.bookingId AND bookingTrip.tripLeg = 'first'
					INNER JOIN driver ON bookingTrip.driverID = driver.driverID
					INNER JOIN driverscommission  ON driverscommission.driverID = driver.driverID  
				WHERE 
					driverscommission.driverID = ".$data['driverID']."
					AND
					booking.isCommissionPaid = 0";
	

		$query=$this->db->query($sql);//, array($driverID) 
		return $query->result_array();
	}
	public function get_driversBookingTotal($data){
		$sql = "SELECT 	
					sum(booking.cost) as cost
				FROM
					booking booking
					INNER JOIN bookingTrip ON bookingTrip.bookingID = booking.bookingId AND bookingTrip.tripLeg = 'first'
					INNER JOIN driver ON bookingTrip.driverID = driver.driverID
					INNER JOIN driverscommission  ON driverscommission.driverID = driver.driverID  
				WHERE 
					driverscommission.driverID = ".$data['driverID']."
				AND
					booking.isCommissionPaid = 0";
		if(isset($data['startDate'])  || isset($data['endDate'])){
			if($data['startDate'] != '' && $data['endDate']!= ''){
				$sql .= " AND booking.dateCreated BETWEEN '".$data['startDate']."' AND '".$data['endDate']."'";
			}
			elseif($data['startDate'] == '' && $data['endDate']!= ''){
				$sql .= " AND booking.dateCreated < '".$data['endDate']."'";
			}
			elseif($data['startDate'] != '' && $data['endDate'] == ''){
				$sql .= " AND booking.dateCreated > '".$data['startDate']."'";
			}
		}
		
		//var_dump($sql);
		$query=$this->db->query($sql);//, array($driverID) 
		return $query->result_array();
	}
	public function get_driverscommission_by_driverID($data){
		$sql = "SELECT
					driver.firstName,
					driver.lastName, 
					driverscommission.driverID,
					driverscommission.driverscommissionID,
					driverscommission.commission,
					driverscommission.startDate,
					driverscommission.endDate,
					DATE_FORMAT(driverscommission.startDate,'%m/%d/%Y') AS formattedStartDate,
					DATE_FORMAT(driverscommission.endDate,'%m/%d/%Y') AS formattedEndDate,
					driverscommission.isActive
				FROM 
					driverscommission
					INNER JOIN driver ON driver.driverID = driverscommission.driverID 
				WHERE 
					driverscommission.driverID = '".$data['driverID']."'".
					" ORDER BY driverscommission.startDate DESC"
		; 
		$query=$this->db->query($sql);//, array($driverID)
		return $query->result_array();
	}
	public function get_driverscommission_by_id($driverscommissionID){
		$sql = "SELECT 
					driverID,
					driverscommissionID,
					commission,
					startDate,
					endDate,
					DATE_FORMAT(startDate,'%m/%d/%Y') AS formattedStartDate,
					DATE_FORMAT(endDate,'%m/%d/%Y') AS formattedEndDate,
					isActive
				FROM 
					driverscommission
				WHERE 
					driverscommissionID = ?"; 
		$query=$this->db->query($sql, array($driverscommissionID));
		return $query;
	}
	public function insert_driverscommission($driver_info){
		$data = array(
			'driverID' => $driver_info['driverID'],
			'commission' => $driver_info['commission'],
			'startDate' => date ("Y-m-d", strtotime($driver_info['startDate'])),
			'endDate' => date ("Y-m-d", strtotime($driver_info['endDate'])),
			'isActive' => $driver_info['isActive'],
			'dateCreated' => 'now()',
			'dateUpdated' => 'now()'
		);
		$this->db->insert('driverscommission', $data);
	}
	public function update_driverscommission($driver_info){
		$driver_info['startDate'] = date ("Y-m-d", strtotime($driver_info['startDate']));
		$driver_info['endDate'] = date ("Y-m-d", strtotime($driver_info['endDate']));
		$sql = "UPDATE	driverscommission
				SET		 driverID		= '{$driver_info['driverID']}'
						,commission	= '{$driver_info['commission']}'
						,startDate	= '{$driver_info['startDate']}'
						,endDate	= '{$driver_info['endDate']}'
						,isActive	= '{$driver_info['isActive']}'
						,dateUpdated	= 'now()'
						
				WHERE	driverscommissionID		= '{$driver_info['driverscommissionID']}'
				";
		$query=$this->db->query($sql, array());
		return $query;
	}
	public function isDriversCommissionExists($data){
		$sql = "SELECT 
					driverscommissionID
				FROM 
					driverscommission
				WHERE
					driverID = {$data['driverID']} 
				AND
					(	
						'".date ("Y-m-d", strtotime($data['startDate']))."' BETWEEN startDate AND endDate
					OR
						'".date ("Y-m-d", strtotime($data['endDate']))."' BETWEEN startDate AND endDate
					)";
		if(isset($data['driverscommissionID']) && $data['driverscommissionID'] > 0){
			$sql .= "
				 AND
					driverscommissionID <> {$data['driverscommissionID']}	
			";
		}
		$query=(array)$this->db->query($sql)->row();
		if(isset($query['driverscommissionID']) && $query['driverscommissionID'] > 0){
			return true;
		}
		else{
			return false;
		}
	}
	public function checkDuplicate_driverscommission($data){
		$sql = "SELECT 
					driverscommissionID
				FROM 
					driverscommission
				WHERE 
					startDate = BETWEEN '".$data['startDate']."' AND '".$data['endDate']."'
					OR
					endDate = BETWEEN '".$data['startDate']."' AND '".$data['endDate']."'";
		$query=$this->db->query($sql, array());
		return $query;
	}
	public function delete_driverscommission($driverscommissionID) {
		$this->db->delete('driverscommission', array('driverscommissionID'=>$driverscommissionID));
	}
	public function get_drivers(){
		$sql = "SELECT		 *
				FROM 		driver ORDER BY firstName,lastName"; 
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	
}

?>