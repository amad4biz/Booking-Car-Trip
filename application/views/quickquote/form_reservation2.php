<div class="row">
	<div class="col-sm-12 pageTitle pagein">Book Now</div>
</div>
<?php 
    $ci = &get_instance();
	$attributes = array('class' => 'frmReservation', 'name' => 'frmReservation', 'id' => 'frmReservation');
	echo form_open('reservation/save', $attributes);
	
?>
	
	<?php for($i=1; $i<= $_POST['trip']; $i++) { 
			$appendToFieldNames = '';
			if ($i == 2)
			{
				$appendToFieldNames = $i;
			}
	?>
		
	<div class="row formReservation">
		<div style="margin-top:20px;" class="col-sm-12 padding-left padding-right">
			<div class="box">
				<div class="boxTitle"><?php 
								if( $i == 1 && $_POST['trip'] == 1){
									echo 'Trip Details';
								} else if ($i == 2) {
									    echo 'Return Trip Details';
								}else{
									echo 'Initial Trip Details';
								}?></div>
				<div class="boxBody">
					<div class="col-sm-6 padding-left padding-right marginTop20">
						<div class="form-group first-form-group">
							<label for="passengerName"><b>Pickup 
								<?php 
								if(strlen($_POST['pickUp_airport'.$appendToFieldNames])){
									echo 'Airport';
								} 
								else
								{
									echo 'Location';
								} ?></b> <label>
					    </div>
						<div class="form-group">
							<?php
								echo $_POST['pickUp_address'.$appendToFieldNames];
								echo '<br/>';
								if(strlen($_POST['pickUp_airport'.$appendToFieldNames])){ 
									echo $_POST['pickUp_city'.$appendToFieldNames] .', '.$_POST['pickUp_state'.$appendToFieldNames];
								}
								else
								{
									echo $_POST['pickUp_airport'.$appendToFieldNames] . $_POST['pickUp_city'.$appendToFieldNames] .', '.$_POST['pickUp_state'.$appendToFieldNames].', '.$_POST['pickUp_zip'.$appendToFieldNames];
								}
							?>
					    </div>
						
					</div>
					<div class="col-sm-6 padding-left padding-right marginTop20">
						<div class="form-group first-form-group">
							
								<label for="passengerName"><b>Dropoff 
								<?php 
								if(strlen($_POST['dropOff_airport'.$appendToFieldNames])){
									echo 'Airport';
								} 
								else
								{
									echo 'Location';
								} ?></b> <label>
								
					    </div>
						<div class="form-group">
							<?php
								echo $_POST['dropOff_address'.$appendToFieldNames];
								echo '<br/>';
								if(strlen($_POST['dropOff_airport'.$appendToFieldNames])){ 
									echo  $_POST['dropOff_city'.$appendToFieldNames] .', '.$_POST['dropOff_state'.$appendToFieldNames];
								}
								else
								{
									echo is_int($_POST['dropOff_airport'.$appendToFieldNames]) . $_POST['dropOff_city'.$appendToFieldNames] .', '.$_POST['dropOff_state'.$appendToFieldNames].', '.$_POST['dropOff_zip'.$appendToFieldNames];
								}
							?>
					    </div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>	
		</div>
	</div>
	<?php
		// close the for loop from above
		}
	?>
	<div class="row formReservation">
		<div style="margin-top:20px;" class="col-sm-12 padding-left padding-right">
			<div class="box">
				<div class="boxTitle">Your Quote</div>
				<div class="boxBody">
					<div class="row padding-left padding-right">
						<div style="margin:10px 0;" class="col-sm-12 bottomBarDetail borderd padding-left padding-right">
							<div class="col-sm-3">
								<strong>Number Of Passengers : </strong> <?php echo $_POST['passengers'] ?>
							</div>
							<div class="col-sm-3">
								<strong>Trip Type : </strong> <?php if($_POST['trip'] == 1){echo 'One Way';}else{echo 'Round Trip';} ?>
							</div>
							<div class="col-sm-3">
								<strong>Vehicle Selected : </strong> <?php echo $vehicleName; ?>
							</div>
							<div class="col-sm-3 text-right">
								<strong>Trip Cost : <span style="color:#62BB46;"  class="cost" orgCost="<?php echo $_POST['cost_' . $_POST['vehicleType']] ?>"><?php echo $_POST['cost_' . $_POST['vehicleType']] ?></span></strong>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<p style="margin:10px 0;color:#478DF7; padding:0 15px; font-size:16px; font-weight:bold; text-align:center;">
		To complete your reservation, please complete information below
	</p>
	<?php
		 if (count($airports) > 0) { 
			
	?>
		<div class="row">
		<div class="col-sm-12 marginTop10 padding-left padding-right">
			<div class="box">
				<div class="boxTitle">Airline Information</div>
					<?php
						foreach($airports AS $airport){
					?>
					<div class="row marginTop20" style="margin-bottom:1px;">
						<div class="col-sm-12 padding-left padding-right">
							<div class="box">
							<div class="boxTitle" style="background:#62BB46;"><?php echo $airport['type'] . ' &mdash; ' . $airport['name'] ?></div>
							</div>
						</div>
					</div>
					<div class="row">
						<div style="margin-top:20px;" class="col-sm-6 padding-left padding-right">
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group">
										<label for="airline">Airline: <span class="req">*</span></label>
										<input type="text" class="form-control" name="airline_<?php echo $airport['code'] . '_' . $airport['tripleg'] ?>" required>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="flight">Flight #: <span class="req">*</span></label>
										<input type="text" class="form-control" name="flightNumber_<?php echo $airport['code'] . '_' . $airport['tripleg'] ?>" required>
									</div>
								</div>
								<div class="col-sm-5">
									<div class="form-group">
										<label for="flightTime">Flight <?php if ($airport['type']== "PickUp"||$airport['type']== "Pickup Return Trip") echo "Arrival"; else if($airport['type']== "Dropoff"||$airport['type']== "Dropoff Return Trip") echo "Departure"?> Time: <span class="req">*</span></label>
										<input type="text" class="form-control pickupTime" id="flightTime_<?php echo $airport['code'] . '_' . $airport['tripleg'] ?>" name="flightTime_<?php echo $airport['code'] . '_' . $airport['tripleg'] ?>" required>
									</div>
								</div>
							</div>						
						</div>	
						<div style="margin-top:20px;" class="col-sm-6 padding-left padding-right">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="luggage">Number of Checked in Luggage: <span class="req">*</span></label><br>
										
										<select class="form-control" name="noOfLuggage_<?php echo $airport['code'] . '_' . $airport['tripleg'] ?>" required>
											<option value="">Select Number</option>
                                            <?php for ($i=0; $i<=$ci->config->item('total_luggage'); $i++) { 
												echo '<option value="' . $i .'">' . $i . '</option>';
											} ?>									
										</select>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="carryOnItems">Number of Carry-on items: <span class="req">*</span></label><br>
										
										<select class="form-control" name="noOfCarryOnItems_<?php echo $airport['code'] . '_' . $airport['tripleg'] ?>" required>
											<option value="">Select Number</option>
                                            <?php for ($i=0; $i<=$ci->config->item('total_carryOnItems'); $i++) { 
												echo '<option value="' . $i .'">' . $i . '</option>';
											} ?>									
										</select>
									</div>
								</div>
							</div>
						</div>
					</div> 
                    <?php
                        if ($airport['type']== "PickUp"||$airport['type']=="Pickup Return Trip") {
                    ?>
                    <div class="row">
                        <div class="col-sm-6 padding-left padding-right">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="arrivaltype">Arrival Type: <span class="req">*</span></label>
                                        <select class="form-control" name="arrivaltype" id="arrivaltype" required>
                                            <option value="">Select Arrival Type</option>
                                            <option value="domestic">Domestic Arrival</option>
                                            <option value="international">International Arrival</option>                                  
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6" id="globalentry">
                                    <div class="form-group">
                                        <label for="globalentry">Do you have Global Entry Pass? </label>
                                        <select class="form-control" id="globalentry" name="globalentry">
                                            <option value="no">No</option>
                                            <option value="yes">Yes</option>                                  
                                        </select>
                                    </div>
                                </div>
                            </div>                        
                        </div> 
                    </div>
					<?php
                        }
                        }
					?>
				</div>
			</div>
		</div>
		
	<?php 
		
		 } 
	
	?>
    
	<div class="row">
		<div class="col-sm-12 marginTop10 padding-left padding-right">
			<div class="box">
				<div class="boxTitle">Passenger Details</div>
				<div class="boxBody">
					<div class="row">
						<div style="margin-top:20px;" class="col-sm-6 padding-left padding-right">
							<div class="form-group">
								<label for="passengerName">Passenger Name: <span class="req">*</span></label>
								<input type="text" class="form-control" id="passengerName" name="passengerName"  required>
						    </div>
						    <div class="form-group">
								<label for="emailAddress">Email Address: <span class="req">*</span></label>
								<input type="text" class="form-control" id="emailAddress" name="emailAddress" required>
						    </div>
						    <div class="form-group">
								<label for="cellPhone">Cell Phone: <span class="req">*</span></label>
								<input type="text" data-mask="1-000-0000-000" class="form-control" id="cellPhone" name="cellPhone" required>
						    </div>
						   
						</div>
						<div style="margin-top:20px;" class="col-sm-6 padding-left padding-right">
							
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="pickupDate">Pickup Date: <span class="req">*</span></label>
										<input type="text" class="form-control pickupDate" id="pickupDate" name="pickupDate" required>
								    </div>
								</div>
                                <?php if ($airports[0]['type']!="PickUp") { ?>
								<div class="col-sm-6">
									<div class="form-group bootstrap-timepicker">
										<label for="time">Pickup Time: <span class="req">*</span></label>
										<input type="text" placeholder="Time" class="form-control pickupTime" id="pickupTime" name="pickupTime" required>
								    </div>
								</div>
                                <?php } else { ?>    
                                <div class="col-sm-6 hidden">
                                    <div class="form-group bootstrap-timepicker">
                                        <label for="time">Pickup Time:</label>
                                        <input type="text" placeholder="Time" class="form-control pickupTime" id="pickupTime" value="123" name="pickupTime">
                                    </div>
                                </div>
                                <?php } ?>
							</div>
							
							<?php if(isset($_POST['trip']) && $_POST['trip'] == 2) 
									{?>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="pickupDate">Return Pickup Date: <span class="req">*</span></label>
											<input type="text" class="form-control pickupDate"  name="pickupDate_return" required>
									    </div>
									</div>
                                    <?php foreach ($airports as $airport) { if ($airport['type']=="Pickup Return Trip") $flag=1; } if(!isset($flag)){?>
									<div class="col-sm-6">
										<div class="form-group bootstrap-timepicker">
											<label for="time">Return Pickup  Time: <span class="req">*</span></label>
											<input type="text" placeholder="Time" class="form-control pickupTime" name="pickupTime_return" required>
									    </div>
									</div>
                                    <?php } else { ?>  
                                    <div class="col-sm-6 hidden">
                                        <div class="form-group bootstrap-timepicker">
                                            <label for="time">Return Pickup  Time:</label>
                                            <input type="text" placeholder="Time" class="form-control pickupTime" value="234"  name="pickupTime_return">
                                        </div>
                                    </div>
                                    <?php } ?>
								</div>
							<?php }?>
						</div>
					</div>
					<div class="row">
						 <div class="col-sm-12 padding-left padding-right">
							 <div class="form-group">
									<label for="specialInstructions">Special Instructions:</label>
									<textarea style="height: 110px;" class="form-control" id="specialInstructions" name="specialInstructions"></textarea>
							 </div>
						 </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row padding-left padding-right">
		<div style="margin:10px 0 0 0;" class="col-sm-12 bottomBarDetail borderd padding-left padding-right">
			<div class="col-sm-3">
				<strong>Number Of Passengers : </strong> <?php echo $_POST['passengers'] ?>
			</div>
			<div class="col-sm-3">
				<strong>Trip Type : </strong> <?php if($_POST['trip'] == 1){echo 'One Way';}else{echo 'Round Trip';} ?>
			</div>
			<div class="col-sm-3">
				<strong>Vehicle Selected : </strong> <?php echo $vehicleName; ?>
			</div>
			<div class="col-sm-3 text-right">
				<strong>Total Amount : <span style="color:#62BB46;" class="cost" orgCost="<?php echo $_POST['cost_' . $_POST['vehicleType']] ?>"><?php echo $_POST['cost_' . $_POST['vehicleType']] ?></span></strong>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 padding-left padding-right marginTop20">
			<div class="box">
				<div class="boxTitle">Payment Information       
                    <img style="margin-left: 27px;" class="img-responsive pull-right" src="<?php echo base_url();?>images/Cash.png"><img class="img-responsive pull-right" src="<?php echo base_url();?>images/creditCards.png">
                    <div class="col-sm-5 control-label pull-right" style="margin-left:-15px;margin-top: -5px;">
                        <label>
                            <input type="radio" name="paymentMethod" id="cash" <?php if(isset($paymentMethod) == 'CA' ){echo 'checked';}?> value="CA">
                                Pay Cash 
                        </label>
                    </div>
                    <div class="col-sm-2 control-label pull-right" style="margin-top: -5px;">
                        <label>
                            <input type="radio" name="paymentMethod" id="creditcard" <?php if(isset($paymentMethod) == 'CC' || isset($paymentMethod) == ''){echo 'checked';}?> value="CC">
                                Pay by Credit Card
                        </label>
                    </div>
                </div>
				<div class="boxBody">
					<div style="margin-top:20px;" class="col-sm-6">
						
					    <div class="form-group">
							<label for="billingAddress">Billing Address: </label>
							<input type="text" class="form-control" id="billingAddress" name="billingAddress">
					    </div>
					    <div class="form-group">
						    <div class="row">
								<div class="col-sm-4">
									<div class="form-group">
										<label for="billingCity">City: </label>
										<input type="text" class="form-control" id="billingCity" name="billingCity">
								    </div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label for="billingState">State: </label>
										<input type="text" class="form-control" id="billingState" name="billingState">
								    </div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label for="billingZip">ZIP: </label>
										<input type="text" class="form-control" id="billingZip" name="billingZip">
								    </div>
								</div>
							</div>
						</div>
						<div style="margin-top:-15px;" class="form-group">
                            			<label for="tipPercentage">Tip Amount: <span class="req">*</span></label>
                            			<select class="form-control" id="tipPercentage" name="tipPercentage" onChange="updateCostOnTip(this.value)" onblur="updateCostOnTip(this.value)" required>
                               				<option value="0">Select Tip Amount</option>
                                				<option value="20">20%</option>
                                				<option value="25">25%</option>
                                				<option value="30">30%</option>
                                				<option value="0">Tip in Cash</option>
                            			</select>
                        			</div>
					</div>
					<div style="margin-top:20px;" class="col-sm-6">
						<div class="form-group">
							<label for="cardHolderName">Card Holder's Name: <span class="req">*</span></label>
							<input type="text" class="form-control" id="cardHolderName" name="cardHolderName"  required>
					    </div>
					    <div class="form-group">
							<label for="billingCard">Credit Card Number: <span class="req">*</span></label>
							<input type="text" class="form-control" id="billingCard" name="billingCard"  required>
					    </div>
					    <div class="form-group">
						    <div class="row">
								<div class="col-sm-4">
									<div class="form-group">
										<label for="expirationDate">Expiration Month: <span class="req">*</span></label>
										<select class="form-control" id="expirationMonth" name="expirationMonth" required>
											<option value="">Select Month</option>
											<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>										
										</select>
								    </div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label for="expirationYear">Expiration Year: <span class="req">*</span></label>
										<select class="form-control" id="expirationYear" name="expirationYear" required>
											<option value="">Select Year</option>
											<?php 
												for($i=0;$i<=10;$i = $i + 1){
													echo '<option value="';
													echo $year + $i.'">';
													echo $year + $i.'</option>';
												}
											?>
										</select>
								    </div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label for="expirationDate">CC Security Code: <span class="req">*</span></label>
										<input type="text" class="form-control" id="securitycode" name="securitycode" required>
										<p  style="font-size:11px;">
											(<a href="#" data-toggle="tooltip" onclick="return false;" data-placement="left" class="ccscPopover"
												title="For Visa, MasterCard or Discover, it's the last three digits in the signature area on the back of your card. For American Express, it's the four digits on the front of the card.">What is this?</a>)</p>
								    </div>
								</div>
							</div>
						</div>
						
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 marginTop20">
		<div class="col-sm-6" >
			<div class="alert alert-info pleaseWaitDiv" role="alert" style="display:none;"><i class="fa fa-spinner fa-spin"></i> Please wait while we process your request...</div>
		</div>
		<div class="col-sm-6">
			<input type="submit" name="showQuote" value="Book Now" class="btn btn-primary btn-lg btn-quick-quote pull-right" 
			id="btnSubmitReservationValidator">
		</div>
	</div>
	</div>
