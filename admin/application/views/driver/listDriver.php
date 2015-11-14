<div class="row print">
    <div class="col-xs-12">
        <h3 class="header smaller lighter blue">Drivers</h3>
        <div class="row">
        	<div class="col-sm-12 text-right" style="margin:0 0 10px 0;">
        		<a href="<?php echo site_url('driver/edit/0') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> New Driver</a>
        	</div>
        </div>
        <div class="widget-box">
				<div class="widget-body">
					<div class="widget-main">
						<form class="form-search">
							<div class="row">
								<div class="col-sm-12">
									<div class="input-group">
										<div class="row">
											<form class="form-inline">
												<fieldset>
													<label>&nbsp;Search By Keyword</label>
													<input name="keyword" placeholder="Search by keyword" value="<?php echo $_REQUEST['keyword'];?>"/>
													<label>&nbsp;Driver Status</label>
													<select name="isActive" class="input-small">
														<option value="1" <?php if($_REQUEST['isActive']==1){echo 'selected';}?>>
															Active
														</option>
														<option value="0" <?php if($_REQUEST['isActive']==0){echo 'selected';}?>>
															In-Active
														</option>
														<option value="" <?php if($_REQUEST['isActive']==''){echo 'selected';}?>>
															All
														</option>
													</select>
													<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-search"></i> Search</button>
												</fieldset>
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
				<table id="DriversListings" class="print table table-striped table-bordered table-hover dataTable" aria-describedby="sample-table-2_info">
					<thead>
						<tr role="row">
                            <th >Name</th>
                            <th >Email</th>
                            <th>Phone</th>
                            <th >Status</th>
                            <th class="sorting_disabled"></th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($driver as $driver_detail): ?>
						<tr>
                            <td><?php echo $driver_detail['lastName'] .', '. $driver_detail['firstName'];?></th>
                            <td><?php echo $driver_detail['email'];?></th>
                            <td><?php echo $driver_detail['phone'];?></th>
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
                            	<div class="hidden-sm hidden-xs action-buttons">
									<!-- 
									<a class="blue" href="#">
										<i class="ace-icon fa fa-search-plus bigger-130"></i>
									</a>
									 -->
									<a class="green" title="Edit" href="<?php echo site_url('driver/edit/' . $driver_detail['driverID']) ?>">
										<i class="ace-icon fa fa-pencil bigger-130"></i>
									</a>

									<a class="red" title="Delete" onclick="return confirm('Are you sure you like to delete this record?');" href="/app/admin/index.php/driver/delete_driver/<?php echo $driver_detail['driverID'];?>">
										<i class="ace-icon fa fa-trash-o bigger-130"></i>
									</a>
									
									<a class="blue" title="Commission" href="<?php echo  '/app/admin/index.php/driverscommission/?driverId=' . $driver_detail['driverID']?>">
										<i class="ace-icon fa fa-usd bigger-130"></i>
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

<?php
$footerJs = <<<EOD
<script>
  $('table#DriversListings').dataTable( {
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