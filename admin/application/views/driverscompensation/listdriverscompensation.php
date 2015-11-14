<?php 
//var_dump(driverscompensation);
?>
<div class="row print">
    <div class="col-xs-12">
        <h3 class="header smaller lighter blue"><?php echo $Driver['lastName'] . ' ' . $Driver['firstName'] ?> Commission</h3>
        
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
													<!--<label>&nbsp;Search By Keyword</label>
													<input name="commissionID" placeholder="Search by keyword" value="<?php echo $_REQUEST['startDate'];?>"/>
													--><label>&nbsp;Date Range</label>
													<input name="startDate" placeholder="Date" value="<?php echo $_REQUEST['startDate'];?>"/>
													<label>&nbsp; - &nbsp;</label>
													<input name="endDate" placeholder="Date" value="<?php echo $_REQUEST['endDate'];?>"/>
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
        <div>
            <div id="drivers_wrapper" class="dataTables_wrapper form-inline" role="grid">
            <h3 class="header smaller lighter blue">Compensation plan for <?php echo $Driver['lastName'] . ' ' . $Driver['firstName'] ?> </h3>
				<table id="DriversListings" class="print table table-striped table-bordered table-hover dataTable" aria-describedby="sample-table-2_info">
					<thead>
						<tr role="row">
                            <th class="sorting_disabled">Commission (%)</th>
                            <th class="sorting_disabled">Booking Date</th>
                            <th class="sorting_disabled">Status</th>
                        </tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php if(count($driverscompensation) > 0) { ?>
						<?php foreach ($driverscompensation as $driver_detail): ?>
						<tr>
                            <td><?php echo $driver_detail['compensation'];?></th>
                            <td><?php echo $driver_detail['dateCreated'];?></th>
                            <td>
	                            <?php 
	                            	if($driver_detail['isCommissionPaid'] == 1){
	                            		echo '<span class="label label-success arrowed-in arrowed-in-right">Active</span>';
	                            	}else{
	                            		echo '<span class="label label-danger arrowed arrowed-right">In-Active</span>';
	                            	}
	                            ?>
                            </th>
                        </tr>
                        <?php endforeach ?>
                        <tr>
                    		<td><b><?php echo $driverscompensationTotal[0]['compensation'];?></b></th>
                    		<td align="center" colspan="1"><b>Total Compensation Cost of <i>"<?php echo $driver_detail['lastName'] .' '. $driver_detail['firstName'];?>"</i><b/> </th>
                    		<td></th>
                        </tr>
                        <?php }else{ ?>
                        <tr>
                            <td align="center" colspan="3" >No compensation plan has been made for this driver.</th>
                        </tr>	
                        <?php }?>
                    </tbody>
				</table>
			</div>
        </div>
    </div>
</div>