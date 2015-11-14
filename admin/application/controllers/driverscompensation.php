<?php 

class Driverscompensation extends MY_Controller {
	public function __construct(){
		parent::__construct();
		//$this->load->helper(array('form', 'url'));
		//$this->load->library('form_validation');
		//$this->form_validation->set_error_delimiters('<div class="req">', '</div>');
		
		$this->load->library('session');
		//loading model
		$this->load->model('driver_model','',TRUE);
		$this->load->model('driverscompensation_model','',TRUE);
	}
	/*public function index()
	{
		$this->layout->view('drivercompensation/listDriverCompensation');
	}*/
	public function index(){
		if(isset($_GET['driverID'])){
		$driverID = $_GET['driverID'];
		}
		if(isset($_GET['driverId'])){
		$driverID = $_GET['driverId'];
		}
		if (!isset($_REQUEST['driverscommissionID'])){
			$_REQUEST['driverscommissionID'] = 1;
		}
		if (!isset($_REQUEST['startDate'])){
			$_REQUEST['startDate'] = '';
		}
		if (!isset($_REQUEST['endDate'])){
			$_REQUEST['endDate'] = '';
		}
		$data['driverscommissionID'] = $_REQUEST['driverscommissionID'];
		$data['endDate'] = $_REQUEST['endDate'];
		$data['startDate'] = $_REQUEST['startDate'];
		$data['driver'] = $this->driver_model->get_driver($data);
		
		//$data['driverscompensation'] = $this->driverscompensation_model->get_driver();
		//$this->layout->view('driverscompensation/listdriverscompensation', $data);
		$data['Driver']=(array)$this->driver_model->get_driver_by_id($driverID)->row();
		$data['driverscompensation'] = $this->driverscompensation_model->get_driverscompensation($driverID);
		$data['driverscompensationTotal'] = $this->driverscompensation_model->get_driverscompensationTotal($driverID);
		$this->layout->view('driverscompensation/listdriverscompensation', $data);
	}
}
