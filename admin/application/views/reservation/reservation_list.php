<div class="row print">
    <div class="col-xs-12">
        <h3 class="header smaller lighter blue">Reservation</h3>
        <div class="row">
        	<div class="col-sm-6" style="margin:0 0 10px 0;">
        		<a href="/app/admin/index.php/reservation/calendar" class="btn btn-warning"><i class="fa fa-calendar"></i> View calendar</a>
        	</div>
        	<div class="col-sm-6 text-right" style="margin:0 0 10px 0;">
        		<a href="/app/admin/index.php/reservation/edit/0" class="btn btn-primary"><i class="fa fa-plus"></i> New Reservation</a>
        	</div>
        </div>        
        <div>
			<div class="widget-box">
				<div class="widget-body">
					<div class="widget-main">
						<form class="form-search">
							<div class="row">
								<div class="col-sm-12">
									<div class="input-group">
										<div class="row">
											<form class="form-inline">
												<label style="margin-left:5px;">From</label>
												<input name="startdate" type="text" placeholder="start date" class="input-small date-picker" value="<?php  if (isSet($startdate)) { echo $startdate; } ?>" />
												<label>To</label>
												<input name="enddate" type="text" placeholder="end date" class="input-small date-picker" value="<?php if (isSet($enddate)) { echo $enddate; }   ?>" />
												<label>Driver</label>
												<select name="driverID" class="input-small">
													<option value=""></option>
													<?php 
														$driverJSON = "'0':'',";
														foreach($qryDrivers as $driver){
															echo '<option value="' . $driver['driverID'] . '"';
															if(isset($driverID) && $driverID == $driver['driverID']){
																echo ' selected="selected" ';
															}
															echo '>' . $driver['firstName'] . ' ' . $driver['lastName'];
															echo '</option>';	
															$driverJSON .= "'".$driver['driverID']."':'".$driver['firstName'] . " " . $driver['lastName']."',";
														}
													?>
												</select>
                                                <label>Vehicle</label>
                                                <select name="vehicleID" class="input-large">
                                                    <option value=""></option>
                                                    <?php 
                                                        $vehicleJSON = '';
                                                        foreach($qryVehicles as $vehicle){
                                                            echo '<option value="' . $vehicle['vehicleID'] . '"';
                                                            if(isset($vehicleID) && $vehicleID == $vehicle['vehicleID']){
                                                                echo ' selected="selected" ';
                                                            }
                                                            echo '>' . $vehicle['year'] . ' ' . $vehicle['make'] . ' ' . $vehicle['model'] . ' (' . $vehicle['vehiclePlate'] . ')';
                                                            echo '</option>';    
                                                            $vehicleJSON .= "'".$vehicle['vehicleID']."':'".$vehicle['year'] . " " . $vehicle['make'] . " " . $vehicle['model'] . " (" . $vehicle['vehiclePlate'].")',";
                                                        }
                                                    ?>
                                                </select>
												<label>Status</label>
												<select name="bookingStatusID" class="input-small">
													<?php 
														$bookingStatusJSON = '';
														foreach($qryBookingStatuses as $status){
															echo '<option value="' . $status['bookingStatusID'] . '"';
															if(isset($bookingStatusID) && $bookingStatusID == $status['bookingStatusID']){
																echo ' selected="selected" ';
															}
															echo '>' . $status['bookingStatus'];
															echo '</option>';
															$bookingStatusJSON .= "'".$status['bookingStatusID']."':'".$status['bookingStatus'] ."',";
														}
													?>
												</select>
												<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-search"></i> Search</button>
											</form>	
										</div>	
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
            <div id="drivers_wrapper" class="dataTables_wrapper form-inline" role="grid">
				<table id="reservationListing" class="print table table-striped table-bordered table-hover dataTable" aria-describedby="sample-table-2_info">
					<thead>
						<tr role="row">
							<th>&nbsp;</th>
							<th>#</th>
							<th>P. Name</th>
							<th>PX</th>
							<th>Pickup Date</th>
							<th>To</th>							
							<th>Driver</th>
                            <th>Vehicle</th>							
							<th>Status</th>
							<th>Source</th>
							<th class="sorting_disabled"></th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($qryBooking as $qryBooking_detail): ?>
							<tr bookingID="<?php echo $qryBooking_detail['bookingID'];?>" bookingTripID="<?php echo $qryBooking_detail['bookingTripID'];?>" driver="<?php if($qryBooking_detail['driverName'] != ''){echo $qryBooking_detail['driverName'];}?>">
								<td><?php echo $qryBooking_detail['trip'];?></td>
								<td><?php echo $qryBooking_detail['bookingID'];?></td>
								<td><?php echo $qryBooking_detail['passengerName'];?>
									<br>
									<b>From:</b><br>
									<?php 
										if (strLen($qryBooking_detail['pickupAirport'])) {
											echo $qryBooking_detail['pickupAirport'];
										}else {
											echo $qryBooking_detail['pickAddress1'] .'<br>' . $qryBooking_detail['pickCity'] . ' ' . $qryBooking_detail['pickZipcode'];
										}
									?>
								</th>
								<td><?php echo $qryBooking_detail['noOfPassenger'];?></th>
									
								<td><?php echo $qryBooking_detail['formattedPickupDate'] . ' ' . $qryBooking_detail['formattedPickupTime'] ;?></th>
								
								<td>
									<?php 
										if (strLen($qryBooking_detail['dropAirPort'])) {
											echo $qryBooking_detail['dropAirPort'] ; 
										} else {
											echo $qryBooking_detail['dropAddress1'] .'<br>' . $qryBooking_detail['dropCity'] . ' ' . $qryBooking_detail['dropZipcode'];
										}
									?>
									
									
								</td>
								<td id="<?php echo $qryBooking_detail['bookingTripID']; ?>"><?php if($qryBooking_detail['driverName'] != ''){echo $qryBooking_detail['driverName'];}?></th>
                                <td id="<?php echo $qryBooking_detail['bookingTripID']; ?>"><?php if($qryBooking_detail['vehicle'] != ''){ echo $qryBooking_detail['vehicle'];}?></th>
								<td <?php if($qryBooking_detail['tripLeg'] == 'second'){ echo 'class="read_only"'; } ?>>
									<span class="label label-<?php if($qryBooking_detail['bookingStatus'] == 'Pending'){ echo 'warning';}else if($qryBooking_detail['bookingStatus'] == 'Draft'){echo 'info';}else if($qryBooking_detail['bookingStatus'] == 'Cancelled'){echo 'danger';}else{ echo 'success';} ?>">
									<?php echo substr($qryBooking_detail['bookingStatus'], 0, 1);?>
									</span>
								</td>
								<td>
									<?php echo $qryBooking_detail['bookingSource'];?>
								</td>
	                            <td>
	                            	<div class="hidden-sm hidden-xs action-buttons">
										<a class="green" title="Edit" href="/app/admin/index.php/reservation/edit/<?php echo $qryBooking_detail['bookingID'];?>">
											<i class="ace-icon fa fa-pencil bigger-130"></i>
										</a>
										<a class="Duplicate" title="Duplicate" href="/app/admin/index.php/reservation/duplicate/<?php echo $qryBooking_detail['bookingID'];?>">
											<i class="ace-icon fa fa-files-o bigger-130"></i>
										</a>
										<?php if($qryBooking_detail['driverID'] > 0){ ?>
										<a class="red" title="View way bill" href="/app/admin/index.php/waybills/view/<?php echo $qryBooking_detail['bookingTripID'];?>">
											<i class="ace-icon fa fa-eye bigger-130"></i>
										</a>
										<?php }?>
									</div>
	                            </th>
	                    	</tr>
                    	<?php endforeach ?>
                    </tbody>
				</table>
			</div>
        </div>
    </div>
