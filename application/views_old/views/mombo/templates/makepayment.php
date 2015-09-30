<div class="header">
       <h1 class="page-title">Make Payment</h1>
 </div>
        
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>
            <li>Issued Loans</li><span class="divider">/</span></li>
            <li class="active">Loan Payment</li>
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

    <div id="well">
          <?php if($loans->num_rows() > 0){ ?>

                <script type="text/javascript" language="javascript">
				function removeOptions(selectbox)
				{
					var i;
					for(i=selectbox.options.length-1;i>0;i--)
					{
						selectbox.remove(i);
					}
				}
				
				
				function get_customer(){	
					removeOptions(document.getElementById("select_customer"));
					var criteria = document.getElementById("criteria_value").value;
					document.getElementById("current-loan-payments").innerHTML= "";
					document.getElementById("current-loan-charges").innerHTML= "";
					var xmlhttp;    
				
					if (window.XMLHttpRequest)
					  {// code for IE7+, Firefox, Chrome, Opera, Safari
					  xmlhttp=new XMLHttpRequest();
					  }
					else
					  {// code for IE6, IE5
					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					  }
					xmlhttp.onreadystatechange=function()
					  {
					  if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
							if(0 == xmlhttp.responseText){
								document.getElementById("me").innerHTML="No customer record found. Please retry!";
							}
							else{
							document.getElementById("me").innerHTML="Record(s) found. Please select customer and proceed!";
								var response = xmlhttp.responseText.split("~");
								var arrayLength = response.length;
								var select = document.getElementById("select_customer");
								for (var i = 0; i < arrayLength; i++) {
									var customer = response[i].split("*");
									select.options[select.options.length] = new Option(customer[2]+" ("+customer[1]+")", customer[0]);
									//alert(customer[2]+" "+customer[1]+" "+customer[0]);
								}
							}													
						}
					  }
					xmlhttp.open("GET","<?php echo base_url();?>customers/getclient/?criteria="+criteria,true);
					xmlhttp.send();
				}
				
				function show_loans(){	
					removeOptions(document.getElementById("loans"));
					document.getElementById("current-loan-payments").innerHTML= "";
					document.getElementById("current-loan-charges").innerHTML= "";
					var customer_id = document.getElementById("select_customer").value;
					var xmlhttp;    
				
					if (window.XMLHttpRequest)
					  {// code for IE7+, Firefox, Chrome, Opera, Safari
					  xmlhttp=new XMLHttpRequest();
					  }
					else
					  {// code for IE6, IE5
					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					  }
					xmlhttp.onreadystatechange=function()
					  {
					  if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
							if(0 == xmlhttp.responseText){
								//document.getElementById("me").innerHTML="No customer record found. Please retry!";
							}
							else{
							//document.getElementById("me").innerHTML="Record(s) found. Please select customer and proceed!";
								var response = xmlhttp.responseText.split("~");
								var profile_pic = response[0]; 
								document.getElementById("profilepic").src = "<?php echo base_url().'images/profilepics/'; ?>"+profile_pic;
								var loans = response[1].split("^");
								var arrayLength = loans.length;
								var select = document.getElementById("loans");
								for (var i = 0; i < arrayLength; i++) {
									var loan = loans[i].split("*");
									select.options[select.options.length] = new Option(loan[1], loan[0]);
								}
							}													
						}
					  }
					  
					xmlhttp.open("GET","<?php echo base_url();?>customers/getclientloans/?customer_id="+customer_id ,true);
					xmlhttp.send();
				}
				
				function show_loan_details(){	
					var loan_id = document.getElementById("loans").value;  
					document.getElementById("current-loan-payments").innerHTML= "";
					document.getElementById("current-loan-charges").innerHTML= "";
					//alert("id: "+loan_id);
					var xmlhttp;    
				
					if (window.XMLHttpRequest)
					  {// code for IE7+, Firefox, Chrome, Opera, Safari
					  xmlhttp=new XMLHttpRequest();
					  }
					else
					  {// code for IE6, IE5
					  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					  }
					xmlhttp.onreadystatechange=function()
					  {
					  if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
							if(0 == xmlhttp.responseText){
								//document.getElementById("me").innerHTML="No customer record found. Please retry!";
							}
							else{
							//document.getElementById("me").innerHTML="Record(s) found. Please select customer and proceed!";
								var result = xmlhttp.responseText; 
								var response;
								var payments;
								var charges;
								var has_charges = 0;
								var c = 0;
								var p = 0;
								if(result.indexOf("~") > -1){ 
									response = result.split("~");
									if( response[0].indexOf("^") > -1){		
										p = 1;
										payments = response[0].split("^");
									}
									else{
										payments = response[0];
									}
									
									if( response[1].indexOf("^") > -1){			
										charges = response[1].split("^");
										c = 1;
									}
									else{
										charges = response[1];
									}
									has_charges = 1;
								}
								else{ 
									if( result.indexOf("^") > -1){			
										payments = result.split("^");
										p = 1;
									}
									else{
										payments = result;
									}
								}
								
								var arrayLength = 1;
								if(1 == p){
									arrayLength = payments.length;
								}
								var payments_html = "<table class='table'><thead><tr><th>Month Principal</th><th>Month Interest</th>";
								payments_html += "<th>Month Principal Balance</th><th>Month Interest Balance</th>";
								payments_html += "<th>Payment Expected Before<th></tr></thead><tbody>";
								
								for (var i = 0; i < arrayLength; i++) {
									var payment;
									if(1 == p){
										payment = payments[i].split("*"); //alert("here "+payment[4]);
									}
									else{
										payment = payments.split("*"); //alert("here "+payment[4]);
									}
									payments_html += "<tr><td>"+payment[0]+"</td>";
									payments_html += "<td>"+payment[2]+"</td>";
									payments_html += "<td>"+payment[1]+"</td>";
									payments_html += "<td>"+payment[3]+"</td>";
									payments_html += "<td>"+payment[4]+"</td></tr>";
								}
								 payments_html += "</tbody></table>";
								document.getElementById("current-loan-payments").innerHTML= payments_html;
								
								if(has_charges == 1){
									var arrayLen  = 1;
									if(1 == c){
										arrayLen  = charges.length;
									}
									var charges_html = "<table class='table'><thead><tr><th>Name</th><th>Date Effected</th>";
									charges_html += "<th>Amount Charged</th><th>Balance</th>";
									charges_html += "</tr></thead><tbody>";
									
									for (var i = 0; i < arrayLen; i++) {
										var charge;
										if(1 == c){
											charge = charges[i].split("*"); //alert("here "+payment[4]);
										}
										else{
											charge = charges.split("*"); //alert("here "+payment[4]);
										}
										charges_html += "<tr><td>"+charge[0]+"</td>";
										charges_html += "<td>"+charge[1]+"</td>";
										charges_html += "<td>"+charge[2]+"</td>";
										charges_html += "<td>"+charge[3]+"</td>";
										charges_html += "</tr>";
									}
									 charges_html += "</tbody></table>";
									document.getElementById("current-loan-charges").innerHTML= charges_html;
								}
								else{
									document.getElementById("current-loan-charges").innerHTML= "No charges";
								}
								
							}													
						}
					  }
					  //alert("<?php echo base_url();?>customers/getloandetails/?loan_id="+loan_id);
					xmlhttp.open("GET","<?php echo base_url();?>customers/getloandetails/?loan_id="+loan_id ,true);
					xmlhttp.send();
				}
			</script>
			

                <form id="make-payment-form" class="well" method="POST" action="<?php echo base_url().'loans/pay1/';?>">

                      <div id="select-customer-loan" class="control-group">

                           <h5 class="control-label">Find Loan by Customer ID/Passport Number or Phone Number or Name</h5>
						   <div id = "me"></div>
						   <div class="control-group">
			
									<label class="control-label"></label>
							
									<div class="controls">
										
										  <input placeholder = "Enter criteria value" type="text" id="criteria_value" name="customer_name" value="" class="input-xlarge"/>
										  <input type="button" id="search" value="Search" onclick="get_customer();"/>
									</div>
							
							</div>
													

                           <div class="controls well">

                              <div class="control-group">
							
									<label class="control-label">Customer</label>
							
									<div class="controls">
										
										  <select type="text" onchange="show_loans()" id="select_customer" name="select_customer" class="input-xlarge">
														
															<option value="">--Select--</option>
														
																			  
										  </select>
									
									</div>
							
							</div>

                              <img id="profilepic" class="small-profile-image make-block-level"  src="<?php echo base_url().'images/profilepics/avator.png' ?>"/>

                           </div>
                        
                      </div>

                      <div id="loan-select" class="controls-group">

                           <h5>Select an Outstanding Customer Loan</h5>

                           <div class="controls well">

                                  <label class="control-label">Loan</label>

                                  <select id="loans" name="loan_id"  class="input-xlarge" onchange="show_loan_details()">

                                        <option value="0">Select Loan</option>

                                  </select>

                                  <label class="control-label">Loan Details</label>
										<div id="loan-details">

                                                  <ul class="nav nav-tabs">

                                                        <li class="active"> <a data-toggle="tab" href="#current-loan-payments">Payments </a> </li>

                                                        <li> <a data-toggle="tab" href="#current-loan-charges">Charges</a> </li>

                                                  </ul>

                                                  <div class="tab-content">

                                                        <div id="current-loan-payments" class="tab-pane active">

                                                                                                                  

                                                        </div>

                                                        <div id="current-loan-charges" class="tab-pane fade">


                                                        </div>

                                                  </div>

                                           

                                    </script>

                           </div>

                      </div>

                      <div id="loan-payment-amount" class="control-group">

                            <h5>Payment Amount</h5>

                            <div class="controls well">

                                <label class="control-label">Amount</label>

                                <input type="text" name="payment_amount" value="<?php if(array_key_exists('payment_amount', $_POST)){ echo $_POST['payment_amount']; } ?>" class="input-xlarge" />

                                <label class="control-label">Payment Channel</label>

                                <select name="payment_channel" class="input-xlarge">
								        <option value="">Select Payment channel</option>
								        <option value="cash" <?php if(array_key_exists('payment_channel', $_POST) && $_POST['payment_channel'] == 'cash'){ echo ' selected="selected"'; } ?>>Cash</option>
										<option value="cheque" <?php if(array_key_exists('payment_channel', $_POST) && $_POST['payment_channel'] == 'cheque'){ echo ' selected="selected"'; } ?>>Cheque</option>
										<option value="mpesa" <?php if(array_key_exists('payment_channel', $_POST) && $_POST['payment_channel'] == 'mpesa'){ echo ' selected="selected"'; } ?>>Mpesa</option>
								</select>
								
								 <label class="control-label">Payment Description</label>

                                <textarea name="payment_description" class="input-xlarge"><?php if(array_key_exists('payment_amount', $_POST)){ echo $_POST['payment_amount']; } ?></textarea>
                            
                            </div>

                      </div>
					 

                      <div class="control-group">

                            <div class="controls">

                                <input type="submit" name="make_payment" value="Make Payment" class="btn btn-info btn-large input-xlarge" />
                            
                            </div>
                      </div>

                </form>

          <?php }else{ ?>

                <div id="no-loans-info" class="alert alert-info">

                      You have no unsettled loans

                </div>

          <?php } ?>
    </div>

</div>