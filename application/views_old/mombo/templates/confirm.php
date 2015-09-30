<div class="container-fluid">
<div class="row-fluid">
	<div style="position:static;margin-top:12%;margin-left:30%;" class="modal small" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
	    <div class="modal-header">
	        <h3 id="myModalLabel">Confirm action</h3>
	    </div>
	    <div class="modal-body">
	        <p class="error-text"><i class="modal-icon"></i><?php echo $message;?></p>
	    </div>
	    <div class="modal-footer">
	        <a href="<?php echo $no_url;?>" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</a>
	        <a href="<?php echo $yes_url;?>" class="btn btn-danger" data-dismiss="modal">Yes</a>
	    </div>
	</div>