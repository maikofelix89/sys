 <div class="header">
       <h1 class="page-title">Debt Recovery</h1>
 </div>
        
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>
            <li class="active">Debt recovery</li>
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

     <h4>Debt Recovery Unit</h4>

     <div class="well">

         <ul class="nav nav-tabs">

               <li class="active"><a data-toggle="tab" href="#debt-recovery">Debt Recovery</a></li>
                <li ><a data-toggle="tab" href="#unpaid-cheques">Unpaid Cheques</a></li>
                <li>
                     <form class="form-horizontal" id="payments-filter" method="POST" action="<?php echo base_url().'loans/debtsrecovery/';?>">

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

              <div id="debt-recovery" class="tab-pane active">

                   <?php if(count($loan_ids) > 0){ ?>

                      <table class="table">
                        <thead>
                              <tr>
                                   <th>#</th>

                                   <th>Name</th>

                                   <th>Mobile</th>
								   <th>Amount</th>

                              </tr>
                        </thead>
                        <tbody class="payments-body">
                            <?php 
                                $j=1;
                                for($i=0; $i < count($loan_ids); $i++) {
									$amount = $debts_amounts[$loan_ids[$i]];
									$customer_details = explode('*',$customers[$loan_ids[$i]]);
									$customer_id = $customer_details[0];
									$customer_name = $customer_details[1];
									$customer_mobile = $customer_details[2];
									
                             ?>
                                  <tr>  
                                      <td><?php echo $i+1; ?></td>
                                      <td>
                                         <p><i class="icon-user"></i>
                                            <a href="<?php echo base_url().'customers/viewcustomerdetails/?customer_id='.$customer_id;?>">
                                              <?php echo $customer_name; ?>
                                            </a> 
                                         </p>
                                      </td>
									  <td>
                                          <?php echo $customer_mobile; ?>
                                      </td>
                                      <td>
                                         <p><?php echo $amount; ?></p>
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
                                  Debt Recovery Unit is currently empty.
                              </div>

                  <?php } ?>

              </div>

              <div  id="unpaid-cheques"  class="tab-pane fade">
				<?php
					$CI = & get_instance();

                    $CI->load->model('debtcollection_model','debtcollection');
					 $CI->load->model('chargestotalpayment_model','chargestotalpayment');
					?>
				  <table class="table">
                    <thead>
                          <tr>
                               <th>#</th>

                               <th>Name</th>

                               <th>Mobile</th>
							   <th>Amount</th>
							   <th>Penalty</th>
							   <th></th>

                          </tr>
                    </thead>
                    <tbody class="payments-body">
                            <?php 
					if(count($unpaid_cheques) > 0){
						$i = 1;
						foreach($unpaid_cheques as $unpaid_cheque){
							$customer = $CI->debtcollection->get_customer_details($unpaid_cheque['loan_id']);
							$cust_name = $customer["name"].' '.$customer["other_names"];
							$cust_id = $customer["id"];
							$cust_mobile = $customer["mobiletel"];
							
							$cheque_penalty_constants = $CI->chargestotalpayment->get_cheque_constants();
							$fixed_penalty_amount = $cheque_penalty_constants['fixed_amount'];
							$varied_penalty_amount = round( ($cheque_penalty_constants['percent']*$unpaid_cheque['amount']),2);
							$bouncing_cheque_penalty = $fixed_penalty_amount + $varied_penalty_amount;
							
							?>
                                  <tr>  
                                      <td><?php echo $i; $i++;?></td>
                                      <td>
                                         <p><i class="icon-user"></i>
                                            <a href="<?php echo base_url().'customers/viewcustomerdetails/?customer_id='.$cust_id;?>">
                                              <?php echo $cust_name; ?>
                                            </a> 
                                         </p>
                                      </td>
									  <td>
                                          <?php echo $cust_mobile; ?>
                                      </td>
                                      <td>
                                         <p><?php echo $unpaid_cheque['amount']; ?></p>
                                      </td>
									  <td>
                                         <p><?php echo $bouncing_cheque_penalty ; ?></p>
                                      </td>
									  <td>
                                         <p>
										 <?php 
										 	if($unpaid_cheque['is_deleted'] == 1){
												echo 'Unsettled'; 
											}
											else{
												echo 'Settled';
											}
										 ?>
										 </p>
                                      </td>
                                  </tr>

                            <?php 
						}
					?>
					 </tbody>
                    </table>
					<?php
					}else{ ?>

                              <div class="alert alert-info">
                                  <button type="button" class="close" data-dismiss="alert">×</button>
                                  No unpaid cheque.
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