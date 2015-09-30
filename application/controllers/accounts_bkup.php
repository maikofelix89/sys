<?php if(!defined('BASEPATH')) exit("Access Denied");

class Accounts extends CI_Controller{

		protected $models = array(
		
		        'sys_object' => 'systemobject_model',
			
				'account' => 'account_model',
				'sub_account' => 'sub_account_model',
				
				'transaction' => 'transaction_model',
				
				'customer_account'  => 'customeraccount_model',
				
				'customer'  => 'customer_model',
				
				'systemoption' => 'systemoption_model',
				
				'loan' => 'loan_model',
				
				'loan_charge' => 'charge_model',
				
				'product' => 'product_model',
			
				'expected_payment' => 'expectedpayment_model',

				'payment' => 'payment_model',

				'charge_payment' => 'chargepayment_model',
				
		
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
		
				$criteria      = $this->input->get_post('criteria');
				
				$message       = $this->input->get_post('message');
				
				$message_type  = $this->input->get_post('message_type');
				
				$accounts      = null;
				
				if($criteria && in_array($criteria,array('expense','other'))){
						
						$is_exp = 0;
						
						switch(strtolower($criteria)){
						
								case 'expense': $is_exp = 1; $criteria = 'expense'; break;
								
								case 'others' : $criteria = 'other'; break;
								
								default:break;
						}
						
						$accounts = $this->account->findBy(
						
								array(
							
										'is_exp' => $is_exp,
										
								),
								
								array(
									
									   (int) $this->input->get_post('per_page'),
									   
									   20,
								)
						);
						
				}else{
				
						$accounts = $this->account->findAll();
						
						$criteria      = 'all';
		
				}
				
				$this->page->title    			= "Mombo Loan System | Accounts";
				
				$this->page->name     			= 'mombo-accounts';
				
				$this->msg['page']   			= $this->page;
				
				$this->msg['message'] 			= $message;
				
				$this->msg['message_type']      = $message_type;
				
				$this->msg['criteria']          = $criteria;
				
				$this->msg['accounts']			= $accounts;
				
				$this->sendResponse($this->msg,array(
				
						$this->header => $this->msg,
						
						'mombo/templates/accounts' => $this->msg,
						
						$this->footer => $this->msg,
				));
		
		}
		
		/******Account CRUD******/
		        
