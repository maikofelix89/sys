<?php if(!defined('BASEPATH')) exit('Access Denied!!');

class Customers extends CI_Controller{ 
      //register models to autoload for controller
      protected $models = array(
	  
			 'customer'=>'customer_model',
			 
			 'loan' => 'loan_model',
			 
			 'customer_account' => 'customeraccount_model',

			 'transaction' => 'transaction_model',
			 
			 'product' => 'product_model',
			 
			 'sms' => 'sms_model',

			 'comment' => 'comment_model',

			 'charge'=>'charge_model',

			 'post' => 'post_model',
		 
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
			  //collect url qstrings accepted by page
			  $message         = ($this->input->get('message')) ? $this->input->get('message') : '';
			  
			  $message_type    = ($this->input->get('message_type')) ? $this->input->get('message_type'): '';
			  
			  //holds customer records returned
			  $customers  = null;
			  
			  //flag for customer type to return based on their status column/field
			  //default to all
			  $customer_type    = null;
			  
			  //get user submitted customer type
			  if($customer_type = $this->input->get_post('type')){
			  
					  //get members that satisfy user customer type critiria
					  $status = 1; //customer status flag
					  
					  switch(strtolower($customer_type)):
					  
							   case 'inactive':$status = 2;break;
							   
							   case 'new'     :$status = 0;break;
							   
							   case 'active'  :$status = 1;
							   
							   default        :break;	
						   
					  endswitch;
					  
					  //get customers that have status chosen above
					  $customers = $this->customer->findBy(array(
					  
							'status'=>$status
							
					     ),array(
					   
					        (int)$this->input->get_post('per_page'),
							
							20,
					     )
					  );
				  
			  }else{
			  
					 $customer_type = 'all';
					 
					 $customers = $this->customer->findAll(array((int)$this->input->get_post('per_page'),20));
				 
			  }
			  
			  //populate response data
			  $this->page->title         = "Mombo Loan System | Customers";
			  
			  $this->page->name          = 'mombo-customers';
			  
			  $this->msg['page']         = $this->page;
			  
			  $this->msg['customer_type']= $customer_type;
			  
			  $this->msg['customers']    = $customers;
			  
			  $this->msg['message']      = $message;
			  
			  $this->msg['message_type'] = $message_type;
			  
			  $this->sendResponse($this->msg,array(
			  
					$this->header=>$this->msg,
					
					'mombo/templates/customers'=>$this->msg,
					
					$this->footer=>$this->msg,
				
			  ));
	  }
	  
	  
	  
	  public function findcustomers(){
	  
	         $criteria = $this->input->get_post('criteria');
			 
			 $query    = $this->input->get_post('query');
			 
			 $customers = null;
			 
			 if($criteria && in_array($criteria,array('active','inactive','new'))){
			            
						$status = 0;
						
						switch($criteria){
						
						      case 'active': $status = 1;break;
							  
							  case 'inactive':$status = 2;break;
							  
							  case 'new':$status = 0;break;
						
						}
						
						$customers = $this->customer->findBy(array(
							 'status' => $status,
						));
						
			 }else{
			 
			         $customers = $this->customer->findBy(array(
					 
							'status' => 1
							
					 ));
			 
			 }
			 
			 $this->msg['customers'] = $customers;
			 
			 $this->sendResponse($this->msg);
	  
	  }
	  
