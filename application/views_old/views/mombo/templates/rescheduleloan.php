<div class="header">
       <h1 class="page-title">Reschedule Loan Payment</h1>
 </div>
        
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>
            <li><a hrf="<?php echo base_url();?>loans/loansissued/">Issued Loans</a><span class="divider">/</span></li>
            <li><a href="<?php echo base_url().'loans/loanpaymentsandcharges?loan_id='.$loan->id; ?>">Loan Payments and Charges</a><span class="divider">/</span></li>
            <li class="active">Reschedule Loan</li>
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

      <h5>Reschedule Payment</h5>

      <div id="reschedule-form-cont">

              <div class="well">

                      <table class="table">

                            <tr>
                                 <th>Loan</th>

                                 <td><?php echo $loan->loan_product->loan_product_name; ?></td>

                                 <th>Payment Balance Amount</th>

                                 <td><?php echo $payment->balance+$payment->interest_amount_balance; ?></td>

                                 <th>Payment Current Expected Date</th>

                                 <td><?php echo $payment->date_expected; ?></td>

                            </tr>
                        
                      </table>

              </div>

              <form id="reschedule-form" class="form-horizontal well" method="POST" action="<?php echo base_url().'loans/reschedulepayment/';?>" >

                    <input type="hidden" name="payment_id" value="<?php echo $payment->id; ?>">

                    <input type="hidden" name="loan_id" value="<?php echo $loan->id; ?>">

                    <div class="control-group">

                              <label class="control-label">Current Expected Date</label>

                              <div class="controls">

                                    <input type="text" name="old_date" value="<?php echo $payment->date_expected; ?>" class="input-xlarge" disabled="disabled" />

                              </div>

                    </div>

                    <div class="control-group">

                              <script type="text/javascript">

                                      

                              </script>

                              <label class="control-label">Current Expected Date</label>

                              <div class="controls">

                                  <input placeholder="e.g 2013-8-31" type="text" id="new-date" name="new_date" value="<?php if(array_key_exists('new_date', $_POST)) echo $_POST['new_date']; ?>" class="input-xlarge"/>

                              </div>

                    </div>

                    <div class="control-group">

                          <div class="controls">

                                <input type="submit" name="reschedule_payment" class="btn btn-info btn-large" value="Reschedule Payment" />

                          </div>

                    </div>

              </form>

      </div>

</div>