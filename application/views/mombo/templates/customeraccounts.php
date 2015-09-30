<div class="header">
        
        <?php if($criteria == 'all'){ ?> <h1 class="page-title">All Accounts</h1> <?php } ?>

        <?php if($criteria == 'other'){ ?> <h1 class="page-title">Main Accounts</h1> <?php } ?>

        <?php if($criteria == 'expense'){ ?> <h1 class="page-title">Expenditure Accounts</h1> <?php } ?>


</div>
        
        <ul class="breadcrumb">

            <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>

             <li><a href="<?php echo base_url();?>accounts/customeraccounts/">Customer Accounts</a> <span class="divider">/</span></li>

            <li class="active">

            	    <?php if($criteria == 'all'){ ?> All Customer Accounts <?php } ?>

			        <?php if($criteria == 'other'){ ?> Accounts With Balances <?php } ?>

			        <?php if($criteria == 'expense'){ ?> Accounts Without Balances <?php } ?>

            </li>

        </ul>

<div class="container-fluid">

  <div class="row-fluid">
    
    <div class="btn-toolbar">

        <div class="btn-group">
          
            <a href="<?php echo base_url();?>accounts/customeraccounts"  class="btn <?php if($criteria  == 'all') echo 'btn-primary';?> ?>">All Accounts</a>
            
            <a href="<?php echo base_url();?>accounts/customeraccounts/?criteria=bal"      class="btn <?php if($criteria == 'other') echo 'btn-primary';?> ?>">Accounts With Balances</a>
            
            <a href="<?php echo base_url();?>accounts/customeraccounts/?criteria=nobal"   class="btn <?php if($criteria == 'expense') echo 'btn-primary';?>">Accounts Without Balances</a>
            
        </div>

        <div class="btn-group pull-right">

            <a href="<?php echo base_url().'accounts/addaccount/';?>" class="btn btn-success"><i class="icon-plus"></i>Add a Customer Account</a>

            <a href="<?php echo base_url().'accounts/exportimport/';?>" class="btn">Import & Export Customer Records</a>

        </div>

    </div>

    <?php if(isset($message) && $message){ ?>

        <div class="alert alert-<?php echo $message_type; ?>">

            <button type="button" class="close" data-dismiss="alert">×</button>

            <?php echo $message;?>

        </div>

    <?php } ?>

  	<div class="well">


        <?php if($accounts->num_rows() > 0){ ?>

             <form action="<?php echo base_url().'account/bulkaction/?account_type=customer'?>" method="POST">

                  <table class="table">

                        <thead>

                                  <tr class="muted">

                                            <th>

                                                <select class="input-small">

                                                    <option value="del">Delete</option>

                                                </select>

                                            </th>

                                            <th>Customer Name</th>

                                            <th>Balance</th>

                                  </tr>

                        </thead>

                        <tbody>

                                  <?php 

                                     $i=0; 

                                      foreach($accounts->result('customeraccount_model') as $account){ ?>

                                          <?php if($account->id == 5000) continue;?>
                                       
                                          <tr>

                                                <td>

                                                     <input type="checkbox" name="accounts[acc_<?php echo $account->id; ?>]" value="<?php echo $account->id;?>" />

                                                </td>

                                                <td> <?php echo ucwords(strtolower($account->customer->name.' '.$account->customer->other_names)); ?> </td>

                                                <td> <?php echo $account->balance; ?></td>

                                                <td style="text-align:center">
                                                     <a class="btn btn-info btn-small" href="<?php echo base_url().'accounts/customeraccountsummary/?account_id='.$account->id; ?>">More..</a>
                                                     <a class="btn btn-success btn-small" href="<?php echo base_url().'accounts/editcustomeraccount/?account_id='.$account->id; ?>">Edit</a>
                                                     <a class="btn btn-warning btn-small" href="<?php echo base_url().'accounts/deletecustomeraccount/?account_id='.$account->id; ?>">Remove</a>
                                                </td>
                                        </tr>
                                  <?php } ?>

                                  <tr class="muted">

                                        <th style="border:none;">

                                            <select class="input-small">

                                                <option value="del">Delete</option>

                                            </select>

                                        </th>

                                  </tr>

                        </tbody>

                 </table>

            </form>

    </div>

<?php }else{ ?>
           
           <?php if($this->input->get_post('per_page')){ ?>\

                     <div class="alert alert-info ?>">

                            No more Accounts in this group

                     </div>

                     <a class="btn btn-success" href="<?php echo base_url().'accounts/customeraccounts/';?>">&laquo;&nbsp;&nbsp;Back to All</a>
    </div>

           <?php }else{ ?>

                    <div class="alert alert-info">
                            No Accounts in this group
                    </div>

                    <a class="btn btn-success" href=<?php if($criteria != 'all'){ echo '"'.last_page().'" >&laquo;&nbsp;&nbsp;Back to All';}else{ echo '"'.base_url().'accounts/addcustomeraccount/">Add New Account'; }?></a>
   
    </div>

           <?php } ?>
<?php } ?>