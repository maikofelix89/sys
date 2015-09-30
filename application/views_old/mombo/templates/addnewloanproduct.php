<div class="header">
        
         <h1 class="page-title">Add New Loan Product</h1> 

</div>
        
        <ul class="breadcrumb">

            <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>

             <li><a href="<?php echo base_url();?>loans/loanproducts/">Loan Products</a> <span class="divider">/</span></li>

            <li class="active"> Add New Product</li>

        </ul>

<div class="container-fluid">

  <div class="row-fluid">
    
    <div class="btn-toolbar">

        <div class="btn-group">
          
            <a href="<?php echo base_url();?>loans/loanproducts/"  class="btn <?php if($criteria  == 'all') echo 'btn-primary';?> ?>">All Products</a>

        </div>

        <div class="btn-group pull-right">

            <a href="<?php echo base_url().'loans/addnewproduct/';?>" class="btn btn-success"><i class="icon-plus"></i>New Product</a>

            <a href="<?php echo base_url().'loans/exportimport/';?>" class="btn">Import & Export Products</a>

        </div>

    </div>

    <?php if(isset($message) && $message){ ?>

        <div class="alert alert-warning">

            <button type="button" class="close" data-dismiss="alert">×</button>

            <?php echo $message;?>

        </div>

    <?php } ?>

    <div >

          <h4 class="btn-primary btn-large" style="margin-bottom:-4px;">Add Product</h4>

          <form id="add-account-form" name="add_account_form" method="POST" action="<?php echo base_url().'loans/addnewproduct/'; ?>" class="form-horizontal well">

              <legend>Basic</legend> 

              <div class="control-group <?php if(array_key_exists('loan_product_name', $errors)) echo 'error'; ?>">

                  <label class="control-label" for="product[loan_product_name]">Product Name</label>

                  <div class="controls">

                      <input type="text" name="product[loan_product_name]" value="<?php echo $product->loan_product_name; ?>" class="input-xxlarge" placeholder="e.g Emergency Loan"/>

                      <?php if(array_key_exists('loan_product_name', $errors)){ ?> <span class="help-inline"> <?php echo $errors['loan_product_name']; ?> </span> <?php } ?>

                  </div>

              </div>

              <div class="control-group <?php if(array_key_exists('interest_type', $errors)) echo 'error'; ?>">

                  <label class="control-label" for="product[interest_type]">Interest Type</label>

                  <div class="controls">

                      <label class="radio inline">

                        <input type="radio" name="product[interest_type]" id="optionsRadios1" value="simple" <?php if(strtolower($product->interest_type) == 'simple') echo 'checked="checked"'?> > Simple

                      </label>

                      <label class="radio inline">

                        <input type="radio" name="product[interest_type]" id="optionsRadios2" value="compound"  <?php if(strtolower($product->interest_type) == 'compound') echo 'checked="checked"'?>> Compound

                      </label>

                      <?php if(array_key_exists('interest_type', $errors)){ ?> <span class="help-inline"> <?php echo $errors['interest_type']; ?> </span> <?php } ?>

                  </div>

             </div>

             <div class="control-group <?php if(array_key_exists('interest_rate', $errors)) echo 'error'; ?>">

                  <label class="control-label" for="product[interest_rate]">Interest Rate</label>

                  <div class="controls">

                      <input type="text" name="product[interest_rate]" value="<?php echo $product->interest_rate; ?>" class="input-xxlarge" placeholder="e.g 25"/>

                      <?php if(array_key_exists('interest_rate', $errors)){ ?> <span class="help-inline"> <?php echo $errors['interest_rate']; ?> </span> <?php } ?>

                  </div>

              </div>


              <div class="control-group <?php if(array_key_exists('minimum_amount_loaned', $errors)) echo 'error'; ?>">

                  <label class="control-label" for="product[minimum_amount_loaned]">Minimum Loan Amount</label>

                  <div class="controls">

                      <input type="text" name="product[minimum_amount_loaned]" value="<?php echo $product->minimum_amount_loaned; ?>" class="input-xxlarge" placeholder="e.g 1500"/>

                      <?php if(array_key_exists('minimum_amount_loaned', $errors)){ ?> <span class="help-inline"> <?php echo $errors['minimum_amount_loaned']; ?> </span> <?php } ?>

                  </div>

              </div>

              <div class="control-group <?php if(array_key_exists('maximum_amount_loaned', $errors)) echo 'error'; ?>">

                  <label class="control-label" for="product[maximum_amount_loaned]">Maximum Loan Amount</label>

                  <div class="controls">

                      <input type="text" name="product[maximum_amount_loaned]" value="<?php echo $product->maximum_amount_loaned; ?>" class="input-xxlarge" placeholder="e.g 2500"/>

                      <?php if(array_key_exists('maximum_amount_loaned', $errors)){ ?> <span class="help-inline"> <?php echo $errors['maximum_amount_loaned']; ?> </span> <?php } ?>

                  </div>

              </div>

              <div class="control-group <?php if(array_key_exists('minimum_duration', $errors)) echo 'error'; ?>">

                  <label class="control-label" for="product[minimum_duration]">Minimum Duration</label>

                  <div class="controls">

                      <input type="text" name="product[minimum_duration]" value="<?php echo $product->minimum_duration; ?>" class="input-xxlarge" placeholder="e.g 1"/>

                      <?php if(array_key_exists('minimum_duration', $errors)){ ?> <span class="help-inline"> <?php echo $errors['minimum_duration']; ?> </span> <?php } ?>

                  </div>

              </div>

              <div class="control-group <?php if(array_key_exists('maximum_duration', $errors)) echo 'error'; ?>">

                  <label class="control-label" for="product[maximum_duration]">Maximum Duration</label>

                  <div class="controls">

                      <input type="text" name="product[maximum_duration]" value="<?php echo $product->maximum_duration; ?>" class="input-xxlarge" placeholder="e.g 3"/>

                      <?php if(array_key_exists('maximum_duration', $errors)){ ?> <span class="help-inline"> <?php echo $errors['maximum_duration']; ?> </span> <?php } ?>

                  </div>

              </div>

               <div class="control-group <?php if(array_key_exists('loan_repayment_frequency', $errors)) echo 'error'; ?>">

                  <label class="control-label" for="product[loan_repayment_frequency]">Loan Repayment Frequency</label>

                  <div class="controls">

                      <select name="product[loan_repayment_frequency]" class="input-xxlarge" placeholder="e.g 3">
					        
							 
							  <option value="">Select Frequency</option>

                              <option value="weekly" <?php if($product->loan_repayment_frequency == 'weekly'){ echo ' selected="selected"'; } ?> >Weekly</option>

							  <option value="monthly" <?php if($product->loan_repayment_frequency == 'monthly'){ echo ' selected="selected"'; } ?> >Monthly</option>
							  
							  <option value="per-two-months" <?php if($product->loan_repayment_frequency == 'per-two-months'){ echo ' selected="selected"'; } ?> >Two Months</option>
								
							  <option value="per-three-months" <?php if($product->loan_repayment_frequency == 'per-three-months'){ echo ' selected="selected"'; } ?> >Three Months</option>
							  
							  <option value="quarterly" <?php if($product->loan_repayment_frequency == 'quarterly'){ echo ' selected="selected"'; } ?> >Quarterly</option>
							  
							  <option value="per-five-months" <?php if($product->loan_repayment_frequency == 'per-five-months'){ echo ' selected="selected"'; } ?> >Five Months</option>
							  
							  <option value="twice-annually" <?php if($product->loan_repayment_frequency == 'twice-annually'){ echo ' selected="selected"'; } ?> >Twice a Year</option>

							  <option value="annually" <?php if($product->loan_repayment_frequency == 'annually'){ echo ' selected="selected"'; } ?> >Annually</option>

                      </select>

                      <?php if(array_key_exists('loan_repayment_frequency', $errors)){ ?> <span class="help-inline"> <?php echo $errors['loan_repayment_frequency']; ?> </span> <?php } ?>

                  </div>

              </div>

              <div class="control-group <?php if(array_key_exists('loan_product_description', $errors)) echo 'error'; ?>">

                  <label class="control-label" for="product[loan_product_description]">Loan Product Description</label>

                  <div class="controls">

                      <textarea name="product[loan_product_description]" class="input-xxlarge" style="height:200px;"><?php echo $product->loan_product_description; ?></textarea>

                      <?php if(array_key_exists('loan_product_description', $errors)){ ?> <span class="help-inline"> <?php echo $errors['loan_product_description']; ?> </span> <?php } ?>

                  </div>

              </div>

              <legend>Charges & Penalties</legend>

              <div class="control-group" id="product-charges">

                      <label class="control-label">Transactional Fee</label>

                      <div class="controls">

                            <ul class="nav nav-tabs">

                                    <li class="active"><a href="#tf_exact" data-toggle="tab">Minimum Amount</a></li>

                                    <li><a href="#tf_interms" data-toggle="tab">In Terms Of (If Greater)</a></li>

                            </ul>

                            <div class="tab-content">

                                    <div class="tab-pane active in" id="tf_exact">

                                          <input type="text" name="product[transaction_fee_exact]" value="<?php echo $product->transaction_fee_exact; ?>" placeholder="e.g 6000"/>

                                           <?php if(array_key_exists('transaction_fee_exact', $errors)){ ?> <span class="help-inline"> <?php echo $errors['transaction_fee_exact']; ?> </span> <?php } ?>

                                    </div>

                                    <div class="tab-pane fade" id="tf_interms">

                                          <label>Select Item</label>

                                          <select name="product[transaction_fee_interms]">
                                                
                                                <option value="principle"  <?php if($product->transaction_fee_interms == 'principle'){ echo ' selected="selected"'; } ?> >Principle</option>

                                                <option value="loan_total"  <?php if($product->transaction_fee_interms == 'loan_total'){ echo ' selected="selected"'; } ?> >Loan Total Amount</option>

                                                <option value="installment_amount"  <?php if($product->transaction_fee_interms == 'installment_amount'){ echo ' selected="selected"'; } ?> >Installment</option>

                                                <option value="interest_amount"  <?php if($product->transaction_fee_interms == 'interest_amount'){ echo ' selected="selected"'; } ?> >Interest Amount</option>

                                                <option value="loan_balance"  <?php if($product->transaction_fee_interms == 'loan_balance'){ echo ' selected="selected"'; } ?> >Loan Balance</option>

                                                <option value="loan_maximum_loaned"  <?php if($product->transaction_fee_interms == 'loan_maximum_loaned'){ echo ' selected="selected"'; } ?> >Maximum Amount Loaned</option>

                                                <option value="loan_minimum_loaned"  <?php if($product->transaction_fee_interms == 'loan_minimum_loaned'){ echo ' selected="selected"'; } ?> >Minimum Amount Loaned</option>

                                          </select>

                                           <?php if(array_key_exists('transaction_fee_interms', $errors)){ ?> <span class="help-inline"> <?php echo $errors['transaction_fee_interms']; ?> </span> <?php } ?>

                                          <label>Percentage</label>

                                          <input type="type" name="product[transaction_fee_percent]" value="<?php echo $product->transaction_fee_percent;?>" placeholder="e.g 5" />

                                           <?php if(array_key_exists('transaction_fee_percent', $errors)){ ?> <span class="help-inline"> <?php echo $errors['transaction_fee_percent']; ?> </span> <?php } ?>

                                    </div>

                            </div>

                      </div>

              </div>



              <legend></legend>



              <div class="control-group" id="product-charges">

                      <label class="control-label">Service Fees</label>

                      <div class="controls">

                             <ul class="nav nav-tabs">

                                    <li class="active"><a href="#sf_exact" data-toggle="tab">Minimum Amount</a></li>

                                    <li><a href="#sf_interms" data-toggle="tab">In Terms Of (If Greater)</a></li>

                            </ul>

                            <div class="tab-content">

                                    <div class="tab-pane active in" id="sf_exact">

                                          <input type="text" name="product[loan_service_fee_exact]" value="<?php echo $product->loan_service_fee_exact; ?>" placeholder="e.g 6000">

                                          <?php if(array_key_exists('loan_service_fee_exact', $errors)){ ?> <span class="help-inline"> <?php echo $errors['loan_service_fee_exact']; ?> </span> <?php } ?>

                                    </div>

                                    <div class="tab-pane fade" id="sf_interms">

                                          <label>Select Item</label>

                                          <select name="product[loan_service_fee_interms]">
                                                
                                                <option value="principle"  <?php if($product->loan_service_fee_interms == 'principle'){ echo ' selected="selected"'; } ?> >Principle</option>

                                                <option value="loan_total" <?php if($product->loan_service_fee_interms == 'loan_total'){ echo ' selected="selected"'; } ?>>Loan Total Amount</option>

                                                <option value="installment_amount" <?php if($product->loan_service_fee_interms == 'installment_amount'){ echo ' selected="selected"'; } ?>>Installment</option>

                                                <option value="interest_amount" <?php if($product->loan_service_fee_interms == 'interest_amount'){ echo ' selected="selected"'; } ?>>Interest Amount</option>

                                                <option value="loan_balance" <?php if($product->loan_service_fee_interms == 'loan_balance'){ echo ' selected="selected"'; } ?>>Loan Balance</option>

                                                <option value="loan_maximum_loaned" <?php if($product->loan_service_fee_interms == 'loan_maximum_loaned'){ echo ' selected="selected"'; } ?>>Maximum Amount Loaned</option>

                                                <option value="loan_minimum_loaned" <?php if($product->loan_service_fee_interms == 'loan_minimum_loaned'){ echo ' selected="selected"'; } ?>>Minimum Amount Loaned</option>

                                          </select>

                                           <?php if(array_key_exists('loan_service_fee_interms', $errors)){ ?> <span class="help-inline"> <?php echo $errors['loan_service_fee_interms']; ?> </span> <?php } ?>

                                          <label>Percentage</label>

                                          <input type="text" name="product[loan_service_fee_percent]" value="<?php echo $product->loan_service_fee_percent; ?>" placeholder="e.g 5" />

                                           <?php if(array_key_exists('loan_service_fee_percent', $errors)){ ?> <span class="help-inline"> <?php echo $errors['loan_service_fee_percent']; ?> </span> <?php } ?>

                                    </div>

                            </div>
                      
                      </div>

                       <div class="controls">

                            <label>Frequency</label>

                            <select name="product[loan_service_fee_frequency]">
							
							       
									<option value="">Select Frequency</option>

                                    <option value="weekly" <?php if($product->loan_service_fee_frequency == 'weekly'){ echo ' selected="selected"'; } ?> >Weekly</option>

                                    <option value="monthly" <?php if($product->loan_service_fee_frequency == 'monthly'){ echo ' selected="selected"'; } ?> >Monthly</option>

                                    <option value="annually" <?php if($product->loan_service_fee_frequency == 'annually'){ echo ' selected="selected"'; } ?> >Annually</option>
									
									 <option value="per-two-months" <?php if($product->loan_service_fee_frequency== 'per-two-months'){ echo ' selected="selected"'; } ?> >Two Months</option>
																
									  <option value="per-three-months" <?php if($product->loan_service_fee_frequency== 'per-three-months'){ echo ' selected="selected"'; } ?> >Three Months</option>
									  
									  <option value="quarterly" <?php if($product->loan_service_fee_frequency== 'quarterly'){ echo ' selected="selected"'; } ?> >Quarterly</option>
									  
									  <option value="per-five-months" <?php if($product->loan_service_fee_frequency== 'per-five-months'){ echo ' selected="selected"'; } ?> >Five Months</option>
									  
									  <option value="twice-annually" <?php if($product->loan_service_fee_frequency== 'twice-annually'){ echo ' selected="selected"'; } ?> >Twice a Year</option>

									  <option value="annually" <?php if($product->loan_service_fee_frequency== 'annually'){ echo ' selected="selected"'; } ?> >Annually</option>

                            </select>

                            <?php if(array_key_exists('loan_service_fee_frequency', $errors)){ ?> <span class="help-inline"> <?php echo $errors['loan_service_fee_frequency']; ?> </span> <?php } ?>

                      </div>

              </div>
			  
			  <legend></legend>
			  
			  
			  <div class="control-group" id="product-charges">

                                                <label class="control-label">Interest Charge</label>

                                                 <div class="controls">

                                                      <label>Frequency</label>

                                                      <select name="product[interest_fee_frequency]">
													  
													          <option value="">Select Frequency</option>
															  
						                                      <option value="None">None</option>

                                                              <option value="weekly" <?php if($product->interest_fee_frequency == 'weekly'){ echo ' selected="selected"'; } ?> >Weekly</option>

                                                              <option value="monthly" <?php if($product->interest_fee_frequency == 'monthly'){ echo ' selected="selected"'; } ?> >Monthly</option>
															  
															  <option value="per-two-months" <?php if($product->interest_fee_frequency == 'per-two-months'){ echo ' selected="selected"'; } ?> >Two Months</option>
																
															  <option value="per-three-months" <?php if($product->interest_fee_frequency == 'per-three-months'){ echo ' selected="selected"'; } ?> >Three Months</option>
															  
															  <option value="quarterly" <?php if($product->interest_fee_frequency == 'quarterly'){ echo ' selected="selected"'; } ?> >Quarterly</option>
															  
															  <option value="per-five-months" <?php if($product->interest_fee_frequency == 'per-five-months'){ echo ' selected="selected"'; } ?> >Five Months</option>
															  
															  <option value="twice-annually" <?php if($product->interest_fee_frequency == 'twice-annually'){ echo ' selected="selected"'; } ?> >Twice a Year</option>

                                                              <option value="annually" <?php if($product->interest_fee_frequency == 'annually'){ echo ' selected="selected"'; } ?> >Annually</option>

                                                      </select>

                                                      <?php if(array_key_exists('interest_fee_frequency', $errors)){ ?> <span class="help-inline"> <?php echo $errors['interest_fee_frequency']; ?> </span> <?php } ?>
													  
													  
														  <label>Percentage</label>

														  <input type="text" name="product[interest_fee_percent]" value="<?php echo $product->interest_fee_percent; ?>" placeholder="e.g 5" />

														   <?php if(array_key_exists('interest_fee_percent', $errors)){ ?> <span class="help-inline"> <?php echo $errors['interest_fee_percent']; ?> </span> <?php } ?>

                                                </div>

                                        </div>




              <legend></legend>



              <div class="control-group" id="product-charges">

                      <label class="control-label">Late Payment Penalty</label>

                      <div class="controls">

                             <ul class="nav nav-tabs">

                                    <li class="active"><a href="#lp_exact" data-toggle="tab">Minimum Amount</a></li>

                                    <li><a href="#lp_interms" data-toggle="tab">In Terms Of (If Greater)</a></li>

                            </ul>

                            <div class="tab-content">

                                    <div class="tab-pane active in" id="lp_exact">

                                          <input type="text" name="product[late_payment_fee_exact]" value="<?php echo $product->late_payment_fee_exact; ?>" placeholder="e.g 6000">
                                           
                                          <?php if(array_key_exists('late_payment_fee_exact', $errors)){ ?> <span class="help-inline"> <?php echo $errors['late_payment_fee_exact']; ?> </span> <?php } ?>

                                    </div>

                                    <div class="tab-pane fade" id="lp_interms">

                                          <label>Select Item</label>

                                          <select name="product[late_payment_fee_interms]">
                                              
                                                <option value="principle" <?php if($product->late_payment_fee_interms == 'principle'){ echo '  selected="selected"';} ?> >Principle</option>

                                                <option value="loan_total" <?php if($product->late_payment_fee_interms == 'loan_total'){ echo '  selected="selected"';} ?>>Loan Total Amount</option>

                                                <option value="installment_amount" <?php if($product->late_payment_fee_interms == 'installment_amount'){ echo '  selected="selected"';} ?>>Installment</option>

                                                <option value="interest_amount" <?php if($product->late_payment_fee_interms == 'interest_amount'){ echo '  selected="selected"';} ?>>Interest Amount</option>

                                                <option value="loan_balance" <?php if($product->late_payment_fee_interms == 'loan_balance'){ echo '  selected="selected"';} ?>>Loan Balance</option>

                                                <option value="loan_maximum_loaned" <?php if($product->late_payment_fee_interms == 'loan_maximum_loaned'){ echo '  selected="selected"';} ?>>Maximum Amount Loaned</option>

                                                <option value="loan_minimum_loaned" <?php if($product->late_payment_fee_interms == 'loan_minimum_loaned'){ echo '  selected="selected"';} ?>>Minimum Amount Loaned</option>

                                          </select>  

                                          <?php if(array_key_exists('late_payment_fee_interms', $errors)){ ?> <span class="help-inline"> <?php echo $errors['late_payment_fee_interms']; ?> </span> <?php } ?>

                                          <label>Percentage</label>

                                          <input type="type" name="product[late_payment_fee_percent]" value="<?php echo $product->late_payment_fee_percent; ?>" placeholder="e.g 5" />

                                          <?php if(array_key_exists('late_payment_fee_percent', $errors)){ ?> <span class="help-inline"> <?php echo $errors['late_payment_fee_percent']; ?> </span> <?php } ?>

                                    </div>

                            </div>
                      
                      </div>

                      <div class="controls">

                            <label>Frequency</label>

                            <select  name="product[late_payment_fee_frequency]">
							    
								        <option value="">Select Frequency</option>

                                       <option value="weekly" <?php if($product->late_payment_fee_frequency == 'weekly'){ echo ' selected="selected"'; }?>>Weekly</option>

                                       <option value="monthly" <?php if($product->late_payment_fee_frequency == 'monthly'){ echo ' selected="selected"'; }?>>Monthly</option>
									
									   <option value="per-two-months" <?php if($product->late_payment_fee_frequency == 'per-two-months'){ echo ' selected="selected"'; } ?> >Two Months</option>
																
									  <option value="per-three-months" <?php if($product->late_payment_fee_frequency == 'per-three-months'){ echo ' selected="selected"'; } ?> >Three Months</option>
									  
									  <option value="quarterly" <?php if($product->late_payment_fee_frequency == 'quarterly'){ echo ' selected="selected"'; } ?> >Quarterly</option>
									  
									  <option value="per-five-months" <?php if($product->late_payment_fee_frequency == 'per-five-months'){ echo ' selected="selected"'; } ?> >Five Months</option>
									  
									  <option value="twice-annually" <?php if($product->late_payment_fee_frequency == 'twice-annually'){ echo ' selected="selected"'; } ?> >Twice a Year</option>

									  <option value="annually" <?php if($product->late_payment_fee_frequency == 'annually'){ echo ' selected="selected"'; } ?> >Annually</option>
									
									

                            </select>  

                            <?php if(array_key_exists('late_payment_fee_frequency', $errors)){ ?> <span class="help-inline"> <?php echo $errors['late_payment_fee_frequency']; ?> </span> <?php } ?>

                      </div>

              </div>



              <legend></legend>



              <div class="control-group" id="product-charges">

                      <label class="control-label">Reschedulement Fee</label>

                      <div class="controls">

                           <ul class="nav nav-tabs">

                                    <li class="active"><a href="#rf_exact" data-toggle="tab">Minimum Amount</a></li>

                                    <li><a href="#rf_interms" data-toggle="tab">In Terms Of (If Greater)</a></li>

                            </ul>

                            <div class="tab-content">

                                    <div class="tab-pane active fade in" id="rf_exact">

                                          <input type="text" name="product[reschedulement_fee_exact]" value="<?php echo $product->reschedulement_fee_exact; ?>" placeholder="e.g 6000">

                                          <?php if(array_key_exists('reschedulement_fee_exact', $errors)){ ?> <span class="help-inline"> <?php echo $errors['reschedulement_fee_exact']; ?> </span> <?php } ?>

                                    

                                    </div>

                                    <div class="tab-pane fade" id="rf_interms">

                                          <label>Select Item</label>

                                          <select name="product[reschedulement_fee_interms]">

 										         <option value="">Select Frequency</option>
                                                
                                                <option value="principle" <?php if($product->reschedulement_fee_interms == 'principle'){ echo ' selected="selected"'; } ?>>Principle</option>

                                                <option value="loan_total" <?php if($product->reschedulement_fee_interms == 'loan_total'){ echo ' selected="selected"'; } ?>>Loan Total Amount</option>

                                                <option value="installment_amount" <?php if($product->reschedulement_fee_interms == 'installment_amount'){ echo ' selected="selected"'; } ?>>Installment</option>

                                                <option value="interest_amount" <?php if($product->reschedulement_fee_interms == 'interest_amount'){ echo ' selected="selected"'; } ?>>Interest Amount</option>

                                                <option value="loan_balance" <?php if($product->reschedulement_fee_interms == 'loan_balance'){ echo ' selected="selected"'; } ?>>Loan Balance</option>

                                                <option value="loan_maximum_loaned" <?php if($product->reschedulement_fee_interms == 'loan_maximum_loaned'){ echo ' selected="selected"'; } ?>>Maximum Amount Loaned</option>

                                                <option value="loan_minimum_loaned" <?php if($product->reschedulement_fee_interms == 'loan_minimum_loaned'){ echo ' selected="selected"'; } ?>>Minimum Amount Loaned</option>

                                          </select>

                                          <?php if(array_key_exists('reschedulement_fee_interms', $errors)){ ?> <span class="help-inline"> <?php echo $errors['reschedulement_fee_interms']; ?> </span> <?php } ?>


                                          <label>Percentage</label>

                                          <input type="type" name="product[reschedulement_fee_percent]" value="<?php echo $product->reschedulement_fee_percent; ?>" placeholder="e.g 5" />

                                          <?php if(array_key_exists('reschedulement_fee_percent', $errors)){ ?> <span class="help-inline"> <?php echo $errors['reschedulement_fee_percent']; ?> </span> <?php } ?>


                                    </div>

                            </div>
                      
                      </div>

              </div>

              <div class="control-group" id="product-charges"></div>

              <div class="control-group" id="product-charges"></div>

              <div class="control-group">

                <div class="controls">

                   <input type="submit" name="add_product" value="Add Product" class="btn btn-info btn-large input-xlarge"/>

                </div>

              </div>
          </form>

    </div>