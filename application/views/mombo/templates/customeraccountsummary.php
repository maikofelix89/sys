<div class="header">
        
         <h1 class="page-title">Account Summary</h1> 

</div>
        
        <ul class="breadcrumb">

            <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>

             <li><a href="<?php echo base_url();?>mombo/accounts/">Accounts</a> <span class="divider">/</span></li>

            <li class="active"> Account Summary </li>

        </ul>

<div class="container-fluid">

  <div class="row-fluid">
    
    <div class="btn-toolbar">

        <div class="btn-group">
          
            <a href="<?php echo base_url();?>accounts/"  class="btn <?php if($criteria  == 'all') echo 'btn-primary';?> ?>">All Customer Accounts</a>
            
            <a href="<?php echo base_url();?>accounts/customeraccounts/?criteria=bal"      class="btn <?php if($criteria == 'other') echo 'btn-primary';?> ?>">Accounts With Balances</a>
            
            <a href="<?php echo base_url();?>accounts/customeraccounts?criteria=nobal"   class="btn <?php if($criteria == 'expense') echo 'btn-primary';?>">Accounts Without Balances</a>
            
        </div>

        <div class="btn-group pull-right">

            <a href="<?php echo base_url().'accounts/addcustomeraccount/';?>" class="btn btn-success"><i class="icon-plus"></i>Add Account</a>

            <a href="<?php echo base_url().'accounts/exportimport/';?>" class="btn">Import & Export Records</a>

        </div>

    </div>
    
    <div class="well">

            <h4><?php echo ucwords(strtolower($account->customer->name.' '.$account->customer->other_names)); ?></h4>

            <div class="well">

                    <ul class="nav nav-tabs">

                              <li class="active">

                                   <a href="#details" data-toggle="tab">Account Details</a>

                              </li>

                              <li>

                                   <a href="#transactions" data-toggle="tab">Transactions</a>

                              </li>

                              <li>

                                  <span data-toggle="tab"><a href="#edit-account-form" class="btn btn-info" data-toggle="tab" >Edit Account Details</a></span>
                              
                              </li>

                    </ul>

                    <div id="myTabContent" class="tab-content">

                             <style type="text/css">

                                    #details table th,

                                    #details table td{

                                        border:none;

                                    }

                             </style>

                              <div class="tab-pane active in" id="details">

                                     <table class="table">

                                            <tbody>

                                                    <tr>

                                                            <th class="mute">Account Name</th>

                                                            <td><?php echo ucwords(strtolower($account->customer->name.' '.$account->customer->other_names));; ?></td>

                                                    </tr>
                                                    <tr>

                                                            <th class="mute">Account Balance</th>

                                                            <td>Ksh <?php echo $account->balance; ?></td>

                                                    </tr>
                                                
                                            </tbody>

                                     </table>

                              </div>

                              <div class="tab-pane fade" id="transactions">

                                    <?php if($transactions->num_rows() > 0){ ?>

                                    <form method="POST" action="<?php echo base_url().'accounts/transbulkaction/'?>" id="trans-bulk-action" name="trans_bulk_action">

                                        <table class="table">

                                                <thead>

                                                        <tr>

                                                                <th>
                                                                        
                                                                        <select name="action" class="input-small">

                                                                            <option value="trans">Transfer</option>

                                                                            <option value="del">Delete</option>

                                                                        </select>
                                                                </th>

                                                                <th>#Code</th>

                                                                <th>Date</th>

                                                                <th>Description</th>

                                                                <th>Debit / Credit </th>

                                                                <th>Amount (Ksh)</th>

                                                        </tr>
                                                    
                                                </thead>

                                                <tbody>

                                                        <?php foreach ($transactions->result('transaction_model') as $transaction) { ?>

                                                                <tr>

                                                                    <td>

                                                                         <input type="checkbox" name="<?php if($transaction->transactiontype){ ?>transactions[trans_<?php echo $transaction->id;  ?>]" value="<?php echo $transaction->id; }else{ echo '" disabled="disabled';} ?>" />

                                                                    </td>

                                                                    <td> <a href="" title="View transaction log"> <?php echo $transaction->transaction_code; ?> </a> </td>

                                                                    <td> <?php echo $transaction->date; ?> </td>

                                                                    <td> <?php echo $transaction->description; ?> </td>

                                                                    <td> 
                                                                        <?php if($transaction->transactiontype){ ?> 
                                                                                
                                                                                <span class="label label-success">Debit &nbsp;</span>

                                                                        <?php }else{ ?>

                                                                                <span class="label label-inverse">Credit</span>

                                                                        <?php } ?> 

                                                                    </td>

                                                                    <td> <?php echo $transaction->amounttransacted;?> </td>

                                                                </tr>

                                                        <?php } ?>

                                                        <tr>

                                                            <td> </td>

                                                            <td> </td>

                                                            <td> </td>

                                                            <td> </td>

                                                            <th style="mute"> Account Balance</th>

                                                            <th> <?php echo $account->balance;?> </th>

                                                        </tr>
                                            
                                                </tbody>

                                        </table>

                                    </form>

                                    <?php }else{ ?>

                                             <div class="alert alert-info ?>">

                                                    No recorded transactions for this account

                                             </div>

                                    <?php } ?>

                              </div>

                              <div class="tab-pane fade" id="edit-account-form">


                              </div>

                    </div>
            </div>

            <a class="btn btn-success" href="<?php  echo base_url().'accounts/customeraccounts/';  ?>" >&laquo;&nbsp;&nbsp;Back</a>
    </div>