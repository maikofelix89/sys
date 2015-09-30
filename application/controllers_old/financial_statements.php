<?php if(!defined('BASEPATH')) exit('Access Denied!!');

class Financial_statements extends CI_Controller{
    
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
				
		$this->page->title      = "Mombo Loan System | Financial Statements";
		 
		$this->page->name       = 'mombo-financial-statements';
		 
		$this->msg['page']      = $this->page;
		 
						
		$this->sendResponse($this->msg,array(
			
	    	$this->header => $this->msg,
				
				'mombo/templates/financial_statements_view' => $this->msg,
				
				$this->footer => $this->msg,
		 
		));
	
	}
	 
}