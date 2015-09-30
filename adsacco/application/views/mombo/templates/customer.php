<div class="header">
      <h1 class="page-title">Customer Details</h1>
</div>

<ul class="breadcrumb">
	<li>
	    <a href="<?php echo base_url().'mombo/mombo/home'; ?>">Home</a> 
	    <span class="divider">/</span>
	</li>
	<li>
	    <a href="<?php echo base_url().'customers/'; ?>">Customers</a> 
	    <span class="divider">/</span>
	</li>
	<li class="active">Customer Details</li>
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
    <h3><?php echo ucwords(strtolower($customer->name.' '.$customer->other_names)); ?></h3>
	<div class="well">
	    <ul class="nav nav-tabs">
	      <li class="active">
	           <a href="#home" data-toggle="tab">Customer Details</a>
	      </li>
	      <li>
	           <a href="#profile" data-toggle="tab">Employment Details</a>
	      </li>
	      <li>
	           <a href="#loandetails" data-toggle="tab">Loan Details</a>
	      </li>
		  <li>
		      <a href="#sms" data-toggle="tab">Send SMS</a>
		  </li>
		  <li>
		      <a href="#personal_statement" data-toggle="tab">Personal Statement</a>
		  </li>
	      <?php if ($customer->profilepic=='avator.png'){ ?>
			      <li>
			         <a href="#1" data-toggle="tab">Add Profile Picture</a>
			      </li>
		  <?php }else{ ?>
			      <li>
			         <a href="#1" data-toggle="tab">Update profile Pic</a>
			      </li>
		  <?php } ?>
		  <li>
		      <span data-toggle="tab"><a href="#edit_customer_form" class="btn btn-info" data-toggle="tab" >Edit Details</a></span>
		  </li>
	    </ul>
	    <div id="myTabContent" class="tab-content">
	      <div class="tab-pane active in" id="home">
	           <table class="table">
	                  <tr>
		                    <th> 
		                      <label>Loyalty Points</label>
		                      <?php echo (($customer->loyaltypoints) ?  $customer->loyaltypoints.' points' : '0 points' ) ; ?>
		                    </th>
		                   
	                  </tr>
	                  <tr>
		                    <td> 
		                      <label>First Name</label>
		                      <?php echo $customer->name;?>
		                    </td>
		                    <td> 
		                       <label>Other Name</label>
		                      <?php echo $customer->other_names;?>
		                    </td>
		                    <td> 
		                      <label>ID Number</label>
		                      <?php echo $customer->idnumber;?>
		                    </td>
							<td> 
		                       <label>Date of Birth</label>
		                      <?php echo $customer->dateOfBirth; ?>
		                    </td>
	                  </tr>
	                  <tr>
		                    <td> 
		                       <label>Email Address</label>
		                       <?php echo strtolower($customer->email);?>
		                    </td>
		                    <td> 
		                       <label>Phone Number</label>
		                       <?php echo $customer->mobiletel;?>
		                    </td>
		                    <td rowspan="2">
		                       <img  style="height:200px;width:200px;border:2px solid #a7a7a7;border-radius:2px;" src="<?php echo base_url()."/images/profilepics/$customer->profilepic"; ?>" />
		                    </td>
	                  </tr>
	                  <tr>
		                    <td> 
		                       <label>Postal Address</label>
		                      <?php echo 'P.O.BOX '.$customer->pobox; ?>
		                    </td>
		                    <td> 
		                       <label>Town</label>
		                      <?php echo $customer->town; ?>
		                    </td>
	                  </tr>
					  <tr>
		                    <td> 
		                       <label>Area</label>
		                      <?php echo $customer->area; ?>
		                    </td>
		                    <td> 
		                       <label>Estate</label>
		                      <?php echo $customer->estate; ?>
		                    </td>
	                  </tr>
					  <tr>
		                    <td> 
		                       <label>House Number</label>
		                      <?php echo $customer->houseno; ?>
		                    </td>
							<td> 
		                       <label>Street</label>
		                      <?php echo $customer->road_street; ?>
		                    </td>
		              </tr>
	         </table>
	      </div>
	      <div class="tab-pane fade" id="profile">
	           <table class="table">
	              <?php if($customer->employer_name){ ?>
	                <tr>
	                    <th style="border:none;">Employed</th>
	                </tr>
	                <tr>
	                  <td> 
	                    <label>Employer  Name</label>
	                    <?php echo $customer->employer_name;?>
	                  </td>
	                  <td> 
	                     <label>Date Employed</label>
	                    <?php echo $customer->dateemployed;?>
	                   </td>
	                </tr>
	                <tr>
	                  <td> 
	                    <label>Office Phone Number</label>
	                    <?php echo $customer->officetel;?>
	                  </td>
	                </tr>
	                <tr>
	                  <td> 
	                     <label>Physical Business Address</label>
	                     <?php echo $customer->officephysicallocation?>
	                  </td>
	                  <td> 
	                     <label>Town</label>
	                     <?php echo $customer->officephysicallocation;?>
	                  </td>
	                </tr>
	             <?php }else{ ?>
                    <tr>
	                    <th style="border:none;">Self Employed</th>
	                </tr>
	                <tr>
	                  <td> 
	                    <label>Business Name</label>
	                    <?php echo $customer->nameofbusiness;?>
	                  </td>
	                  <td> 
	                    <label>Industry</label>
	                    <?php echo $customer->industry;?>
	                  </td>
	                </tr>
	                <tr>
	                  <td> 
	                    <label>Phone Number</label>
	                    <?php echo $customer->mobiletel;?>
	                  </td>
	                </tr>
                    <tr>
                       <td> 
	                     <label>Physical Business Address</label>
	                     <?php echo $customer->physicalbusinessaddress; ?>
	                  </td>

	                  <td> 
	                     <label>Town</label>
	                      <?php echo $customer->town; ?>
	                  </td>
	             <?php } ?>
	               <td> 
	                     <label>Current Position</label>
	                      <?php echo $customer->currentposition; ?>
	                </td>
                  </tr>
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

                                      <a href="<?php echo base_url().'loans/makepayment/?loan_id='.$loan->id;?>" class="btn btn-info btn-small">Make Payment</a>

                                  <?php } ?>

				              </td>

				              <td>

				                 <?php if($loan->request_status == 2){ ?>

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
				        No loans requested by this customer
				    </div>

		     <?php  } ?>
	       </div>
		   <div class="tab-pane fade" id="sms">
			   <form method="post" action="<?php echo base_url().'customers/sendsms/';?>">
			     <input type="hidden" name="customer_id" value="<?php echo $customer->id; ?>"/>
		         <h5> Name:</h5> <input type="text" class="span8" value="<?php echo ucwords(strtolower($customer->name." ".$customer->other_names)); ?>" name="name"		readonly>
				 <br>
				 <h5> Phone Number:</h5>  <input type="text" class="span8" name="PhoneNumber" value="<?php echo $customer->mobiletel; ?>">
				 <br>
				 <h5> Message:</h5> <textarea class="span8" name="message"> </textarea>
				 <input type="hidden" name="cust" value="<?php echo $customer->id; ?>">
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
								<td><a href="<?php echo base_url().'customers/customerloanstatement/'.$loan->id.'/'.$loan->customer->id;?>"><?php echo $loan->loan_product->loan_product_name; ?></a></td>
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

		    <form id="tab" class="well" method="post" action="<?php echo base_url().'customers/uploadpic/';?>" enctype="multipart/form-data">

			   <div class="control-group" style="width:505px;">

				   <h5>Current Profile Picture</h5>

				   <img style="height:150px;width:150px;border:2px solid #a7a7a7;border-radius:2px;" src="<?php echo base_url().'images/profilepics/'.$customer->profilepic;?>" alt="<?php echo $customer->name.' '.$customer->other_names; ?>"/>
		      
		       </div>

		       <div class="control-group">

		          <div clas="controls">
		                 <input type="hidden" name="customer_id" value="<?php echo $customer->id; ?>" />

			             <div class="well" style="border:2px solid #a7a7a7;">

			                <input type="file" name="customer_pic" id="file" class="input-xlarge">

			             </div>

		          		<input type="submit" class="btn btn-danger btn-large" value="Upload Pic"  name="upload_pic" class="input-xlarge">

		          </div>

		       </div>

		    </form>   

	      </div>
	      <div class="tab-pane fade" id="edit_customer_form">

	           <?php
                    
                    $errors = array();

	           ?>
               
               <h4 class="btn-primary btn-large" style="margin-bottom:-4px;">Edit Account</h4>
          
               <form class="well form-horizontal" id="edit-customer-form" method="POST" action="<?php echo base_url().'customers/updatecustomer/';?>">
               	      
               	     <input type="hidden" name="customer[id]" value="<?php echo $customer->id; ?>"/>
						  
						  <input type="hidden" name="customer[status]" value="<?php echo $customer->status; ?>"/>
						  
						  <input type="hidden" name="customer[profilepic]" value="<?php echo $customer->profilepic; ?>"/>
						  
						  <input type="hidden" name="customer[password]" value="<?php echo $customer->password; ?>"/>
						  
						  <input type="hidden" name="customer[member_id]" value="<?php echo $customer->member_id; ?>"/>
						  
						  <input type="hidden" name="customer[loyaltypoints]" value="<?php echo $customer->loyaltypoints; ?>"/>
						  
						  <legend>Basic Details</legend>

						  <div class="control-group">

								<label class="control-label">Customer Name</label>
								
								<div class="controls">

										<input type="text" name="customer[name]" value="<?php echo $customer->name;?>" class="input-xxlarge" />

										<?php if(array_key_exists('name',$errors)){ ?> <span class="inline-help error"><?php echo $errors['name']; ?></span> <?php } ?>

								</div>

						  </div>

						  <div class="control-group">

								<label class="control-label">Customer Other Names</label>
								
								<div class="controls">

										<input type="text" name="customer[other_names]" value="<?php echo $customer->other_names;?>" class="input-xxlarge" />

										<?php if(array_key_exists('other_names',$errors)){ ?> <span class="inline-help error"><?php echo $errors['other_names']; ?></span> <?php } ?>

								</div>

						  </div>
						  
					<!--	  ////////here-->
						   <div class="control-group">

								<label class="control-label">Date of Birth</label>
								
								<div class="controls">

										<input type="text" id="dateOfBirth" name="customer[dateOfBirth]" value="<?php echo $customer->dateOfBirth;?>" class="input-xxlarge" />

										<?php if(array_key_exists('dateOfBirth',$errors)){ ?> <span class="inline-help error"><?php echo $errors['dateOfBirth']; ?></span> <?php } ?>

								</div>
							</div>
							<!--////////////////////////////////////////////////-->
						  
						   <div class="control-group">

								<label class="control-label">Email</label>
								
								<div class="controls">

										<input type="text" name="customer[email]" value="<?php echo $customer->email;?>" class="input-xxlarge" />

										<?php if(array_key_exists('email',$errors)){ ?> <span class="inline-help error"><?php echo $errors['email']; ?></span> <?php } ?>

								</div>

						  </div>
						  
						  <div class="control-group">

								<label class="control-label">Customer Mobile PhoneNumber</label>
								
								<div class="controls">

										<input type="text" name="customer[mobiletel]" value="<?php echo $customer->mobiletel;?>" class="input-xxlarge" />

										<?php if(array_key_exists('mobiletel',$errors)){ ?> <span class="inline-help error"><?php echo $errors['mobiletel']; ?></span> <?php } ?>

								</div>

						  </div>
						  
						  <div class="control-group">

								<label class="control-label">ID/Passport Number</label>
								
								<div class="controls">

										<input type="text" name="customer[idnumber]" value="<?php echo $customer->idnumber;?>" class="input-xxlarge" />

										<?php if(array_key_exists('idnumber',$errors)){ ?> <span class="inline-help error"><?php echo $errors['idnumber'];?></span> <?php } ?>

								</div>

						  </div>
						  
						  <div class="control-group">

								<label class="control-label">Town of Residence</label>
								
								<div class="controls">

										<input type="text" name="customer[town]" value="<?php echo $customer->town;?>" class="input-xxlarge" />

										<?php if(array_key_exists('town',$errors)){ ?> <span class="inline-help error"><?php echo $errors['town']; ?></span> <?php } ?>

								</div>

						  </div>
						  
						  <div class="control-group">

								<label class="control-label">Area of Residence</label>
								
								<div class="controls">

										<input type="text" name="customer[area]" value="<?php echo $customer->area;?>" class="input-xxlarge" />

										<?php if(array_key_exists('area',$errors)){ ?> <span class="inline-help error"><?php echo $errors['area']; ?></span> <?php } ?>

								</div>

						  </div>
						  
						  <div class="control-group">

								<label class="control-label">Estate</label>
								
								<div class="controls">

										<input type="text" name="customer[estate]" value="<?php echo $customer->estate;?>" class="input-xxlarge" />

										<?php if(array_key_exists('estate',$errors)){ ?> <span class="inline-help error"><?php echo $errors['estate']; ?></span> <?php } ?>

								</div>

						  </div>
						  
						  <div class="control-group">

								<label class="control-label">House Number</label>
								
								<div class="controls">

										<input type="text" name="customer[houseno]" value="<?php echo $customer->houseno;?>" class="input-xxlarge" />

										<?php if(array_key_exists('houseno',$errors)){ ?> <span class="inline-help error"><?php echo $errors['houseno']; ?></span> <?php } ?>

								</div>

						  </div>
						  
						  <div class="control-group">

								<label class="control-label">Road or Street</label>
								
								<div class="controls">

										<input type="text" name="customer[road_street]" value="<?php echo $customer->road_street;?>" class="input-xxlarge" />

										<?php if(array_key_exists('road_street',$errors)){ ?> <span class="inline-help error"><?php echo $errors['road_street']; ?></span> <?php } ?>

								</div>

						  </div>
						  
						  <div class="control-group">

								<label class="control-label">Postal Code</label>
								
								<div class="controls">

										<input type="text" name="customer[postal_code]" value="<?php echo $customer->postalcode;?>" class="input-xxlarge" />

										<?php if(array_key_exists('postalcode',$errors)){ ?> <span class="inline-help error"><?php echo $errors['postalcode']; ?></span> <?php } ?>

								</div>

						  </div>
						  
						  <div class="control-group">

								<label class="control-label">P.O.BOX </label>
								
								<div class="controls">

										<input type="text" name="customer[pobox]" value="<?php echo $customer->pobox;?>" class="input-xxlarge" />

										<?php if(array_key_exists('pobox',$errors)){ ?> <span class="inline-help error"><?php echo $errors['pobox']; ?></span> <?php } ?>

								</div>

						  </div>

						  <legend>Employment Details</legend>
						  
							<ul class="nav nav-tabs">
									<li class="active"><a data-toggle="tab" href="#cust-employed">Employement Details</a><li>
									<li><a data-toggle="tab" href="#cust-self-employed">Self Employement Details</a><li>
							</ul>
							
							<div class="tab-content">
							
									<div id="cust-employed" class="tab-pane active">
									
										  <div class="control-group">

												<label class="control-label">Employers Name</label>
												
												<div class="controls">

														<input type="text" name="customer[employer_name]" value="<?php echo $customer->employer_name;?>" class="input-xxlarge" />

														<?php if(array_key_exists('employer_name',$errors)){ ?> <span class="inline-help error"><?php echo $errors['employer_name']; ?></span> <?php } ?>

												</div>

										  </div>
										  
										  <div class="control-group">

												<label class="control-label">Employers Office Location</label>
												
												<div class="controls">

														<input type="text" name="customer[officephysicallocation]" value="<?php echo $customer->officephysicallocation;?>" class="input-xxlarge" />

														<?php if(array_key_exists('officephysicallocation',$errors)){ ?> <span class="inline-help error"><?php echo $errors['officephysicallocation']; ?></span> <?php } ?>

												</div>

										  </div>
										  
										  <div class="control-group">

												<label class="control-label">Office Telephone / Mobile</label>
												
												<div class="controls">

														<input type="text" name="customer[officetel]" value="<?php echo $customer->officetel;?>" class="input-xxlarge" />

														<?php if(array_key_exists('officetel',$errors)){ ?> <span class="inline-help error"><?php echo $errors['officetel']; ?></span> <?php } ?>

												</div>

										  </div>
										  
										  <div class="control-group">

												<label class="control-label">Year Employed</label>
												
												<div class="controls">

														<input type="text" name="customer[dateemployed]" value="<?php echo $customer->dateemployed;?>" class="input-xxlarge" />

														<?php if(array_key_exists('dateemployed',$errors)){ ?> <span class="inline-help error"><?php echo $errors['dateemployed']; ?></span> <?php } ?>

												</div>

										  </div>
										  
										  <div class="control-group">

												<label class="control-label">Current Position</label>
												
												<div class="controls">

														<input type="text" name="customer[currentposition]" value="<?php echo $customer->currentposition;?>" class="input-xxlarge" />

														<?php if(array_key_exists('currentposition',$errors)){ ?> <span class="inline-help error"><?php echo $errors['currentposition']; ?></span> <?php } ?>

												</div>

										  </div>
									
									</div>
									
									<div id="cust-self-employed" class="tab-pane fade">
									
										   <div class="control-group">

												<label class="control-label">Name of Business</label>
												
												<div class="controls">

														<input type="text" name="customer[nameofbusiness]" value="<?php echo $customer->nameofbusiness;?>" class="input-xxlarge" />

														<?php if(array_key_exists('nameofbusiness',$errors)){ ?> <span class="inline-help error"><?php echo $errors['nameofbusiness']; ?></span> <?php } ?>

												</div>

										  </div>
										  
										  <div class="control-group">

												<label class="control-label">Pysical Business Address</label>
												
												<div class="controls">

														<input type="text" name="customer[physicalbusinessaddress]" value="<?php echo $customer->physicalbusinessaddress;?>" class="input-xxlarge" />

														<?php if(array_key_exists('physicalbusinessaddress',$errors)){ ?> <span class="inline-help error"><?php echo $errors['physicalbusinessaddress']; ?></span> <?php } ?>

												</div>

										  </div>
										  
										  <div class="control-group">

												<label class="control-label">Industry</label>
												
												<div class="controls">

														<input type="text" name="customer[industry]" value="<?php echo $customer->industry;?>" class="input-xxlarge" />

														<?php if(array_key_exists('industry',$errors)){ ?> <span class="inline-help error"><?php echo $errors['industry']; ?></span> <?php } ?>

												</div>

										  </div>
									
									</div>
							
							</div>
							
							<div class="control-group">

								<div class="controls">

										<input type="submit" name="update_customer" value="Edit Customer" class="btn btn-info btn-large" />

								</div>

						  </div>

               </form>

	      </div>
	  </div>
      <a class="btn btn-success" href="<?php echo base_url().'customers/';?>">&laquo;&nbsp;&nbsp;Back</a>
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