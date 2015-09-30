 <div class="header">
       <h1 class="page-title">Financial Statements</h1>
 </div>
        
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>
            <li class="active"></li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
    <div class="btn-group">
         <a href="<?php echo base_url();?>loans/loanproducts/"  class="btn btn-primary">
          <!-- All Payments-->
         </a>
    </div>
</div>
<?php if(isset($message) && $message){ ?>
    <div class="alert alert-<?php echo $message_type; ?>">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <?php echo $message;?>
    </div>
<?php } ?>
<div class="well">

     <h4>Financial Statements</h4>

     <div class="well">

         <div class="tab-content">

              <div id="statements">
					<table>
						<tr><th>#</th><th></th><th>Name</th></tr>
						<tr><td>1</td><td></td><td><a href="<?php echo base_url().'balance_sheet/'; ?>">Balance Sheet</a></td></tr>
						<tr><td>2</td><td></td><td><a href="<?php echo base_url().'cashflow_statement/'; ?>">Cashflow Statement</a></td></tr>
						<tr><td>3</td><td></td><td><a href="<?php echo base_url().'income_statements/'; ?>">Income Statements</a></td></tr>
					</table>
			</div>
       </div>
    </div>
</div>
<script type="text/javascript" language="javascript">
	function go(url_part){
		var month = document.getElementById('month').value;
		var year = document.getElementById('year').value;
		var url = url_part+month+'/'+year;
		
		if(month == 0 && year == 0){
			alert('Month and year cannot be empty');
		}
		else if(month == 0){
			alert('Month cannot be empty');
		}
		else if(year == 0){
			alert('Year cannot be empty');
		}
		else{
			window.location.href=url;
		}
	}
</script>