	  //performs various actions on customer status to reduce coupling
	  public function dostatusaction(){
	  
			 $customer_id = (int)$this->input->get_post('customer_id'); //get customer id
			 
			 $action      = $this->input->get_post('action'); //get action to perform
			 
			 $customer    = $this->customer->findOne($customer_id); //find the customer the action has been called on
			 
			 $message     = null; //confirm dialog message set to null
			 
			 if(null != $customer && in_array($action,array('activate','accept','reject','deactivate'))){ //check if customer record was found and action supported
			 
				   $yes_url        = base_url().'customers/dostatusaction/?customer_id='.$customer_id.'&'; //url for action confirmed
				   
				   $on_success_url = base_url().'customers/?type='; //url for action success
				   
				   $no_url         = base_url().'customers/?type='; //url for action cancel
				   
				   $status         = null; //status to change customer registration status 
				   
				   //set message and above items based on action being performed
				   switch(strtolower($action)){
				   
							case 'activate': //set variables for customer activate action

								 $status      = 1;
								 
								 $message     = "Do you really want to activate this customer account";
								 
								 $yes_url    .= 'action=activate&confirmed=true&';
								 
								 $no_url     .= 'active';
								 
								 $on_success_url .= 'active&message=Customer account activated successfully!';
								 
							break;
							
							case 'accept': //set variables for customer registration accept action
							
								 $status      = 1;
								 
								 $message     = "Do you really want to add this customer";
								 
								 $yes_url    .= 'action=accept&confirmed=true&';
								 
								 $no_url     .= 'new';
								 
								 $on_success_url .= 'new&message=Customer account request accepted!';
								 
							break;
							
							case 'reject': //set variables for customer registration reject action
							
								 $status      = 0;
								 
								 $message     = "Do you really want to continue";
								 
								 $yes_url    .= 'action=reject&confirmed=true&';
								 
								 $no_url     .= 'new';
								 
								 $on_success_url .= 'new&message=Customer account request rejected!';
								 
							break;
							
							case 'deactivate': //set variables for customer deactivate action
							
								 $status      = 2;
								 
								 $message     = "Do you really want to deactivate this customer account";
								 
								 $yes_url    .= 'action=deactivate&confirmed=true&';
								 
								 $no_url     .= 'inactive';
								 
								 $on_success_url .= 'inactive&message=Customer account deactivated successfully!';
								 
							break;
						
				   } 
				   if($this->input->get_post('confirmed')){ //proceed only if action has been confirmed
				   
				   
							$customer->status = $status; //set new customer status

							if($customer->update()){ //update customer record

									  //if action is registration acceptance, send SMS to new customer
									if($action == 'accept'){
									      
										 //activate customer's loan request
									     $loan_request = $this->loan->findBy(array('customer'=>$customer->id))->row(0,'loan_model');
										 
										 if(null != $loan_request){
										 
											 $loan_request->request_status = 1;
											 
											 $loan_request->update();
											 
											 if(null == $this->customer_account->findBy(array('customer'=>$customer->id))->row(0,'customeraccount_model')){
												 $customer_account  = array();
												 
												 $customer_account['customer'] = $customer->id;
												 
												 $customer_account['balance']  = 0;
												 
												 $this->customer_account->create($customer_account);
											}
										 }
										 
										    $to         = $customer->email;
														
											$mobile     = $customer->mobiletel;
											
											$subject    = "Mombo Investement Ltd | Account Activated";
											
											$email      = get_accountactivation_email_template();
											
											$email      = str_replace(array(
														  '{base-url}',
														  '{customer-name}',
														  '{password}',
														  '{date}'),array(
														    $this->config->item('siteurl'),
														   $customer->name,
														   $customer->password,
														   date('Y-m-d',time())
														),$email);
											
											$sms        = get_accountactivation_sms_template();
											
											
											
											$sms        = str_replace(array(
														  '{base-url}',
														  '{customer-name}',
														  '{password}',
														  '{date}'),array(
														   $this->config->item('siteurl'),
														   $customer->name,
														   $customer->password,
														   date('Y-m-d',time())
														),$sms);
										    //var_dump($sms);
											
											$this->email->from('customercare@mombo.co.ke','Mombo Investment Ltd');
											
											$this->email->to($to); 
											
											$this->email->cc('registration@mombo.co.ke'); 
											
											$this->email->subject($subject);

                                            $this->email->message($email);											
											
											$this->email->send(); 
											
											send_sms($mobile,$sms);
											
											$this->sms->create(array(
											
												   'date' => date('Y-m-d',time()),
												   
												   'too'=> $customer->mobiletel,
												   
												   'message' => $sms,
												   
											  )
											);
													
									}

									redirect($on_success_url.'&message_type=success');//redirect to customers page

							}else{

									//if customer update fialed. redirect to customers list page with appropriate message
									redirect(base_url().'customers/?message=Error performing action!&message_type=error');

							}
				   }else{
				   
							//if action has not been confirmed then populate template data for confirm page
							//and send page to user for confirmation
							$this->page->title         = "Mombo Loan System | Confirm Action";

							$this->page->name          = 'mombo-accept-customer';

							$this->msg['page']         = $this->page;

							$this->msg['message']      = $message;

							$this->msg['yes_url']      = $yes_url;

							$this->msg['no_url']       = $no_url;

							$this->sendResponse($this->msg,array(
							
									$this->header=>$this->msg,
									
									'mombo/templates/confirm'=>$this->msg,
									
									$this->footer=>$this->msg,
								
							));
					  
				   }
				   
			 }else{
			 
				//if customer record doesn't exists,return all customers list
				$this->index();
				
			}
		
	  } 

	  
	  public function viewcustomerdetails(){
	         
			$customer_id   = (int) $this->input->get_post('customer_id'); //get customer id
			
			$customer      = $this->customer->findOne($customer_id); //get customer with submitted id
			
			$message       = $this->input->get_post('message');
			
			$message_type  = $this->input->get_post('message_type');
			
			//populate template data
			$this->page->title         = "Mombo Loan System | Customer Details";
			
			$this->page->name          = 'mombo-customer-details';
			
			$this->msg['page']         = $this->page;
			
			$this->msg['customer']     = $customer;
			
			$this->msg['message']      = $message;
			
			$this->msg['message_type'] = $message_type;

			$this->msg['customeraccount'] = $this->customer_account->findBy(array(

					'customer' => $customer->id,

		    ))->row(0,'customeraccount_model');
			
			$this->msg['loans']        = $this->loan->findBy(array(
			
					'customer' => (($customer) ? $customer->id : 0 ),
			));


			$this->msg['transactions'] = $this->transaction->findBy(array(

					'account' => $this->msg['customeraccount']->id,
			));
			
		    $this->sendResponse($this->msg,array(
			
					$this->header => $this->msg,
					
					'mombo/templates/customerdetails' => $this->msg,
					
					$this->footer => $this->msg,
			    )
			);
	  }
	  
	  
	  
