<?php if($action == 'view'){ ?>
<h3 class="header smaller lighter blue"><?php echo $title ?></h3>
<div class="row">
	<div class="col-sm-12 text-right" style="margin:0 0 10px 0;">
		<a href="javascript:void(0);" onclick="window.open('/app/admin/index.php/waybills/printWayBill/<?php echo $qryBooking['bookingID']; ?>');" class="btn btn-warning"><i class="fa fa-file-pdf-o"></i> Print</a>
	</div>
</div>        
<?php }?>
<form method="post" action="<?php echo $formAction; ?>" id="formReservation">
	<!-- 
	<fieldset id="tripcostcontainer1">
		<?php 
			if($bookingID > 0){
		?>
		<div class="row">
			<h4 class="header green" style="margin-left: 13px; margin-right: 13px;">Trip Cost</h4>
			<div class="col-xs-12">
				<div class="table-responsive">
					<table id="costtable" class="table table-striped table-bordered table-hover" id="sample-table-1"
						cost="<?php if(isset($qryBooking['cost'])){ echo $qryBooking['cost'];}else{ echo '0';} ?>" 
						tipamount="<?php if(isset($qryBooking['tipAmount'])){ echo $qryBooking['tipAmount'];}else{ echo '0';} ?>" 
						totalCost="<?php if(isset($qryBooking['totalCost'])){ echo $qryBooking['totalCost'];}else{ echo '0';} ?>" 
						miles="<?php echo $qryBooking['miles'] ?>"
					>
						<thead>
							<tr>
								<th># of Passenger</th>
								<th>Miles</th>
								<th>Trip Cost</th>
								<th>Tip</th>
								<th>Total Fare</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td id="noOfPassengerContainer"><?php echo $qryBooking['noOfPassenger'] ?></td>
								<td><?php echo $qryBooking['miles'] ?> miles</td>
								<td>$<?php if(isset($qryBooking['cost'])){ echo $qryBooking['cost'];}else{ echo '0';} ?></td>
								<td>$<?php if(isset($qryBooking['tipAmount'])){ echo $qryBooking['tipAmount'];}else{ echo '0';} ?></td>
								<td>$<?php if(isset($qryBooking['totalCost'])){ echo $qryBooking['totalCost'];}else{ echo '0';} ?></td>
							</tr>							
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<?php 
			}
		?>
	</fieldset>
	 -->
	<fieldset>
		<div class="row">
			<div class="col-sm-12">
				<div class="widget-box">
					<div class="widget-header">
						<h4>General Information</h4>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<!--  
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">	
										<div class="<?php if(($bookingID > 0 && count($qryBookingTrip) < 2) || $bookingID == 0){ echo 'checkedRadio';}else{echo'plainRadio';} ?>"><span><span></span></span> One Way</div>
										<div class="<?php if($bookingID > 0 && count($qryBookingTrip) > 1){ echo 'checkedRadio';}else{echo'plainRadio';} ?>"><span><span></span></span> Round Trip</div>
									</div>	
								</div>	
						    </div>
						    -->						    
						    <div class="row">
						    	<div class="col-sm-4">
									<div class="form-group">
										<label for="vehicleID"> Vehicle: <span class="req">*</span></label>
										<?php 
											foreach($qryVehicles as $vehicle){
												if(count($qryBooking) > 0 && $qryBooking['vehicleID'] == $vehicle['vehicleID']){
													echo '<div class="printc">' . $vehicle['year'] . ' ' . $vehicle['make'] . ' ' . $vehicle['model'] . ' (' . $vehicle['vehiclePlate'] . ')</div>';
												}
											}
										?>
								    </div>						
							    </div>						
						    	<div class="col-sm-2">
									<div class="form-group">
										<label for="passengers"> # of Passengers: <span class="req">*</span></label>
										<?php 
											for($i=1;$i<=20;$i = $i + 1){
												if(count($qryBooking) > 0 && $qryBooking['noOfPassenger'] == $i){
													echo '<div class="printc">'.$i.'</div>';
												}
											}
										?>
								    </div>
							    </div>
								<div class="col-sm-4">
									<div class="form-group">
										<label for="driverID"> Driver: <span class="req">*</span></label>
										<?php 
											foreach($qryDrivers as $driver){
												if(count($qryBooking) > 0 && $qryBooking['driverID'] == $driver['driverID']){
													echo '<div class="printc">' . $driver['firstName'] . ' ' . $driver['lastName'] . '</div>';
												}
											}
										?>
								    </div>
							    </div>
								<div class="col-sm-2">
									<div class="form-group">
										<label for="bookingStatusID"> Booking Status: <span class="req">*</span></label>
										<?php 
											foreach($qryBookingStatuses as $status){
												if(count($qryBooking) > 0 && $qryBooking['bookingStatusID'] == $status['bookingStatusID']){
													echo '<div class="printc">'.$status['bookingStatus'].'</div>';
												}
											}
										?>
								    </div>
							    </div>
						    </div>
						</div>
					</div>
				</div>
			</div>
		</div>				
	</fieldset>
	<fieldset>	
		<?php 
			
			
			for($count=1;$count<=2;$count++){
			$dbIndex = $count-1;
		?>			
			<div id="location<?php echo $count; ?>" class="row" 
					<?php 
					if($count == 2 && !isSet($qryBookingTrip[1])){
						
						 echo 'style="display:none;"'; } 
					?>
				
				>
				<?php 
					if($count == 1){
				?>
				<h4 class="header green" style="margin-left: 13px; margin-right: 13px;">Initial Trip Details</h4>
				<?php 
					}
					else{
				?>
				<h4 class="header green" style="margin-left: 13px; margin-right: 13px;">Return Trip Details</h4>
				<?php 
					}
				?>
				<div class="col-sm-6">
					<div class="widget-box">
						<div class="widget-header">
							<h4>Pickup Location</h4>
						</div>
						<div class="widget-body">
							<div class="widget-main">	
								<!-- 						
								<div class="form-group">	
									<div class="<?php if(!isSet($qryBookingTrip[$dbIndex]) || (isSet($qryBookingTrip[$dbIndex]) && ( !is_null($qryBookingTrip[$dbIndex]['pickAirportID']) && $qryBookingTrip[$dbIndex]['pickAirportID'] > 0  ) )){echo 'checkedRadio';}else{echo'plainRadio';} ?>"><span><span></span></span> Airport / Ports of Calls</div>
									<div class="<?php if(isSet($qryBookingTrip[$dbIndex]) && ( is_null($qryBookingTrip[$dbIndex]['pickAirportID']) || $qryBookingTrip[$dbIndex]['pickAirportID'] == 0 || $qryBookingTrip[$dbIndex]['pickAirportID'] == '' ) ){echo 'checkedRadio';}else{echo'plainRadio';} ?>"><span><span></span></span> Address</div>							
								</div>	
								-->	
							    <div  id="pickupAirport<?php echo $count; ?>" class="row" <?php if(isSet($qryBookingTrip[$dbIndex]) && ( is_null($qryBookingTrip[$dbIndex]['pickAirportID']) || $qryBookingTrip[$dbIndex]['pickAirportID'] == 0 || $qryBookingTrip[$dbIndex]['pickAirportID'] == '' ) ){echo 'style="display:none;"';} ?>>
							    	<div class="col-sm-12">						
									    <div class="form-group">
											<label for="pickup<?php echo $count; ?>AirportID">Airport : <span class="req">*</span></label>
											<?php 
												foreach($qryAirports as $airport){
													if(isSet($qryBookingTrip[$dbIndex]['pickAirportID']) && $qryBookingTrip[$dbIndex]['pickAirportID'] == $airport['id']){
														echo '<div class="printc"> ' . $airport['name'] . ' </div>';
													}
												}
											?>
									    </div>
									</div>  	
									<div class="col-sm-12 col-md-6">
										<div class="form-group">
											<label for="luggage">Number of Checked in Luggage:</label>
											<?php 
												for($i=0;$i<=10;$i = $i + 1){
													if(isSet($qryBookingTrip[$dbIndex])  && $qryBookingTrip[$dbIndex]['noOfLuggage'] == $i){
														echo '<div class="printc"> ' . $i . ' </div>';
													}
												}
											?>
									    </div>
									</div>
									<div class="col-sm-12 col-md-6">
										<div class="form-group">
											<label for="carryOnItems">Number of Carry-on items: </label>
											<?php 
												for($i=0;$i<=10;$i = $i + 1){
													if(isSet($qryBookingTrip[$dbIndex])  && $qryBookingTrip[$dbIndex]['noOfCarryOnItems'] == $i){
														echo '<div class="printc"> ' . $i . ' </div>';
													}
												}
											?>
									    </div>
									</div>								
									<div class="col-sm-4">
										<div class="form-group">
											<label for="airline">Airline:</label>
											<div class="printc"><?php if(isSet($qryBookingTrip[$dbIndex])){ echo $qryBookingTrip[$dbIndex]['airline']; } ?></div>
									    </div>
									</div>
									<div class="col-sm-4 ">
										<div class="form-group">
											<label for="flight">Flight#:</label>
											<div class="printc"><?php if(isSet($qryBookingTrip[$dbIndex])){ echo $qryBookingTrip[$dbIndex]['flightnumber']; } ?></div>
									    </div>
									</div>
									<div class="col-sm-4 ">
										<div class="form-group">
											<label for="flightTime">Flight Time:</label>
											<div class="printc"><?php if(isSet($qryBookingTrip[$dbIndex])){ echo $qryBookingTrip[$dbIndex]['flighttime']; } ?></div>
									    </div>								
									</div>	
							    </div>		
							    <div id="pickupResidence<?php echo $count; ?>" class="row" <?php if(!isSet($qryBookingTrip[$dbIndex]) || (isSet($qryBookingTrip[$dbIndex]) && ( !is_null($qryBookingTrip[$dbIndex]['pickAirportID']) && $qryBookingTrip[$dbIndex]['pickAirportID'] > 0  ) )){echo 'style="display:none;"';} ?>>
							    	<div class="col-sm-12">						
									    <div class="form-group">
											<label for="pickup<?php echo $count; ?>Address1">Address: <span class="req">*</span></label>
											<div class="printc"><?php if (isSet($qryBookingTrip[$dbIndex])) { echo $qryBookingTrip[$dbIndex]['pickAddress1']; } ?></div>
									    </div>
									    <div class="form-group">
											<label for="pickup<?php echo $count; ?>Address2">Address Line2:</label>
											<div class="printc"><?php if (isSet($qryBookingTrip[$dbIndex])) { echo $qryBookingTrip[$dbIndex]['pickAddress2']; } ?></div>
									    </div>
									    <div class="form-group">
										    <div class="row">
												<div class="col-sm-4">
													<div class="form-group">
														<label for="pickup<?php echo $count; ?>City">City: <span class="req">*</span></label>
														<div class="printc"><?php if (isSet($qryBookingTrip[$dbIndex])) { echo $qryBookingTrip[$dbIndex]['pickCity']; } ?></div>
												    </div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label for="pickup<?php echo $count; ?>State">State: <span class="req">*</span></label>
														<div class="printc"><?php if (isSet($qryBookingTrip[$dbIndex])) { echo $qryBookingTrip[$dbIndex]['pickState']; } ?></div>
												    </div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label for="pickup<?php echo $count; ?>Zip">ZIP: <span class="req">*</span></label>
														<div class="printc"><?php if (isSet($qryBookingTrip[$dbIndex])) { echo $qryBookingTrip[$dbIndex]['pickZipcode']; }?></div>
												    </div>
												</div>
											</div>
										</div>
									</div>	
								</div>	
							</div>
						</div>
					</div>				
				</div>
				<div class="col-sm-6">
					<div class="widget-box">
						<div class="widget-header">
							<h4>Drop Off Location</h4>
						</div>
						<div class="widget-body">
							<div class="widget-main">
								<!-- 
								<div class="form-group">	
									<div class="<?php if(!isSet($qryBookingTrip[$dbIndex]) || (isSet($qryBookingTrip[$dbIndex]) && ( !is_null($qryBookingTrip[$dbIndex]['dropAirportID']) && $qryBookingTrip[$dbIndex]['dropAirportID'] > 0  ) )){echo 'checkedRadio';}else{echo'plainRadio';} ?>"><span><span></span></span> Airport / Ports of Calls</div>
									<div class="<?php if(isSet($qryBookingTrip[$dbIndex]) && ( is_null($qryBookingTrip[$dbIndex]['dropAirportID']) || $qryBookingTrip[$dbIndex]['dropAirportID'] == 0 || $qryBookingTrip[$dbIndex]['dropAirportID'] == '' ) ){echo 'checkedRadio';}else{echo'plainRadio';} ?>"><span><span></span></span> Address</div>							
								</div>		
								-->
								<div id="dropoffAirport<?php echo $count; ?>" class="row" <?php if(isSet($qryBookingTrip[$dbIndex]) && ( is_null($qryBookingTrip[$dbIndex]['dropAirportID']) || $qryBookingTrip[$dbIndex]['dropAirportID'] == 0 || $qryBookingTrip[$dbIndex]['dropAirportID'] == '' ) ){echo 'style="display:none;"';} ?>>
							    	<div class="col-sm-12">						
									    <div class="form-group">
											<label for="dropoff<?php echo $count; ?>AirportID">Airport : <span class="req">*</span></label>
											<?php 
												foreach($qryAirports as $airport){
													if(isSet($qryBookingTrip[$dbIndex]) && $qryBookingTrip[$dbIndex]['dropAirportID'] == $airport['id']){
														echo '<div class="printc">'. $airport['name'] . '</div>';
													}
												}
											?>
									    </div>
								    </div>
								    <div class="col-sm-12 col-md-6">
										<div class="form-group">
											<label for="luggage">Number of Checked in Luggage: </label>										
											<?php 
												for($i=0;$i<=10;$i = $i + 1){
													if(isSet($qryBookingTrip[$dbIndex]) && $qryBookingTrip[$dbIndex]['noOfLuggage_dropoff'] == $i){
														echo '<div class="printc">' . $i . '</div>';
													}
												}
											?>
									    </div>
									</div>
									<div class="col-sm-12 col-md-6">
										<div class="form-group">
											<label for="carryOnItems">Number of Carry-on items: </label>
											<?php 
												for($i=0;$i<=10;$i = $i + 1){
													if(isSet($qryBookingTrip[$dbIndex]) &&  $qryBookingTrip[$dbIndex]['noOfCarryOnItems_dropoff'] == $i){
														echo '<div class="printc">' . $i . '</div>';
													}
												}
											?>
									    </div>
									</div>								
									<div class="col-sm-4">
										<div class="form-group">
											<label for="airline">Airline:</label>
											<div class="printc"><?php if(isSet($qryBookingTrip[$dbIndex])){ echo $qryBookingTrip[$dbIndex]['airline_dropoff']; } ?></div>
									    </div>
									</div>
									<div class="col-sm-4 ">
										<div class="form-group">
											<label for="flight">Flight#:</label>
											<div class="printc"><?php if(isSet($qryBookingTrip[$dbIndex])){ echo $qryBookingTrip[$dbIndex]['flightnumber_dropoff']; } ?></div>
									    </div>
									</div>
									<div class="col-sm-4 ">
										<div class="form-group">
											<label for="flightTime">Flight Time:</label>
											<div class="printc"><?php if(isSet($qryBookingTrip[$dbIndex])){ echo $qryBookingTrip[$dbIndex]['flighttime_dropoff']; } ?></div>
									    </div>								
									</div>							
							    </div>	
							    <div id="dropoffResidence<?php echo $count; ?>" class="row" <?php if(!isset($qryBookingTrip[$dbIndex]) || (isSet($qryBookingTrip[$dbIndex]) && (!is_null($qryBookingTrip[$dbIndex]['dropAirportID']) && $qryBookingTrip[$dbIndex]['dropAirportID'] > 0 ) )){echo 'style="display:none;"';} ?>>
							    	<div class="col-sm-12">					
									    <div class="form-group">
											<label for="dropoff<?php echo $count; ?>Address">Address: <span class="req">*</span></label>
											<div class="printc"><?php  if (isSet($qryBookingTrip[$dbIndex])){ echo $qryBookingTrip[$dbIndex]['dropAddress1']; } ?></div>
									    </div>
									    <div class="form-group">
											<label for="dropoff<?php echo $count; ?>Address2">Address Line2:</label>
											<div class="printc"><?php  if (isSet($qryBookingTrip[$dbIndex])){ echo $qryBookingTrip[$dbIndex]['dropAddress2']; } ?></div>
									    </div>
									    <div class="form-group">
										    <div class="row">
												<div class="col-sm-4">
													<div class="form-group">
														<label for="dropoff<?php echo $count; ?>City">City: <span class="req">*</span></label>
														<div class="printc"><?php  if (isSet($qryBookingTrip[$dbIndex])){ echo $qryBookingTrip[$dbIndex]['dropCity']; } ?></div>
												    </div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label for="dropoff<?php echo $count; ?>State">State: <span class="req">*</span></label>
														<div class="printc"><?php  if (isSet($qryBookingTrip[$dbIndex])){ echo $qryBookingTrip[$dbIndex]['dropState']; } ?></div>
												    </div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label for="dropoff<?php echo $count; ?>Zip">ZIP: <span class="req">*</span></label>
														<div class="printc"><?php  if (isSet($qryBookingTrip[$dbIndex])){ echo $qryBookingTrip[$dbIndex]['dropZipcode']; } ?></div>
												    </div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>				
				</div>
			</div>
		<?php
			}
		?>
	</fieldset>
	<fieldset>
		<div class="row">
			<div class="col-sm-12">
				<div class="widget-box">
					<div class="widget-header">
						<h4>Passenger Information</h4>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<div class="row">
								<div class="col-sm-6 padding-left padding-right" style="margin-top:20px;">
									<div class="form-group">
										<label for="passengerName">Passenger Name: <span class="req">*</span></label>
										<div class="printc"><?php if(isset($qryBooking['passengerName'])){echo $qryBooking['passengerName']; } ?></div>
								    </div>
								    <div class="form-group">
										<label for="emailAddress">Email Address: <span class="req">*</span></label>
										<div class="printc"><?php if(isset($qryBooking['emailAddress'])){ echo $qryBooking['emailAddress'];} ?></div>
								    </div>
								    <div class="form-group">
										<label for="cellPhone">Cell Phone: <span class="req">*</span></label>
										<div class="printc"><?php if(isset($qryBooking['cellPhone'])){ echo $qryBooking['cellPhone'];} ?></div>
								    </div>
								</div>
								<div class="col-sm-6 padding-left padding-right" style="margin-top:20px;">
									<div id="firstTripDatetimeContainer" class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="pickupDate">Pickup Date: <span class="req">*</span></label>
												<div class="printc"><?php if(isset($qryBooking['pickupDate']) && $qryBooking['pickupDate']){ echo $qryBooking['pickupDate'];} ?></div>
										    </div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="pickupTime">Time: <span class="req">*</span></label>
												<div class="printc"><?php if(isset($qryBooking['pickupTime'])){echo $qryBooking['pickupTime'];} ?></div>
										    </div>
										</div>
									</div>
									<div id="secondTripDatetimeContainer" class="row"
									<?php if(($bookingID > 0 && count($qryBookingTrip) == 1) || $bookingID == 0){ echo ' style="display:none;" ';} ?>
									>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="pickupDate">Return Pickup Date: <span class="req">*</span></label>
												<div class="printc"><?php if(isset($qryBooking['returnpickupDate'])){ echo $qryBooking['returnpickupDate'];} ?></div>
										    </div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="pickupTime">Return Time: <span class="req">*</span></label>
												<div class="printc"><?php if(isset($qryBooking['returnpickupTime'])){echo $qryBooking['returnpickupTime'];} ?></div>
										    </div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12 padding-left padding-right">
									<div class="form-group">
										<label for="specialInstructions">Special Instructions:</label>
										<div class="printc"><?php if(count($qryBooking) > 0){ echo $qryBooking['notes']; } ?></div>
								    </div>
								<div>
							</div>
							<div class="row">
								<div class="col-sm-12 padding-left padding-right">
									<div class="form-group">
										<label for="internalNotes">Internal Notes:</label>
										<div class="printc"><?php if(count($qryBooking) > 0){ echo $qryBooking['internalNotes']; } ?></div>
								    </div>
								<div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</fieldset>	
</form>
<style>
	.printc {
		color: #858585;
		/*border: 1px solid #d5d5d5;*/
		padding: 5px 4px 6px;
		font-size: 14px;
		font-family: inherit;
		display: block;
		width: 100%;
		height: 34px;
	}
	div.checkedRadio,
	div.plainRadio {
		display: inline;
	}
	div.checkedRadio span {
		display: inline-block;	    
	    width: 17px;
	    line-height: 15px;
		height: 17px;
		text-align: center;
	    border-radius: 50%;
	    border: 1px solid #c8c8c8; 
	    box-shadow: 0 1px 2px rgba(0,0,0,.05);
	}
	div.checkedRadio span span {
		width: 60%;
		height: 60%;
		background: #32a3ce;
		border: none;		
	}
	div.plainRadio span{
		display: inline-block;	    
	    width: 17px;
	    line-height: 15px;
		height: 17px;
		text-align: center;
	    border-radius: 50%;
	    border: 1px solid #c8c8c8; 
	    box-shadow: 0 1px 2px rgba(0,0,0,.05);
	}
	div.plainRadio span span {
		width: 60%;
		height: 60%;
		background: #f8f8f8;
		border: none;
	}
</style>