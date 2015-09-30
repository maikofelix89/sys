<?php if(!defined('BASEPATH')) exit('Access Denied!!');

class Pre_fees extends CI_Controller{
    
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
		$message = "";
		if($this->input->get_post('message',TRUE)){
			$this->msg['message'] = $this->input->get_post('message',TRUE);
			$this->msg['message_type'] = $this->input->get_post('message_type',TRUE);
		}
		$this->page->title      = "Mombo Loan System | Pre-Fees";
		 
		$this->page->name       = 'mombo-pre-fees';
		 
		$this->msg['page']      = $this->page;
		 
						
		$this->sendResponse($this->msg,array(
			
	    	$this->header => $this->msg,
				
				'mombo/templates/pre_fees_view' => $this->msg,
				
				$this->footer => $this->msg,
		 
		));
	
	}
	
	
	 public function submit(){
	  
			$message = null; //add new form error message
			if($this->input->get('message')) $message = $this->input->get('message');

			$errors  = array(); // contains validation error for submitted customer properties

			if($this->input->post('submit')){ //proceed only if the register submit button has been clicked
					
					$this->load->model('account_model');
					$this->load->model('transaction_model');
					$this->load->model('pay_model');
					
					$customer_id = $this->input->get_post('select_customer',TRUE);
					$payment_channel_id = $this->input->get_post('payment_channel_id',TRUE); 
					$income_account_id = $this->input->get_post('income_account_id',TRUE);  
					$amount = $this->input->get_post('amount',TRUE);		
					$payment_description = $this->input->get_post('payment_description',TRUE);
					$customer = $this->pay_model->get_customer_details($customer_id);
					$customer_account = $this->pay_model->get_customer_account($customer_id); 
					$payment_code = $customer_id.''.date('siHdmY').''.mt_rand(100,999);
					$income_account = $this->account_model->get_account($income_account_id); 
					//$receipt_num = $reg_id.''.date('siHdmY');
					
					$user_id = $this->session->userdata('user_id');
					
					if($amount <= 0){
						redirect(base_url().'pre_fees/?message=Amount should be greater than zero&message_type=error');
					}
						
					$update_payment_channel = $this->account_model->update_account_balance($payment_channel_id,$amount,1); //echo "heres ". $update_payment_channel; exit;
					if($update_payment_channel <= 0){
						redirect(base_url().'pre_fees/?message=Error occured. Please retry again later.&message_type=error');
					}
					
					$update_income_account = $this->account_model->update_account_balance($income_account_id,$amount,1);
					if($update_income_account <= 0){
						redirect(base_url().'pre_fees/?message=Could not complete the transaction. Please contact IT.&message_type=error');
					}
					
					$transaction_code = $customer_id.date('sihdmY').$payment_channel_id;
					
					$this->account_model->insert_income($income_account_id,$amount,$transaction_code,$user_id);
					
					$description1 = "Payment for ".$income_account;
					$description2 = 'Customer Account Number: '.$customer_account.". Paymement for ".$income_account;
					$date = date('Y-m-d');
					
					$this->transaction_model->insert_new_transaction(0,$transaction_code,$customer_account,1,$description1,$date,$amount,$user_id,$payment_code);
					$this->transaction_model->insert_new_transaction(0,$transaction_code,$income_account_id,1,$description2,$date,$amount,$user_id,$payment_code);
					$this->transaction_model->insert_new_transaction(0,$transaction_code,$payment_channel_id,1,$description2,$date,$amount,$user_id,$payment_code);
					//echo date('Y-m-01', strtotime('+'.$deposits_period.' months', strtotime(date('Y-m-d'))));  exit;
					$message = "Transaction completed successfully.";
					$message_type = "info";
			}
             
			//populate template data
			$this->page->title    = "Mombo Loan System | Loan Pre-Fees";

			$this->page->name     = 'mombo-pre-fees';

			$this->msg['page']    = $this->page;

			$this->msg['message_type'] = $message_type;
			
			$this->msg['message'] = $message;

			$this->msg['errors']  = $errors;

			$this->sendResponse($this->msg,array(
			
				 $this->header =>$this->msg,
				 
				 'mombo/templates/pre_fees_view' => $this->msg,
				 
				 $this->footer => $this->msg,
				 
			));
	  }
	 
}