</form>
<style>button.ui-datepicker-current {display:none;}</style>
<div id="myModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Opps!</h4>
      </div>
      <div class="modal-body">
	      Reservation with less then 12 hours lead time can not be booked online,<br>Please call <span style="color:blue;font-weight:bold;">866-805-4234</span> for your specific quote.
      </div>
    </div>
  </div>
</div>
<div id="CashModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Pay Cash</h4>
      </div>
      <div class="modal-body">
          Your credit credit will be held for security purposes and it will not be charged.
      </div>
    </div>
  </div>
</div>
<?php 
$footerJs1 = "<script> var currentdatetime = '" . date("m/d/Y H:i:s") . "';";
$footerJs = $footerJs1 . <<<EOD
	function checkPickupDateTime(){		
		/*
		var dateOne = new Date($('input[name="pickupDate"]').val() + ' ' + $('input[name="pickupTime"]').val());
		var dateTwo = new Date(currentdatetime);
		var diff = dateOne.valueOf() - dateTwo.valueOf();   
		var diffInHours = diff/1000/60/60;
		if(diffInHours >= 12){
			return true;
		}
		else{
			return false;
		}
		*/
		return true;
	}    
	$(function() {  
		$( "input.pickupDate" ).datepicker({
			minDate: 0
		});
		$('input.pickupTime').timepicker({
            stepMinute: 5,
            controlType: 'select',
			timeFormat: 'hh:mm tt'
        });
        /*
		$('input[name="pickupDate"]').change(function(){
			if(!checkPickupDateTime() && $('input[name="pickupTime"]').val() != ''){
				$('#myModal').modal('show');
			}
		});
		$('input[name="pickupTime"]').change(function(){
			if(!checkPickupDateTime() && $('input[name="pickupTime"]').val() != ''){
				$('#myModal').modal('show');
			}
		});
		*/
		$('#frmReservation').keydown(function(event){
		    if(event.keyCode == 13) {
		      event.preventDefault();
		      return false;
		    }
		});
		$('a.ccscPopover').tooltip();
		$("#frmReservation").validate({
			submitHandler: function(form) {
				//if(!checkPickupDateTime() && $('input[name="pickupTime"]').val() != ''){
					//$('#myModal').modal('show');
				//}
				//else {
					jQuery('div.pleaseWaitDiv').toggle();
					jQuery('#btnSubmitReservationValidator').attr('disabled',true).val('Please Wait');					
					 jQuery.ajax({
						type: 'post',
						url: '/app/index.php/reservation/save',
						data: jQuery('#frmReservation').serialize(),
						timeout: 20000,
						error: function (XMLHttpRequest, textStatus, errorThrown) {
							
							jQuery('#btnSubmitReservationValidator').attr('disabled',false).val('Book Now');
							jQuery('div.pleaseWaitDiv').toggle();
							AJAX_error(XMLHttpRequest, textStatus, errorThrown);
						},
						success: function(reponse){
							try {
								var json = eval('(' + reponse + ')');
								
								if(json.success == true){
								        addtocalendar();	
								        self.location = '/app/index.php/reservation/thank_message';
								}
								else if (typeof json.timeerror != "undefined"){
									$('#myModal').modal('show');
									jQuery('#btnSubmitReservationValidator').attr('disabled',false).val('Book Now');
									jQuery('div.pleaseWaitDiv').toggle();
								}
								else{
									errorMessage = "Error occured processing credit card. Please try again.\\n\\n" + json.ccAuth.responseMessage;
									alert(errorMessage);
									jQuery('#btnSubmitReservationValidator').attr('disabled',false).val('Book Now');
									jQuery('div.pleaseWaitDiv').toggle();
								}
							} catch(e) {
								jQuery('#btnSubmitReservationValidator').attr('disabled',false).val('Book Now');
								jQuery('div.pleaseWaitDiv').toggle();
							}
						}
					});
				//}	
		  	},
			highlight: function(element) {
				$(element).closest('.control-group').removeClass('success').addClass('error');
			},
			success: function(element) {
				element.closest('.control-group').removeClass('error').addClass('success');
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
	function updateCostOnTip(tip)
	{
		cost = $('span.cost').first().attr('orgCost');
		cost = parseFloat(cost.replace('$', ''));
		tipAmount =0;
		if (tip > 0)
		{
			tipAmount = cost * (tip/100);
		    tipAmount = parseInt(tipAmount)+1;
        }
        
		totalCost = cost+tipAmount;
    
		$('span.cost').text('$' + totalCost.toFixed(0));
	}
    
    function addtocalendar(){
        var name = jQuery('#passengerName').val();
        var pickupDate = jQuery('#pickupDate').val(); 
        var pickupTime = jQuery('#pickupTime').val();
        if(pickupTime == "123")
        {
            pickupTime = jQuery('#flightTime_pickup_first').val();
        }         
        var email = jQuery('#emailAddress').val();
        var cellPhone = jQuery('#cellPhone').val();
        var specialInstructions = "";
        if (jQuery('#specialInstructions').val() != "") 
        {
            specialInstructions = jQuery('#specialInstructions').val();
        }
        
        jQuery.ajax({
            dataType: 'json',                    
            type: 'post',
            data: {name: name, email:email, cellPhone:cellPhone, specialInstructions:specialInstructions, pickupDate:pickupDate, pickupTime:pickupTime},                     
            url: '/app/sync/quickstart.php',
            success: function(reponse){
            }
       });     
    }
    jQuery(document).ready(function($) {
        $('#globalentry').hide();
        $('#arrivaltype').on('change', function(e){
            arrivaltype = $('#arrivaltype').val();
            if(arrivaltype == 'international'){
                $('#globalentry').show();    
            } else {
                $('#globalentry').hide();
            }
        });  
        $('#cash').click(function(){
           $('#CashModal').modal('show');
        });    
    });
</script>
EOD;
$footerJs = Array("type"=>"inline", "script"=>$footerJs);
add_header_footer_cssJS('footer_js', $footerJs);
?>