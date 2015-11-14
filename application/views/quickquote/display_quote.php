		<div class="row">
			<div class="col-sm-12 pageTitle pagein"><?php echo "Book Now"; ?></div>
		</div>
		<!--<div class="row">
            <div class="col-sm-12 padding-left padding-right">
            	<div class="stepWraper borderd">
            		<div class="step active">
            			<span class="stepNumber">1</span>
            			<span class="stepName">Initial Detail</span>
            		</div>
            		<div class="step">
            			<span class="stepNumber">2</span>
            			<span class="stepName">Pickup Detail</span>
            		</div>
            		<div class="step">
            			<span class="stepNumber">3</span>
            			<span class="stepName">Return Detail</span>
            		</div>
            		<div class="step">
            			<span class="stepNumber">4</span>
            			<span class="stepName">Verify Detail</span>
            		</div>
            		<div class="step last-step">
            			<span class="stepNumber">5</span>
            			<span class="stepName">Pay Now</span>
            		</div>
            		<div class="clearfix"></div>
            	</div>
            </div>
        </div>-->
        <?php 
        	$savequoteAttributes = array('class' => 'getQuoteForm', 'name' => 'getQuote', 'id' => 'getQuoteForm');
        	echo form_open('quickquote/savequote', $savequoteAttributes);
        ?>
            <div class="row content">
            	<div class="col-sm-6 padding-left padding-right">
                    	<div class="form-group control-group alert-success" style="padding:10px;padding-bottom:0px;background-color: #80C9E8;">
                            <div class="row controls">
                            	<div class="col-md-5">
                                	<div class="col-sm-6 control-label" style="padding-left:0; padding-right:5px;">
                                		<label>
                                        	<input type="radio" name="trip" id="onewayTrip" required="true" <?php if(isset($trip) == 1 || isset($trip) == ''){echo 'checked';}?> value="1">
                                        	 One Way
                                       	</label>
                                    </div>
                                    <div class="col-sm-6 control-label" style="padding-left:0; padding-right:0;">
                                    	<label>
                                        	<input type="radio" name="trip" id="roundTrip" required="true" <?php if(isset($trip) == 2){echo 'checked';}?> value="2">
                                        	 Round Trip
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                	<div class="checkbox">
									  <label id="otherlocation">
									    <input type="checkbox" name="otherlocation" value="1" id="otherlocationCheck">
									    Return Trip Address Is Different
									  </label>
									</div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col-sm-6">
                	<div class="row noPassengers">
						<div class="col-sm-9 padding-left padding-right">
							<label for="passengers" class="col-sm-6 control-label">Number of Passengers: <span class="req">*</span></label>
	                        <div class="col-sm-6 control-group">
	                        	<div class="controls">
	                        		<select name="passengers" class="form-control"  id="passengers" required="true" digits="true">
	                        			<option value="">Select Passengers</option>
	                        			<option value="1">1</option>
	                        			<option value="2">2</option>
	                        			<option value="3">3</option>
	                        			<option value="4">4</option>
	                        			<option value="5">5</option>
	                        			<option value="6">More then 5</option>
	                        		</select>
	                        	</div>
							</div>
						</div>
						<!--<div class="col-sm-7 padding-left padding-right">
							<label for="passengers" class="col-sm-8 control-label">Distance: <span class="req">*</span></label>
	                        <div class="col-sm-4 control-group">
	                        	<div class="controls">
	                        		<input type="text" name="destance1" class="form-control"  id="destance1" required="true" digits="true" value="">
	                        	</div>
							</div>
						</div>-->
						
						<div class="col-sm-3 padding-left padding-right">
							<input type="submit" name="showQuote" value="&nbsp;&nbsp;&nbsp;Next&nbsp;&nbsp;&nbsp;" style="font-size:20px"  class="btn btn-primary btn-quick-quote pull-right" id="btnSubmitValidator">
						</div>
					</div>
                </div>
            </div>
            <div class="row">
            	<div class="col-sm-6 padding-left padding-right">
                        <div class="box pickUpLoaction" id="pickUpLoaction">
                        	<div class="boxTitle">Pick Up Location</div>
                            <div class="boxBody">
                            	<div class="form-group">
                                    <div class="col-sm-12 padding-left padding-right marginTop20">
                                    	<div class="row">
                                        	<div class="col-sm-12 control-group">
                                            	<label class="controls radio-inline">
                                                    <input type="radio" name="pickUpLoacation" id="airport_radio" required="true" <?php if(isset($pickUpLoacation) == 1 || isset($pickUpLoacation) == ''){echo 'checked';}?> value="1"> Airport / Port of Call
                                                </label>                                            
                                            	<label class="controls radio-inline">
                                                    <input type="radio" name="pickUpLoacation" id="residential_radio" required="true" <?php if(isset($pickUpLoacation) == 2){echo 'checked';}?> value="2"> Address
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="pickUp_airport">
                                    <div class="col-sm-12 control-group padding-left padding-right marginTop20">
                                    	<div class="controls form-group">
                                            <label for="airport">Airport / Port of Call: <span class="req">*</span></label>
                                            <select name="pickUp_airport" class="form-control" id="pickup_airport" required="true">
                                                <option value="">Select an Airport / Port of Call</option>
                                                <?php 
                                                	foreach ($airports as $airport_item):
                                                		echo '<option value="'.$airport_item['airport_code'].'">'.$airport_item['name'].'</option>'; 	
													endforeach
												?>
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="pickUp_residential">
                                    <div class="col-sm-12 padding-left padding-right marginTop20">
                                    	<div class="control-group form-group">
                                    		<div class="controls">
	                                            <label for="pickup_address">Address: </label>
	                                            <input type="text" name="pickUp_address" class="form-control" id="pickup_address"  value="">
											</div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="row">
                                            	<div class="col-sm-5 col-md-6 control-group">
                                            		<div class="controls">
	                                                	<label for="city">City: </label>
	                                            		<input type="text" name="pickUp_city" class="form-control" id="pickup_city"  value="">
	                                            	</div>
                                                </div>
                                            	<div class="col-sm-4 col-md-3 control-group">
                                            		<div class="controls">
	                                                	<label for="state">State: </label>
	                                            		<input type="text" name="pickUp_state" class="form-control disabled" id="pickup_state"  value="CA">
	                                            	</div>
                                                </div>
                                            	<div class="col-sm-3 col-md-3 control-group">
                                            		<div class="controls">
	                                                	<label for="zip">ZIP: <span class="req">*</span></label>
	                                            		<input type="text" name="pickUp_zip" class="form-control" id="pickup_zip" required="true" value="">
	                                            	</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                </div>
                <div class="col-sm-6 padding-left padding-right">
                	<div class="box dropOffLocation" id="dropOffLocation">
                        	<div class="boxTitle">Drop Off Location</div>
                            <div class="boxBody">
                            	<div class="form-group">
                                    <div class="col-sm-12 padding-left padding-right marginTop20">
                                    	<div class="row">
                                        	<div class="col-sm-12 control-group">
                                            	<label class="controls radio-inline">
                                                    <input type="radio" name="dropOffLocation" id="dropOff_airport_radio" required="true" <?php if(isset($dropOffLocation) == 1 || isset($dropOffLocation) == ''){echo 'checked';}?> value="1"> Airport / Port of Call
                                                </label>                                            
                                            	<label class="controls radio-inline">
                                                    <input type="radio" name="dropOffLocation" id="dropOff_residential_radio" required="true" <?php if(isset($dropOffLocation) == 2){echo 'checked';}?> value="2"> Address
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="dropOff_airport">
                                    <div class="col-sm-12 control-group padding-left padding-right marginTop20">
                                    	<div class="controls form-group">
                                            <label for="airport">Airport / Port of Call: <span class="req">*</span></label>
                                            <select name="dropOff_airport" class="form-control" id="dropoff_airport" required="true">
                                                <option value="">Select an Airport / Port of Call</option>
                                                <?php 
                                                	foreach ($airports as $airport_item):
                                                		echo '<option value="'.$airport_item['airport_code'].'">'.$airport_item['name'].'</option>'; 	
													endforeach
												?>
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="dropOff_residential">
                                    <div class="col-sm-12 padding-left padding-right marginTop20">
                                    	<div class="control-group form-group">
                                    		<div class="controls">
	                                            <label for="address">Address: </label>
	                                            <input type="text" name="dropOff_address" class="form-control" id="dropOff_address"  value="">
											</div>
                                        </div>
                                        <input type="hidden" name="dropOff_addressLine2">
                                      
                                        <div class="form-group">
                                            <div class="row">
                                            	<div class="col-sm-5 col-md-6 control-group">
                                            		<div class="controls">
	                                                	<label for="city">City: </label>
	                                            		<input type="text" name="dropOff_city" class="form-control" id="dropOff_city" value="">
	                                            	</div>
                                                </div>
                                            	<div class="col-sm-4 col-md-3  control-group">
                                            		<div class="controls">
	                                                	<label for="state">State: </label>
	                                            		<input type="text" name="dropOff_state" class="form-control" id="dropOff_state"  value="CA">
	                                            	</div>
                                                </div>
                                            	<div class="col-sm-3 col-md-3  control-group">
                                            		<div class="controls">
	                                                	<label for="zip">ZIP: <span class="req">*</span></label>
	                                            		<input type="text" name="dropOff_zip" class="form-control" id="dropOff_zip" required="true" value="">
	                                            	</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                </div>
            </div>
            <div id="destance1"></div>
            <!-- Second Pick & drop Location Starts -->
            <div class="otherLocationDetail" id="otherLocationDetail">
            <div class="row marginTop20" style="margin-bottom:1px;">
            	<div class="col-sm-12 padding-left padding-right">
					<div class="box">
						<div class="boxTitle" style="background:#62BB46;">Return Trip Details</div>
					</div>
				</div>
			</div>            
            <div class="row">
            	<div class="col-sm-6 padding-left padding-right">
                        <div class="box pickUpLoaction2" id="pickUpLoaction2">
                        	<div class="boxTitle">Pick Up Location</div>
                            <div class="boxBody">
                            	<div class="form-group">
                                    <div class="col-sm-12 padding-left padding-right marginTop20">
                                    	<div class="row control-group">
                                        	<div class="col-sm-12  col-md-7">
                                            	<label class="controls radio-inline">
                                                    <input type="radio" name="pickUpLoacation2" id="airport_radio2" required="true" <?php if(isset($pickUpLoacation2) == 1 || isset($pickUpLoacation2) == ''){echo 'checked';}?> value="1"> Airport / Ports of Calls
                                                </label>                                            
                                            	<label class="controls radio-inline">
                                                    <input type="radio" name="pickUpLoacation2" id="residential_radio2" required="true" <?php if(isset($pickUpLoacation2) == 2){echo 'checked';}?> value="2"> Address
                                                </label>
                                            </div>
                                            <div class="col-sm-12 col-md-5">
                                            	<br class="visible-sm"/>
                                            	<div class="checkbox" style="margin:0">
												  <label style="font-size:12px;">
												    <input type="checkbox" id="copyDropOffLocation">
												    Copy Drop Off Location
												  </label>
												</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="pickUp_airport2">
                                    <div class="col-sm-12 control-group padding-left padding-right marginTop20">
                                    	<div class="form-group controls">
                                            <label for="airport">Airport / Ports of Calls : <span class="req">*</span></label>
                                            <select name="pickUp_airport2" class="form-control" required="true" id="p_airprot2">
                                                <option value="">Select an Airport / Ports of Calls</option>
                                                <?php 
                                                	foreach ($airports as $airport_item):
                                                		echo '<option value="'.$airport_item['airport_code'].'">'.$airport_item['name'].'</option>'; 	
													endforeach
												?>
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="pickUp_residential2">
                                    <div class="col-sm-12 padding-left padding-right marginTop20">
                                    	<div class="form-group control-group">
                                    		<div class="controls">
	                                            <label for="address">Address:</label>
	                                            <input type="text" name="pickUp_address2" id="pickUp_address2" class="form-control " value="">
											</div>
                                        </div>
                                       
                                        <div class="form-group">
                                            <div class="row">
                                            	<div class="col-sm-5 col-md-6  control-group">
                                            		<div class="controls">
	                                                	<label for="city">City: </label>
	                                            		<input type="text" name="pickUp_city2" id="pickUp_city2" class="form-control " value="">
	                                            	</div>
                                                </div>
                                            	<div class="col-sm-4 col-md-3  control-group">
                                            		<div class="controls">
	                                                	<label for="state">State: </label>
	                                            		<input type="text" name="pickUp_state2" id="pickUp_state2" class="form-control " value="CA">
	                                            	</div>
                                                </div>
                                            	<div class="col-sm-3 col-md-3  control-group">
                                            		<div class="controls">
	                                                	<label for="zip">ZIP: <span class="req">*</span></label>
	                                            		<input type="text" name="pickUp_zip2" class="form-control required" id="pickup_zip2" value="" onchange="">
	                                            	</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                </div>
                <div class="col-sm-6 padding-left padding-right">
                	<div class="box dropOffLocation2" id="dropOffLocation2">
                        	<div class="boxTitle">Drop Off Location</div>
                            <div class="boxBody">
                            	<div class="form-group">
                                    <div class="col-sm-12 padding-left padding-right marginTop20">
                                    	<div class="row control-group">
                                        	<div class="col-sm-12 col-md-7">
                                            	<label class="controls radio-inline">
                                                    <input type="radio" name="dropOffLocation_2" id="dropOff_airport_radio2" required="true" <?php if(isset($dropOffLocation_2) == 1 || isset($dropOffLocation_2) == ''){echo 'checked';}?> value="1"> Airport / Ports of Calls
                                                </label>                                            
                                            	<label class="controls radio-inline">
                                                    <input type="radio" name="dropOffLocation_2" id="dropOff_residential_radio2" required="true" <?php if(isset($dropOffLocation_2) == 2){echo 'checked';}?> value="2"> Address
                                                </label>
                                            </div>
                                            <div class="col-sm-12 col-md-5">
                                            	<br class="visible-sm"/>
                                            	<div class="checkbox" style="margin:0">
												  <label style="font-size:12px;">
												    <input type="checkbox" id="copyPickUpLocation">
												    Copy Pick Up Location
												  </label>
												</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="dropOff_airport2">
                                    <div class="col-sm-12 control-group padding-left padding-right marginTop20">
                                    	<div class="form-group controls">
                                            <label for="airport">Airport / Ports of Calls : <span class="req">*</span></label>
                                            <select name="dropOff_airport2" class="form-control" required="true" id="d_aiport2">
                                                <option value="">Select an Airport / Ports of Calls</option>
                                                <?php 
                                                	foreach ($airports as $airport_item):
                                                		echo '<option value="'.$airport_item['airport_code'].'">'.$airport_item['name'].'</option>'; 	
													endforeach
												?>
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="dropOff_residential2">
                                    <div class="col-sm-12 padding-left padding-right marginTop20">
                                    	<div class="form-group control-group">
                                    		<div class="controls">
	                                            <label for="address">Address: </label>
	                                            <input type="text" name="dropOff_address2" id="dropOff_address2" class="form-control " value="">
											</div>
                                        </div>
                                        <input type="hidden" name="dropOff_addressLine2_2">
                                       
                                        <div class="form-group">
                                            <div class="row">
                                            	<div class="col-sm-5 col-md-6  control-group">
                                            		<div class="controls">
	                                                	<label for="city">City: </label>
	                                            		<input type="text" name="dropOff_city2" id="dropOff_city2" class="form-control " value="">
	                                            	</div>
                                                </div>
                                            	<div class="col-sm-4 col-md-3  control-group">
                                            		<div class="controls">
	                                                	<label for="state">State: </label>
	                                            		<input type="text" name="dropOff_state2" id="dropOff_state2" class="form-control " value="CA">
	                                            	</div>
                                                </div>
                                            	<div class="col-sm-3 col-md-3  control-group">
                                            		<div class="controls">
	                                                	<label for="zip">ZIP: <span class="req">*</span></label>
	                                            		<input type="text" name="dropOff_zip2" id="dropOff_zip2" class="form-control required" value="">
	                                            	</div>
                                                </div>
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
            <!-- Second Pick & drop Location Ends -->
            <div class="row" id="btnNext">
            	<br><br>
            	<center>
            		<input type="submit" name="showQuote" value="&nbsp;&nbsp;&nbsp;Next&nbsp;&nbsp;&nbsp;" style="font-size:20px" class="btn btn-primary btn-quick-quote" id="btnSubmitValidator2">
            	</center>
            </div>
		</form>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Personel Quote</h4>
      </div>
      <div class="modal-body">
        For more than 5 passengers, please call our office at 866-805-4234
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Restricted Zip Code -->
<div class="modal fade" id="ristrictedZip" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Personel Quote</h4>
      </div>
      <div class="modal-body">
         Call for a personal quote at 866-805-4234
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php 
	$footerJs = <<<EOD
		<script>
		// This example displays an address form, using the autocomplete feature
		// of the Google Places API to help users fill in the information.
		var map = null;
		var directionDisplay;
		var directionsService = new google.maps.DirectionsService();
		////////Start Variable
		var map2 = null;
		var directionDisplay2;
		var directionsService2 = new google.maps.DirectionsService();
		////////	End Variable
		
		var placeSearch, pickup_address1;
		var componentForm = {
				street_number: 'short_name',//pickUp_street
				  route: 'long_name',
				  locality: 'long_name',
				  administrative_area_level_1: 'short_name',
				  country: 'long_name',
				  postal_code: 'short_name'
		};
		
		function initialize() {
		  // Create the autocomplete object, restricting the search
		  // to geographical location types.
		  directionsDisplay = new google.maps.DirectionsRenderer();
			//////Start	
				directionsDisplay2 = new google.maps.DirectionsRenderer();
			//////	End
		  pickup_address1 = new google.maps.places.Autocomplete(document.getElementById('pickup_address'));
		  dropOff_address1 = new google.maps.places.Autocomplete(document.getElementById('dropOff_address'));
		  pickup_address2 = new google.maps.places.Autocomplete(document.getElementById('pickUp_address2'));
		  dropOff_address2 = new google.maps.places.Autocomplete(document.getElementById('dropOff_address2'));
		  // When the user selects an address from the dropdown,
		  // populate the address fields in the form.
		  google.maps.event.addListener(pickup_address1, 'place_changed', function() {
		    fillInAddress();
		  });
		  google.maps.event.addListener(dropOff_address1, 'place_changed', function() {
			    fillInAddress1();
			  });
		  google.maps.event.addListener(pickup_address2, 'place_changed', function() {
			    fillInAddress2();
			  });
		  google.maps.event.addListener(dropOff_address2, 'place_changed', function() {
			    fillInAddress3();
			  });
		}
		
		// [START region_fillform]
		//PickUp-1
		function fillInAddress() {
			var place = pickup_address1.getPlace();
			var adr_address = $('<div>'  + place.adr_address + '</div>');
			$('input#pickup_address, input#pickup_city, input#pickup_state,input#pickup_zip ').val('');
			if (adr_address.find('span.street-address').length > 0)
			{
				$('input#pickup_address').val(adr_address.find('span.street-address').text());
			}
			if (adr_address.find('span.locality').length > 0)
			{
				$('input#pickup_city').val(adr_address.find('span.locality').text());
			}
			if (adr_address.find('span.region').length > 0)
			{
				$('input#pickup_state').val(adr_address.find('span.region').text());
			}
			if (adr_address.find('span.postal-code').length > 0)
			{
				$('input#pickup_zip').val(adr_address.find('span.postal-code').text());
			}
			
			
		}
		function fillInAddress1() {
			var place = dropOff_address1.getPlace();
			var adr_address = $('<div>'  + place.adr_address + '</div>');
			$('input#dropOff_address, input#dropOff_city, input#dropOff_state,input#dropOff_zip ').val('');
			if (adr_address.find('span.street-address').length > 0)
			{
				$('input#dropOff_address').val(adr_address.find('span.street-address').text());
			}
			if (adr_address.find('span.locality').length > 0)
			{
				$('input#dropOff_city').val(adr_address.find('span.locality').text());
			}
			if (adr_address.find('span.region').length > 0)
			{
				$('input#dropOff_state').val(adr_address.find('span.region').text());
			}
			if (adr_address.find('span.postal-code').length > 0)
			{
				$('input#dropOff_zip').val(adr_address.find('span.postal-code').text());
			}
			
		}
		function fillInAddress2() {
			var place = pickup_address2.getPlace();
			var adr_address = $('<div>'  + place.adr_address + '</div>');
			$('input#pickUp_address2, input#pickUp_city2, input#pickUp_state2,input#pickup_zip2 ').val('');
			if (adr_address.find('span.street-address').length > 0)
			{
				$('input#pickUp_address2').val(adr_address.find('span.street-address').text());
			}
			if (adr_address.find('span.locality').length > 0)
			{
				$('input#pickUp_city2').val(adr_address.find('span.locality').text());
			}
			if (adr_address.find('span.region').length > 0)
			{
				$('input#pickUp_state2').val(adr_address.find('span.region').text());
			}
			if (adr_address.find('span.postal-code').length > 0)
			{
				$('input#pickup_zip2').val(adr_address.find('span.postal-code').text());
			}
			
			
		}
		function fillInAddress3() {
			var place = dropOff_address2.getPlace();
			var adr_address = $('<div>'  + place.adr_address + '</div>');
			$('input#dropOff_address2, input#dropOff_city2, input#dropOff_state2,input#dropOff_zip2 ').val('');
			if (adr_address.find('span.street-address').length > 0)
			{
				$('input#dropOff_address2').val(adr_address.find('span.street-address').text());
			}
			if (adr_address.find('span.locality').length > 0)
			{
				$('input#dropOff_city2').val(adr_address.find('span.locality').text());
			}
			if (adr_address.find('span.region').length > 0)
			{
				$('input#dropOff_state2').val(adr_address.find('span.region').text());
			}
			if (adr_address.find('span.postal-code').length > 0)
			{
				$('input#dropOff_zip2').val(adr_address.find('span.postal-code').text());
			}
			
		}
		// [END region_fillform]
		
		/*Stop form submission*/
			$(document).ready(function() {
			  $('#getQuoteForm').keydown(function(event){
			    if(event.keyCode == 13) {
			      event.preventDefault();
			      return false;
			    }
			  });
			 
		});
		jQuery(function($){
			initialize();
		});
		jQuery(document).ready(function($) {
			//Initail Detail
			$('#pickUp_residential').hide();
			$('#residential_radio').on('click', function(){
				$('#pickUp_airport').slideUp();
				$('#pickUp_residential').slideDown();
				$('#pickUp_airport ').find("input[type=text], textarea, select").val("");
			});
			$('#airport_radio').on('click', function(){
				$('#pickUp_residential').slideUp();
				$('#pickUp_airport').slideDown();
				$('#pickUp_residential').find("input[type=text], textarea, select").val("");
			});
			$('#dropOff_residential').hide();
			$('#dropOff_airport_radio').on('click', function(){
				$('#dropOff_residential').slideUp();
				$('#dropOff_airport').slideDown();
				$('#dropOff_residential ').find("input[type=text], textarea, select").val("");
			});
			$('#dropOff_residential_radio').on('click', function(){
				$('#dropOff_airport').slideUp();
				$('#dropOff_residential').slideDown();
				$('#dropOff_airport').find("input[type=text], textarea, select").val("");
			});
			
			//Other Location Detail
			$('#pickUp_residential2').hide();
			$('#residential_radio2').on('click', function(){
				$('#pickUp_airport2').slideUp();
				$('#pickUp_residential2').slideDown();
				$('#pickUp_airport2').find("input[type=text], textarea, select").val("");
			});
			$('#airport_radio2').on('click', function(){
				$('#pickUp_residential2').slideUp();
				$('#pickUp_airport2').slideDown();
				$('#pickUp_residential2').find("input[type=text], textarea, select").val("");
			});
			$('#dropOff_residential2').hide();
			$('#dropOff_airport_radio2').on('click', function(){
				$('#dropOff_residential2').slideUp();
				$('#dropOff_airport2').slideDown();
				$('#dropOff_residential2').find("input[type=text], textarea, select").val("");
			});
			$('#dropOff_residential_radio2').on('click', function(){
				$('#dropOff_airport2').slideUp();
				$('#dropOff_residential2').slideDown();
				$('#dropOff_airport2').find("input[type=text], textarea, select").val("");
			});
		});
		jQuery(document).ready(function($) {
			$('#passengers').on('change', function(e){
				passenger = $('#passengers').val();
				if(passenger > 5){
					$('#myModal').modal('toggle');
					e.preventDefault();
				}else if(passenger >= 4){
					$("input.luxury, input.economy").attr('disabled', true);
				}else if(passenger >= 3){
					$("input.economy").attr('disabled', true);
				}
			});
		});
		jQuery(document).ready(function($) {
			$('#btnSubmitValidator, #btnSubmitValidator2').on('click', function(e){
				passenger = $('#passengers').val();
				if(passenger > 5){
					$('#myModal').modal('toggle');
					e.preventDefault();
				}else if(passenger >= 4){
					$("input.luxury, input.economy").attr('disabled', true);
				}else if(passenger >= 3){
					$("input.economy").attr('disabled', true);
				}
			});
		});
		jQuery(document).ready(function($) {
			$('#copyDropOffLocation').on('click', function(){
				if($(this).prop('checked')==true){
					dropoff_airport = $('#dropoff_airport').val();
					dropOff_address = $('#dropOff_address').val();
					dropOff_addressLine2 = $('#dropOff_addressLine2').val();
					dropOff_city = $('#dropOff_city').val();
					dropOff_state = $('#dropOff_state').val();
					dropOff_zip = $('#dropOff_zip').val();
					if(dropoff_airport.length > 0){
						$('#p_airprot2').val(dropoff_airport);
						$('#pickUp_residential2').slideUp();
						$('#pickUp_airport2').slideDown();
					}else if(dropOff_address.length > 0){
						$('#pickUp_address2').val(dropOff_address);
						$('#pickUp_city2').val(dropOff_city);
						$('#pickUp_state2').val(dropOff_state);
						$('#pickup_zip2').val(dropOff_zip);
						
						$('#pickUp_airport2').slideUp();
						$('#pickUp_residential2').slideDown();
					}else{
						alert('Enter drop off location first.');
						$(this).prop('checked', false);
					}
				}
			});
			$('#copyPickUpLocation').on('click', function(){
				if($(this).prop('checked')==true){
					pickup_airport = $('#pickup_airport').val();
					pickup_address = $('#pickup_address').val();
					addressLine2 = $('#addressLine2').val();
					pickup_city = $('#pickup_city').val();
					pickup_state = $('#pickup_state').val();
					pickup_zip = $('#pickup_zip').val();
					if(pickup_airport.length > 0){
						$('#d_aiport2').val(pickup_airport);
						$('#dropOff_residential2').slideUp();
						$('#dropOff_airport2').slideDown();
					}else if(pickup_address.length > 0){
						$('#dropOff_address2').val(pickup_address);
						$('#dropOff_addressLine2_2').val(addressLine2);
						$('#dropOff_city2').val(pickup_city);
						$('#dropOff_state2').val(pickup_state);
						$('#dropOff_zip2').val(pickup_zip);
						
						$('#dropOff_airport2').slideUp();
						$('#dropOff_residential2').slideDown();
					}else{
						alert('Enter pick up location first.');
						$(this).prop('checked', false);
					}
				}
			});
		});
		jQuery(document).ready(function($) {
			$('#btnSubmitValidator, #btnSubmitValidator2').on('click', function(e){
				//Pickup1 data
				pickup_airport = $('#pickup_airport').val();
				pickup_address = $('#pickup_address').val();
				//Dropoff1 data
				dropoff_airport = $('#dropoff_airport').val();
				dropOff_address = $('#dropOff_address').val();
				//Pickup2 data
				pickUp_airport2 = $('#p_airprot2').val();
				pickUp_address2 = $('#pickUp_address2').val();
				//Dropoff2 data
				dropOff_airport2 = $('#d_aiport2').val();
				dropOff_address2 = $('#dropOff_address2').val();
				
				if(pickup_airport.length > 0 && dropoff_airport.length > 0 && pickup_airport == dropoff_airport){
					alert('Same Airport Selected.')
					e.preventDefault();
				}else if(pickup_address.length > 0 && dropOff_address.length > 0 && pickup_address == dropOff_address){
					alert('Same Location Selected.')
					e.preventDefault();
				}else if(pickUp_airport2.length > 0 && dropOff_airport2.length > 0 && pickUp_airport2 == dropOff_airport2){
					alert('Same Airport Selected.')
					e.preventDefault();
				}else if(pickUp_address2.length > 0 && dropOff_address2.length > 0 && pickUp_address2 == dropOff_address2){
					alert('Same Location Selected.')
					e.preventDefault();
				}
			});
		});
		/*jQuery(document).ready(function($) {
			$('#btnSubmitValidator, #btnSubmitValidator2').on('click', function(e){
				pickup_zip = $('#pickup_zip').val();
				dropoff_zip = $('#dropoff_zip').val();
	
				pickup_zip2 = $('#pickup_zip2').val();
				dropoff_zip2 = $('#dropoff_zip2').val();
				
				if(pickup_zip >= 91916 && pickup_zip <= 92599 || dropoff_zip >= 91916 && dropoff_zip <= 92599 || 
						pickup_zip2 >= 91916 && pickup_zip2 <= 92599 || dropoff_zip2 >= 91916 && dropoff_zip2 <= 92599){
					$('#ristrictedZip').modal('toggle');
					e.preventDefault();
				}
			});
		});*/
		jQuery(document).ready(function($) {
			$('#otherlocation').hide();
			$('#otherLocationDetail').hide();
			$('#onewayTrip').on('click', function(){
				$('#otherlocation').hide();
				$('#otherlocationCheck').prop('checked', false);
				$('#otherLocationDetail').hide();
				
			});
			$('#roundTrip').on('click', function(){
				$('#otherlocation').show();
			});
			$('#otherlocationCheck').on('click', function(){
				if($(this).prop('checked')==true){
					$('#otherLocationDetail').slideDown();
				}else{
					$('#otherLocationDetail').slideUp();
				}
			});
		});
		$("#getQuoteForm").validate({
			submitHandler: function(form) {
		    	form.submit();
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
		jQuery.extend(jQuery.validator.messages, {
		    required: "Required Field.",
		});
		</script>
EOD;
	$footerJs = Array("type"=>"inline", "script"=>$footerJs);
	add_header_footer_cssJS('footer_js', $footerJs);
?>