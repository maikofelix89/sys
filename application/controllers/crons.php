<?php if(!defined('BASEPATH')) exit();

class Crons extends CI_Controller{
 
        protected $models = array(
		
				'systemoption' => 'systemoption_model',
				
				'systemobject' => 'systemobject_model',
				
				'loan_charge' => 'charge_model',
				
				'loan' => 'loan_model',
				
				'customer' => 'customer_model',
				
				'customeraccount' => 'customeraccount_model',
				
				'account' => 'account_model',
				
				'product' => 'product_model',
				
				'expectedpayment' => 'expectedpayment_model',
				
				'payment' => 'payment_model',
				
				'charge_payment' => 'chargepayment_model',
				
				'transaction' => 'transaction_model',
				
				'sms' => 'sms_model'
		);

		public function index(){
		       
			      $this->updateCharges();
				
			      $this->updateAccountServiceCharges();

			      echo "Done updating...";
			    
		}
		
		private function updateCharges(){
		     		
				  $loans = $this->loan->findBy(array('loan_status'=>0,'request_status'=>2)); //get all loan items
				  
				  $current_time_stamp = time();
				  
				  foreach($loans->result('loan_model') as $loan){
				       
					      $expected_payments = $this->expectedpayment->findBy(array('loan'=>$loan->id,'paid'=>0));
						  
						  $customer_account  = $this->customeraccount->findBy(array('customer'=>$loan->customer->id))->row(0,'customeraccount_model');
						  
						  if(!$customer_account)continue;
						  
						  foreach($expected_payments->result('expectedpayment_model') as $payment){
								   
								  $expected_time_stamp = (date_create($payment->date_expected)->getTimestamp() + (24*60*60));
								  
								  if($expected_time_stamp < $current_time_stamp){
								  
										 $late_payment_fee = $loan->getLatePaymentFee();
										 
										 $interest_charge  = $loan->getInterestCharge();
										 
										 if($late_payment_fee > 0){
										 
										     $charge_frequency = strtolower($loan->loan_product->late_payment_fee_frequency);
											 
											 $days = 0;
											 
											 switch($charge_frequency){
											  
														case 'monthly':$days = 31;break;
														
														case 'annually':$days= 365;break;
														
														case 'weekly':$days=7;break;
														
														case 'per-two-months': $days = 63;break;
														
														case 'per-three-months':$days=93;break;
														
														case 'quartely':$days=124;break;
														
														case 'per-five-months':$days = 155;break;
														
														case 'twice-annually':$days=186;break;
														
														case 'per-seven-months':$days = 217;break;
														
														case 'per-eight-months':$days = 248;break;
														
														case 'per-nine-months':$days = 279;break;
														
														case 'per-ten-months':$days = 310;break;
														
														case 'per-elleven-months':$days = 341;break;
														
														default:break;
											 }
											 //echo "nnn"; exit;
											 $loan_charges    = $this->loan_charges->findBy(array('loan'=>$loan->id,'name'=>'latepayment_fee'),null,array('date_expected','desc'));
											 
											 $last_charge     = $loan_charges->row(0,'charge_model');
											 
											 $days_passed     = 0;
											 
											 if($last_charge){
												 
												 $last_time_stamp = date_create($last_charge->date)->getTimestamp();
												 
												 $tstamp_delta    = $current_time_stamp - $last_time_stamp;
												 
												 $days_passed     = floor((($tstamp_delta / 60)/60)/24);
												 
											}else{
											
											     $days_passed     = ((date_create($payment->date_expected)->getTimestamp()) - $current_time_stamp);
												 
												 $days_passed     = floor((($days_passed/60)/60)/24);
												 
											}
											 
											 if($days_passed > $days && $last_charge){

													 $charge = array(
													       
														    'transaction_code' => $loan->transaction_code,
															
															'name' => 'latepayment_fee',
															
															'loan' => $loan->id,
															
															'date' => date('Y-m-d',$current_time_stamp),
															
															'amount' => $late_payment_fee,
															
															'balance' => $late_payment_fee,
															
															'paid'=>0,
													 
													 );
													 
													 if($this->loan_charge->create($charge)){
													  
															//create new transaction
															
															$debit_transaction = array(
													
																	'object' => $this->sys_object->findBy(array('name'=>'charge'))->row(0,'systemobject_model')->id,

																	'transaction_code' => $loan->transaction_code,

																	'account' => $customer_account->id,

																	'transactiontype' => 1,

																	'description' => "Late Payment charge",

																	'date' => date('Y-m-d',$current_time_stamp),

																	'amounttransacted' => $late_payment_fee,

																	'user' => 0,
															);
															
															$customer_account->balance += $late_payment_fee;
															
															if($customer_account->update() && $this->transaction->create($debit_transaction)){
													 
																        $to         = $loan->customer->email;
																	
																		$mobile     = $loan->customer->mobiletel;
																		
																		$subject    = "Late payment fee for ".$loan->loan_product_name;
																		
																		$email      = get_charge_email_template();
																		
																		$email      = str_replace(array(
																		      '{base_url}',
																			  '{customer-name}',
																			  '{payment-amount}',
																			  '{charge-amount}'),array(
																			    $this->config->item('siteurl'),
																			   $loan->customer->name,
																			   'Late payment fee',
																			   $late_payment_fee
																			),$email);
																		
																		$sms        = get_charge_sms_template();
																		
																		$sms        = str_replace(array(
																			  '{customer-name}',
																			  '{charge-name}',
																			  '{charge-amount}'),array(
																			   $loan->customer->name,
																			   'Late payment fee',
																			   $late_payment_fee
																			),$sms);
																		
																		$this->email->from('info@mombo.co.ke','Mombo Investment Ltd');
																		
																		$this->email->to($to); 
																		
																		$this->email->subject($subject); 
																		
																		$this->email->send($email); 
																		
																		send_sms($mobile,$sms);
																		
																		$this->sms->create(array(
																		
																			   'date' => date('Y-m-d',time()),
																			   
																			   'too'=> $mobile,
																			   
																			   'message' => $sms,
																			   
																		  )
																		);
																		
																	
															}
													 
													 }
											}else{
											
												  if($days_passed >= 1 && $days_passed <= $days-1 && $last_charge){
												  
															$to         = $loan->customer->email;
														
															$mobile     = $loan->customer->mobiletel;
															
															$subject    = "Late payment fee for ".$loan->loan_product_name." reminder" ;
															
															$email      = get_paymentreminder_email_template();
															
															$email      = str_replace(array(
															  '{base_url}',
															  '{customer-name}',
															  '{loan-name}',
															  '{date-expected}',
															  '{payment-amount}'),array(
															   $this->config->item('siteurl'),
															   $loan->customer->name,
															   $loan->loan_product->loan_product_name,
															   $payment->date_expected,
															   $late_payment_fee,
															),$email);
															
															$sms        = get_paymentreminder_sms_template();
															
															$sms        = str_replace(array(
															  '{base_url}',
															  '{customer-name}',
															  '{loan-name}',
															  '{date-expected}',
															  '{payment-amount}'),array(
															   $this->config->item('siteurl'),
															   $loan->customer->name,
															   $loan->loan_product->loan_product_name,
															   $payment->date_expected,
															   $late_payment_fee,
															),$sms);
															
															
															$this->email->from('info@mombo.co.ke','Mombo Investment Ltd');
															$this->email->to($to); 
															$this->email->subject($subject); 
															$this->email->send($email); 
															send_sms($mobile,$sms);
															$this->sms->create(array(
															
																   'date' => date('Y-m-d',time()),
																   
																   'too'=> $mobile,
																   
																   'message' => $sms,
																   
															  )
															);
																		
													   
												  }
												  
												  if(!$last_charge && $days_passed >= 1 ){
												  
															$charge = array(
															   
																'transaction_code' => $loan->transaction_code,
																
																'name' => 'latepayment_fee',
																
																'loan' => $loan->id,
																
																'date' => date('Y-m-d',$current_time_stamp),
																
																'amount' => $late_payment_fee,
																
																'balance' => $late_payment_fee,
																
																'paid'=>0,
														 
														   );
														 
														 if($this->loan_charge->create($charge)){
														  
																//create new transaction
																
																$debit_transaction = array(
														
																		'object' => $this->sys_object->findBy(array('name'=>'charge'))->row(0,'systemobject_model')->id,

																		'transaction_code' => $loan->transaction_code,

																		'account' => $customer_account->id,

																		'transactiontype' => 1,

																		'description' => "Late Payment charge",

																		'date' => date('Y-m-d',$current_time_stamp),

																		'amounttransacted' => $late_payment_fee,

																		'user' => 0,
																);
																
																$customer_account->balance += $late_payment_fee;
																
																if($customer_account->update() && $this->transaction->create($debit_transaction)){
														 
																	    $to         = $loan->customer->email;
																	
																		$mobile     = $loan->customer->mobiletel;
																		
																		$subject    = "Late payment fee for ".$loan->loan_product_name;
																		
																		$email      = get_charge_email_template();
																		
																		$email      = str_replace(array(
																		      '{base_url}',
																			  '{customer-name}',
																			  '{charge-name}',
																			  '{charge-amount}'),array(
																			    $this->config->item('siteurl'),
																			   $loan->customer->name,
																			   'Late payment fee',
																			    $late_payment_fee
																			),$email);
																		
																		$sms        = get_charge_sms_template();
																		
																		$sms        = str_replace(array(
																			  '{customer-name}',
																			  '{charge-name}',
																			  '{charge-amount}'),array(
																			   $loan->customer->name,
																			   'Late payment fee',
																			    $late_payment_fee
																			),$sms);
																		
																		$this->email->from('info@mombo.co.ke','Mombo Investment Ltd');
																		$this->email->to($to); 
																		$this->email->subject($subject); 
																		$this->email->send($email); 
																		send_sms($mobile,$sms);
																		$this->sms->create(array(
																		
																			   'date' => date('Y-m-d',time()),
																			   
																			   'too'=> $mobile,
																			   
																			   'message' => $sms,
																			   
																		  )
																		);
																		
																}
														 }
												  
												  }
											  
											}
										
										
										}
										
										if($interest_charge > 0){
										
										     $charge_frequency = strtolower($loan->loan_product->interest_fee_frequency);
											 
											 $days = 0;
											 
											 switch($charge_frequency){
											  
														case 'monthly':$days = 31;break;
														
														case 'annually':$days= 365;break;
														
														case 'weekly':$days=7;break;
														
														case 'per-two-months': $days = 63;break;
														
														case 'per-three-months':$days=93;break;
														
														case 'quartely':$days=124;break;
														
														case 'per-five-months':$days = 155;break;
														
														case 'twice-annually':$days=186;break;
														
														case 'per-seven-months':$days = 217;break;
														
														case 'per-eight-months':$days = 248;break;
														
														case 'per-nine-months':$days = 279;break;
														
														case 'per-ten-months':$days = 310;break;
														
														case 'per-elleven-months':$days = 341;break;
														
														default:break;
											 }
											 
											 $loan_charges    = $this->loan_charges->findBy(array('loan'=>$loan->id,'name'=>'interest_fee'),null,array('date','desc'));
											 
											 $last_charge     = $loan_charges->row(0,'charge_model');
											 
											 $last_time_stamp = date_create($last_charge->date)->getTimestamp();
											 
											 $tstamp_delta    = $current_time_stamp - $last_time_stamp;
											 
											 $days_passed     = 0;
											 
											 if($last_charge){
												 
												 $last_time_stamp = date_create($last_charge->date)->getTimestamp();
												 
												 $tstamp_delta    = $current_time_stamp - $last_time_stamp;
												 
												 $days_passed     = floor((($tstamp_delta / 60)/60)/24);
											}else{
											
											     $days_passed     = ($current_time_stamp -(date_create($payment->date_expected)->getTimestamp()));
												 
												 $days_passed     = floor((($days_passed/60)/60)/24);
											}
											 
											 if($days_passed > $days && $last_charge){

													$charge = array(
													       
														    'transaction_code' => $loan->transaction_code,
															
															'name' => 'interest_charge',
															
															'loan' => $loan->id,
															
															'date' => date('Y-m-d',$current_time_stamp),
															
															'amount' => $interest_charge,
															
															'balance' => $interest_charge,
															
															'paid'=>0,
													 
													 );
													 
													 if($this->loan_charge->create($charge)){
													  
															//create new transaction
															
															$debit_transaction = array(
													
																	'object' => $this->sys_object->findBy(array('name'=>'charge'))->row(0,'systemobject_model')->id,

																	'transaction_code' => $loan->transaction_code,

																	'account' => $customer_account->id,

																	'transactiontype' => 1,

																	'description' => "Interest charge",

																	'date' => date('Y-m-d',$current_time_stamp),

																	'amounttransacted' => $interest_charge,

																	'user' => 0,
															);
															
															$customer_account->balance += $interest_charge;
															
															if($customer_account->update() && $this->transaction->create($debit_transaction)){
													 
																		$to         = $loan->customer->email;
																	
																		$mobile     = $loan->customer->mobiletel;
																		
																		$subject    = "Interest Charge for ".$loan->loan_product_name;
																		
																		$email      = get_charge_email_template();
																		
																		$email      = str_replace(array(
																		      '{base_url}',
																			  '{customer-name}',
																			  '{charge-name}',
																			  '{charge-amount}'),array(
																			   $this->config->item('siteurl'),
																			   $loan->customer->name,
																			   'Interest Charge',
																			   $interest_charge
																			),$email);
																		
																		$sms        = get_charge_sms_template();
																		
																		$sms        = str_replace(array(
																			  '{customer-name}',
																			  '{charge-name}',
																			  '{charge-amount}'),array(
																			   $loan->customer->name,
																			   'Interest Charge',
																			   $interest_charge
																			),$sms);
																		
																		$this->email->from('info@mombo.co.ke','Mombo Investment Ltd');
																		$this->email->to($to); 
																		$this->email->subject($subject); 
																		$this->email->send($email); 
																		send_sms($mobile,$sms);
																		$this->sms->create(array(
																		
																			   'date' => date('Y-m-d',time()),
																			   
																			   'too'=> $mobile,
																			   
																			   'message' => $sms,
																			   
																		  )
																		);
																	
															}
													 
													 }
											}else{
											
											      if($days_passed > 0 && $days_passed < $days){
												         
														$days_delta = $days - $days_passed;
												  
														if($days_delta == 1){
														
																$to         = $loan->customer->email;
															
																$mobile     = $loan->customer->mobiletel;
																
																$subject    = "Late payment fee for ".$loan->loan_product_name." reminder";
																
																$email      = get_paymentreminder_email_template();
																
																$email      = str_replace(array(
																	  '{base_url}',
																	  '{customer-name}',
																	  '{loan-name}',
																	  '{date-expected}',
																	  '{payment-amount}'),array(
																	   $this->config->item('siteurl'),
																	   $loan->customer->name,
																	   $loan->loan_product->loan_product_name,
																	   $payment->date_expected,
																	   $interest_charge,
																	),$email);
																
																$sms        = get_paymentreminder_sms_template();
																
																$sms        = str_replace(array(
																	  '{base_url}',
																	  '{customer-name}',
																	  '{loan-name}',
																	  '{date-expected}',
																	  '{payment-amount}'),array(
																	    $this->config->item('siteurl'),
																	   $loan->customer->name,
																	   $loan->loan_product->loan_product_name,
																	   $payment->date_expected,
																	   $interest_charge,
																	),$sms);
																
																$this->email->from('info@mombo.co.ke','Mombo Investment Ltd');
																$this->email->to($to); 
																$this->email->subject($subject); 
																$this->email->send($email); 
																send_sms($mobile,$sms);
																$this->sms->create(array(
																
																	   'date' => date('Y-m-d',time()),
																	   
																	   'too'=> $mobile,
																	   
																	   'message' => $sms,
																	   
																  )
																);
																
													    }elseif($days_delta == 4){
														     
															  
																$to         = $loan->customer->email;
															
																$mobile     = $loan->customer->mobiletel;
																
																$subject    = "Late payment fee for ".$loan->loan_product_name." reminder";
																
																$email      = get_paymentreminder_email_template();
																
																$email      = str_replace(array(
																	  '{base_url}',
																	  '{customer-name}',
																	  '{loan-name}',
																	  '{date-expected}',
																	  '{payment-amount}'),array(
																	   $this->config->item('siteurl'),
																	   $loan->customer->name,
																	   $loan->loan_product->loan_product_name,
																	   $payment->date_expected,
																	   $interest_charge,
																	),$email);
																
																$sms        = get_paymentreminder_sms_template();
																
																$sms        = str_replace(array(
																	  '{base_url}',
																	  '{customer-name}',
																	  '{loan-name}',
																	  '{date-expected}',
																	  '{payment-amount}'),array(
																	    $this->config->item('siteurl'),
																	   $loan->customer->name,
																	   $loan->loan_product->loan_product_name,
																	   $payment->date_expected,
																	   $interest_charge,
																	),$sms);
																
																$this->email->from('info@mombo.co.ke','Mombo Investment Ltd');
																$this->email->to($to); 
																$this->email->subject($subject); 
																$this->email->send($email); 
																send_sms($mobile,$sms);
																$this->sms->create(array(
																
																	   'date' => date('Y-m-d',time()),
																	   
																	   'too'=> $mobile,
																	   
																	   'message' => $sms,
																	   
																  )
																);
														
														}
													   
												  }
												  
												  
												  
												  if(!$last_charge && $days_passed >= 1 ){
												  
													$charge = array(
													   
														'transaction_code' => $loan->transaction_code,
														
														'name' => 'interest_charge',
														
														'loan' => $loan->id,
														
														'date' => date('Y-m-d',$current_time_stamp),
														
														'amount' => $interest_charge,
														
														'balance' => $interest_charge,
														
														'paid'=>0,
												 
													);
													 
													if($this->loan_charge->create($charge)){
													  
															//create new transaction
															
															$debit_transaction = array(
													
																	'object' => $this->sys_object->findBy(array('name'=>'charge'))->row(0,'systemobject_model')->id,

																	'transaction_code' => $loan->transaction_code,

																	'account' => $customer_account->id,

																	'transactiontype' => 1,

																	'description' => "Interest charge",

																	'date' => date('Y-m-d',$current_time_stamp),

																	'amounttransacted' => $interest_charge,

																	'user' => 0,
															);
															
															$customer_account->balance += $interest_charge;
															
															if($customer_account->update() && $this->transaction->create($debit_transaction)){
													 
																		$to         = $loan->customer->email;
																	
																		$mobile     = $loan->customer->mobiletel;
																		
																		$subject    = "Interest Charge for ".$loan->loan_product_name;
																		
																		$email      = get_charge_email_template();
																		
																		$email      = str_replace(array(
																		      '{base_url}',
																			  '{customer-name}',
																			  '{charge-name}',
																			  '{charge-amount}'),array(
																			   base_url(),
																			   $loan->customer->name,
																			   'Interest Charge',
																			   $interest_charge
																			),$email);
																		
																		$sms        = get_charge_sms_template();
																		
																		$sms        = str_replace(array(
																			  '{customer-name}',
																			  '{charge-name}',
																			  '{charge-amount}'),array(
																			   $loan->customer->name,
																			   'Interest Charge',
																			   $interest_charge
																			),$sms);
																		
																		$this->email->from('info@mombo.co.ke','Mombo Investment Ltd');
																		$this->email->to($to); 
																		$this->email->subject($subject); 
																		$this->email->send($email); 
																		send_sms($mobile,$sms);
																		$this->sms->create(array(
																		
																			   'date' => date('Y-m-d',time()),
																			   
																			   'too'=> $mobile,
																			   
																			   'message' => $sms,
																			   
																		  )
																		);
																	
															}
													 
													 }
												  
												  }
											
											
											}
										
										}
											
								  }
						  
						  }
						  
				  }
		}
		
		
		private function updateAccountServiceCharges(){
		
				  $loans = $this->loan->findBy(array('loan_status'=>0,'request_status'=>2)); //get all loan items
				  
				  $current_time_stamp = time();
				  
				  foreach($loans->result('loan_model') as $loan){
				      
                       $customer_account  = $this->customeraccount->findBy(array('customer'=>$loan->customer->id))->row(0,'customeraccount_model');
				      
					   $date_issued_timestamp = date_create($loan->loan_issue_date)->getTimestamp();
					   
					   $tstamp_delta = $current_time_stamp - $date_issued_timestamp;
					   
					   $days_passed  = ((($tstamp_delta/60)/60)/24);
					   
					   $service_charges = $this->loan_charge->findBy(array('loan'=>$loan->id,'name'=>'service_charge'),null,array('date','desc'));
					   
					   $last_charge = $service_charges->row(0,'charge_model');
					   
					   if($days_passed > 31 && !$last_charge){
					   
					          	$charge = array(
													   
										'transaction_code' => $loan->transaction_code,
										
										'name' => 'service_charge',
										
										'loan' => $loan->id,
										
										'date' => date('Y-m-d',$current_time_stamp),
										
										'amount' => $loan->getServiceFee(),
										
										'balance' => $loan->getServiceFee(),
										
										'paid'=>0,
								 
								);
								//create new transaction
															
								$debit_transaction = array(
						
										'object' => $this->sys_object->findBy(array('name'=>'charge'))->row(0,'systemobject_model')->id,

										'transaction_code' => $loan->transaction_code,

										'account' => $customer_account->id,

										'transactiontype' => 1,

										'description' => "Loan Account Service Charge",

										'date' => date('Y-m-d',$current_time_stamp),

										'amounttransacted' => $loan->getServiceFee(),

										'user' => 0,
								);
								
								$customer_account->balance += $loan->getServiceFee();
								
								if($customer_account->update() && $this->loan_charge->create($charge)){
								   
											$to         = $loan->customer->email;
										
											$mobile     = $loan->customer->mobiletel;
											
											$subject    = "Loan Account Service Charge for ".$loan->loan_product_name;
											
											$email      = get_charge_email_template();
											
											$email      = str_replace(array(
												  '{base_url}',
												  '{customer-name}',
												  '{charge-name}',
												  '{charge-amount}'),array(
												    $this->config->item('siteurl'),
												   $loan->customer->name,
												   'Loan Account Service Charge',
												   $loan->getServiceFee(),
												),$email);
											
											$sms        = get_charge_sms_template();
											
											$sms        = str_replace(array(
												  '{customer-name}',
												  '{charge-name}',
												  '{charge-amount}'),array(
												   $loan->customer->name,
												   'Loan Account Service Charge',
												   $loan->getServiceFee(),
												),$sms);
											
											$this->email->from('info@mombo.co.ke','Mombo Investment Ltd');
											$this->email->to($to); 
											$this->email->subject($subject); 
											$this->email->send($email); 
											send_sms($mobile,$sms);
											$this->sms->create(array(
											
												   'date' => date('Y-m-d',time()),
												   
												   'too'=> $mobile,
												   
												   'message' => $sms,
												   
											  )
											);
	   
								   }
					   
					   }else{
					   
					       if($last_charge ){
						       
							   $date_issued_timestamp = date_create($last_charge->date)->getTimestamp();
					   
							   $tstamp_delta = $current_time_stamp - $date_issued_timestamp;
							   
							   $days_passed  = ((($tstamp_delta/60)/60)/24);
							   
							   if($days_passed > 31){
							   
									 $charge = array(
														   
											'transaction_code' => $loan->transaction_code,
											
											'name' => 'service_charge',
											
											'loan' => $loan->id,
											
											'date' => date('Y-m-d',$current_time_stamp),
											
											'amount' => $loan->getServiceFee(),
											
											'balance' => $loan->getServiceFee(),
											
											'paid'=>0,
									 
									);
									//create new transaction
															
									$debit_transaction = array(
							
											'object' => $this->sys_object->findBy(array('name'=>'charge'))->row(0,'systemobject_model')->id,

											'transaction_code' => $loan->transaction_code,

											'account' => $customer_account->id,

											'transactiontype' => 1,

											'description' => "Loan Account Service Fee",

											'date' => date('Y-m-d',$current_time_stamp),

											'amounttransacted' => $loan->getServiceFee(),

											'user' => 0,
									);
									
									$customer_account->balance += $loan->getServiceFee();
									
									if($customer_account->update() && $this->loan_charge->create($charge)){
								   
											$to         = $loan->customer->email;
										
											$mobile     = $loan->customer->mobiletel;
											
											$subject    = "Loan Account Service Charge for ".$loan->loan_product_name;
											
											$email      = get_charge_email_template();
											
											$email      = str_replace(array(
												  '{base_url}',
												  '{customer-name}',
												  '{charge-name}',
												  '{charge-amount}'),array(
												    $this->config->item('siteurl'),
												   $loan->customer->name,
												   'Loan Account Service Charge',
												   $loan->getServiceFee(),
												),$email);
											
											$sms        = get_charge_sms_template();
											
											$sms        = str_replace(array(
												  '{customer-name}',
												  '{charge-name}',
												  '{charge-amount}'),array(
												   $loan->customer->name,
												   'Loan Account Service Charge',
												   $loan->getServiceFee(),
												),$sms);
											
											$this->email->from('info@mombo.co.ke','Mombo Investment Ltd');
											$this->email->to($to); 
											$this->email->subject($subject); 
											$this->email->send($email); 
											send_sms($mobile,$sms);
											$this->sms->create(array(
											
												   'date' => date('Y-m-d',time()),
												   
												   'too'=> $mobile,
												   
												   'message' => $sms,
												   
											  )
											);
								   
								   }
							   
							   }
						   
						   }
					   
					   }
				  
				 }
		
		}

}