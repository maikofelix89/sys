 <div class="header">
       <h1 class="page-title">Monthly Collection Performance</h1>
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

     <h4>Monthly Collection Performance</h4>

     <div class="well">

         <ul class="nav nav-tabs">

               <li class="active"><a data-toggle="tab" href="#all">All</a></li>
                <li ><a data-toggle="tab" href="#week1">Week 1</a></li>
				<li ><a data-toggle="tab" href="#week2">Week 2</a></li>
				<li ><a data-toggle="tab" href="#week3">Week 3</a></li>
				<li ><a data-toggle="tab" href="#week4">Week 4</a></li>
                <li>
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
										$url = base_url().'collection_performance/index/';
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
								$url = base_url().'collection_performance/index/'.$month.'/'.$mwaka.'/1/A';
							?>
				           <a href="" data-toggle="tab" onclick="toPDF('<?php echo $url ?>')"><font color="#0000ff">Export to PDF</font></a>
				      </li>
				 </ul>
				<strong>All </strong><br />
					<?php echo $month_year; ?>
					
                <?php if( count($all_details) > 0 ){ 
				   	?>
						  <table class="table">
		                    <thead>
		                          <tr>
		                               <th>#</th>
		                               <th>Name</th>
									   <th>Loan</th>
									   <th>Initial Date Expected</th>
									   <th>Date Expected</th>
									   <th>Target</th>
									   <th>Actual</th>
		                          </tr>
		                    </thead>
		                    <tbody class="payments-body">
                        <?php 
						$total_target_amount = 0;
						$total_actual_amount = 0;
						$performance = 0;
						for($i = 0, $j = 1; $i < count($all_details); $i++){
							$details = explode("*",$all_details[$i]);
							$total_target_amount += $details[4];
							$total_actual_amount += $details[5];
							echo "<tr>";
								echo "<td>".$j."</td>";
								echo "<td><a href='".base_url().'customers/viewcustomerdetails/?customer_id='.$details[1]."'>".$details[0]."</a></td>";
								echo "<td><a href='".base_url().'loans/loanpaymentsandcharges/?loan_id='.$details[3]."'>".$details[2]."</a></td>";
								echo "<td>".$details[7]."</td>";
								echo "<td>".$details[6]."</td>";
								echo "<td>".number_format($details[4],2,'.',',')."</td>";
								echo "<td>".number_format($details[5],2,'.',',')."</td>";
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
								echo "<td></td>";
								echo "<td></td>";
								echo "<td></td>";
								echo "<td style='color: purple'>".number_format($total_target_amount,2,'.',',')."</td>";
								echo "<td style='color: blue'>".number_format($total_actual_amount,2,'.',',')."</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo '<td colspan = "6" style="color: green;text-align:right">Performance: '.$performance.'%</td>';
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

              <div  id="week1"  class="tab-pane fade">
		  		<ul class="nav nav-tabs">
			      <li class="active">
				  		<?php
							$url = base_url().'collection_performance/index/'.$month.'/'.$mwaka.'/1/1';
						?>
			           <a href="" data-toggle="tab" onclick="toPDF('<?php echo $url ?>')"><font color="#0000ff">Export to PDF</font></a>
			      </li>
				 </ul>
					<?php echo $month_year; ?><br />
					Week 1: <?php echo $week1; ?> 
					
                <?php if( count($week1_details) > 0 ){ 
				   	?>
						  <table class="table">
		                    <thead>
		                          <tr>
		                               <th>#</th>
		                               <th>Name</th>
									   <th>Loan</th>
									   <th>Initial Date Expected</th>
									   <th>Date Expected</th>
									   <th>Target</th>
									   <th>Actual</th>
		                          </tr>
		                    </thead>
		                    <tbody class="payments-body">
                        <?php 
						$total_target_amount = 0;
						$total_actual_amount = 0;
						$performance = 0;
						for($i = 0, $j = 1; $i < count($week1_details); $i++){
							$details = explode("*",$week1_details[$i]);
							$total_target_amount += $details[4];
							$total_actual_amount += $details[5];
							echo "<tr>";
								echo "<td>".$j."</td>";
								echo "<td><a href='".base_url().'customers/viewcustomerdetails/?customer_id='.$details[1]."'>".$details[0]."</a></td>";
								echo "<td><a href='".base_url().'loans/loanpaymentsandcharges/?loan_id='.$details[3]."'>".$details[2]."</a></td>";
								echo "<td>".$details[7]."</td>";
								echo "<td>".$details[6]."</td>";
								echo "<td>".number_format($details[4],2,'.',',')."</td>";
								echo "<td>".number_format($details[5],2,'.',',')."</td>";
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
								echo "<td></td>";
								echo "<td></td>";
								echo "<td></td>";
								echo "<td style='color: purple'>".number_format($total_target_amount,2,'.',',')."</td>";
								echo "<td style='color: blue'>".number_format($total_actual_amount,2,'.',',')."</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo '<td colspan = "6" style="color: green;text-align:right">Performance: '.$performance.'%</td>';
						echo "</tr>";
					?>
					 </tbody> 
                    </table>
					<?php }else{ ?>

                              <div class="alert alert-info">
                                  <button type="button" class="close" data-dismiss="alert">×</button>
                                  No result for <?php echo "Week 1 of ". $month_year ?>.
                              </div>

                  <?php } ?>
			   </div>
			   <div  id="week2"  class="tab-pane fade">
			   		<ul class="nav nav-tabs">
				      <li class="active">
					  		<?php
								$url = base_url().'collection_performance/index/'.$month.'/'.$mwaka.'/1/2';
							?>
				           <a href="" data-toggle="tab" onclick="toPDF('<?php echo $url ?>')"><font color="#0000ff">Export to PDF</font></a>
				      </li>
				 </ul>
					<?php echo $month_year; ?><br />
					Week 2: <?php echo $week2; ?> 
					
                <?php if( count($week2_details) > 0 ){ 
				   	?>
						  <table class="table">
		                    <thead>
		                          <tr>
		                               <th>#</th>
		                               <th>Name</th>
									   <th>Loan</th>
									   <th>Initial Date Expected</th>
									   <th>Date Expected</th>
									   <th>Target</th>
									   <th>Actual</th>
		                          </tr>
		                    </thead>
		                    <tbody class="payments-body">
                        <?php 
						$total_target_amount = 0;
						$total_actual_amount = 0;
						$performance = 0;
						for($i = 0, $j = 1; $i < count($week2_details); $i++){
							$details = explode("*",$week2_details[$i]);
							$total_target_amount += $details[4];
							$total_actual_amount += $details[5];
							echo "<tr>";
								echo "<td>".$j."</td>";
								echo "<td><a href='".base_url().'customers/viewcustomerdetails/?customer_id='.$details[1]."'>".$details[0]."</a></td>";
								echo "<td><a href='".base_url().'loans/loanpaymentsandcharges/?loan_id='.$details[3]."'>".$details[2]."</a></td>";
								echo "<td>".$details[7]."</td>";
								echo "<td>".$details[6]."</td>";
								echo "<td>".number_format($details[4],2,'.',',')."</td>";
								echo "<td>".number_format($details[5],2,'.',',')."</td>";
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
								echo "<td></td>";
								echo "<td></td>";
								echo "<td></td>";
								echo "<td style='color: purple'>".number_format($total_target_amount,2,'.',',')."</td>";
								echo "<td style='color: blue'>".number_format($total_actual_amount,2,'.',',')."</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo '<td colspan = "6" style="color: green;text-align:right">Performance: '.$performance.'%</td>';
						echo "</tr>";
					?>
					 </tbody> 
                    </table>
					<?php }else{ ?>

                              <div class="alert alert-info">
                                  <button type="button" class="close" data-dismiss="alert">×</button>
                                  No result for <?php echo "Week 2 of ". $month_year ?>.
                              </div>

                  <?php } ?>
			   </div>
			   <div  id="week3"  class="tab-pane fade">
			   		<ul class="nav nav-tabs">
				      <li class="active">
					  		<?php
								$url = base_url().'collection_performance/index/'.$month.'/'.$mwaka.'/1/3';
							?>
				           <a href="" data-toggle="tab" onclick="toPDF('<?php echo $url ?>')"><font color="#0000ff">Export to PDF</font></a>
				      </li>
				 </ul>
					<?php echo $month_year; ?><br />
					Week 3: <?php echo $week3; ?> 
					
                <?php if( count($week3_details) > 0 ){ 
				   	?>
						  <table class="table">
		                    <thead>
		                          <tr>
		                               <th>#</th>
		                               <th>Name</th>
									   <th>Loan</th>
									   <th>Initial Date Expected</th>
									   <th>Date Expected</th>
									   <th>Target</th>
									   <th>Actual</th>
		                          </tr>
		                    </thead>
		                    <tbody class="payments-body">
                        <?php 
						$total_target_amount = 0;
						$total_actual_amount = 0;
						$performance = 0;
						for($i = 0, $j = 1; $i < count($week3_details); $i++){
							$details = explode("*",$week3_details[$i]);
							$total_target_amount += $details[4];
							$total_actual_amount += $details[5];
							echo "<tr>";
								echo "<td>".$j."</td>";
								echo "<td><a href='".base_url().'customers/viewcustomerdetails/?customer_id='.$details[1]."'>".$details[0]."</a></td>";
								echo "<td><a href='".base_url().'loans/loanpaymentsandcharges/?loan_id='.$details[3]."'>".$details[2]."</a></td>";
								echo "<td>".$details[7]."</td>";
								echo "<td>".$details[6]."</td>";
								echo "<td>".number_format($details[4],2,'.',',')."</td>";
								echo "<td>".number_format($details[5],2,'.',',')."</td>";
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
								echo "<td></td>";
								echo "<td></td>";
								echo "<td></td>";
								echo "<td style='color: purple'>".number_format($total_target_amount,2,'.',',')."</td>";
								echo "<td style='color: blue'>".number_format($total_actual_amount,2,'.',',')."</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo '<td colspan = "6" style="color: green;text-align:right">Performance: '.$performance.'%</td>';
						echo "</tr>";
					?>
					 </tbody> 
                    </table>
					<?php }else{ ?>

                              <div class="alert alert-info">
                                  <button type="button" class="close" data-dismiss="alert">×</button>
                                  No result for <?php echo "Week 3 of ". $month_year ?>.
                              </div>

                  <?php } ?>
			   </div>
			   <div  id="week4"  class="tab-pane fade">
			   		<ul class="nav nav-tabs">
				      <li class="active">
					  		<?php
								$url = base_url().'collection_performance/index/'.$month.'/'.$mwaka.'/1/4';
							?>
				           <a href="" data-toggle="tab" onclick="toPDF('<?php echo $url ?>')"><font color="#0000ff">Export to PDF</font></a>
				      </li>
				 </ul>
					<?php echo $month_year; ?><br />
					Week 4: <?php echo $week4; ?> 
                <?php if( count($week4_details) > 0 ){ 
				   	?>
						  <table class="table">
		                    <thead>
		                          <tr>
		                               <th>#</th>
		                               <th>Name</th>
									   <th>Loan</th>
									   <th>Initial Date Expected</th>
									   <th>Date Expected</th>
									   <th>Target</th>
									   <th>Actual</th>
		                          </tr>
		                    </thead>
		                    <tbody class="payments-body">
                        <?php 
						$total_target_amount = 0;
						$total_actual_amount = 0;
						$performance = 0;
						for($i = 0, $j = 1; $i < count($week4_details); $i++){
							$details = explode("*",$week4_details[$i]);
							$total_target_amount += $details[4];
							$total_actual_amount += $details[5];
							echo "<tr>";
								echo "<td>".$j."</td>";
								echo "<td><a href='".base_url().'customers/viewcustomerdetails/?customer_id='.$details[1]."'>".$details[0]."</a></td>";
								echo "<td><a href='".base_url().'loans/loanpaymentsandcharges/?loan_id='.$details[3]."'>".$details[2]."</a></td>";
								echo "<td>".$details[7]."</td>";
								echo "<td>".$details[6]."</td>";
								echo "<td>".number_format($details[4],2,'.',',')."</td>";
								echo "<td>".number_format($details[5],2,'.',',')."</td>";
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
								echo "<td></td>";
								echo "<td></td>";
								echo "<td></td>";
								echo "<td style='color: purple'>".number_format($total_target_amount,2,'.',',')."</td>";
								echo "<td style='color: blue'>".number_format($total_actual_amount,2,'.',',')."</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo '<td colspan = "6" style="color: green;text-align:right">Performance: '.$performance.'%</td>';
						echo "</tr>";
					?>
					 </tbody> 
                    </table>
					<?php }else{ ?>

                              <div class="alert alert-info">
                                  <button type="button" class="close" data-dismiss="alert">×</button>
                                  No result for <?php echo "Week 4 of ". $month_year ?>.
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