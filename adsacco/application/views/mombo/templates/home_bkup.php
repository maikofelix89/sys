<?php
    $cust_no = $customers->num_rows();
    $loan_no = $loans->num_rows();
    $pen_no  = $charges->num_rows();
?>
<div class="header">
    <div class="stats">
        <p class="stat">
          <span class="number"> 
              <?php echo $cust_no; ?>
            </span>
            Registered Clients
        </p>
        <p class="stat">
             <span class="number">
                 <?php echo  $loan_no; ?>
            </span>
            Issued Loans
        </p>
        <p class="stat">
             <span class="number">
                 <?php  echo $pen_no; ?>
             </span>
            Penalties & Charges
        </p>
    </div>

    <h1 class="page-title">Dashboard</h1>
</div>

<ul class="breadcrumb">
    <li>
      <a href="index.php">Home</a> 
       <span class="divider">/</span>
    </li>
    <li class="active">Dashboard</li>
</ul>

<div class="container-fluid">
    <div class="row-fluid">
        <div class="row-fluid">
            <?php if(isset($message) && null != $message){ ?>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <?php echo  $message;?>
                </div>
            <?php } ?>

            <div class="block">
                <a href="#page-stats" class="block-heading" data-toggle="collapse">Latest Stats</a>
                <div id="page-stats" class="block-body collapse in">
                    <div class="stat-widget-container">
                        <div class="stat-widget">
                            <div class="stat-button">
                                <p class="title">
                                     <?php echo $loan_no; ?>
                                </p>
                                <p class="detail"> No. of Loans</p>
                            </div>
                        </div>
                        <div class="stat-widget">
                            <div class="stat-button">
                                <p class="title">
                                    <?php echo $cust_no; ?>
                                </p>
                                <p class="detail">Registered Clients</p>
                            </div>
                        </div>
                        <div class="stat-widget">
                            <div class="stat-button">
                                <p class="title">KES
                                   <?php echo $total_loan_sum; ?>
                                </p>
                                <p class="detail">Total Amount Out</p>
                            </div>
                        </div>
                        <div class="stat-widget">
                            <div class="stat-button">
                                <p class="title">KES
                                  <?php echo $total_payments; ?>
                                </p>
                                <p class="detail">Total Amount Paid</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row-fluid">
            <div class="block span6">
                <div class="block-heading">
                    <span class="block-icon pull-right">
                    </span>
                    <a href="#widget2container" data-toggle="collapse">Incoming payments</a>
                </div>
                <div id="widget2container" class="block-body collapse in">
                 
                  <?php if(count($payments) > 0){ ?>

                      <table class="table">
                        <thead>
                              <tr>
                                   <th>#</th>

                                   <th>Date</th>

                                   <th>Customer</th>
								   <th>Loan Product</th>

                                   <th>Amount Paid</th>

                                  <!-- <th>Description</th>-->
								   <!--<th></th>-->
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
                             ?>
                                  <tr>  
                                      <td><?php echo $i+1; ?></td>
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
                                      <!--<td>
                                        <p><?php echo $description?></p>
                                      </td>-->
									  <!--<td>
									  <?php 
									  	if($payment_channel_id == 1){
											$url = base_url().'loans/loanpayments/'.$payment_code.'/'.$payment_channel_id;
											?>
											<button onclick="confirm_action('<?php echo $url ?>','<?php echo $amount ?>','<?php echo $customer_name ?>')">Bounced</button>
											<?php
										}
										else{
											//echo 'cancel';
										}
									  ?>
									  </td>-->
                                  </tr>

                            <?php 
                                  
                               }
                           ?>
                        </tbody>
                    </table>

                  <?php  }else{ ?>

                          <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            No Loan payments have been made yet
                        </div>

                  <?php } ?>
                </div>
            </div>
            <div class="block span6">
                <a href="#widget1container" class="block-heading" data-toggle="collapse">Quick Menu</a>
                <div id="widget1container" class="block-body collapse in">
                    <table width="775" height="420">
                        <tr>
                          <td>
                            <a href="<?php echo base_url().'accounts/';?>">
                               <img src="<?php echo base_url();?>images/account.png" >
                            </a>
                           </td>	
                           <td>
                               <a href="<?php echo base_url().'loans/loansissued';?>">
                                  <img src="<?php echo base_url();?>images/loansdue.png" >
                                </a>
                           </td> 
                        </tr>
                        <tr>
                           <td>
                             <a href="<?php echo base_url().'accounts/';?>" style="btn btn-primary">Accounts</a>
                           </td> 
                           <td>
                             <a href="<?php echo base_url().'loans/loansissued';?>" style="btn btn-primary">Issued Loans</a>
                           </td>
                        </tr>
                        <tr>
                          <tr>
                             <td colspan="3"></td>
                          </tr>
                          <td>
                            <a href="<?php echo base_url().'statements/';?>">
                               <img src="<?php echo base_url();?>images/reports.png" >
                            </a>
                          </td>  	
                          <td>
                            <a href="<?php echo base_url().'customers/?type=new';?>">
                               <img src="<?php echo base_url();?>images/new_members.png" >
                            </a>
                          </td> 
                          <td>
                             <a href="<?php echo base_url().'messages/';?>">
                               <img src="<?php echo base_url();?>images/message.png" >
                             </a>
                          </td>	
                        </tr>
                        <tr>
                            <td>
                               <a href="<?php echo base_url().'statements/';?>" style="btn btn-primary">Statements</a>
                            </td>   
                            <td>
                               <a href="<?php echo base_url().'customers/?type=new';?>" style="btn btn-primary">Members</a>
                            </td>  
                            <td>
                               <a href="<?php echo base_url().'messages/';?>" style="btn btn-primary">Messages</a>
                            </td>   
                        </tr>
                        <tr><td colspan="3"></td></tr>
                    </table>
                </div>
            </div>
        </div>
