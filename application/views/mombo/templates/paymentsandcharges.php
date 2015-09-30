<div class="header">
       <h1 class="page-title">Loan Expected Payments & Charges</h1> 
 </div>
        
<ul class="breadcrumb">
    <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>
    <li><a href="<?php echo base_url();?>loans/loansissued/">Loans Issued</a></li><span class="divider">/</span></li>
    <li class="active" >Payments and Charges</li>
</ul>

<div class="container-fluid">
<div class="row-fluid">



<?php if(isset($message) && $message){ ?>

    <div class="alert alert-<?php echo $message_type; ?>">

        <button type="button" class="close" data-dismiss="alert">×</button>

        <?php echo $message;?>

    </div>

<?php } ?>

<div class="well">
       <h5>
           Loan Payments and Charges

       </h5>

      <div class="well">

                <ul class="nav nav-tabs">

                       <li <?php if($current_tab == 'loan_payments'){ echo 'class="active"'; } ?> ><a data-toggle="tab" href="#loan-payments">Expected Payments Details</a></li>

                       <li <?php if($current_tab == 'loan_charges'){ echo 'class="active"'; } ?>><a data-toggle="tab" href="#loan-charges">Loan Charges Details</a></li>
					   <li <?php if($current_tab == 'statement'){ echo 'class="active"'; } ?>><a data-toggle="tab" href="#statement">Loan Statement</a></li>

                </ul>

                <div class="tab-content">

                       <div id="loan-payments" class="tab-pane <?php if($current_tab == 'loan_payments'){ echo ' active'; } ?>">

                            <?php if($payments->num_rows > 0){ ?>

                                  <table class="table">

                                          <thead>

                                                <tr>

                                                     <th>Transaction Code</th>
                                                  
                                                     <th>Date Expected</th>

                                                     <th>Amount</th>
													 
													<th>Principal</th>
													
													<th>Interest</th>
													
                                                     <th>Principal Balance</th>

                                                     <th>Interest Balance</th>

                                                     <th>Total Balance</th>

                                                </tr>
                                            
                                          </thead>
                                          <tbody>

                                              <?php foreach ($payments->result('expectedpayment_model') as $payment): ?>
											  		<?php 
														$principal = $payment->amount - $payment->interest_amount; 
														$total_balance = $payment->balance + $payment->interest_amount_balance;
													?>

                                                        <tr>

                                                              <td>

                                                                   <a title="View Transaction Log" href="<?php echo base_url().'accounts/transactionhistroy/?transaction_code='.$payment->transaction_code; ?>">

                                                                      <?php echo $payment->transaction_code; ?>

                                                                   </a>
                                                              
                                                              </td>

                                                              <td><?php echo $payment->date_expected; ?></td>

                                                              <td><?php echo $payment->amount; ?></td>
															  
															  <td><?php echo $principal; ?></td>

                                                              <td><?php echo $payment->interest_amount; ?></td>
															  
															  <td><?php echo $payment->balance; ?></td>

                                                              <td><?php echo $payment->interest_amount_balance; ?></td>
															  
															  <td><?php echo $total_balance; ?></td>

                                                              

                                                              <td>
                                                                
                                                                   <?php if($payment->paid){ ?>

                                                                              <span class="btn btn-primary btn-small" disabled="disabled">Paid</span>

                                                                   <?php }else{ ?>

                                                                             <a class="btn btn-info btn-small" href="<?php echo base_url().'loans/makeapayment/?type=payment&payment_id='.$payment->id.'&loan_id='.$payment->loan->id; ?>">Make Payment</a>
																			  <!--<a onclick="confirm_action()" class="btn btn-info btn-small" href="<?php echo base_url().'loans/loanpaymentsandcharges/?payment_id='.$payment->id.'&loan_id='.$payment->loan->id.'&interest='.$payment->interest_amount_balance; ?>">Waive Interest</a>-->
																	<?php
																	$url = base_url().'loans/loanpaymentsandcharges/?payment_id='.$payment->id.'&loan_id='.$payment->loan->id.'&interest='.$payment->interest_amount_balance;
																	if($payment->interest_amount_balance > 0){
																		?>
																		<button onclick="confirm_action('<?php echo $url ?>')">Waive Interest</button>
																		<?php
																	}
																	?>
																	

                                                                              <a class="btn btn-warning btn-small" href="<?php echo base_url().'loans/reschedulepayment/?payment_id='.$payment->id.'&loan_id='.$payment->loan->id; ?>">Reschedule</a>

                                                                   <?php } ?>

                                                              </td>

                                                        </tr>

                                              <?php endforeach;?>
                                            
                                          </tbody>

                                  </table>

                            <?php }else{ ?>

                                      <div class="alert alert-info">

                                        <button type="button" class="close" data-dismiss="alert">×</button>

                                         No payments items for this loan item

                                      </div>

                            <?php } ?>

                       </div>

                       <div id="loan-charges"  class="tab-pane <?php if($current_tab == 'loan_charges'){ echo ' active'; } ?>">

                            <?php if($charges->num_rows > 0){ ?>

                                  <table class="table">

                                          <thead>

                                                  <tr>
                                                    
                                                       <th>Transaction Code</th>
													   
													   <th>Name</th>

                                                       <th>Date Charged</th>

                                                       <th>Charge Amount</th>

                                                       <th>Charge Balance</th>

                                                  </tr>
                                            
                                          </thead>

                                          <tbody>

                                                     <?php foreach($charges->result('charge_model') as $charge): ?>

                                                            <tr>

                                                                  <td> 
                                                                       <a title="View Transaction Log" href="<?php echo base_url().'accounts/transactionhistroy/?transaction_code='.$payment->transaction_code; ?>">

                                                                          <?php echo $charge->transaction_code; ?> 

                                                                       </a>

                                                                  </td>
																  
																  <td> <?php echo $charge->name; ?> </td>

                                                                  <td> <?php echo $charge->date; ?> </td>

                                                                  <td> <?php echo $charge->amount; ?> </td>

                                                                  <td> <?php echo $charge->balance; ?></td>

                                                                  <td>
                                                                    
                                                                         <?php if($charge->paid){ ?>

                                                                              <span class="btn btn-primary btn-small" disabled="disabled">Paid</span>

                                                                         <?php }else{ ?>

                                                                                    <a class="btn btn-info btn-small" href="<?php echo base_url().'loans/makeapayment/?type=charge&charge_id='.$charge->id.'&loan_id='.$charge->loan; ?>">Make Payment</a>

                                                                                    <a class="btn btn-warning btn-small" href="<?php echo base_url().'loans/waivercharge/?charge_id='.$charge->id.'&loan_id='.$charge->loan; ?>">Waiver</a>

                                                                         <?php } ?>

                                                                  </td>
                                                              

                                                            </tr>

                                                     <?php endforeach; ?>
                                            
                                          </tbody>

                                  </table>

                            <?php }else{ ?>

                                      <div class="alert alert-info">

                                          <button type="button" class="close" data-dismiss="alert">×</button>

                                          No charge items or fees for this loan item

                                      </div>


                            <?php } ?>

                       </div>
					   
					      <div class="tab-pane <?php if($current_tab == 'statement'){ echo ' active'; } ?>" id="statement">
						  		<ul class="nav nav-tabs">
							      <li class="active">
							           <a href="#" data-toggle="tab">Export to PDF</a>
							      </li>
							    </ul>
				              <?php if($customer->num_rows() > 0 ){  ?>
									<table class="table">
										<thead>
											<tr class="muted">
												<th colspan="6" style="text-align: center;"><img src="<?php echo base_url().'img/logo2.png'; ?>"/></th>
											</tr>
											<!--<tr class="muted">
												<th colspan="6" style="text-align: center">Mombo Investment Limited</th>
											</tr>-->
											<tr class="muted">
												<th colspan="6" style="text-align: center">Loan Statement of Account as of <?php echo $date; ?></th>
											</tr>
											<tr class="muted">
												<th colspan="6" style="text-align: left">Borrower: 
												 <?php 
												 	foreach($customer->result('customer_model') as $cust){
														echo $cust->name.' '.$cust->other_names;
													} ?>
												 </th>
											</tr>
											<tr class="muted">
												<th colspan="6" style="text-align: left">Loan Product: 
												 <?php 
												 	foreach($single_loan->result('loan_model') as $cust_loan){
														echo $cust_loan->loan_product->loan_product_name;
													}
												?>
												</th>
											</tr>
											<tr class="muted">
												<th colspan="6" style="text-align: left">Disbursement Description: 
												 <?php 
												 	foreach($single_loan->result('loan_model') as $cust_loan){
														echo $cust_loan->disbursement_description;
													}
												?>
												</th>
											</tr>
											<tr class="muted">
												<th colspan="6" style="text-align: left">Loan Transaction Code: 
												 <?php 
												 	foreach($single_loan->result('loan_model') as $cust_loan){
														echo $cust_loan->transaction_code;
													}
												?>
												</th>
											</tr>
											<tr class="muted">
												<th style="text-align: left">Date</th>
												<th style="text-align: left">Transaction</th>
												<th style="text-align: left">Description</th>
												<th style="text-align: left">Debit</th>
												<th style="text-align: left">Credit</th>
												<th style="text-align: left">Balance</th>
											</tr>
										</thead>
										<tbody>	
											
												<?php 
													foreach($loan_transactions as $loan_transaction){
														$credit = "";
														$debit = "";
														if($loan_transaction["is_credit"]){
															$credit = $loan_transaction["amount"];
														}
														else{
															$debit = $loan_transaction["amount"];
														}
														$date_time = date("Y-m-d", strtotime($loan_transaction["date_time"]));
														echo '<tr>';
														echo '<td style="text-align: left">'.$date_time.'</td>'; 
														echo '<td style="text-align: left">'.$loan_transaction["transaction"].'</td>';
														echo '<td style="text-align: left">'.$loan_transaction["description"].'</td>';
														echo '<td style="text-align: left">'.$debit.'</td>';
														echo '<td style="text-align: left">'.$credit.'</td>';
														echo '<td style="text-align: left">'.$loan_transaction["balance"].'</td>';
														echo '</tr>';
													}
												?>
										</tbody>
										
									</table>
								<?php }else{ ?>
				                           <div class="alert alert-info">
										        <button type="button" class="close" data-dismiss="alert">×</button>
										        Customer not found.
										    </div>
								<?php } ?>
					      </div>

                </div>

      </div>

</div>

<script type="text/javascript" language="javascript">
	function confirm_action(url){
		if (confirm('Are you sure you want to waive the interest?')) {
			window.location.href=url;
		}
	}
</script>