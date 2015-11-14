<h3 class="header smaller lighter blue"><?php echo $title ?></h3>
<?php 
	//var_dump($driverscommission);
?>
<form method="post" action="<?php echo $action; ?>" id="driversCommissionForm">
	<input type="hidden" name="driverscommissionID" value="<?php if(isset($driverscommission['driverscommissionID'])){ echo $driverscommission['driverscommissionID'];}?>">
	<input type="hidden" name="driverID" value="<?php if(isset($driverscommission['driverID'])){ echo $driverscommission['driverID'];}?>">
	<input type="hidden" name="action" value="<?php if(isset($action['action'])){ echo $action['action'];}?>">
	
	<div class="form-group">
		<div class="row controls">
			<label for="commission" class="col-sm-2 control-label">Commission: <span class="req">*</span></label>
			<div class="col-sm-4">
				<input type="text" name="commission" class="form-control" id="commission" required="true" value="<?php echo (set_value('commission'))?set_value('commission'):$driverscommission['commission']; ?>">
				<?php echo form_error('commission'); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row controls">
			<label for="startDate" class="col-sm-2 control-label">Start Date: <span class="req">*</span></label>
			<div class="col-sm-4">
				<input type="text" name="startDate" class="form-control date-picker" id="startDate" required="true" value="<?php if(isset($driverscommission['formattedStartDate'])){echo (set_value('formattedStartDate'))?set_value('formattedStartDate'):$driverscommission['formattedStartDate'];} ?>">
				<?php echo form_error('startDate'); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row controls">
			<label for="endDate" class="col-sm-2 control-label">End Date: <span class="req">*</span></label>
			<div class="col-sm-4">
				<input type="text" name="endDate" class="form-control date-picker" id="endDate" required="true" value="<?php if(isset($driverscommission['formattedEndDate'])){echo (set_value('formattedEndDate'))?set_value('formattedEndDate'):$driverscommission['formattedEndDate'];} ?>">
				<?php echo form_error('endDate'); ?>
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
	$('.date-picker').datepicker();
})
</script>
EOD;
$footerJs = Array("type"=>"inline", "script"=>$footerJs);
add_header_footer_cssJS('footer_js', $footerJs);
?> 