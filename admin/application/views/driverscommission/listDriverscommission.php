<?php 
//var_dump($driverscommissiondata);
?>
<div class="row print">
    <div class="col-xs-12">
        <h3 class="header smaller lighter blue"><?php echo $Driver['lastName'] . ' ' . $Driver['firstName'] ?> Commission</h3>
        <div class="row">
        	<div class="col-sm-12 text-right" style="margin:0 0 10px 0;">
        		<a href="<?php echo 'https://www.xpressshuttles.com/app/admin/index.php/driverscommission/edit/?driverscommissionID=0'.'&driverID='.$Driver['driverID'] ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add Driver's Commission </a>
        	</div>
        </div>
        <div>
            <div id="drivers_wrapper" class="dataTables_wrapper form-inline" role="grid">
            <h3 class="header smaller lighter blue">Commission plan for <?php echo $Driver['lastName'] . ' ' . $Driver['firstName'] ?> </h3>
				<table id="DriversListings" class="print table table-striped table-bordered table-hover dataTable" aria-describedby="sample-table-2_info">
					<thead>
						<tr role="row">
                            <th>Commission (%)</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th class="sorting_disabled">Status</th>
                             <th class="sorting_disabled">Action</th>
                        </tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php if(count($driverscommissiondata) > 0) { ?>
						<?php foreach ($driverscommissiondata as $driver_detail): ?>
						<tr>
                            <td><?php echo $driver_detail['commission'];?></th>
                            <td><?php echo $driver_detail['formattedStartDate']; ?></th>
                            <td><?php echo $driver_detail['formattedEndDate'];?></th>
                            <td>
	                            <?php 
	                            	if($driver_detail['isActive'] == 1){
	                            		echo '<span class="label label-success arrowed-in arrowed-in-right">Active</span>';
	                            	}else{
	                            		echo '<span class="label label-danger arrowed arrowed-right">In-Active</span>';
	                            	}
	                            ?>
                            </th>
                            <td>
                            	<a href="https://www.xpressshuttles.com/app/admin/index.php/driverscommission/edit/?driverId=<?php echo $driver_detail['driverID']; ?>&driverscommissionID=<?php echo $driver_detail['driverscommissionID']; ?>" title="Edit" class="green">
									<i class="ace-icon fa fa-pencil bigger-130"></i>
								</a>
								<a href="https://www.xpressshuttles.com/app/admin/index.php/driverscommission/delete/?driverscommissionID=<?php echo $driver_detail['driverscommissionID']; ?>" title="Edit" class="red">
									<i class="ace-icon fa fa-trash bigger-130"></i>
								</a>
		                        <!--<a class="btn-xs btn-success" href="/index.php/driverscompensation/?driverId=<?php echo $driver_detail['driverID'];?>">
		                        	<i class="fa fa-eye"></i> View Compensation
		                        </a>
	                        --></th>
                        </tr>
                        <?php endforeach ?>
                        <?php }else{ ?>
                        <tr>
                            <td align="center" colspan="4" >No commission plan has been made for this driver.</th>
                        </tr>	
                        <?php }?>
                    </tbody>
				</table>
			</div>
        </div>
        <div id="drivers_wrapper" class="dataTables_wrapper form-inline" role="grid">
            <h3 class="header smaller lighter blue">Commissions for <?php echo $Driver['lastName'] . ' ' . $Driver['firstName'] ?> </h3>
			<form class="form-search">
				<div class="row">
					<div class="col-sm-12">
						<div class="input-group">
							<div class="row">
								<form class="form-inline">
									<fieldset>
										<!-- <input type="hidden" name="driverId" value="<?php echo $Driver['driverID'];?>"/> -->
										<label>&nbsp;<strong>Driver</strong></label>
										<select name="driverID" class="input-large">
											<?php 
												foreach($qryDrivers as $drivers){
													echo '<option value="' . $drivers['driverID'] . '"';
													if(isset($Driver['driverID']) && $Driver['driverID'] == $drivers['driverID']){
														echo ' selected="selected" ';
													}
													echo '>' . $drivers['firstName'] . ' ' . $drivers['lastName'];
													echo '</option>';	
												}
											?>
										</select>
										<label>&nbsp;<strong>From</strong></label>
										<input name="startDate" placeholder="Date" class="input-small date-picker" value="<?php  if (isSet($_REQUEST['startDate'])) { echo $_REQUEST['startDate']; } ?>"/>
										<label>&nbsp;<strong> To </strong></label>
										<input name="endDate" placeholder="Date" class="input-small date-picker" value="<?php  if (isSet($_REQUEST['endDate'])) { echo $_REQUEST['endDate']; } ?>"/>
										<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-search"></i> Search</button>
									</fieldset>
								</form>	
							</div>	
						</div>
					</div>
				</div>
			</form>
		</div>
		<table class="print table table-striped table-bordered table-hover dataTable" aria-describedby="sample-table-2_info">
			<thead>
				<tr role="row">
                            <th class="sorting_disabled">Drivers Name</th>
                            <th class="sorting_disabled">Booking #</th>
                            <th class="sorting_disabled">Booking Date</th>
                            <th class="sorting_disabled">Trip Leg</th>
                            <th class="sorting_disabled">Commission % of Cost</th>
                            <th class="sorting_disabled">Commission</th>
                            <th class="sorting_disabled">Tip Amount</th>
                            <th class="sorting_disabled">Total Payout</th>
                        </tr>
			</thead>
			<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php if(count($driverscommissiondata) > 0) { ?>
						<?php 
							$grandTotal = 0;
						?>
                        <?php foreach ($driverscommission as $driver_detail): ?>
                        <?php 
                        	$commission = ((($driver_detail['cost'] / $driver_detail['totalLeg']) / 100) * $driver_detail['commissionPercentage']);
                        	$tipAmount  = ($driver_detail['tipAmount'] / $driver_detail['totalLeg']);
                        	$total      = $commission + $tipAmount; 
							$grandTotal += $total;
                        ?>
						<tr>
                            <td><?php echo $driver_detail['lastName'] .', '. $driver_detail['firstName'];?></th>
                            <td><?php echo $driver_detail['bookingID']; ?></th>
                            <td><?php echo $driver_detail['formattedBookingDate'] . ' ' . $driver_detail['formattedBookingTime'] ; ?></th>
                            <td><?php if($driver_detail['tripLeg'] == 'second'){ echo 'Second';}else{echo 'First';}?></th>
                            <td><?php echo $driver_detail['commissionPercentage'] . '% of $' . ($driver_detail['cost']  / $driver_detail['totalLeg']) . ''; ?></td>
                            <td>$<?php echo $commission;?></th>
                            <td>$<?php echo $tipAmount;?></th>
                            <td>$<?php echo $total;?></th>
                        </tr>
                        <?php endforeach ?>
	                    <tr>
		                    <td align="center" colspan="7"><b>Total Commission of <i>"<?php echo $driver_detail['lastName'] .' '. $driver_detail['firstName'];?>"</i><b/> </th>
		                    <td><b>$<?php echo $grandTotal; ?></b></th>
	                    </tr>
	                    <?php }else{ ?>
	                    <tr>
                            <td align="center" colspan="8" >No commission plan has been made for this driver.</th>
                        </tr>
                    <?php } ?>
                    
                    </tbody>
		</table>
		</div>
    </div>
</div>

<?php
if(count($driverscommissiondata) > 0) {
$footerJs = <<<EOD
<script>
  $('table#DriversListings').dataTable( {
	            "sDom": "<'row'<'col-xs-6'l><'col-xs-6'f>r>t<'row'<'col-xs-6'i><'col-xs-6'p>>",
						"sPaginationType": "oct",
						"oLanguage": {
							"sLengthMenu": "_MENU_ records per page"
						},
	            "aoColumnDefs": [
	               //{"bSortable": false, "aTargets": [ 3 ] },
	               //{"bSortable": false, "aTargets": [ 0 ] }
	            ],
	            "bFilter": false,
	            "bStateSave": true,
	            "bPaginate": false,
	            "iCookieDuration": 60*60*24*5,
	            "aaSorting": [[0, 'desc']],
	             "aLengthMenu": [
	                [25, 50, 100, 200, 500],
	                [25, 50, 100, 200, 500] // change per page values here
	            ],
	            // set the initial value
	            "iDisplayLength": 50,
	        });

	$(function(){
		$('.date-picker').datepicker();
	})
</script>


EOD;
$footerJs = Array("type"=>"inline", "script"=>$footerJs);
add_header_footer_cssJS('footer_js', $footerJs);
}
?>