	  public function addnewcustomer(){
	  
			$message = null; //add new form error message

			$errors  = array(); // contains validation error for submitted customer properties

			if($this->input->post('add_customer')){ //proceed only if the register submit button has been clicked

					$customer = $this->input->post('customer'); //get the submitted customer assoc array of form field
					
					$customer['status']    = 0;
					
					$customer['password']  = random_string('alnum',6,12);
					
					$customer['member_id']     = 'MOMBO-MMID-'.substr($customer['mobiletel'],3,7).'-'.random_string('numeric',4);
					
					$added  = $this->customer->create($customer);
					
					if($added){ //check if added successfully
					
							//if customer added successfully redirect to customers list page, with appropriate message
							redirect(base_url().'customers/?message=Member added successfully&message_type=success');
						
					}else{
					
						   //else if not added successfully:
						   $message = 'Error adding member!'; //provide an error message
						   
						   $errors  = $this->customer->validationerrors(); //get all validation errors if any
					   
					}
					
			}
             
			//populate template data
			$this->page->title    = "Mombo Loan System | Add New Customer";

			$this->page->name     = 'mombo-addnew-customer';

			$this->msg['page']    = $this->page;

			$this->msg['message'] = $message;

			$this->msg['errors']  = $errors;

			$this->sendResponse($this->msg,array(
			
				 $this->header =>$this->msg,
				 
				 'mombo/templates/addnewcustomer' => $this->msg,
				 
				 $this->footer => $this->msg,
				 
			));
	  }
	  
	  
	  public function updatecustomer(){
	  
			$message = null; //add new form error message

			$errors  = array(); // contains validation error for submitted customer properties

			if($this->input->post('update_customer')){ //proceed only if the register submit button has been clicked

					$customer = $this->input->post('customer'); //get the submitted customer assoc array of form fields
					
					$added    = $this->customer->doupdate($customer);
					
					if($added){ //check if added successfully
					
							//if customer added successfully redirect to customers list page, with appropriate message
							redirect(base_url().'customers/?message=Member updated successfully&message_type=success');
						
					}else{
					
						   //else if not added successfully:
						   $message = 'Error updating member!'; //provide an error message
						   
						   $errors  = $this->customer->validationerrors(); //get all validation errors if any
					   
					}
					
			}
             
			//populate template data
			$this->page->title    = "Mombo Loan System | Add New Customer";

			$this->page->name     = 'mombo-addnew-customer';

			$this->msg['page']    = $this->page;

			$this->msg['message'] = $message;

			$this->msg['errors']  = $errors;

			$this->sendResponse($this->msg,array(
			
				 $this->header =>$this->msg,
				 
				 'mombo/templates/editcustomerdetails' => $this->msg,
				 
				 $this->footer => $this->msg,
				 
			));
	  
	  }
	  
	  
	  public function deletecustomer(){
	  
	  }
	  
	  public function bulkaction(){
	  
	  }
	  
