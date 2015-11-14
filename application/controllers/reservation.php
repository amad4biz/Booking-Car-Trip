<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reservation extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//loading model
		$this->load->model('Reservation_model','',TRUE);
		$this->load->model('autoemail_model','',TRUE);
		$this->load->model('vehicle');
	}
	public function save() {
		$bookInfo = $this->session->userdata('bookInfo');
		$this->Reservation_model->save();
		if($_REQUEST['success'] == true && $_REQUEST['bookingID'] > 0){
			$data['qryVehicle']=$this->vehicle->get_vehicle_by_type($bookInfo['vehicleType']);
			if($_POST['paymentMethod']=="CC")
            {
                $data['autoEmailEventID'] = 1;
			} else if($_POST['paymentMethod']=="CA")
            {
                $data['autoEmailEventID'] = 5;
            }
            $data['trip'] = 1;
            if ($_POST['trip'] == 2){
                $data['trip'] = 2;
                $data['pickUp_address'] = $_POST['pickUp_address'];
                $data['dropOff_address'] = $_POST['dropOff_address'];
                $data['pickUp_address2'] = $_POST['pickUp_address2'];
                $data['dropOff_address2'] = $_POST['dropOff_address2'];   
            }
            $data['bookingID'] = $_REQUEST['bookingID'];
			$data['toEmail'] = $_POST['emailAddress'];
			if(isset($_REQUEST['diffOfHours']) && $_REQUEST['diffOfHours'] < 12){
				$data['lessThen12Hours'] = true;
			}
			else{
				$data['lessThen12Hours'] = false;
			}
			// Book Now Email
			$this->autoemail_model->sendAutoEmail($data);
		}	
	}
	
	public function thank_message(){
		date_default_timezone_set('America/Los_Angeles');
		$data['title'] = 'Confirmation';
		if ($this->session->userdata('pickUpdateDate'))
		{
			$data['pickDateTime'] = date("Y-m-d H:i:s", strtotime($this->session->userdata('pickUpdateDate')));
		}
		else
		{
			$data['pickDateTime'] = date("Y-m-d H:i:s", strtotime('+2 hours'));
		}
		$this->layout->view('quickquote/thank_message', $data);
	}
}
