
        <script src="<?php echo base_url();?>js/modernizr.custom.all.js" type="text/javascript"></script>
		<script src="<?php echo base_url();?>js/css3MediaQueries.js" type="text/javascript"></script>
		<script src="<?php echo base_url();?>js/jquery.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url();?>js/jquery.easing.js" type="text/javascript"></script>
		<script>
		
		function Calculate(){
		var amount = document.getElementById('amount').value
		var duration = document.getElementById('duration').value
		
		var product = document.getElementById('product');
		var item = product.options[product.selectedIndex].value;
		if(item=="Select Loan Product"){
		document.calc.product.focus();
		document.getElementById('calculations').innerHTML="<div class='box error_box'><table><tr><td>&nbsp;</td><td><p>Select A loan Product</p></td></tr></table></div>";
		}else{
		///////////////////////////begin code here
		 if(isNaN(amount)){
		 document.calc.amount.focus();
	document.getElementById('calculations').innerHTML="<div class='box error_box'><table><tr><td>&nbsp;</td><td><p>"+amount+" is not a valid amount. Kindly enter the amount in Kenyan Shillings e.g. 120000</p></td></tr></table></div>";
 }else{
	
			if(isNaN(duration)){
			//alert("Duration="+duration+" is not a number");
			var myElem=document.getElementById('calculations');
				document.getElementById('calculations').innerHTML="<div class='box error_box'><table><tr><td>&nbsp;</td><td><p>"+duration+" is not a valid duration. Kindly enter the duration in Months, e.g 10</p></td></tr></table></div>";
				document.calc.duration.focus();
			}else{
			/////////////////sort the products
			if(item=="emergency"){//emergencr
				if(amount>=2000 && amount<=100000){
					if(duration>=0.25 && duration<=1){
					var comp=amount*0.1*duration;//compound(amount,duration,10,0.25);
					amount = parseInt(amount, 10);
					comp = parseInt(comp, 10);
					var total=comp+amount;
					inst=comp/duration;
					inst = roundNumber(inst,2);
					comp = roundNumber(comp,2);
					total = roundNumber(total,2);
					if(comp=="0"){
					comp="Cannot be computed for "+duration+" months";
					total="N/A";
					}
					document.getElementById('calculations').innerHTML="<div class='box warning_bo'><p><table class='table' border='1' style='font-size:17px;'><tr><th colspan='2'>Emergency Loan</th></tr><tr><td style='padding:21px; width:311px;'>Principle amount in Ksh.</td><td style='padding:21px;'>"+amount+"</td></tr><tr ><td style='padding:21px; width:311px;'>Proposed duration of Loan </td><td style='padding:21px;'>"+duration+"</td></tr><tr><td style='padding:21px; width:311px;'>Interest rate</td><td style='padding:21px;'>10%</td></tr><tr><td style='padding:21px; width:311px;'>Interest </td><td style='padding:21px;'><strong>"+inst+"</strong> </td></tr><tr><td style='padding:21px; width:311px; font-size:20px;'>TOTAL AMOUNT in Kshs.</td><td style='padding:21px; font-size:20px; color:#228B22;'>"+total+" Payable over 1 week</td></tr></table></p></div>";

					
					}else{
													document.getElementById('calculations').innerHTML="<div class='box warning_box'><table><tr><td>&nbsp;</td><td><p>Duration for <strong>Emergency Loan </strong> is Short term. Period of 1 week</p></td></tr></table></div>";
					}
				}else{
								document.getElementById('calculations').innerHTML="<div class='box warning_box'><table><tr><td>&nbsp;</td><td><p><strong>Emergency Loans </strong> issued are in the range of Kshs. 2,000-100,000</p></td></tr></table></div>";

				}
			
			}else if(item=="payday"){//payday
			
			
				if(amount>=2000 && amount<=50000){
					if(duration>=1){
					var comp=amount*0.13*duration;//compound(amount,duration,13,1);
					amount = parseInt(amount, 10);
					comp = parseInt(comp, 10);
				var total=comp+amount;
					inst=comp/duration;
					inst = roundNumber(inst,2);
					comp = roundNumber(comp,2);
					total = roundNumber(total,2);
					if(comp=="0"){
					comp="Cannot be computed for "+duration+" months";
					total="N/A";
					}
					document.getElementById('calculations').innerHTML="<div class='box warning_bo'><p><table class='table' border='1' style='font-size:17px;'><tr><th colspan='2'>Payday Loan</th></tr><tr><td style='padding:21px; width:311px;'>Principle amount in Ksh.</td><td style='padding:21px;'>"+amount+"</td></tr><tr ><td style='padding:21px; width:311px;'>Proposed duration of Loan </td><td style='padding:21px;'>"+duration+"</td></tr><tr><td style='padding:21px; width:311px;'>Interest rate</td><td style='padding:21px;'>13%</td></tr><tr><td style='padding:21px; width:311px;'>Interest</td><td style='padding:21px;'><strong>"+inst+"</strong></td></tr><tr><td style='padding:21px; width:311px; font-size:20px;'>TOTAL AMOUNT in Kshs.</td><td style='padding:21px; font-size:20px; color:#228B22;'>"+total+" Payable within 1 month</td></tr></table></p></div>";
					
					}else{
													document.getElementById('calculations').innerHTML="<div class='box warning_box'><table><tr><td>&nbsp;</td><td><p>Duration for <strong>Payday Loans </strong> must be over 1 month.</p></td></tr></table></div>";
					}
				}else{
								document.getElementById('calculations').innerHTML="<div class='box warning_box'><table><tr><td>&nbsp;</td><td><p><strong>Payday Loans </strong>issued range from kahs. 2,000-50,000.00</p></td></tr></table></div>";

				}
			
			
			}else if(item=="personal"){//personal
			
			if(amount>=10000 && amount<=200000){
					if(duration>=1 && duration<=2){
					var comp=amount*0.15*duration;//compound(amount,duration,15,2);
					amount = parseInt(amount, 10);
					comp = parseInt(comp, 10);
					var total=comp+amount;
					inst=comp/duration;
					inst = roundNumber(inst,2);
					comp = roundNumber(comp,2);
					total = roundNumber(total,2);
					if(comp=="0"){
					comp="Cannot be computed for "+duration+" months";
					total="N/A";
					}
					document.getElementById('calculations').innerHTML="<div class='box warning_bo'><p><table class='table' border='1' style='font-size:17px;'><tr><th colspan='2'>Personal Loan</th></tr><tr><td style='padding:21px; width:311px;'>Principle amount in Ksh.</td><td style='padding:21px;'>"+amount+"</td></tr><tr ><td style='padding:21px; width:311px;'>Proposed duration of Loan </td><td style='padding:21px;'>"+duration+"</td></tr><tr><td style='padding:21px; width:311px;'>Interest rate</td><td style='padding:21px;'>15% (Reducing Balance)</td></tr><tr><td style='padding:21px; width:311px;'>Interest </td><td style='padding:21px;'><strong>"+inst+"</strong></td></tr><tr><td style='padding:21px; width:311px; font-size:20px;'>TOTAL AMOUNT in Kshs.</td><td style='padding:21px; font-size:20px; color:#228B22;'>"+total+"</td></tr></table></p></div>";
					}else{
													document.getElementById('calculations').innerHTML="<div class='box warning_box'><table><tr><td>&nbsp;</td><td><p>For<strong>Personal Loans </strong> Choose a term of 1 month to 2 months.</p></td></tr></table></div>";
					}
				}else{
								document.getElementById('calculations').innerHTML="<div class='box warning_box'><table><tr><td>&nbsp;</td><td><p><strong>Personal Loans </strong> issued range from Kshs. 10,000.00-200,000.00</p></td></tr></table></div>";

				}
			
			
			
			
			}else if(item=="business"){//business
			
			
				if(amount>=50000 && amount<=200000){
					if(duration>=3 && duration<=6){
					var pmt=compound(amount,duration,15.78,1);
					
					
					inst=pmt;
					inst = roundNumber(inst,2);
					pmt = roundNumber(pmt,2);
					var total=pmt*duration;
					total = roundNumber(total,2);
				
					if(comp=="0"){
					comp="Cannot be computed for "+duration+" months";
					total="N/A";
					}
					document.getElementById('calculations').innerHTML="<div class='box warning_bo'><p><table class='table' border='1' style='font-size:17px;'><tr><th colspan='2'>Business Loan</th></tr><tr><td style='padding:21px; width:311px;'>Principle amount in Ksh.</td><td style='padding:21px;'>"+amount+"</td></tr><tr ><td style='padding:21px; width:311px;'>Proposed duration of Loan </td><td style='padding:21px;'>"+duration+"</td></tr><tr><td style='padding:21px; width:311px;'>Interest rate</td><td style='padding:21px;'>10% <font color='red'>*<font></td></tr><tr><td style='padding:21px; width:311px;'>Payment per month</td><td style='padding:21px;'><strong>"+inst+"</strong></td></tr><tr><td style='padding:21px; width:311px; font-size:20px;'>TOTAL AMOUNT in Kshs.</td><td style='padding:21px; font-size:20px; color:#228B22;'>"+total+"</td></tr></table></p></div>";
					
					}else{
													document.getElementById('calculations').innerHTML="<div class='box warning_box'><table><tr><td>&nbsp;</td><td><p>For <strong>Business Loans </strong> Choose a term from 3 months to 6 months. So you can pay it off quickly or spread it out a bit.</p></td></tr></table></div>";
					}
				}else{
								document.getElementById('calculations').innerHTML="<div class='box warning_box'><table><tr><td>&nbsp;</td><td><p><strong>Business Loans </strong> issued range from Kshs. 50,000-200,000.00</p></td></tr></table></div>";

				}
			
			
			
			
			
			}else{
			document.getElementById('calculations').innerHTML="";
			}
			
			
			
			
			
			
			
			
			
			////////////////////////products
			}
	
 }
 ////////////////////////////end code here
		}
		
//alert("Amount="+amount+" Duration="+duration+" product="+item);
		
		
		}
		
		function compound(amount, duration, rate,times){
			var pmt=0;
			rate=rate/100;//i="";
			var principle=amount;//
			times=times*duration;//n
			var inter= 1+rate;    //(1+(rate/duration));
			inter=Math.pow(inter,times);
			inter=inter-1;
			inter=rate/inter;
			inter=rate+inter;
			pmt=amount*inter;
			return pmt;
		}
		
		
		
		function roundNumber(rnum, rlength) { // Arguments: number to round, number of decimal places
            var newnumber = Math.round(rnum * Math.pow(10, rlength)) / Math.pow(10, rlength);
            return newnumber;
        }
		
		
		
		</script>