	  public function uploadpic(){
	  
				$customer_id = (int) $this->input->post('customer_id');
				
				$customer    = $this->customer->findOne($customer_id);
				
				$message     = null;
				
				if($customer && $this->input->post('upload_pic')){
				
				
						if($_FILES['customer_pic'] && $_FILES['customer_pic']['name']){
																
									$customer_pic_uploaded 	    = $this->upload->do_upload('customer_pic');
									
									if($customer_pic_uploaded){
									
											$upload = $this->upload->data();
											
											$customer->profilepic = $upload['file_name'];
											
											$customer->update();
						
											redirect(base_url().'customers/viewcustomerdetails/?message=Profile picture uploaded successfully&message_type=success&customer_id='.$customer->id);
														
									}else{
											
											$message = "<p>Error uploading gaurantor's picture.</p>".$this->upload->display_errors();;
											
											redirect(base_url().'customers/viewcustomerdetails/?message='.$message.'&customer_id='.$customer->id);
									
									}
									
						}
						
						
						
				}
				
				redirect(base_url().'customers/viewcustomerdetails/?message=Photo not uploaded&messsage_type=warning&customer_id='.$customer_id);
	  
	  }
	  
	  public function exportimport(){
	        
			//get user action
			$action = $this->input->get_post('action');
			
			if($action && in_array($action,array('import','export'))){
					
					
			}
			
			//populate template data
			$this->page->title = "Mombo Loan System | Customer Records Export & Import";
			
			$this->page->name  = 'mombo-export-import';
			
			$this->msg['page'] = $this->page;
			
			$this->sendResponse($this->msg,array(
			   
					$this->header=>$this->msg,
					
					'mombo/templates/exportimport'=>$this->msg,
					
					$this->footer=>$this->msg,
					
			    )
			);
			
	  }
	  
	  
	  public function apply(){
	  
	       $message = null;
		   
		   $errors  = array();
		   
		   $code    = 0;
	     
		   if($this->input->get_post('apply')){
		   
		        $customer = array();
				
				$customer['name']          = $this->input->get_post('cusname');
				
				$customer['other_names']   = $this->input->get_post('cusothernames');
				
				$customer['email']         = $this->input->get_post('cusemail');
				
				$customer['idnumber']      = $this->input->get_post('cusidnumber');
				
				$customer['mobiletel']     = $this->input->get_post('cusmobile');
				
			    $customer['password']      = random_string('alnum',6,12);
				
				$customer['status']        = 0;
				
				$customer['member_id']     = 'MOMBO-MMID-'.substr($customer['mobiletel'],3,7).'-'.random_string('numeric',4);
				
				$customer['profilepic']    = 'avator.png';
				
				if($this->customer->create($customer)){
					 
					    $customer = $this->customer->findBy(array(
						
								'email' => $customer['email'],
							 
						))->row(0,'customer_model');
						
						$loan_amount   = (int) $this->input->get_post('loan_amount');
						
						$loan_product  = (int) $this->input->get_post('loan_product');
						
						$loan_duration = (int) $this->input->get_post('loan_duration');
						
						$product = $this->product->findOne($loan_product);
						
						if(null != $product){
						
						       if($loan_amount <= $product->maximum_amount_loaned && $loan_amount >= $product->minimum_amount_loaned){
				
										if($loan_duration <= $product->maximum_duration && $loan_duration >= $product->minimum_duration){
												
												$loan = array();
												
												$loan['loan_product']            =  $loan_product;
												
												$loan['transaction_code']        = 'TRNS-'.date('Y-m',$time_stamp).strtoupper(random_string('alnum',4));
												
												$loan['loan_principle_amount']  = $loan_amount;
												
												$loan['loan_duration']           = $loan_duration;
												
												$loan['customer']                = $customer->id;
												
												$loan['loan_balance_amount']     = 0;
												
												$loan['transaction_fee']         = 0;

												$loan['loan_issue_date']         = null;
																					
												$loan['loan_due_date']           = null;
												
												$loan['next_payment_date']       = null;
												
												$loan['request_status']          = 0;
												
												$loan['loan_status']             = 0;
												
												$loan['pmt']                     = 0;

												$added = $this->loan->create($loan);
												
												if($added){
												
														$message    = "Your application has been received successfully";
														
														$errors     = null;
														
														$code      += 200;
														
														$to         = $customer->email;
														
														$subject    = "Mombo Investement Ltd | Account Activated";
														
														$email      = get_registration_email_template();
														
														$email      = str_replace(array(
																	  '{base-url}',
																	  '{customer-name}',
																	  '{password}',
																	  '{date}'),array(
																	    $this->config->item('siteurl'),
																	   $customer->name,
																	   date('Y-m-d',time())
																	),$email);
														
														
														$this->email->from('customercare@mombo.co.ke','Mombo Investment Ltd');
														
														$this->email->to('requests@mombo.co.ke'); 
														
														$this->email->subject($subject);

														$this->email->message($email);											
														
														$this->email->send(); 
												
												}else{
												
													$message = "Error sending loan application";

													$code    = 503;
													
													$customer->delete($customer->id);
												
												}
										}else{
										
												 $message = "Your loan duration does not fall in the accepted range for the selected loan product. Between $product->maximum_duration and $product->minimum_duration $product->repayment_frequency_single"."s";
										      
										         $errors['loan_amount'] = 'invalid loan duration';
												 
												 $code   = 503;
												 
												 $customer->delete($customer->id);
										
										}
								 }else{  

								 	     $message = "Your loan amount does not fall in the accepted range for the selected loan product. Between Ksh. $product->maximum_amount_loaned and Ksh. $product->minimum_amount_loaned";
											
										 $errors['loan_amount'] = 'invalid loan amount';
										 
										 $code   = 503;
										 
										 $customer->delete($customer->id);
								 
								 }
						}else{
						    
							 $message = "Loan product chosen does not exists";
							 
							 $errors['loan_product'] = 'invalid value selected';
							 
							 $code   = 503;
							 
							 $customer->delete($customer->id);
						
						}
					
				
				}else{
				
				        $errors  = $this->customer->validationerrors();
					    
					    $message = "Please review your inputs and make changes as required";
						
						$code    = 503;
				
				}
		   }
		   
		   $this->msg['errors']  = $errors;
		   
		   $this->msg['message'] = $message;
		   
		   $this->msg['code']    = $code;
		   
		   $this->sendResponse($this->msg);
	  
	  }
	  
	  
	  public function customerapply(){
	  
			if($this->input->get_post('apply')){

				$customer_id   = (int) $this->input->get_post('userid');
		   
		        $customer = $this->customer->findOne($customer_id);
				
				if($customer){
				
						$loan_amount   = $this->input->get_post('loan_amount');
						
						$loan_product  = (int) $this->input->get_post('loan_product');
						
						$loan_duration = $this->input->get_post('loan_duration');
						
						$product = $this->product->findOne($loan_product);
						
						if(null != $product){
						
						       if($loan_amount <= $product->maximum_amount_loaned && $loan_amount >= $product->minimum_amount_loaned){
				
										if($loan_duration <= $product->maximum_duration && $loan_duration >= $product->minimum_duration){
												
												$loan = array();
												
												$loan['loan_product']       =  $loan_product;
												
												$loan['transaction_code']   = 'TRNS-'.date('Y-m',time()).strtoupper(random_string('alnum',4));
												
												$loan['loan_principle_amount'] = $loan_amount;
												
												$loan['loan_duration'] = $loan_duration;
												
												$loan['customer']   = $customer->id;

												$loan['loan_balance_amount']     = 0;
												
												$loan['transaction_fee']         = 0;

												$loan['loan_issue_date']         = null;
																					
												$loan['loan_due_date']           = null;
												
												$loan['next_payment_date']       = null;
												
												$loan['request_status']          = 1;
												
												$loan['loan_status']             = 0;
												
												$loan['pmt']                     = 0;
												
												if($this->loan->create($loan)){
												
														$message = "Your application has been received successfully";
														
														$errors  = null;
														
														$code    = 200;
												
												}else{
												
													$message = "Error sending loan application";
												
												}
										}else{
										
												  $message = "Your loan duration does not fall in the accepted range for the selected loan product. Between $product->maximum_duration and $product->minimum_duration $product->repayment_frequency_single"."s";

												  $errors['loan_duration'] = 'invalid loan duration';
												 
												  $code   = 503;
										
										}
								 }else{
								 
										 $message = "Your loan amount does not fall in the accepted range for the selected loan product. Between Ksh. $product->maximum_amount_loaned and Ksh. $product->minimum_amount_loaned";
												 
										 $errors['loan_amount'] = 'invalid loan amount';
										 
										 $code   = 503;
								 
								 }
						}else{
						    
							 $message = "Loan product chosen does not exists";
							 
							 $errors['loan_product'] = 'invalid value selected';
							 
							 $code   = 503;
						
						}
					
				
				}else{
				
				        $message = "Session Expired. Login again to apply";
						
						$code    = 503;
				
				}
		   }
		   
		   $this->msg['errors']  = $errors;
		   
		   $this->msg['message'] = $message;
		   
		   $this->msg['code']    = $code;
		   
		   $this->sendResponse($this->msg);
	  
	  
	  }
	  
	  
	  public function login(){
	  
	  
	       if($this->input->get_post('login')){

	       			$email = $this->input->get_post('email');

	       			$password    = $this->input->get_post('password');

	       			$result = $this->customer->findBy(array(
                       
                           'email'=>$email,

                           'password' => $password,
                       
	       			))->row(0,'customer_model');


	       			if($result){


	       				 $this->msg['message']  = "Login successfull!";

	       				 $this->msg['code']     = 200;
 
	       				 $this->msg['customer'] = $result;


	       			}else{

	       				  $this->msg['message'] = "Login error!. Wrong password or email";

	       				  $this->msg['code'] = 503;
	       			}

	       }

	       $this->sendResponse($this->msg);
	  
	  }
	  