				public function addaccount(){
				
				        $message = null;
						
						$errors  = array();
						
						if($this->input->post('create_account')){
								
								$account = $this->input->post('account');
								
								$account['account_balance'] = $account['account_opening_balance'];
								
								$added	 = $this->account->create($account);
								
								if($added) redirect(base_url().'accounts/?message=account added successfully&message_type=success');
								
								$message = "Error adding new account!. Please review your inputs";
								
								$errors  = $this->account->validationerrors();
						
						}
					
						$this->page->title     = "Mombo Loan System | Add new account";
						
						$this->page->name      = 'mombo-addnew';
						
						$this->msg['page']     = $this->page;
						
						$this->msg['account']  = $this->account;
						
						$this->msg['message']  = $message;
						
						$this->msg['errors']   = $errors;
						
						$this->msg['criteria'] = 'addnew';
						
						$this->sendResponse($this->msg,array(
						
								$this->header => $this->msg,
								
								'mombo/templates/addnewaccount' => $this->msg,
								
								$this->footer => $this->msg,
						));
				}
				
				
				public function addsubaccount(){
				
				        $message = null;
						
						$errors  = array();
						
						if($this->input->post('create_sub_account')){
								$this->load->model('account_model');
								$sub_account = $this->input->post('sub_account');
								
								$sub_account['account_balance'] = $sub_account['account_opening_balance'];
								//echo 'here'.$sub_account['account_name']; exit;
								
								$this->account_model->update_account_has_child($sub_account['parent_id']);
								
								$added	 = $this->sub_account->create($sub_account);
								
								if($added) redirect(base_url().'accounts/?message=sub account added successfully&message_type=success');
								
								$message = "Error adding new sub account!. Please review your inputs";
								
								$errors  = $this->sub_account->validationerrors();
						
						}
					
						$this->page->title     = "Mombo Loan System | Add new sub account";
						
						$this->page->name      = 'mombo-addnew';
						
						$this->msg['page']     = $this->page;
						
						$this->msg['sub_account']  = $this->sub_account;
						
						$this->msg['message']  = $message;
						
						$this->msg['errors']   = $errors;
						
						$this->msg['criteria'] = 'addnew';
						
						$this->sendResponse($this->msg,array(
						
								$this->header => $this->msg,
								
								'mombo/templates/addnewsubaccount' => $this->msg,
								
								$this->footer => $this->msg,
						));
				}
				
				
				public function editaccount(){
				
						$account_id = (int) $this->input->get_post('account_id');
						$sub_account_id = (int) $this->input->get_post('sub_account_id');
						
						$message    = null;
						
						$errors     = array();
						
						if(!isset($account_id) || empty($account_id) || $account_id != '' || null != $account_id){
						
						         $account_id = ($account = $this->input->get_post('account')) ? $account['id'] : $account_id;
						
						} 
						
						if(!isset($sub_account_id) || empty($sub_account_id) || $sub_account_id != '' || null != $sub_account_id){
						
						        $sub_account_id = ($sub_account = $this->input->get_post('sub_account')) ? $sub_account['id'] : $sub_account_id;
						
						} 
						
						if($account['account_opening_balance'] == 0){
							$account['account_opening_balance'] = 0.00;
						}
						if($account['account_balance'] == 0){
							$account['account_balance'] = 0.00;
						}
													 
						
						if($account_id){
						
						        $account = $this->account->findOne($account_id);
						        
								if(null != $account){
								      
									  $this->account = $account;
									  
								      if($this->input->post('update_account')){
									  
									           $updated = $this->account->doupdate($this->input->post('account'));
									       
									           if($updated) redirect(base_url().'accounts/?message=account edited successfully!&message_type=success');
											   
											   $message = 'Error editing account. Please review your inputs and try again';
											   
											   $errors  = $this->account->validationerrors();
											  
									   }
									   
								}else{
								
										redirect(base_url().'accounts/?message=account doesnt exist&message_type=warning');
								
								}
							}
							elseif($sub_account_id){
						
						        $sub_account = $this->sub_account->findOne($sub_account_id);
						        
								if(null != $sub_account){
								      
									  $this->sub_account = $sub_account;
									  
								      if($this->input->post('update_sub_account')){
									  
									           $updated = $this->sub_account->doupdate($this->input->post('sub_account'));
									       
									           if($updated) redirect(base_url().'accounts/?message=sub account edited successfully!&message_type=success');
											   
											   $message = 'Error editing account. Please review your inputs and try again';
											   
											   $errors  = $this->sub_account->validationerrors();
											  
									   }
									   
								}else{
								
										redirect(base_url().'accounts/?message=account doesnt exist&message_type=warning');
								
								}
							
						}else{
						        
						        redirect(base_url().'accounts/?message=Error!. Action\'s minimum requirement not met&message_type=warning');
								
						}
							
											
							
				 redirect(base_url().'accounts/?message=Error editing account. Please review your inputs and try again&message_type=error');							/*$this->page->title 		= "Mombo Loan System | Account Edit";
						
						$this->page->name  		= 'mombo-edit-account';
						
						$this->msg['page'] 		= $this->page;
						
						$this->msg['criteria']  = '';
						
						$this->msg['message']   = $message;
						
						$this->msg['errors']    = $errors;
						
						$this->msg['account']   = $this->account;
						
						$this->sendResponse($this->msg,array(
							
									$this->header=>$this->msg,
									
									'mombo/templates/editaccount'=>$this->msg,
									
									$this->footer=>$this->msg,
								
						    )
						 
					    );*/
				}
				
				
				public function deleteaccount(){
						
						$account_id = (int) $this->input->get_post('account_id');
						
						if($account_id){
						
						       $account = $this->account->findOne($account_id);
							   
                               if(null != $account){
							   
									   if($this->input->get_post('confirmed')){
									   
									          if($account->delete()) redirect(base_url().'accounts/?message=account deleted successfully!&message_type=success');
											  
									   }
							   
							   }else{
							   
										redirect(base_url().'accounts/?message=account doesnt exist&message_type=warning');
							      
							   }
							   
						}else{
						
						        redirect(base_url().'accounts/?message=Error!. Action\'s minimum requirement not met&message_type=warning');
						
						}
						
						$this->page->title 		= "Mombo Loan System | Confirm Delete";
						
						$this->page->name  		= 'mombo-remove-account';
						
						$this->msg['page'] 		= $this->page;
						
						$this->msg['message']   = "Do you really want to delete this account";
						
						$this->msg['yes_url']   = base_url().'accounts/deleteaccount/?confirmed=true&account_id='.$account_id;
						
						$this->msg['no_url']    = base_url().'accounts/accountsummary/?account_id='.$account_id;
						
						$this->sendResponse($this->msg,array(
							
									$this->header=>$this->msg,
									
									'mombo/templates/confirm'=>$this->msg,
									
									$this->footer=>$this->msg,
								
						    )
						 
					    );
				}
				
