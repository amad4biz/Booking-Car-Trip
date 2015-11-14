<div class="row print">
    <div class="col-xs-12">
        <h3 class="header smaller lighter blue">Way Bills</h3>
        <div>
			<div class="widget-box">
				<div class="widget-body">
					<div class="widget-main">
						<form class="form-search">
							<div class="row">
								<div class="col-sm-12">
									<div class="input-group">
										<div class="row">
											<form action="waybill/index" class="form-inline">
												<label style="margin-left:5px;">From</label>
												<input name="startdate" type="text" placeholder="start date" class="input-small date-picker" value="<?php  if (isSet($startdate)) { echo $startdate; } ?>" />
												<label>To</label>
												<input name="enddate" type="text" placeholder="end date" class="input-small date-picker" value="<?php if (isSet($enddate)) { echo $enddate; }   ?>" />
												<label>Vehicle</label>
												<select name="vehicleID" class="input-large">
													<option value=""></option>
													<?php 
														foreach($qryVehicles as $vehicle){
															echo '<option value="' . $vehicle['vehicleID'] . '"';
															if(isset($vehicleID) && $vehicleID == $vehicle['vehicleID']){
																echo ' selected="selected" ';
															}
															echo '>' . $vehicle['year'] . ' ' . $vehicle['make'] . ' ' . $vehicle['model'] . ' (' . $vehicle['vehiclePlate'] . ')';
															echo '</option>';	
														}
													?>
												</select>
												<label>Driver</label>
												<select name="driverID" class="input-small">
													<option value=""></option>
													<?php 
														foreach($qryDrivers as $driver){
															echo '<option value="' . $driver['driverID'] . '"';
															if(isset($driverID) && $driverID == $driver['driverID']){
																echo ' selected="selected" ';
															}
															echo '>' . $driver['firstName'] . ' ' . $driver['lastName'];
															echo '</option>';	
														}
													?>
												</select>
												<label>Status</label>
												<select name="emailStatus" class="input-small">
													<option value="">All Status</option>
													<option value="Pending"
													<?php if(isset($emailStatus) && $emailStatus == 'Pending'){echo ' selected="selected" ';}?>
													>Pending</option>
													<option value="Sented"
													<?php if(isset($emailStatus) && $emailStatus == 'Sent'){echo ' selected="selected" ';}?>
													>Sent</option>
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
							<th>Passenger Name</th>
							<th>Pickup Date</th>
							<th>Vehicle</th>
							<th>Driver</th>
							<th>Date Sent</th>
							<th>Status</th>
							<th class="sorting_disabled"></th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php if(isset($qryBooking) && count($qryBooking) > 0){ ?>
						<?php foreach ($qryBooking as $qryBooking_detail): ?>
							<tr>
								<td><?php echo $qryBooking_detail['passengerName'];?></th>
								<td><?php echo $qryBooking_detail['formattedPickupDate'] . ' ' . $qryBooking_detail['formattedPickupTime'] ;?></th>
								<td><?php echo $qryBooking_detail['vehicle'];?></th>
								<td><?php echo $qryBooking_detail['driverName'];?></th>
								<td><?php echo $qryBooking_detail['dateSent'];?></th>
								<td>
									<span class="label label-<?php if($qryBooking_detail['emailStatus'] == 'Pending'){ echo 'warning';}else{ echo 'success';} ?>">
									<?php echo $qryBooking_detail['emailStatus'];?>
									</span>
								</th>
	                            <td>
	                            	<div class="hidden-sm hidden-xs action-buttons">
										<a class="red" title="View way bill" href="/app/admin/index.php/waybills/view/<?php echo $qryBooking_detail['bookingID'];?>">
											<i class="ace-icon fa fa-eye bigger-130"></i>
										</a>
									</div>
									<!-- 
	                            	<div class="hidden-sm hidden-xs action-buttons">
										<a class="green" title="Re-send" href="javascript:void(0);" onclick="if(confirm('Are you sure you want to re-send way bill to driver?')){self.location='/app/admin/index.php/waybills/resend/<?php echo $qryBooking_detail['bookingID'];?>';}">
											<i class="ace-icon fa fa-envelope bigger-130"></i>
										</a>
									</div>
									 -->
	                            </th>
	                    	</tr>
	                    <?php endforeach ?>
	                 <?php }?> 
                    </tbody>
				</table>
			</div>
        </div>
    </div>
</div>

<?php
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
?> 