	  public function getloans(){

	  	    $userid    = (int) $this->input->get_post('userid');

	  	    $customer  = $this->customer->findOne($userid);

	  	    $loans     = array();

	  	    $charges   = array();

	  	    if($customer){

	  	    		$rloans = $this->loan->findBy(array('customer'=>$customer->id,'request_status'=>2)); 

	  	    		foreach ($rloans->result('loan_model') as $loan) {
	  	    			  
	  	    			    $loans[$loan->id]   = $loan;

	  	    			    $rcharges = $this->charge->findBy(array('loan'=>$loan->id));

	  	    			    $temparr  = array();

	  	    			    foreach($rcharges->result('charge_model') as $charge){

	  	    			    	 $temparr[$charge->id] = $charge;

	  	    			    }

	  	    			    $charges[$loan->id] = $temparr;

	  	    		}

	  	    		$this->msg['code']    = 200;

	  	    		$this->msg['loans']   = $loans;

	  	    		$this->msg['charges'] = $charges;

	  	    		$this->msg['message'] = "Loans retrieved successfully";


	  	    }else{

                    $this->msg['code']    = 503;

 	  	    	    $this->msg['message'] = "Login to access your statements";

	  	    }

	  	    $this->sendResponse($this->msg);

	  }

	  private function isguest(){

	  		$userid   = (int) $this->input->get_post('userid');

	  		$customer = $this->customer->findOne($userid);

	  		if($customer){

	  			return false;

	  		}

	  		return true;

	  }
     

