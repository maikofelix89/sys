<script type="text/javascript">

		$(function(){

		     $('#date').datepicker({format:'yyyy-mm-dd'});

		});

	</script>
 <div class="header">
       <h1 class="page-title">Customer Balance Summary</h1>
 </div>
        
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>
            <li class="active"></li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
    <div class="btn-group">
         <a href="<?php echo base_url();?>loans/loanproducts/"  class="btn btn-primary">
          <!-- All Payments-->
         </a>
    </div>
</div>
<?php if(isset($message) && $message){ ?>
    <div class="alert alert-<?php echo $message_type; ?>">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <?php echo $message;?>
    </div>
<?php } ?>
<div class="well">

     <h4>Customer Balance Summary</h4>

     <div class="well">

         <ul class="nav nav-tabs">

               <!--<li class="active"><a data-toggle="tab" href="#all">All</a></li>
                <li ><a data-toggle="tab" href="#week1">Week 1</a></li>
				<li ><a data-toggle="tab" href="#week2">Week 2</a></li>
				<li ><a data-toggle="tab" href="#week3">Week 3</a></li>
				<li ><a data-toggle="tab" href="#week4">Week 4</a></li>
                <li>-->
                     <form class="form-horizontal" id="payments-filter" method="POST" action="<?php echo base_url().'loans/statements/';?>">

                        <script type="text/javascript">

                            $(function(){

                                 $('#date-start').datepicker({format:'yyyy-mm-dd'});

                                 $('#date-end').datepicker({format:'yyyy-mm-dd'});

                            });

                        </script>
                        
                        <div class="control-group">

                                <div class="controls">
									<?php 
										$url = base_url().'customer_balance_summary/index/';
									?>
                                   Date: 
								  <input type="text" id="date" name="date" value="" />
                                    <input type="button" class="btn btn-small btn-info" value="Go" onclick="go('<?php echo $url; ?>');"/>
                                  
                            </div>

                        </div>

                    </form>
                </li>

         </ul>

         <div class="tab-content">

              <div id="all" class="tab-pane active">
			  	<ul class="nav nav-tabs">
				      <li class="active">
					  		<?php
								$url = base_url().'customer_balance_summary/index/'.$month.'/'.$mwaka.'/1';
							?>
				           <!--<a href="" data-toggle="tab" onclick="toPDF('<?php echo $url ?>')"><font color="#0000ff">Export to PDF</font></a>-->
				      </li>
				 </ul>
				
					<?php //echo date("M d, Y", strtotime($date)); ?>
					
                <?php if( count($balance_summaries) > 0 ){ 
					$CI = & get_instance();
					$CI->load->model('customer_balance_summary_model','cbs_model');
			        
				   	?>
						  <table class="table">
		                    <thead>
									<tr>
		                               <th colspan="3" style="text-align: center">Customer Balance Summary as of <?php echo date("M d, Y", strtotime($date)); ?></th>
								  </tr>
								  <tr>
		                               <th>#</th>
		                               <th>Name</th>
									   <th>Sum Balance</th>
								  </tr>
		                    </thead>
		                    <tbody class="payments-body">
                        <?php 
						$total_amount = 0;
						for($i = 0, $j = 1; $i < count($balance_summaries); $i++){
							$balance_summary = explode("*",$balance_summaries[$i]);
							$total_amount += $balance_summary[1];
							echo "<tr>";
								echo "<td>".$j."</td>";
								echo "<td>".$balance_summary[0]."</td>";
								echo "<td>".number_format($balance_summary[1],2,'.',',')."</td>";
							echo "</tr>";
							$j++;
						}
						echo "<tr>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td></td>";
							echo "<th style='color:purple'>Total Amount</th>";
							echo "<th style='color:purple'>".number_format($total_amount,2,'.',',')."</th>";
						echo "</tr>";
					?>
					 </tbody> 
                    </table>
					<?php }else{ ?>

                              <div class="alert alert-info">
                                  <button type="button" class="close" data-dismiss="alert">×</button>
                                  No result for <?php echo date("M d, Y", strtotime($date)); ?>.
                              </div>

                  <?php } ?>
              </div>
              
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript">
	function go(url_part){
		var date = document.getElementById('date').value;
		
		var url = url_part+date+"/0";
		
		if(date == 0){
			alert('Select date');
		}
		else{
			window.location.href=url;
		}
	}
</script>

<script type="text/javascript">
function toPDF(url)
{
	window.location.href=url;
}
</script>