<div class="header">
       <h1 class="page-title">Make a Payment</h1>
 </div>
        
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url();?>mombo/home">Home</a> <span class="divider">/</span></li>
            <li><a href="<?php echo base_url().'loans/loanpaymentsandcharges?loan_id='.$loan->id; ?>">Payments and Charges</a></li><span class="divider">/</span></li>
            <li class="active">Make a Payment</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
    <div class="btn-group">
         <a href="<?php echo base_url();?>loans/loansissued/?criteria=all"  class="btn <?php if($criteria == 'all') echo 'btn-primary';?> ">
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

<?php 

     $payment_title    = "Make a Payment";

     $payment_amount_label = "Pay Amount";

     $item_name = 'payment_id';

     $pre_payment_amount_label = "Total Payment Amount";

     $balance = 0;

     if($type == 'payment')  $balance = $item->balance + $item->interest_amount_balance;

     if($type == 'charge'){

         $payment_title = "Make Charge Payment";

         $payment_amount_label = 'Charge Payment Amount';

         $pre_payment_amount_label = "Total Charge Amount";

         $item_name = 'charge_id';

         $balance = $item->balance;

     }
     
?>

<div class="well">

      <h5><?php echo $payment_title; ?></h5>

      <form id="make-payment-form" class="well form-horizontal" method="POST" action="<?php echo base_url().'loans/pay1/';?>" >

              <input type="hidden" name="loan_id" value="<?php echo $loan->id; ?>" />

              <input type="hidden" name="type" value="<?php echo $type; ?>" />

              <input type="hidden" name="<?php echo $item_name; ?>" value="<?php echo $item->id; ?>" />


              <div class="control-group">


                      <label class="control-label"><?php echo $payment_amount_label; ?></label>

                      <div class="controls">

                            <input type="text" name="payment_amount" value="<?php if(array_key_exists('payment_amount',$_POST)) echo $_POST['payment_amount']; ?>" class="input-xlarge" />

                      </div>
              </div>

              <div class="control-group">


                      <label class="control-label">Payment Channel</label>

                      <div class="controls">
								
								<select name="payment_channel" class="input-xlarge">
								        <option value="">Select Payment channel</option>
								        <option value="cash" <?php if(array_key_exists('payment_channel', $_POST) && $_POST['payment_channel'] == 'cash'){ echo ' selected="selected"'; } ?>>Cash</option>
										<option value="cheque" <?php if(array_key_exists('payment_channel', $_POST) && $_POST['payment_channel'] == 'cheque'){ echo ' selected="selected"'; } ?>>Cheque</option>
										<option value="mpesa" <?php if(array_key_exists('payment_channel', $_POST) && $_POST['payment_channel'] == 'mpesa'){ echo ' selected="selected"'; } ?>>Mpesa</option>
								</select>

                      </div>
              </div>
			  
			   <div class="control-group">

                     <label class="control-label">Payment Description</label>
					 
                      <div class="controls">
								
						  <textarea name="payment_description" class="input-xlarge"><?php if(array_key_exists('payment_amount', $_POST)){ echo $_POST['payment_amount']; } ?></textarea>

                      </div>
              </div>
			  
			  
								

                               

               <div class="control-group">

                      <div class="controls">

                            <input type="submit" name="make_payment" value="Make Payment" class="btn btn-info btn-large" />

                      </div>
              </div>

      </form>

</div>