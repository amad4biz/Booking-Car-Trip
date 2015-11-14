<h3 class="header smaller lighter blue"><?php echo $title ?></h3>
<form method="post" action="<?php echo $action; ?>" id="formAutoEmail">
	<input type="hidden" name="autoEmailID" value="<?php if(isset($qryAutoEmail['autoEmailID'])){ echo $qryAutoEmail['autoEmailID'];}?>">
	<input type="hidden" name="action" value="<?php if(isset($action['action'])){ echo $action['action'];}?>">
	<div class="form-group">
		<div class="row controls">
			<label for="status" class="col-sm-2 control-label">Status: <span class="req">*</span></label>
			<div class="col-sm-4">
				<label class="radio-inline">
					<input type="radio" name="isActive" value="1" required="true" <?php if(isset($qryAutoEmail['isActive']) && $qryAutoEmail['isActive'] == 1 || $qryAutoEmail['isActive'] == '' ) {echo 'checked';} ?>> Active
				</label>
				<label class="radio-inline">
					<input type="radio" name="isActive" value="0" required="true" <?php if(isset($qryAutoEmail['isActive']) && $qryAutoEmail['isActive'] == 0 ) {echo 'checked';} ?>> In Active
				</label>
				<?php echo form_error('status'); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row controls">
			<label for="subject" class="col-sm-2 control-label">Event: <span class="req">*</span></label>
			<div class="col-sm-6">
				<select name="autoEmailEventID" class="form-control" required="true">
					<option value="">Select Event</option>
					<?php 
						foreach($autoEmailEvents as $autoEmailEvent){
							echo '<option value="' . $autoEmailEvent['autoEmailEventID'] . '"';
							if(count($qryAutoEmail) > 0 && $qryAutoEmail['autoEmailEventID'] == $autoEmailEvent['autoEmailEventID']){
								echo ' selected="selected" ';
							}
							echo '>' . $autoEmailEvent['eventName'];
							echo '</option>';	
						}
					?>
				</select>
				<?php echo form_error('autoEmailEventID'); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row controls">
			<label for="subject" class="col-sm-2 control-label">Subject: <span class="req">*</span></label>
			<div class="col-sm-8">
				<input type="text" name="subject" class="form-control" id="subject" required="true" value="<?php echo (set_value('subject'))?set_value('subject'):$qryAutoEmail['subject']; ?>">
				<?php echo form_error('subject'); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row controls">
			<label for="ccEmail" class="col-sm-2 control-label">Cc:</label>
			<div class="col-sm-8">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-envelope"></i>
					</span>
					<input type="ccEmail" name="ccEmail" class="form-control" id="ccEmail" value="<?php echo (set_value('ccEmail'))?set_value('ccEmail'):$qryAutoEmail['ccEmail']; ?>">	
				</div>
				
				<?php echo form_error('ccEmail'); ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row controls">
			<label for="bccEmail" class="col-sm-2 control-label">Bcc:</label>
			<div class="col-sm-8">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="ace-icon fa fa-envelope"></i>
					</span>
					<input type="bccEmail" name="bccEmail" class="form-control" id="bccEmail" value="<?php echo (set_value('bccEmail'))?set_value('bccEmail'):$qryAutoEmail['bccEmail']; ?>">	
				</div>
				<?php echo form_error('bccEmail'); ?>
			</div>
		</div>
	</div>
	<div class="form-group" style="margin-left:16.666%">
		<ul id="emailTemplateTab" class="nav nav-tabs">
			<li id="tabHeading1" class="active">
				<a href="#tab-1">Html Content</a>
			</li>
			<li id="tabHeading2">
				<a href="#tab-2">Text Content</a>
			</li>
		</ul>
		<div id="emailTemplateTabBodyContainer" class="tab-content">
			<div class="tab-pane active" id="tab-1">
				<div class="title">Mail Merge Fields</div>
				<div class="muted">
					To add booking,driver or vehicle information to your email, click one of the options item.
				</div>
				<div id="htmlMergeFieldContainer" style="margin-bottom:20px;" class="row">
					<div class="col-sm-4">
						<select onchange="insertMergeField(this[this.selectedIndex].value)" name="htmlMergeField" id="htmlMergeField" class="form-control">
							<option value="">&nbsp;&nbsp;Select Placeholder&nbsp;&nbsp;</option>
							<?php 
								$count = 1;
								$placeholderType = '';
								foreach($qryPlaceholders as $qryPlaceholder){
									if($placeholderType != $qryPlaceholder['placeholderType']){
										if($count > 1){
											echo '</optgroup>';
										}
										echo '<optgroup label="&nbsp;&nbsp;&rarr;' . $qryPlaceholder['placeholderType'] . '">';
										$placeholderType = $qryPlaceholder['placeholderType'];
									}									
									echo '<option value="' . $qryPlaceholder['code'] . '"';
									echo '>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $qryPlaceholder['label'];
									echo '</option>';	
									$count += 1;
								}
							?>
						</select>
					</div>
				</div>
				<textarea id="htmlBody" name="htmlBody" class="input-xxlarge"><?php echo (set_value('htmlBody'))?set_value('htmlBody'):$qryAutoEmail['htmlBody']; ?></textarea>
			</div>
			<div class="tab-pane" id="tab-2">
				<div class="title">Mail Merge Fields</div>
				<div class="muted">
					To add booking,driver or vehicle information to your email, click one of the options item.
				</div>
				<div id="textMergeFieldContainer" style="margin-bottom:20px;" class="row">
					<div class="col-sm-4">
						<select onchange="insertAtCaret(this.form.textMergeFields[this.selectedIndex].value)" name="textMergeFields" id="textMergeFields" class="form-control">
							<option value="">&nbsp;&nbsp;Select Placeholder&nbsp;&nbsp;</option>
							<?php 
								$count = 1;
								$placeholderType = '';
								foreach($qryPlaceholders as $qryPlaceholder){
									if($placeholderType != $qryPlaceholder['placeholderType']){
										if($count > 1){
											echo '</optgroup>';
										}
										echo '<optgroup label="&nbsp;&nbsp;&rarr;' . $qryPlaceholder['placeholderType'] . '">';
										$placeholderType = $qryPlaceholder['placeholderType'];
									}									
									echo '<option value="' . $qryPlaceholder['code'] . '"';
									echo '>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $qryPlaceholder['label'];
									echo '</option>';	
									$count += 1;
								}
							?>
						</select>
					</div>
				</div>
				<textarea id="textBody" name="textBody" style="width:98%;" class="form-control" rows="10"><?php echo (set_value('textBody'))?set_value('textBody'):$qryAutoEmail['textBody']; ?></textarea>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-6 text-right">
			<button type="submit" class="btn btn-primary">Submit</button>
			<a href="/app/admin/index.php/autoemails" class="btn btn-default">Cancel</a>
		</div>
	</div>
</form>


<?php
$footerJs = <<<EOD
<script>
$(function(){
		CKEDITOR.replace( 'htmlBody', {toolbar: 'Basic'});
	    $('#emailTemplateTab a').click(function (e) {
		    e.preventDefault();
		    $(this).tab('show');
	    });
	    $('#autoEmailEventID').change(function(){
			var autoEmailEventID = $('#autoEmailEventID option:selected').val();
			if(autoEmailEventID > 0){
			}	    	
	    });
});
function insertMergeField(fieldCode) {
	CKEDITOR.instances.htmlBody.insertHtml( '<span class="mailmerge">' + fieldCode + '&nbsp;</span>' );
}
function insertAtCaret(code) {
	$('#textBody').append(code + ' ');
} 
</script>


EOD;
$footerJs = Array("type"=>"inline", "script"=>$footerJs);
add_header_footer_cssJS('footer_js', $footerJs);