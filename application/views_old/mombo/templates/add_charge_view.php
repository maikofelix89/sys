<div class="header">
       <h1 class="page-title">Loan Add Charge</h1>
 </div>
        
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>
            <li>Loan Add Charge</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">

<?php if(isset($message) && $message){ ?>

    <div class="alert alert-<?php echo $message_type; ?>">

        <button type="button" class="close" data-dismiss="alert">×</button>

        <?php echo $message;?>

    </div>

<?php } ?>

<div class="well">

    <div id="well">

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
				
				
			</script>
			

                <form id="make-payment-form" class="well" method="POST" action="<?php echo base_url().'customers/addcharge/?cust_id='.$cust_id.'&loan_id='.$loan_id; ?>">

                      <div id="select-customer-loan" class="control-group">
													


                              <div class="control-group">
							
									<label class="control-label"></label>
							
									<div class="controls">
										
										  <select type="text" id="charge" name="charge" class="input-xlarge" required>
														
															<option value="">--Select charge fee--</option>														
															<option value="Car Tracking Fee">Car Tracking Fee</option>			  
										  </select>
									
									</div>
							
							</div>

                              
						<div class="control-group">
			
								<div class="controls">
									
									  <input type="text" name="amount" value="" class="input-xlarge" placeholder="Amount" required/>
								
								</div>
						
						</div>
						
						<div class="controls">
						
						  <input type="submit" name="submit" value="Submit" class="btn btn-info btn-large"/>
					
						</div>
                        
                      </div>

          
</div>