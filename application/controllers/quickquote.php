<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class QuickQuote extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('airport');
		$this->load->model('quote');
		$this->load->model('vehicle');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="req">', '</div>');
		$this->load->library('session');
	}
	public function index(){
		$this->load->view('welcome_message');
	}
	public function redirectquickquote(){
		redirect('quickquote/getquote');
	}
	public function getQuote() {
		$data['airports']=$this->quote->get_airports();
		$data['title'] = 'Get A Quote';
		$this->layout->view('quickquote/display_quote',$data);
	}
	public function saveQuote() {
		$this->load->model('vehicle');
		$data['vehicles']=$this->vehicle->get_vehicleTypes();	
		$fieldList = array('trip', 'otherlocation', 'passengers', 'pickUpLoacation', 'pickUp_airport', 'pickUp_address', 'pickUp_city', 'pickUp_state', 'pickUp_zip', 'dropOffLocation', 'dropOff_airport', 'dropOff_address', 'dropdropOff_addressLine2', 'dropOff_city', 'dropOff_state', 'dropOff_zip', 'pickUpLoacation2', 'pickUp_airport2', 'pickUp_address2', 'pickUp_addressLine2_2', 'pickUp_city2', 'pickUp_state2', 'pickUp_zip2', 'dropOffLocation_2', 'dropOff_airport2', 'dropOff_address2', 'dropOff_addressLine2_2', 'dropOff_city2', 'dropOff_state2', 'dropOff_zip2', 'vehicle');
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			$fieldsData = $_POST;
			$data['getQuote'] = $fieldsData;
			foreach($fieldList as $field){
				if(isset($fieldsData[$field])){
					${$field} = $fieldsData[$field];
				}
			}			
			if(isset($otherlocation) && $otherlocation == 1){
				//get distance for each leg fo the trip.	
				$firstLeg_distance = $this->getDistance($pickUp_airport, $pickUp_address, $pickUp_city, $pickUp_state, $pickUp_zip, $dropOff_airport, $dropOff_address, $dropOff_city, $dropOff_state, $dropOff_zip);
				$secondLeg_distance = $this->getDistance($pickUp_airport2, $pickUp_address2, $pickUp_city2, $pickUp_state2, $pickUp_zip2, $dropOff_airport2, $dropOff_address2, $dropOff_city2, $dropOff_state2, $dropOff_zip2);
				
				//get cost per leg... but pass in to getTripCost as round so we can figure out surcharges. 
				$firstLeg_tripcost = $this->getTripCost($firstLeg_distance['distance'], 'round', $firstLeg_distance['pickUp_zip'], $firstLeg_distance['dropOff_zip'], $passengers);
				$secondLeg_tripcost = $this->getTripCost($secondLeg_distance['distance'], 'round', $secondLeg_distance['pickUp_zip'], $secondLeg_distance['dropOff_zip'], $passengers);
				
				//lets store this data so we can debug
				$data['tripcost_firstLeg'] =$firstLeg_tripcost;
				$data['tripcost_secondLeg'] =$secondLeg_tripcost;
				$data['distance_firstLeg'] = $firstLeg_distance;
				$data['distance_secondLeg'] = $secondLeg_distance;
				
				//lets combine the cost as one for easy printing on next screent.
				foreach ($data['vehicles'] as $vehicles_item) {
					$firstLeg_tripcost[0][str_replace('-','_',$vehicles_item["vehicleTypeCode"])] = $firstLeg_tripcost[0][str_replace('-','_',$vehicles_item["vehicleTypeCode"])]+$secondLeg_tripcost[0][str_replace('-','_',$vehicles_item["vehicleTypeCode"])];
				}
				$data['tripcost'] =$firstLeg_tripcost;
				$data['typeType'] = 'round';
				$data['distance'] = $firstLeg_distance['distance']+$secondLeg_distance['distance'];
				$data['passengers'] = $passengers;
			}
			else if($trip == 2){
				
				//same logic as pretty much as above... 
				//but we flip pickup and drop off for our distance calcs as no seperate address is provided. 
				$firstLeg_distance = $this->getDistance($pickUp_airport, $pickUp_address, $pickUp_city, $pickUp_state, $pickUp_zip, $dropOff_airport, $dropOff_address, $dropOff_city, $dropOff_state, $dropOff_zip);
				$secondLeg_distance = $this->getDistance($dropOff_airport, $dropOff_address, $dropOff_city, $dropOff_state, $dropOff_zip,
														$pickUp_airport, $pickUp_address, $pickUp_city, $pickUp_state, $pickUp_zip 
													  );
				
				$firstLeg_tripcost = $this->getTripCost($firstLeg_distance['distance'], 'round', $firstLeg_distance['pickUp_zip'], $firstLeg_distance['dropOff_zip'], $passengers);
				$secondLeg_tripcost = $this->getTripCost($secondLeg_distance['distance'], 'round', $secondLeg_distance['pickUp_zip'], $secondLeg_distance['dropOff_zip'], $passengers);

				//store for debugging
				$data['tripcost_firstLeg'] =$firstLeg_tripcost;
				$data['tripcost_secondLeg'] =$secondLeg_tripcost;
				$data['distance_firstLeg'] = $firstLeg_distance;
				$data['distance_secondLeg'] = $secondLeg_distance;
				
				//combine the cost into one for easy printing on select_vehicle.php
				foreach ($data['vehicles'] as $vehicles_item) {
					$firstLeg_tripcost[0][str_replace('-','_',$vehicles_item["vehicleTypeCode"])] = $firstLeg_tripcost[0][str_replace('-','_',$vehicles_item["vehicleTypeCode"])]+$secondLeg_tripcost[0][str_replace('-','_',$vehicles_item["vehicleTypeCode"])];
				}
				$data['tripcost'] =$firstLeg_tripcost;
				$data['typeType'] = 'round';
				$data['distance'] = $firstLeg_distance['distance']+$secondLeg_distance['distance'];
				$data['passengers'] = $passengers;
			}
			else{
				$firstLeg_distance = $this->getDistance($pickUp_airport, $pickUp_address, $pickUp_city, $pickUp_state, $pickUp_zip, $dropOff_airport, $dropOff_address, $dropOff_city, $dropOff_state, $dropOff_zip);
				$oneway_tripcost = $this->getTripCost($firstLeg_distance['distance'], 'oneway', $firstLeg_distance['pickUp_zip'], $firstLeg_distance['dropOff_zip'], $passengers);
				//we don't need the other leg data points as only one way and th edefauls below will be enought.
				$data['typeType'] = 'oneway';
				$data['tripcost'] = $oneway_tripcost;
				$data['distance'] = $firstLeg_distance['distance'];
				$data['passengers'] = $passengers;
			}
		}
		
		
		
		if(isset($_POST['passengers'])){
		//store in session... 
		$this->session->set_userdata(Array("distance"=> $data));
		$this->layout->view('quickquote/select_vehicle',$data);
		}
		else
		{
			redirect('quickquote/getquote');
		}
		
	}
	public function getDistance($pickUp_airport, $pickUp_address, $pickUp_city, $pickUp_state, $pickUp_zip, $dropOff_airport, $dropOff_address, $dropOff_city, $dropOff_state, $dropOff_zip){
		$returnData = Array();	
		if($pickUp_airport){
			//Select Airport address from DB
			$pickUp_airport_data = $this->quote->get_airport_by_airportCode($pickUp_airport);
			$pickUp_airport_address = $pickUp_airport_data[0]['address'];
			$pickUp_airport_city = $pickUp_airport_data[0]['city'];
			$pickUp_airport_state = $pickUp_airport_data[0]['state'];
			$pickUp_airport_zip = $pickUp_airport_data[0]['zip'];
			$source = urlencode($pickUp_airport_address . ',' . $pickUp_airport_city. ',' . $pickUp_airport_state . ',' . $pickUp_airport_zip);
			$returnData['pickUp_zip'] = $pickUp_airport_zip;
		}else{
			$source = urlencode($pickUp_address . ',' . $pickUp_city. ',' . $pickUp_state . ',' . $pickUp_zip);
			$returnData['pickUp_zip'] = $pickUp_zip;
		}
		$returnData['sourceAddr'] = $source;
		if($dropOff_airport){
			//Select Airport address from DB
			$dropOff_airport_data = $this->quote->get_airport_by_airportCode($dropOff_airport);
			$dropOff_airport_address = $dropOff_airport_data[0]['address'];
			$dropOff_airport_city = $dropOff_airport_data[0]['city'];
			$dropOff_airport_state = $dropOff_airport_data[0]['state'];
			$dropOff_airport_zip = $dropOff_airport_data[0]['zip'];
			$destionation = urlencode($dropOff_airport_address . ',' . $dropOff_airport_city. ',' . $dropOff_airport_state . ',' . $dropOff_airport_zip);
			$returnData['dropOff_zip'] = $dropOff_airport_data[0]['zip'];
		}else{
			$destionation = urlencode($dropOff_address . ',' . $dropOff_city. ',' . $dropOff_state . ',' . $dropOff_zip);
			$returnData['dropOff_zip'] = $dropOff_zip;
		}
		$returnData['destionationAddr'] = $destionation;
		$url = 'https://maps.googleapis.com/maps/api/directions/json?origin=' . str_replace(' ', '', $source) . '&destination=' . str_replace(' ', '', $destionation) . '&key=AIzaSyCn8yMOqSzp_aT8H0stLwAig9fW1C5HLl8&mode=driving';
		$var = json_decode(file_get_contents($url), true);
		
		if(isset($var['routes'][0]['legs'][0]['distance']['text'])){
			$distance = ceil(substr($var['routes'][0]['legs'][0]['distance']['text'], 0, count($var['routes'][0]['legs'][0]['distance']['text']) - 3));
		}
		else{
			$distance = 0;
		}
		$returnData['distance'] = $distance;
		return $returnData; 
	}
    public function testTripCost() {
		$this->getTripCost(11, 'round', 92407, 91901);
		echo '<br>';
		$this->getTripCost(11, 'oneway', 92407, 91901);
		echo '<br>';
		$this->getTripCost(11, 'round', 91916, 92599);
		echo '<br>';   
    }
	public function getTripCost($distance, $type, $pickUp_zip, $dropOff_zip, $passengers){
		$getCost = true;
		$surcharge = 0; 
		
		if ($passengers == 3) {
			$surcharge = 10;
		} else if ($passengers == 4) {
			$surcharge = 20;
		} else if ($passengers == 5) {
			$surcharge = 30;
		} 
		
		$qryPickupSurchage = $this->quote->select_Surcharge_Pickup($pickUp_zip);
		$qryDropoffSurchage = $this->quote->select_Surcharge_Pickup( $dropOff_zip);
		if ((count($qryPickupSurchage) > 0 && $qryPickupSurchage[0]['surchargeType'] == 'personalQuoteStartsO') 
			|| (count($qryDropoffSurchage) > 0 && $qryDropoffSurchage[0]['surchargeType'] == 'personalQuoteStartsO') )
		{
			$getCost = false;
		}
		else if ((count($qryPickupSurchage) > 0 && $qryPickupSurchage[0]['surchargeType'] == 'startsOrEnds') 
			|| (count($qryDropoffSurchage) > 0 && $qryDropoffSurchage[0]['surchargeType'] == 'startsOrEnds') )
		{
			if ($type == 'oneway'){
				$surcharge += $qryPickupSurchage[0]['oneWaySurcharge'];
			} else {
				$surcharge += $qryPickupSurchage[0]['roundTripSurcharge'];
			}
		}
		elseif (count($qryPickupSurchage) > 0 &&  $qryPickupSurchage[0]['surchargeType'] == 'startsAndEnds' && count($qryDropoffSurchage) > 0 && $qryDropoffSurchage[0]['surchargeType'] == 'startsAndEnds') {
			if ($type == 'oneway'){
				$surcharge += $qryPickupSurchage[0]['oneWaySurcharge'];
			} else {
				$surcharge += $qryPickupSurchage[0]['roundTripSurcharge'];
			}	
			
		}
		elseif (count($qryPickupSurchage) > 0 &&  $qryPickupSurchage[0]['surchargeType'] == 'personalquote' && count($qryDropoffSurchage) > 0 && $qryDropoffSurchage[0]['surchargeType'] == 'personalquote') {
			$getCost = false;
		}
		
		if ($getCost == false) {
			//$distance = 0;
		}
		
		
		
		$vehiclePrices = $this->quote->select_Price_By_distance($distance, $surcharge);

		return $vehiclePrices;
	}
	public function quoteDetail(){
		$fieldList = array('trip', 'otherlocation', 'passengers', 'pickUpLoacation', 'pickUp_airport', 'pickUp_address', 'pickUp_addressLine2', 'pickUp_city', 
							'pickUp_state', 'pickUp_zip', 'dropOffLocation', 'dropOff_airport', 'dropOff_address', 'dropdropOff_addressLine2', 
							'dropOff_city', 'dropOff_state', 'dropOff_zip', 'pickUpLoacation2', 'pickUp_airport2', 'pickUp_address2', 
							'pickUp_addressLine2_2', 'pickUp_city2', 'pickUp_state2', 'pickUp_zip2', 'dropOffLocation_2', 'dropOff_airport2', 
							'dropOff_address2', 'dropOff_addressLine2_2', 'dropOff_city2', 'dropOff_state2', 'dropOff_zip2', 'vehicle');
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$_POST['pickAirportID']	 = '';
			 $_POST['dropAirportID']	 = '';
			 $_POST['pickAirportID2']	 = '';
			 $_POST['dropAirportID2']	 = '';	
			if ( !isset($_POST['otherlocation']) && $_POST['trip'] == 2) {
				 $_POST['pickUp_airport2'] = $_POST['dropOff_airport'];
				 $_POST['pickUp_address2'] = $_POST['dropOff_address'];
				 $_POST['pickUp_addressLine2_2'] = $_POST['dropOff_addressLine2'];
				 $_POST['pickUp_city2'] = $_POST['dropOff_city'];
				 $_POST['pickUp_state2'] =$_POST['dropOff_state'];
				 $_POST['pickUp_zip2'] = $_POST['dropOff_zip'];
				 $_POST['dropOff_airport2'] = $_POST['pickUp_airport'];
				 $_POST['dropOff_address2'] = $_POST['pickUp_address'];
				 $_POST['dropOff_city2'] = $_POST['pickUp_city'];
				 $_POST['dropOff_state2'] = $_POST['pickUp_state'];
				 $_POST['dropOff_zip2']	 = $_POST['pickUp_zip'];
				 
				 
			}
			$fieldsData = $_POST;
			$data['getQuote'] = $fieldsData;
			
			
			$airPorts = Array();
			foreach($fieldList as $field){
				if(isset($fieldsData[$field])){
					${$field} = $fieldsData[$field];
				}
			}
			if($pickUp_airport){
				$frmAirPort = $this->quote->get_airport_by_airportCode($pickUp_airport);
				$airPortInfo = Array("type" => "PickUp",
									 "code" => "pickup",
									 "tripleg" => "first",
									 "name" => $frmAirPort[0]['name'],
									 "address" => $frmAirPort[0]['address'],
									 "city" => $frmAirPort[0]['city'],
									 "state" => $frmAirPort[0]['state'],
									 "zip" => $frmAirPort[0]['zip'] 
								);
				array_push($airPorts, $airPortInfo);
				$_POST['pickAirportID']	 = $frmAirPort[0]['id'];
				$_POST['pickUp_address'] = $frmAirPort[0]['name'];
				$_POST['pickUp_addressLine2'] = $frmAirPort[0]['address'];
				$_POST['pickUp_city'] = $frmAirPort[0]['city'];
				$_POST['pickUp_state'] = $frmAirPort[0]['state'];
				$_POST['pickUp_zip']	 = $frmAirPort[0]['zip'];
				
			}
			if($dropOff_airport){
				$frmAirPort = $this->quote->get_airport_by_airportCode($dropOff_airport);
				$airPortInfo = Array("type" => "Dropoff",
									 "code" => "dropoff",
									 "tripleg" => "first",
									 "name" => $frmAirPort[0]['name'],
									 "address" => $frmAirPort[0]['address'],
									 "city" => $frmAirPort[0]['city'],
									 "state" => $frmAirPort[0]['state'],
									 "zip" => $frmAirPort[0]['zip'] 
								);
				array_push($airPorts, $airPortInfo);
				$_POST['dropAirportID']	 = $frmAirPort[0]['id'];
				$_POST['dropOff_address'] = $frmAirPort[0]['name'];
				$_POST['dropOff_addressLine2'] = $frmAirPort[0]['address'];
				$_POST['dropOff_city'] = $frmAirPort[0]['city'];
				$_POST['dropOff_state'] = $frmAirPort[0]['state'];
				$_POST['dropOff_zip']	 = $frmAirPort[0]['zip'];
				
			}
			if($pickUp_airport2){
				$frmAirPort = $this->quote->get_airport_by_airportCode($pickUp_airport2);
				$airPortInfo = Array("type" => "Pickup Return Trip",
									 "code" => "pickup",
									 "tripleg" => "second",
									 "name" => $frmAirPort[0]['name'],
									 "address" => $frmAirPort[0]['address'],
									 "city" => $frmAirPort[0]['city'],
									 "state" => $frmAirPort[0]['state'],
									 "zip" => $frmAirPort[0]['zip'] 
								);
				array_push($airPorts, $airPortInfo);
				$_POST['pickAirportID2']	 = $frmAirPort[0]['id'];
				$_POST['pickUp_address2'] = $frmAirPort[0]['name'];
				$_POST['pickUp_addressLine2_2'] = $frmAirPort[0]['address'];
				$_POST['pickUp_city2'] = $frmAirPort[0]['city'];
				$_POST['pickUp_state2'] = $frmAirPort[0]['state'];
				$_POST['pickUp_zip2']	 = $frmAirPort[0]['zip'];
				
			}
			if($dropOff_airport2){
				$frmAirPort = $this->quote->get_airport_by_airportCode($dropOff_airport2);
				$airPortInfo = Array("type" => "Dropoff Return Trip",
									 "code" => "dropoff",
									 "tripleg" => "second",
									 "name" => $frmAirPort[0]['name'],
									 "address" => $frmAirPort[0]['address'],
									 "city" => $frmAirPort[0]['city'],
									 "state" => $frmAirPort[0]['state'],
									 "zip" => $frmAirPort[0]['zip'] 
								);
				array_push($airPorts, $airPortInfo);
				$_POST['dropAirportID2']	 = $frmAirPort[0]['id'];
				$_POST['dropOff_address2'] = $frmAirPort[0]['name'];
				$_POST['dropOff_addressLine2_2'] = $frmAirPort[0]['address'];
				$_POST['dropOff_city2'] = $frmAirPort[0]['city'];
				$_POST['dropOff_state2'] = $frmAirPort[0]['state'];
				$_POST['dropOff_zip2']	 = $frmAirPort[0]['zip'];
				
			}
			$_POST['airports'] = $airPorts;
			$data['airports'] = $airPorts;
			$vehicleData = $this->vehicle->get_vehicle_by_type($_POST['vehicleType']);
			
			$data['vehicleName'] = $vehicleData[0]['vehicleName'];
			date_default_timezone_set('America/Los_Angeles');
			$data['year'] = date('Y');
			$this->session->set_userdata(Array("bookInfo"=> $_POST));
			$this->layout->view('quickquote/form_reservation',$data);
		}	
		else
		{
		redirect('quickquote/getquote');
		}
		
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */