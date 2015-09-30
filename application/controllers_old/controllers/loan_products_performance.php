<?php if(!defined('BASEPATH')) exit('Access Denied!!');

class Loan_products_performance extends CI_Controller{
    
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

    		
	public function index($month = 0, $year = 0, $pdf = 0){
		$this->load->model('reports_model');
		
		if($month == 0 && $year == 0){
			$date= date('Y-m');
			$date_check = date('Y-m-01');
			$date_check1 = date ( 'Y-m-t' , strtotime($date) );
			$month_year = date('M, Y');
			$month = date('m');
			$m = date('M');
			$year = date('Y');
		}
		else{
			$date = date ( 'Y-m' , strtotime($year.'-'.$month) );
			$date_check = date ( 'Y-m-01' , strtotime($year.'-'.$month) );
			$date_check1 = date ( 'Y-m-t' , strtotime($year.'-'.$month) );
			$month_year = date ( 'M,Y' , strtotime($year.'-'.$month) );
		}
			//echo $date_check; exit;	
		$date_aa = strtotime ( '+1 month' , strtotime ( $date ) ) ;
		$date_a = date ( 'Y-m' , $date_aa );
		
		$date_plus = date ( 'Y-m-t' , $date_aa );
		
				
		$i = 0;
		$loan_products = $this->reports_model->get_loan_products();
		$loan_opening_bal = array();
		$loan_fresh_disbursement = array();
		$transaction_fees = array();
		$interests_a = array();
		$future_interests_a = array();
		$new_future_interests_a = array();
		$interests_c = array();
		$accrued_interests_a = array();
		$accrued_interests_c = array();
		$charges_a = array();
		$charges_c = array();
		$late_payment_fees_a = array();
		$late_payment_fees_c = array();
		$bouncing_cheque_penalties_a = array();
		$bouncing_cheque_penalties_c = array();
		$debt_collection_fees_a = array();
		$debt_collection_fees_c = array();
		$principal_collected = array();
		$loan_closing_bal = array();
					
		
		foreach($loan_products as $loan_product){
			$loan_opening_bal[] = $this->reports_model->get_loan_opening_bal($loan_product['id'],$date_check,$date,$date_check1);
			$loan_fresh_disbursement[] = $this->reports_model->get_loan_fresh_disbursement($loan_product['id'],$date);
			$transaction_fees[] = $this->reports_model->get_loan_transaction_fees($loan_product['id'],$date);
			$interests_a[] = $this->reports_model->get_interests_a($loan_product['id'],$date,$date_a);
			$future_interests_a[] = $this->reports_model->get_future_interests_a($loan_product['id'],$date_check1,$date_plus);
			$new_future_interests_a[] = $this->reports_model->get_new_future_interests_a($loan_product['id'],$date_check1,$date_plus,$date);
			$interests_c[] = $this->reports_model->get_interests_c($loan_product['id'],$date);
			$late_payment_fees_a[] = $this->reports_model->get_charges_a($loan_product['id'],$date,'latepayment_fee');
			$late_payment_fees_c[] = $this->reports_model->get_charges_c($loan_product['id'],$date,'latepayment_fee');
			$accrued_interests_a[] = $this->reports_model->get_charges_a($loan_product['id'],$date,'interest_fee');
			$accrued_interests_c[] = $this->reports_model->get_charges_c($loan_product['id'],$date,'interest_fee');
			$bouncing_cheque_penalties_a[] = $this->reports_model->get_charges_a($loan_product['id'],$date,'bouncing cheque penalty');
			$bouncing_cheque_penalties_c[] = $this->reports_model->get_charges_c($loan_product['id'],$date,'bouncing cheque penalty');
			$debt_collection_fees_a[] = $this->reports_model->get_charges_a($loan_product['id'],$date,'Debt recovery penalty');
			$debt_collection_fees_c[] = $this->reports_model->get_charges_c($loan_product['id'],$date,'Debt recovery penalty');
			$principal_collected[] = $this->reports_model->get_principal_collected($loan_product['id'],$date);
			$loan_closing_bal[] = $this->reports_model->get_loan_closing_bal($loan_product['id'],$date_check,$date_check1,$date_plus);
						
			$principal_bal[] = $this->reports_model->get_principal_bal($loan_product['id'],$date_check);
			
		}
		
		if(! $pdf){
			$this->page->title      = "Mombo Loan System | Loan Product Performance";
		 
			$this->page->name       = 'mombo-loan-product-performance';
			 
			$this->msg['page']      = $this->page;
			
			$this->msg['loan_products'] = $loan_products; 
			$this->msg['loan_opening_bal'] = $loan_opening_bal;
			$this->msg['loan_fresh_disbursement'] = $loan_fresh_disbursement;
			$this->msg['transaction_fees'] = $transaction_fees;
			$this->msg['interests_a'] = $interests_a;
			$this->msg['future_interests_a'] = $future_interests_a;
			$this->msg['new_future_interests_a'] = $new_future_interests_a;
			$this->msg['interests_c'] = $interests_c;
			$this->msg['late_payment_fees_a'] = $late_payment_fees_a;
			$this->msg['late_payment_fees_c'] = $late_payment_fees_c;
			$this->msg['accrued_interests_a'] = $accrued_interests_a;
			$this->msg['accrued_interests_c'] = $accrued_interests_c;
			$this->msg['bouncing_cheque_penalties_a'] = $bouncing_cheque_penalties_a;
			$this->msg['bouncing_cheque_penalties_c'] = $bouncing_cheque_penalties_c;
			$this->msg['debt_collection_fees_a'] = $debt_collection_fees_a;
			$this->msg['debt_collection_fees_c'] = $debt_collection_fees_c;
			$this->msg['principal_collected'] = $principal_collected;
			$this->msg['loan_closing_bal'] = $loan_closing_bal;
			
			$this->msg['month_year'] = $month_year; 
			$this->msg['month'] = $month;
			$this->msg['mwaka'] = $year;
							
			$this->sendResponse($this->msg,array(
				
		    	$this->header => $this->msg,
					
					'mombo/templates/loan_products_performance_view' => $this->msg,
					
					$this->footer => $this->msg,
			 
			));
		}
		else{
			$img_url = 'img/logo2.png';
			$content = '<img src="'.$img_url.'"/><br />';
			$content .= '<strong> Loan Product Performance</strong><br />';
			
			$content .= $month_year; 
			if( (count($loan_products) > 0) ){
						
						  $content .= '<table>
		                    <thead>
		                          <tr>
		                               <th></th>
		                               <th>Opening Balance</th>
									   <th>Fresh Disbursement</th>
									   <th>Transaction Fees</th>
									   <th style="text-align: center">Interest</th>
									   <th></th>
									   <th>Accrued Interest</th>
									   <th></th>
									   <th>Late Payment Fees</th>
									   <th></th>
									   <th>Boucing Cheque Fees</th>
									   <th></th>
									   <th>Debt Collection Fees</th>
									   <th></th>
									   <th>Principal Collected</th>
									   <th>Future Interest</th>
									   <th>Closing Balance</th>
		                          </tr>
								  <tr>
		                               <th></th>
		                               <th></th>
									   <th></th>
									   <th></th>
									   <th style="color: blue;text-align: center">A</th>
									   <th style="color: purple">C</th>
									   <th style="color: blue">A</th>
									   <th style="color: purple">C</th>
									   <th style="color: blue">A</th>
									   <th style="color: purple">C</th>
									   <th style="color: blue">A</th>
									   <th style="color: purple">C</th>
									   <th style="color: blue">A</th>
									   <th style="color: purple">C</th>
									   <th></th>
									   <th></th>
									   <th></th>
		                          </tr>
		                    </thead>
		                    <tbody>';
                        
						$i=0;
						$total_loan_opening_bal = 0; $total_loan_fresh_disbursement = 0; $total_transaction_fees = 0; $total_interests_a = 0;
						$total_interests_c = 0; $total_accrued_interests_a = 0; $total_accrued_interests_c = 0; $total_late_payment_fees_a = 0;
						$total_late_payment_fees_c = 0; $total_bouncing_cheque_penalties_a = 0; $total_bouncing_cheque_penalties_c = 0; 
						$total_debt_collection_fees_a = 0; $total_debt_collection_fees_c = 0;  $total_principal_collected = 0; 
						$total_future_interests_a = 0; $total_loan_closing_bal = 0;
						foreach($loan_products as $loan_product){
							$total_loan_opening_bal += $loan_opening_bal[$i];
							$total_loan_fresh_disbursement += $loan_fresh_disbursement[$i];
							$total_transaction_fees += $transaction_fees[$i];
							$total_interests_a += $interests_a[$i];
							$total_interests_c += $interests_c[$i];
							$total_accrued_interests_a += $accrued_interests_a[$i];
							$total_accrued_interests_c += $accrued_interests_c[$i];
							$total_late_payment_fees_a += $late_payment_fees_a[$i];
							$total_late_payment_fees_c += $late_payment_fees_c[$i];
							$total_bouncing_cheque_penalties_a += $bouncing_cheque_penalties_a[$i];
							$total_bouncing_cheque_penalties_c += $bouncing_cheque_penalties_c[$i];
							$total_debt_collection_fees_a += $debt_collection_fees_a[$i];
							$total_debt_collection_fees_c += $debt_collection_fees_c[$i];
							$total_principal_collected += $principal_collected[$i];
							$total_future_interests_a += $future_interests_a[$i];
							$total_loan_closing_bal += $loan_closing_bal[$i];
							
							$content .= '<tr>
		                               <th style="text-align: center">'.$loan_product["loan_product_name"].'</th>
		                               <td style="text-align: center">'.$loan_opening_bal[$i].'</td>
									   <td style="text-align: center">'.$loan_fresh_disbursement[$i].'</td>
									   <td style="text-align: center">'.$transaction_fees[$i].'</td>
									   <td style="text-align: center">'.$interests_a[$i].'</td>
									   <td style="text-align: center">'.$interests_c[$i].'</td>
									   <td style="text-align: center">'.$accrued_interests_a[$i].'</td>
									   <td style="text-align: center">'.$accrued_interests_c[$i].'</td>
									   <td style="text-align: center">'.$late_payment_fees_a[$i].'</td>
									   <td style="text-align: center">'.$late_payment_fees_c[$i].'</td>
									   <td style="text-align: center">'.$bouncing_cheque_penalties_a[$i].'</td>
									   <td style="text-align: center">'.$bouncing_cheque_penalties_c[$i].'</td>
									   <td style="text-align: center">'.$debt_collection_fees_a[$i].'</td>
									   <td style="text-align: center">'.$debt_collection_fees_c[$i].'</td>
									   <td style="text-align: center">'.$principal_collected[$i].'</td>
									   <td>'.$future_interests_a[$i].'</td>
									   <td style="text-align: center">'.$loan_closing_bal[$i].'</td>
		                          </tr>';
							$i++;
						}
						$content .= '<tr>
		                               <th>TOTAL</th>
									   <th>'.$total_loan_opening_bal.'</th>
									   <th>'.$total_loan_fresh_disbursement.'</th>
									   <th>'.$total_transaction_fees.'</th>
									   <th style="color: blue">'.$total_interests_a.'</th>
									   <th style="color: purple">'.$total_interests_c.'</th>
									   <th style="color: blue">'.$total_accrued_interests_a.'</th>
									   <th style="color: purple">'.$total_accrued_interests_c.'</th>
									   <th style="color: blue">'.$total_late_payment_fees_a.'</th>
									   <th style="color: purple">'.$total_late_payment_fees_c.'</th>
									   <th style="color: blue">'.$total_bouncing_cheque_penalties_a.'</th>
									   <th style="color: purple">'.$total_bouncing_cheque_penalties_c.'</th>
									   <th style="color: blue">'.$total_debt_collection_fees_a.'</th>
									   <th style="color: purple">'.$total_debt_collection_fees_c.'</th>
									   <th>'.$total_principal_collected.'</th>
									   <th>'.$total_future_interests_a.'</th>
									   <th>'.$total_loan_closing_bal.'</th>';
							 $content .= "</tr>
					
					 </tbody> 
                    </table>";
					$this->product_performance_pdf($content,$month_year.'_Loan Product Performance');
					}else{ 
						$this->product_performance_pdf('No result.',$month_year.'Loan Product Performance');
					} 
		}	
		
	}
	
	public function product_performance_pdf($content,$filename = 'Product Performance'){
	  	//echo 'hehehehe'; exit;
		$content = urldecode($content);
		//Load the library
		$this->load->library('html2pdf');

		//Set folder to save PDF to
		$this->html2pdf->folder('./customer/pdfs/');

		//Set the filename to save/download as
		$this->html2pdf->filename($filename); 

		//Set the paper defaults
		$this->html2pdf->paper('a4', 'landscape');

		//Load html view
		$this->html2pdf->html($content);
		
		//Create the PDF
		$this->html2pdf->create('download'); //other option 'save'
	 }
	 
}