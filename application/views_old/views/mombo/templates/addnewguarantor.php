<div class="header">
      <h1 class="page-title">Add Guarantor</h1>
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
	<li class="active">Add New Guarantor</li>
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
      <a href="<?php echo base_url();?>gaurantors/"  class="btn <?php if(isset($gaurantor_type) && $gaurantor_type == 'all') echo 'btn-primary';?> ?>">All Guarantors</a>
      <a href="<?php echo base_url();?>gaurantors/?type=new"      class="btn <?php if(isset($gaurantor_type) && $gaurantor_type == 'new') echo 'btn-primary';?> ?>">New Guarantors</a>
      <a href="<?php echo base_url();?>gaurantors/?type=active"   class="btn <?php if(isset($gaurantor_type) && $gaurantor_type == 'active') echo 'btn-primary';?>">Activated Guarantors</a>
      <a href="<?php echo base_url();?>gaurantors/?type=inactive" class="btn <?php if(isset($gaurantor_type) && $gaurantor_type == 'inactive') echo 'btn-primary';?> ?>">Inactive Guarantors</a>
    </div>
    <div class="btn-group pull-right">
      <a href="<?php echo base_url().'gaurantors/addnewgaurantor/';?>" class="btn btn-success"><i class="icon-plus"></i> New Guarantor</a>
    </div>
</div>

<?php if(isset($message) && $message){ ?>

	<div class="alert alert-<?php echo $message_type; ?>">

		<button type="button" class="close" data-dismiss="alert">×</button>

		<?php echo $message;?>

	</div>

<?php } ?>

 <div class="well">
	  <div id="edit-gaurantor-form-cont">
				   <h4 class="btn-primary btn-large" style="margin-bottom:-4px;">Add Guarantor</h4>
			  
				   <form class="well form-horizontal" id="edit-gaurantor-form" method="POST" action="<?php echo base_url().'gaurantors/addnewgaurantor/';?>">
               	      
               	     <input type="hidden" name="gaurantor[id]" value="<?php echo $gaurantor->id; ?>"/>
						  
						  <input type="hidden" name="gaurantor[status]" value="<?php echo $gaurantor->status; ?>"/>
						  
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

										<input type="submit" name="add_guarantor" value="Add Guarantor" class="btn btn-info btn-large" />

								</div>

						  </div>

               </form>

	        </div>
</div>