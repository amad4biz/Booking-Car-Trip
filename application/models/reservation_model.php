<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reservation_model extends CI_Model {

	public function __construct(){
		$this->load->library('session');
	}
	private function checkReservationInterval($pickupDate,$pickupTime){
		$first_date = new DateTime(date ("Y-m-d H:i:s", strtotime($pickupDate . ' ' . $pickupTime)));
		$second_date = new DateTime(date("Y-m-d H:i:s"));
		$difference = $first_date->diff($second_date);
		if($first_date > $second_date){
			if( $difference->format("%d") == 0 && $difference->format("%h") < 12){
				return false;
			}
			else{
				return true;
			}
		}
		else{
			return false;
		}
	}
	public function save(){
		if($_POST['pickupTime']=='123') $_POST['pickupTime']=$_POST['flightTime_pickup_first'];
        	if(isset($_POST['pickupTime_return'])&&$_POST['pickupTime_return']=='234') $_POST['pickupTime_return']=$_POST['flightTime_pickup_second'];
		$first_date = new DateTime(date ("Y-m-d H:i:s", strtotime($_POST['pickupDate'] . ' ' . $_POST['pickupTime'])));
		$second_date = new DateTime(date("Y-m-d H:i:s"));
		$difference = $first_date->diff($second_date);

		if( $this->checkReservationInterval($_POST['pickupDate'],$_POST['pickupTime']) ){
			$x_type = 'AUTH_CAPTURE';
		}
		else{
			$x_type = 'AUTH_ONLY';
			$_REQUEST['diffOfHours'] = $difference->format("%h");;
			/*
			$returnData['success'] = FALSE;
			$returnData['timeerror'] = TRUE;
			$returnData['firstDate'] = $first_date;
			$returnData['secondDate'] = $second_date;
			$returnData['diff'] = $difference->format("%h");
			$_REQUEST['success'] = $returnData['success'];
			$_REQUEST['bookingID'] = -1;
			*/
		}
		
		//$_POST['paymentMethod'] = 'CC';
		$bookData = $this->session->userdata('bookInfo');
		$distanceInfo = $this->session->userdata('distance');
		$userID = $this->addUser();
		$cost = str_replace('$','',$bookData['cost_'.$bookData['vehicleType']]);
		$tipAmount = 0.00;
		if ($_POST['tipPercentage'] != 0)
		{
			$tipAmount = $cost * ($_POST['tipPercentage']/100);
		}
		$totalCost = $cost+$tipAmount;
		
		$authNetKey = '';
		$authNetTransactionID = '';
		$transactionType = '';
		$tempAuthNetTransactionID = 1;
		
		//Create our logic for add booking
		$data = array(
			"userId" => '-1', 
			"cost" => $cost, 
			"tipAmount" => $tipAmount, 
			"totalCost" => $totalCost,
			"tipPercentage" => $_POST['tipPercentage'],
			"authNetKey" => $authNetKey,
		    "authNetTransactionID" => $authNetTransactionID ,
			"transactionType" => $transactionType,
		    "passengerName" => $_POST['passengerName'],
		    "emailAddress" => $_POST['emailAddress'],
		    "cellPhone" => $_POST['cellPhone'],
		    "passengers" => $bookData['passengers'],
		    "miles" => $distanceInfo['distance'],
		    "vehicleTypeId" => $bookData['vehicleType'],
		    "trip" => $bookData['trip']			
		);
		// add the booking
		$bookingID = $this->addBooking($data);
		$returnData['bookingID'] = $bookingID;
		// TEST MODE
		if( $_SERVER['REMOTE_ADDR'] == '14.202.154.67'){
			$post_values = array(
				"x_login"			=> "4up5Tp9Un",
				"x_tran_key"		=> "7Y58Cw8wBb9S452d",	
				"x_version"			=> "3.1",
				"x_delim_data"		=> "TRUE",
				"x_delim_char"		=> "|",
				"x_relay_response"	=> "FALSE",		
				"x_type"			=> $x_type,
				"x_method"			=> "CC",
				"x_card_num"		=> $_POST['billingCard'],
				"x_exp_date"		=> $_POST['expirationMonth'].$_POST['expirationYear'],		
				"x_amount"			=> $totalCost,
				"x_first_name"		=> $_POST['passengerName'],
				"x_last_name"		=> "",
				"x_address"			=> $_POST['billingAddress'] . ', ' . $_POST['billingCity'],
				"x_state"			=> $_POST['billingState'],
				"x_email"			=> $_POST['emailAddress'],
				"x_phone"			=> $_POST['cellPhone'],
				"x_cust_id"			=> "Booking # " . $bookingID
			);		
		}
		// LIVE MODE
		else{
			$post_values = array(
				"x_login"			=> "4up5Tp9Un",
				"x_tran_key"		=> "7Y58Cw8wBb9S452d",	
				"x_version"			=> "3.1",
				"x_delim_data"		=> "TRUE",
				"x_delim_char"		=> "|",
				"x_relay_response"	=> "FALSE",		
				"x_type"			=> $x_type,
				"x_method"			=> "CC",
				"x_card_num"		=> $_POST['billingCard'],
				"x_exp_date"		=> $_POST['expirationMonth'].$_POST['expirationYear'],		
				"x_amount"			=> $totalCost,
				"x_first_name"		=> $_POST['passengerName'],
				"x_last_name"		=> "",
				"x_address"			=> $_POST['billingAddress'] . ', ' . $_POST['billingCity'],
				"x_state"			=> $_POST['billingState'],
				"x_email"			=> $_POST['emailAddress'],
				"x_phone"			=> $_POST['cellPhone'],
				"x_cust_id"			=> "Booking # " . $bookingID
			);
		}	
		if ($_POST['paymentMethod'] == 'CC') {
			if ($_POST['billingCard'] == '4519028430336633')
			{
				
				$authNetKey =  "TESTCC";
				$authNetTransactionID =  "TESTCC";
				$transactionType = "TESTCC";
				$returnData['ccAuth'] = Array();
				$returnData['ccAuth']['responseCode'] = 1;
				$returnData['ccAuth']['responseMessage'] = 'Test Transaction';
				$returnData['ccAuth']['fullResponseData'] = array();
				$response_array = array('1','','','This transaction has been approved.');
			}
			else
			{
				$response_array = $this->auth_capture($post_values);
				$returnData = Array();
				$returnData['ccAuth'] = Array();
				$returnData['ccAuth']['responseCode'] = $response_array[0];
				$returnData['ccAuth']['responseMessage'] = $response_array[3];
				$returnData['ccAuth']['fullResponseData'] = $response_array;
				
				$authNetKey =  $response_array[37];
				$authNetTransactionID =  $response_array[6];
				$tempAuthNetTransactionID = $response_array[6];
				$transactionType = $x_type;
			}
			$returnData['totalCost'] = $totalCost;
			$returnData['tipAmount'] = $tipAmount;
			$returnData['cost'] = $cost;
			
		} 
        else if($_POST['paymentMethod'] == 'CA'){
			$returnData['success'] = TRUE; 
			$returnData['ccAuth'] = Array();
			$returnData['ccAuth']['responseCode'] = 1;
			$returnData['ccAuth']['responseMessage'] = 'CASH Transaction';
			$returnData['ccAuth']['fullResponseData'] = array();
			$returnData['totalCost'] = $totalCost;
			$returnData['tipAmount'] = $tipAmount;
			$returnData['cost'] = $cost;
			$authNetKey = 'CASH';
			$authNetTransactionID =  'CASH';
			$transactionType = 'CASH';
			$response_array = array('1','','','This transaction has been approved.');
		}
		$authNetResponse = implode("|",$response_array);
		if($response_array[0] == 1 && $response_array[3] == 'This transaction has been approved.' && $tempAuthNetTransactionID > 0){
				$this->db->trans_begin();	
				$returnData['success'] = TRUE; 
				//Create our logic for add booking
				/*
				$data = array(
					"userId" => '-1', 
					"cost" => $cost, 
					"tipAmount" => $tipAmount, 
					"totalCost" => $totalCost,
					"tipPercentage" => $_POST['tipPercentage'],
					"authNetKey" => $authNetKey,
				    "authNetTransactionID" => $authNetTransactionID ,
					"transactionType" => $transactionType,
				    "passengerName" => $_POST['passengerName'],
				    "emailAddress" => $_POST['emailAddress'],
				    "cellPhone" => $_POST['cellPhone'],
				    "passengers" => $bookData['passengers'],
				    "miles" => $distanceInfo['distance'],
				    "vehicleTypeId" => $bookData['vehicleType'],
				    "trip" => $bookData['trip']
					
				);
				*/
				
				// add the booking
				/*
				$bookingID = $this->addBooking($data);
				$returnData['bookingID'] = $bookingID;
				*/
				
				$query = $this->db->query("
					UPDATE booking SET 
						authNetKey = '{$authNetKey}',
				    	authNetTransactionID = '{$authNetTransactionID}' ,
						transactionType = '{$transactionType}',
						authNetResponse = '{$authNetResponse}'
					WHERE 
						bookingID = '{$bookingID}';
				");
				
				//get errorprts
				$airports = $bookData['airports'];
				
				//build generic information for first leg
				$data = array(
					"bookingID" => $bookingID, 
					"vehicleTypeID" => $bookData['vehicleType'], 
					"pickAirportID" => $bookData['pickAirportID'], 
					"pickAddress1" => $bookData['pickUp_address'],
					"pickAddress2" => $bookData['pickUp_addressLine2'],
					"pickCity" => $bookData['pickUp_city'],
					"pickState" => $bookData['pickUp_state'],
					"pickZipcode" => $bookData['pickUp_zip'],
					"dropAirportID" => $bookData['dropAirportID'], 
					"dropAddress1" => $bookData['dropOff_address'],
					"dropAddress2" => $bookData['dropOff_addressLine2'],
					"dropCity" => $bookData['dropOff_city'],
					"dropState" => $bookData['dropOff_state'],
					"dropZipcode" => $bookData['dropOff_zip'],
					"tripLeg" => "first"
					
				);
				
				$tripDetails = array(
						"noOfLuggage" => '',
						"noOfCarryOnItems" => '',
						"airline" => '',
						"flightNumber" => '',
						"flightTime" => '',
						"noOfLuggage_dropoff" => '',
						"noOfCarryOnItems_dropoff" => '',
						"airline_dropoff" => '',
						"flightNumber_dropoff"=> '',
						"flightTime_dropoff" => '',
						"pickupDate" =>  date ("Y-m-d", strtotime($_POST['pickupDate'])),
						"pickupTime" => $_POST['pickupTime'],
						
				);
				
				//lets get the air port related fields.
				foreach($airports AS $airport){
					if ($airport['tripleg'] == 'first')
					{
						if ($airport['code'] =='pickup')
						{
							$tripDetails['noOfLuggage'] = $_POST['noOfLuggage_'. $airport['code'] . '_' . $airport['tripleg']];
							$tripDetails['noOfCarryOnItems'] = $_POST['noOfCarryOnItems_'. $airport['code'] . '_' . $airport['tripleg']];
							$tripDetails['airline'] = $_POST['airline_'. $airport['code'] . '_' . $airport['tripleg']];
							$tripDetails['flightNumber'] = $_POST['flightNumber_'. $airport['code'] . '_' . $airport['tripleg']];	
							$tripDetails['flightTime'] = $_POST['flightTime_'. $airport['code'] . '_' . $airport['tripleg']];
						}	
						else if ($airport['code'] =='dropoff')
						{
							$tripDetails['noOfLuggage_dropoff'] = $_POST['noOfLuggage_'. $airport['code'] . '_' . $airport['tripleg']];
							$tripDetails['noOfCarryOnItems_dropoff'] = $_POST['noOfCarryOnItems_'. $airport['code'] . '_' . $airport['tripleg']];
							$tripDetails['airline_dropoff'] = $_POST['airline_'. $airport['code'] . '_' . $airport['tripleg']];
							$tripDetails['flightNumber_dropoff'] = $_POST['flightNumber_'. $airport['code'] . '_' . $airport['tripleg']];	
							$tripDetails['flightTime_dropoff'] = $_POST['flightTime_'. $airport['code'] . '_' . $airport['tripleg']];
						}	
					}		
				}
				// merge our airport fileds to data
				$data = array_merge($data,$tripDetails);
				//insert our first leg.
				$this->addBookingTrip($data);
				
				//check if we have a second leg. Run threw same logic as above.
				if($bookData['trip'] == 2){
					$data = array(
						"bookingID" => $bookingID, 
						"vehicleTypeID" => $bookData['vehicleType'], 
						"pickAirportID" => $bookData['pickAirportID2'], 
						"pickAddress1" => $bookData['pickUp_address2'],
						"pickAddress2" => $bookData['pickUp_addressLine2_2'],
						"pickCity" => $bookData['pickUp_city2'],
						"pickState" => $bookData['pickUp_state2'],
						"pickZipcode" => $bookData['pickUp_zip2'],
						"dropAirportID" => $bookData['dropAirportID2'], 
						"dropAddress1" => $bookData['dropOff_address2'],
						"dropAddress1" => $bookData['dropOff_address2'],
						"dropAddress2" => $bookData['dropOff_addressLine2_2'],
						"dropCity" => $bookData['dropOff_city2'],
						"dropState" => $bookData['dropOff_state2'],
						"dropZipcode" => $bookData['dropOff_zip2'],
						"tripLeg" => "second"	
					);
					
					$tripDetails = array(
							"noOfLuggage" => '',
							"noOfCarryOnItems" => '',
							"airline" => '',
							"flightNumber" => '',
							"flightTime" => '',
							"noOfLuggage_dropoff" => '',
							"noOfCarryOnItems_dropoff" => '',
							"airline_dropoff" => '',
							"flightNumber_dropoff"=> '',
							"flightTime_dropoff" => '',
							"pickupDate" => date ("Y-m-d", strtotime($_POST['pickupDate_return'])),
							"pickupTime" => $_POST['pickupTime_return'],
							
					);
					
					foreach($airports AS $airport){
						if ($airport['tripleg'] == 'second')
						{
							if ($airport['code'] =='pickup')
							{
								$tripDetails['noOfLuggage'] = $_POST['noOfLuggage_'. $airport['code'] . '_' . $airport['tripleg']];
								$tripDetails['noOfCarryOnItems'] = $_POST['noOfCarryOnItems_'. $airport['code'] . '_' . $airport['tripleg']];
								$tripDetails['airline'] = $_POST['airline_'. $airport['code'] . '_' . $airport['tripleg']];
								$tripDetails['flightNumber'] = $_POST['flightNumber_'. $airport['code'] . '_' . $airport['tripleg']];	
								$tripDetails['flightTime'] = $_POST['flightTime_'. $airport['code'] . '_' . $airport['tripleg']];
							}	
							else if ($airport['code'] =='dropoff')
							{
								$tripDetails['noOfLuggage_dropoff'] = $_POST['noOfLuggage_'. $airport['code'] . '_' . $airport['tripleg']];
								$tripDetails['noOfCarryOnItems_dropoff'] = $_POST['noOfCarryOnItems_'. $airport['code'] . '_' . $airport['tripleg']];
								$tripDetails['airline_dropoff'] = $_POST['airline_'. $airport['code'] . '_' . $airport['tripleg']];
								$tripDetails['flightNumber_dropoff'] = $_POST['flightNumber_'. $airport['code'] . '_' . $airport['tripleg']];	
								$tripDetails['flightTime_dropoff'] = $_POST['flightTime_'. $airport['code'] . '_' . $airport['tripleg']];
							}	
						}		
					}
					
					$data = array_merge($data,$tripDetails);
					$this->addBookingTrip($data);		
				}
			
			if ( $this->db->trans_status() === FALSE ) {
			   $this->db->trans_rollback();
			   $returnData['success'] = FALSE; 
			} else {    
			   $this->db->trans_commit();    
			    $returnData['success'] = TRUE; 
				$this->session->set_userdata(Array("pickUpdateDate"=> $_POST['pickupDate'] . ' ' . $_POST['pickupTime']));
			}
			$_REQUEST['success'] = $returnData['success'];
			$_REQUEST['bookingID'] = $bookingID;
		} else {
			$_REQUEST['success'] = FALSE;
			$_REQUEST['bookingID'] = 0;
		}		
		// check is booking add successfully with credit card processing
		if($_REQUEST['success'] == FALSE && $bookingID > 0){
			$query = $this->db->query("
				DELETE FROM booking 
				WHERE 
					bookingID = '{$bookingID}';
			");
		}   
		echo json_encode($returnData);			
	}
	private function addBooking($data){
		date_default_timezone_set('America/Chicago');
		
		$query = $this->db->query("
			INSERT INTO booking (
				bookingStatusID,
				userID,
				noOfPassenger,
				miles,
				passengerName,
				emailAddress,
				cellPhone,
				cost,
				tipPercentage,
				tipAmount,
				totalCost,
				notes,
				billingAddress1,
				billingCity,
				billingState,
				billingZip,
				ccName,
				ccExpirationMonth,
				ccExpirationYear,
				ccNumber,
				authNetKey,
				authNetTransactionID,
				transactionType,
				trip,
				bookingSource,
				vehicleTypeID,
				paymentMethod,
				dateCreated	
			)
			VALUES (
				'1',
				'{$data['userId']}',
				'{$data['passengers']}',
				'{$data['miles']}',
				'{$this->db->escape_like_str($data['passengerName'])}',
				'{$data['emailAddress']}',
				'{$data['cellPhone']}',
				'{$data['cost']}',
				'{$data['tipPercentage']}',
				'{$data['tipAmount']}',
				'{$data['totalCost']}',
				'{$this->db->escape_like_str($_POST['specialInstructions'])}',	
				'{$this->db->escape_like_str($_POST['billingAddress'])}',
				'{$this->db->escape_like_str($_POST['billingCity'])}',
				'{$this->db->escape_like_str($_POST['billingState'])}',
				'{$this->db->escape_like_str($_POST['billingZip'])}',
				'{$_POST['cardHolderName']}',
				'{$_POST['expirationMonth']}',
				'{$_POST['expirationYear']}',
				'{$_POST['billingCard']}',	
				'{$data['authNetKey']}',
				'{$data['authNetTransactionID']}',
				'{$data['transactionType']}',
				'{$data['trip']}',	
				'Online',
				'{$data['vehicleTypeId']}',	
				'{$_POST['paymentMethod']}',	
				now());
		");
		return $this->db->insert_id();		
	}
	private function addBookingTrip($data){
		$sql = "INSERT INTO bookingTrip (
				bookingID, 
				pickAddress1, 
				pickAddress2, 
				pickCity, 
				pickState, 
				pickZipcode, 
				dropAddress1, 
				dropAddress2, 
				dropCity, 
				dropState, 
				dropZipcode, 
				dateCreated,
				pickupDate,
				pickupTime,
				noOfLuggage,
				noOfCarryOnItems,
				airline,
				flightNumber,
				flightTime,
				noOfLuggage_dropoff,
				noOfCarryOnItems_dropoff,
				airline_dropoff,
				flightNumber_dropoff,
				flightTime_dropoff,
				pickAirportID,
				dropAirportID,
				tripLeg
			) VALUES (
				'{$data['bookingID']}', 
				'{$this->db->escape_like_str($data['pickAddress1'])}', 
				'{$this->db->escape_like_str($data['pickAddress2'])}', 
				'{$this->db->escape_like_str($data['pickCity'])}', 
				'{$this->db->escape_like_str($data['pickState'])}', 
				'{$this->db->escape_like_str($data['pickZipcode'])}', 
				'{$this->db->escape_like_str($data['dropAddress1'])}', 
				'{$this->db->escape_like_str($data['dropAddress2'])}', 
				'{$this->db->escape_like_str($data['dropCity'])}', 
				'{$this->db->escape_like_str($data['dropState'])}', 
				'{$this->db->escape_like_str($data['dropZipcode'])}', 
					now(),
				'{$data['pickupDate']}',";
				if($data['pickupTime'] == ''){ $sql . 'NULL,';   } else { $sql .= "'" . date('H:i:s', strtotime($data['pickupTime'])) . "',"; }
				$sql .= "'{$data['noOfLuggage']}',
				'{$data['noOfCarryOnItems']}',
				'{$data['airline']}',
				'{$data['flightNumber']}',
				'{$data['flightTime']}',
				'{$data['noOfLuggage_dropoff']}',
				'{$data['noOfCarryOnItems_dropoff']}',
				'{$data['airline_dropoff']}',
				'{$data['flightNumber_dropoff']}',
				'{$data['flightTime_dropoff']}',
				'{$data['pickAirportID']}',
				'{$data['dropAirportID']}',
				'{$data['tripLeg']}'
					
				 
			);";		
			
		$bookingTripID = $this->db->query($sql);
		return $this->db->insert_id();;
	}
	private function addUser(){
		$userID = $this->isUserExists($_POST['emailAddress']);
		if($userID > 0){
			return $userID;
		}
		else{
			$passengerName = explode(" ",$_POST['passengerName']);
			$userID = $this->db->query("
				INSERT INTO user (userName,password,firstName,lastName,email,phone,isActive,dateCreated)
				VALUES ('{$_POST['emailAddress']}','". rand() ."','{$this->db->escape_like_str($passengerName[0])}','{$this->db->escape_like_str($passengerName[1])}','{$_POST['emailAddress']}','{$_POST['cellPhone']}',1,now());
			");
			return $this->db->insert_id();;
		}	
	}
	private function isUserExists($email){
		$query = $this->db->query("
			SELECT	userID
			FROM 	user
			WHERE	email = '{$_POST['emailAddress']}'
		");
		$result = $query->result_array();
		if(count($result) > 0){
			return $result[0]['userID'];
		}
		else{
			return -1;
		}
	}
	private function auth_capture($post_values){
		// CHECK MODE
		$post_url = "https://secure.authorize.net/gateway/transact.dll";
		$post_string = "";
		foreach( $post_values as $key => $value ){ 
			$post_string .= "$key=" . urlencode( $value ) . "&"; 
		}
		$post_string = rtrim( $post_string, "& " );
		$request = curl_init($post_url); 
		curl_setopt($request, CURLOPT_HEADER, 0); 
		curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); 
		curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); 
		/*
		if( $_SERVER['REMOTE_ADDR'] == '14.202.154.67'){
			print_r($post_url);
			print_r($post_string);
			exit;
		}*/
		$post_response = curl_exec($request); 
		curl_close ($request); 
		$response_array = explode($post_values["x_delim_char"],$post_response);
		return $response_array;
	}
	 
	
	/* Gateway Methods */
	
	public function get_booking($bookingID){
		$sql = "SELECT		
							booking.*,
							booking.notes AS specialInstructions,
							booking.cost AS basePrice,
							booking.tipAmount AS tip,
							DATE_FORMAT(bookingTrip.pickupDate,'%m/%d/%Y') AS pickupDate,
							DATE_FORMAT(bookingTrip.pickupTime,'%h:%i %p') AS pickupTime,
							if(bookingTrip.pickAirportID IS NULL OR bookingTrip.pickAirportID = 0,
								concat(bookingTrip.pickAddress1,' ',bookingTrip.pickAddress2,', ',bookingTrip.pickCity,', ',bookingTrip.pickState,', ',bookingTrip.pickZipCode)
								,
								(
									SELECT pickupAirport.name FROM airports pickupAirport
									WHERE pickupAirport.id = bookingTrip.pickAirportID
								)
							) AS pickupLocation,
							if(bookingTrip.dropAirportID IS NULL OR bookingTrip.dropAirportID = 0,
								concat(bookingTrip.dropAddress1,' ',bookingTrip.dropAddress2,', ',bookingTrip.dropCity,', ',bookingTrip.dropState,', ',bookingTrip.dropZipCode)
								,
								(
									SELECT dropAirport.name FROM airports dropAirport
									WHERE dropAirport.id = bookingTrip.dropAirportID
								)
							) AS dropOffLocation,
							bookingTrip.noOfLuggage AS pickupNoOfLuggage,
							bookingTrip.noOfCarryOnItems AS pickupNoOfCarryOnItems,
							bookingTrip.airline AS pickupAirline,
							bookingTrip.flightnumber AS pickupFlightNumber,
							bookingTrip.flighttime AS pickupFlightTime,
							bookingTrip.noOfLuggage_dropoff AS dropOffNoOfLuggage,
							bookingTrip.noOfCarryOnItems_dropoff AS dropOffNoOfCarryOnItems,
							bookingTrip.airline_dropoff AS dropOffAirline,
							bookingTrip.flightnumber_dropoff AS dropOffFlightNumber,
							bookingTrip.flighttime_dropoff AS dropOffFlightTime,							
							DATE_FORMAT(ReturnTrip.pickupDate,'%m/%d/%Y') AS returnpickupDate,
							DATE_FORMAT(ReturnTrip.pickupTime,'%h:%i %p') AS returnpickupTime,							
							if(ReturnTrip.pickAirportID IS NULL OR ReturnTrip.pickAirportID = 0,
								concat(ReturnTrip.pickAddress1,' ',ReturnTrip.pickAddress2,', ',ReturnTrip.pickCity,', ',ReturnTrip.pickState,', ',ReturnTrip.pickZipCode)
								,
								(
									SELECT pickupAirport.name FROM airports pickupAirport
									WHERE pickupAirport.id = ReturnTrip.pickAirportID
								)
							) AS returnPickupLocation,
							if(ReturnTrip.dropAirportID IS NULL OR ReturnTrip.dropAirportID = 0,
								concat(ReturnTrip.dropAddress1,' ',ReturnTrip.dropAddress2,', ',ReturnTrip.dropCity,', ',ReturnTrip.dropState,', ',ReturnTrip.dropZipCode)
								,
								(
									SELECT dropAirport.name FROM airports dropAirport
									WHERE dropAirport.id = ReturnTrip.dropAirportID
								)
							) AS returnDropOffLocation,
							ReturnTrip.noOfLuggage AS returnPickupNoOfLuggage,
							ReturnTrip.noOfCarryOnItems AS returnPickupNoOfCarryOnItems,
							ReturnTrip.airline AS returnPickupAirline,
							ReturnTrip.flightnumber AS returnPickupFlightNumber,
							ReturnTrip.flighttime AS returnPickupFlightTime,
							ReturnTrip.noOfLuggage_dropoff AS returnDropOffNoOfLuggage,
							ReturnTrip.noOfCarryOnItems_dropoff AS returnDropOffNoOfCarryOnItems,
							ReturnTrip.airline_dropoff AS returnDropOffAirline,
							ReturnTrip.flightnumber_dropoff AS returnDropOffFlightNumber,
							ReturnTrip.flighttime_dropoff AS returnDropOffFlightTime,						
							ReturnTrip.noOfLuggage AS returnNoOfLuggage,
							ReturnTrip.noOfCarryOnItems AS returnNoOfCarryOnItem,
							ReturnTrip.airline AS returnAirline,
							ReturnTrip.flightNumber AS returnFlightNumber,
							ReturnTrip.flightTime AS returnFlightTime,
							concat(driver.firstName,' ', driver.lastName) AS driverName,
							driver.email AS driverEmail,
							driver.phone AS driverPhoneNumber,							
							vehicle.year AS vehicleYear,
							vehicle.make AS vehicleMake,
							vehicle.model AS vehicleModel,
							vehicle.vehiclePlate AS vehiclePlateNumber,							
							(
								SELECT vehicleType FROM vehicleType
								WHERE vehicleType.vehicleTypeID = vehicle.vehicleTypeID
							) AS vehicleType,
							concat(returnTripDriver.firstName,' ', returnTripDriver.lastName) AS returnTripDriverName,
							returnTripDriver.email AS returnTripDriverEmail,
							returnTripDriver.phone AS returnTripDriverPhoneNumber,							
							returnTripVehicle.year AS returnTripVehicleYear,
							returnTripVehicle.make AS returnTripVehicleMake,
							returnTripVehicle.model AS returnTripVehicleModel,
							returnTripVehicle.vehiclePlate AS returnTripVehiclePlateNumber,
							(
								SELECT vehicleType FROM vehicleType
								WHERE returnTripVehicle.vehicleTypeID = vehicleType.vehicleTypeID
							) AS returnTripVehicleType,
							booking.passengerName,
							booking.emailAddress AS passengerEmail, 
							booking.cellPhone AS passengerPhoneNumber,
							bookingStatus.bookingStatus
				FROM 		booking
							INNER JOIN bookingTrip ON bookingTrip.bookingID = booking.bookingId AND bookingTrip.tripLeg = 'first'
							LEFT JOIN bookingTrip as ReturnTrip ON ReturnTrip.bookingID = booking.bookingId AND ReturnTrip.tripLeg = 'second'							
							LEFT JOIN bookingStatus ON booking.bookingStatusID = bookingStatus.bookingStatusID
							LEFT JOIN  vehicle ON bookingTrip.vehicleID = vehicle.vehicleID
							LEFT JOIN  driver ON bookingTrip.driverID = driver.driverID
							LEFT JOIN  vehicle returnTripVehicle ON ReturnTrip.vehicleID = returnTripVehicle.vehicleID
							LEFT JOIN  driver returnTripDriver ON ReturnTrip.driverID = returnTripDriver.driverID
							WHERE 		booking.bookingID = ?"; 
		$query=$this->db->query($sql, array($bookingID));
		return $query;
	}
	
	
}

?>