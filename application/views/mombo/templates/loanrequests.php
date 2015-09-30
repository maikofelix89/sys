<div class="header">
       <?php if($criteria == 'all'){ ?> <h1 class="page-title">All Loan Requests</h1> <?php } ?>
       <?php if($criteria == 'acc'){ ?> <h1 class="page-title">Accepted Loan Requests</h1> <?php } ?>
       <?php if($criteria == 'den'){ ?> <h1 class="page-title">Denied Loan Requests</h1> <?php } ?>
       <?php if($criteria == 'new'){ ?> <h1 class="page-title">New Loan Requests</h1> <?php } ?>
 </div>
        
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>
            <li class="active">Loan Requests</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
    <div class="btn-group">
         <a href="<?php echo base_url();?>loans/loanrequests/"  class="btn <?php if($criteria == 'all'){ echo 'btn-primary'; } ?> ">
           All Loan Requests
         </a>
          <a href="<?php echo base_url();?>loans/loanrequests/?criteria=new"  class="btn <?php if($criteria == 'new'){ echo 'btn-primary'; } ?> ">
           New Loan Requests
         </a>
          <a href="<?php echo base_url();?>loans/loanrequests/?criteria=acc"  class="btn <?php if($criteria == 'acc'){ echo 'btn-primary'; }  ?> ">
           Accepted Loan Requests
         </a>
          <a href="<?php echo base_url();?>loans/loanrequests/?criteria=den"  class="btn <?php if($criteria == 'den'){ echo 'btn-primary'; } ?> ">
           Rejected Loan Requests
         </a>
    </div>
    <div class="btn-group pull-right">
      <a href="<?php echo base_url().'loans/issueloan/';?>" class="btn btn-success"><i class="icon-plus"></i>Issue Loan</a>
      <a href="<?php echo base_url().'loans/exportimport/';?>" class="btn">Import & Export Requests</a>
    </div>
</div>
<?php if(isset($message) && $message){ ?>
    <div class="alert alert-<?php echo $message_type; ?>">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <?php echo $message;?>
    </div>
<?php } ?>
<div class="well">
    <?php if($requests->num_rows() > 0){ ?>
         <form action="<?php echo base_url().'loans/bulkaction/'?>" method="POST">
          <table class="table">
            <thead>
              <tr class="muted">
                <th>
                    <select class="input-small">
                        <option value="acc">Accept</option>
                        <option value="den">Deny</option>
                    </select>
                </th>
                <th>Customer</th>
                <th>Loan Product</th>
                <th>Principle Amount</th>
                <th>Total Amount Payable</th>
                <th>Duration</th>
                <th>Collateral</th>
      		      <th>Gaurantors</th>
              </tr>
            </thead>
            <tbody>
                 <?php 
                    $i=1;
                    foreach ($requests->result('loan_model') as $request) {
					
					   if(!$request->customer) continue;
                  ?>
                     <tr <?php if($i%2==0) echo 'class="row-strip"'; ?> >
                        <td><input type="checkbox" name="request[req_<?php echo  $request->id;?>]" value="<?php echo  $request->id; ?>"/></td>
                        <td>
                             <a href="<?php echo base_url().'customers/viewcustomerdetails/?customer_id='.$request->customer->id; ?>" title="View customer details">
                                <?php  echo  ucwords(strtolower($request->customer->name.' '.$request->customer->other_names));?>
                             </a>
                        </td>
                        <td>

                             <a href="<?php echo base_url().'loans/productdetails/?product_id='.$request->loan_product->id; ?>" title="View product details">
                               
                                <?php  echo $request->loan_product->loan_product_name; ?>

                             </a>
                        </td>
                        <td><?php  echo $request->loan_principle_amount; ?></td>
                        <td><?php  echo $request->loan_amount_payable; ?></td>
                        <td><?php  echo $request->loan_duration.' '.$request->loan_product->repayment_frequency_single.'s'; ?></td>
                        <td><?php  if($request->collateral){ echo '<a href="#" title="View Collateral Details">'.$request->collateral->name.'</a>';}else{ echo 'No collateral';} ?></td>
                        <td><?php  if($request->gaurantor){ echo '<a class="thumbnail" style="height:80px;width:80px;" href="#" title="View Gaurantor Details"><img src="'.base_url().'images/profilepics/'.$request->gaurantor->profilepic.'"/></a><a href="#" title="View Gaurantor Details">'.$request->gaurantor->name.'</a>';}else{ echo 'No Gaurantor(s)';} ?> </td>
                        <td>
                           <a class="btn btn-info btn-small" href="<?php echo base_url().'loans/editloanrequest/?loan_id='.$request->id;?>">
                              Edit Request Details
                           </a>
                        </td>
                        <td style="text-align:center" >
                            <?php if($request->request_status != 2){ ?><span><a style="margin-bottom:5px;" class="btn btn-small btn-success"  href="<?php echo base_url().'loans/acceptloan/?loan_id='.$request->id;?>">Accept</a></span><?php } ?>
                            <?php if($request->request_status != 2 && $request->request_status != 3){ ?><span><a class="btn btn-small btn-warning"  href="<?php echo base_url().'loans/rejectloan/?loan_id='.$request->id;?>">Reject</a></span><?php } ?>
                        </td>
                   </tr>
                <?php
                  $i++;
                 }
              ?>
               <tr>
                 <th style="border:none;">
                    <select class="input-small">
                        <option value="acc">Accept</option>
                        <option value="den">Deny</option>
                    </select>
                 </th>
               </tr>
            </tbody>
          </table>
          </form>
          </div>
          <div class="pagination pagination-right">
              <?php
                    $config['base_url'] = base_url().'loans/loanrequests?';
              ?>
              <?php $this->pagination->initialize($config);echo $this->pagination->create_links(); ?>
          </div>
    <?php }else{ ?>
             <div class="alert alert-info ?>">
               <?php if($this->input->get_post('per_page')){ ?>
                   No more requests
               <?php }else{ ?>
                   No loan requests
               <?php } ?>
             </div>
              <?php if($this->input->get_post('per_page')){ ?>
                  <a class="btn btn-success" href="<?php echo base_url().'loans/loanproducts'; ?>">Back to All</a>
                 </div>
              <?php }else{ ?>
                  <a class="btn btn-success" href="<?php echo base_url().'loans/issueloan'; ?>">Issue Loan</a>
                </div>
              <?php } ?>
    <?php } ?>