				public function accountsummary($action = 0){
					
					$account_id = (int) $this->input->get_post('account_id');
					$sub_account_id = (int) $this->input->get_post('sub_account_id');
					$is_sub = (int) $this->input->get_post('is_sub');
					$this->load->model('transaction_model');
									
					if($account_id || $sub_account_id){
						
							if( ($action == 1) || ($action == 2) ){
								$payment_code = date('siHdmY').''.$account_id;
								$amount_to_transfer = 0;
								$user_id = $this->session->userdata('userid');
								$codes = $this->input->get_post('c');
								//$codes = substr($codes,0,-1);
								$payment_codes = explode(',',$codes);
								//echo $payment_codes[0]; exit;
								for($i = 0; $i < count($payment_codes); $i++){
									//echo $payment_codes[$i]; exit;
									$amount_to_transfer += $this->transaction_model->get_amount($payment_codes[$i]);
									$this->transaction_model->update_transaction_details($payment_codes[$i],$payment_code);
								}
								$amount_to_transfer = (double) $amount_to_transfer;
								$other_account = $this->transaction_model->get_account_name($action);
								//echo $amount_to_transfer; exit;
								$account_name = $this->transaction_model->get_account_name($account_id); 
								$description = 'Cash transfer to '.$other_account;
								$description1 = 'Cash transfer from '.$account_name;
								$date = date('Y-m-d');
								$object = 0;
								$this->transaction_model->insert_new_transaction($object,$payment_code,$account_id,0,$description,$date,$amount_to_transfer,$user_id,$payment_code);
								$this->transaction_model->insert_new_transaction($object,$payment_code,$action,1,$description1,$date,$amount_to_transfer,$user_id,$payment_code);
								$this->transaction_model->update_balance($account_id,$amount_to_transfer,0);
								$this->transaction_model->update_balance($action,$amount_to_transfer,1);
								
								$this->msg['message_type'] = "successful";
								$this->msg['message'] = "KSH. ".$amount_to_transfer." has been transfered from ".$account_name." to ".$other_account;
							}
							
							if($is_sub){
								$account = $this->sub_account->findOne($sub_account_id);
							}
							else{
								$account = $this->account->findOne($account_id);
							}
							
							
							if(null != $account){
								
									$this->page->title     		 = "Mombo Loan System | Account Summary";
									
									$this->page->name      		 = 'account-summary';
									
									$this->msg['page']    		 = $this->page;
									
									$this->msg['criteria']       = '';
									
									$this->msg['account'] 		 = $account;
									
									if($is_sub){
										$trans   = $this->transaction->findBy(array(
											
												'sub_account' => $account->id,'is_deleted' => 0), array(), array('id' , 'desc')
												
										);	
									}
									else{
										$trans   = $this->transaction->findBy(array(
												
												'account' => $account->id,'is_deleted' => 0), array(), array('id' , 'desc')
												
										);
									}
									
									$transactions = array();
									$payment_codes  = array();
									$amounts = array();
									$acct_bal = array();
									foreach($trans->result('transaction_model') as $transaction){
										if($transaction->payment_code == 0){
											continue;
										}
										if(in_array($transaction->payment_code,$payment_codes)){
											$amounts[$transaction->payment_code] += $transaction->amounttransacted;
											continue;
										}
										$payment_codes[] = $transaction->payment_code;
										$description = '';
										$customer_id = $this->transaction_model->get_customer_id($transaction->transaction_code);
										if($customer_id == 0){
											$description = $transaction->description;
										}
										else{
											$customer_array = $this->transaction_model->get_customer($customer_id);
											$customer_name = $customer_array['name'].' '.$customer_array['other_names'];
											$description = $customer_name;
										}
										$acct_bal[$transaction->payment_code] = $transaction->acct_bal;
										$amounts[$transaction->payment_code] = $transaction->amounttransacted;
										
										$transactions[] = $transaction->payment_code.'*'.$transaction->date.'*'.$description.'*'.$transaction->transactiontype.'*'.$transaction->amounttransacted.'*'.$transaction->acct_bal;
										
									}
									
									$this->msg['transactions'] = $transactions;
									$this->msg['amounts'] = $amounts;
									$this->msg['acct_bal'] = $acct_bal;
									
									$this->sendResponse($this->msg,array(
									
											$this->header => $this->msg,
											
											'mombo/templates/accountsummary' => $this->msg,
											
											$this->footer => $this->msg,
											
									 )
									);
							
							}else{
							
									redirect(base_url().'accounts/?message=account doesnt exist&message_type=warning');
							
							}
					
					}else{
					
					        redirect(base_url().'accounts/?message=Error!. Action\'s minimum requirement not met&message_type=warning');
							
					}
				
				}
				
