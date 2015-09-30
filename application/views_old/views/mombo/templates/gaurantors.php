 <div class="header">
            <?php if(isset($gaurantor_type)){ ?>
                   <?php if($gaurantor_type == 'active'){ ?>
                        <h1 class="page-title">Active Guarantors</h1>
                    <?php }elseif($gaurantor_type == 'inactive'){ ?>
                        <h1 class="page-title">Deactivated Guarantors</h1>
                    <?php }elseif($gaurantor_type == 'new'){ ?>
                        <h1 class="page-title">New Guarantors</h1>
					<?php }elseif($gaurantor_type == 'reject'){ ?>
                        <h1 class="page-title">Rejected Guarantors</h1>
                    <?php }else{ ?>
                        <h1 class="page-title">All Guarantors</h1>
                   <?php  }  ?>
            <?php } ?>
 </div>
        
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>
            <li class="active">Guarantors</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
	<div class="btn-group pull-right">
      <a href="<?php echo base_url().'gaurantors/addnewgaurantor/';?>" class="btn btn-success"><i class="icon-plus"></i> New Guarantor</a>
    </div>
    <div class="btn-group">
      <a href="<?php echo base_url();?>gaurantors/"  class="btn <?php if(isset($gaurantor_type) && $gaurantor_type == 'all') echo 'btn-primary';?> ?>">All Guarantors</a>
      <a href="<?php echo base_url();?>gaurantors/?type=new"      class="btn <?php if(isset($gaurantor_type) && $gaurantor_type == 'new') echo 'btn-primary';?> ?>">New Guarantors</a>
      <a href="<?php echo base_url();?>gaurantors/?type=active"   class="btn <?php if(isset($gaurantor_type) && $gaurantor_type == 'active') echo 'btn-primary';?>">Activated Guarantors</a>
      <a href="<?php echo base_url();?>gaurantors/?type=inactive" class="btn <?php if(isset($gaurantor_type) && $gaurantor_type == 'inactive') echo 'btn-primary';?> ?>">Deactivated Guarantors</a>
	  <a href="<?php echo base_url();?>gaurantors/?type=reject" class="btn <?php if(isset($gaurantor_type) && $gaurantor_type == 'reject') echo 'btn-primary';?> ?>">Rejected Guarantors</a>
    </div>
</div>
<?php if(isset($message) && $message){ ?>
    <div class="alert alert-<?php echo $message_type; ?>">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <?php echo $message;?>
    </div>
<?php } ?>
<div class="well">
    <?php if($gaurantors->num_rows() > 0){ ?>
         <form action="<?php echo base_url().'gaurantors/bulkaction/'?>" method="POST">
          <table class="table">
            <thead>
              <tr class="muted">
                <th>#
                    <!--<select class="input-small">
                        <option value="">Accept</option>
                        <option value="">Reject</option>
                        <option value="">Deactivate</option>
                        <option value="">Activate</option>
                    </select> -->
                </th>
                <th>Gaurantor Name</th>
                <th>ID Number</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Status</th>
                <th colspan="2">Action</th>
                <th style="width: 26px;"></th>
              </tr>
            </thead>
            <tbody>
                 <?php 
                    $i=1;
                    foreach ($gaurantors->result('gaurantor_model') as $gaurantor) {
                  ?>
                     <tr <?php if($i%2==0) echo 'class="row-strip"';?> >
                        <td><?php echo $i; ?><!--<input type="checkbox" name="gaurantors[cust_<?php echo  $gaurantor->id;?>]" value="<?php echo  $gaurantor->id; ?>"/>--></td>
                        <td><img src="<?php echo base_url();?>images/profilepics/<?php echo $gaurantor->profilepic;?>" height="40" width="40"> <?php echo ucwords(strtolower($gaurantor->name." ".$gaurantor->other_names));?></td>
                        <td><?php echo $gaurantor->idnumber;?></td>
                        <td><?php echo $gaurantor->email;?></td>
                        <td><?php echo $gaurantor->mobile;?></td>

                        <td>
                           <?php 
                              $status = $gaurantor->status;
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
                        <td style="text-align:center;">
                        <?php if($gaurantor->status == 0){ ?><a style="margin-bottom:5px;" href="<?php echo base_url();?>gaurantors/dostatusaction/?action=accept&gaurantor_id=<?php echo $gaurantor->id;?>" class="btn btn-small btn-success">Accept</a><?php } ?>
                        <?php if($gaurantor->status == 0){ ?><a style="margin-bottom:5px;" href="<?php echo base_url();?>gaurantors/dostatusaction/?action=reject&gaurantor_id=<?php echo $gaurantor->id;?>" class="btn btn-small btn-warning">Reject</a><?php } ?>
                        <?php if($gaurantor->status == 1){ ?><a style="margin-bottom:5px;" href="<?php echo base_url();?>gaurantors/dostatusaction/?action=deactivate&gaurantor_id=<?php echo $gaurantor->id;?>" class="btn btn-small btn-warning">Deactivate</a><?php } ?>
                        <?php if($gaurantor->status == 2){ ?><a style="margin-bottom:5px;" href="<?php echo base_url();?>gaurantors/dostatusaction/?action=activate&gaurantor_id=<?php echo $gaurantor->id;?>" class="btn btn-small btn-success">Activate</a><?php } ?>
						<?php if($gaurantor->status == 3){ ?><a style="margin-bottom:5px;" href="<?php echo base_url();?>gaurantors/dostatusaction/?action=accept&gaurantor_id=<?php echo $gaurantor->id;?>" class="btn btn-small btn-success">Accept</a><?php } ?>
                        <a href="<?php echo base_url();?>gaurantors/viewgaurantordetails/?gaurantor_id=<?php echo $gaurantor->id;?>" class="btn btn-small btn-info">View Detail</a></button>
                        </td>
                   </tr>
                <?php
                  $i++;
                 }
              ?>
               <tr>
                 <th style="border:none;">#
                    <!--<select class="input-small">
                        <option value="">Accept</option>
                        <option value="">Reject</option>
                        <option value="">Deactivate</option>
                        <option value="">Activate</option>
                    </select>-->
                 </th>
               </tr>
            </tbody>
          </table>
          </form>
          </div>
          <div class="pagination pagination-right">
              <?php
                    $config['base_url'] = base_url().'gaurantors/?';
                    if($gaurantor_type == 'active') $config['base_url'] = base_url().'gaurantors/?type=active';
                    if($gaurantor_type == 'inactive') $config['base_url'] = base_url().'gaurantors/?type=inactive';
                    if($gaurantor_type == 'new') $config['base_url'] = base_url().'gaurantors/?type=new';
              ?>
              <?php $this->pagination->initialize($config);echo $this->pagination->create_links(); ?>
          </div>
    <?php }else{ ?>
           <?php if($this->input->get_post('per_page')){ ?>
             <div class="alert alert-info ?>">
                No more Guarantor records in this group
             </div>
             <a class="btn btn-success" href="<?php echo base_url().'gaurantors/';?>">&laquo;&nbsp;&nbsp;Back to All</a>
          </div>
        <?php }else{ ?>
            <div class="alert alert-info">
                No Guarantor records in this group
            </div>
             <a class="btn btn-success" href="<?php if(isset($gaurantor_type) && $gaurantor_type != 'all'){ echo last_page().'">&laquo;&nbsp;&nbsp;Back'; }else{ echo '"'.base_url().'gaurantors/addnewgaurantor/">Add New Guarantor'; }?></a>
        </div>
    <?php    
            }
      }
    ?>
