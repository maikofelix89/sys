<div class="header">
       <h1 class="page-title">Charge Loan</h1>
 </div>
        
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url();?>mombo/home">Home</a> <span class="divider">/</span></li>
            <li><a href="<?php echo base_url().'loans/loanpaymentsandcharges?loan_id='.$loan->id; ?>">Payments and Charges</a></li><span class="divider">/</span></li>
            <li class="active">Charge Loan</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
    <div class="btn-group">
         <a href="<?php $criteria =''; echo base_url();?>loans/loansissued/?criteria=all"  class="btn <?php if($criteria == 'all') echo 'btn-primary';?> ">
           All Issued Loans
         </a>
          <a href="<?php echo base_url();?>loans/loansissued/?criteria=paid"  class="btn <?php if($criteria == 'paid') echo 'btn-primary';?>">
           Settled Issued Loans
         </a>
          <a href="<?php echo base_url();?>loans/loansissued/?criteria=unpaid"  class="btn  <?php if($criteria == 'unpaid') echo 'btn-primary';?>">
           Unsettled Issued Loans
         </a>
    </div>
    <div class="btn-group pull-right">
      <a href="<?php echo base_url().'loans/issueloan/';?>" class="btn btn-success"><i class="icon-plus"></i>Issue Loan</a>
      <a href="<?php echo base_url().'loans/exportimport/';?>" class="btn">Import & Export Loans Issued</a>
    </div>
</div>


<?php if(isset($message) && $message){ ?>
    <div class="alert alert-<?php echo $message_type; ?>">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <?php echo $message;?>
    </div>
<?php } ?>

<div class="well">

      <h5><?php echo $payment_title; ?></h5>

      <form id="make-payment-form" class="well form-horizontal" method="POST" action="<?php echo base_url().'loans/chargefeeonloan/';?>" >

              <input type="hidden" name="loan_id" value="<?php echo $loan->id; ?>" />

              <div class="control-group">

                      <label class="control-label">Loan Details</label>

                      <div class="controls">
					  
					        <label class="control-label">Customer</label>
					  
					        <input type="text" name="loan_name_text" value="<?php echo ucwords(strtolower($loan->customer->name.' '$loan->customer->other_names)); ?>" class="input-xlarge" disabled="disabled" />
							
							<label class="control-label">Loan Product</label>

                            <input type="text" name="loan_name_text" value="<?php echo $loan->loan_product->loan_product_name; ?>" class="input-xlarge" disabled="disabled" />
							
							 <label class="control-label">Loan Amount Payable</label>
							
							<input type="text" name="loan_name_text" value="<?php echo $loan->loan_amount_payable; ?>" class="input-xlarge" disabled="disabled" />

                      </div>
              </div>
			  
			  
              <div class="control-group">


                      <label class="control-label">Loan Charge</label>

                      <div class="controls">
								
								<select name="charge" class="input-xlarge">
								
								        <?php foreach(array(
										'upaidcheque_fee' => 'Unpaid Cheque Fee',
										'latepayment_fee' => 'Late Payment Fee',
										'transaction_fee' => 'Transaction Fee',
										'interest_fee'    => 'Interest Fee',
										'service_fee'     => 'Service Fee',
										) as $charge=>$name): ?>
										     <option value="<?php echo $charge; ?>" <?php if(array_key_exist('charge',$_POST) && $charge == $_POST['charge']) echo ' selected="selected"'; ?> > <?php echo $name; ?></option>
										<?php endforeach; ?>
								</select>

                      </div>
              </div>


              <div class="control-group">


                      <label class="control-label">Charge Amount</label>

                      <div class="controls">

                            <input type="text" name="charge_amount" value="<?php if(array_key_exists('charge_amount',$_POST)) echo $_POST['charge_amount']; ?>" class="input-xlarge" />

                      </div>
              </div>
			  
			  
			  <div class="control-group">


                      <label class="control-label">Charge Description</label>

                      <div class="controls">

                            <textarea name="charge_description" class="input-xlarge"><?php if(array_key_exists('charge_description',$_POST)) echo $_POST['charge_description']; ?></textarea>

                      </div>
              </div>


               <div class="control-group">

                      <div class="controls">

                            <input type="submit" name="charge_loan" value="Charge Loan" class="btn btn-info btn-large" />

                      </div>
              </div>

      </form>

</div>