				public function multiple_transfer(){
				
					$this->load->model('transaction_model');
						$account_id = (int) $this->input->get_post('account_id');
						
						if($account_id){
								
								$account = $this->account->findOne($account_id);
								
								if(null != $account){
									
										$this->page->title     		 = "Mombo Loan System | Account Summary";
										
										$this->page->name      		 = 'account-summary';
										
										$this->msg['page']    		 = $this->page;
										
										$this->msg['criteria']       = '';
										
										$this->msg['account'] 		 = $account;
										
										$trans   = $this->transaction->findBy(array(
												
												'account' => $account->id,'is_deleted' => 0), array(), array('id' , 'desc')
												
										);
										$transactions = array();
										$payment_codes  = array();
										$amounts = array();
										$acct_bal = array();
										foreach($trans->result('transaction_model') as $transaction){
											if($transaction->payment_code == 0){
												continue;
											}
											if(in_array($transaction->payment_code,$payment_codes)){
												$amounts[$transaction->payment_code] += $transaction->amounttransacted;
												continue;
											}
											$payment_codes[] = $transaction->payment_code;
											$description = '';
											$customer_id = $this->transaction_model->get_customer_id($transaction->transaction_code);
											if($customer_id == 0){
												$description = $transaction->description;
											}
											else{
												$customer_array = $this->transaction_model->get_customer($customer_id);
												$customer_name = $customer_array['name'].' '.$customer_array['other_names'];
												$description = $customer_name;
											}
											$acct_bal[$transaction->payment_code] = $transaction->acct_bal;
											$amounts[$transaction->payment_code] = $transaction->amounttransacted;
											
											$transactions[] = $transaction->payment_code.'*'.$transaction->date.'*'.$description.'*'.$transaction->transactiontype.'*'.$transaction->amounttransacted.'*'.$transaction->acct_bal;
											
										}
										
										$this->msg['transactions'] = $transactions;
										$this->msg['amounts'] = $amounts;
										$this->msg['acct_bal'] = $acct_bal;
										
										$this->sendResponse($this->msg,array(
										
												$this->header => $this->msg,
												
												'mombo/templates/accountsummary' => $this->msg,
												
												$this->footer => $this->msg,
												
										 )
										);
								
								}else{
								
										redirect(base_url().'accounts/?message=account doesnt exist&message_type=warning');
								
								}
						
						}else{
						
						        redirect(base_url().'accounts/?message=Error!. Action\'s minimum requirement not met&message_type=warning');
								
						}
				
				}
				
