 <div class="header">
       <h1 class="page-title">Mombo Loyal</h1>
 </div>
        
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>
            <li class="active">Mombo Loyal</li>
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

     <h4></h4>

     <div class="well">

         <ul class="nav nav-tabs">

               <li class="active"><a data-toggle="tab" href="#unsettled">Unsettled</a></li>
                <li ><a data-toggle="tab" href="#settled">Settled</a></li>
                <li>
                     <form class="form-horizontal" id="payments-filter" method="POST" action="<?php echo base_url().'loans/rewards/';?>">

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
					
              <div id="unsettled" class="tab-pane active">

                   <?php if($unsettled != 0){ ?>

                      <table class="table">
                        <thead>
                              <tr>
                                   <th>#</th>

                                   <th>Name</th>
                                   <th>Phone</th>
                                   <th>Redeemed Points</th>
								   <th>Reward Type</th>
								   <th>Provider</th>
								   <th>Reward Value</th>
								   <th>Date Submitted</th>

                              </tr>
                        </thead>
                        <tbody class="payments-body">
                            <?php 
								$unsettled_rewards = explode('^',$unsettled);
                                $j=1;
                                for($i=0; $i < count($unsettled_rewards); $i++) {
									$unsettled_reward = explode('*',$unsettled_rewards[$i]);
									$customer_id = $unsettled_reward[0];
									$customer_name = $unsettled_reward[1];
									$points = $unsettled_reward[2];
									$type_id = $unsettled_reward[3];
									$reward_type = $unsettled_reward[4];
									$reward_value = $unsettled_reward[5];
									$date_submitted = $unsettled_reward[6];
									$redeemed_id = $unsettled_reward[8];
									$provider = $unsettled_reward[9];
									$phone = $unsettled_reward[10];
									$customer_fname = $unsettled_reward[11];
									$url = base_url().'loans/settle_reward/'.$redeemed_id.'/?cust_name='.$customer_name;
									$url .='&rew_type='.$reward_type.'&rew_value='.$reward_value.'&msisdn='.$phone.'&cust_fname='.$customer_fname;
									//$url = urlencode($url);
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
                                          <?php echo $phone; ?>
                                      </td>
									  <td>
                                          <?php echo $points; ?>
                                      </td>
                                      <td>
                                         <p><?php echo $reward_type; ?></p>
                                      </td>
									  <td>
                                         <p><?php echo $provider; ?></p>
                                      </td>
									  <td>
                                         <p><?php echo $reward_value; ?></p>
                                      </td>
									  <td>
                                         <p><?php echo $date_submitted; ?></p>
                                      </td>
									  <td>
										<?php
											if(2 == $type_id){
												?>
												<p><button onclick="confirm_action('<?php echo $url ?>','<?php echo $customer_name; ?>','<?php echo $reward_type; ?>','<?php echo $reward_value; ?>')">Settle</button></p>
												<?php
											}
										?>
										 
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
                                  There are no records.
                              </div>

                  <?php } ?>

              </div>

              <div  id="settled"  class="tab-pane fade">
				<?php if($settled != 0){ ?>
				<table class="table">
                        <thead>
                              <tr>
                                   <th>#</th>

                                   <th>Name</th>
                                   <th>Phone</th>
                                   <th>Redeemed Points</th>
								   <th>Reward Type</th>
								   <th>Provider</th>
								   <th>Reward Value</th>
								   <th>Date Submitted</th>
								   <th>Date Settled</th>

                              </tr>
                        </thead>
                        <tbody class="payments-body">
                            <?php 
								$settled_rewards = explode('^',$settled); 
                                $j=1;
                                for($i=0; $i < count($settled_rewards); $i++) { 
									$settled_reward = explode('*',$settled_rewards[$i]);
									$customer_id = $settled_reward[0];
									$customer_name = $settled_reward[1];
									$points = $settled_reward[2];
									$type_id = $settled_reward[3];
									$reward_type = $settled_reward[4];
									$reward_value = $settled_reward[5];
									$date_submitted = $settled_reward[6];
									$date_settled = $settled_reward[7];
									$provider = $settled_reward[9]; 
									$phone = $settled_reward[10];
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
                                          <?php echo $phone; ?>
                                      </td>
									  <td>
                                          <?php echo $points; ?>
                                      </td>
                                      <td>
                                         <p><?php echo $reward_type; ?></p>
                                      </td>
									  <td>
                                         <p><?php echo $provider; ?></p>
                                      </td>
									  <td>
                                         <p><?php echo $reward_value; ?></p>
                                      </td>
									   <td>
                                         <p><?php echo $date_submitted; ?></p>
                                      </td>
									   <td>
                                         <p><?php echo $date_settled; ?></p>
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
                                  No record found.
                              </div>

                  <?php } ?>
				  

			   </div>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript">
	function confirm_action(url,cust_name,rew_type,rew_value){
		if (confirm('Are you sure you want to settle the reward of '+rew_type+' of value Ksh. '+rew_value+' for '+cust_name+'?')) {
			window.location.href=url;
		}
	}
</script>