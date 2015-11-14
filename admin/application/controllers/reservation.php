<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reservation extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="req">', '</div>');
		$this->load->helper('cookie');
		$this->load->library('session');
		$this->session->set_userdata("breadcrumb","Reservations");
		$this->session->set_userdata("menuItem","Reservations");
		//loading model
		$this->load->model('reservation_model','',TRUE);
		$this->load->model('autoemail_model','',TRUE);
		$this->load->model('driver_model','',TRUE);
		$this->load->model('vehicle_model','',TRUE);
	}
	public function pending(){
		date_default_timezone_set('America/Chicago');
		$_REQUEST['bookingStatusID'] = 1;
		$_REQUEST['startdate'] = date('m/d/Y');		
		$_REQUEST['enddate'] =  date('m/d/Y',strtotime($_REQUEST['startdate']." +1 day") );
		$_REQUEST['startdate'] = $_REQUEST['enddate'];
		$this->index();
	}
	public function confirmed(){
		date_default_timezone_set('America/Chicago');
		$_REQUEST['bookingStatusID'] = 2;
		$_REQUEST['startdate'] = date('m/d/Y');		
		$_REQUEST['enddate'] =  date('m/d/Y',strtotime($_REQUEST['startdate']." +1 day") );
		$_REQUEST['startdate'] = $_REQUEST['enddate'];
		$this->index();
	}
	//list reservation
	public function index(){
		date_default_timezone_set('America/Chicago');
		if (!isset($_REQUEST['bookingStatusID']))
		{
			$_REQUEST['bookingStatusID'] = 1;
		}
		if(isset($_REQUEST['startdate']) && strtotime($_REQUEST['startdate']) !== false){
			$data['startdate'] = $_REQUEST['startdate'];		
			$data['enddate'] =  $_REQUEST['enddate'];
		}
		else{
			$data['startdate'] = date('m/d/Y');		
			$data['enddate'] =  date('m/d/Y',strtotime($data['startdate']." +7 day") );
		}	
		if(isset($_REQUEST['vehicleID']) && $_REQUEST['vehicleID'] > 0){
			$data['vehicleID'] = $_REQUEST['vehicleID'];		
		}
		if(isset($_REQUEST['driverID']) && $_REQUEST['driverID'] > 0){
			$data['driverID'] = $_REQUEST['driverID'];		
		}
		if(isset($_REQUEST['bookingStatusID']) && $_REQUEST['bookingStatusID'] > 0){
			$data['bookingStatusID'] = $_REQUEST['bookingStatusID'];		
		}
		$data['qryVehicles']=$this->reservation_model->get_vehicles();
		$data['qryDrivers']=$this->reservation_model->get_drivers();
		$data['qryBooking'] = $this->reservation_model->get_bookings($data);
		$data['qryBookingStatuses']=$this->reservation_model->get_booking_statuses(1);
		$this->session->set_userdata("reservationReturnTo","list");
		$this->layout->view('reservation/reservation_list', $data);
	}
	public function calendar(){
		$data = 1;
		$this->session->set_userdata("reservationReturnTo","calendar");
		$this->layout->view('reservation/reservation_calendar', $data);
	}
	public function bookings(){
		$this->reservation_model->get_booking_json();
	}
	public function edit($bookingID = NULL){
		$data['title'] = 'New Reservation';
		$data['formAction']=site_url('reservation/insert/');
		$data['action'] = 'blank';
		$data['bookingID'] = $bookingID;
		$data['qryBooking']=(array)$this->reservation_model->get_booking($bookingID)->row();
		$data['qryBookingTrip']=$this->reservation_model->get_booking_trip($bookingID);
		$data['qryPassenger']=(array)$this->reservation_model->get_passenger($bookingID)->row();
		$data['qryBookingStatuses']=$this->reservation_model->get_booking_statuses(1);
		$data['qryAirports']=$this->reservation_model->get_airports();
		$data['qryVehicles']=$this->reservation_model->get_vehicles();
		$data['qryDrivers']=$this->reservation_model->get_drivers();
		$data['vehicleType'] = $this->vehicle_model->get_vehicleType();
		$this->_set_rules();
		if ($bookingID > 0) {
			$data['action'] = 'query';
			$data['formAction']=site_url('reservation/update/');
			$data['title'] = 'Edit Reservation';			
		}
		$this->layout->view('reservation/form_reservation', $data);
	}
	public function duplicate($bookingID = NULL){
		$data['title'] = 'New Reservation';
		$data['formAction']=site_url('reservation/insert/');
		$data['action'] = 'duplicate';
		$data['qryBooking']=(array)$this->reservation_model->get_booking($bookingID)->row();		
		$data['qryBookingTrip']=$this->reservation_model->get_booking_trip($bookingID);			
		$data['qryPassenger']=(array)$this->reservation_model->get_passenger($bookingID)->row();
		$data['qryBookingStatuses']=$this->reservation_model->get_booking_statuses(1);
		$data['qryAirports']=$this->reservation_model->get_airports();
		$data['qryVehicles']=$this->reservation_model->get_vehicles();
		$data['qryDrivers']=$this->reservation_model->get_drivers();
		$data['vehicleType'] = $this->vehicle_model->get_vehicleType();
		$data['bookingID'] = 0;
		$this->_set_rules();
		
		$this->layout->view('reservation/form_reservation', $data);
	}
	public function insert(){
		$bookingID = $this->reservation_model->insert();
		// when booking is save as draft
		if($_POST['bookingStatusID'] == 3||isset($_POST['draft'])){
			redirect('reservation/index/?bookingStatusID=' . $_POST['bookingStatusID']);
		}
		else if($bookingID > 0){
			$qryBooking=(array)$this->reservation_model->get_booking($bookingID)->row();
			if($_POST['paymentMethod']=="CC")
            {
                $data['autoEmailEventID'] = 1;
			} else if($_POST['paymentMethod']=="CASH")
            {
                $data['autoEmailEventID'] = 5;
            }
            $data['bookingID'] = $bookingID;
			$data['toEmail'] = $_POST['emailAddress'];
			// Book Now Email
			$this->autoemail_model->sendAutoEmail($data);
			/* if(isset($_POST['driverID']) && $_POST['driverID'] > 0){
				$qryDriver=(array)$this->driver_model->get_driver_by_id($_POST['driverID'])->row();
				$data['autoEmailEventID'] = 3;
				$data['bookingID'] = $bookingID;
				$data['toEmail'] = $qryDriver['email'];
				// Waybill to driver
				$this->autoemail_model->sendAutoEmail($data);					
				// Booking detail to driver				
				$data['autoEmailEventID'] = 4;
				$this->autoemail_model->sendAutoEmail($data);					
			}
			if(isset($_POST['bookingStatusID']) && $_POST['bookingStatusID'] == 2){
				$data['autoEmailEventID'] = 2;
				$data['bookingID'] = $bookingID;
				$data['toEmail'] = $_POST['emailAddress'];
				// Reservation Confirmation Email
				$this->autoemail_model->sendAutoEmail($data);					
			} */
			if($this->session->userdata("reservationReturnTo") == 'calendar'){
				redirect('reservation/calendar');
			}
			else{
				redirect('reservation/index/?bookingStatusID=' . $_POST['bookingStatusID']);
			}
		}
		else{
			echo 'error';
		}
	}
	public function update(){
		$qryBooking=(array)$this->reservation_model->get_booking($_POST['bookingID'])->row();
		$result = $this->reservation_model->update();
//	    if(isset($_POST['driverID']) && $_POST['driverID'] > 0 && $_POST['driverID'] != $qryBooking['driverID']){
        if(isset($_REQUEST['driverID']) && $_REQUEST['driverID'] > 0){
			$qryDriver=(array)$this->driver_model->get_driver_by_id($_REQUEST['driverID'])->row();
			$data['autoEmailEventID'] = 3;
			$data['bookingID'] = $_POST['bookingID'];
			$data['toEmail'] = $qryDriver['email'];  
			// Waybill to driver
			$this->autoemail_model->sendAutoEmail($data);	
			// Booking detail to driver				 
			$data['autoEmailEventID'] = 4;
			$this->autoemail_model->sendAutoEmail($data);					
		}
        if($qryBooking['paymentMethod'] == "CC")
        {
            $data['autoEmailEventID'] = 1;
        } else if($qryBooking['paymentMethod'] == "CASH"||$qryBooking['paymentMethod'] == "CA")
        {
            $data['autoEmailEventID'] = 5;
        }
        $data['bookingID'] = $_POST['bookingID'];
        $data['toEmail'] = $_POST['emailAddress'];
        // Book Now Email
        $this->autoemail_model->sendAutoEmail($data);
                                                    
		/* if(isset($_POST['bookingStatusID']) && $_POST['bookingStatusID'] == 2 && $_POST['bookingStatusID'] != $qryBooking['bookingStatusID']){
			$data['autoEmailEventID'] = 2;
			$data['bookingID'] = $_POST['bookingID'];
			$data['toEmail'] = $qryBooking['emailAddress'];
			// Reservation Confirmation Email
			$this->autoemail_model->sendAutoEmail($data);					
		} */
		if($result == true){
			if($this->session->userdata("reservationReturnTo") == 'calendar'){
				redirect('reservation/calendar');
			}
			else{
				redirect('reservation/index/?bookingStatusID=' . $_POST['bookingStatusID']);
			}
		}
		else{
			echo 'error';
		}
	}
	public function updateDriver(){
		$this->reservation_model->updateDriver();
		$qryBooking=(array)$this->reservation_model->get_booking_by_bookingTrip($_REQUEST['bookingTripID'])->row();	
		
		//if(isset($_POST['driverID']) && $_POST['driverID'] > 0 && $_POST['driverID'] != $qryBooking['driverID']){
			$qryDriver=(array)$this->driver_model->get_driver_by_id($_REQUEST['driverID'])->row();
			$data['placeHolderData'] = $qryBooking;
			$data['autoEmailEventID'] = 3;
			$data['bookingTripID'] = $_REQUEST['bookingTripID'];
			$data['bookingID'] = $qryBooking['bookingID'];
			$data['toEmail'] = $qryDriver['email'];
			// Waybill to driver
			$this->autoemail_model->sendAutoEmail($data);	
		//}
		echo 'Updated';
	}
	public function updateVehicle(){
		$this->reservation_model->updateVehicle();
	}
	public function updateBookingStatus(){
		$this->reservation_model->updateBookingStatus();
	}
	public function get_cost_table(){
		$this->reservation_model->resetAddresses();
		$data['cost']=$this->reservation_model->getCost();
		$this->layout->view('reservation/dsp_tripcost', $data);
	}
	function _set_rules(){
		//Rules
		$fields = array();
		$this->form_validation->set_rules($fields);
	}
}
