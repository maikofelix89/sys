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

    		
	public function index($month = 0, $year = 0){ 
		$this->load->model('statements_model'); 
		
		if($month == 0 && $year == 0){
			$date= date('Y-m');
			$date_check = date('Y-m')."-01";
			$date_check1 = date ( 'Y-m-t' , strtotime($date) );
			$month_year = date('M, Y');
		}
		else{
			$date = date ( 'Y-m' , strtotime($year.'-'.$month) );
			$date_check = date ( 'Y-m-d' , strtotime($year.'-'.$month.'-01') );
			$date_check1 = date ( 'Y-m-t' , strtotime($year.'-'.$month) );
			$month_year = date ( 'M,Y' , strtotime($year.'-'.$month) );
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
		
				
		$this->sendResponse($this->msg,array(
			
	    	$this->header => $this->msg,
				
				'mombo/templates/statements_view' => $this->msg,
				
				$this->footer => $this->msg,
		 
		));
	
	}
	 
}