	  public function getpersonalstatement(){


  			if(!$this->isguest()){

  				 $loanid  = (int) $this->input->get_post('loanid');

  				 $loan    = $this->loan->findOne($loanid);

  				 if(null != $loan){
                       
                        $customeraccount = $this->customer_account->findBy(array(
                        	
                        	'customer'=>$loan->customer->id

                        ))->row(0,'customeraccount_model');

  				 		$transactions    = $this->transaction->findBy(array(

  				 				 'account' => $customeraccount->id,

  				 				 'transaction_code' => $loan->transaction_code
  				 		));

                        $rcharges = $this->charge->findBy(array('loan'=>$loan->id));

                        $m_transactions = array();

  				        $charges = array();

  				 		foreach ($transactions->result('transaction_model') as $transaction) {
  				 			  
  				 			   $m_transactions[$transaction->id] = $transaction;
  				 		}

                        foreach ($rcharges->result('charge_model') as $charge) {

                        	   $charges[$charge->id] = $charge;

                        }

  				 		$this->msg['transactions']    = $m_transactions;

  				 		$this->msg['customeraccount'] = $customeraccount;

  				 		$this->msg['charges']         = $charges;

  				 		$this->msg['code']            = 200;

  				 		$this->msg['message']         = "Statements processed successfully";

  				 }else{

  				 	    $this->msg['code']     = 404;

  				        $this->msg['message']  = "Loan record does not exist";

  				 }

  			}else{

  				 $this->msg['code']     = 503;

  				 $this->msg['message']  = "You must be logged in to access your statements";

  			}

  			$this->sendResponse($this->msg);

	  
	  }



	  public function getnewposts(){
          
            $posts    = $this->post->findAll(array(0,200));
 
            $userid   = $this->input->get_post('userid');

            $newposts = array();

            $customer = $this->customer->findOne($userid);

            if($customer){

            	foreach ($posts->result('post_model') as $post) {

            	   $exclude = json_decode($post->exclude);

            	   if(!in_array($userid,$exclude)) $newposts[$post->id] = $post;

                }
                 
                 $this->msg['code']    = 200;

                 $this->msg['posts']   = json_encode($newposts);

                 $this->msg['message'] = "Posts returned successfully";

            }else{

                 $this->msg['code']    = 503;

                 $this->msg['message'] = 'Session expired. Please login again to continue';

            }

            $this->sendResponse($this->msg);

	  }

