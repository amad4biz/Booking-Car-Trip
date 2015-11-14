<div class="row print">
    <div class="col-xs-12">
        <h3 class="header smaller lighter blue">Staff</h3>
        <div class="row">
        	<div class="col-sm-12 text-right" style="margin:0 0 10px 0;">
        		<a href="<?php echo site_url('staff/edit/0') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> New Staff</a>
        	</div>
        </div>
        
        <div>
            <div class="dataTables_wrapper form-inline" role="grid">
				<table id="staffList" class="print table table-striped table-bordered table-hover dataTable" aria-describedby="sample-table-2_info">
					<thead>
						<tr role="row">
							<th>Staff Name</th>
							<th>Username</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            
                            <th class="sorting_disabled"></th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($staff as $staff_detail): ?>
							<tr>
								<td><?php echo $staff_detail['firstName'] .' '.$staff_detail['lastName'];?></th>
								<td><?php echo $staff_detail['userName'];?></th>
								<td><?php echo $staff_detail['email'];?></th>
								<td><?php echo $staff_detail['phone'];?></th>
								<td>
		                            <?php 
		                            	if($staff_detail['isActive'] == 1){
		                            		echo '<span class="label label-success arrowed-in arrowed-in-right">Active</span>';
		                            	}else{
		                            		echo '<span class="label label-danger arrowed arrowed-right">In-Active</span>';
		                            	}
		                            ?>
	                            </th>
	                            <td>
	                            	<div class="hidden-sm hidden-xs action-buttons">
										<a class="green" href="/app/admin/index.php/staff/edit/<?php echo $staff_detail['staffID'];?>">
											<i class="ace-icon fa fa-pencil bigger-130"></i>
										</a>
	
										<a class="red" href="/app/admin/index.php/staff/delete_staff/<?php echo $staff_detail['staffID'];?>">
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
  $('table#staffList').dataTable( {
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