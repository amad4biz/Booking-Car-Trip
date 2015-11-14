<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reservation_model extends CI_Model {

	public function __construct(){
		$this->load->database();
	}
	public function get_booking_json(){
		date_default_timezone_set('America/Los_Angeles');
		$query=$this->db->query("
			SELECT 
				booking.bookingID,
				booking.bookingStatusID,
				booking.passengerName,
				bookingTrip.pickupdate,
				bookingTrip.pickuptime
			FROM 
				booking 
				LEFT JOIN bookingTrip ON booking.bookingID = bookingTrip.bookingID
			WHERE 
				bookingTrip.pickupdate BETWEEN '" . date('Y-m-d', $_REQUEST['start']) . "' AND '" . date('Y-m-d', $_REQUEST['end']) . "'" .
				" ORDER BY bookingTrip.tripLeg,bookingTrip.pickupdate,bookingTrip.pickuptime ASC");
		echo '[';
		$counter = 1;
		foreach ($query->result() as $row){
			echo '{';
				echo '"title":"' . $row->passengerName . '",';
				echo '"start":"' . $row->pickupdate . 'T' . $row->pickuptime . '",';
				echo '"end":"' . $row->pickupdate . 'T' . $row->pickuptime . '",';
				echo '"url":"/app/admin/index.php/reservation/edit/' . $row->bookingID . '",';
				if($row->bookingStatusID == 1){
					echo '"color":"#FEE188",';
					echo '"textColor":"#963"';
				}
				else if($row->bookingStatusID == 3){
					echo '"color":"#3A87AD",';
					echo '"textColor":"#fff"';
				}
				else if($row->bookingStatusID == 4){
					echo '"color":"#D15B47",';
					echo '"textColor":"#fff"';
				}
				else{
					echo '"color":"#82af6f",';
					echo '"textColor":"#fff"';
				}
			echo ',"allDay":false}';
			if($counter < $query->num_rows()){echo ',';}$counter += 1;
		}
	    echo ']';
	}
	public function get_bookings($data){
		$sqlQuery = "SELECT		booking.*,
								bookingTrip.bookingTripID,
								bookingTrip.tripLeg,
								DATE_FORMAT(bookingTrip.pickupDate,'%m/%d') AS formattedPickupDate,
								DATE_FORMAT(bookingTrip.pickupTime,'%h:%i %p') AS formattedPickupTime,
								concat(bookingTrip.pickupDate, ' ', bookingTrip.pickupTime) as pickupDateTime,
								bookingStatus.bookingStatus,
								concat(driver.firstName,' ',driver.lastName) AS driverName,
								concat(vehicle.year,' ',vehicle.make,' ',vehicle.model,' ',vehicle.vehiclePlate) AS vehicle,
								bookingTrip.pickAddress1,
								bookingTrip.pickCity,
								bookingTrip.pickState,
								bookingTrip.pickZipcode,
								bookingTrip.pickAirportID,
								(SELECT name FROM airports WHERE id = bookingTrip.pickAirportID) as pickupAirport,
								bookingTrip.dropAddress1,
								bookingTrip.dropCity,
								bookingTrip.dropState,
								bookingTrip.dropZipcode,
								bookingTrip.dropAirportID,
								(SELECT name FROM airports WHERE id = bookingTrip.dropAirportID) as dropAirPort,
								booking.noOfPassenger,
								bookingTrip.driverID,
								bookingTrip.vehicleID
					FROM 		booking
					INNER JOIN bookingTrip ON bookingTrip.bookingID = booking.bookingId AND bookingTrip.tripLeg = 'first'					
					LEFT JOIN bookingStatus ON booking.bookingStatusID = bookingStatus.bookingStatusID
					LEFT JOIN driver driver ON bookingTrip.driverID = driver.driverID
					LEFT JOIN vehicle vehicle ON bookingTrip.vehicleID = vehicle.vehicleID
					WHERE 1=1
					";
		if(isset($data['startdate']) && $data['bookingStatusID'] != 3){
			$sqlQuery .= " AND bookingTrip.pickupdate BETWEEN '" . date ("Y-m-d H:i:s", strtotime($data['startdate'])) . "' AND '" . date ("Y-m-d H:i:s", strtotime($data['enddate'])) . "'";
		}
		if(isset($data['vehicleID'])){
			$sqlQuery.= " AND bookingTrip.vehicleID = " . $data['vehicleID'];
		}
		if(isset($data['driverID'])){
			$sqlQuery.= " AND bookingTrip.driverID = " . $data['driverID'];
		}
		if(isset($data['bookingStatusID'])){
			$sqlQuery.= " AND booking.bookingStatusID = " . $data['bookingStatusID'];
		}
		$sqlQuery .= " UNION ";
		$sqlQuery .= "SELECT	booking.*,
								bookingTrip.bookingTripID,
								bookingTrip.tripLeg,
								DATE_FORMAT(bookingTrip.pickupDate,'%m/%d') AS formattedPickupDate,
								DATE_FORMAT(bookingTrip.pickupTime,'%h:%i %p') AS formattedPickupTime,
								concat(bookingTrip.pickupDate, ' ', bookingTrip.pickupTime) as pickupDateTime,
								bookingStatus.bookingStatus,
								concat(driver.firstName,' ',driver.lastName) AS driverName,
								concat(vehicle.year,' ',vehicle.make,' ',vehicle.model,' ',vehicle.vehiclePlate) AS vehicle,
								bookingTrip.pickAddress1,
								bookingTrip.pickCity,
								bookingTrip.pickState,
								bookingTrip.pickZipcode,
								bookingTrip.pickAirportID,
								(SELECT name FROM airports WHERE id = bookingTrip.pickAirportID) as pickupAirport,
								bookingTrip.dropAddress1,
								bookingTrip.dropCity,
								bookingTrip.dropState,
								bookingTrip.dropZipcode,
								bookingTrip.dropAirportID,
								(SELECT name FROM airports WHERE id = bookingTrip.dropAirportID) as dropAirPort,
								booking.noOfPassenger,
								bookingTrip.driverID,
								bookingTrip.vehicleID
					FROM 		booking
					INNER JOIN bookingTrip ON bookingTrip.bookingID = booking.bookingId AND bookingTrip.tripLeg = 'second'					
					LEFT  JOIN bookingStatus ON booking.bookingStatusID = bookingStatus.bookingStatusID
					LEFT  JOIN driver driver ON bookingTrip.driverID = driver.driverID
					LEFT  JOIN vehicle vehicle ON bookingTrip.vehicleID = vehicle.vehicleID
					WHERE 1=1
					";
		if(isset($data['startdate']) && $data['bookingStatusID'] != 3){
			$sqlQuery .= " AND bookingTrip.pickupdate BETWEEN '" . date ("Y-m-d H:i:s", strtotime($data['startdate'])) . "' AND '" . date ("Y-m-d H:i:s", strtotime($data['enddate'])) . "'";
		}
		if(isset($data['vehicleID'])){
			$sqlQuery.= " AND bookingTrip.vehicleID = " . $data['vehicleID'];
		}
		if(isset($data['driverID'])){
			$sqlQuery.= " AND bookingTrip.driverID = " . $data['driverID'];
		}
		if(isset($data['bookingStatusID'])){
			$sqlQuery.= " AND booking.bookingStatusID = " . $data['bookingStatusID'];
		}
		$sqlQuery .= " ORDER BY pickupDateTime ASC";
		$query = $this->db->query($sqlQuery)->result_array();
		return $query;
	}
	public function get_waybills($data){
		$sqlQuery = "SELECT		booking.*,
								DATE_FORMAT(bookingTrip.pickupDate,'%m-%d-%Y') AS formattedPickupDate,
								DATE_FORMAT(bookingTrip.pickupTime,'%h:%i %p') AS formattedPickupTime,
								bookingStatus.bookingStatus,
								concat(driver.firstName,' ',driver.lastName) AS driverName,
								concat(vehicle.year,' ',vehicle.make,' ',vehicle.model,' ',vehicle.vehiclePlate) AS vehicle,
								if(sentemailcontent.sentEmailContentID IS NULL,'Pending','Sent') AS emailStatus,
								if(sentemailcontent.sentEmailContentID IS NULL,'',DATE_FORMAT(sentemailcontent.dateSent,'%m-%d-%Y %h:%i %p')) AS dateSent,
								sentemailcontent.sentEmailContentID 
					FROM 		booking
					INNER JOIN bookingTrip ON bookingTrip.bookingID = booking.bookingId AND bookingTrip.tripLeg = 'first'					
					LEFT  JOIN bookingStatus ON booking.bookingStatusID = bookingStatus.bookingStatusID
					LEFT  JOIN driver driver ON bookingTrip.driverID = driver.driverID
					LEFT  JOIN vehicle vehicle ON bookingTrip.vehicleID = vehicle.vehicleID
					LEFT  JOIN sentemailcontent ON booking.bookingID = sentemailcontent.bookingID
					LEFT  JOIN autoemail ON sentemailcontent.autoEmailID = autoemail.autoEmailID
					WHERE autoemail.autoEmailEventID IN (
						SELECT autoEmailEventID FROM autoemailevents 
						WHERE eventCode = 'waybillToDriver'
					)
					";
		if(isset($data['startdate'])){
			$sqlQuery .= " AND bookingTrip.pickupdate BETWEEN '" . date ("Y-m-d H:i:s", strtotime($data['startdate'])) . "' AND '" . date ("Y-m-d H:i:s", strtotime($data['enddate'])) . "'";
		}
		if(isset($data['vehicleID'])){
			$sqlQuery.= " AND booking.vehicleID = " . $data['vehicleID'];
		}
		if(isset($data['driverID'])){
			$sqlQuery.= " AND booking.driverID = " . $data['driverID'];
		}
		if(isset($data['emailStatus'])){
			if($data['emailStatus'] == 'Pending'){
				$sqlQuery.= " AND sentemailcontent.sentEmailContentID IS NULL";
			}
			else if($data['emailStatus'] == 'Sent'){
				$sqlQuery.= " AND sentemailcontent.sentEmailContentID IS NOT NULL";
			}			
		}
		$sqlQuery .= " ORDER BY dateSent DESC,bookingTrip.pickupdate ASC";
		$query = $this->db->query($sqlQuery)->result_array();
		return $query;
	}
	public function get_booking($bookingID){
		$sql = "SELECT		
							booking.*,
							booking.notes AS specialInstructions,
							booking.cost AS basePrice,
							booking.tipAmount AS tip,
							DATE_FORMAT(bookingTrip.pickupDate,'%m/%d/%Y') AS pickupDate,
							DATE_FORMAT(bookingTrip.pickupTime,'%h:%i %p') AS pickupTime,
							if(bookingTrip.pickAirportID IS NULL OR bookingTrip.pickAirportID = 0,
								concat(bookingTrip.pickAddress1,' ',if(bookingTrip.pickAddress2 IS NULL,'',bookingTrip.pickAddress2),', ',bookingTrip.pickCity,', ',bookingTrip.pickState,', ',bookingTrip.pickZipCode)
								,
								(
									SELECT pickupAirport.name FROM airports pickupAirport
									WHERE pickupAirport.id = bookingTrip.pickAirportID
								)
							) AS pickupLocation,
							if(bookingTrip.dropAirportID IS NULL OR bookingTrip.dropAirportID = 0,
								concat(bookingTrip.dropAddress1,' ',if(bookingTrip.dropAddress2 IS NULL,'',bookingTrip.dropAddress2),', ',bookingTrip.dropCity,', ',bookingTrip.dropState,', ',bookingTrip.dropZipCode)
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
								concat(ReturnTrip.pickAddress1,' ',if(ReturnTrip.pickAddress2 IS NULL,'',ReturnTrip.pickAddress2),', ',ReturnTrip.pickCity,', ',ReturnTrip.pickState,', ',ReturnTrip.pickZipCode)
								,
								(
									SELECT pickupAirport.name FROM airports pickupAirport
									WHERE pickupAirport.id = ReturnTrip.pickAirportID
								)
							) AS returnPickupLocation,
							if(ReturnTrip.dropAirportID IS NULL OR ReturnTrip.dropAirportID = 0,
								concat(ReturnTrip.dropAddress1,' ',if(ReturnTrip.dropAddress2 IS NULL,'',ReturnTrip.dropAddress2),', ',ReturnTrip.dropCity,', ',ReturnTrip.dropState,', ',ReturnTrip.dropZipCode)
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
	public function get_booking_by_bookingTrip($bookingTripID){
		$sql = "SELECT		
							booking.*,
							concat(booking.billingAddress1,' ',booking.billingAddress2,', ',booking.billingCity,', ',booking.billingState,', ',booking.billingZip) as billingAddress,
							DATE_FORMAT(booking.dateCreated, '%m/%d/%y') as dateCreated,
							DATE_FORMAT(booking.dateCreated, '%h:%i %p') as timeCreated,
							booking.notes AS specialInstructions,
							booking.cost AS basePrice,
							booking.tipAmount AS tip,
							DATE_FORMAT(bookingTrip.pickupDate,'%m/%d/%Y') AS pickupDate,
							DATE_FORMAT(bookingTrip.pickupTime,'%h:%i %p') AS pickupTime,
							
							if(bookingTrip.pickAirportID IS NULL OR bookingTrip.pickAirportID = 0,
								concat(bookingTrip.pickAddress1,' ',if(bookingTrip.pickAddress2 IS NULL,'',bookingTrip.pickAddress2),', ',bookingTrip.pickCity,', ',bookingTrip.pickState,', ',bookingTrip.pickZipCode)
								,
								(
									SELECT pickupAirport.name FROM airports pickupAirport
									WHERE pickupAirport.id = bookingTrip.pickAirportID
								)
							) AS pickupLocation,
							if(bookingTrip.dropAirportID IS NULL OR bookingTrip.dropAirportID = 0,
								concat(bookingTrip.dropAddress1,' ',if(bookingTrip.dropAddress2 IS NULL,'',bookingTrip.dropAddress2),', ',bookingTrip.dropCity,', ',bookingTrip.dropState,', ',bookingTrip.dropZipCode)
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
							bookingTrip.driverID,
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
							booking.emailAddress AS passengerEmail, 
							booking.cellPhone AS passengerPhoneNumber,
							bookingStatus.bookingStatus,
							CASE WHEN airline <> '' AND airline_dropoff <> '' THEN concat('<b>Pickup:</b>', airline, ' <b>Dropoff:</b>', airline_dropoff)
								 WHEN airline_dropoff <> '' THEN airline_dropoff
								 ELSE  airline
							END as airline,
							CASE WHEN airline <> '' AND airline_dropoff <> '' THEN concat('<b>Pickup:</b>', flightnumber, ' <b>Dropoff:</b>', flightnumber_dropoff)
								 WHEN airline_dropoff <> '' THEN flightnumber_dropoff
								 ELSE flightnumber
							END as flightNo,
							CASE WHEN airline <> '' AND airline_dropoff <> '' THEN concat('<b>Pickup:</b>', flighttime, ' <b>Dropoff:</b>', flighttime_dropoff)
								 WHEN airline_dropoff <> '' THEN flighttime_dropoff
								 WHEN airline = '' OR airline IS NULL THEN ''
								 ELSE flighttime
							END as flightTime
								 
				FROM 		booking
							INNER JOIN bookingTrip ON bookingTrip.bookingID = booking.bookingId 						
							LEFT JOIN bookingStatus ON booking.bookingStatusID = bookingStatus.bookingStatusID
							LEFT JOIN  driver ON bookingTrip.driverID = driver.driverID
							LEFT JOIN  vehicle ON bookingTrip.vehicleID = vehicle.vehicleID
							WHERE 		bookingTrip.bookingTripID = ?"; 
		$query=$this->db->query($sql, array($bookingTripID));
		return $query;
	}
	
	public function updateDriver(){
		$sql = "UPDATE	bookingTrip SET
				driverID = {$_REQUEST['driverID']}
				WHERE 		bookingTripID = {$_REQUEST['bookingTripID']}"; 
		$this->db->query($sql);
		
	}
	public function updateVehicle(){
		$sql = "UPDATE	bookingTrip SET
				vehicleID = {$_POST['vehicleID']}
				WHERE 		bookingTripID = {$_POST['bookingTripID']}"; 
		$this->db->query($sql);
		exit;
	}	
	public function updateBookingStatus(){
		$sqlbooking = "SELECT booking.* FROM booking WHERE booking.bookingID = ?"; 
		$querybooking=(array)$this->db->query($sqlbooking, array($_POST['bookingID']))->row();
		// check is previous transaction is AUTH_ONLY
		if($_POST['bookingStatusID'] == 2 && $querybooking['paymentMethod'] == 'CC' && $querybooking['transactionType'] == "AUTH_ONLY"){
			if( $_SERVER['REMOTE_ADDR'] == '14.202.154.67'){
				$post_values = array(
					"x_login" => "4up5Tp9Un",
					"x_tran_key" => "7Y58Cw8wBb9S452d",
					"x_version"			=> "3.1",
					"x_delim_data"		=> "TRUE",
					"x_delim_char"		=> "|",
					"x_relay_response"	=> "FALSE",		
					"x_type"			=> "PRIOR_AUTH_CAPTURE",
					"x_method"			=> "CC",
					"x_Trans_ID"		=> $querybooking['authNetTransactionID']
				);	
			}
			else{
				$post_values = array(
					"x_login" => "4up5Tp9Un",
					"x_tran_key" => "7Y58Cw8wBb9S452d",
					"x_version"			=> "3.1",
					"x_delim_data"		=> "TRUE", 
					"x_delim_char"		=> "|",
					"x_relay_response"	=> "FALSE",		
					"x_type"			=> "PRIOR_AUTH_CAPTURE",
					"x_method"			=> "CC",
					"x_Trans_ID"		=> $querybooking['authNetTransactionID']
				);
			}
			$response_array = $this->auth_capture($post_values);
			$authNetResponse = implode("|",$response_array);
			if($response_array[0] == 1 && $response_array[3] == 'This transaction has been approved.'){
				$query = $this->db->query("
					UPDATE booking SET 
						authNetKey='{$response_array[37]}',
						transactionType='PRIOR_AUTH_CAPTURE',
						authNetResponse='{$authNetResponse}'
					WHERE 
						bookingID = '{$_POST['bookingID']}';
				");
			}
		}
		$sql = "UPDATE	booking SET
				bookingStatusID = {$_POST['bookingStatusID']}
				WHERE 		bookingID = {$_POST['bookingID']}"; 
		$this->db->query($sql);
		exit;
	}	
	public function get_booking_trip($bookingID){
		$sql = "SELECT		 *
				FROM 		bookingTrip
				WHERE 		bookingID = ? ORDER BY bookingTripID ASC"; 
		$query=$this->db->query($sql, array($bookingID));
		return $query->result_array();
	}
	public function get_passenger($bookingID){
		$sql = "SELECT		user.*
				FROM 		booking INNER JOIN user ON booking.userID = user.userID 
				WHERE 		booking.bookingID = ?"; 
		$query=$this->db->query($sql, array($bookingID));
		return $query;
	}
	public function get_booking_statuses($isActive = 1){
		$sql = "SELECT		 *
				FROM 		bookingStatus
				WHERE 		isActive = ?"; 
		$query=$this->db->query($sql, array($isActive));
		return $query->result_array();
	}
	public function get_airports(){
		$sql = "SELECT		 *
				FROM 		airports
				ORDER BY sortOrder ASC
				"; 
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	public function update(){
		/* when pending */
		if($_POST['pStatus'] == 1){
			$sqlquery = "
				UPDATE booking SET 
					bookingStatusID={$_POST['bookingStatusID']},
					noOfPassenger={$_POST['passengers']},
					billingAddress1='{$_POST['billingAddress']}',
					billingAddress2='{$_POST['billingAddressLine2']}',
					billingCity='{$_POST['billingCity']}',
					billingState='{$_POST['billingState']}',
					billingZip='{$_POST['billingZip']}',
					internalNotes='{$_POST['internalNotes']}',
					notes='{$_POST['specialInstructions']}',
					passengerName='{$_POST['passengerName']}',
					emailAddress='{$_POST['emailAddress']}',
					cellPhone='{$_POST['cellPhone']}',
					dateUpdated=now()
				WHERE 
					bookingID = '{$_POST['bookingID']}';
			";
			$query = $this->db->query($sqlquery);
			/* update airline details  */
			if(isSet($_POST['pickupBookingTripID1']) && !is_null($_POST['pickupBookingTripID1']) && $_POST['pickupBookingTripID1'] > 0){
				$pickupDate1 = date ("Y-m-d", strtotime($_POST['pickupDate1']));
				$sqlquery = "
					UPDATE bookingTrip SET 
						noOfLuggage='{$_POST['pickupnoOfLuggage1']}',
						noOfCarryOnItems='{$_POST['pickupnoOfCarryOnItems1']}',
						airline='{$_POST['pickupairline1']}',
						flightNumber='{$_POST['pickupflight1']}',
						flightTime='{$_POST['pickupflightTime1']}',
						pickupDate='{$pickupDate1}',
						pickupTime='{$_POST['pickupTime1']}'						
					WHERE 
						bookingTripID = '{$_POST['pickupBookingTripID1']}';
				";
				$query = $this->db->query($sqlquery);			
			}
			if(isSet($_POST['dropoffBookingTripID1']) && !is_null($_POST['dropoffBookingTripID1']) && $_POST['dropoffBookingTripID1'] > 0){
				$sqlquery = "
					UPDATE bookingTrip SET 
						noOfLuggage_dropoff='{$_POST['dropoffnoOfLuggage1']}',
						noOfCarryOnItems_dropoff='{$_POST['dropoffnoOfCarryOnItems1']}',
						airline_dropoff='{$_POST['dropoffairline1']}',
						flightNumber_dropoff='{$_POST['dropoffflight1']}',
						flightTime_dropoff='{$_POST['dropoffflightTime1']}'
					WHERE 
						bookingTripID = '{$_POST['dropoffBookingTripID1']}';
				";
				$query = $this->db->query($sqlquery);			
			}
			if(isSet($_POST['pickupBookingTripID2']) && !is_null($_POST['pickupBookingTripID2']) && $_POST['pickupBookingTripID2'] > 0){
				$pickupDate2 = date ("Y-m-d", strtotime($_POST['pickupDate2']));
				$sqlquery = "
					UPDATE bookingTrip SET 
						noOfLuggage='{$_POST['pickupnoOfLuggage2']}',
						noOfCarryOnItems='{$_POST['pickupnoOfCarryOnItems2']}',
						airline='{$_POST['pickupairline2']}',
						flightNumber='{$_POST['pickupflight2']}',
						flightTime='{$_POST['pickupflightTime2']}',
						pickupDate='{$pickupDate2}',
						pickupTime='{$_POST['pickupTime2']}'						
					WHERE 
						bookingTripID = '{$_POST['pickupBookingTripID2']}';
				";
				$query = $this->db->query($sqlquery);			
			}
			if(isSet($_POST['dropoffBookingTripID2']) && !is_null($_POST['dropoffBookingTripID2']) && $_POST['dropoffBookingTripID2'] > 0){
				$sqlquery = "
					UPDATE bookingTrip SET 
						noOfLuggage_dropoff='{$_POST['dropoffnoOfLuggage2']}',
						noOfCarryOnItems_dropoff='{$_POST['dropoffnoOfCarryOnItems2']}',
						airline_dropoff='{$_POST['dropoffairline2']}',
						flightNumber_dropoff='{$_POST['dropoffflight2']}',
						flightTime_dropoff='{$_POST['dropoffflightTime2']}'
					WHERE 
						bookingTripID = '{$_POST['dropoffBookingTripID2']}';
				";
				$query = $this->db->query($sqlquery);			
			}			
		}
		/* when draft */
		if($_POST['bookingStatusID'] == 3){
			$sqlquery = "
				UPDATE booking SET 
					bookingStatusID={$_POST['bookingStatusID']},
					userID=-1,
					noOfPassenger={$_POST['passengers']},
					miles={$_POST['miles']},
					cost={$_POST['cost']},
					tipPercentage={$_POST['billingTipPercentage']},
					tipAmount={$_POST['tipAmount']},
					discount={$_POST['discountAmount']},
					totalCost={$_POST['totalCost']},
					vehicleTypeID='{$_POST['vehicleTypeID']}',
					billingAddress1='{$_POST['billingAddress']}',
					billingAddress2='{$_POST['billingAddressLine2']}',
					billingCity='{$_POST['billingCity']}',
					billingState='{$_POST['billingState']}',
					billingZip='{$_POST['billingZip']}',";
					if($_POST['bookingStatusID'] != 3){
						$sqlquery .= "	
						ccName='{$_POST['cardHolderName']}',
						ccExpirationMonth='{$_POST['expirationMonth']}',
						ccExpirationYear='{$_POST['expirationYear']}',
						ccNumber='XXXXXXXXXX".substr($_POST['billingCard'], -4)."',";
					}
					else{
						$sqlquery .= "	
						ccName=NULL,
						ccExpirationMonth=NULL,
						ccExpirationYear=NULL,
						ccNumber=NULL,";
					}
			$sqlquery .= "	
					internalNotes='{$_POST['internalNotes']}',
					notes='{$_POST['specialInstructions']}',
					passengerName='{$_POST['passengerName']}',
					emailAddress='{$_POST['emailAddress']}',
					cellPhone='{$_POST['cellPhone']}',
					trip={$_POST['trip']},
					bookingSource='Phone',
					paymentMethod='{$_POST['paymentMethod']}',
					dateUpdated=now()
				WHERE 
					bookingID = '{$_POST['bookingID']}';
			";
			$query = $this->db->query($sqlquery);
			$query = $this->db->query("DELETE FROM bookingTrip WHERE bookingID = '{$_POST['bookingID']}';");		
			$this->resetAddresses();
			$data = array(
				"bookingID" => $_POST['bookingID'], 
				"pickAirportID" => $_POST['pickup1AirportID'],
				"pickAddress1" => $_POST['pickup1Address1'],
				"pickAddress2" => $_POST['pickup1Address2'],
				"pickCity" => $_POST['pickup1City'],
				"pickState" => $_POST['pickup1State'],
				"pickZipcode" => $_POST['pickup1Zip'],
				"dropAirportID" => $_POST['dropoff1AirportID'],
				"dropAddress1" => $_POST['dropoff1Address1'],
				"dropAddress2" => $_POST['dropoff1Address2'],
				"dropCity" => $_POST['dropoff1City'],
				"dropState" => $_POST['dropoff1State'],
				"dropZipcode" => $_POST['dropoff1Zip'],
				"tripLeg" => "first",
				"noOfLuggage" => $_POST['pickupnoOfLuggage1'],
				"noOfCarryOnItems" => $_POST['pickupnoOfCarryOnItems1'],
				"airline" => $_POST['pickupairline1'],
				"flightNumber" => $_POST['pickupflight1'],
				"flightTime" => $_POST['pickupflightTime1'],
				"noOfLuggage_dropoff" => $_POST['dropoffnoOfLuggage1'],
				"noOfCarryOnItems_dropoff" => $_POST['dropoffnoOfCarryOnItems1'],
				"airline_dropoff" => $_POST['dropoffairline1'],
				"flightNumber_dropoff"=> $_POST['dropoffflight1'],
				"flightTime_dropoff" => $_POST['dropoffflightTime1'],
				"pickupDate" =>  date ("Y-m-d", strtotime($_POST['pickupDate1'])),
				"pickupTime" => $_POST['pickupTime1']
			);
			$this->addBookingTrip($data);
			if(isset($_POST['otherLocation'])){	
				$data = array(
					"bookingID" => $_POST['bookingID'], 
					"pickAirportID" => $_POST['pickup2AirportID'],
					"pickAddress1" => $_POST['pickup2Address1'],
					"pickAddress2" => $_POST['pickup2Address2'],
					"pickCity" => $_POST['pickup2City'],
					"pickState" => $_POST['pickup2State'],
					"pickZipcode" => $_POST['pickup2Zip'],
					"dropAirportID" => $_POST['dropoff2AirportID'],
					"dropAddress1" => $_POST['dropoff2Address1'],
					"dropAddress2" => $_POST['dropoff2Address2'],
					"dropCity" => $_POST['dropoff2City'],
					"dropState" => $_POST['dropoff2State'],
					"dropZipcode" => $_POST['dropoff2Zip'],
					"tripLeg" => "second",
					"noOfLuggage" => $_POST['pickupnoOfLuggage2'],
					"noOfCarryOnItems" => $_POST['pickupnoOfCarryOnItems2'],
					"airline" => $_POST['pickupairline2'],
					"flightNumber" => $_POST['pickupflight2'],
					"flightTime" => $_POST['pickupflightTime2'],
					"noOfLuggage_dropoff" => $_POST['dropoffnoOfLuggage2'],
					"noOfCarryOnItems_dropoff" => $_POST['dropoffnoOfCarryOnItems2'],
					"airline_dropoff" => $_POST['dropoffairline2'],
					"flightNumber_dropoff"=> $_POST['dropoffflight2'],
					"flightTime_dropoff" => $_POST['dropoffflightTime2'],
					"pickupDate" =>  date ("Y-m-d", strtotime($_POST['pickupDate2'])),
					"pickupTime" => $_POST['pickupTime2']
				);
				$this->addBookingTrip($data);		
			}
			else if($_POST['trip'] == 2){
				$data = array(
					"bookingID" => $_POST['bookingID'], 
					"driverID" => $_POST['driverID1'],
					"vehicleID" => $_POST['vehicleID1'],
					"pickAirportID" => $_POST['dropoff1AirportID'],
					"pickAddress1" => $_POST['dropoff1Address1'],
					"pickAddress2" => $_POST['dropoff1Address2'],
					"pickCity" => $_POST['dropoff1City'],
					"pickState" => $_POST['dropoff1State'],
					"pickZipcode" => $_POST['dropoff1Zip'],
					"dropAirportID" => $_POST['pickup1AirportID'],
					"dropAddress1" => $_POST['pickup1Address1'],
					"dropAddress2" => $_POST['pickup1Address2'],
					"dropCity" => $_POST['pickup1City'],
					"dropState" => $_POST['pickup1State'],
					"dropZipcode" => $_POST['pickup1Zip'],
					"tripLeg" => "second",
					"noOfLuggage" => $_POST['dropoffnoOfLuggage1'],
					"noOfCarryOnItems" => $_POST['dropoffnoOfCarryOnItems1'],
					"airline" => $_POST['dropoffairline1'],
					"flightNumber" => $_POST['dropoffflight1'],
					"flightTime" => $_POST['dropoffflightTime1'],
					"noOfLuggage_dropoff" => $_POST['pickupnoOfLuggage1'],
					"noOfCarryOnItems_dropoff" => $_POST['pickupnoOfCarryOnItems1'],
					"airline_dropoff" => $_POST['pickupairline1'],
					"flightNumber_dropoff"=> $_POST['pickupflight1'],
					"flightTime_dropoff" => $_POST['pickupflightTime1'],
					"pickupDate" =>  date ("Y-m-d", strtotime($_POST['pickupDate2'])),
					"pickupTime" => $_POST['pickupTime2']
				);
				$this->addBookingTrip($data);		
			}			
		}
		else{
			$query = $this->db->query("
				UPDATE booking SET 
					bookingStatusID={$_POST['bookingStatusID']},
					internalNotes='{$_POST['internalNotes']}'
				WHERE 
					bookingID = '{$_POST['bookingID']}';
			");
		}	
		/* update trip 1 driver / vehicle */
		if(isset($_POST['vehicleID1']) && $_POST['vehicleID2'] > 0){
		$query = $this->db->query("
			UPDATE bookingTrip SET 
				vehicleID='{$_POST['vehicleID1']}',
				driverID='{$_POST['driverID1']}'
			WHERE 
				bookingID = '{$_POST['bookingID']}'
			AND
				tripLeg = 'first';
		");
		}
		/* update trip 2 driver / vehicle */
		if(isset($_POST['vehicleID2']) && $_POST['vehicleID2'] > 0){
		$query = $this->db->query("
			UPDATE bookingTrip SET 
				vehicleID='{$_POST['vehicleID2']}',
				driverID='{$_POST['driverID2']}'
			WHERE 
				bookingID = '{$_POST['bookingID']}'
			AND
				tripLeg = 'second';
		");
		}
		// when payment already process with Auth_ONLY & user want to change the status with confirmed
		if ($_POST['isProcessed'] == 1 && $_POST['bookingStatusID'] == 2){
			$sqlbooking = "SELECT booking.* FROM booking WHERE booking.bookingID = ?"; 
			$querybooking=(array)$this->db->query($sqlbooking, array($_POST['bookingID']))->row();
			// check is previous transaction is AUTH_ONLY
			if($querybooking['paymentMethod'] == 'CC' && $querybooking['transactionType'] == "AUTH_ONLY"){
				if( $_SERVER['REMOTE_ADDR'] == '14.202.154.67'){
					$post_values = array(
						"x_login" => "4up5Tp9Un",
						"x_tran_key" => "7Y58Cw8wBb9S452d",
						"x_version"			=> "3.1",
						"x_delim_data"		=> "TRUE",
						"x_delim_char"		=> "|",
						"x_relay_response"	=> "FALSE",		
						"x_type"			=> "PRIOR_AUTH_CAPTURE",
						"x_method"			=> "CC",
						"x_Trans_ID"		=> $querybooking['authNetTransactionID']
					);	
				}
				else{
					$post_values = array(
						"x_login" => "4up5Tp9Un",
						"x_tran_key" => "7Y58Cw8wBb9S452d",
						"x_version"			=> "3.1",
						"x_delim_data"		=> "TRUE",
						"x_delim_char"		=> "|",
						"x_relay_response"	=> "FALSE",		
						"x_type"			=> "PRIOR_AUTH_CAPTURE",
						"x_method"			=> "CC",
						"x_Trans_ID"		=> $querybooking['authNetTransactionID']
					);
				}
				$response_array = $this->auth_capture($post_values);
				$authNetResponse = implode("|",$response_array);
				if($response_array[0] == 1 && $response_array[3] == 'This transaction has been approved.'){
					$query = $this->db->query("
						UPDATE booking SET 
							authNetKey='{$response_array[37]}',
							transactionType='PRIOR_AUTH_CAPTURE',
							authNetResponse='{$authNetResponse}'
						WHERE 
							bookingID = '{$_POST['bookingID']}';
					");
					return true;
				}
				else{
					return false;
				}
			}
			else {
				return true;			
			}
		}
		else if (($_POST['bookingStatusID'] != 3 && $_POST['bookingStatusID'] != 4) && isset($_POST['paymentMethod']) && $_POST['paymentMethod'] == 'CC') {
			// IF STATUS IS CONFIRMED
			if($_POST['bookingStatusID'] == 2){
				$x_type = "AUTH_CAPTURE";
			}
			else{
				$x_type = "AUTH_ONLY";
			}
			if($_POST['isProcessed'] == 0){
			
				// Test mode
				if( $_SERVER['REMOTE_ADDR'] == '14.202.154.67'){
					$post_values = array(
						"x_login" => "4up5Tp9Un",
						"x_tran_key" => "7Y58Cw8wBb9S452d",
						"x_version"			=> "3.1",
						"x_delim_data"		=> "TRUE",
						"x_delim_char"		=> "|",
						"x_relay_response"	=> "FALSE",		
						"x_type"			=> $x_type,
						"x_method"			=> "CC",
						"x_card_num"		=> $_POST['billingCard'],
						"x_exp_date"		=> $_POST['expirationMonth'].$_POST['expirationYear'],		
						"x_amount"			=> $_POST['totalCost'],
						"x_first_name"		=> $_POST['passengerName'],
						"x_last_name"		=> "",
						"x_address"			=> $_POST['billingAddress'] . ' ' . $_POST['billingAddressLine2'] . ', ' . $_POST['billingCity'],
						"x_state"			=> $_POST['billingState'],
						"x_email"			=> $_POST['emailAddress'],
						"x_phone"			=> $_POST['cellPhone'],
						"x_cust_id"			=> "Booking # " . $_POST['bookingID']
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
						"x_amount"			=> $_POST['totalCost'],
						"x_first_name"		=> $_POST['passengerName'],
						"x_last_name"		=> "",
						"x_address"			=> $_POST['billingAddress'] . ' ' . $_POST['billingAddressLine2'] . ', ' . $_POST['billingCity'],
						"x_state"			=> $_POST['billingState'],
						"x_email"			=> $_POST['emailAddress'],
						"x_phone"			=> $_POST['cellPhone'],
						"x_cust_id"			=> "Booking # " . $_POST['bookingID']
					);					
				}
			
				$response_array = $this->auth_capture($post_values);
				$authNetResponse = implode("|",$response_array);
				if($response_array[0] == 1 && $response_array[3] == 'This transaction has been approved.' && $response_array[6] > 0){
					$query = $this->db->query("
						UPDATE booking SET 
							billingAddress1='{$_POST['billingAddress']}',
							billingAddress2='{$_POST['billingAddressLine2']}',
							billingCity='{$_POST['billingCity']}',
							billingState='{$_POST['billingState']}',
							billingZip='{$_POST['billingZip']}',
							ccName='{$_POST['cardHolderName']}',
							ccExpirationMonth='{$_POST['expirationMonth']}',
							ccExpirationYear='{$_POST['expirationYear']}',
							ccNumber='XXXXXXXXXX" . substr($_POST['billingCard'], -4) . "',
							authNetKey='{$response_array[37]}',
							authNetTransactionID='{$response_array[6]}',
							authNetResponse='{$authNetResponse}',
							transactionType='{$x_type}',
							paymentMethod='CC'
						WHERE 
							bookingID = '{$_POST['bookingID']}';
					");
					return true;
				}
				else{
					return false;
				}		
			}
			else{
				return true;
			} 
		} else {
			return true;	
		}
	}
	public function insert(){
		
		$bookingID = $this->saveBooking();
		$query = $this->db->query("DELETE FROM bookingTrip WHERE bookingID = '{$bookingID}';");		
		$this->resetAddresses();
		$data = array(
			"bookingID" => $bookingID, 
			"pickAirportID" => $_POST['pickup1AirportID'],
			"pickAddress1" => $_POST['pickup1Address1'],
			"pickAddress2" => $_POST['pickup1Address2'],
			"pickCity" => $_POST['pickup1City'],
			"pickState" => $_POST['pickup1State'],
			"pickZipcode" => $_POST['pickup1Zip'],
			"dropAirportID" => $_POST['dropoff1AirportID'],
			"dropAddress1" => $_POST['dropoff1Address1'],
			"dropAddress2" => $_POST['dropoff1Address2'],
			"dropCity" => $_POST['dropoff1City'],
			"dropState" => $_POST['dropoff1State'],
			"dropZipcode" => $_POST['dropoff1Zip'],
			"tripLeg" => "first",
			"noOfLuggage" => $_POST['pickupnoOfLuggage1'],
			"noOfCarryOnItems" => $_POST['pickupnoOfCarryOnItems1'],
			"airline" => $_POST['pickupairline1'],
			"flightNumber" => $_POST['pickupflight1'],
			"flightTime" => $_POST['pickupflightTime1'],
			"noOfLuggage_dropoff" => $_POST['dropoffnoOfLuggage1'],
			"noOfCarryOnItems_dropoff" => $_POST['dropoffnoOfCarryOnItems1'],
			"airline_dropoff" => $_POST['dropoffairline1'],
			"flightNumber_dropoff"=> $_POST['dropoffflight1'],
			"flightTime_dropoff" => $_POST['dropoffflightTime1'],
			"pickupDate" =>  date ("Y-m-d", strtotime($_POST['pickupDate1'])),
			"pickupTime" => $_POST['pickupTime1']
		);
		$this->addBookingTrip($data);
		if(isset($_POST['otherLocation'])){	
			$data = array(
				"bookingID" => $bookingID, 
				"pickAirportID" => $_POST['pickup2AirportID'],
				"pickAddress1" => $_POST['pickup2Address1'],
				"pickAddress2" => $_POST['pickup2Address2'],
				"pickCity" => $_POST['pickup2City'],
				"pickState" => $_POST['pickup2State'],
				"pickZipcode" => $_POST['pickup2Zip'],
				"dropAirportID" => $_POST['dropoff2AirportID'],
				"dropAddress1" => $_POST['dropoff2Address1'],
				"dropAddress2" => $_POST['dropoff2Address2'],
				"dropCity" => $_POST['dropoff2City'],
				"dropState" => $_POST['dropoff2State'],
				"dropZipcode" => $_POST['dropoff2Zip'],
				"tripLeg" => "second",
				"noOfLuggage" => $_POST['pickupnoOfLuggage2'],
				"noOfCarryOnItems" => $_POST['pickupnoOfCarryOnItems2'],
				"airline" => $_POST['pickupairline2'],
				"flightNumber" => $_POST['pickupflight2'],
				"flightTime" => $_POST['pickupflightTime2'],
				"noOfLuggage_dropoff" => $_POST['dropoffnoOfLuggage2'],
				"noOfCarryOnItems_dropoff" => $_POST['dropoffnoOfCarryOnItems2'],
				"airline_dropoff" => $_POST['dropoffairline2'],
				"flightNumber_dropoff"=> $_POST['dropoffflight2'],
				"flightTime_dropoff" => $_POST['dropoffflightTime2'],
				"pickupDate" =>  date ("Y-m-d", strtotime($_POST['pickupDate2'])),
				"pickupTime" => $_POST['pickupTime2']
			);
			$this->addBookingTrip($data);		
		}
		else if($_POST['trip'] == 2){
			$data = array(
				"bookingID" => $bookingID, 
				"pickAirportID" => $_POST['dropoff1AirportID'],
				"pickAddress1" => $_POST['dropoff1Address1'],
				"pickAddress2" => $_POST['dropoff1Address2'],
				"pickCity" => $_POST['dropoff1City'],
				"pickState" => $_POST['dropoff1State'],
				"pickZipcode" => $_POST['dropoff1Zip'],
				"dropAirportID" => $_POST['pickup1AirportID'],
				"dropAddress1" => $_POST['pickup1Address1'],
				"dropAddress2" => $_POST['pickup1Address2'],
				"dropCity" => $_POST['pickup1City'],
				"dropState" => $_POST['pickup1State'],
				"dropZipcode" => $_POST['pickup1Zip'],
				"tripLeg" => "second",
				"noOfLuggage" => $_POST['dropoffnoOfLuggage1'],
				"noOfCarryOnItems" => $_POST['dropoffnoOfCarryOnItems1'],
				"airline" => $_POST['dropoffairline1'],
				"flightNumber" => $_POST['dropoffflight1'],
				"flightTime" => $_POST['dropoffflightTime1'],
				"noOfLuggage_dropoff" => $_POST['pickupnoOfLuggage1'],
				"noOfCarryOnItems_dropoff" => $_POST['pickupnoOfCarryOnItems1'],
				"airline_dropoff" => $_POST['pickupairline1'],
				"flightNumber_dropoff"=> $_POST['pickupflight1'],
				"flightTime_dropoff" => $_POST['pickupflightTime1'],
				"pickupDate" =>  date ("Y-m-d", strtotime($_POST['pickupDate2'])),
				"pickupTime" => $_POST['pickupTime2']
			);
			$this->addBookingTrip($data);		
		}
		if ($_POST['paymentMethod'] == 'CC') {
			
			// IF STATUS IS CONFIRMED
			if($_POST['bookingStatusID'] == 2){
				$x_type = "AUTH_CAPTURE";
			}
			else{
				$x_type = "AUTH_ONLY";
			}
			
			// TEST MODE
			if( $_SERVER['REMOTE_ADDR'] == '14.202.154.67'){
				$post_values = array(
					"x_login" => "4up5Tp9Un",
					"x_tran_key" => "7Y58Cw8wBb9S452d",
					"x_version"			=> "3.1",
					"x_delim_data"		=> "TRUE",
					"x_delim_char"		=> "|",
					"x_relay_response"	=> "FALSE",		
					"x_type"			=> $x_type,
					"x_method"			=> "CC",
					"x_card_num"		=> $_POST['billingCard'],
					"x_exp_date"		=> $_POST['expirationMonth'].$_POST['expirationYear'],		
					"x_amount"			=> $_POST['totalCost'],
					"x_first_name"		=> $_POST['passengerName'],
					"x_last_name"		=> "",
					"x_address"			=> $_POST['billingAddress'] . ' ' . $_POST['billingAddressLine2'] . ', ' . $_POST['billingCity'],
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
					"x_amount"			=> $_POST['totalCost'],
					"x_first_name"		=> $_POST['passengerName'],
					"x_last_name"		=> "",
					"x_address"			=> $_POST['billingAddress'] . ' ' . $_POST['billingAddressLine2'] . ', ' . $_POST['billingCity'],
					"x_state"			=> $_POST['billingState'],
					"x_email"			=> $_POST['emailAddress'],
					"x_phone"			=> $_POST['cellPhone'],
					"x_cust_id"			=> "Booking # " . $bookingID
				);
			}				
				
			if($_POST['bookingStatusID'] != 3 && $_POST['isProcessed'] == 0){
				$response_array = $this->auth_capture($post_values);
				$authNetResponse = implode("|",$response_array);
				if($response_array[1] == 1 && $response_array[3] == 'This transaction has been approved.' && $response_array[6] > 0){
					$query = $this->db->query("
						UPDATE booking SET 
							authNetKey='{$response_array[37]}',
							authNetTransactionID='{$response_array[6]}',
							authNetResponse='{$authNetResponse}',
							transactionType='{$x_type}',
							paymentMethod='CC'
						WHERE 
							bookingID = '{$bookingID}';
					");
					return $bookingID;
				}
				else{
					return -1;
				}		
			} else{
					return $bookingID;
			}
		} else {
			$query = $this->db->query("
				UPDATE booking SET 
					bookingStatusID={$_POST['bookingStatusID']},
					authNetKey='CASH',
					authNetTransactionID='CASH',
					transactionType='CASH',
					paymentMethod='CASH'
				WHERE 
					bookingID = '{$bookingID}';
			");
			return $bookingID;
		}
		
	}
	private function saveBooking(){
		date_default_timezone_set('America/Chicago');
			
		if(isset($_POST['billingTipPercentage']) && $_POST['billingTipPercentage'] == ''){
			$_POST['billingTipPercentage'] = '0';
		}
		if($_POST['bookingID'] > 0){
			$query = $this->db->query("
				UPDATE booking SET 
					bookingStatusID={$_POST['bookingStatusID']},
					userID=-1,
					noOfPassenger={$_POST['passengers']},
					miles='{$_POST['miles']}',
					cost='{$_POST['cost']}',
					tipPercentage='{$_POST['billingTipPercentage']}',
					tipAmount='{$_POST['tipAmount']}',
					discount='{$_POST['discountAmount']}',
					totalCost='{$_POST['totalCost']}',
					billingAddress1='{$_POST['billingAddress']}',
					billingAddress2='{$_POST['billingAddressLine2']}',
					billingCity='{$_POST['billingCity']}',
					billingState='{$_POST['billingState']}',
					billingZip='{$_POST['billingZip']}',
					ccName='{$_POST['cardHolderName']}',
					ccExpirationMonth='{$_POST['expirationMonth']}',
					ccExpirationYear='{$_POST['expirationYear']}',
					ccNumber='XXXXXXXXXX" . substr($_POST['billingCard'], -4) . "',
					notes='{$_POST['specialInstructions']}',
					internalNotes='{$_POST['internalNotes']}',
					passengerName='{$_POST['passengerName']}',
					emailAddress='{$_POST['emailAddress']}',
					cellPhone='{$_POST['cellPhone']}',
					trip='{$_POST['trip']}',
					vehicleTypeID='{$_POST['vehicleTypeID']}',
					paymentMethod='{$_POST['paymentMethod']}'
				WHERE 
					bookingID = '{$_POST['bookingID']}';
			");
			return $_POST['bookingID'];		
		}	
		else{
			$sqlquery = "
				INSERT INTO booking (
					bookingStatusID,
					userID,
					noOfPassenger,
					miles,
					cost,
					tipPercentage,
					tipAmount,
					discount,
					totalCost,
					billingAddress1,
					billingAddress2,
					billingCity,
					billingState,
					billingZip,
					ccName,
					ccExpirationMonth,
					ccExpirationYear,
					ccNumber,
					internalNotes,
					notes,
					passengerName,
					emailAddress,
					cellPhone,
					trip,
					bookingSource,
					vehicleTypeID,
					paymentMethod,
					dateCreated			
				)
				VALUES (
					'{$_POST['bookingStatusID']}',
					'-1',
					'{$_POST['passengers']}',
					" . $_POST['miles'] . ",
					" . $_POST['cost'] . ",
					" . $_POST['billingTipPercentage'] . ",
					" . $_POST['tipAmount'] . ",
					" . $_POST['discountAmount'] . ",						
					" . $_POST['totalCost'] . ",						
					'{$this->db->escape_like_str($_POST['billingAddress'])}',
					'{$this->db->escape_like_str($_POST['billingAddressLine2'])}',
					'{$this->db->escape_like_str($_POST['billingCity'])}',
					'{$this->db->escape_like_str($_POST['billingState'])}',
					'{$this->db->escape_like_str($_POST['billingZip'])}',";
			if($_POST['bookingStatusID'] != 3){
				$sqlquery .= "'{$_POST['cardHolderName']}',";
				$sqlquery .= "'{$_POST['expirationMonth']}',";
				$sqlquery .= "'{$_POST['expirationYear']}',";
				$sqlquery .= "'XXXXXXXXXX" . substr($_POST['billingCard'], -4) . "',";
			}
			else{
				$sqlquery .="NULL,NULL,NULL,NULL,";
			}
			$sqlquery .= "		
					'{$this->db->escape_like_str($_POST['internalNotes'])}',	
					'{$this->db->escape_like_str($_POST['specialInstructions'])}',	
					'{$this->db->escape_like_str($_POST['passengerName'])}',
					'{$_POST['emailAddress']}',
					'{$_POST['cellPhone']}',	
					'{$_POST['trip']}',	
					'Phone',	
					'{$_POST['vehicleTypeID']}',
					'{$_POST['paymentMethod']}',				
					now());
			";
			$query = $this->db->query($sqlquery);
			return $this->db->insert_id();
		}
	}
	private function addBookingTrip($data){
		$sql = "INSERT INTO bookingTrip (
				bookingID, 
				pickAirportID,
				pickAddress1, 
				pickAddress2, 
				pickCity, 
				pickState, 
				pickZipcode, 
				dropAirportID,
				dropAddress1, 
				dropAddress2, 
				dropCity, 
				dropState, 
				dropZipcode, 
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
				tripLeg,
				dateCreated
			) VALUES (
				'{$data['bookingID']}'";
				if($data['pickAirportID'] == ''){$sql = $sql . ',NULL';}else{$sql = $sql . "," . $data['pickAirportID'];}	
				if($data['pickAddress1'] == ''){$sql = $sql . ',NULL';}else{$sql = $sql . ",'" . $this->db->escape_like_str($data['pickAddress1']) . "'";}	
				if($data['pickAddress2'] == ''){$sql = $sql . ',NULL';}else{$sql = $sql . ",'" . $this->db->escape_like_str($data['pickAddress2']) . "'";}	
				if($data['pickCity'] == ''){$sql = $sql . ',NULL';}else{$sql = $sql . ",'" . $this->db->escape_like_str($data['pickCity']) . "'";}	
				if($data['pickState'] == ''){$sql = $sql . ',NULL';}else{$sql = $sql . ",'" . $this->db->escape_like_str($data['pickState']) . "'";}	
				if($data['pickZipcode'] == ''){$sql = $sql . ',NULL';}else{$sql = $sql . ",'" . $this->db->escape_like_str($data['pickZipcode']) . "'";}	
				if($data['dropAirportID'] == ''){$sql = $sql . ',NULL';}else{$sql = $sql . "," . $data['dropAirportID'];}	
				if($data['dropAddress1'] == ''){$sql = $sql . ',NULL';}else{$sql = $sql . ",'" . $this->db->escape_like_str($data['dropAddress1']) . "'";}	
				if($data['dropAddress2'] == ''){$sql = $sql . ',NULL';}else{$sql = $sql . ",'" . $this->db->escape_like_str($data['dropAddress2']) . "'";}	
				if($data['dropCity'] == ''){$sql = $sql . ',NULL';}else{$sql = $sql . ",'" . $this->db->escape_like_str($data['dropCity']) . "'";}	
				if($data['dropState'] == ''){$sql = $sql . ',NULL';}else{$sql = $sql . ",'" . $this->db->escape_like_str($data['dropState']) . "'";}	
				if($data['dropZipcode'] == ''){$sql = $sql . ',NULL';}else{$sql = $sql . ",'" . $this->db->escape_like_str($data['dropZipcode']) . "'";}					
				if($data['pickupDate'] == ''){$sql = $sql . ',NULL';}else{$sql = $sql . ",'" . $data['pickupDate'] . "'";}	
				if($data['pickupTime'] == ''){$sql = $sql . ',NULL';}else{$sql = $sql . ",'" .  date('H:i:s', strtotime($data['pickupTime'])) . "'";}	
				if($data['noOfLuggage'] == ''){$sql = $sql . ',NULL';}else{$sql = $sql . ",'" . $data['noOfLuggage'] . "'";}	
				if($data['noOfCarryOnItems'] == ''){$sql = $sql . ',NULL';}else{$sql = $sql . ",'" . $data['noOfCarryOnItems'] . "'";}	
				if($data['airline'] == ''){$sql = $sql . ',NULL';}else{$sql = $sql . ",'" . $data['airline'] . "'";}	
				if($data['flightNumber'] == ''){$sql = $sql . ',NULL';}else{$sql = $sql . ",'" . $data['flightNumber'] . "'";}	
				if($data['flightTime'] == ''){$sql = $sql . ',NULL';}else{$sql = $sql . ",'" . $data['flightTime'] . "'";}	
				if($data['noOfLuggage_dropoff'] == ''){$sql = $sql . ',NULL';}else{$sql = $sql . ",'" . $data['noOfLuggage_dropoff'] . "'";}	
				if($data['noOfCarryOnItems_dropoff'] == ''){$sql = $sql . ',NULL';}else{$sql = $sql . ",'" . $data['noOfCarryOnItems_dropoff'] . "'";}
				if($data['airline_dropoff'] == ''){$sql = $sql . ',NULL';}else{$sql = $sql . ",'" . $data['airline_dropoff'] . "'";}
				if($data['flightNumber_dropoff'] == ''){$sql = $sql . ',NULL';}else{$sql = $sql . ",'" . $data['flightNumber_dropoff'] . "'";}
				if($data['flightTime_dropoff'] == ''){$sql = $sql . ',NULL';}else{$sql = $sql . ",'" . $data['flightTime_dropoff'] . "'";}
				if($data['tripLeg'] == ''){$sql = $sql . ',NULL';}else{$sql = $sql . ",'" . $data['tripLeg'] . "'";}
				$sql = $sql . ",now());"; 
		$bookingTripID = $this->db->query($sql);
		return $this->db->insert_id();
	}
	/*
	private function saveUser(){
		$userID = $this->isUserExists($_POST['emailAddress']);
		if($userID > 0){
			$passengerName = explode(" ",$_POST['passengerName']);
			$this->db->query("
				UPDATE user SET 
					firstName='{$passengerName[0]}',
					lastName='{$passengerName[1]}',
					phone='{$_POST['cellPhone']}'
				WHERE
					userID = '{$userID}'
			");
			return $userID;
		}
		else{
			$passengerName = explode(" ",$_POST['passengerName']);
			$this->db->query("
				INSERT INTO user (userName,password,firstName,lastName,email,phone,isActive,dateCreated)
				VALUES ('{$_POST['emailAddress']}','". rand() ."','{$passengerName[0]}','{$passengerName[1]}','{$_POST['emailAddress']}','{$_POST['cellPhone']}',1,now());
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
	}*/
	private function auth_capture($post_values){
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
		$post_response = curl_exec($request); 
		curl_close ($request); 
		$response_array = explode($post_values["x_delim_char"],$post_response);
		/*		
		if( $_SERVER['REMOTE_ADDR'] == '14.202.154.67'){
			print_r($post_url);
			print_r('<br>');
			print_r('<br>');
			print_r($post_string);
			print_r('<br>');
			print_r('<br>');
			print_r($response_array);
			exit;		
		}
		*/
		return $response_array;
	}
	
	public function getCost(){
		
		
		
		if(isset($_POST['otherLocation']) && $_POST['otherLocation'] == 1){
			$firstLeg_distance = $this->getDistance($_POST['pickup1AirportID'], $_POST['pickup1Address1'], $_POST['pickup1City'], $_POST['pickup1State'], $_POST['pickup1Zip'], $_POST['dropoff1AirportID'], $_POST['dropoff1Address1'], $_POST['dropoff1City'], $_POST['dropoff1State'], $_POST['dropoff1Zip']);
			$secondLeg_distance = $this->getDistance($_POST['pickup2AirportID'], $_POST['pickup2Address1'], $_POST['pickup2City'], $_POST['pickup2State'], $_POST['pickup2Zip'], $_POST['dropoff2AirportID'], $_POST['dropoff2Address1'], $_POST['dropoff2City'], $_POST['dropoff2State'], $_POST['dropoff2Zip']);
			$totalDistance = $firstLeg_distance+$secondLeg_distance;
			$round_tripcost = $this->getTripCost($totalDistance, 'round', $_POST['pickup2Zip'], $_POST['dropoff2Zip'], $_POST['passengers']);
			$data['tripcost'] = $round_tripcost;
			$data['distance'] = $totalDistance;
			$data['passengers'] = $_POST['passengers'];
		}
		else if(isset($_POST['trip']) && $_POST['trip'] == 2){
			$oneway_distance = $this->getDistance($_POST['pickup1AirportID'], $_POST['pickup1Address1'], $_POST['pickup1City'], $_POST['pickup1State'], $_POST['pickup1Zip'], $_POST['dropoff1AirportID'], $_POST['dropoff1Address1'], $_POST['dropoff1City'], $_POST['dropoff1State'], $_POST['dropoff1Zip']);
			$oneway_tripcost = $this->getTripCost($oneway_distance, 'round', $_POST['pickup1Zip'], $_POST['dropoff1Zip'], $_POST['passengers']);
			$data['tripcost'] = $oneway_tripcost;
			$data['distance'] = $oneway_distance + $oneway_distance ;
			$data['passengers'] = $_POST['passengers'];
		}
		else{
			$oneway_distance = $this->getDistance($_POST['pickup1AirportID'], $_POST['pickup1Address1'], $_POST['pickup1City'], $_POST['pickup1State'], $_POST['pickup1Zip'], $_POST['dropoff1AirportID'], $_POST['dropoff1Address1'], $_POST['dropoff1City'], $_POST['dropoff1State'], $_POST['dropoff1Zip']);
			$oneway_tripcost = $this->getTripCost($oneway_distance, 'oneway', $_POST['pickup1Zip'], $_POST['dropoff1Zip'], $_POST['passengers']);
			$data['tripcost'] = $oneway_tripcost;
			$data['distance'] = $oneway_distance;
			$data['passengers'] = $_POST['passengers'];
		}
		$data['cost'] = 0;
		
		if(isset($data['tripcost'][0]['vehicleType' . $_POST['vehicleTypeID']])){
			$data['cost'] = $data['tripcost'][0]['vehicleType' . $_POST['vehicleTypeID']];
			if($_POST['trip'] == 2){
				$data['cost'] = $data['cost'] + $data['cost'];	
			}
		}
		if(!isset($_POST['priceCalculationType'])){
			if (isset($_POST['tripCostField'])  && $_POST['tripCostField'] > 0)
			{
				$data['cost'] =$_POST['tripCostField'];
			}
		}
		$data['discount'] = 0;
		$data['totalcost'] = $data['cost'];
		if(isset($_POST['billingTipPercentage']) && $_POST['billingTipPercentage'] > 0 && $data['cost'] > 0){
			$data['tipAmount'] = $data['cost'] / 100 * $_POST['billingTipPercentage'];
			$data['totalcost'] = $data['totalcost'] + $data['tipAmount'];
		}
		if(isset($_POST['discount']) && $_POST['discount'] > 0){
			$data['discount'] = $_POST['discount'];
			$data['totalcost'] = $data['totalcost'] - $data['discount'];
		}
		return $data;
	}
	
	public function getDistance($pickUp_airport, $pickUp_address, $pickUp_city, $pickUp_state, $pickUp_zip, $dropOff_airport, $dropOff_address, $dropOff_city, $dropOff_state, $dropOff_zip){
		if($pickUp_airport){
			//Select Airport address from DB
			$pickUp_airport_data = $this->get_airport_by_airportCode($pickUp_airport);
			$pickUp_airport_address = $pickUp_airport_data[0]['address'];
			$pickUp_airport_city = $pickUp_airport_data[0]['city'];
			$pickUp_airport_state = $pickUp_airport_data[0]['state'];
			$pickUp_airport_zip = $pickUp_airport_data[0]['zip'];
			$source = urlencode($pickUp_airport_address . ',' . $pickUp_airport_city. ',' . $pickUp_airport_state . ',' . $pickUp_airport_zip);
		}else{
			$source = urlencode($pickUp_address . ',' . $pickUp_city. ',' . $pickUp_state . ',' . $pickUp_zip);
		}
		if($dropOff_airport){
			//Select Airport address from DB
			$dropOff_airport_data = $this->get_airport_by_airportCode($dropOff_airport);
			$dropOff_airport_address = $dropOff_airport_data[0]['address'];
			$dropOff_airport_city = $dropOff_airport_data[0]['city'];
			$dropOff_airport_state = $dropOff_airport_data[0]['state'];
			$dropOff_airport_zip = $dropOff_airport_data[0]['zip'];
			$destionation = urlencode($dropOff_airport_address . ',' . $dropOff_airport_city. ',' . $dropOff_airport_state . ',' . $dropOff_airport_zip);
		}else{
			$destionation = urlencode($dropOff_address . ',' . $dropOff_city. ',' . $dropOff_state . ',' . $dropOff_zip);
		}
		$url = 'https://maps.googleapis.com/maps/api/directions/json?origin=' . str_replace(' ', '', $source) . '&destination=' . str_replace(' ', '', $destionation) . '&key=AIzaSyCn8yMOqSzp_aT8H0stLwAig9fW1C5HLl8&mode=driving';
		$var = json_decode(file_get_contents($url), true);
		if(isset($var['routes'][0]['legs'][0]['distance']['text'])){
			$distance = ceil(substr($var['routes'][0]['legs'][0]['distance']['text'], 0, count($var['routes'][0]['legs'][0]['distance']['text']) - 3));
			return $distance; 
		}
		else{
			return 0;
		}
	}
	public function get_airport_by_airportCode($airport){
		$query = $this->db->query("
			SELECT	name, address, city, state, zip
			FROM	airports
			WHERE	id = '{$airport}'
		");
		return $query->result_array();
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
		
		$qryPickupSurchage = $this->select_Surcharge_Pickup($pickUp_zip);
		$qryDropoffSurchage = $this->select_Surcharge_Pickup( $dropOff_zip);
		
		if ((count($qryPickupSurchage) > 0 && $qryPickupSurchage[0]['surchargeType'] == 'startsOrEnds') 
			|| (count($qryDropoffSurchage) > 0 && $qryDropoffSurchage[0]['surchargeType'] == 'startsOrEnds') )
		{
			if ($type == 'oneway'){
				$surcharge += $qryPickupSurchage[0]['oneWaySurcharge'];
			} else {
				$surcharge += $qryPickupSurchage[0]['roundTripSurcharge'];
			}
		}
		elseif (count($qryPickupSurchage) > 0 &&  $qryPickupSurchage[0]['surchargeType'] == 'startsAndEnds' && count($qryDropoffSurchage) > 0 && $qryDropoffSurchage[0]['surchargeType'] == 'startsAndEnds') {
			$surcharge += $qryPickupSurchage[0]['roundTripSurcharge'];
		}
		elseif (count($qryPickupSurchage) > 0 &&  $qryPickupSurchage[0]['surchargeType'] == 'personalquote' && count($qryDropoffSurchage) > 0 && $qryDropoffSurchage[0]['surchargeType'] == 'personalquote') {
			$getCost = false;
		}
		if ($getCost == false) {
			$distance = 0;
		}
		
		$vehiclePrices = $this->select_Price_By_distance($distance, $surcharge);
		
		return $vehiclePrices;
	}
	public function select_Price_By_distance($distance, $surcharge){
		if ($distance < 11)
		{
			$query = $this->db->query("
			SELECT	(40)+{$surcharge} as economy, 
					(45)+{$surcharge} as private_van, 
					(50)+{$surcharge} as luxury_sedan,
					(40)+{$surcharge} as vehicleType1, 
					(45)+{$surcharge} as vehicleType2, 
					(50)+{$surcharge} as vehicleType3
			");
		} else {
			$query = $this->db->query("
				SELECT	({$distance}*economy_price)+{$surcharge} as vehicleType1, 
						({$distance}*van_price)+{$surcharge} as vehicleType2, 
						({$distance}*luxury_price)+{$surcharge} as vehicleType3
				FROM	prices
				WHERE	mile = '{$distance}'
			");
		}
		return $query->result_array();
	} 	
	public function select_Surcharge_Pickup($pickUp_zip){
		$query = $this->db->query("
			SELECT	roundTripSurcharge, oneWaySurcharge, surchargeType, personalQuote
			FROM 	surcharge
			WHERE	1=1
			AND '{$pickUp_zip}' BETWEEN startZip and endZip
			ORDER BY sortOrder

		");
		return $query->result_array();
	}
	public function select_Surcharge_Dropoff($dropOff_zip){
		$query = $this->db->query("
			SELECT	roundTripSurcharge, oneWaySurcharge, surchargeType, personalQuote
			FROM 	surcharge
			WHERE	1=1 
			AND '{$dropOff_zip}' BETWEEN startZip and endZip
			ORDER BY sortOrder
		");
		return $query->result_array();
	}
	public function get_vehicles(){
		$sql = "SELECT		 *
				FROM 		vehicle ORDER BY vehicleTypeID,year,make,model,vehiclePlate"; 
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	public function get_drivers(){
		$sql = "SELECT		 *
				FROM 		driver ORDER BY firstName,lastName"; 
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	public function get_vehicle($vehicleID){
		$sql = "SELECT		 *
				FROM 		vehicle WHERE vehicleID = " . $vehicleID; 
		$query=$this->db->query($sql);
		return $query;
	}
	public function resetAddresses(){
		if($_POST['pickup1Location'] == 1){
			$_POST['pickup1Address1'] = '';$_POST['pickup1Address2'] = '';$_POST['pickup1City'] = '';$_POST['pickup1State'] = '';$_POST['pickup1Zip'] = '';
		}
		else{
			$_POST['pickup1AirportID'] = '';
		}
		if($_POST['dropoff1Location'] == 1){
			$_POST['dropoff1Address1'] = '';$_POST['dropoff1Address2'] = '';$_POST['dropoff1City'] = '';$_POST['dropoff1State'] = '';$_POST['dropoff1Zip'] = '';
		}
		else{
			$_POST['dropoff1AirportID'] = '';
		}
		if($_POST['pickup2Location'] == 1){
			$_POST['pickup2Address1'] = '';$_POST['pickup2Address2'] = '';$_POST['pickup2City'] = '';$_POST['pickup2State'] = '';$_POST['pickup2Zip'] = '';
		}
		else{
			$_POST['pickup2AirportID'] = '';
		}
		if($_POST['dropoff2Location'] == 1){
			$_POST['dropoff2Address1'] = '';$_POST['dropoff2Address2'] = '';$_POST['dropoff2City'] = '';$_POST['dropoff2State'] = '';$_POST['dropoff2Zip'] = '';
		}
		else{
			$_POST['dropoff2AirportID'] = '';
		}
	}
}


/*
oroginal
$post_values = array(
	"x_login" => "49wv6tWCe",
	"x_tran_key" => "9WA362vj689CUfmc",
	"x_version"			=> "3.1",
	"x_delim_data"		=> "TRUE", 
	"x_delim_char"		=> "|",
	"x_relay_response"	=> "FALSE",		
	"x_type"			=> "PRIOR_AUTH_CAPTURE",
	"x_method"			=> "CC",
	"x_Trans_ID"		=> $querybooking['authNetTransactionID']
); 
dummy
$post_values = array(
	"x_login" => "4wvSU7pA262h",
	"x_tran_key" => "5a4SzNRf4U48M8sB",
	"x_version"			=> "3.1",
	"x_delim_data"		=> "TRUE",
	"x_delim_char"		=> "|",
	"x_relay_response"	=> "FALSE",		
	"x_type"			=> "PRIOR_AUTH_CAPTURE",
	"x_method"			=> "CC",
	"x_Trans_ID"		=> $querybooking['authNetTransactionID']
);	

*/

?>