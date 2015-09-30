<div class="header">
      <h1 class="page-title">Guarantor Details</h1>
</div>

<ul class="breadcrumb">
	<li>
	    <a href="<?php echo base_url().'mombo/mombo/home'; ?>">Home</a> 
	    <span class="divider">/</span>
	</li>
	<li>
	    <a href="<?php echo base_url().'gaurantors/'; ?>">Guarantors</a> 
	    <span class="divider">/</span>
	</li>
	<li class="active">Guarantor Details</li>
</ul>
<!--<div class="container-fluid">
<div class="row-fluid">-->

	<?php if(isset($message) && $message){ ?>

		<div class="alert alert-<?php echo $message_type; ?>">

			<button type="button" class="close" data-dismiss="alert">×</button>

			<?php echo $message;?>

		</div>

	<?php } ?>
	
	<script type="text/javascript">

		$(function(){

		     $('#dateOfBirth').datepicker({format:'yyyy-mm-dd'});

		});

	</script>

  <div class="well">
    <h3><?php echo ucwords(strtolower($gaurantor->name.' '.$gaurantor->other_names)); ?></h3>
	<div class="well">
	    <ul class="nav nav-tabs">
	      <li class="active">
	           <a href="#home" data-toggle="tab">Guarantor Details</a>
	      </li>
	      <li>
	           <a href="#profile" data-toggle="tab">Employment/Business Details</a>
	      </li>
	      <li>
	           <a href="#personal_statement" data-toggle="tab">Loans Gauranteed</a>
	      </li>
		  <li>
		      <a href="#sms" data-toggle="tab">Send SMS</a>
		  </li>
	      <?php if ($gaurantor->profilepic=='avator.png'){ ?>
			      <li>
			         <a href="#1" data-toggle="tab">Add Profile Picture</a>
			      </li>
		  <?php }else{ ?>
			      <li>
			         <a href="#1" data-toggle="tab">Update profile Pic</a>
			      </li>
		  <?php } ?>
		  <li>
		      <span data-toggle="tab"><a href="#edit_gaurantor_form" class="btn btn-info" data-toggle="tab" >Edit Details</a></span>
		  </li>
	    </ul>
	    <div id="myTabContent" class="tab-content">
	      <div class="tab-pane active in" id="home">
	           <table class="table">
	                  <tr>
		                    <td> 
		                      <label>First Name</label>
		                      <?php echo $gaurantor->name;?>
		                    </td>
		                    <td> 
		                       <label>Other Names</label>
		                      <?php echo $gaurantor->other_names;?>
		                    </td>
		                    <td> 
		                      <label>ID Number</label>
		                      <?php echo $gaurantor->idnumber;?>
		                    </td>
							<td> 
		                       <label>Date of Birth</label>
		                      <?php echo $gaurantor->dateOfBirth; ?>
		                    </td>
	                  </tr>
	                  <tr>
		                    <td> 
		                       <label>Email Address</label>
		                       <?php echo strtolower($gaurantor->email);?>
		                    </td>
		                    <td> 
		                       <label>Phone Number</label>
		                       <?php echo $gaurantor->mobile;?>
		                    </td>
		                    <td rowspan="2">
		                       <img  style="height:200px;width:200px;border:2px solid #a7a7a7;border-radius:2px;" src="<?php echo base_url()."/images/profilepics/$gaurantor->profilepic"; ?>" />
		                    </td>
	                  </tr>
	                  <tr>
		                    <td> 
		                       <label>Residential Area</label>
		                      <?php echo $gaurantor->residentialarea; ?>
		                    </td>
		                    <td> 
		                       <label>Estate</label>
		                      <?php echo $gaurantor->estate; ?>
		                    </td>
	                  </tr>
					  <tr>
		                    <td> 
		                       <label>House Number</label>
		                      <?php echo $gaurantor->houseno; ?>
		                    </td>
	                  </tr>
	         </table>
	      </div>
	      <div class="tab-pane fade" id="profile">
	           <table class="table">
	              <?php if($gaurantor->employer_name){ ?>
	                <tr>
	                    <th style="border:none;">Employment Details</th>
	                </tr>
	                <tr>
	                  <td> 
	                    <label>Employer Name</label>
	                    <?php echo $gaurantor->employer_name;?>
	                  </td>
	                  <td> 
	                     <label>Employer Phone</label>
	                    <?php echo $gaurantor->employer_tel;?>
	                   </td>
					   <td> 
	                     <label>Employer Location</label>
	                    <?php echo $gaurantor->employer_location;?>
	                   </td>
	                </tr>
	             <?php }
				 if($gaurantor->name_of_business){ ?>
					<tr>
	                    <th style="border:none;">Business Details</th>
	                </tr>
	                <tr>
	                  <td> 
	                    <label>Business Name</label>
	                    <?php echo $gaurantor->name_of_business;?>
	                  </td>
	                  <td> 
	                    <label>Business Address</label>
	                    <?php echo $gaurantor->business_address;?>
	                  </td>
	                </tr>
	                <tr>
	                  <td> 
	                    <label>Business Location</label>
	                    <?php echo $gaurantor->business_location;?>
	                  </td>
	                </tr>
                    <tr>
                       <td> 
	                     <label>Business Phone</label>
	                     <?php echo $gaurantor->business_tel; ?>
	                  </td>
					 </tr>
	             <?php } ?>
                 
	          </table>
	      </div>

	       <div class="tab-pane fade" id="loandetails">
	          <?php if($loans->num_rows() > 0 ){ ?>
		          <table class="table">
		            <thead>
		                <tr class="muted">
		                     <th>Amount of The Loan</th>
		                     <th>Loan Product</th>
		                     <th>Loan Balance</th>
		                     <th></th>
		                </tr>
		            </thead>
		            <tbody>
						<?php $total_bal = 0; ?>
			            <?php foreach($loans->result('loan_model') as $loan){ ?>
							<?php 
								$CI = & get_instance();
								$CI->load->model('loan_model','l_model');
						        $balance = $CI->l_model->get_balance_due($loan->id);
								$total_bal += $balance;
						        //echo "bal: ".$balance." here";
							?>
				            <tr>

				              <td> 

				                  <?php echo $loan->loan_principle_amount; ?>

				              </td>


				              <td> 
				                  
				                  <?php echo $loan->loan_product->loan_product_name; ?>

							  </td>
				              <td>
								<?php echo number_format($balance,2,'.',','); ?>				              	  				              
				              </td>
							  
							  <td>

                                  <?php if($loan->loan_status == 0 && $loan->request_status == 2){ ?>

                                      <a href="<?php echo base_url().'gaurantors/addcharge/?cust_id='.$gaurantor->id.'&loan_id='.$loan->id;?>" class="btn btn-info btn-small">Add Charge</a>

                                  <?php } ?>

				              </td>

				              <td>

                                  <?php if($loan->loan_status == 0 && $loan->request_status == 2){ ?>

                                      <a href="<?php echo base_url().'loans/makepayment/?loan_id='.$loan->id;?>" class="btn btn-info btn-small">Make Payment</a>

                                  <?php } ?>

				              </td>

				              <td>

				                 <?php if($loan->loan_status == 0 && $loan->request_status == 2){ ?>

				              		<a href="<?php echo base_url().'loans/loanpaymentsandcharges/?loan_id='.$loan->id;?>" class="btn btn-warning btn-small">Reschedule Payment</a>
                                 
                                 <?php } ?>

				              </td>

				              <td>

				                 <?php if($loan->request_status == 1){ ?>

				              		<a href="<?php echo base_url().'loans/acceptloan/?loan_id='.$loan->id;?>" class="btn btn-success btn-small">Accept</a>

				              		<a href="<?php echo base_url().'loans/rejectloan/?loan_id='.$loan->id;?>" class="btn btn-danger btn-small">Reject</a>
                                 
                                 <?php } ?>

				              </td>
				           </tr>
						   
				        <?php } ?>
						<tr>
					   		<td></td>
							<td style="font-style:bold;font-size:15px;color:purple">Total Balance Due</td>
							<td style="font-style:bold;font-size:15px;color:purple"><?php echo number_format($total_bal,2,'.',','); ?></td>
					   </tr> 
		           </tbody>   
		          </table>
		     <?php }else{ ?>

		            <div class="alert alert-info">
				        <button type="button" class="close" data-dismiss="alert">×</button>
				        No loans requested by this gaurantor
				    </div>

		     <?php  } ?>
	       </div>
		   <div class="tab-pane fade" id="sms">
			   <form method="post" action="<?php echo base_url().'gaurantors/sendsms/';?>">
			     <input type="hidden" name="gaurantor_id" value="<?php echo $gaurantor->id; ?>"/>
		         <h5> Name:</h5> <input type="text" class="span8" value="<?php echo ucwords(strtolower($gaurantor->name." ".$gaurantor->other_names)); ?>" name="name"		readonly>
				 <br>
				 <h5> Phone Number:</h5>  <input type="text" class="span8" name="PhoneNumber" value="<?php echo $gaurantor->mobile; ?>">
				 <br>
				 <h5> Message:</h5> <textarea class="span8" name="message"> </textarea>
				 <input type="hidden" name="cust" value="<?php echo $gaurantor->id; ?>">
				    <br>
				 <input type="submit" value="Send SMS" class="btn btn-default">
				</form>
	      </div>
	      <div class="tab-pane fade" id="personal_statement">
              <?php if($loans->num_rows() > 0 ){ ?>
					<table class="table">
						<thead>
							<tr class="muted">
								<th>Issue Date</th>
								<th>Loan Product</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
					

						</tbody>
						<tfoot>
							<?php foreach($loans->result('loan_model') as $loan){ ?>
							<tr>
								<td><?php echo $loan->loan_issue_date; ?></td>
								<td><a href="<?php echo base_url().'gaurantors/gaurantorloanstatement/'.$loan->id.'/'.$loan->customer->id.'/'.$gaurantor->id;?>"><?php echo $loan->loan_product->loan_product_name; ?></a></td>
								<td><?php echo ($loan->loan_status) ? 'Settled':'Unsettled'; ?></td>
							</tr>
							<?php } ?>
						</tfoot>
					</table>
				<?php }else{ ?>
                           <div class="alert alert-info">
						        <button type="button" class="close" data-dismiss="alert">×</button>
						        No loan found.
						    </div>
				<?php } ?>
	      </div>
		  
	      <div class="tab-pane fade" id="1">

		    <form id="tab" class="well" method="post" action="<?php echo base_url().'gaurantors/uploadpic/';?>" enctype="multipart/form-data">

			   <div class="control-group" style="width:505px;">

				   <h5>Current Profile Picture</h5>

				   <img style="height:150px;width:150px;border:2px solid #a7a7a7;border-radius:2px;" src="<?php echo base_url().'images/profilepics/'.$gaurantor->profilepic;?>" alt="<?php echo $gaurantor->name.' '.$gaurantor->other_names; ?>"/>
		      
		       </div>

		       <div class="control-group">

		          <div clas="controls">
		                 <input type="hidden" name="gaurantor_id" value="<?php echo $gaurantor->id; ?>" />

			             <div class="well" style="border:2px solid #a7a7a7;">

			                <input type="file" name="gaurantor_pic" id="file" class="input-xlarge">

			             </div>

		          		<input type="submit" class="btn btn-danger btn-large" value="Upload Pic"  name="upload_pic" class="input-xlarge">

		          </div>

		       </div>

		    </form>   

	      </div>
	      <div class="tab-pane fade" id="edit_gaurantor_form">

	           <?php
                    
                    $errors = array();

	           ?>
               
               <h4 class="btn-primary btn-large" style="margin-bottom:-4px;">Edit Guarantor</h4>
          
               <form class="well form-horizontal" id="edit-gaurantor-form" method="POST" action="<?php echo base_url().'gaurantors/updategaurantor/';?>">
               	      
               	     <input type="hidden" name="gaurantor[id]" value="<?php echo $gaurantor->id; ?>"/>
						  
						  <input type="hidden" name="gaurantor[status]" value="<?php echo $gaurantor->status; ?>"/>
						  
						  <input type="hidden" name="gaurantor[profilepic]" value="<?php echo $gaurantor->profilepic; ?>"/>
						  
						  <legend>Basic Details</legend>

						  <div class="control-group">

								<label class="control-label">Name</label>
								
								<div class="controls">

										<input type="text" name="gaurantor[name]" value="<?php echo $gaurantor->name;?>" class="input-xxlarge" />

										<?php if(array_key_exists('name',$errors)){ ?> <span class="inline-help error"><?php echo $errors['name']; ?></span> <?php } ?>
 
								</div>

						  </div>

						  <div class="control-group">

								<label class="control-label">Other Names</label>
								
								<div class="controls">

										<input type="text" name="gaurantor[other_names]" value="<?php echo $gaurantor->other_names;?>" class="input-xxlarge" />

										<?php if(array_key_exists('other_names',$errors)){ ?> <span class="inline-help error"><?php echo $errors['other_names']; ?></span> <?php } ?>

								</div>

						  </div>
						  
					<!--	  ////////here-->
						   <div class="control-group">

								<label class="control-label">Date of Birth</label>
								
								<div class="controls">

										<input type="text" id="dateOfBirth" name="gaurantor[dateOfBirth]" value="<?php echo $gaurantor->dateOfBirth;?>" class="input-xxlarge" />

										<?php if(array_key_exists('dateOfBirth',$errors)){ ?> <span class="inline-help error"><?php echo $errors['dateOfBirth']; ?></span> <?php } ?>

								</div>
							</div>
							<!--////////////////////////////////////////////////-->
						  
						   <div class="control-group">

								<label class="control-label">Email</label>
								
								<div class="controls">

										<input type="text" name="gaurantor[email]" value="<?php echo $gaurantor->email;?>" class="input-xxlarge" />

										<?php if(array_key_exists('email',$errors)){ ?> <span class="inline-help error"><?php echo $errors['email']; ?></span> <?php } ?>

								</div>

						  </div>
						  
						  <div class="control-group">

								<label class="control-label">Phone Number</label>
								
								<div class="controls">

										<input type="text" name="gaurantor[mobile]" value="<?php echo $gaurantor->mobile;?>" class="input-xxlarge" />

										<?php if(array_key_exists('mobile',$errors)){ ?> <span class="inline-help error"><?php echo $errors['mobile']; ?></span> <?php } ?>

								</div>

						  </div>
						  
						  <div class="control-group">

								<label class="control-label">ID/Passport Number</label>
								
								<div class="controls">

										<input type="text" name="gaurantor[idnumber]" value="<?php echo $gaurantor->idnumber;?>" class="input-xxlarge" />

										<?php if(array_key_exists('idnumber',$errors)){ ?> <span class="inline-help error"><?php echo $errors['idnumber'];?></span> <?php } ?>

								</div>

						  </div>
						  
						  <div class="control-group">

								<label class="control-label">Residential Area</label>
								
								<div class="controls">

										<input type="text" name="gaurantor[residentialarea]" value="<?php echo $gaurantor->residentialarea;?>" class="input-xxlarge" />

										<?php if(array_key_exists('residentialarea',$errors)){ ?> <span class="inline-help error"><?php echo $errors['residentialarea']; ?></span> <?php } ?>

								</div>

						  </div>
						  
						  <div class="control-group">

								<label class="control-label">Estate</label>
								
								<div class="controls">

										<input type="text" name="gaurantor[estate]" value="<?php echo $gaurantor->estate;?>" class="input-xxlarge" />

										<?php if(array_key_exists('estate',$errors)){ ?> <span class="inline-help error"><?php echo $errors['estate']; ?></span> <?php } ?>

								</div>

						  </div>
						  
						  <div class="control-group">

								<label class="control-label">House Number</label>
								
								<div class="controls">

										<input type="text" name="gaurantor[houseno]" value="<?php echo $gaurantor->houseno;?>" class="input-xxlarge" />

										<?php if(array_key_exists('houseno',$errors)){ ?> <span class="inline-help error"><?php echo $errors['houseno']; ?></span> <?php } ?>

								</div>

						  </div>
						  

						  <legend>Employment Details</legend>
						  
							<ul class="nav nav-tabs">
									<li class="active"><a data-toggle="tab" href="#cust-employed">Employment Details</a><li>
									<li><a data-toggle="tab" href="#cust-self-employed">Business Details</a><li>
							</ul>
							
							<div class="tab-content">
							
									<div id="cust-employed" class="tab-pane active">
									
										  <div class="control-group">

												<label class="control-label">Employer's Name</label>
												
												<div class="controls">

														<input type="text" name="gaurantor[employer_name]" value="<?php echo $gaurantor->employer_name;?>" class="input-xxlarge" />

														<?php if(array_key_exists('employer_name',$errors)){ ?> <span class="inline-help error"><?php echo $errors['employer_name']; ?></span> <?php } ?>

												</div>

										  </div>
										  
										  <div class="control-group">

												<label class="control-label">Employer's Location</label>
												
												<div class="controls">

														<input type="text" name="gaurantor[employer_location]" value="<?php echo $gaurantor->employer_location;?>" class="input-xxlarge" />

														<?php if(array_key_exists('employer_location',$errors)){ ?> <span class="inline-help error"><?php echo $errors['employer_location']; ?></span> <?php } ?>

												</div>

										  </div>
										  
										  <div class="control-group">

												<label class="control-label">Emloyer's Phone Number</label>
												
												<div class="controls">

														<input type="text" name="gaurantor[employer_tel]" value="<?php echo $gaurantor->employer_tel;?>" class="input-xxlarge" />

														<?php if(array_key_exists('employer_tel',$errors)){ ?> <span class="inline-help error"><?php echo $errors['employer_tel']; ?></span> <?php } ?>

												</div>

										  </div>
										  
									
									</div>
									
									<div id="cust-self-employed" class="tab-pane fade">
									
										   <div class="control-group">

												<label class="control-label">Name of Business</label>
												
												<div class="controls">

														<input type="text" name="gaurantor[name_of_business]" value="<?php echo $gaurantor->name_of_business;?>" class="input-xxlarge" />

														<?php if(array_key_exists('name_of_business',$errors)){ ?> <span class="inline-help error"><?php echo $errors['name_of_business']; ?></span> <?php } ?>

												</div>

										  </div>
										  
										  <div class="control-group">

												<label class="control-label">Business Address</label>
												
												<div class="controls">

														<input type="text" name="gaurantor[business_address]" value="<?php echo $gaurantor->business_address;?>" class="input-xxlarge" />

														<?php if(array_key_exists('business_address',$errors)){ ?> <span class="inline-help error"><?php echo $errors['business_address']; ?></span> <?php } ?>

												</div>

										  </div>
										  
										  <div class="control-group">

												<label class="control-label">Business Phone</label>
												
												<div class="controls">

														<input type="text" name="gaurantor[business_tel]" value="<?php echo $gaurantor->business_tel;?>" class="input-xxlarge" />

														<?php if(array_key_exists('business_tel',$errors)){ ?> <span class="inline-help error"><?php echo $errors['business_tel']; ?></span> <?php } ?>

												</div>

										  </div>
										  
										  <div class="control-group">

												<label class="control-label">Business Location</label>
												
												<div class="controls">

														<input type="text" name="gaurantor[business_location]" value="<?php echo $gaurantor->business_location;?>" class="input-xxlarge" />

														<?php if(array_key_exists('business_location',$errors)){ ?> <span class="inline-help error"><?php echo $errors['business_location']; ?></span> <?php } ?>

												</div>

										  </div>
										  
									
									</div>
							
							</div>
							
							<div class="control-group">

								<div class="controls">

										<input type="submit" name="update_gaurantor" value="Edit Guarantor" class="btn btn-info btn-large" />

								</div>

						  </div>

               </form>

	      </div>
	  </div>
      <a class="btn btn-success" href="<?php echo base_url().'gaurantors/';?>">&laquo;&nbsp;&nbsp;Back</a>
	</div>
</div>

	<div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		    <h3 id="myModalLabel">Delete Confirmation</h3>
		  </div>
		  <div class="modal-body">
		    
		    <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete the user?</p>
		  </div>
		  <div class="modal-footer">
		    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		    <button class="btn btn-danger" data-dismiss="modal">Delete</button>
		  </div>
	</div>