<?php if(!defined('BASEPATH')) exit("Access Denied");

class Mombo extends CI_Controller{
	protected $models = array(
		 
			'user'=>'user_model',
			
			'customer'=>'customer_model',
			
			'loan'=>'loan_model',
			
			'loan_charge' => 'charge_model',
			
			'penalty'=>'penalty_model',
			
			'payment'=>'payment_model',

			'expected_payment' => 'expectedpayment_model',

			'charge_payment' => 'chargepayment_model',
			
			'account' => 'account_model',
		    
			'systemoption' => 'systemoption_model'
	 );
	 
	 protected $header = 'mombo/layout/header'; 
	 
	 protected $footer = 'mombo/layout/footer';
	public function __construct()
	{
	    parent::__construct();
		
	    //function inside autoloaded helper, check if user is logged in, if not redirects to login page
	    is_logged_in();
	}

	 
     public function index(){
	 
			if($this->session->userdata('user_id')){ //if user is already logged in:
			
			        //redirect to user home
					redirect(base_url().'mombo/home');
			   
			}
			
			//otherwise load the login page
			$this->login();
	 }
	 
	
	 
	 public function login1(){
	 	
		$this->msg['message'] = "Login First";
		$this->msg['message_type'] = 'warning';
	 	$this->page->title = "Mombo Loan System | Login";
			
		$this->page->name  = 'mombo-login';
		
		$this->msg['page'] = $this->page;
		
		$this->sendResponse($this->msg,array(
		
			$this->header=>$this->msg,
			
			'mombo/templates/login'=>$this->msg,
			
			$this->footer=>$this->msg,
		  )
		);
	 }
	 
	 public function logout(){
	 
			//Destroy sessions
			$this->session->sess_destroy();

			//redirect to the login page
			$this->page->title = "Mombo Loan System | Logout";

			$this->page->name  = 'mombo-logout';

			$this->msg['page'] = $this->page;

			$this->msg['message'] = "Successfully logged out";

			$this->msg['message_type'] = 'success';

			$this->sendResponse($this->msg,array(

				 $this->header=>$this->msg,
				 
				'mombo/templates/login'=>$this->msg,
				
				$this->footer=>$this->msg,
				
			   )
			);
		
	 }
	 
	 public function home(){
	 		$this->load->model('chargestotalpayment_model');
			
			//login success message
			$message        = null; if($message = $this->input->get('success_login_msg')) $message = $message;

			//get all active customers
			$customers      = $this->customer->findBy(array('status'=>1));
			
			//get all loan items
			$loans          = $this->loan->findAll();
			
			//get all payments
			//$payments       = $this->payment->findAll();
			$payments =  $this->chargestotalpayment_model->get_all_payments();
			
			$principal_outstanding = $this->chargestotalpayment_model->get_outstanding_principal();
			$all_payments_amount = $this->chargestotalpayment_model->get_payments_made();
			$total_amount_due = $this->chargestotalpayment_model->get_total_amount_due();
			
			//get all penalties
			 $charges            = $this->loan_charge->findAll(); 
			 
			 $collection_account = $this->account->findOne($this->systemoption->findBy(array(
			 
						'name' => 'loan_receipt_account',
						
			  )
			 )->row(0,'systemoption_model')->value);
			 
			//var_dump($collection_account);
			
			//get total loan sum
			$total_loan_sum = $this->loan->doSQLFunction('sum','loan_principle_amount');
			
			 
			//populate page properties
			$this->page->title           = "Mombo Loan System | Dashboard";
			
			//set page name
			$this->page->name            = 'mombo-logout';

			//load view data
			$this->msg['page']           = $this->page;
			
			$this->msg['message']        = $message;
			
			$this->msg['customers']      = $customers;
			
			$this->msg['loans']          = $loans; 
			
			$this->msg['payments']       = $payments;
			
			$this->msg['charges']        = $charges;
			
			$this->msg['total_payments'] = $collection_account->account_opening_balance - $collection_account->account_balance;
			
			$this->msg['total_loan_sum'] = $total_loan_sum;
			$this->msg['principal_outstanding'] = $principal_outstanding;
			$this->msg['all_payments_amount'] = $all_payments_amount;
			$this->msg['total_amount_due'] = $total_amount_due;
			
			//load view and send response
			$this->sendResponse($this->msg,array(
			
				$this->header=>$this->msg,
				
				'mombo/templates/home'=>$this->msg,
				
				$this->footer=>$this->msg,
				
			));
	 }


	 public function mombo_404(){

	 	   //populate page properties
			$this->page->title   = "Mombo Loan System | 404 Not Found";
			
			//set page name
			$this->page->name    = 'mombo-404-error';


			$this->msg['page']   = $this->page;
 

			//load view and send response
			$this->sendResponse($this->msg,array(
			
				$this->header=>$this->msg,
				
				'mombo/templates/404error'=>$this->msg,
				
				$this->footer=>$this->msg,
				
			));

	 }
}