				public function getallaccounts(){
				
				
				}
		
		/******End Account CRUD******/
		
		/******Account Activity******/
		
		        public function transfercash($transfer_from){
					$this->load->model('account_model');
				     if( ($this->input->post('transfer_from_bank')) || ($this->input->post('transfer_from_cash')) ){
					 
							$from_account_id = (int) $transfer_from;
							
							$to_account_string   = $this->input->post('payee');
							$to_account_array = explode("*",$to_account_string);
							
							$amount       = (double) $this->input->post('amount');
							
							$reference_number  = $this->input->post('reference_num');
							if($from_account_id == 1){
								$date  = $this->input->post('date');
							}
							else{
								$date = date('Y-m-d');
							}
							
							$description  = $this->input->post('description');
							
							$from_account = $this->account->findOne($from_account_id);
							$check = FALSE;
							if($from_account_id == 4){
								$check = TRUE;
							}
							if($from_account->account_balance >= $amount){
								$check = TRUE;
							}
							if($check){
								$this->account_model->update_account_balance($from_account_id,$amount,0);
								$to_account_id = 0;
								if($to_account_array[0] == 'p'){
									$this->account_model->update_account_balance($to_account_array[1],$amount,1);
									$to_account_id = $to_account_array[1];
									$to_sub_account_id = 0;
									$to_account = $this->account->findOne($to_account_id);
								}
								elseif($to_account_array[0] == 'c'){
									$this->account_model->update_account_balance($to_account_array[2],$amount,1);
									$this->account_model->update_sub_account_balance($to_account_array[1],$amount,1);
									$to_account_id = $to_account_array[2];
									$to_sub_account_id = $to_account_array[1];
									$to_account = $this->sub_account->findOne($to_sub_account_id);
									//echo $to_account->account_name;
								}
								$t_code  = 'TRNS-'.date('Y-m',time()).strtoupper(random_string('alnum',4));
								$obj = 0;
								$acct_to = $to_account_id;
								$sub_acct_to = $to_sub_account_id;
								$t_type_d = 0; //debit
								$t_type_c = 1; //credit
								$description_c = 'Transfer from '.$from_account->account_name.', '.$description;
								$description_d = 'Transfer to '.$to_account->account_name.', '.$description;
								$user = $this->session->userdata('user_id');
								$payment_code = $acct_to.''.date('siHdmY');
								//echo $payment_code; exit;
								$this->account_model->insert_transaction($obj,$t_code,$from_account_id,0,$t_type_d,$description_d,$date,$amount,$usr,$payment_code,$reference_number);//debit
								$this->account_model->insert_transaction($obj,$t_code,$acct_to,$sub_acct_to,$t_type_c,$description_c,$date,$amount,$usr,$payment_code,$reference_number);//credit
								
								redirect(base_url().'accounts/?message=Transfer has been successful&message_type=success');
							}
							else{
								redirect(base_url().'accounts/?message=amount to transfer is greater than origin account\'s balance&message_type=warning');
							}
							
						}
				}
				
