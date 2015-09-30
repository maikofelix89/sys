<div class="header">
        
         <h1 class="page-title">System Settings</h1> 

</div>
        
        <ul class="breadcrumb">

            <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>

             <li><a href="<?php echo base_url();?>systemsettings/">Settings and Objects </a> <span class="divider">/</span></li>

            <li class="active"> Edit System Options</li>

        </ul>

<div class="container-fluid">

  <div class="row-fluid">

    <div class="well">

            <form class="" method="POST" action="<?php echo base_url().'systemsettings/editsettings/'; ?>" >

                <?php foreach($options->result('systemoption_model') as $option): ?>

                        <?php if($option->name == 'loan_service_account' || $option->name == 'loan_receipt_account' || $option->name == 'cheque_receipt_account'): ?>

                                <div class="control-group">

                                    <h5 class="control-label" for="<?php echo $option->name; ?>" ><?php echo $option->name; ?></h5>

                                    <div class="controls">

                                            <select name="<?php echo $option->name; ?>" class="input-xxlarge">

                                                    <?php foreach($accounts->result('account_model') as $account): ?>

                                                            <option value="<?php echo $account->id; if($account->id == $option->value){ echo '" selected="selected"';} ?>"><?php echo $account->account_name; ?></option>

                                                    <?php endforeach; ?>

                                            </select>

                                    </div>

                                </div>
                        <?php else: ?>

                                 <div class="control-group">

                                    <h5 class="control-label bold" for="<?php echo $option->name; ?>" ><?php echo $option->name; ?></h5>

                                    <div class="controls">

                                            <input type="text" name="<?php echo $option->name; ?>" value="<?php echo $option->value?>" class="input-xxlarge" />

                                    </div>

                                </div>

                        <?php endif;?>

                <?php endforeach; ?>

                <div class="control-group">

                        <div class="controls">
                                <input type="submit" name="edit_settings" value="Update Options" class="btn btn-info btn-large" />
                        </div>
                </div>

            </form>

    </div>