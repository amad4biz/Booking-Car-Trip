<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehicle extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="req">', '</div>');
		
		$this->load->library('session');
		$this->session->set_userdata("breadcrumb","Vehicles");
		$this->session->set_userdata("menuItem","Vehicles");		
		//loading model
		$this->load->model('vehicle_model','',TRUE);
	}
	//list Vehicle
	public function index(){
		$data['vehicle'] = $this->vehicle_model->get_vehicle();
		$this->layout->view('vehicle/vehicle_list', $data);
	}
	// edit vehicle
	public function edit($vehicleID = NULL) {
		
		$data['action']=site_url('vehicle/save/'. $vehicleID);
		$data['driver'] = $this->vehicle_model->get_driver();
		$data['vehicleType'] = $this->vehicle_model->get_vehicleType();
		$this->_set_rules();
		if ($vehicleID > 0) {
			// lets query db and get the data
			$data['title']="Edit Vehicle";
			$data['vehicle']=(array)$this->vehicle_model->get_vehicle_by_id($vehicleID)->row();
		} else {
			$data['title']="New Vehicle";
			$data['vehicle']=array(
				'vehicleID'	=> $vehicleID,
				'vehicleTypeID' => '',
				'driverID' => ''
			);
		}
		$this->layout->view('vehicle/formVehicle', $data);
	}
	
	public function save($vehicleID=null) {
		//$this->_set_fields();
		if ($vehicleID > 0) {
			$data['title']="Edit Vehicle";
		} else {
			$data['title']="New Vehicle";
		}
		$data['action']=site_url('vehicle/save/'. $vehicleID);
		
        $this->_set_rules();
		$vehicle_info = array(
	        'vehicleName' => $this->input->post('vehicleName'),
			'vehiclePlate' => $this->input->post('vehiclePlate'),
	        'vehicleCode' => $this->input->post('vehicleCode'),
			'make' => $this->input->post('make'),
			'model' => $this->input->post('model'),
			'year' => $this->input->post('year'),
	        'vehicleTypeID' => $this->input->post('vehicleTypeID'), 
	        'driverID' => $this->input->post('driverID'),
			'vehicleID' => $this->input->post('vehicleID')
		);
		$data['vehicle']=$vehicle_info;
		
		$blnSuccess=$this->form_validation->run();
		
		$data['blnSuccess']=$blnSuccess;
		
		if ($blnSuccess){
			
			if ($vehicleID > 0) {
				$this->vehicle_model->update_vehicle($vehicle_info);
			} else {
				$this->vehicle_model->insert_vehicle($vehicle_info);
			}
		}
		
		if ($blnSuccess) {
			redirect('vehicle/index/' . $vehicleID);
		} else {
			$this->layout->view('vehicle/formVehicle', $data);
		}
	}
	
	function _set_rules(){
		//Rules
		$fields = array(
			array(
            	'field'   => 'vehiclePlate', 
                'label'   => 'Vehicle Plate', 
                'rules'   => 'htmlspecialchars|trim|required|xss_clean'
			),
			array(
            	'field'   => 'vehicleName', 
                'label'   => 'Vehicle Name', 
                'rules'   => 'htmlspecialchars|trim|required|xss_clean'
			),
			array(
            	'field'   => 'make', 
                'label'   => 'Make', 
                'rules'   => 'htmlspecialchars|trim|required|xss_clean'
			),
			array(
            	'field'   => 'model', 
                'label'   => 'Model', 
                'rules'   => 'htmlspecialchars|trim|required|xss_clean'
			),
			array(
            	'field'   => 'year', 
                'label'   => 'Year', 
                'rules'   => 'htmlspecialchars|trim|required|xss_clean'
			),
            array(
            	'field'   => 'vehicleTypeID', 
                'label'   => 'Vehicle Type', 
                'rules'   => 'htmlspecialchars|trim|required'
			)
		);
		$this->form_validation->set_rules($fields);
	}
	public function delete_vehicle($vehicleID = NULL) {
		$delete=$this->vehicle_model->delete_vehicle($vehicleID);
		redirect('vehicle/index/delete_'.$vehicleID);
	}
}
