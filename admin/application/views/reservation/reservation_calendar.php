<div class="row print">
    <div class="col-xs-12">
        <h3 class="header smaller lighter blue">Reservation</h3>
        <div class="row">
        	<div class="col-sm-6" style="margin:0 0 10px 0;">
        		<a href="/app/admin/index.php/reservation" class="btn btn-warning"><i class="fa fa-list"></i> View List </a>
        	</div>
        	<div class="col-sm-6 text-right" style="margin:0 0 10px 0;">
        		<a href="/app/admin/index.php/reservation/edit/0" class="btn btn-primary"><i class="fa fa-plus"></i> New Reservation</a>
        	</div>
        </div>
        <div class="row">
        	<div class="col-sm-9">
        		<div class="space"></div>
				<div id="calendar"></div>
        	</div>
			<div class="col-sm-3">
				<div class="widget-box transparent">
					<div class="widget-header">
						<h4>Reservation Statuses</h4>
					</div>
					<div class="widget-body">
						<div class="widget-main no-padding">
							<div id="external-events">								
								<div class="external-event label-yellow" data-class="label-yellow" style="padding-left:10px;">
									<i class="fa fa-bell"></i>
									Pending
								</div>
								<div class="external-event label-success" data-class="label-success" style="padding-left:10px;">
									<i class="fa fa-smile-o"></i>
									Confirmed
								</div>
								<div class="external-event label-info" data-class="label-danger" style="padding-left:10px;">
									<i class="fa fa-file"></i>
									Draft
								</div>
								<div class="external-event label-danger" data-class="label-danger" style="padding-left:10px;">
									<i class="fa fa-remove"></i>
									Cancelled
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>

<?php
$footerJs = <<<EOD
<script>
$(function(){
	$('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		defaultView: 'month',
		editable: false,
		slotEventOverlap: false,
		eventLimit: true, // allow "more" link when too many events
		events: '/app/admin/index.php/reservation/bookings'								
	});	
})
</script>
EOD;
$footerJs = Array("type"=>"inline", "script"=>$footerJs);
add_header_footer_cssJS('footer_js', $footerJs);
?>