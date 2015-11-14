<h3 class="header smaller lighter blue"><?php echo $title ?></h3>

<form method="post" action="<?php echo $action; ?>" id="driverForm">
	<input type="hidden" name="driverID" value="<?php if(isset($Driver['driverID'])){ echo $Driver['driverID'];}?>">
	<input type="hidden" name="action" value="<?php if(isset($action['action'])){ echo $action['action'];}?>">
	<div class="form-group">
		<div class="row controls">
			<label for="status" class="col-sm-2 control-label">Status: <span class="req">*</span></label>
			<div class="col-sm-4">
				<label class="radio-inline">
					<input type="radio" name="isActive" value="1" required="true" <?php if(isset($Driver['isActive']) && $Driver['isActive'] == 1 || $Driver['isActive'] == '' ) {echo 'checked';} ?>> Active
				</label>
				<label class="radio-inline">
					<input type="radio" name="isActive" value="0" required="true" <?php if(isset($Driver['isActive']) && $Driver['isActive'] == 0 ) {echo 'checked';} ?>> In Active
				</label>
				<?php echo form_error('status'); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row controls">
			<label for="firstName" class="col-sm-2 control-label">First Name: <span class="req">*</span></label>
			<div class="col-sm-4">
				<input type="text" name="firstName" class="form-control" id="firstName" required="true" value="<?php echo (set_value('firstName'))?set_value('firstName'):$Driver['firstName']; ?>">
				<?php echo form_error('firstName'); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row controls">
			<label for="lastName" class="col-sm-2 control-label">Last Name: <span class="req">*</span></label>
			<div class="col-sm-4">
				<input type="text" name="lastName" class="form-control" id="lastName" required="true" value="<?php echo (set_value('lastName'))?set_value('lastName'):$Driver['lastName']; ?>">
				<?php echo form_error('lastName'); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row controls">
			<label for="email" class="col-sm-2 control-label">Email: <span class="req">*</span></label>
			<div class="col-sm-4">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-envelope"></i>
					</span>
					<input type="email" name="email" class="form-control" id="email" required="true" value="<?php echo (set_value('email'))?set_value('email'):$Driver['email']; ?>">	
				</div>
				
				<?php echo form_error('email'); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row controls">
			<label for="phone" class="col-sm-2 control-label">Phone: <span class="req">*</span></label>
			<div class="col-sm-4">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-phone"></i>
					</span>
					<input type="text" name="phone" class="form-control input-mask-phone" id="phone" required="true" value="<?php echo (set_value('phone'))?set_value('phone'):$Driver['phone']; ?>">
				</div>
				<?php echo form_error('phone'); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row controls">
			<label for="Address" class="col-sm-2 control-label">Address:</label>
			<div class="col-sm-4">
				<input type="text" name="Address" class="form-control" id="Address" value="<?php echo (set_value('Address'))?set_value('Address'):$Driver['Address']; ?>">
				<?php echo form_error('Address'); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row controls">
			<label for="City" class="col-sm-2 control-label"></label>
			<div class="col-sm-2">
				<input type="text" placeholder="City" name="City" class="form-control" id="City" value="<?php echo (set_value('City'))?set_value('City'):$Driver['City']; ?>">
				
			</div>
			<div class="col-sm-1">
				<input type="text" placeholder="State" name="State" class="form-control" id="State" value="<?php echo (set_value('State'))?set_value('State'):$Driver['State']; ?>">
				
			</div>
			<div class="col-sm-1">
				<input type="text" placeholder="Zip Code" name="zipCode" class="form-control" id="zipCode" value="<?php echo (set_value('zipCode'))?set_value('zipCode'):$Driver['zipCode']; ?>">
				
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row controls">
			<label for="socialSecurity" class="col-sm-2 control-label">Social Security:</label>
			<div class="col-sm-4">
				<input type="text" name="socialSecurity" class="form-control" id="socialSecurity" value="<?php echo (set_value('socialSecurity'))?set_value('socialSecurity'):$Driver['socialSecurity']; ?>">
				<?php echo form_error('socialSecurity'); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row controls">
			<label for="license" class="col-sm-2 control-label">License:</span></label>
			<div class="col-sm-4">
				<input type="text" name="license" class="form-control" id="license" value="<?php echo (set_value('license'))?set_value('license'):$Driver['license']; ?>">
				<?php echo form_error('license'); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row controls">
			<label for="bankName" class="col-sm-2 control-label">Bank Name:</label>
			<div class="col-sm-4">
				<input type="text" name="bankName" class="form-control" id="bankName" value="<?php echo (set_value('bankName'))?set_value('bankName'):$Driver['bankName']; ?>">
				<?php echo form_error('bankName'); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row controls">
			<label for="bankAccount" class="col-sm-2 control-label">Bank Account:</label>
			<div class="col-sm-4">
				<input type="text" name="bankAccount" class="form-control" id="bankAccount" value="<?php echo (set_value('bankAccount'))?set_value('bankAccount'):$Driver['bankAccount']; ?>">
				<?php echo form_error('bankAccount'); ?>
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-sm-6 text-right">
			<button type="submit" class="btn btn-primary">Submit</button>
			<a href="/app/admin/index.php/driver" class="btn btn-default">Cancel</a>
		</div>
	</div>
</form>

<?php
$footerJs = <<<EOD
<script>
$(function(){
	$('.input-mask-phone').mask('(999) 999-9999');				
	$("#driverForm").validate({
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
})
</script>
EOD;
$footerJs = Array("type"=>"inline", "script"=>$footerJs);
add_header_footer_cssJS('footer_js', $footerJs);
?>