<div class="row print">
    <div class="col-xs-12">
        <h3 class="header smaller lighter blue">Vehicle</h3>
        <div class="row">
        	<div class="col-sm-12 text-right" style="margin:0 0 10px 0;">
        		<a href="<?php echo site_url('vehicle/edit/0') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> New Vehicle</a>
        	</div>
        </div>
        
        <div>
            <div id="drivers_wrapper" class="dataTables_wrapper form-inline" role="grid">
				<table id="vehicleList" class="print table table-striped table-bordered table-hover dataTable" aria-describedby="sample-table-2_info">
					<thead>
						<tr role="row">
							<th>Driver Name</th>
							<th>Year</th>
							<th>Make</th>
							<th>Model</th>
							<th>Plate #</th>
							<th># of PAX</th>
                            <th class="sorting_disabled">Action</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($vehicle as $vehicle_detail): ?>
							<tr>
								<td><?php echo $vehicle_detail['firstName'] .' '.$vehicle_detail['lastName'];?></th>
								<td><?php echo $vehicle_detail['year'];?></th>
								<td><?php echo $vehicle_detail['make'];?></th>
								<td><?php echo $vehicle_detail['model'];?></th>
								<td><?php echo $vehicle_detail['vehiclePlate'];?></th>
								<td><?php echo $vehicle_detail['maxPassenger'];?></th>
	                            
	                            <td>
	                            	<div class="hidden-sm hidden-xs action-buttons">
										<a class="green" title="Edit" href="/app/admin/index.php/vehicle/edit/<?php echo $vehicle_detail['vehicleID'];?>">
											<i class="ace-icon fa fa-pencil bigger-130"></i>
										</a>
	
										<a class="red" title="Delete" href="/app/admin/index.php/vehicle/delete_vehicle/<?php echo $vehicle_detail['vehicleID'];?>">
											<i class="ace-icon fa fa-trash-o bigger-130"></i>
										</a>
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
$footerJs = <<<EOD
<script>
  $('table#vehicleList').dataTable( {
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
	            "aaSorting": [[0, 'desc']],
	             "aLengthMenu": [
	                [25, 50, 100, 200, 500],
	                [25, 50, 100, 200, 500] // change per page values here
	            ],
	            // set the initial value
	            "iDisplayLength": 50,
	        });
</script>


EOD;
$footerJs = Array("type"=>"inline", "script"=>$footerJs);
add_header_footer_cssJS('footer_js', $footerJs);
?>