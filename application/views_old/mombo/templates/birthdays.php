 <div class="header">
       <h1 class="page-title">Customer Birthdays</h1>
 </div>
        
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>
            <li class="active">Customer Birthdays</li>
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

     <h4>Customer Birthdays</h4>

     <div class="well">

         <ul class="nav nav-tabs">

               <li class="active"><a data-toggle="tab" href="#today">Today</a></li>
                <li ><a data-toggle="tab" href="#today1">Tomorrow</a></li>
				<li ><a data-toggle="tab" href="#today2"><?php echo date("Y-M-d", strtotime("+ 2 day")); ?></a></li>
				<li ><a data-toggle="tab" href="#today3"><?php echo date("Y-M-d", strtotime("+ 3 day")); ?></a></li>
				<li ><a data-toggle="tab" href="#today4"><?php echo date("Y-M-d", strtotime("+ 4 day")); ?></a></li>
				<li ><a data-toggle="tab" href="#today5"><?php echo date("Y-M-d", strtotime("+ 5 day")); ?></a></li>
				<li ><a data-toggle="tab" href="#today6"><?php echo date("Y-M-d", strtotime("+ 6 day")); ?></a></li>                

         </ul>

         <div class="tab-content">

              <div id="today" class="tab-pane active">
					<?php echo date("Y-M-d"); ?>
                   <?php if(!empty($today)){ ?>

                      <table class="table">
                        <thead>
                              <tr>
                                   <th>#</th>

                                   <th>Name</th>

                                   <th>Mobile</th>
								   <th>E-mail</th>

                              </tr>
                        </thead>
                        <tbody class="payments-body">
                            <?php 
                                $i=1;
                                foreach($today as $_today) {
									$customer_id = $_today['id'];
									$customer_name = $_today['name']." ".$_today['other_names'];
									$customer_mobile = $_today['mobiletel'];
									$customer_email= $_today['email'];
									
                             ?>
                                  <tr>  
                                      <td><?php echo ++$i; ?></td>
                                      <td>
                                         <p><i class="icon-user"></i>
                                            <a href="<?php echo base_url().'customers/viewcustomerdetails/?customer_id='.$customer_id;?>">
                                              <?php echo $customer_name; ?>
                                            </a> 
                                         </p>
                                      </td>
									  <td>
                                          <?php echo $customer_mobile; ?>
                                      </td>
                                      <td>
                                         <p><?php echo $customer_email; ?></p>
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
                                  There are no birthdays today.
                              </div>

                  <?php } ?>

              </div>

		   <div id="today1" class="tab-pane fade">
						<?php echo date("Y-M-d", strtotime("+ 1 day")); ?>
					   <?php if(!empty($today1)){ ?>

						  <table class="table">
							<thead>
								  <tr>
									   <th>#</th>

									   <th>Name</th>

									   <th>Mobile</th>
									   <th>E-mail</th>

								  </tr>
							</thead>
							<tbody class="payments-body">
								<?php 
									$j=0;
									foreach($today1 as $_today1) {
										$customer_id = $_today1['id'];
										$customer_name = $_today1['name']." ".$_today1['other_names'];
										$customer_mobile = $_today1['mobiletel'];
										$customer_email= $_today1['email'];
										
								 ?>
									  <tr>  
										  <td><?php echo ++$j; ?></td>
										  <td>
											 <p><i class="icon-user"></i>
												<a href="<?php echo base_url().'customers/viewcustomerdetails/?customer_id='.$customer_id;?>">
												  <?php echo $customer_name; ?>
												</a> 
											 </p>
										  </td>
										  <td>
											  <?php echo $customer_mobile; ?>
										  </td>
										  <td>
											 <p><?php echo $customer_email; ?></p>
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
									  No records found.
								  </div>

					  <?php } ?>

				  </div>
				  
				  <div id="today2" class="tab-pane fade">
						<?php echo date("Y-M-d", strtotime("+ 2 day")); ?>
					   <?php if(!empty($today2)){ ?>

						  <table class="table">
							<thead>
								  <tr>
									   <th>#</th>

									   <th>Name</th>

									   <th>Mobile</th>
									   <th>E-mail</th>

								  </tr>
							</thead>
							<tbody class="payments-body">
								<?php 
									$k=0;
									foreach($today2 as $_today2) {
										$customer_id = $_today2['id'];
										$customer_name = $_today2['name']." ".$_today2['other_names'];
										$customer_mobile = $_today2['mobiletel'];
										$customer_email= $_today2['email'];
										
								 ?>
									  <tr>  
										  <td><?php echo ++$k; ?></td>
										  <td>
											 <p><i class="icon-user"></i>
												<a href="<?php echo base_url().'customers/viewcustomerdetails/?customer_id='.$customer_id;?>">
												  <?php echo $customer_name; ?>
												</a> 
											 </p>
										  </td>
										  <td>
											  <?php echo $customer_mobile; ?>
										  </td>
										  <td>
											 <p><?php echo $customer_email; ?></p>
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
									  No records found.
								  </div>

					  <?php } ?>

				  </div>

				  	<div id="today3" class="tab-pane fade">
						<?php echo date("Y-M-d", strtotime("+ 3 day")); ?>
					   <?php if(!empty($today3)){ ?>

						  <table class="table">
							<thead>
								  <tr>
									   <th>#</th>

									   <th>Name</th>

									   <th>Mobile</th>
									   <th>E-mail</th>

								  </tr>
							</thead>
							<tbody class="payments-body">
								<?php 
									$l=0;
									foreach($today3 as $_today3) {
										$customer_id = $_today3['id'];
										$customer_name = $_today3['name']." ".$_today3['other_names'];
										$customer_mobile = $_today3['mobiletel'];
										$customer_email= $_today3['email'];
										
								 ?>
									  <tr>  
										  <td><?php echo ++$l; ?></td>
										  <td>
											 <p><i class="icon-user"></i>
												<a href="<?php echo base_url().'customers/viewcustomerdetails/?customer_id='.$customer_id;?>">
												  <?php echo $customer_name; ?>
												</a> 
											 </p>
										  </td>
										  <td>
											  <?php echo $customer_mobile; ?>
										  </td>
										  <td>
											 <p><?php echo $customer_email; ?></p>
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
									  No records found.
								  </div>

					  <?php } ?>

				  </div>

				  		   <div id="today4" class="tab-pane fade">
						<?php echo date("Y-M-d", strtotime("+ 4 day")); ?>
					   <?php if(!empty($today4)){ ?>

						  <table class="table">
							<thead>
								  <tr>
									   <th>#</th>

									   <th>Name</th>

									   <th>Mobile</th>
									   <th>E-mail</th>

								  </tr>
							</thead>
							<tbody class="payments-body">
								<?php 
									$p=0;
									foreach($today4 as $_today4) {
										$customer_id = $_today4['id'];
										$customer_name = $_today4['name']." ".$_today4['other_names'];
										$customer_mobile = $_today4['mobiletel'];
										$customer_email= $_today4['email'];
										
								 ?>
									  <tr>  
										  <td><?php echo ++$p; ?></td>
										  <td>
											 <p><i class="icon-user"></i>
												<a href="<?php echo base_url().'customers/viewcustomerdetails/?customer_id='.$customer_id;?>">
												  <?php echo $customer_name; ?>
												</a> 
											 </p>
										  </td>
										  <td>
											  <?php echo $customer_mobile; ?>
										  </td>
										  <td>
											 <p><?php echo $customer_email; ?></p>
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
									  No records found.
								  </div>

					  <?php } ?>

				  </div>

				  		   <div id="today5" class="tab-pane fade">
						<?php echo date("Y-M-d", strtotime("+ 5 day")); ?>
					   <?php if(!empty($today5)){ ?>

						  <table class="table">
							<thead>
								  <tr>
									   <th>#</th>

									   <th>Name</th>

									   <th>Mobile</th>
									   <th>E-mail</th>

								  </tr>
							</thead>
							<tbody class="payments-body">
								<?php 
									$q=0;
									foreach($today5 as $_today5) {
										$customer_id = $_today5['id'];
										$customer_name = $_today5['name']." ".$_today5['other_names'];
										$customer_mobile = $_today5['mobiletel'];
										$customer_email= $_today5['email'];
										
								 ?>
									  <tr>  
										  <td><?php echo ++$q; ?></td>
										  <td>
											 <p><i class="icon-user"></i>
												<a href="<?php echo base_url().'customers/viewcustomerdetails/?customer_id='.$customer_id;?>">
												  <?php echo $customer_name; ?>
												</a> 
											 </p>
										  </td>
										  <td>
											  <?php echo $customer_mobile; ?>
										  </td>
										  <td>
											 <p><?php echo $customer_email; ?></p>
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
									  No records found.
								  </div>

					  <?php } ?>

				  </div>

				  		   <div id="today6" class="tab-pane fade">
						<?php echo date("Y-M-d", strtotime("+ 6 day")); ?>
					   <?php if(!empty($today6)){ ?>

						  <table class="table">
							<thead>
								  <tr>
									   <th>#</th>

									   <th>Name</th>

									   <th>Mobile</th>
									   <th>E-mail</th>

								  </tr>
							</thead>
							<tbody class="payments-body">
								<?php 
									$r=0;
									foreach($today6 as $_today6) {
										$customer_id = $_today6['id'];
										$customer_name = $_today6['name']." ".$_today6['other_names'];
										$customer_mobile = $_today6['mobiletel'];
										$customer_email= $_today6['email'];
										
								 ?>
									  <tr>  
										  <td><?php echo $r++; ?></td>
										  <td>
											 <p><i class="icon-user"></i>
												<a href="<?php echo base_url().'customers/viewcustomerdetails/?customer_id='.$customer_id;?>">
												  <?php echo $customer_name; ?>
												</a> 
											 </p>
										  </td>
										  <td>
											  <?php echo $customer_mobile; ?>
										  </td>
										  <td>
											 <p><?php echo $customer_email; ?></p>
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
									  No records found.
								  </div>

					  <?php } ?>

				  </div>

        </div>
    </div>
</div>
<script type="text/javascript" language="javascript">
	function confirm_action(url,amount,customer){
		if (confirm('Are you sure you want to cancel payment made by cheque of KSH. '+amount+' by '+customer+'?')) {
			window.location.href=url;
		}
	}
</script>