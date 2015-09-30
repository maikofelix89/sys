<script type="text/javascript">

		$(function(){

		     $('#date').datepicker({format:'yyyy-mm-dd'});

		});

	</script>
 <div class="header">
       <h1 class="page-title">Balance Sheet</h1>
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

     <h4>Balance Sheet</h4>

     <div class="well">

         <ul class="nav nav-tabs">

               <!--<li class="active"><a data-toggle="tab" href="#all">All</a></li>
                <li ><a data-toggle="tab" href="#week1">Week 1</a></li>
				<li ><a data-toggle="tab" href="#week2">Week 2</a></li>
				<li ><a data-toggle="tab" href="#week3">Week 3</a></li>
				<li ><a data-toggle="tab" href="#week4">Week 4</a></li>
                <li>-->
                     <form class="form-horizontal" id="payments-filter" method="POST" action="<?php echo base_url().'loans/statements/';?>">

                        <script type="text/javascript">

                            $(function(){

                                 $('#date-start').datepicker({format:'yyyy-mm-dd'});

                                 $('#date-end').datepicker({format:'yyyy-mm-dd'});

                            });

                        </script>
                        
                        <div class="control-group">

                                <div class="controls">
									<?php 
										$url = base_url().'balance_sheet/index/';
									?>
                                   Date: 
								  <input type="text" id="date" name="date" value="" />
                                    <input type="button" class="btn btn-small btn-info" value="Go" onclick="go('<?php echo $url; ?>');"/>
                                  
                            </div>

                        </div>

                    </form>
                </li>

         </ul>

         <div class="tab-content">

              <div id="all" class="tab-pane active">
			  	<ul class="nav nav-tabs">
				      <li class="active">
					  		<?php
								$url = base_url().'balance_sheet/index/'.$month.'/'.$mwaka.'/1';
							?>
				           <!--<a href="" data-toggle="tab" onclick="toPDF('<?php echo $url ?>')"><font color="#0000ff">Export to PDF</font></a>-->
				      </li>
				 </ul>
				
					<?php //echo date("M d, Y", strtotime($date)); ?>
					
                <?php if( count($savings) > 0 ){ 
					$CI = & get_instance();
					$CI->load->model('balance_sheet_model','bs_model');
			        
				   	?>
						  <table class="table">
		                    <thead>
									<tr>
		                               <th colspan="6" style="text-align: center">Balance Sheet as of <?php echo date("M d, Y", strtotime($date)); ?></th>
								  </tr>
								  <tr>
		                               <th colspan="2">ASSETS</th>
								  </tr>
		                    </thead>
		                    <tbody class="payments-body">
							 
							  <tr>
	                               <th colspan="2" style="text-indent: 2em;">Current Assets</th>
							  </tr>
							  <tr>
	                               <th colspan="2" style="text-indent: 4em;">Checking/Savings</th>
							  </tr>
							  
							  <?php 
							  $total_savings = 0;
							  	for($i = 0; $i < count($savings); $i++){
									$saving = explode("*",$savings[$i]);
									$total_savings += $saving[1];
									echo "<tr>";
										echo "<td style='text-indent: 6em;'>".$saving[0]."</td>";
										echo "<td style=\"text-align: right;\">".number_format($saving[1],2,'.',',')."</td>";
									echo "</tr>";	
								}
								echo "<tr>";
		                        	echo "<th style='text-indent: 4em'>Total Checking/Savings</th>";
									echo "<th style=\"text-align: right\">".number_format($total_savings,2,'.',',')."</th>";
								echo "</tr>";
								echo "<tr>";
		                        	echo "<th colspan = '2' style='text-indent: 4em'>Accounts Receivable</th>";
								echo "</tr>";
								echo "<tr>";
		                        	echo "<td style='text-indent: 6em'>Loan</td>";
									echo "<td style=\"text-align: right\">".number_format($total_amount_due,2,'.',',')."</td>";
								echo "</tr>";
								echo "<tr>";
		                        	echo "<th style='text-indent: 4em'>Total Accounts Receivable</th>";
									echo "<th style=\"text-align: right\">".number_format($total_amount_due,2,'.',',')."</th>";
								echo "</tr>";
								echo "<tr>";
		                        	echo "<th style='text-indent: 2em'>Total Current Assets</th>";
									echo "<th style=\"text-align: right\">".number_format($total_amount_due+$total_savings,2,'.',',')."</th>";
								echo "</tr>";
								echo "<tr>";
		                        	echo "<th>TOTAL ASSETS</th>";
									echo "<th style=\"text-align: right;color: purple\">".number_format($total_amount_due+$total_savings,2,'.',',')."</th>";
								echo "</tr>";
								echo "<tr>";
		                        	echo "<th></th>";
									echo "<th style=\"text-align: right\"></th>";
								echo "</tr>";
								echo "<tr>";
		                        	echo "<th colspan='2'>LIABILITIES & EQUITY</th>";
								echo "</tr>";
								echo "<tr>";
		                        	echo "<th colspan='2' style='text-indent: 2em'>Liabilities</th>";
								echo "</tr>";
								echo "<tr>";
		                        	echo "<th colspan='2' style='text-indent: 4em'>Long Term Liabilities</th>";
								echo "</tr>";
								$creditors_amount = 0;
								for($i = 0; $i < count($creditors); $i++){
									$creditor = explode("*",$creditors[$i]);
									$creditors_amount += $creditor[1];
									echo "<tr>";
										echo "<td style='text-indent: 6em;'>Creditors</td>";
										echo "<td style=\"text-align: right;\">".number_format($creditor[1],2,'.',',')."</td>";
									echo "</tr>";	
								}
								echo "<tr>";
		                        	echo "<th style='text-indent: 4em'>Total Long Term Liabilities</th>";
									echo "<th style=\"text-align: right;\">".number_format($creditors_amount,2,'.',',')."</th>";
								echo "</tr>";
								echo "<tr>";
		                        	echo "<th style='text-indent: 2em'>Total Liabilities</th>";
									echo "<th style=\"text-align: right;\">".number_format($creditors_amount,2,'.',',')."</th>";
								echo "</tr>";
								echo "<tr>";
		                        	echo "<th style='text-indent: 2em'></th>";
									echo "<td style=\"text-align: right;\"></td>";
								echo "</tr>";
								echo "<tr>";
		                        	echo "<th colspan='2' style='text-indent: 2em'>Equity</th>";
								echo "</tr>";
								echo "<tr>";
									echo "<td style='text-indent: 4em;'>Opening Balance Equity</td>";
									echo "<td style=\"text-align: right;\">".number_format($opening_bal_equity,2,'.',',')."</td>";
								echo "</tr>";
								echo "<tr>";
									echo "<td style='text-indent: 4em;'>Net Income</td>";
									echo "<td style=\"text-align: right;\">".number_format($net_income,2,'.',',')."</td>";
								echo "</tr>";
								echo "<tr>";
									echo "<th style='text-indent: 2em;'>Total Equity</hd>";
									echo "<th style=\"text-align: right;\">".number_format($opening_bal_equity+$net_income,2,'.',',')."</th>";
								echo "</tr>";
								echo "<tr>";
									echo "<th>TOTAL LIABILITIES & EQUITY</th>";
									echo "<th style=\"text-align: right;color:purple\">".number_format($opening_bal_equity+$net_income+$creditors_amount,2,'.',',')."</th>";
								echo "</tr>";
							  ?>						  
                       
					 </tbody> 
                    </table>
					<?php }else{ ?>

                              <div class="alert alert-info">
                                  <button type="button" class="close" data-dismiss="alert">×</button>
                                  No result for <?php echo date("M d, Y", strtotime($date)); ?>.
                              </div>

                  <?php } ?>
              </div>
              
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript">
	function go(url_part){
		var date = document.getElementById('date').value;
		
		var url = url_part+date+"/0";
		
		if(date == 0){
			alert('Select date');
		}
		else{
			window.location.href=url;
		}
	}
</script>

<script type="text/javascript">
function toPDF(url)
{
	window.location.href=url;
}
</script>