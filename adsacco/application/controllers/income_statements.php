<?php if(!defined('BASEPATH')) exit('Access Denied!!');

class Income_statements extends CI_Controller{
    
	 protected $models = array(
	 
				'sys_object' => 'systemobject_model',
				
				'sys_option' => 'systemoption_model',
				
				'product' => 'product_model',
		 
				'loan' => 'loan_model',

				'loan_charge' => 'charge_model',
				
				'collateral' => 'collateral_model',
				
				'account' => 'account_model',
				
				'transaction' => 'transaction_model',
				
				'customer' => 'customer_model',
				
				'customer_account' => 'customeraccount_model',

				'expected_payment' => 'expectedpayment_model',

				'payment' => 'payment_model',

				'charge_payment' => 'chargepayment_model',
				
				'gaurantor' => 'gaurantor_model',
			
	 );
	 
	 protected $header = 'mombo/layout/header'; //set header template file
	  
	 protected $footer = 'mombo/layout/footer'; //set footer template file
	 
	 public function __construct()
	{
	    parent::__construct();
		
	    //function inside autoloaded helper, check if user is logged in, if not redirects to login page
	    is_logged_in();
	}

    		
	public function index($month = 0, $year = 0,$pdf = 0,$type = 'A'){ 
		$this->load->model('statements_model'); 
		
		if($month == 0 && $year == 0){
			$date= date('Y-m');
			$date_check = date('Y-m')."-01";
			$date_check1 = date ( 'Y-m-t' , strtotime($date) );
			$month_year = date('M, Y');
			$month = date('m');
			$m = date('M');
			$year = date('Y');
		}
		else{
			$date = date ( 'Y-m' , strtotime($year.'-'.$month) );
			$date_check = date ( 'Y-m-d' , strtotime($year.'-'.$month.'-01') );
			$date_check1 = date ( 'Y-m-t' , strtotime($year.'-'.$month) );
			$month_year = date ( 'M,Y' , strtotime($year.'-'.$month) );
			$m = date ( 'M' , strtotime($year.'-'.$month) );;
		}
				
		$date_aa = strtotime ( '+1 month' , strtotime ( $date ) ) ;
		$date_a = date ( 'Y-m' , $date_aa );
		
		
		$date_b = date("Y-m", mktime(0, 0, 0, date("m")-1, date("d"),   date("Y")));
		
		$accrued_transaction_fees = $this->statements_model->get_transaction_fees($date);
		$accrued_interests = $this->statements_model->get_interest($date);
		$accrued_interests_b = $this->statements_model->get_interest_b($date_a);
		$accrued_charges = $this->statements_model->get_charges($date);
		
		$interests_c = $this->statements_model->get_interests_c($date);
		$accrued_interests_c = $this->statements_model->get_charges_c($date,'interest_fee');
		$late_payment_fees_c = $this->statements_model->get_charges_c($date,'latepayment_fee');
		$bouncing_cheque_penalties_c = $this->statements_model->get_charges_c($date,'bouncing cheque penalty');
		$debt_collection_fees_c = $this->statements_model->get_charges_c($date,'Debt recovery penalty');
		
		$expenditure_accts = $this->statements_model->get_exp_accts();
		$expenditures_array = array(); 
		foreach($expenditure_accts as $expenditure_acct){
			$expenditures_array[] = $this->statements_model->get_expenditures($expenditure_acct["id"],$date);
		}
		
		if(! $pdf){
			$this->page->title      = "Mombo Loan System | Income Statements";
		 
			$this->page->name       = 'mombo-income-statements';
			 
			$this->msg['page']      = $this->page;
			 
			$this->msg['accrued_transaction_fees'] = $accrued_transaction_fees;
			$this->msg['accrued_interests'] = $accrued_interests;
			$this->msg['accrued_interests_b'] = $accrued_interests_b;
			$this->msg['accrued_charges'] = $accrued_charges;
			$this->msg['interests_c'] = $interests_c;
			$this->msg['accrued_interests_c'] = $accrued_interests_c;
			$this->msg['late_payment_fees_c'] = $late_payment_fees_c;
			$this->msg['bouncing_cheque_penalties_c'] = $bouncing_cheque_penalties_c;
			$this->msg['debt_collection_fees_c'] = $debt_collection_fees_c;
			
			$this->msg['expenditures_array'] = $expenditures_array;
			$this->msg['month_year'] = $month_year;
			$this->msg['month'] = $month;
			$this->msg['mwaka'] = $year;
			
					
			$this->sendResponse($this->msg,array(
				
		    	$this->header => $this->msg,
					
					'mombo/templates/income_statements_view' => $this->msg,
					
					$this->footer => $this->msg,
			 
			));
		}
		else{
			if($type == 'A'){ //echo "here"; exit;
				$img_url = 'img/logo2.png';
				$contentA = '<img src="'.$img_url.'"/><br />';
					$contentA .= '<strong>Accrued Profit & Loss Statement </strong><br />';
					
					$contentA .= $month_year; 
					
                    if( TRUE ){ 
				   //(count($accrued_transaction_fees) > 0) || (count($accrued_interests) > 0) || (count($accrued_charges) > 0)
						
						 $contentA .= "<table>
		                    <thead>
		                          <tr>
		                               <th>INCOME</th>

		                               <th>KES</th>
		                          </tr>
		                    </thead>
		                    <tbody>";
                       
						$i = 1;
						$gross_income = 0;
						$transaction_fees = 0;
						$interests = 0;
						$late_payment_fees = 0;
						$interest_fees = 0;
						$cheque_penalties = 0;
						$debt_collection_fees = 0;
						
						foreach($accrued_transaction_fees as $accrued_transaction_fee){
							$gross_income += $accrued_transaction_fee["amount"];
							$transaction_fees += $accrued_transaction_fee["amount"];				
						}
						
						foreach($accrued_interests as $accrued_interest){
							$gross_income += $accrued_interest["total_interest_amount"];
							$interests += $accrued_interest["total_interest_amount"];				
						}
						$interests += $accrued_interests_b;
						$gross_income += $accrued_interests_b;
						/*foreach($accrued_interests_b as $accrued_interest_b){
							$gross_income += $accrued_interest_b["interest_amount"];
							$interests += $accrued_interest_b["interest_amount"];				
						}*/
						
						foreach($accrued_charges as $accrued_charge){
							if($accrued_charge["name"] == 'latepayment_fee'){
								$gross_income += $accrued_charge["amount"] - $accrued_charge["waiver"];
								$late_payment_fees += $accrued_charge["amount"] - $accrued_charge["waiver"];
							}
							elseif($accrued_charge["name"] == 'interest_fee'){
								$gross_income += $accrued_charge["amount"] - $accrued_charge["waiver"];
								$interest_fees += $accrued_charge["amount"] - $accrued_charge["waiver"];
							}	
							elseif($accrued_charge["name"] == 'bouncing cheque penalty'){
								$gross_income += $accrued_charge["amount"] - $accrued_charge["waiver"];
								$cheque_penalties += $accrued_charge["amount"] - $accrued_charge["waiver"];
							}	
							elseif($accrued_charge["name"] == 'Debt recovery penalty'){
								$gross_income += $accrued_charge["amount"] - $accrued_charge["waiver"];
								$debt_collection_fees += $accrued_charge["amount"] - $accrued_charge["waiver"];
							}
						}
						$contentA .= "<tr>";
							$contentA .= "<td>Transaction Fees</td>";
							$contentA .= "<td>".$transaction_fees."</td>";
						$contentA .= "</tr>";
						
						$contentA .= "<tr>";
							$contentA .= "<td>Interests</td>";
							$contentA .= "<td>".$interests."</td>";
						$contentA .= "</tr>";
						
						$contentA .= "<tr>";
							$contentA .= "<td>Charges and Penalties</td>";
						$contentA .= "</tr>";
						$contentA .= "<tr>";
							$contentA .= "<td style=\"text-indent: 3em;\">Late Payment Fees</td>";
							$contentA .= "<td>".$late_payment_fees."</td>";
						$contentA .= "</tr>";
						$contentA .= "<tr>";
							$contentA .= "<td style=\"text-indent: 3em;\">Accrued Interests</td>";
							$contentA .= "<td>".$interest_fees."</td>";
						$contentA .= "</tr>";
						$contentA .= "<tr>";
							$contentA .= "<td style=\"text-indent: 3em;\">Bouncing Cheque Penalties</td>";
							$contentA .= "<td>".$cheque_penalties."</td>";
						$contentA .= "</tr>";
						$contentA .= "<tr>";
							$contentA .= "<td style=\"text-indent: 3em;\">Debt Collection Fees</td>";
							$contentA .= "<td>".$debt_collection_fees."</td>";
						$contentA .= "</tr>";
						$contentA .= "<tr>";
							$contentA .= "<td style=\"font-style:bold;font-size:15px;color:purple\">Gross Income</td>";
							$contentA .= "<td style=\"font-style:bold;font-size:15px;color:purple\">".number_format($gross_income,2,'.',',')."</td>";
						$contentA .= "</tr>";
						
						$contentA .= "<thead>
		                          <tr>
		                               <th>EXPENDITURE</th>
		                          </tr>
		                    </thead>";
						
						//$CI = & get_instance();
						//$this->load->model('statements_model','statements');
                        $total_expenditure = 0;
						for($i = 0; $i < count($expenditures_array); $i++){
							$expenditures = $expenditures_array[$i];
							$account_id = 0;
							$account_expenditure = 0;
							foreach($expenditures as $expenditure){
								$account_id = $expenditure["account"];
								$account_expenditure += $expenditure['amounttransacted'];
								$total_expenditure += $expenditure['amounttransacted'];
							}
							$account = $this->statements_model->get_account($account_id);
							
							if($account_expenditure > 0){
								if($account['has_child'] == 0){
									$contentA .= "<tr>
												<td>".$account['account_name']."</td>
												<td>".$account_expenditure."</td>
											</tr>";	
								}
								else{
									$contentA .= "<tr>";
										$contentA .= "<td>".$account['account_name']."</td>";
									$contentA .= "</tr>";
									
									$sub_accounts = $this->statements_model->get_sub_accounts($account_id);
									foreach($sub_accounts as $sub_account){
										$sub_account_expenditure = 0;
										//$sub_acct = $CI->statements->get_sub_account($sub_account['id']);
										foreach($expenditures as $expenditure){
											if($expenditure['sub_account'] == $sub_account['id']){
												$sub_account_expenditure += $expenditure['amounttransacted'];
											}
										}
										if($sub_account_expenditure > 0){
											$contentA .= "<tr>";
												$contentA .= "<td style=\"text-indent: 3em;\">".$sub_account['account_name']."</td>";
												$contentA .= "<td>".$sub_account_expenditure."</td>";
											$contentA .= "</tr>";
										}
									}
								}
							}
						}
						$contentA .= "<tr>";
							$contentA .= "<td style=\"font-style:bold;font-size:15px;color:purple\">Total Expenditure</td>";
							$contentA .= "<td style=\"font-style:bold;font-size:15px;color:purple\">".number_format($total_expenditure,2,'.',',')."</td>";
						$contentA .= "</tr>";
						$contentA .= "<tr>";
							$contentA .= "<td style=\"font-style:bold;font-size:15px;color:purple\"></td>";
							$contentA .= "<td style=\"font-style:bold;font-size:15px;color:purple\"></td>";
						$contentA .= "</tr>";
						$contentA .= "<tr>";
							$contentA .= "<td style=\"font-style:bold;font-size:15px;color:purple\">NET INCOME</td>";
							$contentA .= "<td style=\"font-style:bold;font-size:15px;color:purple\">".number_format($gross_income - $total_expenditure,2,'.',',')."</td>";
						$contentA .= "</tr>";
					
					 $contentA .= "</tbody> 
                    </table>";
					//echo $contentA;
					$this->profit_loss($contentA,$month_year.'_Accrued Profit & Loss Statement');
					}else{ 
						$this->profit_loss('No result.',$month_year.'_Accrued Profit & Loss Statement');
					} 
			}
			elseif($type == 'B'){
				$img_url = 'img/logo2.png';
				$contentB = '<img src="'.$img_url.'"/><br />';
					$contentB .= '<strong>Basis Profit & Loss Statement </strong><br />';
					
					$contentB .= $month_year; 
					
                   if( true ){
					
						  $contentB .= "<table>
		                    <thead>
		                          <tr>
		                               <th>INCOME</th>

		                               <th>KES</th>
		                          </tr>
		                    </thead>
		                    <tbody>";
                         
						$i = 1;
						$gross_income = 0;
						$transaction_fees = 0;
						$interests = 0;
						$late_payment_fees = 0;
						$interest_fees = 0;
						$cheque_penalties = 0;
						$debt_collection_fees = 0;
						
						foreach($accrued_transaction_fees as $accrued_transaction_fee){
							$gross_income += $accrued_transaction_fee["amount"];
							$transaction_fees += $accrued_transaction_fee["amount"];				
						}
						$gross_income += $interests_c + $accrued_interests_c + $late_payment_fees_c + $bouncing_cheque_penalties_c + $debt_collection_fees_c;
						
						$contentB .= "<tr>";
							$contentB .= "<td>Transaction Fees</td>";
							$contentB .= "<td>".$transaction_fees."</td>";
						$contentB .= "</tr>";
						
						$contentB .= "<tr>";
							$contentB .= "<td>Interests</td>";
							$contentB .= "<td>".$interests_c."</td>";
						$contentB .= "</tr>";
						
						$contentB .= "<tr>";
							$contentB .= "<td>Charges and Penalties</td>";
						$contentB .= "</tr>";
						$contentB .= "<tr>";
							$contentB .= "<td style=\"text-indent: 3em;\">Late Payment Fees</td>";
							$contentB .= "<td>".$late_payment_fees_c."</td>";
						$contentB .= "</tr>";
						$contentB .= "<tr>";
							$contentB .= "<td style=\"text-indent: 3em;\">Accrued Interests</td>";
							$contentB .= "<td>".$accrued_interests_c."</td>";
						$contentB .= "</tr>";
						$contentB .= "<tr>";
							$contentB .= "<td style=\"text-indent: 3em;\">Bouncing Cheque Penalties</td>";
							$contentB .= "<td>".$bouncing_cheque_penalties_c."</td>";
						$contentB .= "</tr>";
						$contentB .= "<tr>";
							$contentB .= "<td style=\"text-indent: 3em;\">Debt Collection Fees</td>";
							$contentB .= "<td>".$debt_collection_fees_c."</td>";
						$contentB .= "</tr>";
						$contentB .= "<tr>";
							$contentB .= "<td style=\"font-style:bold;font-size:15px;color:purple\">Gross Income</td>";
							$contentB .= "<td style=\"font-style:bold;font-size:15px;color:purple\">".number_format($gross_income,2,'.',',')."</td>";
						$contentB .= "</tr>";
						
						 $contentB .= "<thead>
		                          <tr>
		                               <th>EXPENDITURE</th>
		                          </tr>
		                    </thead>";
						
						
                        $total_expenditure = 0;
						for($i = 0; $i < count($expenditures_array); $i++){
							$expenditures = $expenditures_array[$i];
							$account_id = 0;
							$account_expenditure = 0;
							foreach($expenditures as $expenditure){
								$account_id = $expenditure["account"];
								$account_expenditure += $expenditure['amounttransacted'];
								$total_expenditure += $expenditure['amounttransacted'];
							}
							$account = $this->statements_model->get_account($account_id);
							
							if($account_expenditure > 0){
								if($account['has_child'] == 0){
									$contentB .= "<tr>
												<td>".$account['account_name']."</td>
												<td>".$account_expenditure."</td>
											</tr>";	
								}
								else{
									$contentB .= "<tr>";
										$contentB .= "<td>".$account['account_name']."</td>";
									$contentB .= "</tr>";
									
									$sub_accounts = $this->statements_model->get_sub_accounts($account_id);
									foreach($sub_accounts as $sub_account){
										$sub_account_expenditure = 0;
										//$sub_acct = $CI->statements->get_sub_account($sub_account['id']);
										foreach($expenditures as $expenditure){
											if($expenditure['sub_account'] == $sub_account['id']){
												$sub_account_expenditure += $expenditure['amounttransacted'];
											}
										}
										if($sub_account_expenditure > 0){
											$contentB .= "<tr>";
												$contentB .= "<td style=\"text-indent: 3em;\">".$sub_account['account_name']."</td>";
												$contentB .= "<td>".$sub_account_expenditure."</td>";
											$contentB .= "</tr>";
										}
									}
								}
							}
						}
						$contentB .= "<tr>";
							$contentB .= "<td style=\"font-style:bold;font-size:15px;color:purple\">Total Expenditure</td>";
							$contentB .= "<td style=\"font-style:bold;font-size:15px;color:purple\">".number_format($total_expenditure,2,'.',',')."</td>";
						$contentB .= "</tr>";
						$contentB .= "<tr>";
							$contentB .= "<td style=\"font-style:bold;font-size:15px;color:purple\"></td>";
							$contentB .= "<td style=\"font-style:bold;font-size:15px;color:purple\"></td>";
						$contentB .= "</tr>";
						$contentB .= "<tr>";
							$contentB .= "<td style=\"font-style:bold;font-size:15px;color:purple\">NET INCOME</td>";
							$contentB .= "<td style=\"font-style:bold;font-size:15px;color:purple\">".number_format($gross_income - $total_expenditure,2,'.',',')."</td>";
						$contentB .= "</tr>";
					
					 $contentB .= "</tbody> 
                    </table>";
					//echo $contentB;
					$this->profit_loss($contentB,$month_year.'_Basis Profit & Loss Statement');
					}else{ 
						$this->profit_loss('No result.',$month_year.'_Basis Profit & Loss Statement');
					} 
			}
		}
	}
	
	public function profit_loss($content,$filename = 'Profit & Loss'){
	  	//echo 'hehehehe'; exit;
		$content = urldecode($content);
		//Load the library
		$this->load->library('html2pdf');

		//Set folder to save PDF to
		$this->html2pdf->folder('./customer/pdfs/');

		//Set the filename to save/download as
		$this->html2pdf->filename($filename); 

		//Set the paper defaults
		$this->html2pdf->paper('a4', 'portrait');

		//Load html view
		$this->html2pdf->html($content);
		
		//Create the PDF
		$this->html2pdf->create('download'); //other option 'save'
	  }
	 
}