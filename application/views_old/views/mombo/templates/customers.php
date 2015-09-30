 <div class="header">
            <?php if(isset($customer_type)){ ?>
                   <?php if($customer_type == 'active'){ ?>
                        <h1 class="page-title">Active Customers</h1>
                    <?php }elseif($customer_type == 'inactive'){ ?>
                        <h1 class="page-title">Deactivated Customers</h1>
                    <?php }elseif($customer_type == 'new'){ ?>
                        <h1 class="page-title">New Customers</h1>
					<?php }elseif($customer_type == 'reject'){ ?>
                        <h1 class="page-title">Rejected Customers</h1>
                    <?php }else{ ?>
                        <h1 class="page-title">All Customers</h1>
                   <?php  }  ?>
            <?php } ?>
 </div>
        
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>
            <li class="active">Customers</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
	<div class="btn-group pull-right">
      <a href="<?php echo base_url().'customers/addnewcustomer/';?>" class="btn btn-success"><i class="icon-plus"></i> New Customer</a>
      <a href="<?php echo base_url().'customers/exportimport/';?>" class="btn">Import & Export Records</a>
    </div>
    <div class="btn-group">
      <a href="<?php echo base_url();?>customers/"  class="btn <?php if(isset($customer_type) && $customer_type == 'all') echo 'btn-primary';?> ?>">All Customers</a>
      <a href="<?php echo base_url();?>customers/?type=new"      class="btn <?php if(isset($customer_type) && $customer_type == 'new') echo 'btn-primary';?> ?>">New Customers</a>
      <a href="<?php echo base_url();?>customers/?type=active"   class="btn <?php if(isset($customer_type) && $customer_type == 'active') echo 'btn-primary';?>">Activated Customers</a>
      <a href="<?php echo base_url();?>customers/?type=inactive" class="btn <?php if(isset($customer_type) && $customer_type == 'inactive') echo 'btn-primary';?> ?>">Deactivated Customers</a>
	  <a href="<?php echo base_url();?>customers/?type=reject" class="btn <?php if(isset($customer_type) && $customer_type == 'reject') echo 'btn-primary';?> ?>">Rejected Customers</a>
    </div>
</div>
<?php if(isset($message) && $message){ ?>
    <div class="alert alert-<?php echo $message_type; ?>">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <?php echo $message;?>
    </div>
<?php } ?>
<div class="well">
    <?php if($customers->num_rows() > 0){ ?>
         <form action="<?php echo base_url().'customers/bulkaction/'?>" method="POST">
          <table class="table">
            <thead>
              <tr class="muted">
                <th>
                    <select class="input-small">
                        <option value="">Accept</option>
                        <option value="">Reject</option>
                        <option value="">Deactivate</option>
                        <option value="">Activate</option>
                    </select>
                </th>
                <th>Customer Name</th>
                <th>ID Number</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Account Status</th>
      		      <th>Member ID</th>
                <th>Points</th>
                <th colspan="2">Action</th>
                <th style="width: 26px;"></th>
              </tr>
            </thead>
            <tbody>
                 <?php 
                    $i=1;
                    foreach ($customers->result('customer_model') as $customer) {
                  ?>
                     <tr <?php if($i%2==0) echo 'class="row-strip"';?> >
                        <td><input type="checkbox" name="customers[cust_<?php echo  $customer->id;?>]" value="<?php echo  $customer->id; ?>"/></td>
                        <td><img src="<?php echo base_url();?>images/profilepics/<?php echo $customer->profilepic;?>" height="40" width="40"> <?php echo ucwords(strtolower($customer->name." ".$customer->other_names));?></td>
                        <td><?php echo $customer->idnumber;?></td>
                        <td><?php echo $customer->email;?></td>
                        <td><?php echo $customer->mobiletel;?></td>

                        <td>
                           <?php 
                              $status = $customer->status;
                              if($status == 0){
                                $status = "Awaiting approval";

                              }else if($status==1){
                                $status = "Active";
                              }else if($status == 2){
                                $status = "Deactivated";
                              }
							  else if($status == 3){
                                $status = "Rejected";
                              }
                              echo $status;
                            ?>
                        </td>
      				          <td><?php echo $customer->member_id;?></td>
                        <td> <?php echo (($customer->loyaltypoints) ?  $customer->loyaltypoints.' ps' : '0 ps' ) ; ?></td>
                        <td style="text-align:center;">
                        <?php if($customer->status == 0){ ?><a style="margin-bottom:5px;" href="<?php echo base_url();?>customers/dostatusaction/?action=accept&customer_id=<?php echo $customer->id;?>" class="btn btn-small btn-success">Accept</a><?php } ?>
                        <?php if($customer->status == 0){ ?><a style="margin-bottom:5px;" href="<?php echo base_url();?>customers/dostatusaction/?action=reject&customer_id=<?php echo $customer->id;?>" class="btn btn-small btn-warning">Reject</a><?php } ?>
                        <?php if($customer->status == 1){ ?><a style="margin-bottom:5px;" href="<?php echo base_url();?>customers/dostatusaction/?action=deactivate&customer_id=<?php echo $customer->id;?>" class="btn btn-small btn-warning">Deactivate</a><?php } ?>
                        <?php if($customer->status == 2){ ?><a style="margin-bottom:5px;" href="<?php echo base_url();?>customers/dostatusaction/?action=activate&customer_id=<?php echo $customer->id;?>" class="btn btn-small btn-success">Activate</a><?php } ?>
						<?php if($customer->status == 3){ ?><a style="margin-bottom:5px;" href="<?php echo base_url();?>customers/dostatusaction/?action=accept&customer_id=<?php echo $customer->id;?>" class="btn btn-small btn-success">Accept</a><?php } ?>
                        <a href="<?php echo base_url();?>customers/viewcustomerdetails/?customer_id=<?php echo $customer->id;?>" class="btn btn-small btn-info">View Detail</a></button>
                        </td>
                   </tr>
                <?php
                  $i++;
                 }
              ?>
               <tr>
                 <th style="border:none;">
                    <select class="input-small">
                        <option value="">Accept</option>
                        <option value="">Reject</option>
                        <option value="">Deactivate</option>
                        <option value="">Activate</option>
                    </select>
                 </th>
               </tr>
            </tbody>
          </table>
          </form>
          </div>
          <div class="pagination pagination-right">
              <?php
                    $config['base_url'] = base_url().'customers/?';
                    if($customer_type == 'active') $config['base_url'] = base_url().'customers/?type=active';
                    if($customer_type == 'inactive') $config['base_url'] = base_url().'customers/?type=inactive';
                    if($customer_type == 'new') $config['base_url'] = base_url().'customers/?type=new';
              ?>
              <?php $this->pagination->initialize($config);echo $this->pagination->create_links(); ?>
          </div>
    <?php }else{ ?>
           <?php if($this->input->get_post('per_page')){ ?>
             <div class="alert alert-info ?>">
                No more Customer records in this group
             </div>
             <a class="btn btn-success" href="<?php echo base_url().'customers/';?>">&laquo;&nbsp;&nbsp;Back to All</a>
          </div>
        <?php }else{ ?>
            <div class="alert alert-info">
                No Customer records in this group
            </div>
             <a class="btn btn-success" href="<?php if(isset($customer_type) && $customer_type != 'all'){ echo last_page().'">&laquo;&nbsp;&nbsp;Back'; }else{ echo '"'.base_url().'customers/addnewcustomer/">Add New Customer'; }?></a>
        </div>
    <?php    
            }
      }
    ?>
