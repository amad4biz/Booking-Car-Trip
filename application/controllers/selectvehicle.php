<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SelectVehicle extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}
	public function select_vehicle() {
		$this->load->helper('form');
		$this->load->model('airport');
		$data['airports']=$this->airport->get_airports();
		$this->layout->view('quickquote/select_vehicle.php',$data);
	}
	public function saveQuote() {
//		require_once('book/includes/inc_dbi.php');
//		require_once('book/includes/inc_functions.php');
//		require('book/includes/inc_query.php'); 
		/*$fieldList = array('trip', 'otherlocation', 'passengers', 'pickUpLoacation', 'pickUp_airport', 'pickUp_address', 'pickUp_addressLine2', 'pickUp_city', 'pickUp_state', 'pickUp_zip', 'dropOffLocation', 'dropOff_airport', 'dropOff_address', 'dropdropOff_addressLine2', 'dropOff_city', 'dropOff_state', 'dropOff_zip', 'pickUpLoacation2', 'pickUp_airport2', 'pickUp_address2', 'pickUp_addressLine2_2', 'pickUp_city2', 'pickUp_state2', 'pickUp_zip2', 'dropOffLocation_2', 'dropOff_airport2', 'dropOff_address2', 'dropOff_addressLine2_2', 'dropOff_city2', 'dropOff_state2', 'dropOff_zip2', 'vehicle');
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$data = $_POST;
			echo '<pre>';
			print_r($data);
			echo '</pre>';
			die();
		}*/
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */