<?php if(!defined('BASEPATH')) exit('Access Denied!!');

class Balance_sheet extends CI_Controller{
    
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

    		
	public function index($date = 0,$pdf = 0){ 
		$this->load->model('balance_sheet_model'); 
		
		if($date == 0){
			$date= date('Y-m-d');
			$date_ = date('Y-m');
			
			$prev_date = strtotime($date." -1 month");
			$previous_date = date('Y-m', $prev_date);
			$date1 = date ('Y-m-t');
			$prev_date1 = strtotime($date." -1 month");
			$previous_date1 = date('Y-m-t', $prev_date1);
			//echo $previous_date." ".$previous_date1." ".$date1; exit;
			$date_check = date('Y-m')."-01";
			$date_check1 = date ( 'Y-m-t' , strtotime($date) );
			$month_year = date('M, Y');
			$month = date('m');
			$m = date('M');
			$year = date('Y');
		}
		else{
			$date = date ( 'Y-m-d' , strtotime($date));
			$date_ = date ( 'Y-m' , strtotime($date));
			
			$prev_date = strtotime($date." -1 month");
			$previous_date = date('Y-m', $prev_date);
			$date1 = date ( 'Y-m-t' , strtotime($year.'-'.$month) );
			$prev_date1 = strtotime($date." -1 month");
			$previous_date1 = date('Y-m-t', $prev_date1);
			$date_check = date ( 'Y-m-d' , strtotime($year.'-'.$month.'-01') );
			$date_check1 = date ( 'Y-m-t' , strtotime($year.'-'.$month) );
			$month_year = date ( 'M,Y' , strtotime($year.'-'.$month) );
		}
		//echo date("M d, Y", strtotime($date)); exit;
		$l = date ( 't' , strtotime($date) );
				
		$date_aa = strtotime ( '+1 month' , strtotime ( $date ) ) ;
		$date_a = date ( 'Y-m' , $date_aa );
		
		
		$date_b = date("Y-m", mktime(0, 0, 0, date("m")-1, date("d"),   date("Y")));
		
		$savings = $this->balance_sheet_model->get_savings($date);
		$total_amount_due = $this->balance_sheet_model->get_total_amount_due($date);
		$creditors = $this->balance_sheet_model->get_creditors_amount($date,4);
		$opening_bal_equity = $this->balance_sheet_model->get_opening_bal_equity();
		//echo $creditors[0]; exit;
		
		
		$accrued_transaction_fees = $this->balance_sheet_model->get_transaction_fees($date);
		$accrued_interests = $this->balance_sheet_model->get_interest($date);
		$accrued_interests_b = $this->balance_sheet_model->get_interest_b($date);
		$accrued_charges = $this->balance_sheet_model->get_charges($date);
		
		$interests_c = $this->balance_sheet_model->get_interests_c($date);
		$accrued_interests_c = $this->balance_sheet_model->get_charges_c($date,'interest_fee');
		$late_payment_fees_c = $this->balance_sheet_model->get_charges_c($date,'latepayment_fee');
		$bouncing_cheque_penalties_c = $this->balance_sheet_model->get_charges_c($date,'bouncing cheque penalty');
		$debt_collection_fees_c = $this->balance_sheet_model->get_charges_c($date,'Debt recovery penalty');
		
		$expenditure_accts = $this->balance_sheet_model->get_exp_accts();
		$expenditures_array = array(); 
		foreach($expenditure_accts as $expenditure_acct){
			$expenditures_array[] = $this->balance_sheet_model->get_expenditures($expenditure_acct["id"],$date);
		}
		
		$i = 1;
		$gross_income = 0;
		$total_expenditure = 0;
		$net_income = 0;
			
		foreach($accrued_transaction_fees as $accrued_transaction_fee){
			$gross_income += $accrued_transaction_fee["amount"];
		}
		//echo $gross_income; exit;
		foreach($accrued_interests as $accrued_interest){
			$gross_income += $accrued_interest["total_interest_amount"];
		}
		$gross_income += $accrued_interests_b;
				
		foreach($accrued_charges as $accrued_charge){
			$gross_income += $accrued_charge["amount"] - $accrued_charge["waiver"];
		}
		for($i = 0; $i < count($expenditures_array); $i++){
			$expenditures = $expenditures_array[$i];
			foreach($expenditures as $expenditure){
				$total_expenditure += $expenditure['amounttransacted'];
			}
		}
		
		$net_income = $gross_income - $total_expenditure;
		//echo $gross_income." - ".$total_expenditure." = ". $net_income; exit;
		
				
		if(! $pdf){
			$this->page->title      = "Mombo Loan System | Balance Sheet";
		 
			$this->page->name       = 'mombo-balance-sheet';
			 
			$this->msg['page']      = $this->page;
			 
			$this->msg['savings'] = $savings;
			$this->msg['total_amount_due'] = $total_amount_due;
			$this->msg['creditors'] = $creditors;
			$this->msg['opening_bal_equity'] = $opening_bal_equity;
			$this->msg['net_income'] = $net_income;
						
			$this->msg['date'] = $date;
			/*$this->msg['month'] = $month;
			$this->msg['mwaka'] = $year;*/
			
					
			$this->sendResponse($this->msg,array(
				
		    	$this->header => $this->msg,
					
					'mombo/templates/balance_sheet_view' => $this->msg,
					
					$this->footer => $this->msg,
			 
			));
		}
		else{
			/*$img_url = 'img/logo2.png';
			$contentA = '<img src="'.$img_url.'"/><br />';
			$contentA .= '<strong>All</strong><br />';
			
			$contentA .= $month_year; 
			
			if( count($all_details) > 0 ){ 
				$contentA .= "<table>
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
	                    <tbody>";
                    
					$total_target_amount = 0;
					$total_actual_amount = 0;
					$performance = 0;
					for($i = 0, $j = 1; $i < count($all_details); $i++){
						$details = explode("*",$all_details[$i]);
						$total_target_amount += $details[4];
						$total_actual_amount += $details[5];
						$contentA .= "<tr>";
							$contentA .= "<td>".$j."</td>";
							$contentA .= "<td>".$details[0]."</td>";
							$contentA .= "<td>".$details[2]."</td>";
							$contentA .= "<td>".$details[7]."</td>";
							$contentA .= "<td>".$details[6]."</td>";
							$contentA .= "<td>".number_format($details[4],2,'.',',')."</td>";
							$contentA .= "<td>".number_format($details[5],2,'.',',')."</td>";
						$contentA .= "</tr>";
						$j++;
					}
					$performance = round(($total_actual_amount/$total_target_amount)*100,2);
					
					$contentA .= "<tr>";
							$contentA .= "<td></td>";
							$contentA .= "<td></td>";
							$contentA .= "<td></td>";
							$contentA .= "<td></td>";
							$contentA .= "<td></td>";
							$contentA .= "<td style='color: purple'></td>";
							$contentA .= "<td style='color: blue'></td>";
					$contentA .= "</tr>";
					
					$contentA .= "<tr>";
							$contentA .= "<td></td>";
							$contentA .= "<td></td>";
							$contentA .= "<td></td>";
							$contentA .= "<td></td>";
							$contentA .= "<td></td>";
							$contentA .= "<td style='color: purple'>".number_format($total_target_amount,2,'.',',')."</td>";
							$contentA .= "<td style='color: blue'>".number_format($total_actual_amount,2,'.',',')."</td>";
					$contentA .= "</tr>";
					
					$contentA .= "<tr>";
						$contentA .= '<td colspan = "6" style="color: green;text-align:right">Performance: '.$performance.'%</td>';
					$contentA .= "</tr>
				
				 </tbody> 
                </table>";
				$this->collection_performance_pdf($contentA,$month_year.'_Collection Performance');
				}else{ 
					$this->collection_performance_pdf('No result.',$month_year.'_Collection Performance');
				} */
		}
	
	}
	
	public function collection_performance_pdf($content,$filename = 'Collection Performance'){
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