<!-- __________________________________________________ Start Middle -->
				<section id="middle">
					<div class="cont_nav">
						<a href="<?php echo base_url(); ?>">Home</a>&nbsp;/&nbsp;<a href="<?php echo base_url().'products'; ?>">Loans</a>&nbsp;/&nbsp;Calculator
					</div>
					<div class="headline">
						<table class="pagehead">
							<tbody>
								<tr>
									<td><img src="<?php echo base_url().'images/calc.png'; ?>" alt=""></td>
									<td>
										<h2>Loan Calculator</h2>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
<!-- __________________________________________________ Start Content -->
					<section id="middle_content">
						<div class="entry">
						<form id="calc" name="calc">
							<div class="full">
								<div class="box notice_box1">
									<table>
										<tr>
	<td> Loan Product  </td>
											<td>  <select onchange="Calculate()" name="product" id="product">
											<option selected="selected" >Select Loan Product</option>
											<option value="emergency">Emergency</option>
											<option value="payday">Payday</option>
											<option value="personal">Personal</option>
											<option value="business">Business</option>
											</select></td>
											<td>Loan Amount in KSHS. </td>
											<td >  <input type="text" name="amount" id="amount" value="" placeholder="Enter Loan Amount" onkeyup="Calculate()" /></td>
										<td>Duration Of Loan in Months</td>
											<td >  <input type="text" name="duration" id="duration" value="" onkeyup="Calculate()" placeholder="Duration Of Loan(mnths)" />
											</td>
										</tr>
									</table>
								</div>
								
								<div id="calculations">
							
								</div>
								
								<div class="box notice_box">
									<table>
										<tr>
											<td>&nbsp;</td>
											<td><p>The figures provided above are estimates. * -fixed coumpound interest</p></td>
										</tr>
									</table>
								</div>
							</div>
							</form>
						</div>
						
					<div class="cl"></div>
					</section>

				   <div class="cl"></div>
<!-- __________________________________________________ Finish Content -->
				</section>

<!-- __________________________________________________ Finish Middle -->
