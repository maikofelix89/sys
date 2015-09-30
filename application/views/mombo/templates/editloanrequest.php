<script type="text/javascript">

	$(function(){

	     $('#dateOfBirth').datepicker({format:'yyyy-mm-dd'});

	});

</script>
<div class="header">
        
         <h1 class="page-title">Edit Loan Request</h1> 

</div>
        
        <ul class="breadcrumb">

            <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>

             <li><a href="<?php echo base_url();?>loans/loanrequests/">Loan Requests</a> <span class="divider">/</span></li>

            <li class="active"> Edit Request</li>

        </ul>

<div class="container-fluid">

  <div class="row-fluid">
    
    <div class="btn-toolbar">

       <div class="btn-group">

             <a href="<?php echo base_url();?>loans/loanrequests/"  class="btn <?php if($criteria == 'all'){ echo 'btn-primary'; } ?> ">

                    All Loan Requests

             </a>

              <a href="<?php echo base_url();?>loans/loanrequests/?criteria=new"  class="btn <?php if($criteria == 'new'){ echo 'btn-primary'; } ?> ">

                    New Loan Requests

             </a>

              <a href="<?php echo base_url();?>loans/loanrequests/?criteria=acc"  class="btn <?php if($criteria == 'acc'){ echo 'btn-primary'; }  ?> ">

                   Accepted Loan Requests

             </a>

              <a href="<?php echo base_url();?>loans/loanrequests/?criteria=den"  class="btn <?php if($criteria == 'den'){ echo 'btn-primary'; } ?> ">

                   Denied Loan Requests

             </a>
      </div>

      <div class="btn-group pull-right">

            <a href="<?php echo base_url().'loans/issueloan/';?>" class="btn btn-success"><i class="icon-plus"></i>Issue Loan</a>

            <a href="<?php echo base_url().'loans/exportimport/';?>" class="btn">Import & Export Requests</a>

      </div>

    </div>

    <?php if(isset($message) && $message){ ?>

        <div class="alert alert-warning">

            <button type="button" class="close" data-dismiss="alert">×</button>

            <?php echo $message;?>

        </div>

    <?php } ?>

    <div >

          <h4 class="btn-primary btn-large" style="margin-bottom:-4px;">Edit Product</h4>

          <form id="add-account-form" name="add_account_form" enctype="multipart/form-data" method="POST" action="<?php echo base_url().'loans/editloanrequest/'; ?>" class="form-horizontal well">

              <input type="hidden" name="request[id]" value="<?php echo $request->id; ?>">

              <input type="hidden" name="collateral[id]" value="<?php echo $collateral->id; ?>">

               <input type="hidden" name="collateral[loan]" value="<?php echo $request->id; ?>">

              <input type="hidden" name="request[loan_status]" value="<?php echo $request->loan_status; ?>">

              <input type="hidden" name="request[request_status]" value="<?php echo $request->request_status; ?>">

              <input type="hidden" name="request[transaction_code]" value="<?php echo $request->transaction_code; ?>">

              <input type="hidden" name="request[request_status]" value="<?php echo $request->request_status; ?>">

              <legend>Basic</legend>

              <div class="control-group">

                  <label class="control-label" for="request[customer]">Customer Name</label>

                  <div class="controls">

                      <input type="hidden" name="request[customer]" value="<?php echo $request->customer->id; ?>">

                      <input type="text" name="" disabled="disabled" class="input-xxlarge" value="<?php echo ucwords(strtolower($request->customer->name.' '.$request->customer->other_names)); ?>" />

                      <?php if(array_key_exists('customer', $errors)){ ?> 

                              <span class="help-inline"> 

                                <?php echo $errors['customer']; ?> 

                              </span> 

                      <?php } ?>

                  </div>

              </div>


             <div class="control-group">

                  <label class="control-label" for="request[loan_product]">Loan Product</label>

                  <div class="controls">

                      <input type="hidden" name="request[loan_product]" value="<?php echo $request->loan_product->id; ?>">

                      <input type="text" name="" disabled="disabled" class="input-xxlarge" value="<?php echo ucwords(strtolower($request->loan->loan_product->loan_product_name)); ?>" />

                     <?php if(array_key_exists('loan_product', $errors)){ ?> <span class="help-inline"> <?php echo $errors['loan_product']; ?> </span> <?php } ?>

                  </div>

              </div>


              <div class="control-group">

                  <label class="control-label" for="request[loan_principle_amount]">Loan Amount</label>

                  <div class="controls">

                      <input type="text" name="request[loan_principle_amount]" value="<?php echo $request->loan_principle_amount; ?>" class="input-xxlarge" placeholder="e.g 15000"/>

                      <?php if(array_key_exists('loan_principle_amount', $errors)){ ?> <span class="help-inline"> <?php echo $errors['loan_principle_amount']; ?> </span> <?php } ?>

                  </div>

              </div>
			  
			   <div class="control-group">

                  <label class="control-label" for="request[loan_principle_amount]">Installments Amount</label>

                  <div class="controls">

                      <input type="text" name="request[loan_principle_amount]" value="<?php echo $request->installment_amount; ?>" class="input-xxlarge" disabled="disabled"/><span> Per <?php echo ucwords(strtolower($request->loan_product->repayment_frequency_single));?></span>

                      <?php if(array_key_exists('loan_principle_amount', $errors)){ ?> <span class="help-inline"> <?php echo $errors['loan_principle_amount']; ?> </span> <?php } ?>

                  </div>

              </div>

              <div class="control-group">

                  <label class="control-label" for="request[loan_duration]">Loan Duration</label>

                  <div class="controls">

                      <input type="text" name="request[loan_duration]" value="<?php echo $request->loan_duration; ?>" class="input-xxlarge" placeholder="e.g 2"/><span> <?php echo ucwords(strtolower($request->loan_product->repayment_frequency_single));?>s</span>

                      <?php if(array_key_exists('loan_duration', $errors)){ ?> <span class="help-inline"> <?php echo $errors['loan_duration']; ?> </span> <?php } ?>

                  </div>

              </div>

              <legend>Collateral Details</legend>


              <div class="control-group">
			     
			     <input type="hidden" name="request[collateral]" value="<?php echo $request->collateral; ?>" />

                  <label class="control-label" for="collateral[name]">Collateral Name</label>

                  <div class="controls">

                      <input type="text" name="collateral[name]" value="<?php echo $collateral->name; ?>" class="input-xxlarge" 

                      <?php if(array_key_exists('name', $errors)){ ?> <span class="help-inline"> <?php echo $errors['name']; ?> </span> <?php } ?>

                  </div>

              </div>


              <div class="control-group">

                  <label class="control-label" for="collateral[description]">Collateral Description</label>

                  <div class="controls">

                      <textarea name="collateral[description]" class="input-xxlarge" style="height:300px;" placeholder="Description of collateral. Detail as much as possible" title="Description of collateral. Detail as much as possible"><?php echo $collateral->description; ?></textarea>

                      <?php if(array_key_exists('description', $errors)){ ?> <span class="help-inline"> <?php echo $errors['description']; ?> </span> <?php } ?>

                  </div>

              </div>

               <legend>Gaurantor Details</legend>


              <div class="control-group">
			  
			      <input type="hidden" name="request[gaurantor]" value="<?php echo $request->gaurantor; ?>" />
			  
			      <input type="hidden" name="gaurantor[id]" value="<?php echo $gaurantor->id; ?>" />
				  
				  <input type="hidden" name="gaurantor[loan]" value="<?php echo $request->id; ?>" />

                  <label class="control-label" for="">Gaurantor Name</label>

                  <div class="controls">

                      <input type="text" name="gaurantor[name]" value="<?php echo $gaurantor->name; ?>" class="input-xxlarge" />

                      <?php if(array_key_exists('name', $errors)){ ?> <span class="help-inline"> <?php echo $errors['name']; ?> </span> <?php } ?>

                  </div>

              </div>
			  
			  <div class="control-group">

                  <label class="control-label" for="">Gaurantor Other Names</label>

                  <div class="controls">

                      <input type="text" name="gaurantor[other_names]" value="<?php echo $gaurantor->other_names; ?>" class="input-xxlarge"/>

                      <?php if(array_key_exists('other_names', $errors)){ ?> <span class="help-inline"> <?php echo $errors['other_names']; ?> </span> <?php } ?>

                  </div>

              </div>
			  
			  <div class="control-group">

					<label class="control-label">Date of Birth</label>
					
					<div class="controls">

							<input type="text" id="dateOfBirth" name="gaurantor[dateOfBirth]" value="<?php echo $gaurantor->dateOfBirth;?>" class="input-xxlarge" />

							<?php if(array_key_exists('dateOfBirth',$errors)){ ?> <span class="help-inline"><?php echo $errors['dateOfBirth']; ?></span> <?php } ?>

					</div>
				</div>

               <div class="control-group">

                  <label class="control-label" for="gaurantor[email]">Email</label>

                  <div class="controls">

                      <input type="text" name="gaurantor[email]" value="<?php echo $gaurantor->email; ?>" class="input-xxlarge" />

                      <?php if(array_key_exists('email', $errors)){ ?> <span class="help-inline"> <?php echo $errors['email']; ?> </span> <?php } ?>

                  </div>

              </div>
               <div class="control-group">

                  <label class="control-label" for="gaurantor[mobile]">Mobile</label>

                  <div class="controls">

                      <input type="text" name="gaurantor[mobile]" value="<?php echo $gaurantor->mobile; ?>" class="input-xxlarge" />

                      <?php if(array_key_exists('mobile', $errors)){ ?> <span class="help-inline"> <?php echo $errors['mobile']; ?> </span> <?php } ?>

                  </div>

              </div>
                <div class="control-group">

                  <label class="control-label" for="gaurantor[residentialearea]">Residential Area</label>

                  <div class="controls">

                      <input type="text" name="gaurantor[residentialarea]" value="<?php echo $gaurantor->residentialarea; ?>" class="input-xxlarge" />

                      <?php if(array_key_exists('residentialarea', $errors)){ ?> <span class="help-inline"> <?php echo $errors['residentialarea']; ?> </span> <?php } ?>

                  </div>

              </div>
               <div class="control-group">

                  <label class="control-label" for="gaurantor[estate]">Estate</label>

                  <div class="controls">

                      <input type="text" name="gaurantor[estate]" value="<?php echo $gaurantor->estate; ?>" class="input-xxlarge" />

                      <?php if(array_key_exists('estate', $errors)){ ?> <span class="help-inline"> <?php echo $errors['estate']; ?> </span> <?php } ?>

                  </div>

              </div>
                <div class="control-group">

                  <label class="control-label" for="gaurantor[houseno]">House Number</label>

                  <div class="controls">

                      <input type="text" name="gaurantor[houseno]" value="<?php echo $gaurantor->houseno; ?>" class="input-xxlarge" />

                      <?php if(array_key_exists('houseno', $errors)){ ?> <span class="help-inline"> <?php echo $errors['houseno']; ?> </span> <?php } ?>

                  </div>

              </div>


              <div class="control-group">

                  <label class="control-label" for="gaurantor[idnumber]">Gaurantor National ID</label>

                  <div class="controls">

                      <input type="text" name="gaurantor[idnumber]" value="<?php echo $gaurantor->idnumber; ?>" class="input-xxlarge" />

                      <?php if(array_key_exists('idnumber', $errors)){ ?> <span class="help-inline"> <?php echo $errors['idnumber']; ?> </span> <?php } ?>

                  </div>

              </div>
			  
			  <div class="control-group">

                  <label class="control-label"> Employment Detials</label>

                  <div class="controls">

                           <ul class="nav nav-tabs">
						   
									<li class="active"><a data-toggle="tab" href="#employed">Employed</a></li>
									<li><a data-toggle="tab" href="#self-employed">Self Employment</a></li>
						   
						   </ul>
						   
						   <div class="tab-content">
						   
									<div id="employed" class="tab-pane active">
									
											 <div class="control-group">

												  <label class="control-label" for="gaurantor[employer_name]">Employer Name</label>

												  <div class="controls">

													  <input type="text" name="gaurantor[employer_name]" value="<?php echo $gaurantor->employer_name; ?>" class="input-xxlarge" />

													  <?php if(array_key_exists('employer_name', $errors)){ ?> <span class="help-inline"> <?php echo $errors['employer_name']; ?> </span> <?php } ?>

												  </div>

										    </div>
                         <div class="control-group">

                          <label class="control-label" for="gaurantor[employer_location]">Employer Location</label>

                          <div class="controls">

                            <input type="text" name="gaurantor[employer_location]" value="<?php echo $gaurantor->employer_location; ?>" class="input-xxlarge" />

                            <?php if(array_key_exists('employer_location', $errors)){ ?> <span class="help-inline"> <?php echo $errors['employer_location']; ?> </span> <?php } ?>

                          </div>

                        </div>
											
											 <div class="control-group">

												  <label class="control-label" for="gaurantor[employer_tel]">Employer Telephone</label>

												  <div class="controls">

													  <input type="text" name="gaurantor[employer_tel]" value="<?php echo $gaurantor->employer_tel; ?>" class="input-xxlarge" />

													  <?php if(array_key_exists('employer_tel', $errors)){ ?> <span class="help-inline"> <?php echo $errors['employer_tel']; ?> </span> <?php } ?>

												  </div>

										    </div>
									
									</div>
									
									<div id="self-employed" class="tab-pane fade">
									
											<div class="control-group">

												  <label class="control-label" for="gaurantor[name_of_business]">Business Name</label>

												  <div class="controls">

													  <input type="text" name="gaurantor[name_of_business]" value="<?php echo $gaurantor->name_of_business; ?>" class="input-xxlarge"/>

													  <?php if(array_key_exists('name_of_business', $errors)){ ?> <span class="help-inline"> <?php echo $errors['name_of_business']; ?> </span> <?php } ?>

												  </div>

										    </div>
											
											 <div class="control-group">

												  <label class="control-label" for="gaurantor[business_location]">Location of Business</label>

												  <div class="controls">

													  <input type="text" name="gaurantor[business_location]" value="<?php echo $gaurantor->business_location; ?>" class="input-xxlarge"/>

													  <?php if(array_key_exists('business_location', $errors)){ ?> <span class="help-inline"> <?php echo $errors['business_location']; ?> </span> <?php } ?>

												  </div>

										    </div>
											
											 <div class="control-group">

												  <label class="control-label" for="gaurantor[business_address]">Business Address</label>

												  <div class="controls">

													  <input type="text" name="gaurantor[business_address]" value="<?php echo $gaurantor->business_address; ?>" class="input-xxlarge" />

													  <?php if(array_key_exists('business_address', $errors)){ ?> <span class="help-inline"> <?php echo $errors['business_address']; ?> </span> <?php } ?>

												  </div>

										    </div>
									
									</div>
						   
						   </div>

                  </div>

              </div>

              <div class="control-group">

                  <div class="controls well" style="width:505px;">

                       <h6  for="request_gaurantorpic">Gaurantor Picture</h6>

                       <div class="well">

                              <img style="height:150px;width:150px;border:2px solid #a7a7a7;border-radius:2px;" src="<?php echo base_url().'images/profilepics/'.$gaurantor->profilepic;?>" alt="<?php echo $gaurantor->name; ?>"/>

                       </div>

                       <div class="well" style="border:2px solid #787878;">

                          <label for="request_gaurantorpic">Change Picture</label>

                          <input type="file" name="request_gaurantorpic" />

                          <?php if(array_key_exists('profilepic', $errors)){ ?> <span class="help-inline"> <?php echo $errors['profilepic']; ?> </span> <?php } ?>

                       </div>
                  </div>

              </div>

              <div class="control-group">

                <div class="controls">

                   <input type="submit" name="edit_request" value="Update Request" class="btn btn-info btn-large input-xlarge"/>

                </div>

              </div>
          </form>

    </div>