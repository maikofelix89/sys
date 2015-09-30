<div class="header">
      <h1 class="page-title">Add Customer</h1>
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
	<li class="active">Add New Customer</li>
</ul>
<!--<div class="container-fluid">
<div class="row-fluid">-->

<script type="text/javascript">

	$(function(){

	     $('#dateOfBirth').datepicker({format:'yyyy-mm-dd'});

	});

</script>

<div class="btn-toolbar">
    <div class="btn-group">
      <a href="<?php echo base_url();?>customers/"  class="btn <?php if(isset($customer_type) && $customer_type == 'all') echo 'btn-primary';?> ?>">All Customers</a>
      <a href="<?php echo base_url();?>customers/?type=new"      class="btn <?php if(isset($customer_type) && $customer_type == 'new') echo 'btn-primary';?> ?>">New Customers</a>
      <a href="<?php echo base_url();?>customers/?type=active"   class="btn <?php if(isset($customer_type) && $customer_type == 'active') echo 'btn-primary';?>">Activated Customers</a>
      <a href="<?php echo base_url();?>customers/?type=inactive" class="btn <?php if(isset($customer_type) && $customer_type == 'inactive') echo 'btn-primary';?> ?>">Inactive Customers</a>
    </div>
    <div class="btn-group pull-right">
      <a href="<?php echo base_url().'customers/addnewcustomer/';?>" class="btn btn-success"><i class="icon-plus"></i> New Customer</a>
      <a href="<?php echo base_url().'customers/exportimport/';?>" class="btn">Import & Export Records</a>
    </div>
</div>

<?php if(isset($message) && $message){ ?>

	<div class="alert alert-<?php echo $message_type; ?>">

		<button type="button" class="close" data-dismiss="alert">×</button>

		<?php echo $message;?>

	</div>

<?php } ?>

 <div class="well">
	  <div id="edit-customer-form-cont">
				   <h4 class="btn-primary btn-large" style="margin-bottom:-4px;">Add Customer Account</h4>
			  
				   <form class="well form-horizontal" id="edit-customer-form" method="POST" action="<?php echo base_url().'customers/addnewcustomer/';?>">
						  
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
						  
						   <div class="control-group">

								<label class="control-label">Email</label>
								
								<div class="controls">

										<input type="text" name="customer[email]" value="<?php echo $customer->email;?>" class="input-xxlarge" />

										<?php if(array_key_exists('email',$errors)){ ?> <span class="inline-help error"><?php echo $errors['email']; ?></span> <?php } ?>

								</div>

						  </div>
						  
						  <div class="control-group">

								<label class="control-label">Customer Mobile Phone Number</label>
								
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

								<label class="control-label">Date of Birth</label>
								
								<div class="controls">

										<input type="text" id="dateOfBirth" placeholder="YYYY-MM-DD" name="customer[dateOfBirth]" value="<?php echo $customer->dateOfBirth;?>" class="input-xxlarge" />

										<?php if(array_key_exists('dateOfBirth',$errors)){ ?> <span class="inline-help error"><?php echo $errors['dateOfBirth']; ?></span> <?php } ?>

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

										<input type="submit" name="add_customer" value="Add Customer" class="btn btn-info btn-large" />

								</div>

						  </div>

				   </form>

	        </div>
</div>