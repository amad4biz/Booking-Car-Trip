<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Driver extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="req">', '</div>');
		
		$this->load->library('session');
		$this->session->set_userdata("breadcrumb","Drivers");
		$this->session->set_userdata("menuItem","Drivers");
		//loading model
		$this->load->model('driver_model','',TRUE);
	}
	// list drivers
	public function index(){
		date_default_timezone_set('America/Chicago');
		if (!isset($_REQUEST['isActive'])){
			$_REQUEST['isActive'] = 1;
		}
		if (!isset($_REQUEST['keyword'])){
			$_REQUEST['keyword'] = '';
		}
		$data['keyword'] = $_REQUEST['keyword'];
		$data['isActive'] = $_REQUEST['isActive'];
		$data['driver'] = $this->driver_model->get_driver($data);
		$this->layout->view('driver/listDriver', $data);
	}
	// edit driver
	public function edit($driverID = NULL) {
		
		$data['action']=site_url('driver/save/'. $driverID);
		$this->_set_rules();
		if ($driverID > 0) {
			// lets query db and get the data
			$data['title']="Edit Driver";
			$data['Driver']=(array)$this->driver_model->get_driver_by_id($driverID)->row();
		} else {
			$data['title']="New Driver";
			$data['Driver']=array(
				'driverID'	=> $driverID,
				'firstName' => '',
				'lastName' => '',
				'email' => '',
				'phone'	=> '',
				'isActive' => 1,
				'Address'	=> '',
				'City'	=> '',
				'State'	=> '',
				'zipCode'	=> '',
				'socialSecurity'	=> '',
				'license'	=> '',
				'bankName'	=> '',
				'bankAccount'	=> '',
			);
		}
		$this->layout->view('driver/formDriver', $data);
	}
	
	public function save($driverID=null) {
		//$this->_set_fields();
		if ($driverID > 0) {
			$data['title']="Edit Driver";
		} else {
			$data['title']="New Driver";
		}
		$data['action']=site_url('driver/save/'. $driverID);
		
        $this->_set_rules();
		$driver_info = array(
			'driverID' => $this->input->post('driverID'),
	        'firstName' => $this->input->post('firstName'),
	        'lastName' => $this->input->post('lastName'), 
	        'email' => $this->input->post('email'), 
	        'phone' => $this->input->post('phone'), 
	        'isActive' => $this->input->post('isActive'),
			'Address' => $this->input->post('Address'),
			'City' => $this->input->post('City'),
			'State' => $this->input->post('State'),
			'zipCode' => $this->input->post('zipCode'),
			'socialSecurity' => $this->input->post('socialSecurity'),
			'license' => $this->input->post('license'),
			'bankName' => $this->input->post('bankName'),
			'bankAccount' => $this->input->post('bankAccount'),
		);
		$data['Driver']=$driver_info;
		
		//$blnSuccess=$this->form_validation->run();
		$blnSuccess = true;
		$data['blnSuccess']=$blnSuccess;
		
		if ($blnSuccess){
			
			if ($driverID > 0) {
				$this->driver_model->update_driver($driver_info);
			} else {
				$this->driver_model->insert_driver($driver_info);
			}
		}
		
		if ($blnSuccess) {
			redirect('driver/index/' . $driverID);
		} else {
			$this->layout->view('driver/formDriver', $data);
		}
	}
	
	function _set_rules(){
		//Rules
		$fields = array(
			array(
            	'field'   => 'Address', 
                'label'   => 'Address', 
                'rules'   => 'htmlspecialchars|trim|required|xss_clean'
			),
			array(
            	'field'   => 'City', 
                'label'   => 'City', 
                'rules'   => 'htmlspecialchars|trim|required|xss_clean'
			),
			array(
            	'field'   => 'State', 
                'label'   => 'State', 
                'rules'   => 'htmlspecialchars|trim|required|xss_clean'
			),
			array(
            	'field'   => 'zipCode', 
                'label'   => 'Zip Code', 
                'rules'   => 'htmlspecialchars|trim|required|xss_clean'
			),
			array(
            	'field'   => 'socialSecurity', 
                'label'   => 'Social Security', 
                'rules'   => 'htmlspecialchars|trim|required|xss_clean'
			),
			array(
            	'field'   => 'license', 
                'label'   => 'license', 
                'rules'   => 'htmlspecialchars|trim|required|xss_clean'
			),
			array(
            	'field'   => 'bankName', 
                'label'   => 'Bank Name', 
                'rules'   => 'htmlspecialchars|trim|required|xss_clean'
			),
			array(
            	'field'   => 'bankAccount', 
                'label'   => 'Bank Account', 
                'rules'   => 'htmlspecialchars|trim|required|xss_clean'
			),
			array(
            	'field'   => 'commission', 
                'label'   => 'Commission', 
                'rules'   => 'htmlspecialchars|trim|required|xss_clean'
			),
			array(
            	'field'   => 'isActive', 
                'label'   => 'Active', 
                'rules'   => 'htmlspecialchars|trim|required|xss_clean'
			),
            array(
            	'field'   => 'firstName', 
                'label'   => 'First Name', 
                'rules'   => 'htmlspecialchars|trim|required|xss_clean'
			),
            array(
            	'field'   => 'lastName', 
                'label'   => 'Last Name', 
                'rules'   => 'htmlspecialchars|trim|required|xss_clean'
			),   
            array(
            	'field'   => 'email', 
                'label'   => 'Email', 
                'rules'   => 'htmlspecialchars|trim|required|valid_email'
			),
			array(
            	'field'   => 'phone', 
                'label'   => 'Phone', 
                'rules'   => 'htmlspecialchars|trim|required|xss_clean'
			)
		);
		$this->form_validation->set_rules($fields);
	}
	
	public function delete_driver($driverID = NULL) {
		$this->load->model('driver_model');
		$delete=$this->driver_model->delete_driver($driverID);
		redirect('driver/index/delete_'.$driverID);
	}
}
?>
