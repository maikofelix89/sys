 <div class="header">
       <h1 class="page-title">Finance Transfers</h1>
 </div>
        
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>
            <li class="active">Finance Transfers</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<!--<div class="btn-toolbar">
    <div class="btn-group">
         <a href="<?php echo base_url();?>loans/loanproducts/"  class="btn btn-primary">
           All Payments
         </a>
    </div>
</div>-->
<?php if(isset($message) && $message){ ?>
    <div class="alert alert-<?php echo $message_type; ?>">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <?php echo $message;?>
    </div>
<?php } ?>
<div class="well">

     <h4>Finance Transfers</h4>

     <div class="well">

         <ul class="nav nav-tabs">

                <li class="active"><a data-toggle="tab" href="#new_transfers">New Transfers</a></li>
                <li ><a data-toggle="tab" href="#approved_transfers">Approved Transfers</a></li>
			    <li ><a data-toggle="tab" href="#rejected_transfers">Rejected Transfers</a></li>
                <li>
                     <form class="form-horizontal" id="payments-filter" method="POST" action="<?php echo base_url().'finance_transfers/';?>">

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

              <div id="new_transfers" class="tab-pane active">

                   <?php if(count($new_transfers) > 0){ ?>

                      <table class="table">
                        <thead>
                              <tr>
                                   <th></th>

                                   <th>Date</th>

                                   <th>Description</th>
								   <th>Amount</th>
                                   <th></th>
								   <th></th>
                              </tr>
                        </thead>
                        <tbody class="payments-body">
                            <?php 
                                $j=1;
                                for($i=0; $i < count($new_transfers); $i++) {
									$new_transfer = explode('^',$new_transfers[$i]);
									$from_account_name = $new_transfer[0];
									$to_account_name = $new_transfer[1];
									$from_account_id = $new_transfer[2];
									$to_account_string = $new_transfer[3];
									$amount = $new_transfer[4]; 
									$reference_number = $new_transfer[5];
									$description = $new_transfer[6];
									$date = $new_transfer[7];
									$parent_id = $new_transfer[8];
									$id = $new_transfer[10];
																		
                             ?>
                                  <tr>  
                                      <td><?php echo $j; ?></td>
                                       <td>
                                         <p><?php echo $date; ?></p>
                                      </td>
                                      <td>
                                         <p>
										 	Transfer from <?php echo $from_account_name; ?> to <?php echo $to_account_name; ?> 
                                         </p>
                                      </td>
									  <td>
                                          <?php echo $amount; ?>
                                      </td>
                                      <td>
									  <?php
									  $url = base_url().'accounts/transfercash/'.$from_account_id.'/'.$parent_id.'/1/?payee='.$to_account_string.'&amount='.$amount.'&reference_num='.$reference_number.'&date='.$date.'&description='.$description.'&id='.$id;
									  ?>
                                       <button onclick="confirm_action('<?php echo $url; ?>','Transfer of Ksh. <?php echo $amount ?> from <?php echo $from_account_name; ?> to <?php echo $to_account_name; ?>','APPROVE')">Approve</button>
                                      </td>
									  <td>
									  <?php
									  $url = base_url().'accounts/transfercash/'.$from_account_id.'/'.$parent_id.'/-1/?payee='.$to_account_string.'&amount='.$amount.'&reference_num='.$reference_number.'&date='.$date.'&description='.$description.'&id='.$id;
									  ?>
									 	<button onclick="confirm_action('<?php echo $url; ?>','Transfer of Ksh. <?php echo $amount ?> from <?php echo $from_account_name; ?> to <?php echo $to_account_name; ?>','REJECT')">Reject</button>
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
                                  No new transfer
                              </div>

                  <?php } ?>

              </div>

              <div id="approved_transfers" class="tab-pane fade">

                   <?php if(count($approved_transfers) > 0){ ?>

                      <table class="table">
                        <thead>
                              <tr>
                                   <th></th>

                                   <th>Date</th>

                                   <th>Description</th>
								   <th>Amount</th>
                               </tr>
                        </thead>
                        <tbody class="payments-body">
                            <?php 
                                $j=1;
                                for($i=0; $i < count($approved_transfers); $i++) {
									$approved_transfer = explode('^',$approved_transfers[$i]);
									$from_account_name = $approved_transfer[0];
									$to_account_name = $approved_transfer[1];
									$from_account_id = $approved_transfer[2];
									$to_account_string = $approved_transfer[3];
									$amount = $approved_transfer[4]; 
									$reference_number = $approved_transfer[5];
									$description = $approved_transfer[6];
									$date = $approved_transfer[7];
									$parent_id = $approved_transfer[8];
									$id = $approved_transfer[10];
																		
                             ?>
                                  <tr>  
                                      <td><?php echo $j; ?></td>
                                       <td>
                                         <p><?php echo $date; ?></p>
                                      </td>
                                      <td>
                                         <p>
										 	Transfer from <?php echo $from_account_name; ?> to <?php echo $to_account_name; ?> 
                                         </p>
                                      </td>
									  <td>
                                          <?php echo $amount; ?>
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
                                  No approved transfer
                              </div>

                  <?php } ?>

              </div>
			  
			  <div id="rejected_transfers" class="tab-pane fade">

                   <?php if(count($rejected_transfers) > 0){ ?>

                      <table class="table">
                        <thead>
                              <tr>
                                   <th></th>

                                   <th>Date</th>

                                   <th>Description</th>
								   <th>Amount</th>
                                   <th></th>
							</tr>
                        </thead>
                        <tbody class="payments-body">
                            <?php 
                                $j=1;
                                for($i=0; $i < count($rejected_transfers); $i++) {
									$rejected_transfer = explode('^',$rejected_transfers[$i]);
									$from_account_name = $rejected_transfer[0];
									$to_account_name = $rejected_transfer[1];
									$from_account_id = $rejected_transfer[2];
									$to_account_string = $rejected_transfer[3];
									$amount = $rejected_transfer[4]; 
									$reference_number = $rejected_transfer[5];
									$description = $rejected_transfer[6];
									$date = $rejected_transfer[7];
									$parent_id = $rejected_transfer[8];
									$id = $rejected_transfer[10];
																		
                             ?>
                                  <tr>  
                                      <td><?php echo $j; ?></td>
                                       <td>
                                         <p><?php echo $date; ?></p>
                                      </td>
                                      <td>
                                         <p>
										 	Transfer from <?php echo $from_account_name; ?> to <?php echo $to_account_name; ?> 
                                         </p>
                                      </td>
									  <td>
                                          <?php echo $amount; ?>
                                      </td>
                                      <td>
									  <?php
									  $url = base_url().'accounts/transfercash/'.$from_account_id.'/'.$parent_id.'/1/?payee='.$to_account_string.'&amount='.$amount.'&reference_num='.$reference_number.'&date='.$date.'&description='.$description.'&id='.$id;
									  ?>
                                       <button onclick="confirm_action('<?php echo $url; ?>','Transfer of Ksh. <?php echo $amount ?> from <?php echo $from_account_name; ?> to <?php echo $to_account_name; ?>','APPROVE')">Approve</button>
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
                                  No rejected transfer
                              </div>

                  <?php } ?>

              </div>

        </div>
    </div>
</div>
<script type="text/javascript" language="javascript">
	function confirm_action(url,description,action){
		if (confirm('Are you sure you want to '+action+' '+description+'?')) {
			window.location.href=url;
		}
	}
</script>