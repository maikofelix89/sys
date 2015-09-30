 <div class="header">
       <h1 class="page-title">Monthly Disbursement Performance</h1>
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

     <h4>Monthly Disbursement Performance</h4>

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
										$url = base_url().'disbursement_performance/index/';
									?>
                                   Month: 
								   <select name="month" id="month">
								   		<option value="0">---select month---</option>
										<option value="1">January</option>
										<option value="2">February</option>
										<option value="3">March</option>
										<option value="4">April</option>
										<option value="5">May</option>
										<option value="6">June</option>
										<option value="7">July</option>
										<option value="8">August</option>
										<option value="9">September</option>
										<option value="10">October</option>
										<option value="11">November</option>
										<option value="12">December</option>
								   </select>
									Year: 
									<?php  
										$current_year = date('Y');
									?>
								   <select name="year" id="year">
								   		<option value="0">---select year---</option>
										<?php 
										for($i = 0; $i < 10; $i++){
											$year_b = strtotime ( '-'.$i.' year' , strtotime ( $current_year  ) ) ;
											$year = date ( 'Y' , $year_b );
											echo '<option value="'.$year.'">'.$year.'</option>';
										}
										
										?>
								   </select>
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
								$url = base_url().'collection_performance/index/'.$month.'/'.$mwaka.'/1';
							?>
				           <!--<a href="" data-toggle="tab" onclick="toPDF('<?php echo $url ?>')"><font color="#0000ff">Export to PDF</font></a>-->
				      </li>
				 </ul>
				
					<?php echo $month_year; ?>
					
                <?php if( count($all_details) > 0 ){ 
					$CI = & get_instance();
					$CI->load->model('disbursement_performance_model','dp_model');
			        
				   	?>
						  <table class="table">
		                    <thead>
		                          <tr>
		                               <th>#</th>
		                               <th>Loan Product</th>
									   <th>Target</th>
									   <th>Actual</th>
									   <th>Performance</th>
								  </tr>
		                    </thead>
		                    <tbody class="payments-body">
                        <?php 
						$total_target_amount = 0;
						$total_actual_amount = 0;
						$performance = 0;
						for($i = 0, $j = 1; $i < count($all_details); $i++){
							$details = explode("*",$all_details[$i]);
							$total_target_amount += $details[1];
							$total_actual_amount += $details[2];
							echo "<tr>";
								echo "<td>".$j."</td>";
								$loan_product = $CI->dp_model->get_loan_product($details[0]);
								echo "<td>".$loan_product."</td>";
								echo "<td>".number_format($details[1],2,'.',',')."</td>";
								echo "<td>".number_format($details[2],2,'.',',')."</td>";
								echo "<td>".$details[3]."%</td>";
							echo "</tr>";
							$j++;
						}
						$performance = round(($total_actual_amount/$total_target_amount)*100,2);
						
						echo "<tr>";
								echo "<td></td>";
								echo "<td></td>";
								echo "<td></td>";
								echo "<td></td>";
								echo "<td></td>";
								echo "<td style='color: purple'></td>";
								echo "<td style='color: blue'></td>";
						echo "</tr>";
						
						echo "<tr>";
								echo "<td></td>";
								echo "<td></td>";
								echo "<td style='color: purple'>".number_format($total_target_amount,2,'.',',')."</td>";
								echo "<td style='color: blue'>".number_format($total_actual_amount,2,'.',',')."</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo '<td colspan = "3" style="color: green;text-align:right">Overall Performance: '.$performance.'%</td>';
						echo "</tr>";
					?>
					 </tbody> 
                    </table>
					<?php }else{ ?>

                              <div class="alert alert-info">
                                  <button type="button" class="close" data-dismiss="alert">×</button>
                                  No result for <?php echo $month_year ?>.
                              </div>

                  <?php } ?>
              </div>
              
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript">
	function go(url_part){
		var month = document.getElementById('month').value;
		var year = document.getElementById('year').value;
		var url = url_part+month+'/'+year;
		
		if(month == 0 && year == 0){
			alert('Month and year cannot be empty');
		}
		else if(month == 0){
			alert('Month cannot be empty');
		}
		else if(year == 0){
			alert('Year cannot be empty');
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