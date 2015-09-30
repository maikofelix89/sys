 <div class="header">
       <h1 class="page-title">Income Statements</h1>
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

     <h4>Income Statements</h4>

     <div class="well">

         <ul class="nav nav-tabs">

               <li class="active"><a data-toggle="tab" href="#accrued">Accrued Profit & Loss</a></li>
                <li ><a data-toggle="tab" href="#basis">Basis Profit & Loss</a></li>
                <li>
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
										$url = base_url().'income_statements/index/';
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

              <div id="accrued" class="tab-pane active">
			  	<ul class="nav nav-tabs">
				      <li class="active">
					  		<?php
								$url = base_url().'income_statements/index/'.$month.'/'.$mwaka.'/1/A';
							?>
				           <a href="" data-toggle="tab" onclick="toPDF('<?php echo $url ?>')"><font color="#0000ff">Export to PDF</font></a>
				      </li>
				 </ul>
				<strong>Accrued Profit & Loss Statement </strong><br />
					
					<?php echo $month_year; ?>
					
                   <?php if( TRUE ){ 
				   //(count($accrued_transaction_fees) > 0) || (count($accrued_interests) > 0) || (count($accrued_charges) > 0)
						?>
						  <table class="table">
		                    <thead>
		                          <tr>
		                               <th>INCOME</th>

		                               <th>KES</th>
		                          </tr>
		                    </thead>
		                    <tbody class="payments-body">
                        <?php 
						$i = 1;
						$gross_income = 0;
						$transaction_fees = 0;
						$interests = 0;
						$late_payment_fees = 0;
						$interest_fees = 0;
						$cheque_penalties = 0;
						$debt_collection_fees = 0;
						
						foreach($accrued_transaction_fees as $accrued_transaction_fee){
							$gross_income += $accrued_transaction_fee["amount"];
							$transaction_fees += $accrued_transaction_fee["amount"];				
						}
						//echo $gross_income; exit;
						foreach($accrued_interests as $accrued_interest){
							$gross_income += $accrued_interest["total_interest_amount"];
							$interests += $accrued_interest["total_interest_amount"];				
						}
						$interests += $accrued_interests_b;
						$gross_income += $accrued_interests_b;
						/*foreach($accrued_interests_b as $accrued_interest_b){
							$gross_income += $accrued_interest_b["interest_amount"];
							$interests += $accrued_interest_b["interest_amount"];				
						}*/
						
						foreach($accrued_charges as $accrued_charge){
							if($accrued_charge["name"] == 'latepayment_fee'){
								$gross_income += $accrued_charge["amount"] - $accrued_charge["waiver"];
								$late_payment_fees += $accrued_charge["amount"] - $accrued_charge["waiver"];
							}
							elseif($accrued_charge["name"] == 'interest_fee'){
								$gross_income += $accrued_charge["amount"] - $accrued_charge["waiver"];
								$interest_fees += $accrued_charge["amount"] - $accrued_charge["waiver"];
							}	
							elseif($accrued_charge["name"] == 'bouncing cheque penalty'){
								$gross_income += $accrued_charge["amount"] - $accrued_charge["waiver"];
								$cheque_penalties += $accrued_charge["amount"] - $accrued_charge["waiver"];
							}	
							elseif($accrued_charge["name"] == 'Debt recovery penalty'){
								$gross_income += $accrued_charge["amount"] - $accrued_charge["waiver"];
								$debt_collection_fees += $accrued_charge["amount"] - $accrued_charge["waiver"];
							}
						}
						
						$CI = & get_instance();
						$CI->load->model('statements_model','statements'); 
						for($i = 0; $i < count($other_income_array); $i++){ //var_dump($other_income_array); exit;
							$incomes = $other_income_array[$i];
							$account_id = 0;
							$account_income = 0;
							foreach($incomes as $income){
								$account_id = $income["account_id"];
								$account_income += $income['amount'];
								$gross_income += $income['amount'];
							}
							$account = $CI->statements->get_account($account_id);
							
							if($account_income > 0){
								if($account['has_child'] == 0){
									echo "<tr>
												<td>".$account['account_name']."</td>
												<td>".$account_income."</td>
											</tr>";	
								}
								/*else{
									echo "<tr>";
										echo "<td>".$account['account_name']."</td>";
									echo "</tr>";
									
									$sub_accounts = $CI->statements->get_sub_accounts($account_id);
									foreach($sub_accounts as $sub_account){
										$sub_account_income = 0;
										//$sub_acct = $CI->statements->get_sub_account($sub_account['id']);
										foreach($incomes as $income){
											if($income['sub_account'] == $sub_account['id']){
												$sub_account_income += $income['amounttransacted'];
											}
										}
										if($sub_account_income > 0){
											echo "<tr>";
												echo "<td style=\"text-indent: 3em;\">".$sub_account['account_name']."</td>";
												echo "<td>".$sub_account_income."</td>";
											echo "</tr>";
										}
									}
								} */
							}
						}
						
						echo "<tr>";
							echo "<td>Transaction Fees</td>";
							echo "<td>".$transaction_fees."</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td>Interests</td>";
							echo "<td>".$interests."</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td>Charges and Penalties</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td style=\"text-indent: 3em;\">Late Payment Fees</td>";
							echo "<td>".$late_payment_fees."</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td style=\"text-indent: 3em;\">Accrued Interests</td>";
							echo "<td>".$interest_fees."</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td style=\"text-indent: 3em;\">Bouncing Cheque Penalties</td>";
							echo "<td>".$cheque_penalties."</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td style=\"text-indent: 3em;\">Debt Collection Fees</td>";
							echo "<td>".$debt_collection_fees."</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td style=\"font-style:bold;font-size:15px;color:purple\">Gross Income</td>";
							echo "<td style=\"font-style:bold;font-size:15px;color:purple\">".number_format($gross_income,2,'.',',')."</td>";
						echo "</tr>";
						
						 echo "<thead>
		                          <tr>
		                               <th>EXPENDITURE</th>
		                          </tr>
		                    </thead>";
						
                        $total_expenditure = 0;
						for($i = 0; $i < count($expenditures_array); $i++){
							$expenditures = $expenditures_array[$i];
							$account_id = 0;
							$account_expenditure = 0;
							foreach($expenditures as $expenditure){
								$account_id = $expenditure["account"];
								$account_expenditure += $expenditure['amounttransacted'];
								$total_expenditure += $expenditure['amounttransacted'];
							}
							$account = $CI->statements->get_account($account_id);
							
							if($account_expenditure > 0){
								if($account['has_child'] == 0){
									echo "<tr>
												<td>".$account['account_name']."</td>
												<td>".$account_expenditure."</td>
											</tr>";	
								}
								else{
									echo "<tr>";
										echo "<td>".$account['account_name']."</td>";
									echo "</tr>";
									
									$sub_accounts = $CI->statements->get_sub_accounts($account_id);
									foreach($sub_accounts as $sub_account){
										$sub_account_expenditure = 0;
										//$sub_acct = $CI->statements->get_sub_account($sub_account['id']);
										foreach($expenditures as $expenditure){
											if($expenditure['sub_account'] == $sub_account['id']){
												$sub_account_expenditure += $expenditure['amounttransacted'];
											}
										}
										if($sub_account_expenditure > 0){
											echo "<tr>";
												echo "<td style=\"text-indent: 3em;\">".$sub_account['account_name']."</td>";
												echo "<td>".$sub_account_expenditure."</td>";
											echo "</tr>";
										}
									}
								}
							}
						}
						echo "<tr>";
							echo "<td style=\"font-style:bold;font-size:15px;color:purple\">Total Expenditure</td>";
							echo "<td style=\"font-style:bold;font-size:15px;color:purple\">".number_format($total_expenditure,2,'.',',')."</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td style=\"font-style:bold;font-size:15px;color:purple\"></td>";
							echo "<td style=\"font-style:bold;font-size:15px;color:purple\"></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td style=\"font-style:bold;font-size:15px;color:purple\">NET INCOME</td>";
							echo "<td style=\"font-style:bold;font-size:15px;color:purple\">".number_format($gross_income - $total_expenditure,2,'.',',')."</td>";
						echo "</tr>";
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

              <div  id="basis"  class="tab-pane fade">
				<ul class="nav nav-tabs">
			      <li class="active">
				  		<?php
							$url = base_url().'income_statements/index/'.$month.'/'.$mwaka.'/1/B';
						?>
			           <a href="" data-toggle="tab" onclick="toPDF('<?php echo $url ?>')"><font color="#0000ff">Export to PDF</font></a>
			      </li>
			 	</ul>
				<strong>Basis Profit & Loss Statement </strong><br />
				 <?php echo $month_year; ?>
					
                   <?php if( true ){
						?>
						  <table class="table">
		                    <thead>
		                          <tr>
		                               <th>INCOME</th>

		                               <th>KES</th>
		                          </tr>
		                    </thead>
		                    <tbody class="payments-body">
                        <?php 
						$i = 1;
						$gross_income = 0;
						$transaction_fees = 0;
						$interests = 0;
						$late_payment_fees = 0;
						$interest_fees = 0;
						$cheque_penalties = 0;
						$debt_collection_fees = 0;
						
						for($i = 0; $i < count($other_income_array); $i++){ //var_dump($other_income_array); exit;
							$incomes = $other_income_array[$i];
							$account_id = 0;
							$account_income = 0;
							foreach($incomes as $income){
								$account_id = $income["account_id"];
								$account_income += $income['amount'];
								$gross_income += $income['amount'];
							}
							$account = $CI->statements->get_account($account_id);
							
							if($account_income > 0){
								if($account['has_child'] == 0){
									echo "<tr>
												<td>".$account['account_name']."</td>
												<td>".$account_income."</td>
											</tr>";	
								}
								/*else{
									echo "<tr>";
										echo "<td>".$account['account_name']."</td>";
									echo "</tr>";
									
									$sub_accounts = $CI->statements->get_sub_accounts($account_id);
									foreach($sub_accounts as $sub_account){
										$sub_account_income = 0;
										//$sub_acct = $CI->statements->get_sub_account($sub_account['id']);
										foreach($incomes as $income){
											if($income['sub_account'] == $sub_account['id']){
												$sub_account_income += $income['amounttransacted'];
											}
										}
										if($sub_account_income > 0){
											echo "<tr>";
												echo "<td style=\"text-indent: 3em;\">".$sub_account['account_name']."</td>";
												echo "<td>".$sub_account_income."</td>";
											echo "</tr>";
										}
									}
								} */
							}
						}
						
						foreach($accrued_transaction_fees as $accrued_transaction_fee){
							$gross_income += $accrued_transaction_fee["amount"];
							$transaction_fees += $accrued_transaction_fee["amount"];				
						}
						$gross_income += $interests_c + $accrued_interests_c + $late_payment_fees_c + $bouncing_cheque_penalties_c + $debt_collection_fees_c;
						
						echo "<tr>";
							echo "<td>Transaction Fees</td>";
							echo "<td>".$transaction_fees."</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td>Interests</td>";
							echo "<td>".$interests_c."</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td>Charges and Penalties</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td style=\"text-indent: 3em;\">Late Payment Fees</td>";
							echo "<td>".$late_payment_fees_c."</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td style=\"text-indent: 3em;\">Accrued Interests</td>";
							echo "<td>".$accrued_interests_c."</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td style=\"text-indent: 3em;\">Bouncing Cheque Penalties</td>";
							echo "<td>".$bouncing_cheque_penalties_c."</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td style=\"text-indent: 3em;\">Debt Collection Fees</td>";
							echo "<td>".$debt_collection_fees_c."</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td style=\"font-style:bold;font-size:15px;color:purple\">Gross Income</td>";
							echo "<td style=\"font-style:bold;font-size:15px;color:purple\">".number_format($gross_income,2,'.',',')."</td>";
						echo "</tr>";
						
						 echo "<thead>
		                          <tr>
		                               <th>EXPENDITURE</th>
		                          </tr>
		                    </thead>";
						
						$CI = & get_instance();
						$CI->load->model('statements_model','statements');
                        $total_expenditure = 0;
						for($i = 0; $i < count($expenditures_array); $i++){
							$expenditures = $expenditures_array[$i];
							$account_id = 0;
							$account_expenditure = 0;
							foreach($expenditures as $expenditure){
								$account_id = $expenditure["account"];
								$account_expenditure += $expenditure['amounttransacted'];
								$total_expenditure += $expenditure['amounttransacted'];
							}
							$account = $CI->statements->get_account($account_id);
							
							if($account_expenditure > 0){
								if($account['has_child'] == 0){
									echo "<tr>
												<td>".$account['account_name']."</td>
												<td>".$account_expenditure."</td>
											</tr>";	
								}
								else{
									echo "<tr>";
										echo "<td>".$account['account_name']."</td>";
									echo "</tr>";
									
									$sub_accounts = $CI->statements->get_sub_accounts($account_id);
									foreach($sub_accounts as $sub_account){
										$sub_account_expenditure = 0;
										//$sub_acct = $CI->statements->get_sub_account($sub_account['id']);
										foreach($expenditures as $expenditure){
											if($expenditure['sub_account'] == $sub_account['id']){
												$sub_account_expenditure += $expenditure['amounttransacted'];
											}
										}
										if($sub_account_expenditure > 0){
											echo "<tr>";
												echo "<td style=\"text-indent: 3em;\">".$sub_account['account_name']."</td>";
												echo "<td>".$sub_account_expenditure."</td>";
											echo "</tr>";
										}
									}
								}
							}
						}
						echo "<tr>";
							echo "<td style=\"font-style:bold;font-size:15px;color:purple\">Total Expenditure</td>";
							echo "<td style=\"font-style:bold;font-size:15px;color:purple\">".number_format($total_expenditure,2,'.',',')."</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td style=\"font-style:bold;font-size:15px;color:purple\"></td>";
							echo "<td style=\"font-style:bold;font-size:15px;color:purple\"></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td style=\"font-style:bold;font-size:15px;color:purple\">NET INCOME</td>";
							echo "<td style=\"font-style:bold;font-size:15px;color:purple\">".number_format($gross_income - $total_expenditure,2,'.',',')."</td>";
						echo "</tr>";
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