				public function doubleentry(){
				
				}
				
				public function accounttransactionhistory(){
				
				      $transaction = $this->input->get_post('transaction_id');
					  
					  $message = null;
					  
					  $message_type = null;
					  
					  $transaction = $this->transaction->findOne($transaction);
					  
					  if(null != $transaction){
					  
								//$account = $this->account->findOne($transaction->account) || $this->customer_account->findOne($transaction->account);
								
								//$object  = $this->system_object->findOne($transaction->object)->name;
								
								/*switch(strtolower($object)){
								
								}*/
					  
					  }else{
					     
						   $messsage      = 'Transaction record not found';
						   
						   $message_type  = 'warning';
					  
					  }
					  
					  $this->page->title           = "Mombo Loan System | Transaction History Log";
					  
					  $this->page->name            = 'mombo-transaction-history';
					  
					  $this->msg['page']           = $this->page;
					  
					  $this->msg['message']        = $message;
					  
					  $this->msg['message_type']   = $message_type;
					  
					  $this->sendResponse($this->msg,array(
					  
							$this->header => $this->msg,
							
							'mombo/templates/transactionhistory' => $this->msg,
							
							$this->footer => $this->msg,
							
					  ));
 				
				
				}
				
				public function deletetransaction(){
				
				}
				
				public function edittransaction(){
				
				}
				
				public function viewtransactiondetails(){
				
				}
				
	   /******End Account Activity******/


	   /******Customer Ledger Accounts*****/


	   		    public function customeraccounts(){

		   		    	$criteria 		= $this->input->get_post('criteria');

		   		    	$message  		= $this->input->get_post('message');
	 
		   		    	$message_type   = $this->input->get_post('message_type');

		   		    	if($criteria && in_array($criteria,array('bal','nobal'))){
	                          


		   		    	}else{

		   		    		$criteria       = 'all';

		   		    	    $accounts       = $this->customer_account->findAll();

		   		    	}


		   		    	$this->page->title   		= "Mombo Loan System | Customer Ledger Accounts";

		   		    	$this->page->name     		= 'mombo-customer-accounts';

		   		    	$this->msg['page']    		= $this->page;

		   		    	$this->msg['criteria']      = $criteria;
	 
		   		    	$this->msg['message'] 		= $message;

		   		    	$this->msg['message_type']  = $message_type;

		   		    	$this->msg['accounts']      = $accounts;

		   		    	$this->sendResponse($this->msg,array(

		   		    		   $this->header => $this->msg,

		   		    		   'mombo/templates/customeraccounts' => $this->msg,

		   		    		   $this->footer => $this->msg,

		   		        ));
	   		    }


	   		    public function customeraccountsummary(){

	   		    	  $account_id = (int) $this->input->get_post('account_id');

	   		    	 if($account_id){
								
								$account = $this->customer_account->findOne($account_id);
								
								if(null != $account){
									
										$this->page->title     		 = "Mombo Loan System | Customer Account Summary";
										
										$this->page->name      		 = 'mombo-customer-account-summary';
										
										$this->msg['page']    		 = $this->page;
										
										$this->msg['criteria']       = '';
										
										$this->msg['account'] 		 = $account;
										
										$this->msg['transactions']   = $this->transaction->findBy(array(
												
												'account' => $account->id,
												
										   )
										);
										
										$this->sendResponse($this->msg,array(
										
												$this->header => $this->msg,
												
												'mombo/templates/customeraccountsummary' => $this->msg,
												
												$this->footer => $this->msg,
												
										 )
										);
								
								}else{
								
										redirect(base_url().'accounts/customeraccounts/?message=account doesnt exist&message_type=warning');
								
								}
						
						}else{
						
						        redirect(base_url().'accounts/customeraccounts/?message=Error!. Action\'s minimum requirement not met&message_type=warning');
								
						}

	   		    }


	   /******End Customer Ledger Accounts*****/
}