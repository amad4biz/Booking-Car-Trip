<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Staff_model extends CI_Model {

	public function __construct(){
		$this->load->database();
	}
	public function get_staff(){
		$this->db->select('staffID, firstName, lastName, userName, email, phone, isActive');
		$query = $this->db->get('staff'); 
		return $query->result_array();
	}
	public function insert_staff($staff_info){
		$data = array(
			'userName' => $staff_info['userName'],
			'password' => $staff_info['password'],
			'firstName' => $staff_info['firstName'],
			'lastName' => $staff_info['lastName'],
			'email' => $staff_info['email'],
			'phone' => $staff_info['phone'],
			'isActive' => $staff_info['isActive'],
			'dateCreated' => date("Y-m-d H:i:s")
		);
		$this->db->insert('staff', $data);
	}
	public function get_staff_by_id($staffID){
		$sql = "SELECT	 staffID
						,userName
						,password
						,firstName
						,lastName
						,email
						,phone
						,isActive
						
				FROM	staff
				WHERE	staffID = ?
				"; 
		$query=$this->db->query($sql, array($staffID));
		return $query;
	}
	public function update_staff($staff_info){
		$sql = "UPDATE	staff
				SET		 userName		= '{$staff_info['userName']}'
						,password	= '{$staff_info['password']}'
						,firstName	= '{$staff_info['firstName']}'
						,lastName	= '{$staff_info['lastName']}'
						,email	= '{$staff_info['email']}'
						,phone	= '{$staff_info['phone']}'
						,isActive	= '{$staff_info['isActive']}'
						
				WHERE	staffID		= '{$staff_info['staffID']}'
				";
		$query=$this->db->query($sql, array());
		return $query;
	}
	public function delete_staff($staffID){
		$this->db->delete('staff', array('staffID'=>$staffID));
	}
}

?>