<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Driver_model extends CI_Model {

	public function __construct(){
		$this->load->database();
	}
	public function get_driver($data){
		$this->db->select('driverID, firstName, lastName, email, phone, isActive');
		$this->db->order_by("lastName ASC, firstName ASC"); 
		$query = $this->db->get('driver'); 
		
		$sql="SELECT
				driverID,
				firstName,
				lastName,
				email,
				phone,
		 		isActive
		 	FROM
		 		driver
		 	WHERE
		 		1=1
		 	";
		if(isset($data['isActive']) && $data['isActive'] != ''){
			$sql .= " AND isActive = '".$data['isActive']."'";
		}
		if(isset($data['keyword']) && $data['keyword'] != ''){
			$sql .=" AND (firstName like '%".$data['keyword']."%'";
			$sql .=" OR lastName like '%".$data['keyword']."%'";
			$sql .=" OR email like '%".$data['keyword']."%'";
			$sql .=" OR phone like '%".$data['keyword']."%')";
		}
		$sql.=" ORDER BY lastName ASC, firstName ASC";
		
		$query=$this->db->query($sql);//, array($driverID)
		return $query->result_array();
	}
	public function get_driver_by_id($driverID){
		$sql = "SELECT 
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
		return $query;
	}
	public function insert_driver($driver_info){
		if(!isset($driver_info['commission'])){
			$driver_info['commission'] = 0;
		}
		$data = array(
			'firstName' => $driver_info['firstName'],
			'lastName' => $driver_info['lastName'],
			'email' => $driver_info['email'],
			'phone' => $driver_info['phone'],
			'isActive' => $driver_info['isActive'],
			
			'Address' => $driver_info['Address'],
			'City' => $driver_info['City'],
			'State' => $driver_info['State'],
			'zipCode' => $driver_info['zipCode'],
			'socialSecurity' => $driver_info['socialSecurity'],
			'license' => $driver_info['license'],
			'bankName' => $driver_info['bankName'],
			'bankAccount' => $driver_info['bankAccount'],
			'commission' => $driver_info['commission'],
			'dateCreated' => 'now()'
		);
		$this->db->insert('driver', $data);
	}
	public function update_driver($driver_info){
		if(!isset($driver_info['commission'])){
			$driver_info['commission'] = 0;
		}
		$sql = "UPDATE	driver
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
		return $query;
	}
	public function delete_driver($driverID) {
		$this->db->delete('driver', array('driverID'=>$driverID));
	}
	
}

?>