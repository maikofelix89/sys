 <div class="header">
       <h1 class="page-title">Loan Payments</h1>
 </div>
        
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>
            <li class="active">Loan Payments</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
    <div class="btn-group">
         <a href="<?php echo base_url();?>loans/loanpayments/"  class="btn btn-primary">
           All Payments
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

     <h4>Payments</h4>

     <div class="well">

         <ul class="nav nav-tabs">

                <li class="active"><a data-toggle="tab" href="#payments-made">Payments</a></li>
                <li ><a data-toggle="tab" href="#expected-payments">Pending Payment</a></li>
                <li>
                     <form class="form-horizontal" id="payments-filter" method="POST" action="<?php echo base_url().'loans/loanpayments/';?>">

                        <script type="text/javascript">

                            $(function(){

                                 $('#date-start').datepicker({format:'yyyy-mm-dd'});

                                 $('#date-end').datepicker({format:'yyyy-mm-dd'});

                            });

                        </script>
                        
                        <div class="control-group">

                            <div class="controls">
                                   From

                                    <input type="text" name="start_date" id="date-start"  value="<?php if($date = $_POST['start_date']) echo $date; ?>"/>

                                    To
                                 
                                    <input type="text" name="end_date" id="date-end" value="<?php if($date = $_POST['end_date']) echo $date; ?>"/>

                                    <input type="submit" name="go" class="btn btn-small btn-info" value="Go"/>
                                  
                            </div>

                        </div>

                    </form>
                </li>

         </ul>

         <div class="tab-content">

              <div id="payments-made" class="tab-pane active">

                   <?php if(count($payments) > 0){ ?>

                      <table class="table">
                        <thead>
                              <tr>
                                   <th></th>

                                   <th>Date Paid</th>

                                   <th>Customer</th>
								   <th>Loan Product</th>

                                   <th>Amount Paid</th>

                                   <th>Description</th>
								   <th></th>
                              </tr>
                        </thead>
                        <tbody class="payments-body">
                            <?php 
                                $j=1;
                                for($i=0; $i < count($payments); $i++) {
									$payment_details = explode('*',$payments[$i]);
									$date_time = $payment_details[0];
									$customer_name = $payment_details[1];
									$amount = $payment_details[2];
									$description = $payment_details[3];
									$customer_id = $payment_details[4];
									$loan_product = $payment_details[5];
									$payment_code = $payment_details[6];
									$payment_channel_id = $payment_details[7];
									$loan_id = $payment_details[8];
                             ?>
                                  <tr>  
                                      <td><?php echo $j; ?></td>
                                       <td>
                                         <p><?php echo $date_time; ?></p>
                                      </td>
                                      <td>
                                         <p><i class="icon-user"></i>
                                            <a href="<?php echo base_url().'customers/viewcustomerdetails/?customer_id='.$customer_id;?>">
                                              <?php echo $customer_name; ?>
                                            </a> 
                                         </p>
                                      </td>
									  <td>
                                          <?php echo $loan_product; ?>
                                      </td>
                                      <td>
                                         <p><?php echo $amount; ?></p>
                                      </td>
                                      <td>
                                        <p><?php echo $description?></p>
                                      </td>
									  <td>
									  <?php 
									  	if($payment_channel_id == 1){
											$url = base_url().'loans/loanpayments/'.$payment_code.'/'.$payment_channel_id.'/'.$loan_id;
											?>
											<button onclick="confirm_action('<?php echo $url ?>','<?php echo $amount ?>','<?php echo $customer_name ?>')">Cancel</button>
											<?php
										}
									  ?>
									  </td>
                                  </tr>

                            <?php 
                                  $j++;
                               }
                           ?>
                        </tbody>
                    </table>

                  <?php }else{ ?>

                              <div class="alert alert-info">
                                  <button type="button" class="close" data-dismiss="alert">×</button>
                                  No Loan payments have been made yet
                              </div>

                  <?php } ?>

              </div>

              <div  id="expected-payments"  class="tab-pane fade">

                     <?php if(count($expectedpayments) > 0){  ?>

                      <table class="table">
                        <thead>
                              <tr>
                                   <th>#</th>

                                   <th>Date Expected</th>

                                   <th>Customer</th>

                                   <th>Loan Product</th>

                                   <th>Amount Expected</th>
								   <th>Description</th>

                              </tr>
                        </thead>
                        <tbody id="expected-payments-body">
                            <?php 
                                
                                for($i=0; $i < count($expectedpayments); $i++) {
									$expected_payments_details = explode('*',$expectedpayments[$i]);
									$installment = $expected_payments_details[0];
									$interest = $expected_payments_details[1];
									$charges = $expected_payments_details[2];
									$date = $expected_payments_details[3];
									$customer_name = $expected_payments_details[4];
									$customer_id = $expected_payments_details[5];
									$loan_product = $expected_payments_details[6];
                             ?>
                                  <tr>  
                                      <td><?php echo $i+1; ?></td>
                                       <td>
                                         <p><?php echo $date; ?></p>
                                      </td>
                                      <td>
                                         <p><i class="icon-user"></i>
                                            <a href="<?php echo base_url().'customers/viewcustomerdetails/?customer_id='.$customer_id;?>">
                                              <?php echo ucwords(strtolower($customer_name)); ?>
                                            </a> 
                                         </p>
                                      </td>
                                      <td>
                                          <?php echo $loan_product; ?>
                                      </td>
                                      <td>
                                         <p><?php echo $installment + $interest + $charges; ?></p>
                                      </td>
									  <td>
                                         <p><?php echo 'Installment: KSH. '.$installment.'; Interest: KSH. '.$interest.'; Charges: KSH. '.$charges; ?></p>
                                      </td>
                                     
                                  </tr>

                            <?php 
                               }
                           ?>
                        </tbody>
                    </table>

                  <?php }else{ ?>

                              <div class="alert alert-info">
                                  <button type="button" class="close" data-dismiss="alert">×</button>
                                  No expected loan payments 
                              </div>

                  <?php } ?>

              </div>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript">
	function confirm_action(url,amount,customer){
		if (confirm('Are you sure you want to cancel payment made by cheque of KSH. '+amount+' by '+customer+'?')) {
			window.location.href=url;
		}
	}
</script>