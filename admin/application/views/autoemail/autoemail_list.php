<div class="row print">
    <div class="col-xs-12">
        <h3 class="header smaller lighter blue">Auto Emails</h3>
        <div class="row">
        	<div class="col-sm-12 text-right" style="margin:0 0 10px 0;">
        		<a href="/app/admin/index.php/autoemails/edit/0" class="btn btn-primary"><i class="fa fa-plus"></i> New Auto Emai</a>
        	</div>
        </div>        
        <div id="drivers_wrapper" class="dataTables_wrapper form-inline" role="grid">
			<table id="DriversListings" class="print table table-striped table-bordered table-hover dataTable" aria-describedby="sample-table-2_info">
				<thead>
					<tr role="row">
						<th class="sorting_disabled">Event</th>
						<th class="sorting_disabled">Subject</th>
						<th class="sorting_disabled">Isactive</th>
						<th></th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php 
							if(count($qryAutoEmails) > 0){
						?>
						<?php foreach ($qryAutoEmails as $qryAutoEmails_detail): ?>
						<tr>
							<td><?php echo $qryAutoEmails_detail['eventName'];?></th>
							<td><?php echo $qryAutoEmails_detail['subject'];?></th>
							<td>
								<span class="label label-<?php if($qryAutoEmails_detail['isActive'] == '0'){ echo 'danger';}else{ echo 'success';} ?>">
								<?php if($qryAutoEmails_detail['isActive'] == '0'){ echo 'No';}else{ echo 'Yes';} ?>
								</span>
							</th>
                            <td>
                            	<div class="hidden-sm hidden-xs action-buttons">
									<a class="green" title="Edit" href="/app/admin/index.php/autoemails/edit/<?php echo $qryAutoEmails_detail['autoEmailID'];?>">
										<i class="ace-icon fa fa-pencil bigger-130"></i>
									</a>
									<a class="red" title="Delete" href="javascript:void(0);" onclick="if(confirm('Are you sure you want to delete?')){self.location='/app/admin/index.php/autoemails/delete/<?php echo $qryAutoEmails_detail['autoEmailID'];?>';}">
										<i class="ace-icon fa fa-trash-o bigger-130"></i>
									</a>
								</div>
                            </th>
                    	</tr>
                    	<?php endforeach ?>
                    	<?php 
							}
							else{
                    	?>
                    		<tr>
                    			<td colspan="4">Create your first auto email now. <a href="/app/admin/index.php/autoemails/edit/0" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></a></td>
                    		</tr>
                    	<?php 
							}
                    	?>
                    </tbody>
			</table>
		</div>
    </div>
</div>