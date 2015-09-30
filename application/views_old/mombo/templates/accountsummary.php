<div class="header">
        
         <h1 class="page-title">Account Summary</h1> 

</div>
        
        <ul class="breadcrumb">

            <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>

             <li><a href="<?php echo base_url();?>mombo/accounts/">Accounts</a> <span class="divider">/</span></li>

            <li class="active"> Account Summary </li>

        </ul>

<script type="text/javascript">

	$(function(){

	     $('#date').datepicker({format:'yyyy-mm-dd'});
		 $('#date1').datepicker({format:'yyyy-mm-dd'});

	});

</script>

<!--<div class="container-fluid">

  <div class="row-fluid">-->
    
    <div class="btn-toolbar">

        <div class="btn-group">
          
            <a href="<?php echo base_url();?>accounts/"  class="btn <?php if($criteria  == 'all') echo 'btn-primary';?> ?>">All Accounts</a>
            
            <a href="<?php echo base_url();?>accounts/?criteria=other"      class="btn <?php if($criteria == 'other') echo 'btn-primary';?> ?>">Main Accounts</a>
            
            <a href="<?php echo base_url();?>accounts/?criteria=expense"   class="btn <?php if($criteria == 'expense') echo 'btn-primary';?>">Expenditure Accounts</a>
            <a href="<?php echo base_url();?>accounts/?criteria=income"   class="btn <?php if($criteria == 'income') echo 'btn-primary';?>">Income Accounts</a>
        </div>

        <div class="btn-group pull-right">

            <a href="<?php echo base_url().'accounts/addaccount/';?>" class="btn btn-success"><i class="icon-plus"></i>Add Account</a>
			<a href="<?php echo base_url().'accounts/addsubaccount/';?>" class="btn btn-success"><i class="icon-plus"></i>Add Sub Account</a>

            <!-- <a href="<?php echo base_url().'accounts/exportimport/';?>" class="btn">Import & Export Records</a> -->

        </div>

    </div>
    
    <div class="well">

            <h4><?php echo $account->account_name; ?></h4>
			

            <div class="well">

                    <ul class="nav nav-tabs">

                              <li class="active">

                                   <a href="#details" data-toggle="tab">Account Details</a>

                              </li>

                              <li>
								   <?php 
								   	if($account->has_child == 0){
										echo '<a href="#transactions" data-toggle="tab">Transactions</a>';
									}
									else{
										echo '<a href="#subaccounts" data-toggle="tab">Sub Accounts</a>';
										
											$CI = & get_instance();

							                $CI->load->model('sub_account_model','sub_account');

							                $sub_accts = $CI->sub_account->get_sub_accounts($account->id);
											
									}
								   ?>
                                   

                              </li>

                              <li>
									<?php 
										if($account->id != 3){
											echo '<a href="#transfer" data-toggle="tab">Transfer</a>';
										}
									?>
                              </li>
							  
							 <!-- <li>
									<?php 
										if($account->id != 3){
											echo '<a href="#pending_transfers" data-toggle="tab">Pending Transfers</a>';
										}
									?>
                              </li>-->


                              <li>
									<?php 
										if($account->parent_id){
											echo '<span data-toggle="tab"><a href="#edit-sub-account-form" class="btn btn-info" data-toggle="tab" >Edit Sub Account Details</a></span>';
										}
										else{
													echo '<span data-toggle="tab"><a href="#edit-account-form" class="btn btn-info" data-toggle="tab" >Edit Account Details</a></span>';
										}
									?>
                                  
                              
                              </li>

                    </ul>

                    <div id="myTabContent" class="tab-content">

                             <style type="text/css">

                                    #details table th,

                                    #details table td{

                                        border:none;

                                    }

                             </style>

                              <div class="tab-pane active in" id="details">
									<?php echo $message; ?>
                                     <table class="table">

                                            <tbody>

                                                    <tr>

                                                            <th class="mute">Account Name</th>

                                                            <td><?php echo $account->account_name; ?></td>

                                                    </tr>

                                                    <tr>

                                                            <th class="mute">Opening Balance</th>

                                                            <td>Ksh <?php echo $account->account_opening_balance; ?></td>

                                                    </tr>

                                                    <tr>

                                                            <th class="mute">Account Balance</th>

                                                            <td>Ksh <?php echo $account->account_balance; ?></td>

                                                    </tr>
                                                
                                            </tbody>

                                     </table>

                              </div>

                              <div class="tab-pane fade" id="transactions">
										
                                    <?php if(count($transactions) > 0){ 
										$url = base_url().'accounts/accountsummary/';
									?>

                                    <form method="POST" action="<?php echo base_url().'accounts/accountsummary/'?>" id="trans-bulk-action" name="trans_bulk_action">
											<?php 
												if($account->id == 3){
													?>
														<select name="action" id="action" onchange="transfer_funds(<?php echo $account->id ?>,'<?php echo $url ?>')">
															<option value="0">--select action--</option>
			                                                <option value="1">Transfer to Chase Bank A/C</option>

			                                                <option value="2">Transfer to Cash A/C</option>
															<option value="17">Transfer to M-PESA A/C</option>

			                                            </select>
													<?php
												}
											?>
										    
                                        <table class="table">

                                                <thead>

                                                        <tr>

                                                                <th></th>

                                                                <th>Date</th>
																
                                                                <th>Description</th>
																<th>Ref. Number</th>
																
                                                                <th>Debit</th>
																<th>Credit</th>

                                                                <th>Account Balance</th>

                                                        </tr>
                                                    
                                                </thead>

                                                <tbody>

                                                        <?php for ($i = 0; $i < count($transactions); $i++) { 
															$transaction = explode('*',$transactions[$i]);
														?>

                                                                <tr>

                                                                    <td>

                                                                         <input type="checkbox" name="paymentCodes[]" value="<?php echo $transaction[0]; ?>" />

                                                                    </td>

                                                                    <td> <?php echo $transaction[1]; ?> </td>
																	
                                                                    <td> <?php echo $transaction[2]; ?> </td>
																	
																	<td> 
																	<?php 
																	 if($transaction[6] === '0')echo "-"; 
																	 else echo $transaction[6];
																	?> 
																	</td>
																	
                                                                    <td> 
																		<?php if($transaction[3] == 0){ 
																			echo $amounts[$transaction[0]]; 
																		}
																		?>
                                                                    </td>
																	<td> 
																		<?php if($transaction[3] == 1){ 
																			echo $amounts[$transaction[0]]; 
																			}
																		?>
                                                                    </td>

                                                                    <td> <?php echo $acct_bal[$transaction[0]];?> </td>

                                                                </tr>

                                                        <?php } ?>

                                                         <tr>

                                                            <td> </td>

                                                            <td> </td>

                                                            <td> </td>

                                                            <td> </td>

                                                            <th style="mute"> Opening Balance</th>

                                                            <th> <?php echo $account->account_opening_balance;?> </th>

                                                        </tr>

                                                        <tr>

                                                            <td> </td>

                                                            <td> </td>

                                                            <td> </td>

                                                            <td> </td>

                                                            <th style="mute"> Account Balance</th>

                                                            <th> <?php echo $account->account_balance;?> </th>

                                                        </tr>
                                            
                                                </tbody>

                                        </table>

                                    </form>

                                    <?php }else{ ?>
											  <?php 
													$url = base_url().'accounts/accountsummary/';
												?>

                                    <form method="POST" action="<?php echo base_url().'accounts/accountsummary/'?>" id="trans-bulk-action" name="trans_bulk_action">
											<?php 
												if($account->id == 3){
													?>
														<select name="action" id="action" onchange="transfer_funds(<?php echo $account->id ?>,'<?php echo $url ?>')">
															<option value="0">--select action--</option>
			                                                <option value="1">Transfer to Chase Bank A/C</option>

			                                                <option value="2">Transfer to Cash A/C</option>
															<option value="17">Transfer to M-PESA A/C</option>

			                                            </select>
													<?php
												}
											?>
											</form>
                                             <div class="alert alert-info ?>">

                                                    No recorded transactions for this account

                                             </div>

                                    <?php } ?>

                              </div>
							  
							  
							  <div class="tab-pane fade" id="subaccounts">
							  <h6>Sub Accounts</h6>
							  <?php 
							  	echo '<table>';
								echo '<tr>';
								echo '<th align="left">Name</th>';
								echo '<th align="right">Balance</th>';
								echo '</tr>';
						  		 foreach($sub_accts as $sub_account){
									//echo $sub_account['account_name'];
									?>
									<tr>
										<td align="left"><a href="<?php echo base_url().'accounts/accountsummary/?is_sub=1&sub_account_id='.$sub_account['id'];?>"><?php echo $sub_account['account_name']; ?>
									</a></td>
										<td align="right"><?php echo $sub_account['account_balance']; ?></td>
									</tr>
									
										
									<?php
								}
							  	echo '</table>';	
							  ?>
							 </div>
							  
							  
							  
							   <div class="tab-pane fade" id="transfer">

                                    <?php

                                        $CI = & get_instance();

                                        $CI->load->model('account_model','account');

                                        $accounts = $CI->account->findAll();
										
										$accts = $CI->account->find_accounts($account->id);
										
                                        $t_errors = array();

                                    ?>

                                    <?php if(isset($t_message)): ?>

                                             <div class="alert alert-<?php echo $t_message_type; ?>">

                                                    <button type="button" class="close" data-dismiss="alert">×</button>

                                                    <?php echo $t_message;?>

                                             </div>

                                    <?php endif; ?>
									
									<?php
										if($account->id == 1 || $account->parent_id == 4 || $account->parent_id == 12 || $account->parent_id == 18){  ?>
											<?php 
												if($account->id == 1){
													if( !($account->id == 1 && $account->parent_id > 0) ){
														?>
															<form id="transfer-form" name="transfer-form" method="POST" action="<?php echo base_url().'accounts/transfercash/'.$account->id; ?>">
														<?php
													}
													
												} 
												elseif($account->parent_id == 4){
													?>
													<form id="transfer-form" name="transfer-form" method="POST" action="<?php echo base_url().'accounts/transfercash/'.$account->id.'/'.$account->parent_id; ?>">
													<?php
												} 
												
												elseif($account->parent_id == 12){
													?>
													<form id="transfer-form" name="transfer-form" method="POST" action="<?php echo base_url().'accounts/transfercash/'.$account->id.'/'.$account->parent_id; ?>">
													<?php
												} 
												
												elseif($account->parent_id == 18){
													?>
													<form id="transfer-form" name="transfer-form" method="POST" action="<?php echo base_url().'accounts/transfercash/'.$account->id.'/'.$account->parent_id; ?>">
													<?php
												} 
											if( !($account->id == 1 && $account->parent_id > 0) ){
											?>
											
									    	<table>
												<tr>
													<td>Date:</td><td><input type="date" id="date" name="date" placeholder="YYYY-MM-DD" required=""/></td>
												</tr>
												<tr>
													<td>Pay:</td>
													<td>
														<select name="payee" id="payee" required="">
															<?php 
															echo "<option value=''>---Select Payee---</option>";
																foreach($accts as $acct){
																	if($acct['is_income'] == 1){
																		continue;
																	}
																	if($account->parent_id == 4 && $acct['id'] != 1 && $acct['id'] != 2){
																		continue;
																	} 
																	if($account->parent_id == 12 && $acct['id'] != 1 && $acct['id'] != 2){//mine 14
																		continue;
																	}
																	echo "<optgroup label='".$acct['account_name']."' rel='".$acct['account_name']."'>";
																	if($acct['has_child']){
																		$sub_accts = $CI->account->find_sub_accounts($acct['id']);
																		foreach($sub_accts as $sub_acct){
																			echo "<option value='c*".$sub_acct['id']."*".$acct['id']."'>".$sub_acct['account_name']."</option>";
																		}
																	}
																	else{
																		echo "<option value='p*".$acct['id']."'>".$acct['account_name']."</option>";
																	}
																	echo "</optgroup>";
																}
															?>
															
														</select>
													</td>
												</tr>
												<tr>
													<td>Kenya Shillings:</td><td><input type="number" name="amount" required=""/></td>
												</tr>
												<tr>
											<?php 
												if($account->id == 1){ 
													?>
													<td>Cheque Number:</td><td><input type="text" name="reference_num" required="" /></td>
													<?php
												}
												else{
													?>
													<td>Reference Number:</td><td><input type="text" name="reference_num" required="" /></td>
													<?php
												}
											?>
												</tr>
												<tr>
													<td>Description:</td><td><input type="text" name="description" required=""/></td>
												</tr>
												<tr><td></td><td><input type="submit" value="Transfer" name="transfer_from_bank"/></td></tr>
											</table>                                    

                                    		</form>
									<?php	}
											}
									?>
									
												<?php
										if($account->id == 2 || $account->id == 14 || $account->id == 15 || $account->id == 17 || $account->id == 18){ 
										
											if( !( ($account->id == 2 || $account->id == 14 || $account->id == 15 || $account->id == 17 || $account->id == 18) && $account->parent_id > 0) ){?>
											<form id="transfer-form1" name="transfer-form1" method="POST" action="<?php echo base_url().'accounts/transfercash/'.$account->id; ?>">				
									    	<table>
												<tr>
													<td>Date:</td><td><input type="date" id="date1" name="date" placeholder="YYYY-MM-DD" required=""/></td>
												</tr>
												<tr>
													<td>Pay:</td>
													<td>
														<select name="payee" id="payee" required="">
															<?php 
															echo "<option value=''>---Select Payee---</option>";
																foreach($accts as $acct){
																	if($acct['is_income'] == 1){
																		continue;
																	}
																	echo "<optgroup label='".$acct['account_name']."' rel='".$acct['account_name']."'>";
																	if($acct['has_child']){
																		$sub_accts = $CI->account->find_sub_accounts($acct['id']);
																		foreach($sub_accts as $sub_acct){
																			echo "<option value='c*".$sub_acct['id']."*".$acct['id']."'>".$sub_acct['account_name']."</option>";
																		}
																	}
																	else{
																		echo "<option value='p*".$acct['id']."'>".$acct['account_name']."</option>";
																	}
																	echo "</optgroup>";
																}
															?>
															
														</select>
													</td>
												</tr>
												<tr>
													<td>Kenya Shillings:</td><td><input type="number" name="amount" required=""/></td>
												</tr>
												<tr>
													<td>Reference Number:</td><td><input type="text" name="reference_num" required="" /></td>
												</tr>
												<tr>
													<td>Description:</td><td><input type="text" name="description" required=""/></td>
												</tr>
												<tr><td></td><td><input type="submit" value="Transfer" name="transfer_from_cash"/></td></tr>
											</table>                                    

                                    		</form>
									<?php	}}
									?>
                                    

                              </div>
							  
							  
							  <div class="tab-pane fade" id="pending_transfers">
							  	here
							  </div>
							  							  
							  

                              <div class="tab-pane fade" id="edit-account-form">

                                      <h4 class="btn-primary btn-large" style="margin-bottom:-4px;">Edit Account</h4>

                                      <?php $errors = array(); ?>

                                      <form id="add-account-form" name="add_account_form" method="POST" action="<?php echo base_url().'accounts/editaccount/'; ?>" class="form-horizontal well">
                                          
                                          <input type="hidden" name="account[id]" value="<?php echo $account->id; ?>" />

                                          <div class="control-group <?php if(array_key_exists('account_name', $errors)) echo 'error'; ?>">

                                              <label class="control-label" for="account[account_name]">Account</label>

                                              <div class="controls">

                                                  <input type="text" name="account[account_name]" value="<?php echo $account->account_name; ?>" class="input-xxlarge" required=""/>

                                                  <?php if(array_key_exists('account_name', $errors)){ ?> <span class="help-inline"> <?php echo $errors['account_name']; ?> </span> <?php } ?>

                                              </div>

                                          </div>

                                          <div class="control-group <?php if(array_key_exists('account_opening_balance', $errors)) echo 'error'; ?>">

                                              <label class="control-label" for="account[account_opening_balance]">Starting Balance</label>

                                              <div class="controls">

                                                  <input type="text" name="account[account_opening_balance]" value="<?php echo $account->account_opening_balance; ?>" placeholder="0.00" class="input-xxlarge" required=""/>

                                                   <?php if(array_key_exists('account_opening_balance', $errors)){ ?> <span class="help-inline"> <?php echo $errors['account_opening_balance']; ?> </span> <?php } ?>

                                              </div>

                                          </div>

                                          <div class="control-group <?php if(array_key_exists('account_balance', $errors)) echo 'error'; ?>">

                                              <label class="control-label" for="account[account_balance]">Account Balance</label>

                                              <div class="controls">

                                                  <input type="text" name="account[account_balance]" value="<?php echo $account->account_balance; ?>" placeholder="0.00" class="input-xxlarge" required=""/>

                                                   <?php if(array_key_exists('account_balance', $errors)){ ?> <span class="help-inline"> <?php echo $errors['account_balance']; ?> </span> <?php } ?>

                                              </div>

                                          </div>

                                          <div class="control-group <?php if(array_key_exists('account_desc', $errors)) echo 'error'; ?>">

                                              <label class="control-label" for="account[desc]">Account Description</label>

                                              <div class="controls">

                                                  <textarea name="account[account_desc]" class="input-xxlarge" style="height:200px;"><?php echo $account->account_desc; ?></textarea>

                                                  <?php if(array_key_exists('account_desc', $errors)){ ?> <span class="help-inline"> <?php echo $errors['account_desc']; ?> </span> <?php } ?>

                                              </div>

                                          </div>

                                          <div class="control-group">

                                              <label class="control-label" for="account[is_exp]">Is Expenditure Account</label>

                                              <div class="controls">

                                                  <label class="radio inline">
												  <?php
												  	if($account->is_exp){
														?>
														<input type="radio" name="account[is_exp]" id="optionsRadios1" value="1" checked> Yes
														<?php
													}
													else{
														?>
														<input type="radio" name="account[is_exp]" id="optionsRadios1" value="1" checked> Yes
														<?php
													}
													echo '</label>';
													echo ' <label class="radio inline">';
													if( ! $account->is_exp){
														?>
														<input type="radio" name="account[is_exp]" id="optionsRadios2" value="0" checked> No
														<?php
													}
													else{
														?>
														<input type="radio" name="account[is_exp]" id="optionsRadios2" value="0"> No
														<?php
													}
												  ?>
													</label>
                                                  <?php if(array_key_exists('is_exp', $errors)){ ?> <span class="help-inline"> <?php echo $errors['is_exp']; ?> </span> <?php } ?>

                                              </div>

                                          </div>
										  
										  <div class="control-group">

                                              <label class="control-label" for="account[is_income]">Is Income Account</label>
												 <div class="controls">

                                                  <label class="radio inline">
												  <?php
												  	if($account->is_income){
														?>
														<input type="radio" name="account[is_income]" id="optionsRadios1" value="1" checked> Yes
														<?php
													}
													else{
														?>
														<input type="radio" name="account[is_income]" id="optionsRadios1" value="1" checked> Yes
														<?php
													}
													echo '</label>';
													echo ' <label class="radio inline">';
													if( ! $account->is_income){
														?>
														<input type="radio" name="account[is_income]" id="optionsRadios2" value="0" checked> No
														<?php
													}
													else{
														?>
														<input type="radio" name="account[is_income]" id="optionsRadios2" value="0"> No
														<?php
													}
												  ?>
													</label>
                                                  <?php if(array_key_exists('is_income', $errors)){ ?> <span class="help-inline"> <?php echo $errors['is_income']; ?> </span> <?php } ?>

                                              </div>
										  </div>
										  
										  <div class="control-group">

                                              <label class="control-label" for="account[has_child]">Has Sub Account</label>

                                              <div class="controls">

                                                  <label class="radio inline">
												  <?php
												  	if($account->has_child){
														?>
														<input type="radio" name="account[has_child]" id="optionsRadios1s" value="1" checked> Yes
														<?php
													}
													else{
														?>
														<input type="radio" name="account[has_child]" id="optionsRadios1s" value="1" checked> Yes
														<?php
													}
													echo '</label>';
													echo ' <label class="radio inline">';
													if( ! $account->has_child){
														?>
														<input type="radio" name="account[has_child]" id="optionsRadios2s" value="0" checked> No
														<?php
													}
													else{
														?>
														<input type="radio" name="account[has_child]" id="optionsRadios2s" value="0"> No
														<?php
													}
												  ?>
													</label>
                                                  <?php if(array_key_exists('has_child', $errors)){ ?> <span class="help-inline"> <?php echo $errors['has_child']; ?> </span> <?php } ?>

                                              </div>

                                          </div>
										  

                                          <div class="control-group">

                                            <div class="controls">

                                               <input type="submit" name="update_account" value="Update Account" class="btn btn-info btn-large input-xlarge"/>

                                            </div>

                                          </div>

                                      </form>

                              </div>
							  
							  
							  
							  
							   <div class="tab-pane fade" id="edit-sub-account-form">
							   		<?php
										$CI = & get_instance();

                                        $CI->load->model('account_model','account');

                                        $parent_accounts = $CI->account->get_accounts();
									?>

                                      <h4 class="btn-primary btn-large" style="margin-bottom:-4px;">Edit Sub Account</h4>

                                      <?php $errors = array(); ?>

                                      <form id="add-sub-account-form" name="add_sub_account_form" method="POST" action="<?php echo base_url().'accounts/editaccount/'; ?>" class="form-horizontal well">
                                          
                                          <input type="hidden" name="sub_account[id]" value="<?php echo $account->id; ?>" />

                                          <div class="control-group <?php if(array_key_exists('account_name', $errors)) echo 'error'; ?>">

                                              <label class="control-label" for="sub_account[account_name]">Sub Account</label>

                                              <div class="controls">

                                                  <input type="text" name="sub_account[account_name]" value="<?php echo $account->account_name; ?>" class="input-xxlarge" required=""/>

                                                  <?php if(array_key_exists('account_name', $errors)){ ?> <span class="help-inline"> <?php echo $errors['account_name']; ?> </span> <?php } ?>

                                              </div>

                                          </div>
										  
										   <div class="control-group <?php if(array_key_exists('parent_id', $errors)) echo 'error'; ?>">

                                              <label class="control-label" for="sub_account[parent_id]">Parent Account</label>

                                              <div class="controls">										  
												  <select name="sub_account[parent_id]" id="parent" required="">
														<?php 
															foreach($parent_accounts as $parent){
																if($parent['has_child'] == 0){
																	continue;
																}
																if($parent['id'] == $account->parent_id){
																	echo "<option value='".$parent['id']."' selected=\"\">".$parent['account_name']."</option>";
																}
																else{
																	echo "<option value='".$parent['id']."'>".$parent['account_name']."</option>";
																}
																	
															}
														?>
													</select>
											</div>

                                          </div>
										  

                                          <div class="control-group <?php if(array_key_exists('account_opening_balance', $errors)) echo 'error'; ?>">

                                              <label class="control-label" for="sub_account[account_opening_balance]">Starting Balance</label>

                                              <div class="controls">

                                                  <input type="text" name="sub_account[account_opening_balance]" value="<?php echo $account->account_opening_balance; ?>" placeholder="0.00" class="input-xxlarge" required=""/>

                                                   <?php if(array_key_exists('account_opening_balance', $errors)){ ?> <span class="help-inline"> <?php echo $errors['account_opening_balance']; ?> </span> <?php } ?>

                                              </div>

                                          </div>

                                          <div class="control-group <?php if(array_key_exists('account_balance', $errors)) echo 'error'; ?>">

                                              <label class="control-label" for="sub_account[account_balance]">Account Balance</label>

                                              <div class="controls">

                                                  <input type="text" name="sub_account[account_balance]" value="<?php echo $account->account_balance; ?>" placeholder="0.00" class="input-xxlarge" required=""/>

                                                   <?php if(array_key_exists('account_balance', $errors)){ ?> <span class="help-inline"> <?php echo $errors['account_balance']; ?> </span> <?php } ?>

                                              </div>

                                          </div>

                                          <div class="control-group <?php if(array_key_exists('account_desc', $errors)) echo 'error'; ?>">

                                              <label class="control-label" for="sub_account[desc]">Account Description</label>

                                              <div class="controls">

                                                  <textarea name="sub_account[account_desc]" class="input-xxlarge" style="height:200px;"><?php echo $account->account_desc; ?></textarea>

                                                  <?php if(array_key_exists('account_desc', $errors)){ ?> <span class="help-inline"> <?php echo $errors['account_desc']; ?> </span> <?php } ?>

                                              </div>

                                          </div>

                                          <div class="control-group">

                                              <label class="control-label" for="sub_account[is_exp]">Is Expenditure Account</label>

                                              <div class="controls">

                                                   <label class="radio inline">
												  <?php
												  	if($account->is_exp){
														?>
														<input type="radio" name="sub_account[is_exp]" id="optionsRadios1" value="1" checked> Yes
														<?php
													}
													else{
														?>
														<input type="radio" name="sub_account[is_exp]" id="optionsRadios1" value="1" checked> Yes
														<?php
													}
													echo '</label>';
													echo ' <label class="radio inline">';
													if( ! $account->is_exp){
														?>
														<input type="radio" name="sub_account[is_exp]" id="optionsRadios2" value="0" checked> No
														<?php
													}
													else{
														?>
														<input type="radio" name="sub_account[is_exp]" id="optionsRadios2" value="0"> No
														<?php
													}
												  ?>
													</label>
                                                  <?php if(array_key_exists('is_exp', $errors)){ ?> <span class="help-inline"> <?php echo $errors['is_exp']; ?> </span> <?php } ?>

                                              </div>

                                          </div>
										  
										    <div class="control-group">

                                              <label class="control-label" for="sub_account[is_income]">Is Income Account</label>
												 <div class="controls">

                                                  <label class="radio inline">
												  <?php
												  	if($sub_account->is_income){
														?>
														<input type="radio" name="sub_account[is_income]" id="optionsRadios1" value="1" checked> Yes
														<?php
													}
													else{
														?>
														<input type="radio" name="sub_account[is_income]" id="optionsRadios1" value="1" checked> Yes
														<?php
													}
													echo '</label>';
													echo ' <label class="radio inline">';
													if( ! $sub_account->is_income){
														?>
														<input type="radio" name="sub_account[is_income]" id="optionsRadios2" value="0" checked> No
														<?php
													}
													else{
														?>
														<input type="radio" name="sub_account[is_income]" id="optionsRadios2" value="0"> No
														<?php
													}
												  ?>
													</label>
                                                  <?php if(array_key_exists('is_income', $errors)){ ?> <span class="help-inline"> <?php echo $errors['is_income']; ?> </span> <?php } ?>

                                              </div>
										  </div>

                                          <div class="control-group">

                                            <div class="controls">

                                               <input type="submit" name="update_sub_account" value="Update Sub Account" class="btn btn-info btn-large input-xlarge"/>

                                            </div>

                                          </div>

                                      </form>

                              </div>
							  
							  
							  

                    </div>
            </div>

            <a class="btn btn-success" href="<?php  echo last_page();  ?>" >&laquo;&nbsp;&nbsp;Back</a>
			<script language="javascript" type="text/javascript">
				function transfer_funds(account_id,url){
					var action = document.getElementById('action').value;
					if(action == 0){
						alert("Select action!");
					}
					else{
						if($("#transactions").find('input[type="checkbox"]').is(":checked")){
							var cboxes = document.getElementsByName('paymentCodes[]');
						    var len = cboxes.length;
							var rSelectedLen = 0;
							var codes = '';
							
						    for (var i=0; i<len; i++) {
								if(cboxes[i].checked){
									rSelectedLen++;
									codes += cboxes[i].value+',';
								}
						    }
							if(action > 0){
								if (confirm(rSelectedLen+' marked transactions will be transfered!')) {
									window.location.href=url+action+'/?account_id='+account_id+'&c='+codes;
								} else {
								    //alert("ddd");
								}
							}
							else if(action == "delete"){
								if (confirm(rSelectedLen+' marked transactions will be deleted!')) {
									alert('Still under development!');
								} else {
								    //alert("d");
								}
							}
						}
						else{
							alert("Select at least one transaction!");	
						}
					}
				}

			</script>
    </div>