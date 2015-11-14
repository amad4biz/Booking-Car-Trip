<?php
class Airport extends CI_Model {

	public function __construct()
	{
		// Call the Model constructor
        parent::__construct();
	}
	/* === Gateway === */
	public function get_airports($sort_by="sortOrder",$sorder="ASC") {
		$query = $this->db->query('SELECT id,name,airport_code,address2 FROM airports ORDER BY '.$sort_by.' '.$sorder);
		return $query->result_array();
	}
	/* === DAO === */
}
?>