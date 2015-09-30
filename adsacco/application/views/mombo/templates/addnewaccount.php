<div class="header">
        
         <h1 class="page-title">Add New Account</h1> 

</div>
        
        <ul class="breadcrumb">

            <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>

             <li><a href="<?php echo base_url();?>accounts/">Accounts</a> <span class="divider">/</span></li>

            <li class="active"> Add new account </li>

        </ul>

<div class="container-fluid">

  <div class="row-fluid">
    
    <div class="btn-toolbar">

        <div class="btn-group">
          
            <a href="<?php echo base_url();?>accounts/"  class="btn <?php if($criteria  == 'all') echo 'btn-primary';?> ?>">All Accounts</a>
            
            <a href="<?php echo base_url();?>accounts/?criteria=other"      class="btn <?php if($criteria == 'other') echo 'btn-primary';?> ?>">Main Accounts</a>
            
            <a href="<?php echo base_url();?>accounts/?criteria=expense"   class="btn <?php if($criteria == 'expense') echo 'btn-primary';?>">Expenditure Accounts</a>
            
        </div>

        <div class="btn-group pull-right">

            <a href="<?php echo base_url().'accounts/addaccount/';?>" class="btn btn-success"><i class="icon-plus"></i>Add Account</a>
			<a href="<?php echo base_url().'accounts/addsubaccount/';?>" class="btn btn-success"><i class="icon-plus"></i>Add Sub Account</a>
            <a href="<?php echo base_url().'accounts/exportimport/';?>" class="btn">Import & Export Records</a>

        </div>

    </div>

    <?php if(isset($message) && $message){ ?>

        <div class="alert alert-warning">

            <button type="button" class="close" data-dismiss="alert">×</button>

            <?php echo $message;?>

        </div>

    <?php } ?>

    <div >

          <h4 class="btn-primary btn-large" style="margin-bottom:-4px;">Add Account</h4>

          <form id="add-account-form" name="add_account_form" method="POST" action="<?php echo base_url().'accounts/addaccount/'; ?>" class="form-horizontal well">

              <div class="control-group <?php if(array_key_exists('account_name', $errors)) echo 'error'; ?>">

                  <label class="control-label" for="account[account_name]">Account Name</label>

                  <div class="controls">

                      <input type="text" name="account[account_name]" value="<?php $account->account_name; ?>" class="input-xxlarge" required=""/>

                      <?php if(array_key_exists('account_name', $errors)){ ?> <span class="help-inline"> <?php echo $errors['account_name']; ?> </span> <?php } ?>

                  </div>

              </div>

              <div class="control-group <?php if(array_key_exists('account_opening_balance', $errors)) echo 'error'; ?>">

                  <label class="control-label" for="account[account_opening_balance]">Opening Balance</label>

                  <div class="controls">

                      <input type="text" name="account[account_opening_balance]" value="<?php echo $account->account_opening_balance; ?>" placeholder="0.00" class="input-xxlarge" required=""/>

                       <?php if(array_key_exists('account_opening_balance', $errors)){ ?> <span class="help-inline"> <?php echo $errors['account_opening_balance']; ?> </span> <?php } ?>

                  </div>

              </div>

              <div class="control-group <?php if(array_key_exists('account_desc', $errors)) echo 'error'; ?>">

                  <label class="control-label" for="account[desc]">Account Description</label>

                  <div class="controls">

                      <textarea name="account[account_desc]" class="input-xxlarge" style="height:200px;" ><?php echo $account->account_desc; ?></textarea>

                      <?php if(array_key_exists('account_desc', $errors)){ ?> <span class="help-inline"> <?php echo $errors['account_desc']; ?> </span> <?php } ?>

                  </div>

              </div>
             		  
			  <div class="control-group">

                  <label class="control-label" for="account[is_exp]">Is Expenditure Account</label>

                  <div class="controls">

                      <label class="radio inline">

                        <input type="radio" name="account[is_exp]" id="optionsRadios1" value="1" checked> Yes

                      </label>

                      <label class="radio inline">

                        <input type="radio" name="account[is_exp]" id="optionsRadios2" value="0"> No

                      </label>

                      <?php if(array_key_exists('is_exp', $errors)){ ?> <span class="help-inline"> <?php echo $errors['is_exp']; ?> </span> <?php } ?>

                  </div>

              </div>
			  
			   <div class="control-group">

                  <label class="control-label" for="account[has_child]">Has Sub Account</label>

                  <div class="controls">

                      <label class="radio inline">

                        <input type="radio" name="account[has_child]" id="optionsRadios1a" value="1" checked> Yes

                      </label>

                      <label class="radio inline">

                        <input type="radio" name="account[has_child]" id="optionsRadios2a" value="0"> No

                      </label>

                      <?php if(array_key_exists('has_child', $errors)){ ?> <span class="help-inline"> <?php echo $errors['has_child']; ?> </span> <?php } ?>

                  </div>

              </div>

              <div class="control-group">

                <div class="controls">

                   <input type="submit" name="create_account" value="Add Account" class="btn btn-info btn-large input-xlarge"/>

                </div>

              </div>
          </form>

    </div>