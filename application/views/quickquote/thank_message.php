<div class="row">
	<div class="col-sm-12 pageTitle pagein">Confirmation</div>
</div>
<h3>Thank you.<h3>

<?php
	date_default_timezone_set('America/Los_Angeles');
	$date12hoursFromNow = date("Y-m-d H:i:s", strtotime('+12 hours'));
	
	if ($pickDateTime < $date12hoursFromNow) {
		
?>	
	<p>Your reservation is pending. You will receive a confirmation call from our office or you may call us at 866.805.4234</p>
<?php } else { ?>
	<p>Your reservation is confirmed. If you have any questions, please call 866.805.4234</p>
<?php } ?>