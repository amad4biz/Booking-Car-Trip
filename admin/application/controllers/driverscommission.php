<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DriversCommission extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="req">', '</div>');
		
		$this->load->library('session');
		//loading model
		$this->load->model('driverscommission_model','',TRUE);
		$this->load->model('driver_model','',TRUE);
		
	}
	
	function _remap($method,$args)
	{
		if (method_exists($this, $method))
		{
			$this->$method($args);
		}
		else
		{
			$this->index($method,$args);
		}
	}
	// list drivers
	public function index(){
		
		//$data['driver'] = $this->driverscommission_model->get_driver();
		if(isset($_GET['driverID'])){
		$data['driverID'] = $_GET['driverID'];
		}
		if(isset($_GET['driverId'])){
		$data['driverID'] = $_GET['driverId'];
		}
		if (!isset($_REQUEST['startDate'])){
			$_REQUEST['startDate'] = '';
		}
		if (!isset($_REQUEST['endDate'])){
			$_REQUEST['endDate'] = '';
			$_REQUEST['endDate'] =  date('m/d/Y');
			$_REQUEST['startDate'] = date('m/d/Y',strtotime($_REQUEST['endDate']." -15 day"));		
		}
		$data['startDate'] = $_REQUEST['startDate'];
		$data['endDate'] = $_REQUEST['endDate'];
		
		$data['qryDrivers']=$this->driverscommission_model->get_drivers();
		$data['driverscommission'] = $this->driverscommission_model->get_driversBookingCommissions($data);
		$data['driverscommissionTotal'] = $this->driverscommission_model->get_driversBookingTotal($data);
		$data['driverscommissiondata'] = $this->driverscommission_model->get_driverscommission_by_driverID($data);
		$data['Driver']=(array)$this->driver_model->get_driver_by_id($data['driverID'])->row();
		$this->layout->view('driverscommission/listDriverscommission', $data);
	}
	// edit driver
	public function commission($driverID = NULL) {
	$driverID = $_GET['driverID'];	
	if ($driverID > 0) {
			$data['driverscommission'] = $this->driverscommission_model->get_driversBooking($driverID);
			$this->layout->view('driverscommission/listDriverscommission', $data);
		}
	}
	//Add new commission
	public function edit($driverID = NULL, $driverscommissionID = NULL) {
	if(isset($_GET['driverID'])){
		$driverID  = $_GET['driverID'];
		}
		if(isset($_GET['driverId'])){
		$driverID  = $_GET['driverId'];
		}	
		$driverscommissionID = $_GET['driverscommissionID'];
		
			$data['action']=site_url('driverscommission/saveCommission/?driverscommissionID='. $driverscommissionID);
			//$this->_set_rules();
			if($driverscommissionID > 0){
			$data['title']="Edit Drivers Commission";
			$data['driverscommission']=(array)$this->driverscommission_model->get_driverscommission_by_id($driverscommissionID)->row();
			//$data['driverscommission'] = $this->driverscommission_model->add_driversCommission($driverID);
			//$this->layout->view('driverscommission/listDriverscommission', $data);
			}else{
				$data['title']="New Drivers Commission";
				$data['driverscommission']=array(
					'driverID'	=> $driverID,
					'driverscommissionID'	=> 0 ,
					'commission' => '',
					'startDate' => '',
					'endDate' => '',
					'isActive' => ''
				);
			}
			$this->layout->view('driverscommission/formDriverscommission', $data);
		
	}

	public function saveCommission($driverscommissionID=null) {
		$driverscommissionID = $_POST['driverscommissionID'];
		//$this->_set_fields();
		if ($driverscommissionID > 0) {
			$data['title']="Edit Drivers Commission";
		} else {
			$data['title']="New Drivers Commission";
		}
		$data['action']=site_url('driverscommission/saveCommission/'. $driverscommissionID);
		//$this->_set_rules();
		$driver_info = array(
			'driverscommissionID' => $this->input->post('driverscommissionID'),
	        'driverID' => $this->input->post('driverID'),
			'commission' => $this->input->post('commission'), 
	        'startDate' => $this->input->post('startDate'), 
	        'endDate' => $this->input->post('endDate'), 
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
		$data['driverscommission']=$driver_info;
		$isCommisionExists = $this->driverscommission_model->isDriversCommissionExists($driver_info);
		//$blnSuccess=$this->form_validation->run();
		if($isCommisionExists == false && $this->input->post('commission') < 101){
			$blnSuccess = true ;
		}
		else{
			$blnSuccess = false ;
		}
		$data['blnSuccess']=$blnSuccess;
		if ($blnSuccess){
		//$data['checkDuplicate'] = $this->driverscommission_model->checkDuplicate_driverscommission($driver_info);
		if ($driverscommissionID > 0) {
				$this->driverscommission_model->update_driverscommission($driver_info);
			} else {
				$this->driverscommission_model->insert_driverscommission($driver_info);
			}
		}
		if ($blnSuccess) {
			redirect('driverscommission/?driverId=' . $driver_info['driverID']);
		} else {
			$data['driverscommission']=array(
				'driverID'	=> $this->input->post('driverID'),
				'driverscommissionID'	=> $this->input->post('driverscommissionID') ,
				'commission' => $this->input->post('commission'),
				'startDate' => $this->input->post('startDate'),
				'endDate' => $this->input->post('endDate'),
				'formattedStartDate' => $this->input->post('startDate'),
				'formattedEndDate' => $this->input->post('endDate'),
				'isActive' => 1
			);
			$this->layout->view('driverscommission/formDriverscommission', $data);
		}
	}
	
	
	/*function _set_rules(){
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
	}*/
	
	public function delete($driverscommissionID = NULL) {
		$driverscommissionID = $_GET['driverscommissionID'];
		$this->load->model('driverscommission_model');
		$data=(array)$this->driverscommission_model->get_driverscommission_by_id($driverscommissionID)->row();
		$delete=$this->driverscommission_model->delete_driverscommission($driverscommissionID);
		redirect('driverscommission/?driverId=' . $data['driverID']);
	}
}
?>