</div>
<?php
$vehicleJSON = substr($vehicleJSON,0,-1);
$driverJSON = substr($driverJSON,0,-1);
$bookingStatusJSON = substr($bookingStatusJSON,0,-1);

$footerJs = <<<EOD
<script>
	
	$('table#reservationListing').dataTable({
            "sDom": "<'row'<'col-xs-6'l><'col-xs-6'f>r>t<'row'<'col-xs-6'i><'col-xs-6'p>>",
			"sPaginationType": "oct",
			"oLanguage": {
				"sLengthMenu": "_MENU_ records per page"
			},
            "aoColumnDefs": [
               //{"bSortable": false, "aTargets": [ 5 ] },
               //{"bSortable": false, "aTargets": [ 0 ] }
            ],
            "bFilter": false,
            "bStateSave": true,
            "bPaginate": false,
            "iCookieDuration": 60*60*24*5,
            "aaSorting": [[1, 'desc']],
             "aLengthMenu": [
                [25, 50, 100, 200, 500],
                [25, 50, 100, 200, 500] // change per page values here
            ],
            // set the initial value
            "iDisplayLength": 50,
	}).makeEditable({
	sUpdateURL: "index.cfm?fuseaction=orders.ajaxUpdateOpportunity",
	sSuccessResponse: "IGNORE",
    oEditableSettings: { event: 'click' },
    fnShowError: function (message, action) {
    	switch (action) {
        	case "update":
			break;
            case "delete":
       		break;
            case "add":
       		break;
       }
	},
	"callback": function( sValue, y ) {
		//alert(sValue);
		var aPos = oTable.fnGetPosition( this );
		oTable.fnUpdate( sValue, aPos[0], aPos[1] );
    }, 	
	"aoColumns": [
				null,
				null,
                null,
                null,
                null,
                null,
                {
                    indicator: 'Saving Driver...',
                    tooltip: 'Click to select driver',
                    loadtext: 'loading...',
                    type: 'select',
                    onblur: 'submit',
                    data: "\{$driverJSON\}",
                    sUpdateURL: function(value, settings){
                        
                        return updateDriver(value, $(this).parents('tr').attr('bookingTripID'),$(this).parents('tr').attr('driver'));
                        
                    }
                },
				{
	                indicator: 'Saving Vehicle...',
	                tooltip: 'Click to select vehicle',
	                loadtext: 'loading...',
	                type: 'select',
	                onblur: 'submit',
	                data: "\{$vehicleJSON\}",
	                sUpdateURL: function(value, settings){
	                	updateVehicle(value, $(this).parents('tr').attr('bookingTripID'));
	                	return value;
					}
				},  
				{
	                indicator: 'Saving Status...',
	                tooltip: 'Click to Status ',
	                loadtext: 'loading...',
	                type: 'select',
	                onblur: 'submit',
	                data: "\{$bookingStatusJSON\}",
	               
	                sUpdateURL: function(value, settings){
	                	
	                	updateBookingStatus(value, $(this).parents('tr').attr('bookingID'));
	                	return value;
					}
					
				},
                null,
                null
		]									
	});
	function updateDriver(driverID, bookingTripID,driver){
		if(driverID > 0){
			var result = confirm('Are you sure you want to update driver?');
			if(result == true){
				jQuery.ajax({
					type: 'post',
					url: '/app/admin/index.php/reservation/updateDriver',
					data: 'bookingTripID=' + parseInt(bookingTripID) + '&driverID=' + driverID,
					timeout: 20000,
					error: function (XMLHttpRequest, textStatus, errorThrown) {},
					success: function(html){}
				});
				return driverID;	
			}
			else{
				setTimeout(function() {
					if(driver != ''){
						jQuery('td.last-updated-cell').html(driver);
					}
					else{
						jQuery('td.last-updated-cell').html('Click to edit');
					}					
				}, 50);
				return 0;
			}
		}
		else{
			
			setTimeout(function() {
				if(driver != ''){
					jQuery('td.last-updated-cell').html(driver);
				}
				else{
					jQuery('td.last-updated-cell').html('Click to edit');
				}					
			}, 50);
			return 0;
		}
	}
	function updateBookingStatus(bookingStatusID, bookingID){
		jQuery.ajax({
			type: 'post',
			url: '/app/admin/index.php/reservation/updateBookingStatus',
			data: 'bookingID=' + parseInt(bookingID) + '&bookingStatusID=' + bookingStatusID,
			timeout: 20000,
			error: function (XMLHttpRequest, textStatus, errorThrown) {},
			success: function(html){}
		});
	}
	function updateVehicle(vehicleID, bookingTripID){
		jQuery.ajax({
			type: 'post',
			url: '/app/admin/index.php/reservation/updateVehicle',
			data: 'bookingTripID=' + parseInt(bookingTripID) + '&vehicleID=' + vehicleID,
			timeout: 20000,
			error: function (XMLHttpRequest, textStatus, errorThrown) {},
			success: function(html){}
		});
	}
	$(function(){
		$('.date-picker').datepicker();
	})
