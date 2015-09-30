<?php if(!defined('BASEPATH')) exit('Access Denied!!');

class Finance_transfers extends CI_Controller{
    
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

    		
			public function index(){
				 $this->load->model('transfers_model'); 
								 
			     $new_transfers = array();
				 $approved_transfers = array();
				 $rejected_transfers = array();

				 if($this->input->get_post('start_date') && $this->input->get_post('end_date')){
				 		
					   $start_date = $this->input->get_post('start_date');
					   $end_date = $this->input->get_post('end_date');
                      
                       $new_transfers = $this->transfers_model->get_filtered_transfers($start_date,$end_date,0);

				 	   $approved_transfers = $this->transfers_model->get_filtered_transfers($start_date,$end_date,1);
					   
					   $rejected_transfers = $this->transfers_model->get_filtered_transfers($start_date,$end_date,-1);

				 }else{
					   $new_transfers = $this->transfers_model->get_transfers(0);

				 	   $approved_transfers = $this->transfers_model->get_transfers(1);
					   
					   $rejected_transfers = $this->transfers_model->get_transfers(-1);
				 }
				 
				 $this->page->title               = "Mombo Loan System | Finance Transfers";
				 
				 $this->page->name                = 'mombo-finance-transfers';
				 
				 $this->msg['page']               = $this->page;
				 
				 $this->msg['new_transfers'] = $new_transfers;
				 
				 $this->msg['approved_transfers']   = $approved_transfers;
				 $this->msg['rejected_transfers']   = $rejected_transfers;
				 
				 $this->sendResponse($this->msg,array(
					
					    $this->header => $this->msg,
						
						'mombo/templates/finance_transfers_view' => $this->msg,
						
						$this->footer => $this->msg,
				 
				 ));
			
			
			}
	 
}