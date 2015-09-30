<?php if(!defined('BASEPATH')) exit('Access Denied!!');

class Admin_login extends CI_Controller{ 
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
	 public function index(){
			//Proceed only if the user has not been blocked
			if($this->input->post('login_btn') && (user_not_blocked())){
					 
					 //Initialize counter if not initialized,with maximum attempts allowed as parameter
					 init_attempts_counter(10);
					 
					 $user = $this->user->findBy(array(
					 
						   'user_email'=>$this->input->post('username'),
						   
						   'user_password'=>$this->input->post('password'),
						   
					   )
					 )->row(0,'user_model');
					 

					 if(null != $user){
					 
							 $this->session->set_userdata(array(
							 
								   'user_fullname'=>$user->user_fullname,
								   
								   'user_email'=>$user->user_email,
								   
								   'user_phone'=>$user->user_password,
								   
								   'user_type'=>$user->user_type,
								   
								   'user_photo'=>$user->user_photo,
								   
								   'user_description'=>$user->user_description,
								   
								   'user_id'=>$user->id,
							    )
							 );
							 
							 //log login
							 /* to_db_log("login",array(
							  
									  'access-time' => date('Y-m-d H:m:s',time()),
									  
									  'user-ip-address' => $_SERVER['REMOTE_ADDR'],
									  
									  'user-agent' => $this->agent->agent_string(),
									  
									  'userid-entered' => $this->input->post('username'),
									  
									  'password-entered' => $this->input->post('password'),
									  
									  )
							  ); */
							 
							 redirect(base_url().'mombo/home/?success_login_msg=Hello '.$this->session->userdata('user_fullname').', you have successfully logged into Mombo Loan System as Administrator');
							 
					 }
					 
					 //increment attempts counter
					 increment_att_counter();
					 
					 //Check if attempts limit passed if so block user
					 if(doubt_used_up()){
					 
							  //Use cookie based blocking mechanism
							  clear_counter();
							  
							  block_user_cookie();
							  
							  //log block action
							/* -------------------------
							   Accepted array fields
							   ------------------------
							   array(
							   'access-time',
							   'user-ip-address',
							   'userid-entered',
							   'password-entered',
							   'host-name',
							   'user-agent',
							  ); */
							  
							  to_db_log("block",array(
							  
									  'access-time' => date('Y-m-d H:m:s',time()),
									  
									  'user-ip-address' => $_SERVER['REMOTE_ADDR'],
									  
									  'user-agent' => $this->agent->agent_string(),
									  
									  'userid-entered' => $this->input->post('username'),
									  
									  'password-entered' => $this->input->post('password'),
									  
									  )
							  ); 
							 
							 $this->msg['message']      = "Too many tries";
							 
							 $this->msg['message_type'] = 'warning';
							 
					 }else{
					 
							//Log the unsuccessful login
							/*-------------------------
							Accepted array fields
							------------------------
							array(
								'access-time'=>'',
								'user-ip-address'=>'',
								'userid-entered'=>'',
								'password-entered'=>'',
								'host-name'=>'',
								'user-agent'=>'',
								'at-attempt-no'=>'',
							)
							/*---------------*/
							
							to_db_log("unaccess",array(
							
							   'access-time' => date('Y-m-d H:m:s',time()),
							   
							   'user-ip-address' => $_SERVER['REMOTE_ADDR'],
							   
							   'user-agent' => $this->agent->agent_string(),
							   
							   'userid-entered' => $this->input->post('username'),
							   
							   'password-entered' => $this->input->post('password'),
							   
							   'at-attempt-no' => get_attempts_tried(),
							   
							   )
							); 

							$this->msg['message'] = "Invalid login details";
							
							$this->msg['message_type'] = 'warning';
					 }
			}else{
			
				   if(!user_not_blocked()){
				   
						   $this->msg['message'] = "Too many tries";
						 
						   $this->msg['message_type'] = 'warning';
					 
				   }
				   
			}

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
}