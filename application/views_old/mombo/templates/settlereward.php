<div class="header">
       <h1 class="page-title">Settle Reward</h1>
 </div>
        
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>
            <li><a href="<?php echo base_url();?>loans/rewards">Mombo Loyal</a><span class="divider">/</span></li>
            <li class="active">Settle Reward</li>
        </ul>

       <script type="text/javascript">

			$(function(){

				 $('#date').datepicker({format:'yyyy-mm-dd'});
				 $('#date1').datepicker({format:'yyyy-mm-dd'});

			});

		</script>                



<div class="well">

    <div id="well">

            <form id="make-payment-form" class="well" method="POST" action="<?php echo base_url().'loans/rewards/'.$redeemed_id;?>">
				  <div id="loan-payment-amount" class="control-group">

                            <h5>Settle Reward Request</h5>
							
                            <div class="controls well">
								<?php echo $message; ?>
								<input type="hidden" name="redeemed_id" value="<?php echo $redeemed_id; ?>" readonly class="input-xlarge" />
								<input type="hidden" name="cust_name" value="<?php echo $cust_name; ?>" readonly class="input-xlarge" />
								<input type="hidden" name="cust_fname" value="<?php echo $cust_fname; ?>" readonly class="input-xlarge" />
								<input type="hidden" name="rew_type" value="<?php echo $rew_type; ?>" readonly class="input-xlarge" />
                                <input type="hidden" name="rew_value" value="<?php echo $rew_value; ?>" readonly class="input-xlarge" />
								
								<label class="control-label">Date</label>
								<input type="date" id="date1" name="date" placeholder="YYYY-MM-DD" required=""/>
								
								<label class="control-label">Payment Channel</label>
                                <select name="payment_channel" class="input-xlarge">
								        <option value="">--Select--</option>
								        <option value="cash">Cash</option>
										<option value="cheque">Cheque</option>
										<option value="mpesa">Mpesa</option>
								</select>
								
								<label class="control-label">Reference Number</label>
								<input type="text" name="reference_num" required="" />
								
								 <label class="control-label">Brief Description</label>

                                <textarea name="payment_description" class="input-xlarge"></textarea>
                            
                            </div>

                      </div>
					 

                      <div class="control-group">

                            <div class="controls">

                                <input type="submit" name="make_payment" value="Settle" class="btn btn-info btn-large input-xlarge" />
                            
                            </div>
                      </div>
			</form>
	</div>
   

</div>