<div class="header">
       <h1 class="page-title">Waiver Loan Charge</h1>
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

      <h5>Waiver Charge</h5>

      <form id="make-payment-form" class="well form-horizontal" method="POST" action="<?php echo base_url().'loans/waivercharge/';?>" >

              <input type="hidden" name="loan_id" value="<?php echo $loan->id; ?>" />

              <input type="hidden" name="charge_id" value="<?php echo $charge->id; ?>" />

              <div class="control-group">


                      <label class="control-label">Charge Amount</label>

                      <div class="controls">

                            <input type="text" name="charge_amount" value="<?php echo $charge->balance; ?>" class="input-xlarge" disabled="disabled" />

                      </div>
              </div>


              <div class="control-group">


                      <label class="control-label">Waiver Amount</label>

                      <div class="controls">

                            <input type="text" name="waiver_amount" value="<?php if(array_key_exists('waiver_amount',$_POST)) echo $_POST['waiver_amount']; ?>" class="input-xlarge" />

                      </div>
              </div>

               <div class="control-group">

                      <div class="controls">

                            <input type="submit" name="waiver_charge" value="Waive Charge" class="btn btn-info btn-large" />

                      </div>
              </div>

      </form>

</div>