</script>
EOD;
$footerJs = Array("type"=>"inline", "script"=>$footerJs);
add_header_footer_cssJS('footer_js', $footerJs);
?> 
<?php
/*
$footerJs = <<<EOD
<script>
  		$('table#reservationListing').dataTable( {
            "sDom": "<'row'<'col-xs-6'l><'col-xs-6'f>r>t<'row'<'col-xs-6'i><'col-xs-6'p>>",
				"sPaginationType": "oct",
				"oLanguage": {
					"sLengthMenu": "_MENU_ records per page"
				},
            "aoColumnDefs": [
               //{"bSortable": false, "aTargets": [ 5 ] },
               //{"bSortable": false, "aTargets": [ 0 ] }
            ],
            "bFilter": false,
            "bStateSave": true,
            "bPaginate": false,
            "iCookieDuration": 60*60*24*5,
            "aaSorting": [[1, 'desc']],
             "aLengthMenu": [
                [25, 50, 100, 200, 500],
                [25, 50, 100, 200, 500] // change per page values here
            ],
            // set the initial value
            "iDisplayLength": 50,
        });
        $('.date-picker').datepicker({
        	startDate: new Date(),
			setDate: new Date(),	
        	autoclose:true
        }).next().on(ace.click_event, function(){
			$(this).prev().focus();
		});		
</script>


EOD;
$footerJs = Array("type"=>"inline", "script"=>$footerJs);
add_header_footer_cssJS('footer_js', $footerJs);
*/
?> 