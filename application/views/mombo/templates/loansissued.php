<div class="header">
       <?php if($criteria == 'all'){ ?> <h1 class="page-title">All Issued Loans</h1> <?php } ?>
       <?php if($criteria == 'paid'){ ?> <h1 class="page-title">Settled Issued Loans</h1> <?php } ?>
       <?php if($criteria == 'unpaid'){ ?> <h1 class="page-title">Unsettled Issued Loans</h1> <?php } ?>
 </div>
        
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>
            <li class="active">Issued Loans</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
    <div class="btn-group">
         <a href="<?php echo base_url();?>loans/loansissued/?criteria=all"  class="btn <?php if($criteria == 'all') echo 'btn-primary';?> ">
           All Issued Loans
         </a>
          <a href="<?php echo base_url();?>loans/loansissued/?criteria=paid"  class="btn <?php if($criteria == 'paid') echo 'btn-primary';?>">
           Settled Issued Loans
         </a>
          <a href="<?php echo base_url();?>loans/loansissued/?criteria=unpaid"  class="btn  <?php if($criteria == 'unpaid') echo 'btn-primary';?>">
           Unsettled Issued Loans
         </a>
    </div>
    <div class="btn-group pull-right">
      <a href="<?php echo base_url().'loans/issueloan/';?>" class="btn btn-success"><i class="icon-plus"></i>Issue Loan</a>
      <a href="<?php echo base_url().'loans/exportimport/';?>" class="btn">Import & Export Loans Issued</a>
    </div>
</div>
	
	<form class="form-horizontal" id="payments-filter" method="POST" action="<?php echo base_url().'loans/loansissued/?criteria='.$criteria;?>">
		<div class="control-group">
	
	        <div class="controls">
	               From

	                <input type="text" name="start_date" id="date-start"  value="<?php if( ($date = $_POST['start_date']) || ($date = $_GET['start_date'])) echo $date; ?>"/>

	                To
	             
	                <input type="text" name="end_date" id="date-end" value="<?php if( ($date = $_POST['end_date']) || ($date = $_GET['end_date'])) echo $date; ?>"/>

	                <input type="submit" name="go" class="btn btn-small btn-info" value="Go"/>
	              
	        </div>

       </div>
	</form>