	  public function getnewcomments(){

	  		$comments    = $this->comment->findAll(array(0,200));
 
            $userid      = $this->input->get_post('userid');

            $newcomments = array();

            $customer    = $this->customer->findOne($userid);

            if($customer){

            	 foreach ($comments->result('comments_model') as $comment) {

            	   $exclude = json_decode($comment->exclude);

            	   if(!in_array($userid,$exclude)) $newcomments[$comment->id] = $comment;

                 }
                 
                 $this->msg['code']     = 200;

                 $this->msg['comments'] = json_encode($newcomments);

                 $this->msg['message']  = "Posts returned successfully";

            }else{

                 $this->msg['code']     = 503;

                 $this->msg['message']  = 'Session expired. Please login again to continue';

            }

            $this->sendResponse($this->msg);

	  }
	  
	  
	  public function makewallpost(){

	  		$userid   = (int)$this->input->get_post('userid');

	  		$postText = $this->input->get_post('postText');

	  		$customer = $this->customer->findOne($userid);

	  		if($customer){

	  				if($postText && !empty($postText) && null != $postText && $postText != ''){

	  					  $post = array(

	  					  		'user'=>$customer->id,

	  					  		'post' => $postText,

	  					  		'time' => date('Y-m-d:h-m-s',time()),

	  					  		'exclude' => json_encode(array($customer->id))

	  					  );

	  					  $created = $this->post->create($post);

	  					  if($created){

	  					  	   $this->msg['code'] = 200;

	  					  	   $this->msg['post'] = json_encode(array(
                                        
                                     'userName' => $customer->name,

                                     'userPic' => $customer->profilepic,

                                     'time' => $post['time'],

                                     'postText' => $postText,

                                     'comments' => 0,

                                     'likes' => 0,

	  					  	   	));

	  					  	   $this->msg['message'] = "Posts  made successfully";

	  					  }else{

	  					  	   $this->msg['code'] = 404;

	  					  	   $this->msg['message'] = "Network error when making post, please try again";

	  					  }

	  				}else{

	  					  $this->msg['code'] = 503;

	  					  $this->msg['message'] = "Post cannot be empty";

	  				}
	  		}else{


	  			 $this->code = 503;

	  			 $this->msg['message'] = "You must be logged in to make posts";

	  			 $this->msg['code'] = $this->code;

	  		}

	  		$this->sendResponse($this->msg);

	  }

	  public function commentonpost(){

	  	    $userid = (int) $this->input->post('userid');

	  	    $postid = (int) $this->input->post('postid');

	  	    $commentText = $this->input->post('comment');

	  	    $customer = $this->customer->findOne($userid);

	  	    if($customer){

	  	    		$post = $this->post->findOne($postid);

	  	    		if($post){

	  	    				if($commentText && !empty($commentText) && null != $commentText && $commentText != ''){

	  	    						 $comment = array(

	  	    						 		'user'=>$customer->id,

	  	    						 		'post'=> $post->id,

	  	    						 		'comment'=> $commentText,

	  	    						 		'time'=>date('Y-m-d:H-m-s',time()),

	  					  		            'exclude' => json_encode(array($customer->id))

	  	    						 );

	  	    						 $created = $this->comment->create($comment);

	  	    						 if($created){

	  	    						 			$this->msg['code'] = 200;

	  	    						 			$this->msg['comment'] = json_encode(array(

	  	    						 					'commentText' => $commentText,

	  	    						 					'userName' => $customer->name,

	  	    						 					'time'=> $comment['time'],

                                                        'likes' => 0
	  	    						 			));

	  	    						 }else{

	  	    						 		$this->msg['code'] = 404;

	  	    						        $this->msg['message'] = "Network error when posting comment. Please try again";

	  	    						 }


	  	    				}else{

	  	    						$this->msg['code'] = 503;

	  	    						$this->msg['message'] = "Comment cannot be empty";

	  	    				}

	  	    		}else{

	  	    			 $this->msg['code'] = 503;

	  	    			 $this->msg['message'] = "You must be logged in to comment";
	  	    		}


	  	    }else{

	  	    		$this->msg['code'] = 503;

	  	    		$this->msg['message'] = "Please login to comment";

	  	    }

	  	    $this->sendResponse($this->msg);


	  }

	  
	  public function replytopost(){
	  
	  }
	  
	  
	  public function getloyaltypoints(){
	  
	  }
	  
