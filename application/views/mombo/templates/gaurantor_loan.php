<div class="header">
      <h1 class="page-title">Gaurantor Details</h1>
</div>

<ul class="breadcrumb">
	<li>
	    <a href="<?php echo base_url().'mombo/mombo/home'; ?>">Home</a> 
	    <span class="divider">/</span>
	</li>
	<li>
	    <a href="<?php echo base_url().'customers/'; ?>">Gaurantors</a> 
	    <span class="divider">/</span>
	</li>
	<li class="active">Gaurantor Details</li>
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
    <h3></h3>
	<div class="well">
	    <ul class="nav nav-tabs">
	      <li class="active">
		  		<?php
					$url = base_url().'gaurantors/gaurantorloanstatement/'.$loan_id.'/'.$customer_id.'/'.$gaurantor_id.'/1';
					//echo date('Y-m-d H:i:s');
				?>
	           <a href="" data-toggle="tab" onclick="toPDF('<?php echo $url ?>')"><font color="#0000ff">Export to PDF</font></a>
	      </li>
	     </ul>
	    <div id="myTabContent" class="tab-content">
		   <div class="tab-pane active in" id="personal_statement">
              <?php if($customer->num_rows() > 0 ){ 
			  	$content = ""; 
			  	//$content = urlencode($content);
			   $img_url = base_url().'img/logo2.png';
					$content .= '<table class="table">
						<thead>
							<tr class="muted">
								<th colspan="6" style="text-align: center;"><img src="'.$img_url.'"/></th>
							</tr>
							<!--<tr class="muted">
								<th colspan="6" style="text-align: center">Mombo Investment Limited</th>
							</tr>-->
							<tr class="muted">
								<th colspan="6" style="text-align: center">Loan Statement of Account as of '.$date.'</th>
							</tr>
							<tr class="muted">
								<th colspan="6" style="text-align: left">Borrower: '; ?> 
								 <?php 
								 	foreach($customer->result('customer_model') as $cust){
										$content .= $cust->name.' '.$cust->other_names;
									} 
								 $content .= '</th>
							</tr>
							<tr class="muted">
								<th colspan="6" style="text-align: left">Loan Product: '; ?>
								 <?php 
								 	foreach($loan->result('loan_model') as $cust_loan){
										$content .= $cust_loan->loan_product->loan_product_name;
									}
								
								$content .= '</th>
							</tr>
							<tr class="muted">
								<th colspan="6" style="text-align: left">Loan Transaction Code: '; ?>
								 <?php 
								 	foreach($loan->result('loan_model') as $cust_loan){
										$content .= $cust_loan->transaction_code;
									}
								
								$content .= '</th>
							</tr>
							<tr class="muted">
								<th style="text-align: left">Date</th>
								<th style="text-align: left">Transaction</th>
								<th style="text-align: left">Description</th>
								<th style="text-align: left">Debit</th>
								<th style="text-align: left">Credit</th>
								<th style="text-align: left">Balance</th>
							</tr>
						</thead>
						<tbody>'; ?>
							
								<?php 
									foreach($loan_transactions as $loan_transaction){
										$credit = "";
										$debit = "";
										if($loan_transaction["is_credit"]){
											$credit = $loan_transaction["amount"];
										}
										else{
											$debit = $loan_transaction["amount"];
										}
										$date_time = date("Y-m-d", strtotime($loan_transaction["date_time"]));
										$content .= '<tr>';
										$content .= '<td style="text-align: left">'.$date_time.'</td>'; 
										$content .= '<td style="text-align: left">'.$loan_transaction["transaction"].'</td>';
										$content .= '<td style="text-align: left">'.$loan_transaction["description"].'</td>';
										$content .= '<td style="text-align: left">'.$debit.'</td>';
										$content .= '<td style="text-align: left">'.$credit.'</td>';
										$content .= '<td style="text-align: left">'.$loan_transaction["balance"].'</td>';
										$content .= '</tr>';
									}
								
						$content .= '</tbody>
						
					</table>';
					echo $content;
				 }else{ ?>
                           <div class="alert alert-info">
						        <button type="button" class="close" data-dismiss="alert">×</button>
						        Customer not found.
						    </div>
				<?php } 
					/*//Load the library
					$CI = & get_instance();
					$CI->load->library('html2pdf');

					//Set folder to save PDF to
					$CI->html2pdf->folder('./customer/pdfs/');

					//Set the filename to save/download as
					$CI->html2pdf->filename('test.pdf');

					//Set the paper defaults
					$CI->html2pdf->paper('a4', 'portrait');

					//Load html view
					$CI->html2pdf->html('VESTER');
					
					//Create the PDF
					$CI->html2pdf->create('download'); //other option 'save'*/
				?>
	      </div>
      
	  </div>
      <a class="btn btn-success" href="<?php echo base_url().'customers/';?>">&laquo;&nbsp;&nbsp;Back</a>
	</div>
</div>
<script type="text/javascript" language="javascript">
	function confirm_action(url){
		var content = '<?php echo $content; ?>'
		if (confirm(content+' Are you sure you want to cancel payment made by cheque of KSH.')) {
			window.location.href=url+content;
		}
	}
</script>

<script type="text/javascript">
function toPDF(url)
{
	window.location.href=url;
    /*var xmlhttp;
    if (window.XMLHttpRequest)
    {
        xmlhttp = new XMLHttpRequest();
    }
    else
    {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
    {
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            // do something if the page loaded successfully
        }
    }
    xmlhttp.open("GET",url,true);
    xmlhttp.send();*/
}
</script>