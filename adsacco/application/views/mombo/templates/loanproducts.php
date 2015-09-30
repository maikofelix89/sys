 <div class="header">
       <h1 class="page-title">Loan Products</h1>
 </div>
        
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>
            <li class="active">Loan Products</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
    <div class="btn-group">
         <a href="<?php echo base_url();?>loans/loanproducts/"  class="btn btn-primary">
           All Products
         </a>
    </div>
    <div class="btn-group pull-right">
      <a href="<?php echo base_url().'loans/addnewproduct/';?>" class="btn btn-success"><i class="icon-plus"></i> New Product</a>
      <a href="<?php echo base_url().'loans/exportimport/';?>" class="btn">Import & Export Products</a>
    </div>
</div>
<?php if(isset($message) && $message){ ?>
    <div class="alert alert-<?php echo $message_type; ?>">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <?php echo $message;?>
    </div>
<?php } ?>
<div class="well">
    <?php if($products->num_rows() > 0){ ?>
         <form action="<?php echo base_url().'loans/bulkaction/'?>" method="POST">
          <table class="table">
            <thead>
              <tr class="muted">
                <th>
                    <select class="input-small">
                        <option value="del">Delete</option>
                    </select>
                </th>
                <th>Product Name</th>
                <th>Product Description</th>
                <th>Interest Type</th>
                <th>Interest Rate</th>
                <th>Minimum Amount</th>
      		      <th>Maximum Amount</th>
                <th>Duration</th>
                <th>Payment Frequency</th>
              </tr>
            </thead>
            <tbody>
                 <?php 
                    $i=1;
                    foreach ($products->result('product_model') as $product) {
                  ?>
                     <tr <?php if($i%2==0) echo 'class="row-strip"'; ?> >
                        <td><input type="checkbox" name="product[prod_<?php echo  $product->id;?>]" value="<?php echo  $product->id; ?>"/></td>
                        <td><?php echo $product->loan_product_name; ?></td>
                        <td><?php echo $product->loan_product_description; ?></td>
                        <td><?php echo $product->interest_type; ?></td>
                        <td><?php echo $product->interest_rate;?> %</td>
                        <td><?php echo $product->minimum_amount_loaned;?></td>
                        <td><?php echo $product->maximum_amount_loaned;?> </td>
      				          <td><?php echo $product->minimum_duration;?> &gt; x &lt; <?php echo $product->maximum_duration;?></td>
                        <td><?php echo $product->loan_repayment_frequency;?></td>
                        <td>
                            <a class="btn btn-small btn-success" style="margin-bottom:5px;" href="<?php echo base_url().'loans/editproduct/?product_id='.$product->id; ?>">Edit</a>
                            <a class="btn btn-small btn-warning" style="margin-bottom:5px;" href="<?php echo base_url().'loans/deleteproduct/?product_id='.$product->id; ?>">Remove</a>
                            <a class="btn btn-small btn-info" href="<?php echo base_url().'loans/productdetails/?product_id='.$product->id; ?>">More...</a>
                        </td>
                   </tr>
                <?php
                  $i++;
                 }
              ?>
               <tr>
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
          <div class="pagination pagination-right">
              <?php
                    $config['base_url'] = base_url().'loans/loanproducts?';
              ?>
              <?php $this->pagination->initialize($config);echo $this->pagination->create_links(); ?>
          </div>
    <?php }else{ ?>
             <div class="alert alert-info ?>">
               <?php if($this->input->get_post('per_page')){ ?>
                   No More loan products
               <?php }else{ ?>
                   No loan products added yet
               <?php } ?>
             </div>
              <?php if($this->input->get_post('per_page')){ ?>
                  <a class="btn btn-success" href="<?php echo base_url().'loans/loanproducts'; ?>">Back to All</a>
              </div>
              <?php }else{ ?>
                  <a class="btn btn-success" href="<?php echo base_url().'loans/addnewproduct'; ?>">Add New Product</a>
             
              </div>
              <?php } ?>
    <?php } ?>
</div>