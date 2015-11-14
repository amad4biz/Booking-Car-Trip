<h3 class="header smaller lighter blue"><?php echo $title ?></h3>
<form method="post" action="<?php echo $action; ?>" id="userForm">
	<input type="hidden" name="staffID" value="<?php if(isset($staff['staffID'])){ echo $staff['staffID'];}?>">
	<input type="hidden" name="action" value="<?php if(isset($action['action'])){ echo $action['action'];}?>">
	<div class="form-group">
		<div class="row controls">
			<label for="status" class="col-sm-2 control-label">Status: <span class="req">*</span></label>
			<div class="col-sm-4">
				<label class="radio-inline">
					<input type="radio" name="isActive" value="1"  <?php if(isset($staff['isActive']) && $staff['isActive'] == 1) {echo 'checked';} ?>> Active
				</label>
				<label class="radio-inline">
					<input type="radio" name="isActive" value="0"  <?php if(isset($staff['isActive']) && $staff['isActive'] == 0 ) {echo 'checked';} ?>> In Active
				</label>
				<?php echo form_error('isActive'); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row controls">
			<label for="firstName" class="col-sm-2 control-label">First Name: <span class="req">*</span></label>
			<div class="col-sm-4">
				<input type="text" name="firstName" class="form-control" ="true" id="firstName" value="<?php if(isset($staff['firstName'])){ echo $staff['firstName'];}?>">
				<?php echo form_error('firstName'); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row controls">
			<label for="lastName" class="col-sm-2 control-label">Last Name: <span class="req">*</span></label>
			<div class="col-sm-4">
				<input type="text" name="lastName" class="form-control"  ="true" id="lastName" value="<?php if(isset($staff['lastName'])){ echo $staff['lastName'];}?>">
				<?php echo form_error('lastName'); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row controls">
			<label for="email" class="col-sm-2 control-label">Email: <span class="req">*</span></label>
			<div class="col-sm-4">
				<input type="email" name="email" class="form-control" ="true" id="email" value="<?php if(isset($staff['email'])){ echo $staff['email'];}?>">
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
					<input type="text" name="phone" class="form-control input-mask-phone" ="true" id="phone"  value="<?php if(isset($staff['phone'])){ echo $staff['phone'];}?>">
				</div>
				<?php echo form_error('phone'); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row controls">
			<label for="userName" class="col-sm-2 control-label">Username: <span class="req">*</span></label>
			<div class="col-sm-4">
				<input type="text" name="userName" class="form-control"  ="true" id="userName" value="<?php if(isset($staff['userName'])){ echo $staff['userName'];}?>">
				<?php echo form_error('userName'); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row controls">
			<label for="password" class="col-sm-2 control-label">Password: <span class="req">*</span></label>
			<div class="col-sm-4">
				<input type="text" name="password" class="form-control" ="true" id="password" value="<?php if(isset($staff['password'])){ echo $staff['password'];}?>">
				<?php echo form_error('password'); ?>
			</div>
		</div>
	</div>
	
	
	<div class="form-group">
		<div class="col-sm-6 text-right">
			<button type="submit" class="btn btn-default">Submit</button>
			<a href="<?php echo site_url('/user') ?>" class="btn btn-primary">Cancel</a>
		</div>
	</div>
</form>


<?php
$footerJs = <<<EOD
<script>
$(function(){
	$('.input-mask-phone').mask('(999) 999-9999');				
	$("#userForm").validate({
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
})
</script>
EOD;
$footerJs = Array("type"=>"inline", "script"=>$footerJs);
add_header_footer_cssJS('footer_js', $footerJs);
?>