<div class="header">
       <?php $criteria='';?>
       <h1 class="page-title">Issue Loan</h1> 
 </div>
        
<ul class="breadcrumb">
	<li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>
	<li><a href="<?php echo base_url();?>loans/">Loans</a> <span class="divider">/</span></li>
	<li class="active">Issue Loan</li>
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
<?php if(isset($message)){ ?>
    <div class="alert alert-<?php echo $message_type; ?>">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <?php echo $message;?>
    </div>
<?php } ?>
<div class="well">	
      <form id="issue-loan-form" class="well form-horizontal"method="POST" action="<?php echo base_url().'loans/issueloan/'; ?>">
	       
		    <input type="hidden" id="customer-id-hidden" name="customer"/>
	  
			<script type="text/javascript">
					
			  <!-- -->
			  $(function(){
					    
						var customers       = [];
						
						var customer_names  = [];
					
					    $('#customer-id').typeahead((function(){
								
								return {
								
									source : function(query,process){
									
									       var name_id = query;
												
										   $.ajax((function(){
										   
												return {
												
												      type:'GET',
													  
													  url :"<?php echo base_url();?>customers/findcustomers",
													  
													  data:{
													  
														   'aj':'true',
														   
														   'criteria':'active',
														   
													  },
													  
													  dataType:"json",
													  
													  success: function(data){
													       
														   customers         = [];
														   customer_names   = [];
														   
														   data = data.customers.custom_result_object.customer_model;
														   
														   for(var i=0;i<data.length;i++){
																
																customers.push(data[i]);
																
																customer_names.push("("+data[i].name+' '+data[i].other_names+")"+data[i].idnumber);
														   }
													  
													  }
												
												};
												
										   })());
										   
										   return customer_names;
									}
									
								};
					    })()).change(function(e){  
						
						        var id_number = this.value.substring((this.value.indexOf(')')+1));

                                this.value    = this.value.substring((this.value.indexOf('(')+1),this.value.indexOf(')'));

                                for(var i=0;i < customers.length; i++){

                                      if(customers[i].idnumber == id_number){

                                           var customer = customers[i];
                                           
                                           $('#customer-id-hidden').attr('value',customer.id);

                                      }

                                }
						
						      e.preventDefault();	  
						});
				});
			<!-- -->
			</script>
			
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
							document.getElementById("me").innerHTML="Please select customer and proceed!";
								var response = xmlhttp.responseText.split("~");
								var arrayLength = response.length;
								var select = document.getElementById("select_customer");
								for (var i = 0; i < arrayLength; i++) {
									var customer = response[i].split("*");
									select.options[select.options.length] = new Option(customer[2]+" ("+customer[1]+")", customer[0]);
								}
							}													
						}
					  }
					xmlhttp.open("GET","<?php echo base_url();?>customers/getclient/?criteria="+criteria,true);
					xmlhttp.send();
				}
				
				function get_guarantor(){	
					removeOptions(document.getElementById("select_guarantor"));
					var criteria = document.getElementById("criteria_value1").value;
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
								document.getElementById("me1").innerHTML="No guarantor record found. Please retry!";
							}
							else{
							document.getElementById("me1").innerHTML="Please select guarantor and proceed!";
								var response = xmlhttp.responseText.split("~");
								var arrayLength = response.length;
								var select = document.getElementById("select_guarantor");
								for (var i = 0; i < arrayLength; i++) {
									var guarantor = response[i].split("*");
									select.options[select.options.length] = new Option(guarantor[2]+" ("+guarantor[1]+")", guarantor[0]);
								}
							}													
						}
					  }
					xmlhttp.open("GET","<?php echo base_url();?>gaurantors/getguarantor/?criteria="+criteria,true);
					xmlhttp.send();
				}
				
				function get_guarantor2(){	
					removeOptions(document.getElementById("select_guarantor2"));
					var criteria = document.getElementById("criteria_value2").value;
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
								document.getElementById("me2").innerHTML="No guarantor record found. Please retry!";
							}
							else{
							document.getElementById("me2").innerHTML="Please select guarantor and proceed!";
								var response = xmlhttp.responseText.split("~");
								var arrayLength = response.length;
								var select = document.getElementById("select_guarantor2");
								//alert(response);
								for (var i = 0; i < arrayLength; i++) {
									var guarantor = response[i].split("*");
									select.options[select.options.length] = new Option(guarantor[2]+" ("+guarantor[1]+")", guarantor[0]);
								}
							}													
						}
					  }
					xmlhttp.open("GET","<?php echo base_url();?>gaurantors/getguarantor/?criteria="+criteria,true);
					xmlhttp.send();
				}
				
			</script>
			
			<div id = "me"></div>
			<div class="control-group">
			
			        <label class="control-label"></label>
			
					<div class="controls">
						
						  <input type="text" id="criteria_value" name="customer_name" placeholder="Search value to find Customer" value="" class="input-xlarge"/>
						  <input type="button" id="search" value="Search" onclick="get_customer();"/>
					</div>
			
			</div>
			
				<div class="control-group">
			
			        <label class="control-label">Customer</label>
			
					<div class="controls">
						
						  <select type="text" id="select_customer" name="select_customer" class="input-xlarge" required>
									    
											<option value="">--Select--</option>
										
															  
						  </select>
					
					</div>
			
			</div>
			
			<div id = "me1"></div>
			<div class="control-group">
			
			        <label class="control-label"></label>
			
					<div class="controls">
						
						  <input type="text" id="criteria_value1" name="guarantor_name" placeholder="Search value to find 1st Guarantor" value="" class="input-xlarge"/>
						  <input type="button" id="search1" value="Search" onclick="get_guarantor();"/>
					</div>
			
			</div>
			
			<div class="control-group">
			
			        <label class="control-label">Guarantor 1</label>
			
					<div class="controls">
						
						  <select type="text" id="select_guarantor" name="select_guarantor" class="input-xlarge">
									    
											<option value="">--Select--</option>
										
															  
						  </select>
					
					</div>
			
			</div>
			
			<div id = "me2"></div>
			<div class="control-group">
			
			        <label class="control-label"></label>
			
					<div class="controls">
						
						  <input type="text" id="criteria_value2" name="guarantor_name2" placeholder="Search value to find 2nd Guarantor" value="" class="input-xlarge"/>
						  <input type="button" id="search2" value="Search" onclick="get_guarantor2();"/>
					</div>
			
			</div>
			
			<div class="control-group">
			
			        <label class="control-label">Guarantor 2</label>
			
					<div class="controls">
						
						  <select type="text" id="select_guarantor2" name="select_guarantor2" class="input-xlarge">
									    
											<option value="">--Select--</option>
										
															  
						  </select>
					
					</div>
			
			</div>
			
			<div class="control-group">
			
			        <label class="control-label">Select Loan</label>
			
					<div class="controls">
						
						  <select type="text" name="loan_product" class="input-xlarge">
						  
									<?php foreach($products->result('product_model') as $product): ?>
									    
											<option value="<?php echo $product->id; ?>" value="<?php if(array_key_exists('loan_product',$_POST) && $_POST['loan_product'] == $product->id) echo ' selected="selected"'; ?>"><?php echo $product->loan_product_name; ?></option>
										
									<?php endforeach; ?>
						  
						  </select>
					
					</div>
			
			</div>
			
			<div class="control-group">
			
			        <label class="control-label">Amount</label>
			
					<div class="controls">
						
						  <input type="text" name="loan_amount" value="<?php if(array_key_exists('loan_amount',$_POST)) echo $_POST['loan_amount']; ?>" class="input-xlarge"/>
					
					</div>
			
			</div>
			
			<div class="control-group">
			
			        <label class="control-label">Duration</label>
			
					<div class="controls">
						
						  <input type="text" name="loan_duration" value="<?php if(array_key_exists('loan_duration',$_POST)) echo $_POST['loan_duration']; ?>"/>
					
					</div>
			
			</div>
			
			<div class="control-group">
			
			       <div class="controls">
						
						  <input type="submit" name="issue_loan" value="Issue Loan" class="btn btn-info btn-large"/>
					
					</div>
			
			</div>
	  
	  </form>
</div>