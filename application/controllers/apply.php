<?php if(!defined('BASEPATH')) exit("Access Denied!!");

require_once 'site.php';

class Apply extends Site{

    protected $models = array(
			
			'customer' => 'customer_model',
			
			'loan' => 'loan_model',
			
			'product' => 'product_model',
			
			'sms' => 'sms_model'
			
	);
	
	
    public function index(){
	
			$message = null; //add new form error message

			$errors  = array(); // contains validation error for submitted customer properties

			if($this->input->post('registrationsubmit')){ //proceed only if the register submit button has been clicked
			        
					$customer				                = array();

					$customer['name']                       = $this->input->post('customer_surname');
					
					$customer['other_names']                = $this->input->post('customer_othernames');
					
					$customer['idnumber']                   = $this->input->post('customer_idnum');
					
					$customer['area']                       = $this->input->post('customer_area');
					
					$customer['pobox']			            = $this->input->post('customer_pobox');
					
					$customer['postalcode']			        = $this->input->post('customer_pcode');
					
					$customer['mobiletel']                  = $this->input->post('customer_phone');
					
					$customer['email']                      = $this->input->post('customer_email');
					
					$customer['status']          		    = $this->input->post('customer_status');
					
					$customer['employer_name']   		    = $this->input->post('customer_employername');
					
					$customer['officephysicallocation']     = $this->input->post('customer_officeplocation');
					
					$customer['officetel']                  = $this->input->post('customer_officetel');
					
					$customer['dateemployed']               = $this->input->post('customer_datee');
					
					$customer['currentposition']            = $this->input->post('customer_currentposition');
					
					$customer['nameofbusiness']             = $this->input->post('customer_nameofbusiness');
					
					$customer['physicalbusinessaddress']    = $this->input->post('customer_bussphysclocation');
					
					$customer['industry']                   = $this->input->post('customer_industry');
					
					$customer['member_id']                  = 'MOMBO-MMID-'.substr($customer['mobiletel'],3,7).'-'.random_string('numeric',4);
					
					$customer['profilepic']                 = 'avatar.png';
					
					
					$product = $this->product->findOne($this->input->post('customer_loan_purpose'));
					
					
					if($product){
					
					         $product_maximum = $product->maximum_amount_loaned;
							 
							 $product_minimum = $product->minimum_amount_loaned;
							 
							 $product_minim_d = $product->minimum_duration;
							 
							 $product_maxim_d = $product->maximum_duration;
							 
							 if(((double)$this->input->post('customer_loan_amount')) >= $product_minimum && ((double)$this->input->post('customer_loan_amount')) <= $product_maximum){
                                     
									 if(((int)$this->input->post('customer_loan_duration')) >= $product_minim_d && ((int)$this->input->post('customer_loan_duration')) <= $product_maxim_d){
									 
											 $customer['password']   = random_string('alnum', 12);
											 
											 $added  				 = $this->customer->create($customer);
											 
											 if($added){ //check if added successfully
													 
													 //loan details
													$cloan  									= array();
													
													$cloan['transaction_code']				= 'TRNS-'.date('Y-m',time()).strtoupper(random_string('alnum',4));
													
													$cloan['customer']                       = $this->customer->findBy(array('idnumber'=>$this->customer->idnumber))->row(0,'customer_model')->id;
													
													$cloan['loan_principle_amount']          = $this->input->post('customer_loan_amount');
													
													$cloan['loan_product']                   = $this->input->post('customer_loan_purpose');
													
													$cloan['loan_issue_date']                = null;
													
													$cloan['loan_due_date']                  = null;
													
													$cloan['loan_duration']                  = $this->input->post('customer_loan_duration');
													
													$cloan['loan_balance_amount']            = $loan['loan_principle_amount'];
													
													$cloan['transaction_fee']                = 0;
													
													$cloan['next_payment_date']              = null;
													
													$cloan['request_status']                 = 0;
													
													$cloan['loan_status']                    = 0;
													
													$cloan['pmt']                            = 0;
													
													//validate loan request
													$added = $this->loan->create($cloan);
						  
													if($added){
													
															$to         = $customer['email'];
														
															$mobile     = $customer['mobiletel'];
															
															$subject    = "Mombo Investement Ltd | Account Registration";
															
															$email      = get_registration_email_template();
															
															$email      = str_replace(array(
																		  '{base-url}',
																		  '{customer-name}',),array(
																		   base_url(),
																		   $customer['name'],
																		),$email);
															
															$sms        = get_registration_sms_template();
															
															$sms        = str_replace(array(
															
																		  '{base-url}',
																		  
																		  '{customer-name}',
																		  
																		  ),array(
																		    
																			base_url(),
																			
																		    $customer['name'],
																		),$sms);
															
															$this->email->from('customercare@mombo.co.ke','Mombo Investment Ltd');
															
															$this->email->to($to); 
															
															$this->email->cc('registration@mombo.co.ke'); 
															
															$this->email->subject($subject); 
															
															$this->email->send($email); 
															
															send_sms($mobile,$sms);
															
															$this->sms->create(array(
															
																   'date' => date('Y-m-d',time()),
																   
																   'to'=> $mobile,
																   
																   'message' => $sms,
																   
															  )
															);
													
															redirect(base_url().'apply/success/');
															
													}else{
															 //else if not added successfully:
															 $message = "An error occured while submitting loan application.<br/> We are working on correcting the error. Please try again later;";	
															 
															 $this->customer->delete();
														   
															 $this->loan->delete();											   
													}
											}else{
											
											       //else if not added successfully:
												   $message = "Registration unsuccessful!. Please review details entered for any errors.";
												   
												   $errors  = $this->customer->validationerrors(); //get all validation errors if any
												   
											}
										
									}else{
									
										  //else if not added successfully:
										   $message = "Sorry your loan duration doesn't fall into the expected duration range for the chosen loan product.(from $product_minim_d to $product_maxim_d  $product->loan_repayment_frequency";
											   
									}
							}else{
							
							     //else if not added successfully:
								 $message = "Sorry your loan amount doesn't fall into the expected range for the chosen loan product.(from Ksh.$product_minimum to Ksh.$product_maximum)";
							
							}
							
					}else{
					
							 //else if not added successfully:
							 $message = "Loan product chosen does not exists.";
						 
					}
					
					
			}
			  
			
				
			$this->page->title      = "Mombo Investment Ltd | Apply";
			
			$this->page->name       = 'contact';
			
			$this->msg['page']      = $this->page;

			$this->msg['message']   = $message;

			$this->msg['errors']    = $errors;
			
			$this->msg['products']  = $this->product->findAll();
			
			$this->msg['customer']  = $this->customer;
			
			$this->msg['loan']      = $this->loan;

			$this->sendPage('site/pages/apply',$this->msg);
	}
	
	public function success(){
	
			$this->page->title    = "Mombo Investment Ltd | Loan Application Success";
			
			$this->page->name     = 'contact';
			
			$this->msg['page']    = $this->page;

			$this->sendPage('site/pages/applysuccess',$this->msg);
			
	}
	
}