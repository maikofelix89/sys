<div class="header">
       <h1 class="page-title">Waiver Loan Transaction Charge</h1>
 </div>
        
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url();?>mombo/home">Home</a> <span class="divider">/</span></li>
            <li><a href="<?php echo base_url().'loans/loanpaymentsandcharges?loan_id='.$loan->id; ?>">Payments and Charges</a></li><span class="divider">/</span></li>
            <li class="active">Waiver Charge</li>
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


<div class="well">

      <h5>Waiver Transaction Charge and Accept Request</h5>

      <form id="make-payment-form" class="well form-horizontal" method="POST" action="<?php echo base_url().'loans/confirmrequest/';?>" >

              <input type="hidden" name="loan_id" value="<?php echo $loan->id; ?>" />

              <div class="control-group">


                      <label class="control-label">Waiver Amount</label>

                      <div class="controls">

                            <input type="text" name="transaction_fee_waiver" value="<?php if(array_key_exists('transaction_fee_waiver',$_POST)) echo $_POST['transaction_fee_waiver']; ?>" class="input-xlarge" />

                      </div>
              </div>
			  
			  <div class="control-group">


                      <label class="control-label">Disbursement Brief Description</label>

                      <div class="controls">

                            <input type="text" name="description" value="" class="input-xlarge" />

                      </div>
              </div>

               <div class="control-group">

                      <div class="controls">

                            <input type="submit" name="waiver_charge" value="Accept Loan Request" class="btn btn-danger btn-large" />
							
							              <a href="<?php echo base_url().'loans/loanrequests'; ?>" class="btn btn-large">Cancel</a>

                      </div>
              </div>

      </form>

</div>