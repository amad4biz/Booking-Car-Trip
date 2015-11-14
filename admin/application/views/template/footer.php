								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content-area -->
				</div><!-- /.page-content -->
			</div><!-- /.main-content -->

			<div class="footer">
				<div class="footer-inner">
					<!-- #section:basics/footer -->
					<div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder">Xpress Shuttle</span>
							Control Panel &copy; 2013-2014
						</span>

					</div>

					<!-- /section:basics/footer -->
				</div>
			</div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='/app/admin/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		
		<!-- page specific plugin scripts -->
		<?php
			$jsFiles = array('','ace-extra.min', 'bootstrap.min', 'jquery.dataTables.min', 'jquery.dataTables.min', 'jquery.maskedinput.min', 'jquery.validate.min', 'jquery-ui.custom.min', 'jquery.ui.touch-punch.min', 'jquery.easypiechart.min', 'jquery.sparkline.min',  'application', 'flot'=>array('jquery.flot.min', 'jquery.flot.pie.min', 'jquery.flot.resize.min'), 'ace-elements.min', 'ace.min', 'fullcalendar' , 'jquery.jeditable.mini','jquery.dataTable.editable', 'bootstrap-wysiwyg.min','IE8' => array('html5shiv.min', 'respond.min', 'excanvas.min'));
			foreach($jsFiles as $key => $file){
				if($key == 'IE8'){
					echo '<!--[if lte IE 8]>';
					/* foreach($file as $IE_file){
						echo '<script src="/app/admin/assets/js/'.$IE_file.'.js"></script>'. "\n";
					} */
					echo '<![endif]-->';
				}elseif($key == 'flot'){
					foreach($file as $flot_file){
						echo '<script src="/app/admin/assets/js/flot/'.$flot_file.'.js"></script>'. "\n";
					}
				}else{
					echo '<script src="/app/admin/assets/js/'.$file.'.js"></script>'. "\n";
				}
			}
		?>
		<script src="/app/admin/assets/js/date-time/bootstrap-datepicker.min.js"></script>
		<script src="/app/admin/assets/js/date-time/bootstrap-timepicker.min.js"></script>
		<script type="text/javascript" src="/app/admin/assets/ckeditor/ckeditor.js"></script>
		
		<?php
			echo print_OctHeaderFooterCSSJS('footer_js');
		
		?>
		
		<!-- inline scripts related to this page
		<script type="text/javascript">
			/* THIS I HAVE MOVDE 
			jQuery(function($) {
				$('.input-mask-phone').mask('(999) 999-9999');				
			});
			$("#vehicle, #driverForm, #userForm, #formReservation").validate({
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
						: '.'
					}
				}
			});			
			*/
			/* This I HAVE MOVED
			jQuery(function($) {
				$('#formReservation input[name="trip"]').click(function(){
					$('#formReservation input[name="otherLocation"]').attr('checked',false);
					if($(this).val() == 1){
						$('#formReservation div#location2').hide();	
						$('#formReservation div#otherLocationContainer').hide();
					}
					else{
						$('#formReservation div#otherLocationContainer').show();
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
				$('#formReservation select,input').change(function(){
					update_trip_cost();
				});
				$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				$('.timepicker').timepicker({
					minuteStep: 1,
					showSeconds: true,
					showMeridian: false
				}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				CKEDITOR.replace( 'htmlBody', {toolbar: 'Basic'});
			    $('#emailTemplateTab a').click(function (e) {
				    e.preventDefault();
				    $(this).tab('show');
			    });
			    $('#autoEmailEventID').change(function(){
					var autoEmailEventID = $('#autoEmailEventID option:selected').val();
					if(autoEmailEventID > 0){
					}	    	
			    });
			    
			    /*.
			});	
			function insertMergeField(fieldCode) {
				CKEDITOR.instances.htmlBody.insertHtml( '<span class="mailmerge">' + fieldCode + '&nbsp;</span>' );
			}
			function insertAtCaret(code) {
				$('#textBody').append(code + ' ');
			} 
		</script> -->
		<!-- Google auto complete api 
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
		function initialize() {
		  directionsDisplay = new google.maps.DirectionsRenderer();
		  directionsDisplay2 = new google.maps.DirectionsRenderer();
		  pickup1Address1 = new google.maps.places.Autocomplete(document.getElementById('pickup1Address1'));
		  pickup2Address1 = new google.maps.places.Autocomplete(document.getElementById('pickup2Address1'));
		  dropoff1Address1 = new google.maps.places.Autocomplete(document.getElementById('dropoff1Address1'));
		  dropoff2Address1 = new google.maps.places.Autocomplete(document.getElementById('dropoff2Address1'));
		  google.maps.event.addListener(pickup1Address1, 'place_changed', function() {
			  _pickup1Address1();
			  //update_trip_cost();
		  });
		  google.maps.event.addListener(pickup2Address1, 'place_changed', function() {
			  _pickup2Address1();
			  //update_trip_cost();
		  });
		  google.maps.event.addListener(dropoff1Address1, 'place_changed', function() {
			  _dropoff1Address1();
			  update_trip_cost();
		  });
		  google.maps.event.addListener(dropoff2Address1, 'place_changed', function() {
			  _dropoff2Address1();
			  update_trip_cost();
		  });
		}
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
		function update_trip_cost(){
			booingID = parseInt($('#formReservation input[name="bookingID"]').val());
			if(booingID == 0){
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
					}
				});			
			}	
			else{
				$('#formReservation input[type="text"],#formReservation input[type="radio"],#formReservation input[type="checkbox"], #formReservation select').each(function(){
					$(this).attr('disabled',true);
				});
				$('#formReservation textarea[name="specialInstructions"]').attr('disabled',true);
				$('#formReservation select[name="vehicleID"]').attr('disabled',false);
				$('#formReservation select[name="driverID"]').attr('disabled',false);
				$('#formReservation select[name="bookingStatusID"]').attr('disabled',false);
				$('#formReservation select[name="vehicleID"]').attr('disabled',false);
				if(parseInt($('#formReservation input[name="isProcessed"]').val()) == 0){
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
			}
		}
		</script>-->
	</body>
</html>
