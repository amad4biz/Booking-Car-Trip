<?php 

class Waybills extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url'));		
		$this->load->library('session');
		$this->session->set_userdata("breadcrumb","Way Bills");
		$this->session->set_userdata("menuItem","Way Bills");
		$this->load->model('reservation_model','',TRUE);
		$this->load->model('autoemail_model','',TRUE);
		$this->load->model('driver_model','',TRUE);
	}
	public function index()
	{
		date_default_timezone_set('America/Chicago');
		if (!isset($_REQUEST['bookingStatusID']))
		{
			$_REQUEST['bookingStatusID'] = 1;
		}
		if(isset($_REQUEST['startdate']) && strtotime($_REQUEST['startdate']) !== false){
			$data['startdate'] = $_REQUEST['startdate'];		
			$data['enddate'] =  $_REQUEST['enddate'];
		}	
		if(isset($_REQUEST['vehicleID']) && $_REQUEST['vehicleID'] > 0){
			$data['vehicleID'] = $_REQUEST['vehicleID'];		
		}
		if(isset($_REQUEST['driverID']) && $_REQUEST['driverID'] > 0){
			$data['driverID'] = $_REQUEST['driverID'];		
		}
		$data['emailStatus'] = '';
		if(isset($_REQUEST['emailStatus']) && $_REQUEST['emailStatus'] != ''){
			$data['emailStatus'] = $_REQUEST['emailStatus'];		
		}
		$data['qryBookingStatuses']=$this->reservation_model->get_booking_statuses(1);
		$data['qryVehicles']=$this->reservation_model->get_vehicles();
		$data['qryDrivers']=$this->reservation_model->get_drivers();
		$data['qryBooking'] = $this->reservation_model->get_waybills($data);
		$this->layout->view('waybill/waybill_list',$data);
	}
	public function view($bookingTripID){
		$qryBooking=(array)$this->reservation_model->get_booking_by_bookingTrip($bookingTripID)->row();	
		$qryDriver=(array)$this->driver_model->get_driver_by_id($qryBooking['driverID'])->row();
		$data['placeHolderData'] = $qryBooking;
		$data['autoEmailEventID'] = 3;
		$data['bookingTripID'] = $bookingTripID;
		$data['bookingID'] = $qryBooking['bookingID'];
		$data['toEmail'] = $qryDriver['email'];
		$data['wayBill'] = $this->autoemail_model->getAutoEmailHTML($data);	
		$this->layout->view('waybill/view_waybill', $data);
	}
	public function printWayBill($bookingID){		
		$data['action'] = 'pdf';
		$data['formAction']='';
		$data['title'] = 'View way bill';			
		$data['bookingID'] = $bookingID;
		$data['qryBooking']=(array)$this->reservation_model->get_booking($bookingID)->row();
		$data['qryBookingTrip']=$this->reservation_model->get_booking_trip($bookingID);
		$data['qryPassenger']=(array)$this->reservation_model->get_passenger($bookingID)->row();
		$data['qryBookingStatuses']=$this->reservation_model->get_booking_statuses(1);
		$data['qryAirports']=$this->reservation_model->get_airports();
		$data['qryVehicles']=$this->reservation_model->get_vehicles();
		$data['qryDrivers']=$this->reservation_model->get_drivers();
		$this->layout->view('waybill/view_waybill', $data);
	}
	public function resend($bookingTripID){
		/* $qryBooking=(array)$this->reservation_model->get_booking($bookingID)->row();
		if(isset($qryBooking['driverID']) && $qryBooking['driverID'] > 0){
			$qryDriver=(array)$this->driver_model->get_driver_by_id($qryBooking['driverID'])->row();
			$data['autoEmailEventID'] = 3;
			$data['bookingID'] = $bookingID;
			$data['toEmail'] = $qryDriver['email'];
			// Waybill to driver
			$this->autoemail_model->sendAutoEmail($data);
			$this->index();
		}*/
		$qryBooking=(array)$this->reservation_model->get_booking_by_bookingTrip($_REQUEST['bookingTripID'])->row();	
		$qryDriver=(array)$this->driver_model->get_driver_by_id($_REQUEST['driverID'])->row();
		$data['placeHolderData'] = $qryBooking;
		$data['autoEmailEventID'] = 3;
		$data['bookingTripID'] = $_REQUEST['bookingTripID'];
		$data['bookingID'] = $qryBooking['bookingID'];
		$data['toEmail'] = $qryDriver['email'];
		// Waybill to driver
		$this->autoemail_model->sendAutoEmail($data);		
		
	}
}
