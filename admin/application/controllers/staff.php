<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Staff extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="req">', '</div>');
		
		$this->load->library('session');
		$this->session->set_userdata("breadcrumb","Staff");
		$this->session->set_userdata("menuItem","Staff");
		//loading model
		$this->load->model('staff_model','',TRUE);
	}
	//list Vehicle
	public function index(){
		$data['staff'] = $this->staff_model->get_staff();
		$this->layout->view('staff/listStaff', $data);
	}
	// edit vehicle
	public function edit($staffID = NULL) {
		
		$data['action']=site_url('staff/save/'. $staffID);
		$this->_set_rules();
		if ($staffID > 0) {
			// lets query db and get the data
			$data['title']="Edit Staff";
			$data['staff']=(array)$this->staff_model->get_staff_by_id($staffID)->row();
		} else {
			$data['title']="New Staff";
			$data['staff']=array(
				'staffID'	=> $staffID,
				'userName' => '',
				'password' => '',
				'firstName' => '',
				'lastName' => '',
				'email' => '',
				'phone' => '',
				'isActive' => 1
			);
		}
		$this->layout->view('staff/formStaff', $data);
	}
	
	public function save($staffID=null) {
		//$this->_set_fields();
		if ($staffID > 0) {
			$data['title']="Edit Staff";
		} else {
			$data['title']="New Staff";
		}
		$data['action']=site_url('staff/save/'. $staffID);
		
        $this->_set_rules();
		$staff_info = array(
	        'staffID' => $this->input->post('staffID'),
	        'userName' => $this->input->post('userName'), 
	        'password' => $this->input->post('password'),
			'firstName' => $this->input->post('firstName'),
			'lastName' => $this->input->post('lastName'),
			'email' => $this->input->post('email'),
			'phone' => $this->input->post('phone'),
			'isActive' => $this->input->post('isActive')
		);
		$data['staff']=$staff_info;
		
		$blnSuccess=$this->form_validation->run();
		
		$data['blnSuccess']=$blnSuccess;
		
		if ($blnSuccess){
			
			if ($staffID > 0) {
				$this->staff_model->update_staff($staff_info);
			} else {
				$this->staff_model->insert_staff($staff_info);
			}
		}
		
		if ($blnSuccess) {
			redirect('staff/index/' . $staffID);
		} else {
			$this->layout->view('staff/formStaff', $data);
		}
	}
	
	function _set_rules(){
		//Rules
		$fields = array(
			array(
            	'field'   => 'userName', 
                'label'   => 'User Name', 
                'rules'   => 'htmlspecialchars|trim|required|xss_clean'
			),
            array(
            	'field'   => 'password', 
                'label'   => 'Password', 
                'rules'   => 'htmlspecialchars|trim|required|min_length[4]'
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
                'rules'   => 'htmlspecialchars|trim|required'
			),
            array(
            	'field'   => 'isActive', 
                'label'   => 'Status', 
                'rules'   => 'htmlspecialchars|trim|required'
			)
		);
		$this->form_validation->set_rules($fields);
	}
	public function delete_staff($staffID = NULL) {
		$delete=$this->staff_model->delete_staff($staffID);
		redirect('staff/index/delete_'.$staffID);
	}
}
