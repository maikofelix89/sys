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

                                                     <th>Interest Amount</th>

                                                     <th>Intestest Amount Balance</th>

                                                     <th>Balance</th>

                                                </tr>
                                            
                                          </thead>
                                          <tbody>

                                              <?php foreach ($payments->result('expectedpayment_model') as $payment): ?>

                                                        <tr>

                                                              <td>

                                                                   <a title="View Transaction Log" href="<?php echo base_url().'accounts/transactionhistroy/?transaction_code='.$payment->transaction_code; ?>">

                                                                      <?php echo $payment->transaction_code; ?>

                                                                   </a>
                                                              
                                                              </td>

                                                              <td><?php echo $payment->date_expected; ?></td>

                                                              <td><?php echo $payment->amount; ?></td>

                                                              <td><?php echo $payment->interest_amount; ?></td>

                                                              <td><?php echo $payment->interest_amount_balance; ?></td>

                                                              <td><?php echo $payment->balance; ?></td>

                                                              <td>
                                                                
                                                                   <?php if($payment->paid){ ?>

                                                                              <span class="btn btn-primary btn-small" disabled="disabled">Paid</span>

                                                                   <?php }else{ ?>

                                                                              <a class="btn btn-info btn-small" href="<?php echo base_url().'loans/makeapayment/?type=payment&payment_id='.$payment->id.'&loan_id='.$payment->loan->id; ?>">Make Payment</a>

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

                </div>

      </div>

</div>