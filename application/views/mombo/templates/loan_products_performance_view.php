 <div class="header">
       <h1 class="page-title">Loan Products Performance</h1>
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

     <h4><!--Loan Product Performance--></h4>

     <div class="well">

         <ul class="nav nav-tabs">

               <li class="active"><a data-toggle="tab" href="#reports">Loan Products Performance</a></li>
                <!--<li ><a data-toggle="tab" href="#ggg">ggg</a></li>-->
                <li>
                     <form class="form-horizontal" id="payments-filter" method="POST" action="<?php echo base_url().'reports/';?>">

                        <script type="text/javascript">

                            $(function(){

                                 $('#date-start').datepicker({format:'yyyy-mm-dd'});

                                 $('#date-end').datepicker({format:'yyyy-mm-dd'});

                            });

                        </script>
                        
                        <div class="control-group">

                            <div class="controls">
									<?php 
										$url = base_url().'loan_products_performance/index/';
									?>
                                   Month: 
								   <select name="month" id="month">
								   		<option value="0">---select month---</option>
										<option value="1">January</option>
										<option value="2">February</option>
										<option value="3">March</option>
										<option value="4">April</option>
										<option value="5">May</option>
										<option value="6">June</option>
										<option value="7">July</option>
										<option value="8">August</option>
										<option value="9">September</option>
										<option value="10">October</option>
										<option value="11">November</option>
										<option value="12">December</option>
								   </select>
									Year: 
									<?php  
										$current_year = date('Y');
									?>
								   <select name="year" id="year">
								   		<option value="0">---select year---</option>
										<?php 
										for($i = 0; $i < 10; $i++){
											$year_b = strtotime ( '-'.$i.' year' , strtotime ( $current_year  ) ) ;
											$year = date ( 'Y' , $year_b );
											echo '<option value="'.$year.'">'.$year.'</option>';
										}
										
										?>
								   </select>
                                    <input type="button" class="btn btn-small btn-info" value="Go" onclick="go('<?php echo $url; ?>');"/>
                                  
                            </div>

                        </div>

                    </form>
                </li>

         </ul>

         <div class="tab-content">

              <div id="reports" class="tab-pane active">
			  	<ul class="nav nav-tabs">
			      <li class="active">
				  		<?php
							$url = base_url().'loan_products_performance/index/'.$month.'/'.$mwaka.'/1';
						?>
			           <a href="" data-toggle="tab" onclick="toPDF('<?php echo $url ?>')"><font color="#0000ff">Export to PDF</font></a>
			      </li>
				 </ul>
				<strong> Loan Product Performance</strong><br />
					<?php echo $month_year; ?>
					
                   <?php if( (count($loan_products) > 0) ){
						?>
						  <table class="table">
		                    <thead>
		                          <tr>
		                               <th></th>
		                               <th>Opening Balance</th>
									   <th style="color: blue">Fresh Disbursement</th>
									   <th>Transaction Fees</th>
									   <th colspan="2">Interest</th>
									   <th colspan="2">Accrued Interest</th>
									   <th colspan="2">Late Payment Fees</th>
									   <th colspan="2">Boucing Cheque Fees</th>
									   <th colspan="2">Debt Collection Fees</th>
									   <th style="color: purple">Principal Collected</th>
									   <th style="color: blue">New Future Interest</th>
									   <th>Total Future Interest</th>
									   <th>Closing Balance</th>
		                          </tr>
								  <tr>
		                               <th></th>
		                               <th></th>
									   <th></th>
									   <th></th>
									   <th style="color: blue">A</th>
									   <th style="color: purple">C</th>
									   <th style="color: blue">A</th>
									   <th style="color: purple">C</th>
									   <th style="color: blue">A</th>
									   <th style="color: purple">C</th>
									   <th style="color: blue">A</th>
									   <th style="color: purple">C</th>
									   <th style="color: blue">A</th>
									   <th style="color: purple">C</th>
									   <th></th>
									   <th></th>
									   <th></th>
									   <th></th>
		                          </tr>
		                    </thead>
		                    <tbody class="payments-body">
                        <?php 
						$i=0;
						$total_loan_opening_bal = 0; $total_loan_fresh_disbursement = 0; $total_transaction_fees = 0; $total_interests_a = 0;
						$total_interests_c = 0; $total_accrued_interests_a = 0; $total_accrued_interests_c = 0; $total_late_payment_fees_a = 0;
						$total_late_payment_fees_c = 0; $total_bouncing_cheque_penalties_a = 0; $total_bouncing_cheque_penalties_c = 0; 
						$total_debt_collection_fees_a = 0; $total_debt_collection_fees_c = 0;  $total_principal_collected = 0; 
						$total_new_future_interests_a = 0; $total_future_interests_a = 0; $total_loan_closing_bal = 0;
						foreach($loan_products as $loan_product){
							$total_loan_opening_bal += $loan_opening_bal[$i];
							$total_loan_fresh_disbursement += $loan_fresh_disbursement[$i];
							$total_transaction_fees += $transaction_fees[$i];
							$total_interests_a += $interests_a[$i];
							$total_interests_c += $interests_c[$i];
							$total_accrued_interests_a += $accrued_interests_a[$i];
							$total_accrued_interests_c += $accrued_interests_c[$i];
							$total_late_payment_fees_a += $late_payment_fees_a[$i];
							$total_late_payment_fees_c += $late_payment_fees_c[$i];
							$total_bouncing_cheque_penalties_a += $bouncing_cheque_penalties_a[$i];
							$total_bouncing_cheque_penalties_c += $bouncing_cheque_penalties_c[$i];
							$total_debt_collection_fees_a += $debt_collection_fees_a[$i];
							$total_debt_collection_fees_c += $debt_collection_fees_c[$i];
							$total_new_future_interests_a += $new_future_interests_a[$i];
							$total_future_interests_a += $future_interests_a[$i];
							$total_principal_collected += $principal_collected[$i];
							$total_loan_closing_bal += $loan_closing_bal[$i];
							
							echo '<tr>
		                               <th>'.$loan_product["loan_product_name"].'</th>
		                               <td>'.$loan_opening_bal[$i].'</td>
									   <td>'.$loan_fresh_disbursement[$i].'</td>
									   <td>'.$transaction_fees[$i].'</td>
									   <td>'.$interests_a[$i].'</td>
									   <td>'.$interests_c[$i].'</td>
									   <td>'.$accrued_interests_a[$i].'</td>
									   <td>'.$accrued_interests_c[$i].'</td>
									   <td>'.$late_payment_fees_a[$i].'</td>
									   <td>'.$late_payment_fees_c[$i].'</td>
									   <td>'.$bouncing_cheque_penalties_a[$i].'</td>
									   <td>'.$bouncing_cheque_penalties_c[$i].'</td>
									   <td>'.$debt_collection_fees_a[$i].'</td>
									   <td>'.$debt_collection_fees_c[$i].'</td>
									   <td>'.$principal_collected[$i].'</td>
									   <td>'.$new_future_interests_a[$i].'</td>
									   <td>'.$future_interests_a[$i].'</td>
									   <td>'.$loan_closing_bal[$i].'</td>
		                          </tr>';
							$i++;
						}
						echo '<tr>
		                               <th>TOTAL</th>
									   <th>'.$total_loan_opening_bal.'</th>
									   <th style="color: blue">'.$total_loan_fresh_disbursement.'</th>
									   <th>'.$total_transaction_fees.'</th>
									   <th style="color: blue">'.$total_interests_a.'</th>
									   <th style="color: purple">'.$total_interests_c.'</th>
									   <th style="color: blue">'.$total_accrued_interests_a.'</th>
									   <th style="color: purple">'.$total_accrued_interests_c.'</th>
									   <th style="color: blue">'.$total_late_payment_fees_a.'</th>
									   <th style="color: purple">'.$total_late_payment_fees_c.'</th>
									   <th style="color: blue">'.$total_bouncing_cheque_penalties_a.'</th>
									   <th style="color: purple">'.$total_bouncing_cheque_penalties_c.'</th>
									   <th style="color: blue">'.$total_debt_collection_fees_a.'</th>
									   <th style="color: purple">'.$total_debt_collection_fees_c.'</th>
									   <th style="color: purple">'.$total_principal_collected.'</th>
									   <th style="color: blue">'.$total_new_future_interests_a.'</th>
									   <th>'.$total_future_interests_a.'</th>
									   <th>'.$total_loan_closing_bal.'</th>
							 </tr>';
						
					?>
					
					 </tbody>
                    </table>
					<?php }else{ ?>

                              <div class="alert alert-info">
                                  <button type="button" class="close" data-dismiss="alert">×</button>
                                  No result for <?php echo $month_year ?>.
                              </div>

                  <?php } ?>
              </div>

              <div  id="ggg"  class="tab-pane fade">
				
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

<script type="text/javascript">
function toPDF(url)
{
	window.location.href=url;
}
</script>