	  public function forgotpassword(){
          
           $email = $this->input->post('email');
 
	  	   $customer  = $this->customer->findBy(array(

	  	   	    'email' => $email

	  	   	))->row(0,'customer_model');

	  	   if($customer){
                   
                    $email_address = $customer->email;

                    $email = "Dear ".ucwords($customer->name).", your password is ".$customer->password.". Please always keep your password safe.";

                    $this->email->from('customercare@mombo.co.ke','Mombo Investment Ltd');

					$this->email->cc('requests@mombo.co.ke');
					
					$this->email->to($email_address); 
					
					$this->email->subject("Password Request");

					$this->email->message($email);											
					
					$this->email->send(); 

					$this->msg['code'] = 200;

					$this->msg['message'] = "Success. Password has been sent to your email";


	  	   }else{

	  	   	    $this->msg['code'] = 503;

	  	   	    $this->msg['message'] = "No account exists, with the submitted email, please try again.";
	  	   }

	  	   $this->sendResponse($this->msg);
	  
	  }
	  
	  public function changepassword(){

	  	   if(!$this->isguest() && $this->input->get_post('change')){

	  	   	    $oldpass   = $this->input->get_post('oldpass');

	  	   	    $newpass   = $this->input->get_post('newpass');

	  	   	    $cnewpass  = $this->input->get_post('cnewpass');

	  	   	    $userid    = (int) $this->input->get_post('userid');

	  	   	    if(!empty($oldpass) && !empty($newpass) && !empty($cnewpass) && isset($oldpass,$newpass,$cnewpass) && $oldpass != '' && $newpass != '' && $cnewpass != ''){

		  	   	    	if($oldpass != $newpass){

		  	   	    		if($newpass == $cnewpass){

		  	   	    			     $customer = $this->customer->findOne($userid);

		  	   	    			     if($customer){

		  	   	    			     	     $customer->password = $newpass;

		  	   	    			     	     $updated = $customer->update();

		  	   	    			     	     if($updated){

		  	   	    			     	     	   $this->msg['code'] = 200;

		  	   	    			     	     	   $this->msg['message'] = "Password changed successfully";


		  	   	    			     	     }else{

		  	   	    			     	     	   $this->msg['code'] = 404;

		  	   	    			     	     	   $this->msg['message'] = "Error while updating password please try again";

		  	   	    			     	     }

		  	   	    			     }else{

		  	   	    			     	$this->msg['code'] = 503;

		  	   	                        $this->msg['message'] = "User account does not exits. Please contact the administrator";

		  	   	    			     }


		  	   	    		}else{

		  	   	    			$this->msg['code'] = 503;

		  	   	                $this->msg['message'] = "New password and confirmation mismatch";

		  	   	    		}

			  	   	    }else{

			  	   	    		$this->msg['code'] = 503;

			  	   	            $this->msg['message'] = "Old password cannot be the same as new password";
			  	   	    }

	  	   	  }else{

	  	   	  		$this->msg['code'] = 503;

		  	   	    $this->msg['message'] = "Please provide all required fields";
	  	   	  }

	  	   }else{

	  	   	    $this->msg['code'] = 503;

	  	   	    $this->msg['message'] = "Session timeout. Login to change password";

	  	   }

	  	   $this->sendResponse($this->msg);
	  
	  }
	  
	  public function changeprofilepic(){
	  
	  }


	  public function sendsms(){

              $message        = $this->input->get_post('message');

              $customer_id    = (int) $this->input->get_post('customer_id');

              if($customer_id){

                     $customer = $this->customer->findOne($customer_id);

                     if($customer){

                             $mob = $customer->mobiletel;

                             send_sms($mob,$message);

                             $this->sms->create(array(
							   
							   'message' => $message,

                     	       'date' => date('Y-m-d',time()),

							   'too'=> &$customer->mobiletel,
                             ));

                     	    redirect(base_url().'customers/viewcustomerdetails/?customer_id='.$customer->id.'&message=Message sent successfully&message_type=success');

                     }else{

                     	 redirect(base_url().'customers/?message=error sending message,customer doesnt exists&message_type=warning');

                     }
              }else{

              	    redirect(base_url().'customers/?message=Error. Minimum action requirements not met&message_type=warning');

              }
	  }
}