<?php if(isset($message) && $message){ ?>
    <div class="alert alert-<?php echo $message_type; ?>">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <?php echo $message;?>
    </div>
<?php } ?>
<div class="well">
    <?php 
	$check = false;
	if($filtered){
		if($loans != 0){
			$check = true;;
		}
	}
	else{
		if($loans->num_rows() > 0) $check = true;
	}
	if($check){ ?>
         <form action="<?php echo base_url().'loans/bulkaction/'?>" method="POST">
          <table class="table">
            <thead>
              <tr class="muted">
                <th>#</th>
                <th>Customer</th>
                <th>Loan Product</th>
                <th>Principal Amount</th>
                <th>Total Interest</th>
				<th>Total Charges</th>
				<th>Total Amount Payable</th>
				<th>Total Amount Paid</th>
                <th>Total Balance Due</th>
                <th>Duration in Days</th>
              </tr>
            </thead>
            <tbody> 
                 <?php 
                    $i=1;
					$j=0;
               		if($filtered){
						     foreach ($loans as $loan) {
								$total_bal_due = round(($loan["loan_principle_amount"] + $loan["total_interest_amount"] + $total_charges[$j]) 
								- $total_amount_paid[$j], 2);
								$total_amount_payable = $loan["loan_principle_amount"] + $loan["total_interest_amount"] + $total_charges[$j];
								if( ($loan["date_settled"] == '0000-00-00') || (is_null($loan["date_settled"])) ){
									$date_settled = date('Y-m-d');
								}
								else{
									$date_settled = $loan["date_settled"];
								}
		                  ?>
		                     <tr <?php if($i%2==0) echo 'class="row-strip"'; ?> >
								<td><?php echo $j+1; ?></td>
		                        <td>
		                             <a href="<?php echo base_url().'customers/viewcustomerdetails/?customer_id='.$loan["customer"]; ?>" title="View customer details">
		                                  
		                                  <?php
										  	$CI = & get_instance();
											$CI->load->model(loan_model);
											$customer_name = $CI->loan_model->get_customer($loan["customer"]);
										    echo  ucwords(strtolower($customer_name));
										?>

		                             </a>
		                        </td>
		                        <td><?php
									$loan_product_name = $CI->loan_model->get_loan_product($loan["loan_product"]);
								  echo $loan_product_name; 
								 ?></td>
		                        <td><?php  echo $loan["loan_principle_amount"]; ?></td>
		                        <td><?php  echo $loan["total_interest_amount"]; ?></td>
								<td><?php  echo $total_charges[$j]; ?></td>
								<td><?php  echo $total_amount_payable; ?></td>
								<td><?php  echo $total_amount_paid[$j]; ?></td>
		                        <td><?php  echo $total_bal_due; ?></td>
		                        <!--<td><?php  echo $loan->loan_duration.' '.$loan->loan_product->repayment_frequency_single.'s'; ?></td>-->
								<td><?php  echo floor( ( strtotime( $date_settled ) - strtotime( $loan["loan_issue_date"] ) ) / 86400 ); ?></td>
								<td><a href="<?php echo base_url().'gaurantors/viewgaurantordetails/?gaurantor_id='.$loan["gaurantor"]; ?>" class="btn btn-info btn-small">
												
												  Guarantor 1

									</a>
								</td>
								<td><a href="<?php echo base_url().'gaurantors/viewgaurantordetails/?gaurantor_id='.$loan["guarantor_b"]; ?>" class="btn btn-info btn-small">
												
												  Guarantor 2

									</a>
								</td>
		                        <td style="text-align:center;">
		                           <?php if($loan["loan_status"] == 0){ ?> 

		                               <a href="<?php echo base_url().'loans/loanpaymentsandcharges/?loan_id='.$loan["id"]; ?>" class="btn btn-info btn-small">
		                                    
		                                      Payments and Charges

		                               </a>
									  <?php if($loan->penalizable == 0){ echo "<br />";?> 
											<td><a href="<?php echo base_url().'loans/penalization/?type=1&loan_id='.$loan["id"]; ?>" class="btn btn-info btn-small">
												
												  Enable Penalization

										   </a></td>
									   <?php }else{ echo "<br />";?>
											<td><a href="<?php echo base_url().'loans/penalization/?type=0&loan_id='.$loan["id"]; ?>" class="btn btn-info btn-small">
												
												  Disable Penalization

										   </a></td>
									   <?php } ?>
									   
									  <!-- <a href="<?php echo base_url().'loans/chargefeeonloan/?loan_id='.$loan["id"]; ?>" class="btn btn-warning btn-small">
		                                    
		                                      Charge Fee on Loan

		                               </a>-->
		                           <?php }else{ ?>

		                               <a class="btn btn-success btn-small" href="<?php echo base_url().'loans/loanpaymentsandcharges/?loan_id='.$loan["id"]; ?>">

		                                       Loan Paid

		                               </a>

		                           <?php } ?>
		                        </td>
		                   </tr>
		                <?php
		                  $i++;
						  $j++;
		                 }
					}
					else{
						     foreach ($loans->result('loan_model') as $loan) {
								$total_bal_due = round(($loan->loan_principle_amount + $loan->total_interest_amount + $total_charges[$j]) 
								- $total_amount_paid[$j], 2);
								$total_amount_payable = $loan->loan_principle_amount + $loan->total_interest_amount + $total_charges[$j];
								if( ($loan->date_settled == '0000-00-00') || (is_null($loan->date_settled)) ){
									$date_settled = date('Y-m-d');
								}
								else{
									$date_settled = $loan->date_settled;
								}
								
		                  ?>
		                     <tr <?php if($i%2==0) echo 'class="row-strip"'; ?> >
								<td><?php echo $j+1; ?></td>
		                        <td>
		                             <a href="<?php echo base_url().'customers/viewcustomerdetails/?customer_id='.$loan->customer->id; ?>" title="View customer details">
		                                  
		                                  <?php  echo  ucwords(strtolower($loan->customer->name.' '.$loan->customer->other_names));?>

		                             </a>
		                        </td>
		                        <td><?php  echo $loan->loan_product->loan_product_name; ?></td>
		                        <td><?php  echo $loan->loan_principle_amount; ?></td>
		                        <td><?php  echo $loan->total_interest_amount; ?></td>
								<td><?php  echo $total_charges[$j]; ?></td>
								<td><?php  echo $total_amount_payable; ?></td>
								<td><?php  echo $total_amount_paid[$j]; ?></td>
		                        <td><?php  echo $total_bal_due; ?></td>
		                        <!--<td><?php  echo $loan->loan_duration.' '.$loan->loan_product->repayment_frequency_single.'s'; ?></td>-->
								<td><?php  echo floor( ( strtotime( $date_settled ) - strtotime( $loan->loan_issue_date ) ) / 86400 ); ?></td>
								<?php if(! is_null($loan->gaurantor->id)){ ?>
									<td><a href="<?php echo base_url().'gaurantors/viewgaurantordetails/?gaurantor_id='.$loan->gaurantor->id; ?>" class="btn btn-info btn-small">
												
										  Guarantor 1

										</a>
								   </td>
								<?php } ?>
								<?php if(! is_null($loan->guarantor_b)){ ?>
							   <td><a href="<?php echo base_url().'gaurantors/viewgaurantordetails/?gaurantor_id='.$loan->guarantor_b; ?>" class="btn btn-info btn-small">
												
									  Guarantor 2

									</a>
							   </td>
							   <?php } ?>
		                        <td style="text-align:center;">
		                           <?php if($loan->loan_status == 0){ ?> 

		                               <a href="<?php echo base_url().'loans/loanpaymentsandcharges/?loan_id='.$loan->id; ?>" class="btn btn-info btn-small">
		                                    
		                                      Payments and Charges

		                               </a>
									   
									    <?php if($loan->penalizable == 0){ echo "<br />";?> 
											<td><a href="<?php echo base_url().'loans/penalization/?type=1&loan_id='.$loan->id; ?>" class="btn btn-info btn-small">
												
												  Enable Penalization

										   </a></td>
									   <?php }else{ echo "<br />";?>
											<td><a href="<?php echo base_url().'loans/penalization/?type=0&loan_id='.$loan->id; ?>" class="btn btn-info btn-small">
												
												  Disable Penalization

										   </a></td>
									   <?php } ?>
									   
									  <!-- <a href="<?php echo base_url().'loans/chargefeeonloan/?loan_id='.$loan->id; ?>" class="btn btn-warning btn-small">
		                                    
		                                      Charge Fee on Loan

		                               </a>-->
		                           <?php }else{ ?>

		                               <a class="btn btn-success btn-small" href="<?php echo base_url().'loans/loanpaymentsandcharges/?loan_id='.$loan->id; ?>">

		                                       Loan Paid

		                               </a>

		                           <?php } ?>
		                        </td>
								
		                   </tr>
		                <?php
		                  $i++;
						  $j++;
		                 }
					}
              ?>
               <tr>
                 <th style="border:none;">
                    <select class="input-small">
                        <option value="acc">Accept</option>
                        <option value="den">Deny</option>
                        <option value="rev">Revoke</option>
                    </select>
                 </th>
               </tr>
            </tbody>
          </table>
          </form>
          </div>
          <div class="pagination pagination-right">
              <?php
			  		if($filtered){
						$config['base_url'] = base_url().'loans/loansissued/?start_date='.$start_date.'&end_date='.$end_date;
					}
					else{
						$config['base_url'] = base_url().'loans/loansissued/?';
					}
                    
              ?>
              <?php $this->pagination->initialize($config);echo $this->pagination->create_links(); ?>
          </div>
    <?php }else{ ?>
             <div class="alert alert-info ?>">
               <?php if($this->input->get_post('per_page')){ ?>
                   No more loans
               <?php }else{ ?>
                   No loans issued in this group
               <?php } ?>
             </div>
              <?php if($this->input->get_post('per_page')){ ?>
                  <a class="btn btn-success" href="<?php echo base_url().'loans/loansissued/'; ?>">Back to All</a>
                 </div>
              <?php }else{ ?>
                  <a class="btn btn-success" href="<?php echo base_url().'loans/issueloan/'; ?>">Issue Loan</a>
                </div>
              <?php } ?>
    <?php } ?>
	
	 <script type="text/javascript">

        $(function(){

             $('#date-start').datepicker({format:'yyyy-mm-dd'});

             $('#date-end').datepicker({format:'yyyy-mm-dd'});

        });

    </script>