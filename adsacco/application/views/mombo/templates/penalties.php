<div class="header">
        
         <h1 class="page-title">Loan Penalties & Charges</h1> 

</div>
        
        <ul class="breadcrumb">

            <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>

             <li><a href="<?php echo base_url();?>loans/loansissued/">Issued Loans</a> <span class="divider">/</span></li>

            <li class="active"> Penalties and Charges</li>

        </ul>

<div class="container-fluid">

  <div class="row-fluid">
    
    <div class="btn-toolbar">

       <div class="btn-group">
       </div>

    </div>

   <form class="form-horizontal" id="payments-filter" method="POST" action="<?php echo base_url().'loans/penalties/';?>">

        <script type="text/javascript">

            $(function(){

                 $('#date-start').datepicker({format:'yyyy-mm-dd'});

                 $('#date-end').datepicker({format:'yyyy-mm-dd'});

            });

        </script>
        
        <div class="control-group">

            <div class="controls">
                   From

                    <input type="text" name="start_date" id="date-start"  value="<?php if($date = $_POST['start_date']) echo $date; ?>"/>

                    To
                 
                    <input type="text" name="end_date" id="date-end" value="<?php if($date = $_POST['end_date']) echo $date; ?>"/>

                    <input type="submit" name="go" class="btn btn-small btn-info" value="Go"/>
                  
            </div>

        </div>

    </form>


    <div class="well">
		   <ul class="nav nav-tabs">

                <li class="active"><a data-toggle="tab" href="#unsettled">Unsettled</a></li>
                <li ><a data-toggle="tab" href="#settled">Settled</a></li>
            </ul>
			
			<div class="tab-content">
				<div id="unsettled" class="tab-pane active">
					<?php
						$check = FALSE; 
						foreach($penalties  as $charge){
							if($charge->paid == 0){
								$check = TRUE;
								break;
							}
						}
					?>
					<?php if($check): ?>

	    		    <table class="table">

	    		    		<thead>

	    		    			<tr>
	    		    				<th>Date</th>
	    		    				<th>Type</th>
	    		    				<th>Amount</th>
	    		    				<th>Balance</th>
	    		    				<th>Status</th>
	    		    				<th></th>
	    		    			</tr>
	    		    			
	    		    		</thead>
	    		    		<tbody>

		    		    		<?php foreach($penalties  as $charge): ?>
										<?php if($charge->paid == 1) continue; ?>
		    		    				<tr>
		    		    					
		    		    					 <td><?php echo $charge->date; ?></td>
		    		    					 <td><?php echo $charge->name; ?></td>
		    		    					 <td><?php echo $charge->amount; ?></td>
		    		    					 <td><?php echo $charge->balance; ?></td>
		    		    					 <td><?php echo (($charge->paid == 1) ? "Settled" : "Not Settled");?></td>
		    		    					 <td><a class="btn btn-info btn-small" href="<?php echo base_url().'loans/loanpaymentsandcharges/?loan_id='.$charge->loan; ?>">View Loan Details</a></td>

		    		    				</tr>

		    		    		<?php endforeach;?>
	    		    			
	    		    		</tbody>
	    		    	
	    		    </table>

	    		<?php else: ?>

	    			 <div class="">
	    			      No penalty or charge records in this category.
	    			 </div>

	    		<?php endif; ?>
				</div>
				<div  id="settled"  class="tab-pane fade">
					<?php
						$check = FALSE; 
						foreach($penalties  as $charge){
							if($charge->paid == 1){
								$check = TRUE;
								break;
							}
						}
					?>
					<?php if($check): ?>

	    		    <table class="table">

	    		    		<thead>

	    		    			<tr>
	    		    				<th>Date</th>
	    		    				<th>Type</th>
	    		    				<th>Amount</th>
	    		    				<th>Balance</th>
	    		    				<th>Status</th>
	    		    				<th></th>
	    		    			</tr>
	    		    			
	    		    		</thead>
	    		    		<tbody>

		    		    		<?php foreach($penalties  as $charge): ?>
										<?php if($charge->paid == 0) continue; ?>
		    		    				<tr>
		    		    					
		    		    					 <td><?php echo $charge->date; ?></td>
		    		    					 <td><?php echo $charge->name; ?></td>
		    		    					 <td><?php echo $charge->amount; ?></td>
		    		    					 <td><?php echo $charge->balance; ?></td>
		    		    					 <td><?php echo (($charge->paid == 1) ? "Settled" : "Not Settled");?></td>
		    		    					 <td><a class="btn btn-info btn-small" href="<?php echo base_url().'loans/loanpaymentsandcharges/?loan_id='.$charge->loan; ?>">View Loan Details</a></td>

		    		    				</tr>

		    		    		<?php endforeach;?>
	    		    			
	    		    		</tbody>
	    		    	
	    		    </table>

		    		<?php else: ?>

		    			 <div class="">
		    			      No penalty or charge records in this category.
		    			 </div>

		    		<?php endif; ?>
				</div>
			</div>
    </div>

 </div>

</div>