<h3 class="header smaller lighter blue"><?php echo $title ?></h3>
<form method="post" action="<?php echo $formAction; ?>" id="formReservation">
	<input type="hidden" name="bookingID" value="<?php echo $bookingID;?>">
	<input type="hidden" name="pricedManual" value="0">
	<input type="hidden" name="userID" value="<?php if(isset($qryBooking['userID'])){ echo $qryBooking['userID'];} ?>">
	<input type="hidden" name="cost" value="<?php if(isset($qryBooking['cost'])){ echo $qryBooking['cost'];}else{ echo '0';} ?>">
	<input type="hidden" name="tipAmount" value="<?php if(isset($qryBooking['tipAmount'])){ echo $qryBooking['tipAmount'];}else{ echo '0';} ?>">
	<input type="hidden" name="discountAmount" value="<?php if(isset($qryBooking['discount'])){ echo $qryBooking['discount'];}else{ echo '0';} ?>">
	<input type="hidden" name="totalCost" value="<?php if(isset($qryBooking['totalCost'])){ echo $qryBooking['totalCost'];}else{ echo '0';} ?>">
	<input type="hidden" name="miles" value="<?php if(isset($qryBooking['miles'])){echo $qryBooking['miles'];} ?>">
	<input type="hidden" name="isProcessed" value="<?php if($action == 'query' && isset($qryBooking['authNetKey']) && $qryBooking['authNetKey'] != ''){ echo '1';}else{ echo '0';} ?>">
	<input type="hidden" name="isDraft" value="<?php if(count($qryBooking) > 0 && $qryBooking['bookingStatusID'] == 3){echo'1';}else{echo'0';}?>" />
	<input type="hidden" name="pStatus" value="<?php if(count($qryBooking) > 0){echo$qryBooking['bookingStatusID'];}else{echo'0';}?>" /> 
		<?php 
			if($bookingID > 0){
		/*
	<fieldset id="tripcostcontainer1">
		
		<div class="row">
			<h4 class="header green" style="margin-left: 13px; margin-right: 13px;">Trip Cost</h4>
	        <div class="row">
	        	<div class="col-sm-12 text-right" style="margin:0 0 10px 0;padding-right:25px;">
	        		<a href="<?php echo site_url('reservation/edit/0') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> New Reservation</a>
	        	</div>
	        </div>
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
								<th>Discount</th>
								<th>Total Fare</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td id="noOfPassengerContainer"><?php echo $qryBooking['noOfPassenger'] ?></td>
								<td><?php echo $qryBooking['miles'] ?> miles</td>
								<td>$<?php if(isset($qryBooking['cost'])){ echo $qryBooking['cost'];}else{ echo '0';} ?></td>
								<td>$<?php if(isset($qryBooking['tipAmount'])){ echo $qryBooking['tipAmount'];}else{ echo '0';} ?></td>
								<td>$<?php if(isset($qryBooking['discount'])){ echo $qryBooking['discount'];}else{ echo '0';} ?></td>
								<td>$<?php if(isset($qryBooking['totalCost'])){ echo $qryBooking['totalCost'];}else{ echo '0';} ?></td>
							</tr>							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	
	</fieldset> */
		
			}
		?>
	<fieldset>
		<div class="row">
			<div class="col-sm-12">
				<div class="widget-box">
					<div class="widget-header">
						<h4>General Information</h4>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">								
										<label class="inline">
											<input type="radio" class="ace" name="trip" value="1" required="true"
											<?php if(($bookingID > 0 && count($qryBookingTrip) < 2) || $bookingID == 0){ echo 'checked="checked"';} ?>
											/>
											<span class="lbl"> One Way </span>
										</label>								
										<label class="inline">
											<input type="radio" class="ace" name="trip" value="2"  required="true"
											<?php if($bookingID > 0 && count($qryBookingTrip) > 1){ echo 'checked="checked"';} ?>
											/>
											<span class="lbl"> Round Trip </span>
										</label>								
									</div>	
								</div>	
								<div id="otherLocationContainer" class="col-sm-3"
							    <?php if($bookingID > 0 && count($qryBookingTrip) < 2){ echo ' style="display:none;"';} ?>
							    >
									<div class="form-group">								
										<label class="inline">
											<input type="checkbox" class="ace" name="otherLocation" value="1"
											<?php if(count($qryBookingTrip) > 1){ echo ' checked="checked" ';} ?>
											/>
											<span class="lbl"> Return Trip Address Is Different </span>
										</label>																	
									</div>	
							    </div>								
						    </div>						     						    
						    <div class="row">
						    	<div class="col-sm-2">
									<div class="form-group">
										<label for="passengers"> # of Passengers: <span class="req">*</span></label>
										<select name="passengers" class="form-control" required="true">
											<?php 
												for($i=1;$i<=20;$i = $i + 1){
													echo '<option value="'.$i.'"';
													if(count($qryBooking) > 0 && $qryBooking['noOfPassenger'] == $i){
														echo ' selected="selected" ';
													}
													echo '>'.$i.'</option>';
												}
											?>
										</select>
								    </div>
							    </div>
								<div class="col-sm-2">
									<div class="form-group">
										<label for="vehicleTypeID"> Vehicle Type: <span class="req">*</span></label>
										<select name="vehicleTypeID" class="form-control" required="true">
											<option value=""></option>
											<?php 
												foreach($vehicleType as $type){
													echo '<option value="'.$type['vehicleTypeID'].'" ';
													if(count($qryBooking) > 0 && $qryBooking['vehicleTypeID'] == $type['vehicleTypeID']){
														echo 'selected';
													}
													echo '>'.$type['vehicleType'].'</option>';
												}
											?>
										</select>
								    </div>
							    </div>
								<div class="col-sm-2">
									<div class="form-group">
										<label for="bookingStatusID"> Booking Status: <span class="req">*</span></label>
										<select name="bookingStatusID" class="form-control" required="true" onchange="disabledValidation(this.value);">
											<?php 
												foreach($qryBookingStatuses as $status){
													echo '<option value="' . $status['bookingStatusID'] . '"';
													if(count($qryBooking) > 0 && $qryBooking['bookingStatusID'] == $status['bookingStatusID']){
														echo ' selected="selected" ';
													}
													echo '>' . $status['bookingStatus'];
													echo '</option>';
												}
											?>
										</select>
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
								<div class="form-group">								
									<label class="inline">
										<?php if(isSet($qryBookingTrip) && count($qryBookingTrip) >= $dbIndex && isSet($qryBookingTrip[$dbIndex]) && !is_null($qryBookingTrip[$dbIndex]['pickAirportID']) && $qryBookingTrip[$dbIndex]['pickAirportID'] > 0 && $qryBookingTrip[$dbIndex]['bookingTripID'] > 0) { ?>					
										<input type="hidden" name="pickupBookingTripID<?php echo$count; ?>" value="<?php echo$qryBookingTrip[$dbIndex]['bookingTripID']; ?>" />										
										<?php } ?>	
										<input type="radio" class="ace" name="pickup<?php echo $count; ?>Location" value="1"  required="true"
										<?php if(!isSet($qryBookingTrip[$dbIndex]) || (isSet($qryBookingTrip[$dbIndex]) && ( !is_null($qryBookingTrip[$dbIndex]['pickAirportID']) && $qryBookingTrip[$dbIndex]['pickAirportID'] > 0  ) )){echo ' checked="checked" ';} ?>
										/>
										<span class="lbl"> Airport / Ports of Calls</span>
									</label>	
									<label class="inline">
										<input type="radio" class="ace" name="pickup<?php echo $count; ?>Location" value="2" required="true"
										<?php if(isSet($qryBookingTrip[$dbIndex]) && ( is_null($qryBookingTrip[$dbIndex]['pickAirportID']) || $qryBookingTrip[$dbIndex]['pickAirportID'] == 0 || $qryBookingTrip[$dbIndex]['pickAirportID'] == '' ) ){echo ' checked="checked" ';} ?>
										/>
										<span class="lbl"> Address</span>
									</label>							
								</div>		
							    <div  id="pickupAirport<?php echo $count; ?>" class="row" <?php if(isSet($qryBookingTrip[$dbIndex]) && ( is_null($qryBookingTrip[$dbIndex]['pickAirportID']) || $qryBookingTrip[$dbIndex]['pickAirportID'] == 0 || $qryBookingTrip[$dbIndex]['pickAirportID'] == '' ) ){echo 'style="display:none;"';} ?>>
							    	<div class="col-sm-12">						
									    <div class="form-group">
											<label for="pickup<?php echo $count; ?>AirportID">Airport : <span class="req">*</span></label>
											<select class="form-control" name="pickup<?php echo $count; ?>AirportID" required="true">
												<option value=""></option>>
												<?php 
													foreach($qryAirports as $airport){
														echo '<option value="' . $airport['id'] . '"';
														if(isSet($qryBookingTrip[$dbIndex]['pickAirportID']) && $qryBookingTrip[$dbIndex]['pickAirportID'] == $airport['id']){
															echo ' selected="selected" ';
														}
														echo '>' . $airport['name'];
														echo '</option>';	
													}
												?>
											</select>
									    </div>
									</div>  	
									<div class="col-sm-12 col-md-6">
										<div class="form-group">
											<label for="luggage">Number of Checked in Luggage:</label>
											<select name="pickupnoOfLuggage<?php echo $count; ?>" id="pickupnoOfLuggage<?php echo $count; ?>" class="form-control">
												<?php 
													for($i=0;$i<=10;$i = $i + 1){
														echo '<option value="'.$i.'"';
														if(isSet($qryBookingTrip[$dbIndex])  && $qryBookingTrip[$dbIndex]['noOfLuggage'] == $i){
															echo ' selected="selected" ';
														}
														echo '>'.$i.'</option>';
													}
												?>
											</select>
									    </div>
									</div>
									<div class="col-sm-12 col-md-6">
										<div class="form-group">
											<label for="carryOnItems">Number of Carry-on items: </label>
											<select name="pickupnoOfCarryOnItems<?php echo $count; ?>" id="pickupCarryOnItems<?php echo $count; ?>" class="form-control">
												<?php 
													for($i=0;$i<=10;$i = $i + 1){
														echo '<option value="'.$i.'"';
														if(isSet($qryBookingTrip[$dbIndex])  && $qryBookingTrip[$dbIndex]['noOfCarryOnItems'] == $i){
															echo ' selected="selected" ';
														}
														echo '>'.$i.'</option>';
													}
												?>
											</select>
									    </div>
									</div>								
									<div class="col-sm-4">
										<div class="form-group">
											<label for="airline">Airline:</label>
											<input type="text" name="pickupairline<?php echo $count; ?>" id="pickupairline<?php echo $count; ?>" class="form-control" value="<?php if(isSet($qryBookingTrip[$dbIndex])){ echo $qryBookingTrip[$dbIndex]['airline']; } ?>" />
									    </div>
									</div>
									<div class="col-sm-4 ">
										<div class="form-group">
											<label for="flight">Flight#:</label>
											<input type="text" name="pickupflight<?php echo $count; ?>" id="pickupflight<?php echo $count; ?>" class="form-control" value="<?php if(isSet($qryBookingTrip[$dbIndex])){ echo $qryBookingTrip[$dbIndex]['flightnumber']; } ?>" />
									    </div>
									</div>
									<div class="col-sm-4 ">
										<div class="form-group">
											<label for="flightTime">Flight Time:</label>
											<input type="text" name="pickupflightTime<?php echo $count; ?>" id="pickupflightTime<?php echo $count; ?>" class="form-control timepicker" value="<?php if(isSet($qryBookingTrip[$dbIndex])){ echo $qryBookingTrip[$dbIndex]['flighttime']; } ?>" />
									    </div>								
									</div>	
							    </div>		
							    <div id="pickupResidence<?php echo $count; ?>" class="row" <?php if(!isSet($qryBookingTrip[$dbIndex]) || (isSet($qryBookingTrip[$dbIndex]) && ( !is_null($qryBookingTrip[$dbIndex]['pickAirportID']) && $qryBookingTrip[$dbIndex]['pickAirportID'] > 0  ) )){echo 'style="display:none;"';} ?>>
							    	<div class="col-sm-12">						
									    <div class="form-group">
											<label for="pickup<?php echo $count; ?>Address1">Address: <span class="req">*</span></label>
											<input type="text" class="form-control" id="pickup<?php echo $count; ?>Address1" name="pickup<?php echo $count; ?>Address1" required="true" aria-required="true" value="<?php if (isSet($qryBookingTrip[$dbIndex])) { echo $qryBookingTrip[$dbIndex]['pickAddress1']; } ?>" />
									    </div>
									    <div class="form-group">
											<label for="pickup<?php echo $count; ?>Address2">Address Line2:</label>
											<input type="text" class="form-control" id="pickup<?php echo $count; ?>Address2" name="pickup<?php echo $count; ?>Address2" value="<?php if (isSet($qryBookingTrip[$dbIndex])) { echo $qryBookingTrip[$dbIndex]['pickAddress2']; } ?>" />
									    </div>
									    <div class="form-group">
										    <div class="row">
												<div class="col-sm-4">
													<div class="form-group">
														<label for="pickup<?php echo $count; ?>City">City: <span class="req">*</span></label>
														<input type="text" class="form-control" id="pickup<?php echo $count; ?>City" name="pickup<?php echo $count; ?>City" required="true" aria-required="true" value="<?php if (isSet($qryBookingTrip[$dbIndex])) { echo $qryBookingTrip[$dbIndex]['pickCity']; } ?>" />
												    </div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label for="pickup<?php echo $count; ?>State">State: <span class="req">*</span></label>
														<input type="text" class="form-control" id="pickup<?php echo $count; ?>State" name="pickup<?php echo $count; ?>State" required="true" aria-required="true" value="<?php if (isSet($qryBookingTrip[$dbIndex])) { echo $qryBookingTrip[$dbIndex]['pickState']; } ?>" />
												    </div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label for="pickup<?php echo $count; ?>Zip">ZIP: <span class="req">*</span></label>
														<input type="text" class="form-control" id="pickup<?php echo $count; ?>Zip" name="pickup<?php echo $count; ?>Zip" required="true" aria-required="true" value="<?php if (isSet($qryBookingTrip[$dbIndex])) { echo $qryBookingTrip[$dbIndex]['pickZipcode']; }?>" />
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
								<div class="form-group">			
									<?php if(isSet($qryBookingTrip) && count($qryBookingTrip) >= $dbIndex && isSet($qryBookingTrip[$dbIndex]) && !is_null($qryBookingTrip[$dbIndex]['dropAirportID']) && $qryBookingTrip[$dbIndex]['dropAirportID'] > 0 && $qryBookingTrip[$dbIndex]['bookingTripID'] > 0) { ?>					
									<input type="hidden" name="dropoffBookingTripID<?php echo$count; ?>" value="<?php echo$qryBookingTrip[$dbIndex]['bookingTripID']; ?>" />										
									<?php } ?>	
									<label class="inline">
										<input type="radio" class="ace" name="dropoff<?php echo $count; ?>Location" value="1" required="true"
										<?php if(!isSet($qryBookingTrip[$dbIndex]) || (isSet($qryBookingTrip[$dbIndex]) && ( !is_null($qryBookingTrip[$dbIndex]['dropAirportID']) && $qryBookingTrip[$dbIndex]['dropAirportID'] > 0  ) )){echo ' checked="checked" ';} ?>
										/>
										<span class="lbl"> Airport / Ports of Calls</span>
									</label>	
									<label class="inline">
										<input type="radio" class="ace" name="dropoff<?php echo $count; ?>Location" value="2" required="true"
										<?php if(isSet($qryBookingTrip[$dbIndex]) && ( is_null($qryBookingTrip[$dbIndex]['dropAirportID']) || $qryBookingTrip[$dbIndex]['dropAirportID'] == 0 || $qryBookingTrip[$dbIndex]['dropAirportID'] == '' ) ){echo ' checked="checked" ';} ?>
										/>
										<span class="lbl"> Address</span>
									</label>							
								</div>		
								<div id="dropoffAirport<?php echo $count; ?>" class="row" <?php if(isSet($qryBookingTrip[$dbIndex]) && ( is_null($qryBookingTrip[$dbIndex]['dropAirportID']) || $qryBookingTrip[$dbIndex]['dropAirportID'] == 0 || $qryBookingTrip[$dbIndex]['dropAirportID'] == '' ) ){echo 'style="display:none;"';} ?>>
							    	<div class="col-sm-12">						
									    <div class="form-group">
											<label for="dropoff<?php echo $count; ?>AirportID">Airport : <span class="req">*</span></label>
											<select class="form-control" name="dropoff<?php echo $count; ?>AirportID" required="true">
												<option value=""></option>>
												<?php 
													foreach($qryAirports as $airport){
														echo '<option value="' . $airport['id'] . '"';
														if(isSet($qryBookingTrip[$dbIndex]) && $qryBookingTrip[$dbIndex]['dropAirportID'] == $airport['id']){
															echo ' selected="selected" ';
														}
														echo '>' . $airport['name'];
														echo '</option>';	
													}
												?>
											</select>
									    </div>
								    </div>
								    <div class="col-sm-12 col-md-6">
										<div class="form-group">
											<label for="luggage">Number of Checked in Luggage: </label>
											<select name="dropoffnoOfLuggage<?php echo $count; ?>" id="dropoffnoOfLuggage<?php echo $count; ?>" class="form-control">
												<?php 
													for($i=0;$i<=10;$i = $i + 1){
														echo '<option value="'.$i.'"';
														if(isSet($qryBookingTrip[$dbIndex]) && $qryBookingTrip[$dbIndex]['noOfLuggage_dropoff'] == $i){
															echo ' selected="selected" ';
														}
														echo '>'.$i.'</option>';
													}
												?>
											</select>
									    </div>
									</div>
									<div class="col-sm-12 col-md-6">
										<div class="form-group">
											<label for="carryOnItems">Number of Carry-on items: </label>
											<select name="dropoffnoOfCarryOnItems<?php echo $count; ?>" id="dropoffnoOfCarryOnItems<?php echo $count; ?>" class="form-control">
												<?php 
													for($i=0;$i<=10;$i = $i + 1){
														echo '<option value="'.$i.'"';
														if(isSet($qryBookingTrip[$dbIndex]) &&  $qryBookingTrip[$dbIndex]['noOfCarryOnItems_dropoff'] == $i){
															echo ' selected="selected" ';
														}
														echo '>'.$i.'</option>';
													}
												?>
											</select>
									    </div>
									</div>								
									<div class="col-sm-4">
										<div class="form-group">
											<label for="airline">Airline:</label>
											<input type="text" name="dropoffairline<?php echo $count; ?>" id="dropoffairline<?php echo $count; ?>" class="form-control" value="<?php if(isSet($qryBookingTrip[$dbIndex])){ echo $qryBookingTrip[$dbIndex]['airline_dropoff']; } ?>" />
									    </div>
									</div>
									<div class="col-sm-4 ">
										<div class="form-group">
											<label for="flight">Flight#:</label>
											<input type="text" name="dropoffflight<?php echo $count; ?>" id="dropoffflight<?php echo $count; ?>" class="form-control" value="<?php if(isSet($qryBookingTrip[$dbIndex])){ echo $qryBookingTrip[$dbIndex]['flightnumber_dropoff']; } ?>" />
									    </div>
									</div>
									<div class="col-sm-4 ">
										<div class="form-group">
											<label for="flightTime">Flight Time:</label>
											<input type="text" name="dropoffflightTime<?php echo $count; ?>" id="dropoffflightTime<?php echo $count; ?>" class="form-control timepicker" value="<?php if(isSet($qryBookingTrip[$dbIndex])){ echo $qryBookingTrip[$dbIndex]['flighttime_dropoff']; } ?>" />
									    </div>								
									</div>							
							    </div>	
							    <div id="dropoffResidence<?php echo $count; ?>" class="row" <?php if(!isset($qryBookingTrip[$dbIndex]) || (isSet($qryBookingTrip[$dbIndex]) && (!is_null($qryBookingTrip[$dbIndex]['dropAirportID']) && $qryBookingTrip[$dbIndex]['dropAirportID'] > 0 ) )){echo 'style="display:none;"';} ?>>
							    	<div class="col-sm-12">					
									    <div class="form-group">
											<label for="dropoff<?php echo $count; ?>Address">Address: <span class="req">*</span></label>
											<input type="text" class="form-control" id="dropoff<?php echo $count; ?>Address1" name="dropoff<?php echo $count; ?>Address1" required="true" aria-required="true" value="<?php  if (isSet($qryBookingTrip[$dbIndex])){ echo $qryBookingTrip[$dbIndex]['dropAddress1']; } ?>" />
									    </div>
									    <div class="form-group">
											<label for="dropoff<?php echo $count; ?>Address2">Address Line2:</label>
											<input type="text" class="form-control" id="dropoff<?php echo $count; ?>Address2" name="dropoff<?php echo $count; ?>Address2" value="<?php  if (isSet($qryBookingTrip[$dbIndex])){ echo $qryBookingTrip[$dbIndex]['dropAddress2']; } ?>" />
									    </div>
									    <div class="form-group">
										    <div class="row">
												<div class="col-sm-4">
													<div class="form-group">
														<label for="dropoff<?php echo $count; ?>City">City: <span class="req">*</span></label>
														<input type="text" class="form-control" id="dropoff<?php echo $count; ?>City" name="dropoff<?php echo $count; ?>City" required="true" aria-required="true" value="<?php  if (isSet($qryBookingTrip[$dbIndex])){ echo $qryBookingTrip[$dbIndex]['dropCity']; } ?>" />
												    </div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label for="dropoff<?php echo $count; ?>State">State: <span class="req">*</span></label>
														<input type="text" class="form-control" id="dropoff<?php echo $count; ?>State" name="dropoff<?php echo $count; ?>State" required="true" aria-required="true" value="<?php  if (isSet($qryBookingTrip[$dbIndex])){ echo $qryBookingTrip[$dbIndex]['dropState']; } ?>" />
												    </div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<label for="dropoff<?php echo $count; ?>Zip">ZIP: <span class="req">*</span></label>
														<input type="text" class="form-control" id="dropoff<?php echo $count; ?>Zip" name="dropoff<?php echo $count; ?>Zip" required="true" aria-required="true" value="<?php  if (isSet($qryBookingTrip[$dbIndex])){ echo $qryBookingTrip[$dbIndex]['dropZipcode']; } ?>" />
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
										<input type="text" required="true" name="passengerName" id="passengerName" class="form-control" value="<?php if(isset($qryBooking['passengerName'])){echo $qryBooking['passengerName']; } ?>" />
								    </div>
								    <div class="form-group">
										<label for="emailAddress">Email Address: <span class="req">*</span></label>
										<input type="text" required="true" name="emailAddress" id="emailAddress" class="form-control" value="<?php if(isset($qryBooking['emailAddress'])){ echo $qryBooking['emailAddress'];} ?>" />
								    </div>
								    <div class="form-group">
										<label for="cellPhone">Cell Phone: <span class="req">*</span></label>
										<input type="text" required="true" name="cellPhone" id="cellPhone" class="form-control input-mask-phone" value="<?php if(isset($qryBooking['cellPhone'])){ echo $qryBooking['cellPhone'];} ?>" />
								    </div>
								</div>
								<div class="col-sm-6 padding-left padding-right" style="margin-top:20px;">
									<div id="firstTripDatetimeContainer" class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="pickupDate">Pickup Date: <span class="req">*</span></label>
												<input type="text" required="true" name="pickupDate1" id="pickupDate1" class="form-control date-picker" value="<?php if(isset($qryBooking['pickupDate']) && $qryBooking['pickupDate']){ echo $qryBooking['pickupDate'];}else{echo date('m/d/Y');} ?>" />
										    </div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="pickupTime">Time: <span class="req">*</span></label>
												<input type="text" required="true" name="pickupTime1" id="pickupTime1" class="form-control timepicker" placeholder="Time" value="<?php if(isset($qryBooking['pickupTime'])){echo $qryBooking['pickupTime'];} ?>" />
										    </div>
										</div>
									</div>
									<div id="secondTripDatetimeContainer" class="row"
									<?php if(($bookingID > 0 && count($qryBookingTrip) == 1) || $bookingID == 0){ echo ' style="display:none;" ';} ?>
									>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="pickupDate">Return Pickup Date: <span class="req">*</span></label>
												<input type="text" required="true" name="pickupDate2" id="pickupDate2" class="form-control date-picker" value="<?php if(isset($qryBooking['returnpickupDate'])){ echo $qryBooking['returnpickupDate'];}else{echo date('m/d/Y');} ?>" />
										    </div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label for="pickupTime">Return Time: <span class="req">*</span></label>
												<input type="text" required="true" name="pickupTime2" id="pickupTime2" class="form-control timepicker" placeholder="Time" value="<?php if(isset($qryBooking['returnpickupTime'])){echo $qryBooking['returnpickupTime'];} ?>" />
										    </div>
										</div>
									</div>
									<div class="form-group">
										<label for="billingTipPercentage">Tip Amount:</label>
										<select name="billingTipPercentage" id="billingTipPercentage" class="form-control">
											<option value="0">Select Tip Amount</option>
											<option value="20"
											<?php if($action == 'query' && $qryBooking['tipPercentage'] == '20.00'){ echo ' selected="selected" ';} ?>
											>20%</option>
											<option value="25"
											<?php if($action == 'query' && $qryBooking['tipPercentage'] == '25.00'){ echo ' selected="selected" ';} ?>
											>25%</option>
											<option value="30"
											<?php if($action == 'query' && $qryBooking['tipPercentage'] == '30.00'){ echo ' selected="selected" ';} ?>
											>30%</option>
											<option value="-1">Tip in Cash</option>										
										</select>
							   		</div>
									
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12 padding-left padding-right">
									<div class="form-group">
										<label for="specialInstructions">Special Instructions:</label>
										<textarea name="specialInstructions" class="form-control" row="6"><?php if(count($qryBooking) > 0){ echo $qryBooking['notes']; } ?></textarea>
								    </div>
								<div>
							</div>
							<div class="row">
								<div class="col-sm-12 padding-left padding-right">
									<div class="form-group">
										<label for="internalNotes">Internal Notes:</label>
										<textarea name="internalNotes" class="form-control" row="6"><?php if(count($qryBooking) > 0){ echo $qryBooking['internalNotes']; } ?></textarea>
								    </div>
								<div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</fieldset>
	<fieldset id="tripcostcontainer2">
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
								<th>Discount</th>
								<th>Total Fare</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td id="noOfPassengerContainer"><?php echo $qryBooking['noOfPassenger'] ?></td>
								<td><?php echo $qryBooking['miles'] ?> miles</td>
								<td>
									$<input type="text" name="tripCostField" value="<?php if(isset($qryBooking['cost'])){ echo $qryBooking['cost'];}else{ echo '0';} ?>" onBlur="updateCosts();" onChange="updateCost()">
									<!--  <label for="priceCalculationType"><input type="checkbox" id="priceCalculationType" name="priceCalculationType" value="1" checked="checked" /> Price auto Calculate</label>-->
								</td>
								<td class="tdTipAmount">$<?php if(isset($qryBooking['tipAmount'])){ echo $qryBooking['tipAmount'];}else{ echo '0';} ?></td>
								<td class="tdDiscount">$<?php if(isset($qryBooking['discount'])){ echo $qryBooking['discount'];}else{ echo '0';} ?></td>
								<td class="tdTotalCost">$<?php if(isset($qryBooking['totalCost'])){ echo $qryBooking['totalCost'];}else{ echo '0';} ?></td>
							</tr>							
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<?php 
			}
			else{
			 echo '<input type="hidden" name="priceCalculationType" value="1" />';
			}
		?>
	</fieldset>
	<fieldset>
		<div class="row">
			<div class="col-sm-12">
				<div class="widget-box">
					<div class="widget-header">
						<h4>Payment Information</h4>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<div class="col-sm-6 padding-left padding-right" style="margin-top:20px;">
								<div class="form-group ccFieldsDiv">
									<label for="cardHolderName">Card Holder's Name: <span class="req ccFieldReq">*</span></label>
									<input type="text" required="true" name="cardHolderName" id="cardHolderName" class="form-control ccField" value="<?php if($action == 'query' && isset($qryBooking['ccName'])){echo $qryBooking['ccName'];} ?>" />
							    </div>
							    <div class="form-group">
									<label for="billingAddress">Billing Address: <span class="req">*</span></label>
									<input type="text" required="true" name="billingAddress" id="billingAddress" class="form-control" value="<?php if(isset($qryBooking['billingAddress1'])){echo $qryBooking['billingAddress1'];} ?>" />
							    </div>
							    <div class="form-group">
									<label for="billingAddressLine2">Address Line2:</label>
									<input type="text" name="billingAddressLine2" id="billingAddressLine2" class="form-control" value="<?php if(isset($qryBooking['billingAddress2'])){echo $qryBooking['billingAddress2'];} ?>" />
							    </div>
							    <div class="form-group">
								    <div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="billingCity">City: <span class="req">*</span></label>
												<input type="text" required="true" name="billingCity" id="billingCity" class="form-control" value="<?php if(isset($qryBooking['billingCity'])){echo $qryBooking['billingCity'];} ?>" />
										    </div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="billingState">State: <span class="req">*</span></label>
												<input type="text" required="true" name="billingState" id="billingState" class="form-control" value="<?php if(isset($qryBooking['billingState'])){echo $qryBooking['billingState'];} ?>" />
										    </div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="billingZip">ZIP: <span class="req">*</span></label>
												<input type="text" required="true" name="billingZip" id="billingZip" class="form-control" value="<?php if(isset($qryBooking['billingZip'])){echo $qryBooking['billingZip'];} ?>" />
										    </div>
										</div>
									</div>
								</div>
								<?php if(isset($qryBooking['bookingID']) && $qryBooking['bookingID'] > 0) { ?>
								<div class="form-group">
									<label for="billingCity">Booking #: </label>
									<?php echo $qryBooking['bookingID'] ;?>
							    </div>
								<?php
								} 
								?>
								<?php if(isset($qryBooking['authNetKey']) && strtolower($qryBooking['authNetKey']) != 'cash' && $qryBooking['authNetKey'] != ''){?>
							    <div class="form-group">
									<label for="billingCity">Auth Net Key: </label>
									<?php echo $qryBooking['authNetKey'] ;?>
							    </div>
								<div class="form-group">
									<label for="billingCity">TransactionID: </label>
									<?php echo $qryBooking['authNetTransactionID'] ;?>
							    </div>
							    <?php if(isset($qryBooking['transactionType']) && $qryBooking['transactionType'] != '') { ?>
							    <div class="form-group">
									<label for="billingCity">Transaction Status: </label>
									<?php if($qryBooking['transactionType'] == 'PRIOR_AUTH_CAPTURE' || $qryBooking['transactionType'] == 'AUTH_CAPTURE'){ echo 'CAPTURED'; }elseif($qryBooking['transactionType'] == 'AUTH_ONLY'){ echo 'AUTH ONLY'; }else{ echo $qryBooking['transactionType']; } ?>
							    </div>
								<?php
								} 
								?>
								<?php
								} 
								?>
							</div>
							<div class="col-sm-6 padding-left padding-right" style="margin-top:20px;">
								<div class="form-group">
										<label for="paymentMethod">Payment Method:</label>
										<select name="paymentMethod" id="paymentMethod" class="form-control">
											
											<option value="CC"
											<?php if($action == 'query' && $qryBooking['paymentMethod'] == 'CC'){ echo ' selected="selected" ';} ?>
											>Credit Card</option>
											<option value="CASH"
											<?php if($action == 'query' && strtolower($qryBooking['paymentMethod']) == 'cash'){ echo ' selected="selected" ';} ?>
											>Cash</option>
																			
										</select>
										<?php
										$footerJs = <<<EOD
										<script>
											$(function() {
												$('select[name="paymentMethod"]').change(function(){
													if ($(this).val() == 'CC')
													{
														$('.ccField').attr('required', 'true');
														$('span.ccFieldReq').text('*');
														$('div.ccFieldsDiv').show();
													}
													else
													{
														$('.ccField').removeAttr('required');
														$('span.ccFieldReq').text('');
														$('div.ccFieldsDiv').hide();
													}
													
												});
												$('select[name="paymentMethod"]').trigger('change');
											});
											
										</script>
