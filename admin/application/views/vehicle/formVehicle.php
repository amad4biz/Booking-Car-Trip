<h3 class="header smaller lighter blue"><?php echo $title ?></h3>
<form method="post" action="<?php echo $action; ?>" id="vehicle">
	<input type="hidden" name="vehicleID" value="<?php if(isset($vehicle['vehicleID'])){ echo $vehicle['vehicleID'];}?>">
	<input type="hidden" name="action" value="<?php if(isset($action['action'])){ echo $action['action'];}?>">
	<div class="form-group">
		<div class="row controls">
			<label for="vehicleName" class="col-sm-2 control-label">Vehicle Name: <span class="req">*</span></label>
			<div class="col-sm-4">
				<input type="text" name="vehicleName" class="form-control" ="true" id="vehicleName" value="<?php if(isset($vehicle['vehicleName'])){ echo $vehicle['vehicleName'];}?>">
				<?php echo form_error('vehicleName'); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row controls">
			<label for="vehicleType" class="col-sm-2 control-label">Vehicle Type: <span class="req">*</span></label>
			<div class="col-sm-4">
				<select name="vehicleTypeID" class="form-control" id="vehicleType" ="true">
					<option value="">Select Vehicle Type</option>
					<?php 
						foreach($vehicleType as $vehicleTypeDetail){
							echo '<option value="'.$vehicleTypeDetail['vehicleTypeID'].'" ';
							if($vehicle['vehicleTypeID'] == $vehicleTypeDetail['vehicleTypeID']){
								echo 'selected';
							}
							echo '>'.$vehicleTypeDetail['vehicleType'].'</option>';
						}
					?>
				</select>
				<?php echo form_error('vehicleTypeID'); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row controls">
			<label for="vehiclePlate" class="col-sm-2 control-label">Vehicle Plate: <span class="req">*</span></label>
			<div class="col-sm-4">
				<input type="text" name="vehiclePlate" class="form-control" ="true" id="vehiclePlate" value="<?php if(isset($vehicle['vehiclePlate'])){ echo $vehicle['vehiclePlate'];}?>">
				<?php echo form_error('vehiclePlate'); ?>
			</div>
		</div>
	</div>
	<input type="hidden" name="vehicleCode">
	<!-- <div class="form-group">
		<div class="row controls">
			<label for="vehicleCode" class="col-sm-2 control-label">Vehicle Code: <span class="req">*</span></label>
			<div class="col-sm-4">
				<input type="text" name="vehicleCode" class="form-control" ="true" id="vehicleCode" value="<?php if(isset($vehicle['vehicleCode'])){ echo $vehicle['vehicleCode'];}?>">
				<?php echo form_error('vehicleCode'); ?>
			</div>
		</div>
	</div> -->
	<div class="form-group">
		<div class="row controls">
			<label for="year" class="col-sm-2 control-label">Year: <span class="req">*</span></label>
			<div class="col-sm-4">
				<input type="text" name="year" class="form-control" ="true" id="year" value="<?php if(isset($vehicle['year'])){ echo $vehicle['year'];}?>">
				<?php echo form_error('year'); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row controls">
			<label for="make" class="col-sm-2 control-label">Make: <span class="req">*</span></label>
			<div class="col-sm-4">
				<input type="text" name="make" class="form-control" ="true" id="make" value="<?php if(isset($vehicle['make'])){ echo $vehicle['make'];}?>">
				<?php echo form_error('make'); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row controls">
			<label for="model" class="col-sm-2 control-label">Model: <span class="req">*</span></label>
			<div class="col-sm-4">
				<input type="text" name="model" class="form-control" ="true" id="model" value="<?php if(isset($vehicle['model'])){ echo $vehicle['model'];}?>">
				<?php echo form_error('model'); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row controls">
			<label for="driverName" class="col-sm-2 control-label">Driver: </label>
			<div class="col-sm-4">
				<select name="driverID" class="form-control" id="driverName" >
					<option value="">Select Driver</option>
					<?php 
						foreach($driver as $driverDetail){
							echo '<option value="'.$driverDetail['driverID'].'" ';
							if($vehicle['driverID'] == $driverDetail['driverID']){
								echo 'selected';
							}
							echo '>'.$driverDetail['firstName'].' '. $driverDetail['lastName'].'</option>';
						}
					?>
				</select>
				<?php echo form_error('driverID'); ?>
			</div>
		</div>
		
	</div>
	
	<div class="form-group">
		<div class="col-sm-6 text-right">
			<button type="submit" class="btn btn-primary">Submit</button>
			<a href="<?php echo site_url('/vehicle') ?>" class="btn btn-default">Cancel</a>
		</div>
	</div>
</form>


<?php
$footerJs = <<<EOD
<script>
$(function(){
	$('.input-mask-phone').mask('(999) 999-9999');				
	$("#vehicle").validate({
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
});
</script>
EOD;
$footerJs = Array("type"=>"inline", "script"=>$footerJs);
add_header_footer_cssJS('footer_js', $footerJs);
?>