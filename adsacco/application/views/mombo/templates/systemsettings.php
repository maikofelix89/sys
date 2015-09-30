<div class="header">
        
         <h1 class="page-title">System Settings</h1> 

</div>
        
        <ul class="breadcrumb">

            <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>

             <li><a href="<?php echo base_url();?>systemsettings/">System</a> <span class="divider">/</span></li>

            <li class="active"> Settings and Objects</li>

        </ul>

<div class="container-fluid">

  <div class="row-fluid">
    
    <?php if(isset($message) && $message){ ?>

        <div class="alert alert-<?php echo $message_type; ?>">

            <button type="button" class="close" data-dismiss="alert">×</button>

            <?php echo $message;?>

        </div>

    <?php } ?>

    <div class="well">

            <div class="well">

                    <ul class="nav nav-tabs">

                            <li class="active">
                                
                                <a href="#system-options" data-toggle="tab">System Options</a>

                            </li>

                            <li>
                                
                                <a href="#system-objects" data-toggle="tab">System Objects</a>

                            </li>

                    </ul>

                    <div class="tab-content">

                            <div id="system-options" class="tab-pane active in">

                                <table class="table">

                                    <tr>

                                         <th style="border:none">System Options</th>

                                    </tr>

                                    <tr>
                                          <td style="border:none"></td>
                                    </tr>


                                    <?php 

                                          $CI = & get_instance();

                                          $CI->load->model('account_model','account');

                                    ?>

                                    <?php foreach($system_options->result('systemoption_model') as $option):  ?>

                                              <?php if($option->name == 'loan_service_account' || $option->name == 'loan_receipt_account' || $option->name == 'cheque_receipt_account'): ?>
                                                    <tr>
                                                            <th class="muted"> <?php echo $option->name; ?> </th>

                                                            <td> <?php echo $CI->account->findOne($option->value)->account_name; ?> </td>

                                                    </tr>
                                              <?php else: ?>

                                                     <tr>
                                                            <th class="muted"> <?php echo $option->name; ?> </th>

                                                            <td> <?php echo  $option->value; ?> </td>

                                                    </tr>

                                              <?php endif; ?>

                                    <?php endforeach; ?>

                                    <tr>

                                         <td>

                                                <a href="<?php echo base_url().'systemsettings/editsettings/'; ?>" class="btn btn-info" >

                                                        Edit System Options

                                                </a>

                                        </td>
                                        
                                        <td></td>

                                    </tr>

                                </table>

                            </div>

                            <div id="system-objects" class="tab-pane fade">

                                <table class="table">

                                    <tr>

                                         <th style="border:none">System Objects</th>

                                    </tr>

                                    <tr>
                                          <td style="border:none"></td>
                                    </tr>

                                    <?php $i = 1?>

                                    <?php foreach($system_objects->result('systemoption_model') as $object):  ?>

                                            <tr>
                                                    <th class="muted"><?php echo '#'.$i; ?></th>
                                                    <td> <?php echo ucwords(strtolower($object->name)); ?> </td>
                                            </tr>

                                            <?php $i++; ?>

                                    <?php endforeach; ?>
                                
                                </table>

                            </div>

                    </div>

            </div>

    </div>