EOD;
$footerJs = Array("type"=>"inline", "script"=>$footerJs);
add_header_footer_cssJS('footer_js', $footerJs);
?>
							   		</div>
							    <div class="form-group ccFieldsDiv">
									<label for="billingCard">Credit Card # : <span class="req ccFieldReq">*</span></label>
									<input type="text" required="true" name="billingCard" id="billingCard" class="form-control ccField" value="<?php if(isset($qryBooking['ccNumber'])){echo $qryBooking['ccNumber'];} ?>" />
							    </div>
							    <div class="form-group ccFieldsDiv">
								    <div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="expirationDate">Expiration Month: <span class="req ccFieldReq">*</span></label>
												<select required="true" name="expirationMonth" id="expirationMonth" class="form-control ccField">
													<option value="">Select Month</option>
													<?php 
														for($i=1;$i<=12;$i = $i + 1){
															echo '<option value="'.$i.'"';
															if($action == 'query' && $qryBooking['ccExpirationMonth'] == $i){
																echo ' selected="selected" ';
															}
															echo '>'.$i.'</option>';
														}
													?>
												</select>
										    </div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="expirationYear">Expiration Year: <span class="req ccFieldReq">*</span></label>
												<select required="true" name="expirationYear" id="expirationYear" class="form-control ccField">
													<option value="">Select Year</option>
													<?php 
														for($i=date("Y");$i<=date("Y")+10;$i = $i + 1){
															echo '<option value="'.$i.'"';
															if($action == 'query' && $qryBooking['ccExpirationYear'] == $i){
																echo ' selected="selected" ';
															}
															echo '>'.$i.'</option>';
														}
													?>
												</select>
										    </div>
										</div>
									</div>
								</div>
								<div class="form-group ccFieldsDiv">
								    <div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="cvv2">Cc Security Code: <span class="req ccFieldReq">*</span></label>
												<input type="text" required="true" name="cvv2" id="cvv2" value="<?php if(isset($qryBooking['ccNumber'])){echo substr($qryBooking['ccNumber'],-4);} ?>" class="form-control ccField">
										    </div>
										</div>
										<div class="col-sm-8">
											<div class="form-group">
												<div class="note">(Last 3 digits in signature panel for Visa/Mastercard or 4 digit above account# on front Amex Cards.)</div>
										    </div>
										</div>
									</div>
								</div>
								<div class="form-group">
								    <div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="discount">Discount: </label>
												<input type="text" name="discount" id="discount" class="form-control" value="<?php if(isset($qryBooking['discount'])){echo $qryBooking['discount'];}else{echo'0';}?>" />
										    </div>
										</div>
										<div class="col-sm-8">&nbsp;</div>
									</div>
							    </div>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</fieldset>	
	<div class="clearfix form-actions">
		<div class="col-md-offset-3 col-md-9">
			<button id="btnSubmit" type="submit" onclick="return sendtwilio();" name="save" class="btn btn-primary<?php if(count($qryBooking) > 0 && $qryBooking['bookingStatusID'] == 3){echo' cancel';} ?>">Save Changes</button>
            <button id="btnSubmit" type="submit" name="draft" value="draft" class="btn btn-primary">Save As Draft</button>
			<a href="<?php echo site_url('/reservation') ?>" class="btn btn-default ">Cancel</a>
		</div>
	</div>	
</form>


<?php
$footerJs = <<<EOD
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
<script>
	var map = null;
	var directionDisplay;
	var directionsService = new google.maps.DirectionsService();
	var map2 = null;
	var directionDisplay2;
	var directionsService2 = new google.maps.DirectionsService();
	var placeSearch;
	var componentForm = {
	  street_number: 'short_name',//pickUp_street
	  route: 'long_name',
	  locality: 'long_name',
	  administrative_area_level_1: 'short_name',
	  country: 'long_name',
	  postal_code: 'short_name'
	};	
    function sendtwilio(){
        
        var cellPhone = jQuery('#cellPhone').val();
        var first = cellPhone.substr(1,3);
        var second = cellPhone.substr(6,3); 
        var third = cellPhone.substr(10,4);
        var number = "+1"+first+second+third; 
        jQuery.ajax({
            dataType: 'json',                    
            type: 'post',
            data: {number:number},                    
            url: '/app/sync/twilio.php',
            success: function(reponse){
            }
        });
        return true;
    }	
	function initialize() {
	  directionsDisplay = new google.maps.DirectionsRenderer();
	  directionsDisplay2 = new google.maps.DirectionsRenderer();
	  pickup1Address1 = new google.maps.places.Autocomplete(document.getElementById('pickup1Address1'));
	  pickup2Address1 = new google.maps.places.Autocomplete(document.getElementById('pickup2Address1'));
	  dropoff1Address1 = new google.maps.places.Autocomplete(document.getElementById('dropoff1Address1'));
	  dropoff2Address1 = new google.maps.places.Autocomplete(document.getElementById('dropoff2Address1'));
	  google.maps.event.addListener(pickup1Address1, 'place_changed', function() {
	  	  _addresses(pickup1Address1,'pickup1');	
		  //_pickup1Address1();
		  //update_trip_cost();
	  });
	  google.maps.event.addListener(pickup2Address1, 'place_changed', function() {
	  	  _addresses(pickup2Address1,'pickup2');	
	  	  //_pickup2Address1();
		  //update_trip_cost();
	  });
	  google.maps.event.addListener(dropoff1Address1, 'place_changed', function() {
	      _addresses(dropoff1Address1,'dropoff1');
		  //_dropoff1Address1();
		  update_trip_cost();
	  });
	  google.maps.event.addListener(dropoff2Address1, 'place_changed', function() {
	  	  _addresses(dropoff2Address1,'dropoff2');
		  //_dropoff2Address1();
		  update_trip_cost();
	  });
	}
	initialize() ;
	function _addresses(elem,field) {
		var place = elem.getPlace(),
			address = place.address_components,
			streetAddress = '',
			suburb = '',
			state = '',
			zip = '',
			country = '';
			for (var i = 0; i < address.length; i++) {
	            var addressType = address[i].types[0];
		
	            if (addressType == 'subpremise') {
	            	streetAddress += address[i].long_name + '/';
	            }
	            if (addressType == 'street_number') {
	            	streetAddress += address[i].long_name + ' ';
	            }
	            if (address[i].types[0] == 'route') {
	            	streetAddress += address[i].long_name;
	            }
	            if (addressType == 'locality') {
	            	suburb = address[i].long_name;
	            }
	            if (addressType == 'administrative_area_level_1') {
	            	state = address[i].short_name;
	            }
	            if (addressType == 'postal_code') {
	            	zip = address[i].long_name;
	            }
	            if (addressType == 'country') {
	            	country = address[i].long_name;
	            }
            }			
			setTimeout(function(){
				$('#' + field + 'Address1').val(streetAddress).blur(function(e){			
		            this.value = streetAddress;
        		});
        	},50);
        	document.getElementById(field + 'City').value = suburb;
			document.getElementById(field + 'State').value = state;
			document.getElementById(field + 'Zip').value = zip;
	}
	/*
	function _pickup1Address1() {
		var place = pickup1Address1.getPlace();
		for (var i = 0; i < place.address_components.length; i++) {
		    var addressType = place.address_components[i].types[0];
			
			if(addressType == 'street_number'){
				document.getElementById('pickup1Address2').value = place.address_components[i][componentForm[addressType]];
			}
			else if(addressType == 'route'){
				document.getElementById('pickup1Address2').value = document.getElementById('pickup1Address2').value+' '+place.address_components[i][componentForm[addressType]];
			}
			else if(addressType == 'locality'){
				document.getElementById('pickup1City').value = place.address_components[i][componentForm[addressType]];
			}
			else if(addressType == 'administrative_area_level_1'){
				document.getElementById('pickup1State').value = place.address_components[i][componentForm[addressType]];
			}
			else if(addressType == 'postal_code'){
				document.getElementById('pickup1Zip').value = place.address_components[i][componentForm[addressType]];
			}
		}
	}
	function _pickup2Address1() {
		var place = pickup2Address1.getPlace();
		for (var i = 0; i < place.address_components.length; i++) {
		    var addressType = place.address_components[i].types[0];
			if(addressType == 'street_number'){
				document.getElementById('pickup2Address2').value = place.address_components[i][componentForm[addressType]];
			}
			else if(addressType == 'route'){
				document.getElementById('pickup2Address2').value = document.getElementById('pickup2Address2').value+' '+place.address_components[i][componentForm[addressType]];
			}
			else if(addressType == 'locality'){
				document.getElementById('pickup2City').value = place.address_components[i][componentForm[addressType]];
			}
			else if(addressType == 'administrative_area_level_1'){
				document.getElementById('pickup2State').value = place.address_components[i][componentForm[addressType]];
			}
			else if(addressType == 'postal_code'){
				document.getElementById('pickup2Zip').value = place.address_components[i][componentForm[addressType]];
			}
		}
	}
	function _dropoff1Address1() {
		var place = dropoff1Address1.getPlace();
		for (var i = 0; i < place.address_components.length; i++) {
		    var addressType = place.address_components[i].types[0];
			if(addressType == 'street_number'){
				document.getElementById('dropoff1Address2').value = place.address_components[i][componentForm[addressType]];
			}
			else if(addressType == 'route'){
				document.getElementById('dropoff1Address2').value = document.getElementById('dropoff1Address2').value+' '+place.address_components[i][componentForm[addressType]];
			}
			else if(addressType == 'locality'){
				document.getElementById('dropoff1City').value = place.address_components[i][componentForm[addressType]];
			}
			else if(addressType == 'administrative_area_level_1'){
				document.getElementById('dropoff1State').value = place.address_components[i][componentForm[addressType]];
			}
			else if(addressType == 'postal_code'){
				document.getElementById('dropoff1Zip').value = place.address_components[i][componentForm[addressType]];
			}
		}
	}
	function _dropoff2Address1() {
		var place = dropoff2Address1.getPlace();
		for (var i = 0; i < place.address_components.length; i++) {
		    var addressType = place.address_components[i].types[0];
			if(addressType == 'street_number'){
				document.getElementById('dropoff2Address2').value = place.address_components[i][componentForm[addressType]];
			}
			else if(addressType == 'route'){
				document.getElementById('dropoff2Address2').value = document.getElementById('dropoff2Address2').value+' '+place.address_components[i][componentForm[addressType]];
			}
			else if(addressType == 'locality'){
				document.getElementById('dropoff2City').value = place.address_components[i][componentForm[addressType]];
			}
			else if(addressType == 'administrative_area_level_1'){
				document.getElementById('dropoff2State').value = place.address_components[i][componentForm[addressType]];
			}
			else if(addressType == 'postal_code'){
				document.getElementById('dropoff2Zip').value = place.address_components[i][componentForm[addressType]];
			}
		}
	}
	*/
	function disabledValidation(bookingStatusID){
		if(bookingStatusID == 3){
			jQuery('#btnSubmit').addClass('cancel');
		}
		else{
			jQuery('#btnSubmit').removeClass('cancel');
		}
	}
	tripcodeJS();	
	function tripcodeJS(){
		$('#formReservation input[name="priceCalculationType"]').click(function(){
			if($(this).is(':checked') == true){
				$('#formReservation input[name="tripCostField"]').attr('disabled',true);	
			}
			else{
				$('#formReservation input[name="tripCostField"]').attr('disabled',false);	
			}
			update_trip_cost();
		});
	}
	function update_trip_cost(){
		bookingID = parseInt($('#formReservation input[name="bookingID"]').val());
		isDraft = parseInt($('#formReservation input[name="isDraft"]').val());
		isProcessed = parseInt($('#formReservation input[name="isProcessed"]').val());
		$('#formReservation textarea[name="specialInstructions"]').attr('disabled',false);
		$('#formReservation input[type="text"],#formReservation input[type="radio"],#formReservation input[type="checkbox"], #formReservation select').each(function(){
			$(this).attr('disabled',false);
		});
		if ($('input[name="priceManual"]').val() == 0) {
			$('input[name="tripCostField"]').prop('disabled', true);
		}
		if(bookingID == 0 || isDraft == 1 || isProcessed == 0){
			jQuery.ajax({
				type: 'post',
				url: '/app/admin/index.php/reservation/get_cost_table',
				data: jQuery('#formReservation').serialize(),
				timeout: 20000,
				error: function (XMLHttpRequest, textStatus, errorThrown) {
					//console.log(XMLHttpRequest, textStatus, errorThrown);
				},
				success: function(html){
					jQuery('#formReservation fieldset#tripcostcontainer1').html(html);
					jQuery('#formReservation fieldset#tripcostcontainer2').html(html);
					jQuery('#formReservation input[name="cost"]').val(parseFloat($('#formReservation table#costtable').attr('cost')));
					jQuery('#formReservation input[name="tipAmount"]').val(parseFloat($('#formReservation table#costtable').attr('tipAmount')));
					jQuery('#formReservation input[name="totalCost"]').val(parseFloat($('#formReservation table#costtable').attr('totalCost')));
					jQuery('#formReservation input[name="miles"]').val(parseFloat($('#formReservation table#costtable').attr('miles')));
					jQuery('#formReservation input[name="discountAmount"]').val(parseFloat($('#formReservation table#costtable').attr('discount')));
					tripcodeJS();	
				}
			});			
		}	
		else
		{
			$('#formReservation input[type="text"],#formReservation input[type="radio"],#formReservation input[type="checkbox"], #formReservation select').each(function(){
				$(this).attr('disabled',true);
			});
			$('#formReservation textarea[name="specialInstructions"]').attr('disabled',true);
			$('#formReservation select[name="vehicleID1"]').attr('disabled',false);
			$('#formReservation select[name="driverID1"]').attr('disabled',false);
			$('#formReservation select[name="vehicleID2"]').attr('disabled',false);
			$('#formReservation select[name="driverID2"]').attr('disabled',false);
			$('#formReservation select[name="bookingStatusID"]').attr('disabled',false);
			if(parseInt($('#formReservation input[name="isProcessed"]').val()) == 0){
				$('#formReservation select[name="paymentMethod"]').attr('disabled',false);
				$('#formReservation input[name="cardHolderName"]').attr('disabled',false);
				$('#formReservation input[name="billingAddress"]').attr('disabled',false);
				$('#formReservation input[name="billingAddressLine2"]').attr('disabled',false);
				$('#formReservation input[name="billingCity"]').attr('disabled',false);
				$('#formReservation input[name="billingState"]').attr('disabled',false);
				$('#formReservation input[name="billingZip"]').attr('disabled',false);
				$('#formReservation select[name="billingTipPercentage"]').attr('disabled',false);
				$('#formReservation input[name="billingCard"]').attr('disabled',false);
				$('#formReservation select[name="expirationMonth"]').attr('disabled',false);
				$('#formReservation select[name="expirationYear"]').attr('disabled',false);
				$('#formReservation input[name="cvv2"]').attr('disabled',false);
			}
			// check status was not equal to confirm & cancelled
			if($('#formReservation input[name="pStatus"]').val() != 2 && $('#formReservation input[name="pStatus"]').val() != 4){
				$('#formReservation select[name="passengers"]').attr('disabled',false);
				$('#formReservation select[name="pickupnoOfLuggage1"]').attr('disabled',false);
				$('#formReservation select[name="pickupnoOfCarryOnItems1"]').attr('disabled',false);
				$('#formReservation input[name="pickupairline1"]').attr('disabled',false);
				$('#formReservation input[name="pickupflight1"]').attr('disabled',false);
				$('#formReservation input[name="pickupflightTime1"]').attr('disabled',false);
				
				$('#formReservation select[name="pickupnoOfLuggage2"]').attr('disabled',false);
				$('#formReservation select[name="pickupnoOfCarryOnItems2"]').attr('disabled',false);
				$('#formReservation input[name="pickupairline2"]').attr('disabled',false);
				$('#formReservation input[name="pickupflight2"]').attr('disabled',false);
				$('#formReservation input[name="pickupflightTime2"]').attr('disabled',false);
				
				$('#formReservation select[name="dropoffnoOfCarryOnItems1"]').attr('disabled',false);
				$('#formReservation select[name="dropoffnoOfLuggage1"]').attr('disabled',false);
				$('#formReservation input[name="dropoffairline1"]').attr('disabled',false);
				$('#formReservation input[name="dropoffflight1"]').attr('disabled',false);
				$('#formReservation input[name="dropoffflightTime1"]').attr('disabled',false);
				
				$('#formReservation select[name="dropoffnoOfCarryOnItems2"]').attr('disabled',false);
				$('#formReservation select[name="dropoffnoOfLuggage2"]').attr('disabled',false);
				$('#formReservation input[name="dropoffairline2"]').attr('disabled',false);
				$('#formReservation input[name="dropoffflight2"]').attr('disabled',false);
				$('#formReservation input[name="dropoffflightTime2"]').attr('disabled',false);
				
				$('#formReservation input[name="cellPhone"]').attr('disabled',false);
				$('#formReservation input[name="emailAddress"]').attr('disabled',false);
				$('#formReservation input[name="passengerName"]').attr('disabled',false);
				$('#formReservation textarea[name="specialInstructions"]').attr('disabled',false);
				$('#formReservation input[name="billingAddress"]').attr('disabled',false);
				$('#formReservation input[name="billingAddressLine2"]').attr('disabled',false);
				$('#formReservation input[name="billingCity"]').attr('disabled',false);
				$('#formReservation input[name="billingState"]').attr('disabled',false);
				$('#formReservation input[name="billingZip"]').attr('disabled',false);

				$('#formReservation input[name="pickupDate1"]').attr('disabled',false);
				$('#formReservation input[name="pickupDate2"]').attr('disabled',false);
				$('#formReservation input[name="pickupTime1"]').attr('disabled',false);
				$('#formReservation input[name="pickupTime2"]').attr('disabled',false);
				
			}			
			
		}
	}
	function updateCosts(){
		$('input[name="priceManual"]').val('1');
		update_trip_cost();
	}

	jQuery(function($) {
		$('#formReservation input[name="trip"]').click(function(){
			$('#formReservation input[name="otherLocation"]').attr('checked',false);
			if($(this).val() == 1){
				$('#formReservation div#location2').hide();	
				$('#formReservation div#otherLocationContainer').hide();
				$('#formReservation div#secondTripDatetimeContainer').hide();
			}
			else{
				$('#formReservation div#otherLocationContainer').show();
				$('#formReservation div#secondTripDatetimeContainer').show();
				if($('#formReservation input[name="otherLocation"]').is(':checked') == true){
					$('#formReservation div#location2').show();		
				}
				else{
					$('#formReservation div#location2').hide();
				}
			}
		});
		$('#formReservation input[name="otherLocation"]').click(function(){
			if($(this).is(':checked') == true){
				$('#formReservation div#location2').show();	
			}
			else{
				$('#formReservation div#location2').hide();	
			}
		});
		$('#formReservation input[name="pickup1Location"], #formReservation input[name="pickup2Location"]').click(function(){
			if($(this).attr('name') == 'pickup1Location'){
				if($(this).val() == 1){
					$('#pickupAirport1').show();
					$('#pickupResidence1').hide();
				}
				else{
					$('#pickupAirport1').hide();
					$('#pickupResidence1').show();
				}
			}	
			if($(this).attr('name') == 'pickup2Location'){
				if($(this).val() == 1){
					$('#pickupAirport2').show();
					$('#pickupResidence2').hide();
				}
				else{
					$('#pickupAirport2').hide();
					$('#pickupResidence2').show();
				}
			}	
		});
		$('#formReservation input[name="dropoff1Location"], #formReservation input[name="dropoff2Location"]').click(function(){
			if($(this).attr('name') == 'dropoff1Location'){
				if($(this).val() == 1){
					$('#dropoffAirport1').show();
					$('#dropoffResidence1').hide();
				}
				else{
					$('#dropoffAirport1').hide();
					$('#dropoffResidence1').show();
				}
			}	
			if($(this).attr('name') == 'dropoff2Location'){
				if($(this).val() == 1){
					$('#dropoffAirport2').show();
					$('#dropoffResidence2').hide();
				}
				else{
					$('#dropoffAirport2').hide();
					$('#dropoffResidence2').show();
				}
			}	
		});
		$('#formReservation select[name="passengers"]').change(function(){
			$("#formReservation #noOfPassengerContainer").html($('#formReservation select[name="passengers"] option:selected').val());
		});
		$('#formReservation select,input:not(input[name="tripCostField"])').change(function(){
			update_trip_cost();
		});
		$('.date-picker').datepicker({
			//startDate: new Date(),
			setDate:new Date(),
			autoclose:true
		}).next().on(ace.click_event, function(){
			$(this).prev().focus();
		});
		$('.timepicker').timepicker({
			minuteStep: 1,
			showSeconds: false,
			showMeridian: true
		}).next().on(ace.click_event, function(){
			$(this).prev().focus();
		});
		$('.input-mask-phone').mask('(999) 999-9999');			
		$("#formReservation").validate({
			submitHandler: function(form) {
		    	form.submit();
		  	},
			highlight: function(element) {
				$(element).closest('.form-group').removeClass('success').addClass('error');
			},
			success: function(element) {
				element.closest('.form-group').removeClass('error').addClass('success');
			},
			errorElement: "span",
			errorClass: "help-block",
			errorPlacement: function (error, element) {
					error.appendTo(element.parents(".controls:first"));
			},
			messages: {
				passengers: {
					required: 'Required.'
				}
			}
		});	
	});	
	var keyStop = {
	   8: ":not(input:text, textarea, input:file, input:password)", // stop backspace = back
	   13: "input:text, input:password", // stop enter = submit 	
	   end: null
	 };
	 $(document).bind("keydown", function(event){
	  var selector = keyStop[event.which];	
	  if(selector !== undefined && $(event.target).is(selector)) {
	      event.preventDefault(); //stop event
	  }
	  return true;
	 });
</script>



EOD;
$footerJs = Array("type"=>"inline", "script"=>$footerJs);
add_header_footer_cssJS('footer_js', $footerJs);
?>