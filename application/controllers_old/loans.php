<?php if(!defined('BASEPATH')) exit('Access Denied!!');

class Loans extends CI_Controller{
    
	 protected $models = array(
	 
				'sys_object' => 'systemobject_model',
				
				'sys_option' => 'systemoption_model',
				
				'product' => 'product_model',
		 
				'loan' => 'loan_model',

				'loan_charge' => 'charge_model',
				
				'collateral' => 'collateral_model',
				
				'account' => 'account_model',
				'sub_account' => 'sub_account_model',
				
				'transaction' => 'transaction_model',
				
				'customer' => 'customer_model',
				
				'customer_account' => 'customeraccount_model',

				'expected_payment' => 'expectedpayment_model',

				'payment' => 'payment_model',

				'charge_payment' => 'chargepayment_model',
				
				'gaurantor' => 'gaurantor_model',
				
				'transfers' => 'transfers_model',
			
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
	 
			$criteria = strtolower(trim($this->input->get_post('criteria')));
			
			$message  = null;
			
			$errors   = array();
			
			$loans    = null;
			
			if($criteria && in_array($criteria,array('issued','requested',))){
			
			        $request_status = 2;
			
					switch($criteria){
					
							case 'requested': $request_status = 1; break;
							
							case 'issued'   : break;

							default:break;
					}
					
					$loans    = $this->loan->findBy(array(
					
							'request_status' => $request_status,
							
					));
			
			}else{
			        
					$criteria = 'all';
					
					$loans    = $this->loan->findAll();
					
			}
			
			$this->page->title     = "Mombo Loan System | Loans";
			
			$this->page->name      = 'mombo-loans';
			
			$this->msg['page']     = $this->page;
			
			$this->msg['criteria'] = $criteria;
			
			$this->msg['requests'] = $loans;
			
			$this->sendResponse($this->msg, array(
					
					$this->header => $this->msg,
					
					'mombo/templates/loanrequests' => $this->msg,
					
					$this->footer => $this->msg,
					
			   )
			   
			);
	 
	 }
	 
	 /******Loan Products******/
	 
			 public function addnewproduct(){
			 
					$message = null;
					
					$errors  = array();
			 
					if($this->input->post('add_product')){
					
							$product = $this->input->post('product');
							
							$product['status'] = 1;
							
							switch($product['loan_repayment_frequency']){
									
									case 'weekly'   : $product['repayment_frequency_single'] = 'week'; break;
									
									case 'monthly'  : $product['repayment_frequency_single'] = 'month'; break;
									
									case 'annually' : $product['repaymeny_frequency_single'] = 'year'; break;
									
									case 'per-two-months': $product['repaymeny_frequency_single'] = 'two months';break;
																
									case 'per-three-months':$product['repaymeny_frequency_single'] = 'three months';break;
									
									case 'quartely':$product['repaymeny_frequency_single'] = 'quarter';break;
									
									case 'per-five-months':$product['repaymeny_frequency_single'] = 'five months';break;
									
									case 'twice-annually':$product['repaymeny_frequency_single'] = 'half year';break;
							
							}

                          
							
							$added   = $this->product->create($product);
							
							if($added) redirect(base_url().'loans/loanproducts?message=product successfully added&message_type=success');
							
							$message = "Error adding product. Please review your inputs and try again";
							
							$errors  = $this->product->validationerrors();
					
					}
					
					$this->page->title      = "Mombo Loan System | Add New Product";
					
					$this->page->name       = 'mombo-addproduct';
							
					$this->msg['page']      = $this->page;
					
					$this->msg['criteria']  = '';
					
					$this->msg['message']   = $message;
					
					$this->msg['errors']    = $errors;
					
					$this->msg['product']   = $this->product;
					
					$this->sendResponse($this->msg,array(
					
							$this->header => $this->msg,
							
							'mombo/templates/addnewloanproduct' => $this->msg,
							
							$this->footer => $this->msg
					));
			 
			 }
			 
			 
			 public function editproduct(){
			 	
					$message     = null;
					
					$errors      = array();
					
					$product_id  = (int) $this->input->get_post('product_id');
					
					if(!isset($product_id) || empty($produc_id) || $product_id != '' || null != $product_id){
						
						         $product_id = ($product = $this->input->post('product')) ? $product['id'] : $product_id;
						
					} 
							
					
					if($product_id){
					        
							$product = $this->product->findOne($product_id);
					
							if(null != $product){
							        
									$this->product = $product;
			 
									if($this->input->post('edit_product')){
									
											$product = $this->input->post('product');
											
											switch($product['loan_repayment_frequency']){
											
													case 'weekly'   : $product['repayment_frequency_single'] = 'week'; break;
													
													case 'monthly'  : $product['repayment_frequency_single'] = 'month'; break;
													
													case 'annually' : $product['repaymeny_frequency_single'] = 'year'; break;
													
													case 'per-two-months': $product['repaymeny_frequency_single'] = 'two months';break;
																				
													case 'per-three-months':$product['repaymeny_frequency_single'] = 'three months';break;
													
													case 'quartely':$product['repaymeny_frequency_single'] = 'quarter';break;
													
													case 'per-five-months':$product['repaymeny_frequency_single'] = 'five months';break;
													
													case 'twice-annually':$product['repaymeny_frequency_single'] = 'half year';break;
																				
											
											}

											
											$added   = $this->product->doupdate($product);
											
											if($added) redirect(base_url().'loans/loanproducts?message=product successfully updated&message_type=success');
											
											$message = "Error editing product. Please review your inputs and try again";
											
											$errors  = $this->product->validationerrors();
									
									}
								
							}else{
							
									redirect(base_url().'loans/loanproducts?message=Error!. Product not found&message_type=warning');
							
							}
						
					}else{
					
							redirect(base_url().'loans/loanproducts?message=Error!. Action\'s minimum requirement not met&message_type=warning');
					
					}
					
					$this->page->title      = "Mombo Loan System | Edit Product";
					
					$this->page->name       = 'mombo-editproduct';
							
					$this->msg['page']      = $this->page;
					
					$this->msg['criteria']  = '';
					
					$this->msg['message']   = $message;
					
					$this->msg['errors']    = $errors;
					
					$this->msg['product']   = $this->product;
					
					$this->sendResponse($this->msg,array(
					
							$this->header => $this->msg,
							
							'mombo/templates/editloanproduct' => $this->msg,
							
							$this->footer => $this->msg
					));
			 
			 }
			 
			 public function deleteproduct(){
			 
					$product_id = (int) $this->input->get_post('product_id');
					
					if($product_id){
					
							$product = $this->product->findOne($product_id);
							
							if(null != $product){
							
									if($this->input->get_post('confirmed')){
									
											if($product->delete()) redirect(base_url().'loans/loanproducts/?message=Loan product deleted successfully!&message_type=success');
									
											redirect(base_url().'loans/loanproducts/?message=Error deleting product&message_type=warning');
										
									}
							
							}else{
							
									redirect(base_url().'loans/loanproducts/?message=Error. Loan product does not exists&message_type=warning');
							
							}
					
					}else{
					   
							redirect(base_url().'loans/loanproducts?message=Error!. Action\'s minimum requirement not met&message_type=warning');
								
					}
					
					$this->page->title 		= "Mombo Loan System | Confirm Delete";
					
					$this->page->name  		= 'mombo-delete-product';
					
					$this->msg['page'] 		= $this->page;
					
					$this->msg['message']   = "Do you really want to delete this product";
					
					$this->msg['yes_url']   = base_url().'loans/deleteproduct/?confirmed=true&product_id='.$product_id;
					
					$this->msg['no_url']    = base_url().'loans/productdetails/?product_id='.$product_id;
					
					$this->sendResponse($this->msg,array(
						
								$this->header=>$this->msg,
								
								'mombo/templates/confirm'=>$this->msg,
								
								$this->footer=>$this->msg,
							
						)
					 
					);
			 
			 }
			 
			 
			 public function productdetails(){
			 
					$product_id        = (int) $this->input->get_post('product_id');
					
					$loans             = array();
					
					$loans_settled     = array();
					
					$loan_requests     = array();
					
					$accepted_requests = array();
					
					$denied_requests   = array();
					
					
					if($product_id){
					
							$product = $this->product->findOne($product_id);
							
							if(null != $product){
								
								    $this->product = $product;
									
									$loans = $this->loan->findBy(array(
									
											'loan_product' => $this->product->id,
											
									));
									
									$loans_settled = $this->loan->findBy(array(
									
											'loan_product' => $this->product->id,
											
											'loan_status'  => 1,
									
									));
									
									$loan_requests  =  $this->loan->findBy(array(
											
											'loan_status'  => 0,
											
											'request_status' => 1
									
									  )
									);
									
									$accepted_requests  =  $this->loan->findBy(array(
											
											'loan_status'  => 0,
											
											'request_status' => 2
									
									  )
									);
									
									$denied_requests  =  $this->loan->findBy(array(
											
											'loan_status'  => 0,
											
											'request_status' =>3
									
									  )
									);
							
							}else{
							
								   redirect(base_url().'loans/loanproducts/?message=Error. Loan product does not exists&message_type=warning');
								   
							}
					
					}else{
					
							redirect(base_url().'loans/loanproducts?message=Error!. Action\'s minimum requirement not met&message_type=warning');
							
					}
					
					
					$this->page->title             	= "Mombo Loan System | Product Summary";
					
					$this->page->name				= 'mombo-product-details';
					
					$this->msg['page']             	= $this->page;
					
					$this->msg['product']         	= $this->product;
					
					$this->msg['loans']           	= $loans;
					 
					$this->msg['loans_settled']    	= $loans_settled;
					
					$this->msg['loan_requests']    	= $loan_requests;
					
					$this->msg['denied_requests']  	= $denied_requests;
					
					$this->msg['accepted_requests'] = $accepted_requests;
					
					$this->sendResponse($this->msg,array(
					
							$this->header => $this->msg,
							
							'mombo/templates/productdetails' => $this->msg,
							
							$this->footer => $this->msg,
					
					));
			 
			 }
			 
			 public function loanproducts(){
			   
					$products 		= $this->product->findAll(array((int)$this->input->get_post('per_page'),20));
					
					$message		= $this->input->get_post('message');
					
					$message_type   = $this->input->get_post('message_type');
					
					$this->page->title          = "Mombo Loan System | Loan Products";
					
					$this->page->name           = 'mombo-loan-products';
					
					$this->msg['page']    	    = $this->page;
					
					$this->msg['products'] 		= $products;
					
					$this->msg['message']  		= $message;
					
					$this->msg['message_type']  = $message_type;
					
					$this->sendResponse($this->msg,array(
					
							$this->header => $this->msg,
							
							'mombo/templates/loanproducts' => $this->msg,
							
							$this->footer => $this->msg,
					  )
					);
			 
			 }
	 
	 /******End Loan products******/
	 
	 /******Loan Requests******/
	 
			 public function loanrequests(){
			 
			 
			        $criteria		 = strtolower($this->input->get_post('criteria')); //get product criteria to such for
					
					$product_id      = (int) $this->input->get_post('product_id');
					
					$message 		 = $this->input->get_post('message');
					
					$message_type    = $this->input->get_post('message_type');
					
					$requests = null;
					
					if($criteria && in_array($criteria,array('den','acc','new'))){
					        
							$status = 0;
							
					        switch($criteria){
							
									case 'den': $status = 3; break;
									
									case 'acc':	$status = 2; break;
									
									case 'new': $status = 1; break;
									
									default:break;
							}
					
							$requests = $this->loan->findBy(
							
								  array(
									 
										 'loan_status' => 0,
										 
										 'request_status' => $status,
										 
									 ),
									 
								  array(
								  
										 (int)$this->input->get_post('per_page'),
										 
										  20,
									  
									)
								
							 );
							 
							 if($product_id){
							 
							 
										if($this->product->findOne($product_id)){
							 
												$requests = $this->loan->findBy(
										
													  array(
														 
															 'loan_status' => 0,
															 
															 'request_status' => $status,
														 
															 'loan_product' => $product_id,
															 
														 ),
														 
													  array(
														  
															 (int)$this->input->get_post('per_page'),
															 
															  20,
														  
														)
													
												);
												
										 }else{
										 
											  redirect(base_url().'loans/loanrequests/?message=Error loan product cannot be found&message_type=warning');
										 
										 }
							}
							
					}else{
					
							$criteria  = 'all';
							
							$requests  = $this->loan->findAll(array(
							
									(int) $this->input->get_post('per_page'),
									
									20,
							
							));
							
							if($product_id){
							 
							 
										if($this->product->findOne($product_id)){
							 
												$requests = $this->loan->findBy(
										
													  array(
														 
															 'loan_status' => 0,
															
															 'loan_product' => $product_id,
															 
														 ),
														 
													  array(
														  
															 (int)$this->input->get_post('per_page'),
															 
															  20,
														  
														)
													
												);
												
										 }else{
										 
											  redirect(base_url().'loans/loanrequests/?message=Error loan product cannot be found&message_type=warning');
										 
										 }
							}
					}
					
					$this->page->title           = "Mombo Loan System | Loan Requests";
					
					$this->page->name            = 'mombo-loan-products';
					
					$this->msg['page']    	     = $this->page;
					
					$this->msg['requests']		 = $requests;
					
					$this->msg['message']  		 = $message;
					
					$this->msg['message_type']   = $message_type;
					
					$this->msg['criteria']       = $criteria;
					
					$this->sendResponse($this->msg,array(
					
							$this->header => $this->msg,
							
							'mombo/templates/loanrequests' => $this->msg,
							
							$this->footer => $this->msg,
					  )
					);
			 
			 }

			 public function getloanchargesandpayments(){

			 	   $loan_id = (int) $this->input->get_post('loan_id');

			 	   if($loan_id){

			 	   		   $loan = $this->loan->findOne($loan_id);

			 	   	       if(null != $loan){

			 	   	       			$this->msg['loan_charges']     = $this->loan_charge->findBy(array('loan'=>$loan->id));

			 	   	       			$this->msg['loan_payments']    = $this->expected_payment->findBy(array('loan'=>$loan->id));

			 	   	       			$this->msg['message'] 	       = 'OK';

			 	   	       			$this->msg['responsecode']     = 200;

			 	   	       }else{

			 	   	       		$this->msg['message']       = "Loan item does not exists";

			 	   	       	    $this->msg['responsecode']  = 404;

			 	   	       }


			 	   }else{

			 	   			$this->msg['message']       = "Loan item does not exists";

			 	   			$this->msg['responsecode']  = 404;

			 	   }

			 	   $this->sendResponse($this->msg);
			 }


			 public function findloansby(){

			 	  $by        = strtolower(trim($this->input->get_post('by')));

			 	  $criteria  =  strtolower(trim($this->input->get_post('criteria')));

			 	  $loans     = null;

			 	  if($by && in_array($by,array('id','customer','product','customer_idnum'))){

			 	  	        $field = 'id';

			 	  	        $value = 0;

			 	  			switch($by){

			 	  				  case 'id' :            $value = (int) $this->input->get_post('loan_id');break;

			 	  				  case 'customer':       $field =  'customer';$value = (int) $this->input->get_post('customer_id');break;
								  
								  case 'customer_idnum': $field =  'customer';$value = $this->customer->findBy(array('idnumber'=>(int)$this->input->get_post('customer_id')))->row(0,'customer_model')->id;break;

			 	  				  case 'product' :       $field =  'loan_product';$value = (int) $this->input->get_post('product_id');break;

			 	  				  default:break;

			 	  			}

			 	  			if($criteria && in_array($criteria,array('paid','unpaid'))){
					
									$status  = 0;
									
									switch($criteria){
									
											case 'paid': $status = 1; break;
											
											default:break;
									
									}
									
								
									$loans   = $this->loan->findBy(
									
											array(
													 $field => $value,

													'request_status'=>2,
													
													'loan_status'=>$status
													
											)
											
									);
									
								
							}else{
							
								   $loans   = $this->loan->findBy(
									
											array(
													 $field => $value,

													'request_status'=>2
													
											)
											
									);
								
							}

				}else{
									
						 if($criteria && in_array($criteria,array('paid','unpaid'))){
					
								$status  = 0;
								
								switch($criteria){
								
										case 'paid': $status = 1; break;
										
										default:break;
								
								}
						
								$loans   = $this->loan->findBy(
								
										array(
												
												'request_status'=>2,
												
												'loan_status'=>$status
												
										)
										
								);

					    }else{

                            
								 $loans = $this->loan->findBy(array(

									  'request_status'=>2,

								 ));

                        }		
						  

				 }


			 	  $this->msg['loans'] = $loans;

			 	  $this->sendResponse($this->msg);
			 }
			 
			 public function loansissued(){ 
					$this->load->model('chargestotalpayment_model'); 
					$this->load->model('loan_model');
					
					$criteria      = strtolower($this->input->get_post('criteria'));
					if($criteria != "all" && $criteria != "paid"){
						$criteria = 'unpaid';
					}
					//echo "here ".$criteria; exit;
					$product_id    = (int) $this->input->get_post('product_id');
					
					$message       = $this->input->get_post('message');
					
					$message_type  = $this->input->get_post('message_type');
					
					$loans         = null;
					
					
					
					 if($this->input->get_post('start_date') && $this->input->get_post('end_date')){
				 		$filtered = 1;
					   $start_date = $this->input->get_post('start_date');
					   $end_date = $this->input->get_post('end_date');
					   
					   if($criteria && in_array($criteria,array('paid','unpaid'))){
					
								$status  = 1;
								
								switch($criteria){
								
										case 'unpaid': $status = 0; break;
										
										default:break;
								
								}
						
								$per_page = (int)$this->input->get_post('per_page');
								$loans = $this->loan_model->get_filtered_loans($start_date,$end_date,$status,$per_page);
						}else{
					
							    $criteria  = 'all';
								
								$status = -1;
								$per_page = (int)$this->input->get_post('per_page');
								$loans = $this->loan_model->get_filtered_loans($start_date,$end_date,$status,$per_page);
						}
						
						$total_charges = array();
						$total_amount_paid = array();
						$i = 0;
						foreach ($loans as $loan) {
							$total_charges[$i] = $this->chargestotalpayment_model->get_total_charges($loan["id"]); 
							$total_amount_paid[$i] = $this->chargestotalpayment_model->get_amount_paid($loan["transaction_code"]);
							$i++;
						}
						
                    }else{
						$filtered = 0;
				 			if($criteria && in_array($criteria,array('paid','unpaid'))){
					
								$status  = 1;
								
								switch($criteria){
								
										case 'unpaid': $status = 0; break;
										
										default:break;
								
								}
						
								$loans   = $this->loan->findBy(
								
										array(
												
												'request_status'=>2,
												
												'loan_status'=>$status
												
										),
										
										array(
										
												(int)$this->input->get_post('per_page'),
												
												20,
										)
										
								);
						}else{
								$per_page = (int)$this->input->get_post('per_page');
							    $criteria  = 'all';  
								
								$loans     = $this->loan->findBy(
								
									array(
											
											'request_status'=>2,
											
									),
									
									array(
									
											(int)$this->input->get_post('per_page'),
											
											20,
									)
									
								);
						}
						
						$total_charges = array();
						$total_amount_paid = array();
						$i = 0;
						foreach ($loans->result('loan_model') as $loan) {
							$total_charges[$i] = $this->chargestotalpayment_model->get_total_charges($loan->id);
							$total_amount_paid[$i] = $this->chargestotalpayment_model->get_amount_paid($loan->transaction_code);
							$i++;
						}
					}
					
															
					$this->page->title         = "Mombo Loan System | Loans Issued";
					
					$this->page->name          = 'mombo-issued-loans';
					
					$this->msg['page']         = $this->page;
					
					$this->msg['message']	   = $message;
					
					$this->msg['message_type'] = $message_type;
					
					$this->msg['criteria']     = $criteria;
					$this->msg['filtered']     = $filtered;
					$this->msg['loans']   	   = $loans;
					
					$this->msg['total_charges']   	   = $total_charges;
					
					$this->msg['total_amount_paid']   	   = $total_amount_paid;
					if($filtered){
						$this->msg['start_date']     = $start_date;
						$this->msg['end_date']     = $end_date;
					}
					
					$this->sendResponse($this->msg,array(
					
							$this->header => $this->msg,
							
							'mombo/templates/loansissued' => $this->msg,
							
							$this->footer => $this->msg,
					  )
					);
			 }
			 
			 public function editloanrequest(){
			 
			        $loan_id = (int) $this->input->get_post('loan_id');
					
					$message = null;
					
					$errors  = array();
					
					if(!isset($loan_id) || empty($loan_id) || $loan_id != '' || null != $loan_id){
						
						         $loan_id = ($request = $this->input->post('request')) ? $request['id'] : $loan_id;
						
					} 
			 
					if($loan_id){
					
					        $request = $this->loan->findOne($loan_id);
							
							if(null != $request){
							
									if(null == $this->collateral->findBy(array('loan' => $request->id))->row(0,'collateral_model')){
									
											$created = $this->collateral->create(array(
													
													'loan' =>  $request->id,
													
													'name' => '',
													
													'description' => null
													
												)
											
											);

											if(!$created){
											
												redirect(base_url().'loans/loanrequests/?message=Error updating loan request. Something went wrong please try again. Collateral&message_type=warning');
											
											}
										
									}
									
									
							
									if($this->input->post('edit_request')){
									
												$collateral     = $this->input->post('collateral');
												
												$edit_request   = $this->input->post('request');
												
												$gaurantor      = $this->input->post('gaurantor');
												
												//var_dump($_FILES['request_gaurantorpic']);exit();
												
												if(!empty($_FILES['request_gaurantorpic']) && $_FILES['request_gaurantorpic']['name']){
												
														$gaurantor_pic  = $this->upload->do_upload('request_gaurantorpic');
														
														if($gaurantor_pic){
														
																$upload = $this->upload->data();
																
																$gaurantor['profilepic'] = $upload['file_name'];
														
														}else{
																
																$message = "<p>Error uploading gaurantor's picture.</p>".$this->upload->display_errors();;
																
																$gaurantor['profilepic'] = $request->guarantor->profilepic;
														
														}
												}else{
												
														$gaurantor['profilepic'] = $request->gaurantor->profilepic;
												
												}
												
												if($this->collateral->doupdate($collateral) && $this->loan->doupdate($edit_request) && $this->gaurantor->doupdate($gaurantor) && $message == null ){
												
														redirect(base_url().'loans/loanrequests/?message=Successfully updated loan request&message_type=success');
												
												}else{
												
														if(null == $message){
														
																$message = 'Error updating request. Please review your inputs';
														  
														}
														
														$errors  = array_merge($this->collateral->validationerrors(),$this->loan->validationerrors(),$this->gaurantor->validationerrors());
														
														//var_dump($errors);
												
												}
												
												
									}
									
									$this->loan        = $request;
									
									$this->collateral  = $this->collateral->findBy(array('loan' => $request->id))->row(0,'collateral_model');
									
									$this->gaurantor   = $this->gaurantor->findBy(array('loan'=>$request->id))->row(0,'gaurantor_model');
									
									$this->loan->gaurantor = $this->gaurantor->id;

									$this->loan->collateral = $this->collateral->id;
									
									$this->customer    = $this->customer->findOne($this->loan->customer->id);
									
							}else{
							
									redirect(base_url().'loans/loanrequests/?message=Loan request not found. Please try again. If error persist contact the administrator&message_type=warning');
							
							}
							
					}else{
					
							redirect(base_url().'loans/loanrequests/?message=Error minimum requirements for action not met. Please try again&message_type=warning');
					
					}
					
					$this->page->title       = "Mombo Loan System | Edit Loan Request";
					
					$this->page->name  		 = 'mombo-edit-request';
					
					$this->msg['page']		 = $this->page;
					
					$this->msg['message']    = $message;
					
					$this->msg['errors']     = $errors;
					
				    $this->msg['collateral'] = $this->collateral;
					
					$this->msg['gaurantor']  = $this->gaurantor;
					
					$this->msg['request']    = $this->loan;
					
					$this->msg['products']   = $this->product->findAll();
					
					$this->msg['customer']   = $this->customer;
					
					$this->msg['criteria']   = '';
					
					$this->sendResponse($this->msg,array(
					
							$this->header => $this->msg,
							
							'mombo/templates/editloanrequest' => $this->msg,
							
							$this->footer => $this->msg,
					  )
					);
					
			 
			 }
			 
			 public function confirmrequest(){
					$this->load->model('pay_model');
					$loan_id = (int) $this->input->get_post('loan_id');
					
					$loan = $this->loan->findOne($loan_id);
					
					
					if($loan){
					
							 if($this->input->post('waiver_charge')){
							 
							      $waiver = (int) $this->input->get_post('transaction_fee_waiver');
								  $description = $this->input->get_post('description');
								  $this->pay_model->update_disbursement_description($loan_id,$description);
								  
								  redirect(base_url().'loans/acceptloan/?confirmed=true&loan_id='.$loan->id.'&transaction_fee_waiver='.$waiver);
							 
							 }else{
							 
							       $this->page->title  = "Mombo Loan System | Accept Loan Waiver";
								   
								   $this->page->name   = 'mombo-waiver-loan';
								   
								   $this->msg['page']  = $this->page;
								   
								   $this->msg['loan']  = $loan;
								   
								   $this->msg['criteria'] = '';
								   
								   $this->sendResponse($this->msg,array(
								   
											$this->header => $this->msg,
											
											'mombo/templates/confirmrequest' => $this->msg,
											
											$this->footer => $this->msg,
								   ));
								   
							 }
							 
					
					}else{
					   
					     redirect(base_url().'loans/loanrequests/?message=Error. Minumum action requirement not met&message_type=warning');
					}
			 
			 }
			 
			 public function acceptloan(){
			 	$this->load->model('pay_model');
				$this->load->model('loan_transactions_model'); 
				$this->load->model('rewards_model');
				$this->load->model('penalties_model');
				$this->load->model('account_model');
			 //echo "here"; exit;
					$loan_id = (int) $this->input->get_post('loan_id');

					$transaction_fee_waiver = 0;
					
					if($loan_id){
					
							$loan = $this->loan->findOne($loan_id);
					
							if(null != $loan){


								    if($loan->request_status == 2 ) redirect(base_url().'loans/loanrequests/?message=Loan request already accepted&message_type=info');
                                    
                                    if(!$this->input->get('confirmed')) redirect(base_url().'loans/confirmrequest?loan_id='.$loan->id);

                                    $transaction_fee_waiver = (int)$this->input->get_post('transaction_fee_waiver');

								    $customer_account = $this->customer_account->findBy(array(
											
													'customer' => $loan->customer->id,
													
											 )
									)->row(0,'customeraccount_model');

									
									if(null == $customer_account){
											
											$customer_account = array(
											
												'customer' => $loan->customer->id,
												
												'balance'  => 0
											);
											
											$added = $this->customer_account->create($customer_account);
											
											if(!$added) redirect(base_url().'loans/loanrequests/?message=Error creating customer ledger account. Please try again&message_type=warning');
											
											$customer_account = $this->customer_account->findBy(array(
											
													'customer' => $loan->customer->id,
													
											 )
											)->row(0,'customeraccount_model');
											
									       
									}

									
									$cash_account = $this->account->findOne($this->sys_option->findBy(array(
											
											'name'=>'loan_service_account'
											
									))->row(0,'systemoption_model')->value);
									
									$collection_account = $this->account->findOne($this->sys_option->findBy(array(
											
											'name'=>'loan_receipt_account'
											
									))->row(0,'systemoption_model')->value);

									
									if(null != $cash_account && null != $collection_account){

										        $time_stamp = time();
									
												if($cash_account->account_balance < $loan->loan_principle_amount ) redirect(base_url().'loans/loanrequests/?message=cash account balance is less than loan amount&message_type=warning');
												
												$cash_account->account_balance -= $loan->loan_principle_amount;
												
												$customer_account->balance += $loan->loan_principle_amount;
												
												$transaction_code = 'TRNS-'.date('Ymdis',$time_stamp).'-'.strtoupper(random_string('alnum',4)).'-'.$loan_id;
												$payment_code = $loan_id.''.date('siHdmY').'-'.strtoupper(random_string('alnum',4)).'-'.$cash_account->id;
												$debit_transaction = array(
													
															'object' => $this->sys_object->findBy(array('name'=>'loan'))->row(0,'systemobject_model')->id,
														
															'transaction_code' => $transaction_code,
															
															'account' => $customer_account->id,
															
															'transactiontype' => 1,
															
															'description' => 'Loan amount received for '.$loan->loan_product->loan_product_name.' request' ,
															
															'date' => date('Y-m-d',$time_stamp),
															
															'amounttransacted' => $loan->loan_principle_amount,
															
															'user' => $this->session->userdata('user_id'),
															'payment_code' => $payment_code,
															'ref_num' => $transaction_code
												
												);
											
												$credit_transaction = array(
												
															'object' => $this->sys_object->findBy(array('name'=>'loan'))->row(0,'systemobject_model')->id,
														
															'transaction_code' => $transaction_code,
															
															'account' => $cash_account->id,
															
															'transactiontype' => 0,
															
															'description' => 'Customer Loan issue for '.$loan->loan_product->loan_product_name.' request',
															
															'date' => date('Y-m-d',$time_stamp),
															
															'amounttransacted' => $loan->loan_principle_amount,
															
															'user' => $this->session->userdata('user_id'),
															'payment_code' => $payment_code,
															'ref_num' => $transaction_code
												);

												
												if($customer_account->update() && $cash_account->update()){
												
														if($this->transaction->create($debit_transaction) && $this->transaction->create($credit_transaction)){
                                                               
												             $transaction_fee   = $loan->getTransactionFee()-$transaction_fee_waiver;
															 
															 $collection_account->account_balance += $transaction_fee;
															 
															 $payment_code = $loan_id.''.date('siHdmY').''.$collection_account->id;

												             if($transaction_fee > 0 ){

														              $transaction_fee_credit_transaction  = array(

															               		'object' => $this->sys_object->findBy(array('name'=>'loan'))->row(0,'systemobject_model')->id,
																	
																				'transaction_code' => $transaction_code,
																				
																				'account' => $collection_account->id,
																				
																				'transactiontype' => 1,
																				
																				'description' => 'Transction Fee for '.$loan->loan_product->loan_product_name.' issuance' ,
																				
																				'date' => date('Y-m-d',$time_stamp),
																				
																				'amounttransacted' => $transaction_fee,
																				
																				'user' => $this->session->userdata('user_id'),
																				'payment_code' => $payment_code,
																				'ref_num' => $transaction_code

														               );
																	   
																	   
																	   $transaction_fee_debit_transaction  = array(

															               		'object' => $this->sys_object->findBy(array('name'=>'loan'))->row(0,'systemobject_model')->id,
																	
																				'transaction_code' => $transaction_code,
																				
																				'account' => $customer_account->id,
																				
																				'transactiontype' => 0,
																				
																				'description' => 'Transction Fee for '.$loan->loan_product->loan_product_name.' issueance' ,
																				
																				'date' => date('Y-m-d',$time_stamp),
																				
																				'amounttransacted' => $transaction_fee,
																				
																				'user' => $this->session->userdata('user_id'),
																				'payment_code' => $payment_code,
																				'ref_num' => $transaction_code

														               );

														                //Create charge records

														               $tfee_charge = array(

		                                                                      'name' => 'transction_fee',

		                                                                      'loan' => $loan->id,

		                                                                      'date' => date('Y-m-d',$time_stamp),

		                                                                      'amount' => $transaction_fee,

		                                                                      'balance' => 0,

		                                                                      'transaction_code' => $transaction_code,

		                                                                      'paid' => 1,
														               );

														       }
															   
															   $full_description = 'Payment for Transaction Fee';
															   if($transaction_fee > 0){
															   		$this->pay_model->add_full_payment($loan_id, $transaction_fee,3,$full_description,$payment_code);
																	
																   $keys_values = array(
																   						'loan_id' => $loan->id,
																						'amount' => $transaction_fee,
																						'paid' => 1);
																   $this->loan_charge->insert_transaction_fee($keys_values);
															   }
															   									
									
												               if($customer_account->update()){

																       if((($transaction_fee > 0) ? (($this->transaction->create($transaction_fee_debit_transaction) && $this->transaction->create($transaction_fee_credit_transaction)) ? true : false ) : true)){

																	        $interest_rate = $loan->loan_product->interest_rate;
																			$product_name = $loan->loan_product->loan_product_name;
																			$discounted = 0;
																			if(1 == $loan->loan_product->id){ 
																				$this->load->model('rewards_model');
																				$cust_id = $loan->customer->id;
																				$discount_values = $this->rewards_model->get_redeemed_discount_reward($cust_id);
																				if($discount_values != 0){
																					$discount_values_array = explode("^",$discount_values);
																					$discount = 0;
																					$redeemed_ids = array();
																					for($i = 0; $i < count($discount_values_array); $i++){
																						$discount_value_array = explode("*",$discount_values_array[$i]);
																						$discount += $discount_value_array[0];
																						$redeemed_ids[] = $discount_value_array[1];
																					}
																					$interest_rate -= $discount; 
																					$discounted = 1;
																					$this->rewards_model->settle_rewards($redeemed_ids,$loan->id);
																					
																					
																					$recipient =  $loan->customer->email;
																					$subject = "Mombo Reward";
																					$body = "Dear ".$loan->customer->name." ".$loan->customer->other_names.",\nYour personal loan interest has been discounted to ";
																					$body .= $interest_rate."% for a period of only one month. ";
                                                                                    $body .= "This is as a result of redeeming your Mombo Loyal points. We appreciate your Loyalty.";
																					$headers = "From: admin@mombo.co.ke";
																					@mail($recipient, $subject, $body,$headers);
																					
																					$message = $body;
																					$customer_mobile = $loan->customer->mobiletel;
																					send_sms($customer_mobile,$message);
																					
																					$sent_date = date("Y-m-d");
																					$this->penalties_model->set_sent_sms($customer_mobile, $message, $sent_date);
																					
																					$discounted_interest = round( ($loan->loan_principle_amount * ($discount / 100) * $loan->loan_duration),0);
																					$from_account = $this->account->findOne(2);
																					$this->account_model->update_account_balance(2,$discounted_interest,0);
																					$this->account_model->update_account_balance(5,$discounted_interest,1);
																					$this->account_model->update_sub_account_balance(46,$discounted_interest,1);
																					$to_account_id = 5;
																					$to_sub_account_id = 46;
																					$to_account = $this->sub_account->findOne($to_sub_account_id);
																					$t_code  = 'TRNS-'.date('Y-m',time()).strtoupper(random_string('alnum',4));
																					$obj = 0;
																					$acct_to = $to_account_id;
																					$sub_acct_to = $to_sub_account_id;
																					$t_type_d = 0; //debit
																					$t_type_c = 1; //credit
																					$date = date('Y-m-d');
																					$description_c = 'Transfer from '.$from_account->account_name;
																					$description_d = 'Transfer to '.$to_account->account_name;
																					$user = $this->session->userdata('user_id');
																					$payment_code = $acct_to.''.date('siHdmY');
																					$this->account_model->insert_transaction($obj,$transaction_code,2,0,$t_type_d,$description_d,$date,$discounted_interest,$user,$payment_code,$transaction_code);//debit
																					$this->account_model->insert_transaction($obj,$transaction_code,5,46,$t_type_c,$description_c,$date,$discounted_interest,$user,$payment_code,$transaction_code);//credit
																				}
																			}
																			
																			$loan->discounted = $discounted;
																			
                                                                            if(strtolower($loan->loan_product->interest_type) == 'simple'){

                                                                            	  $loan->loan_amount_payable = round(($loan->loan_principle_amount + ($loan->loan_principle_amount * ($interest_rate / 100) * $loan->loan_duration)),0);

                                                                            }elseif(strtolower($loan->loan_product->interest_type) == 'compound'){
																			
																			     $pv  = $loan->loan_principle_amount;
																				 
																				 $i   = ($interest_rate+100) / 100;
																				 
																				 $n   = $loan->loan_duration;

                                                                                 $loan->loan_amount_payable = round($pv * pow($i,$n),0);
                                                                            }

                                                                            $loan->loan_balance_amount   = round(($loan->loan_amount_payable),0);

                                                                            $loan->total_interest_amount = $loan->loan_amount_payable - $loan->loan_principle_amount;

                                                                            $loan->installment_amount    = round(($loan->loan_amount_payable / $loan->loan_duration),0);

                                                                            $loan->installment_interest  = round(($loan->total_interest_amount / $loan->loan_duration),0);

                                                                            $loan->loan_issue_date       = date('Y-m-d',$time_stamp);


                                                                            $days  = 0;
																			
																			//$date= date('Y-m');
																			

                                                                            switch (strtolower($loan->loan_product->loan_repayment_frequency)) {

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
																				
																				case 'per-eleven-months':$days = 341;break;
                                                                            	
                                                                            	default:break;
                                                                            }
												if( (strtolower($loan->loan_product->loan_repayment_frequency)) == 'monthly'){
													$date_ = date('Y-m-d');
													$newdate_ = strtotime ( '+1 month' , strtotime ( $date_ ) ) ;
													$loan->loan_due_date = date ( 'Y-m-d' , $newdate_ );
												}
												else{
													$loan->loan_due_date          = date('Y-m-d',(($loan->loan_duration * $days * 24 * 60 * 60)+$time_stamp));
												}
                                                                            

																	        $total_interest_amount = 0;
																			

																	        for($i=1;$i <= $loan->loan_duration; $i++){

																	        	  $expected_time_stamp = (($i*$days*24*60*60)+$time_stamp);

                                                                                  $expected_payment = array(

                                                                                  		'loan'   => $loan->id,

                                                                                  		'amount' => $loan->installment_amount,

                                                                                  		'balance' => $loan->installment_amount - $loan->installment_interest,

                                                                                  		'interest_amount' => $loan->installment_interest,

                                                                                  		'interest_amount_balance' => $loan->installment_interest,

                                                                                  		'date_expected' => date('Y-m-d',$expected_time_stamp),
																						                                                                                												'initial_expected_date' => date('Y-m-d',$expected_time_stamp),

                                                                                  		'paid'=> 0,

                                                                                  		'transaction_code' => $transaction_code,
                                                                                  );
																				  
																				  $total_interest_amount += $loan->installment_interest;
	
																				  $customer_account->balance += $loan->installment_interest;
																				  $this->expected_payment->create($expected_payment);
																	        }
																			
																			round($customer_account->balance,0);

																	        $loan->request_status   = 2;
																			$loan->discounted = $discounted;

																	        $loan->transaction_code = $transaction_code;
																			
																			 $interest_debit_transaction  = array(

																						'object' => $this->sys_object->findBy(array('name'=>'loan'))->row(0,'systemobject_model')->id,
																			
																						'transaction_code' => $transaction_code,
																						
																						'account' => $customer_account->id,
																						
																						'transactiontype' => 1,
																						
																						'description' => 'Interest for '.$loan->loan_product->loan_product_name.' issueance' ,
																						
																						'date' => date('Y-m-d',time()),
																						
																						'amounttransacted' => $loan->total_interest_amount,
																						
																						'user' => $this->session->userdata('user_id'),
																						'ref_num' => $transaction_code

																			   );

																	        //send sms to customer and email to admin
																			 
																			 
																			 $updated_c  = $customer_account->update();
																			 
																			 $updated_cl = $collection_account->update();
																			 
																			 $updated_l  = $loan->update();
															
							$this->loan_transactions_model->insert_principal($loan_id,$loan->loan_principle_amount,$loan->disbursement_description);
							$this->loan_transactions_model->insert_interest($loan_id,$loan->loan_principle_amount,$total_interest_amount);								 
																		   
																		    if($updated_c && $updated_cl && $updated_l) redirect(base_url().'loans/loansissued?criteria=all&message=Loan issued successfully&message_type=success');

															           }
															    }
																	   
														}
														
														 
												}
												
												foreach($this->transaction->findBy(array('transaction_code'=>$transaction_code))->result('transaction_model') as $transaction){
													 	 
													    $transaction->delete();
														 
												}


												foreach($this->expected_payment->findBy(array('transaction_code'=>$transaction_code))->result('expectedpayment_model') as $payment){
														
				                                     	$payment->delete();

												}


												foreach($this->loan_charge->findBy(array('transaction_code'=>$transaction_code))->result('charge_model') as $charge){

                                                        $charge->delete();
												}
												
												
												$customer_account->balance -= $loan->loan_principle_amount+$transaction_fee+$total_interest_amount;
												
												$customer_account->update();
												
												$cash_account->account_balance += $loan->loan_principle_amount;
												
												$cash_account->update();

												$loan->transaction_code = null;
												
												$loan->request_status   =  1;
												
												$loan->update();
												
												redirect(base_url().'loans/loanrequests/?message=Transaction error. Please try again&message_type=danger');
												
										}else{
									
												redirect(base_url().'loans/loanrequests/?message=loan servicing account unavailable or not set&message_type=warning');
									
									}
							
							}else{
							
									redirect(base_url().'loans/loanrequests/?message=loan request not found or does not exists&message_type=warning');
							
							}
					
					}else{
					
							redirect(base_url().'loans/loanrequests/?message=Error minimum action requirement not met.Please try again&message_type=warning');
					
					}
			 
			 }
			 
			 public function rejectloan(){

			 		$loan_id = (int) $this->input->get_post('loan_id');

			 	    if($loan_id){

			 	    			$loan = $this->loan->findOne($loan_id);

			 	    			if(null != $loan){

			 	    					$loan->request_status = 3;

			 	    					if($loan->update()){

			 	    						    //send SMS to user

			 	    						  	redirect(base_url().'loans/loanrequests/?message=Successfully rejected loan requests&message_type=success');

			 	    					}else{

			 	    						    redirect(base_url().'loans/loanrequests/?message=Error updating loan product. Please try again&message_type=danger');
                                                

			 	    					}

			 	    			}else{


			 	    				    redirect(base_url().'loans/loanrequests/?message=loan request not found or does not exists&message_type=warning');

			 	    			}

			 	    }else{

			 	    			redirect(base_url().'loans/loanrequests/?message=Error minimum action requirement not met.Please try again&message_type=warning');


			 	    }
			 
			 }
			 
			 
			 public function penalization(){
					$this->load->model('loan_model');
			 		$loan_id = (int) $this->input->get_post('loan_id');
					$type= (int) $this->input->get_post('type');

			 	    if($loan_id){

			 	    			$loan = $this->loan->findOne($loan_id);

			 	    			if(null != $loan){

			 	    					$loan->penalizable = $type;

			 	    					if($loan->update()){
											$this->loan_model->penalization($type,$loan_id);
									
			 	    						  	redirect(base_url().'loans/loansissued/?message=Operation was successful&message_type=success');

			 	    					}else{

			 	    						    redirect(base_url().'loans/loansissued/?message=Error occured. Please try again&message_type=danger');
                                                

			 	    					}

			 	    			}else{


			 	    				    redirect(base_url().'loans/loansissued/?message=loan does not exists&message_type=warning');

			 	    			}

			 	    }else{

			 	    			redirect(base_url().'loans/loanissued/?message=Error minimum action requirement not met.Please try again&message_type=warning');


			 	    }
			 
			 }
			 

			 public function loanpaymentsandcharges(){
					$loan_id = (int) $this->input->get_post('loan_id');
					$payment_id = (int) $this->input->get_post('payment_id');
					$interest_bal = $this->input->get_post('interest');
					if($payment_id && $interest_bal){
						$this->load->model('loan_model');
						$this->load->model('loan_transactions_model');
						$this->loan_model->waive_interest($payment_id,$interest_bal,$loan_id);
						
						//add loan transaction
						$trans = 'Interest waived'; 
						$trans_description = '-';
						$is_credit = 1;
						$this->loan_transactions_model->add_transaction($loan_id,$trans,$trans_description,$is_credit,$interest_bal);
					}

			 		if($loan_id){

			 			     $loan = $this->loan->findOne($loan_id);
							 $customer_id = $loan->customer->id; 

			 			     if(null != $loan){

	                                    $charges  =  $this->loan_charge->findBy(array(

	                                    		'loan' => $loan->id,

	                                    ),array(
												
												(int) $this->input->get_post('per_page'),
												
												20,
										
										
										));

	                                    $expected_payments  =  $this->expected_payment->findBy(array(
	                                          
	                                            'loan' => $loan->id
												
										  ),array(
												
												(int) $this->input->get_post('per_page'),
												
												20,
										
										
										));
										
										$this->load->model('loan_transactions_model');
									  	$date = date('d-M-Y');
										$customer = $this->customer->findBy(array(

													'id' => $customer_id,
											));
											/*foreach($customer->result('customer_model') as $cust){
												echo $cust->name;
											}*/
											
										$single_loan = $this->loan->findBy(array(
											
													'id' => $loan_id,
											));
											/*foreach($loan->result('loan_model') as $cust_loan){
												echo $cust_loan->loan_product->loan_product_name;
											}*/
										$loan_transactions = $this->loan_transactions_model->get_loan_transactions($loan_id);
										/*foreach($loan_transactions as $loan_transaction){
											echo $loan_transaction["balance"]; 
										}*/
											
										//populate template data
										$this->msg['date'] = $date;
										$this->msg['customer'] = $customer;
										$this->msg['single_loan'] = $single_loan;
										$this->msg['loan_transactions'] = $loan_transactions;

	                                    $this->page->title         = "Mombo Loan System | Expected Payments & Charges";

	                                    $this->page->name          = 'mombo-loan-payments-and-charges';

	                                    $this->msg['page']         = $this->page;
										
										$this->msg['message']      = $this->input->get_post('message');
										
										$this->msg['message_type'] = $this->input->get_post('message_type');
   
	                                    $this->msg['loan']         = $loan;

	                                    $this->msg['charges']      = $charges;

	                                    $this->msg['payments']     = $expected_payments;
										
										$this->msg['current_tab']  = ($this->input->get_post('current_tab')) ?: 'loan_payments';

	                                    $this->sendResponse($this->msg,array(

	                                    		$this->header => $this->msg,

	                                    		'mombo/templates/paymentsandcharges' => $this->msg,

	                                    		$this->footer => $this->msg,

	                                    ));

			 			     }else{

			 	    				   redirect(base_url().'loans/loansissued/?message=loan request not found or does not exists&message_type=warning');

			 			     }

			 		}else{


			 	          redirect(base_url().'loans/loansissued/?message=Error minimum requirements for action not met&message_type=warning');


			 		}

			 }
			 
			 
			
			
			public function issueloan(){ 
			
				   $message = null;
				   
				   $errors  = null;
				   
				   if($this->input->get_post('issue_loan')){
				   
				           $amount    = $this->input->get_post('loan_amount');
						   
						   $duration  = $this->input->get_post('loan_duration');
						   
						   $product   = (int) $this->input->get_post('loan_product');
						   
						   $customer  = (int) $this->input->get_post('select_customer');
						   
						   $guarantor  = (int) $this->input->get_post('select_guarantor');
						   
						   $guarantor2  = (int) $this->input->get_post('select_guarantor2');
						   
						   if($customer && $product){
						   
						            $customer = $this->customer->findOne($customer);
									
									$product  = $this->product->findOne($product);
									
									if($customer && $product){
									
									           if($amount && $duration){
											   
														if(is_numeric($amount)&& is_numeric($duration)){
														
														          $maximum_amount    = $product->maximum_amount_loaned;
																  
																  $minimum_amount    = $product->minimum_amount_loaned;
																  
																  $maximum_duration  = $product->maximum_duration;
																  
																  $minimum_duration  = $product->minimum_duration;
																  
																  if($amount <= $maximum_amount && $amount >= $minimum_amount){
																  
																			if($duration <= $maximum_duration && $duration >= $minimum_duration){
																			
																			        $loan = array();
																					
																					$loan['transaction_code']				= 'TRNS-'.date('Y-m',time()).strtoupper(random_string('alnum',4));
													
																					$loan['customer']                       = $customer->id;
																					
																					$loan['loan_principle_amount']          = $amount;
																					
																					$loan['loan_product']                   = $product->id;
																					
																					$loan['loan_issue_date']                = null;
																					
																					$loan['loan_due_date']                  = null;
																					
																					$loan['loan_duration']                  = $duration;
																					
																					$loan['loan_balance_amount']            = 0;
																					
																					$loan['transaction_fee']                = 0;
																					
																					$loan['next_payment_date']              = null;
																					
																					$loan['request_status']                 = 1;
																					
																					$loan['loan_status']                    = 0;
																					
																					$loan['pmt']                            = 0;
																					if(0 != $guarantor){
																						$loan['gaurantor'] = $guarantor;
																					}
																					
																					if(0 != $guarantor2){
																						$loan['guarantor_b'] = $guarantor2;
																					}
																					
																					$loan['date_settled']  = '0000-00-00';
																					$loan['penalizable']  = 1;
																					
																					$added = $this->loan->create($loan);
																					
																					if($added){

																						  //send sms and email
																					
																					      redirect(base_url().'loans/loanrequests/?message=Loan issued successfully to '.$customer->name.'!&message_type=success&criteria=new');
																					
																					}
													
																			
																			}else{
																			
																					$message = "Your loan duration does not fall in the accepted range for this product. Between ".$maximum_duration." and ".$minimum_duration;
																			
																			}
																  
																  }else{
                                                                     
																	   $message = "Your loan amount does not fall in the accepted range for this product. Between Ksh ".$maximum_amount." and Ksh ".$minimum_amount;
																  
																  }
														
														}else{
														
														     $message = "Please make sure the loan amount and duration are valid numerical values";
														
														}
											   
											   }else{
											   
											       $message = "Please make sure you have input the amount and duration";
											   
											   }
									
									}else{
									
									     $message = "Customer or Product selected does not exist";
										  
									}
						   
						   }else{
						      
							     $message = "Please make sure you a have selected the customer and product";
						   }
						   
				   
				   }
				   
				   $this->page->title 		= "Mombo Loan System | Issue Loan";
				   
				   $this->page->name  		= 'mombo-issue-loan';
				   
				   $this->msg['page'] 		= $this->page;
				   
				   $this->msg['message']    = $message;
				   
				   $this->msg['message_type'] = 'warning';
				   
				   $this->msg['errors']     = $errors;
				   
				   $this->msg['products']   = $this->product->findAll();
				   
				   $this->sendResponse($this->msg,array(
				   
				          $this->header => $this->msg,
						  
						  'mombo/templates/issueloan' => $this->msg,
						  
						  $this->footer => $this->msg,
				   ));
			   
			   
			
			}
			 
	/******End Loan Requests******/
	
	/******Loan Payments******/

	        public function pay(){

			      $payment_amount    = $this->input->get_post('payment_amount');
				  
				  $total_pay_amount  = $payment_amount;
				  
				  $loan = $this->loan;
				  
	        	  if($this->input->get_post('make_payment')){

	        	  				$loan_id = (int) $this->input->get_post('loan_id');

	        	  				if($loan_id){

			        	  				$loan    = $this->loan->findOne($loan_id);
										
										if($loan->loan_status == 1)  redirect(base_url().'loans/makepayment/?message=Loan item has been settled&message_type=success'); 

			        	  				if(null != $loan){

			        	  					        if($this->input->get_post('payment_channel') != 'cheque'){
													
														$collection_account = $this->account->findOne($this->sys_option->findBy(array(
												
																'name'=>'loan_receipt_account'
																
														))->row(0,'systemoption_model')->value);
														
													}else{
													   
													    
														$collection_account = $this->account->findOne($this->sys_option->findBy(array(
												
																'name'=>'cheque_receipt_account'
																
														))->row(0,'systemoption_model')->value);
													
													}
													
													//var_dump($collection_account);

													$customer_account   = $this->customer_account->findBy(array(
                                                            
                                                             'customer' => $loan->customer->id,
															 
												    ))->row(0,'customeraccount_model');
													
													//var_dump($customer_account);exit;

                                                    $charges        = $this->loan_charge->findBy(array(
                                                    	
                                                    	   'loan' => $loan->id,

                                                    	   'paid' => 0,

                                                    ));

                                                    $payments       = $this->expected_payment->findBy(array(

                                                    	'loan' => $loan->id,

                                                    	'paid' => 0,

                                                    ));

													if($charges->num_rows() > 0){

                                                            foreach($charges->result('charge_model') as $charge){
															        
																	$amount_paid = 0;

                                                            		if($payment_amount > 0){

                                                            			  if($charge->balance >= $payment_amount){

			        	  					                                    $amount_paid      = $payment_amount;
																				
                                                            			  	    $payment_amount   = 0;

	                                                            			    $charge->balance -= $amount_paid;

	                                                            	      }else{

	                                                            	      	    $amount_paid      = $charge->balance;
																				
                                                                                $payment_amount  -= $charge->balance;

                                                                                $charge->balance  = 0;

	                                                            	      }

	                                                            	      $charge_pay   = array(

	                                                            	      	    'charge' => $charge->id,

	                                                            	      	    'date' => date('Y-m-d',time()),

	                                                            	      	    'amount' => $amount_paid,

	                                                            	      	    'channel' => $this->input->get_post('payment_channel'),

	                                                            	      	    'transaction_code' => $charge->transaction_code,

                                                            			  );

                                                            			  $debit_trans  = array(

                                                            			  	    'object' => $this->sys_object->findBy(array('name'=>'charge'))->row(0,'systemobject_model')->id,

                                                            			  		'transaction_code' => $charge->transaction_code,

                                                            			  		'account' => $collection_account->id,

                                                            			  		'transactiontype' => 1,

                                                            			  		'description' => "Payment for ".$charge->name." charge. ".$this->input->get_post('payment_description'),
																				
                                                            			  		'date' => date('Y-m-d',time()),

                                                            			  		'amounttransacted' => $amount_paid,

                                                            			  		'user' => $this->session->userdata('userid'),
                                                            			  );

                                                            			  $credit_trans = array(


                                                            			  	    'object' => $this->sys_object->findBy(array('name'=>'charge'))->row(0,'systemobject_model')->id,

                                                            			  		'transaction_code' => $charge->transaction_code,

                                                            			  		'account' => $customer_account->id,

                                                            			  		'transactiontype' => 0,

                                                            			  		'description' => "Payment for ".$charge->name." charge. ".$this->input->get_post('payment_description'),

                                                            			  		'date' => date('Y-m-d',time()),

                                                            			  		'amounttransacted' => $amount_paid,

                                                            			  		'user' => $this->session->userdata('userid'),
                                                            			  );

                                                                          $collection_account->account_balance += $amount_paid;
																		  
																		  $customer_account->balance -= $amount_paid;  
																		  
	                                                            	      if($charge->balance == 0) $charge->paid = 1;

	                                                            	      if($this->transaction->create($debit_trans) && $this->transaction->create($credit_trans)){

		                                                            	      	  if($this->charge_payment->create($charge_pay)){

			                                                            	      	  	 if($charge->update()){

			                                                            	      	  	 }else{

			                                                            	      	  	 	    redirect(base_url().'loans/makepayment?message=Error recording transaction&message_type=warning');

			                                                            	      	  	 }

		                                                            	      	  }else{

		                                                            	      	  	   redirect(base_url().'loans/makepayment?message=Error recording payment. Please try again&message_type=warning');
		                                                            	      	  }

	                                                            	      }else{

	                                                            	      	    redirect(base_url().'loans/makepayment?message=Error recording transaction.Please try again&message_type=warning');

	                                                            	      }

	                                                              }

                                                            }

                                                    }

                                                    if($payments->num_rows() > 0){

                                                    		foreach($payments->result('expectedpayment_model') as $payment){

                                                    			  $amount_paid = 0;

                                                                  $int_amount_paid = 0;

                                                    			  if($payment_amount > 0){

                                                                        
                                                                          if($payment->interest_amount_balance > 0 && $payment_amount > 0){

                                                                        	  if($payment->interest_amount_balance >= $payment_amount){

                                                                        	  		   $int_amount_paid  = $payment_amount;

                                                                        	  		   $payment->interest_amount_balance -= $int_amount_paid;

                                                                        	  		   $payment_amount  = 0;

                                                                        	  }else{
                                                                                       
                                                                                       $int_amount_paid = $payment->interest_amount_balance;

                                                                                       $payment_amount  -= $payment->interest_amount_balance;

                                                                                       $payment->interest_amount_balance = 0;

                                                                        	  }
																			  
																			  $loan->loan_balance_amount -= $int_amount_paid;
																			  
																			  
																		      $collection_account->account_balance += $int_amount_paid;
																		  
																		      $customer_account->balance -= $int_amount_paid;  
																			  
																			  $points = floor($int_amount_paid / 500);
																		
																			  $loan->customer->loyaltypoints = $points;
																				
																			  $loan->customer->update();


																					  
		                                        			  					if($payment->balance >= $payment_amount){
		                                                                             
		                                                                              $amount_paid       = $payment_amount;

		                                                                              $payment->balance -= $payment_amount;

		                                                                              $payment_amount    = 0;

		                                        			  					}else{

		                                        			  						 $amount_paid        = $payment->balance;

		                                        			  						 $payment_amount    -= $payment->balance;

		                                        			  						 $payment->balance   = 0;

		                                        			  					}
																				
																				 $loan->loan_balance_amount -= $amount_paid;
																				
																				 $collection_account->account_balance += $amount_paid;
																				  
																				 $customer_account->balance -= $amount_paid;  
																		


                                                                        	  $interest_paid = array(

	                                                                               'payment' => $payment->id,

	                                                                               'transaction_code' => $payment->transaction_code,

	                                                                               'payment_amount' => $int_amount_paid,

	                                                                               'payment_date' => date('Y-m-d',time()),

	                                                                               'payment_channel' => $this->input->get_post('payment_channel'),

	                                                                               'desc' => "Payment for customer loan interest. ".$this->input->get_post('payment_description'),

                                                                        	  );

                                                                        	  $debit_trans   = array(

	                                                                        	    'object' => $this->sys_object->findBy(array('name'=>'payment'))->row(0,'systemobject_model')->id,

	                                                            			  		'transaction_code' => $payment->transaction_code,

	                                                            			  		'account' => $collection_account->id,

	                                                            			  		'transactiontype' => 1,

	                                                            			  		'description' => "Payment for customer loan interest",

	                                                            			  		'date' => date('Y-m-d',time()),

	                                                            			  		'amounttransacted' => $int_amount_paid,

	                                                            			  		'user' => $this->session->userdata('userid'),

                                                                        	  );

                                                                        	  $credit_trans  = array(

	                                                                        	    'object' => $this->sys_object->findBy(array('name'=>'payment'))->row(0,'systemobject_model')->id,

	                                                            			  		'transaction_code' => $payment->transaction_code,

	                                                            			  		'account' => $customer_account->id,

	                                                            			  		'transactiontype' => 0,

	                                                            			  		'description' => "Payment for customer loan interest. ".$this->input->get_post('payment_description'),


	                                                            			  		'date' => date('Y-m-d',time()),

	                                                            			  		'amounttransacted' => $int_amount_paid,

	                                                            			  		'user' => $this->session->userdata('userid'),


                                                                        	  );

                                                                              if($this->transaction->create($debit_trans) && $this->transaction->create($credit_trans)){

	                                                                        		if($this->payment->create($interest_paid)){

		                                                                        		}else{

		                                                                        		        redirect(base_url().'loans/makepayment?message=Error recording payment. Please try again&message_type=warning');

		                                                                        			  

		                                                                        		}

		                                                                        }else{

			                                                            		       redirect(base_url().'loans/makepayment?message=Error recording transactions. Please try again&message_type=warning');

		                                                                        }

                                                                        }

                                                                        $payment_made = array(
                                                                               
                                                                               'payment' => $payment->id,

                                                                               'transaction_code' => $payment->transaction_code,

                                                                               'payment_amount' => $amount_paid,

                                                                               'payment_date' => date('Y-m-d',time()),

                                                                               'payment_channel' => $this->input->get_post('payment_channel'),

                                                                               'desc' => "Payment for customer loan installment. ".$this->input->get_post('payment_description'),


                                                                        );

                                                                        $debit_trans  = array(

                                                                        	    'object' => $this->sys_object->findBy(array('name'=>'payment'))->row(0,'systemobject_model')->id,

                                                            			  		'transaction_code' => $payment->transaction_code,

                                                            			  		'account' => $collection_account->id,

                                                            			  		'transactiontype' => 1,

                                                            			  		'description' => "Payment for customer loan installment. ".$this->input->get_post('payment_description'),


                                                            			  		'date' => date('Y-m-d',time()),

                                                            			  		'amounttransacted' => $amount_paid,

                                                            			  		'user' => $this->session->userdata('userid'),

                                                                        );

                                                                        $credit_trans = array(

                                                                        	    'object' => $this->sys_object->findBy(array('name'=>'payment'))->row(0,'systemobject_model')->id,

                                                            			  		'transaction_code' => $payment->transaction_code,

                                                            			  		'account' => $customer_account->id,

                                                            			  		'transactiontype' => 0,

                                                            			  		'description' => "Payment for customer loan installment. ".$this->input->get_post('payment_description'),

                                                            			  		'date' => date('Y-m-d',time()),

                                                            			  		'amounttransacted' => $amount_paid,

                                                            			  		'user' => $this->session->userdata('userid'),

                                                                        );

                                                                        
                                                                        if($this->transaction->create($debit_trans) && $this->transaction->create($credit_trans)){

                                                                        		if($this->payment->create($payment_made)){

                                                                        			  if($payment->balance == 0 && $payment->interest_amount_balance == 0) $payment->paid = 1;
                                                                                         
                                                                        			  if($payment->update()){
																					  
																					       continue;

                                                                        			  }else{

                                                                        			  	   redirect(base_url().'loans/makepayment?message=Error recording payment. Please try again&message_type=warning');

                                                                        			  }

                                                                        		}else{
                                                                        		        redirect(base_url().'loans/makepayment?message=Error recording payment. Please try again&message_type=warning');

                                                                        			  

                                                                        		}

                                                                        }else{

	                                                            		       redirect(base_url().'loans/makepayment?message=Error recording transactions. Please try again&message_type=warning');

                                                                        }
                                                    			  }

                                                            }

                                                    }else{
													
															if($charges->num_rows() <= 0){

																 /*if($loan->loan_balance_amount > 0 && $payment_amount > 0){
                                                                         
                                                                          $loan->loan_balance_amount -= $payment_amount;

																 }
															
															     if($loan->loan_balance_amount <= 0) {

															     	$loan->loan_balance_amount=0;$loan->loan_status = 1;

															     }*/

															      $loan->loan_status = 1;
																 
																 if($loan->update()) redirect(base_url().'loans/makepayment/?message=Loan item has been settled&message_type=success');
																 
																 redirect(base_url().'loans/makepayment/?message=Error closing loan item. Please try again&message=warning');
															
															}
													
													}
											     
																					  
													$customer_account->update();
													
													$collection_account->update();
													
													$charges = $this->loan_charge->findBy(array('loan'=>$loan->id,'paid'=>0));
   
                   
													if($loan->loan_balance_amount <= 0 && $charges->num_rows() <= 0){
													
													     $loan->loan_balance_amount = 0;

														 $loan->loan_status = 1;

													} 
													  
													$loan->update();

			        	  				}else{

			        	  					redirect(base_url().'loans/makepayment?message=Loan item not found&message_type=warning');

			        	  				}
			        	  	    }else{

			        	  	    	  redirect(base_url().'loans/makepayment?message=Error minimum action requirement not met. Please select a loan to make payment for&message_type=warning');


			        	  	    }


	        	  }else{

			 	          redirect(base_url().'loans/loansissued/?message=Error minimum requirements for action not met&message_type=warning');
                  
                  }
				  
				  
				  
				  
				  if($loan->loan_status == 1)redirect(base_url().'loans/makepayment/?message=Loan item has been settled&message_type=success');

				  //send sms and email

				  redirect(base_url().'loans/makepayment/?message=Payments made successfully!&message_type=success');


	        }

			public function pay1(){
					$this->load->model('pay_model');
					$this->load->model('reminders_model');
					$this->load->model('loan_transactions_model');
					
					$payment_amount    = $this->input->get_post('payment_amount');
					$total_pay_amount  = $payment_amount;
					$payment_code = '';
					if($this->input->get_post('make_payment')){
						$loan_id = (int) $this->input->get_post('loan_id');
						if($loan_id <= 0){
							redirect(base_url().'loans/makepayment?message=Invalid loan. Please retry!&message_type=warning');
						}
						$payment_channel = $this->input->get_post('payment_channel');
						$payment_description = $this->input->get_post('payment_description');
						if($loan_id){
							$loan = $this->pay_model->get_loan($loan_id);
							$transaction_code = $loan['transaction_code'];
							if($loan['loan_status'] == 1)  redirect(base_url().'loans/makepayment/?message=Loan item was settled&message_type=success'); 
			  				if(null != $loan){
								if($this->input->get_post('payment_channel') != 'cheque'){
									//Mombo account affected Chase Account 
									$mombo_account = $this->pay_model->get_affected_account('Collection Account');
								}else{
									//Mombo account affected Collection Account 
									$mombo_account = $this->pay_model->get_affected_account('Chase Account');
								}
								
								$payment_code = $loan_id.''.date('siHdmY').''.$loan['customer'];
								
								//Customer's details
								$customer_account = $this->pay_model->get_customer_account($loan['customer']);
								$customer = $this->pay_model->get_customer_details($loan['customer']);
								$customer_msisdn = $customer['mobiletel'];
								$customer_fname = $customer['name'];
								//loan charges
								$charges = $this->pay_model->get_charges($loan_id);
								
								//other payments i.e. installment and interest fee
								$payments = $this->pay_model->get_expected_payments($loan_id);	
								
								$total_charges_amt_paid = 0;
								$total_interest_amt_paid = 0;
								$total_installment_amt_paid = 0;
								
								if($payment_amount != 0){
									$date = date('Y-m-d',time());
									$user = $this->session->userdata('userid');
									if($charges != 0){
										foreach($charges as $charge){
											if($payment_amount > 0){//2
												$amount_paid = 0;
												$charge_balance = $charge['balance'];
												$isPaid = 0;
												if($charge_balance >= $payment_amount){
													$amount_paid = $payment_amount;
													$total_charges_amt_paid += $amount_paid;
													$payment_amount = 0;
													$charge_balance -= $amount_paid;
												}else{
			                           	      	    $amount_paid = $charge_balance;
													$total_charges_amt_paid += $amount_paid;
			                                        $payment_amount -= $charge_balance;
			                                        $charge_balance = 0;
				                           	    }
												if($charge_balance == 0){
													$isPaid = 1;
												}
												$this->pay_model->update_charge_balance($charge['id'], $amount_paid, $isPaid);
												$this->pay_model->insert_charge_payment($charge['id'],$date,$amount_paid,$payment_channel,$transaction_code,$payment_code);
												$description = "Payment for ".$charge['name']." charge. ".$this->input->get_post('payment_description');
												
												$this->pay_model->insert_transaction(3,$transaction_code,$customer_account,0,$description,$date,$amount_paid,$user,$payment_code);
												$this->pay_model->insert_transaction(3,$transaction_code,$mombo_account,1,$description,$date,$amount_paid,$user,$payment_code);
												$this->pay_model->update_account_balance($mombo_account,$amount_paid);
											}//end of if($payment_amount != 0) 2
										}//end of foreach($charges as $charge)
									}//end of if($charges != 0)
									
									if( ($payment_amount > 0) && ($payments != 0) ){
										
										foreach($payments as $payment){
											if($payment_amount > 0){//check for payment amount
												$amount_paid = 0;
												$points = 0;
												$interest_balance = $payment['interest_amount_balance'];
												$expected_id = $payment['id'];
												if($interest_balance != 0){
													if($interest_balance >= $payment_amount){
														if($interest_balance == $payment_amount){
															$this->pay_model->update_points($loan['customer'],$loan_id,$payment['interest_amount']);
														}
														$amount_paid = $payment_amount;
														$total_interest_amt_paid += $amount_paid;
														$payment_amount = 0;
														$interest_balance -= $amount_paid;
													}else{
														$this->pay_model->update_points($loan['customer'],$loan_id,$payment['interest_amount']);     
					                       	      	    $amount_paid = $interest_balance;
														$total_interest_amt_paid += $amount_paid;
					                                    $payment_amount -= $interest_balance;
					                                    $interest_balance  = 0;
													}
													
																										
													$description = "Payment for customer loan interest. ".$this->input->get_post('payment_description');
													$this->pay_model->update_interest_balance($expected_id, $amount_paid);
													$this->pay_model->insert_payment($payment['id'],$transaction_code,$amount_paid,$date,$payment_channel,$description,$payment_code,0);
													$this->pay_model->insert_transaction(3,$transaction_code,$customer_account,0,$description,$date,$amount_paid,$user,$payment_code);
													$this->pay_model->insert_transaction(3,$transaction_code,$mombo_account,1,$description,$date,$amount_paid,$user,$payment_code);
													$this->pay_model->update_account_balance($mombo_account,$amount_paid);
													$this->pay_model->update_loan_balance($loan_id,$amount_paid);
													$this->pay_model->update_customer_account($loan['customer'],$amount_paid);
												}
																						
												if($payment_amount > 0){
													$installment_balance = $payment['balance'];
													if($installment_balance != 0){
														$amount_paid = 0;
														if($installment_balance >= $payment_amount){
															$amount_paid = $payment_amount;
															$total_installment_amt_paid += $amount_paid;
															$payment_amount = 0;
															$installment_balance -= $amount_paid;
														}else{
						                       	      	    $amount_paid = $installment_balance ;
						                                    $payment_amount -= $installment_balance;
															$total_installment_amt_paid += $amount_paid;
						                                    $installment_balance = 0;
						                           	    }
														
														$paid = 0;
														if($installment_balance == 0){
															$paid = 1;
														}
														$description = "Payment for customer loan installment. ".$this->input->get_post('payment_description');
														$this->pay_model->update_installment_balance($expected_id, $amount_paid, $paid);
														$this->pay_model->insert_payment($payment['id'],$transaction_code,$amount_paid,$date,$payment_channel,$description,$payment_code,1);
														$this->pay_model->insert_transaction(3,$transaction_code,$customer_account,0,$description,$date,$amount_paid,$user,$payment_code);
														$this->pay_model->insert_transaction(3,$transaction_code,$mombo_account,1,$description,$date,$amount_paid,$user,$payment_code);
														$this->pay_model->update_account_balance($mombo_account,$amount_paid);
														$this->pay_model->update_loan_balance($loan_id,$amount_paid);
														$this->pay_model->update_customer_account($loan['customer'],$amount_paid);
													}
												}					
											}//end of if($payment_amount > 0){//check for payment amount
										}//end of foreach($payments as $payment)
									}//end of if( ($payment_amount > 0) && ($payments != 0) )
									
									$payment_channel_id = 0;
									if($payment_channel == 'cheque'){
										$payment_channel_id = 1;
									}
									elseif($payment_channel == 'mpesa'){
										$payment_channel_id = 2;
									}
									elseif($payment_channel == 'cash'){
										$payment_channel_id = 3;
									}
									$full_description = 'Payment channel: '.$payment_channel.'. Charges: KSH. '.$total_charges_amt_paid.'; Interest: KSH. '.$total_interest_amt_paid.'; Principal: KSH. '.$total_installment_amt_paid;
									$this->pay_model->add_full_payment($loan_id, $total_pay_amount,$payment_channel_id,$full_description,$payment_code);
									
									//add loan transaction
									$trans = 'Payment';
									$trans_description = $payment_channel.' '.$payment_description.'. Payment Code: '.$payment_code;
									$is_credit = 1;
							$this->loan_transactions_model->add_transaction($loan_id,$trans,$trans_description,$is_credit,$total_pay_amount);
									
									
									//loan charges
									$charges = $this->pay_model->get_charges($loan_id);
								
									//payments i.e. installment and interest fee
									$payments = $this->pay_model->get_expected_payments($loan_id);	
									
									$loan = $this->pay_model->get_loan($loan_id);
									$loan_balance_amount = $loan['loan_balance_amount'];
									
									$bouncing_cheques = $this->pay_model->get_bouncing_cheques($loan_id);
									$amount_to_use = $total_pay_amount;
									foreach($bouncing_cheques as $bouncing_cheque){
										$penalty_bal = $bouncing_cheque["penalty_bal"];
										$amount_bal = $bouncing_cheque["amount_bal"];
										$amount_to_pay_penalty = 0;
										if($penalty_bal != 0){
											if($amount_to_use >= $penalty_bal){
												$amount_to_pay_penalty += $penalty_bal;
												$amount_to_use -= $penalty_bal;
											}
											else{
												$amount_to_pay_penalty += $amount_to_use;
												$amount_to_use = 0;
											}
										}
										$amount_to_pay_amount = 0;
										if($amount_to_use >= $amount_bal){
											$amount_to_pay_amount += $amount_bal;
											$amount_to_use -= $amount_bal;
											$this->pay_model->update_bouncing_cheque($bouncing_cheque["id"],$amount_to_pay_penalty,$amount_to_pay_amount,1,$bouncing_cheque["all_payment_id"]);
										}
										elseif($amount_to_use > 0){
											$amount_to_pay_amount += $amount_to_use;
											$amount_to_use = 0;
											$this->pay_model->update_bouncing_cheque($bouncing_cheque["id"],$amount_to_pay_penalty,$amount_to_pay_amount,0,$bouncing_cheque["all_payment_id"]);
										}
									}
									
									if( ($charges == 0) && ($payments == 0) ){
																		
										$this->pay_model->update_loan_status($loan_id);
										$message = 'Dear '.$customer_fname.'. We acknowledge receipt of Kshs. '.$total_pay_amount.' loan payment. It is our pleasure doing business with you. Your loan has been fully settled.';
										send_sms($customer_msisdn,$message);
										$sent_date = date("Y-m-d");
										$this->reminders_model->set_sent_sms($customer_msisdn, $message, $sent_date);
										
										if($payment_amount > 0){
											$this->pay_model->update_account_balance($mombo_account,$payment_amount);
											redirect(base_url().'loans/makepayment/?message=Payment made successfully! Loan has been fully settled. Extra payment is Ksh '.$payment_amount.'&message_type=success');
										}
										else{
											redirect(base_url().'loans/makepayment/?message=Payment made successfully! Loan has been fully settled&message_type=success');
										}
									}
									else{
										$message = 'Dear '.$customer_fname.'. We acknowledge receipt of Kshs. '.$total_pay_amount.' loan payment. It is our pleasure doing business with you.';
										send_sms($customer_msisdn,$message);
										$sent_date = date("Y-m-d");
										$this->reminders_model->set_sent_sms($customer_msisdn, $message, $sent_date);
										
										redirect(base_url().'loans/makepayment/?message=Payment made successfully!&message_type=success');
									}
									
								}//end of if($payment_amount != 0)
								else{
									redirect(base_url().'loans/makepayment?message=You cannot make payment of Ksh 0.Please try again&message_type=warning');
								}
							}//end of if(null != $loan)
						}//end of if($loan_id)
					}//end of if($this->input->get_post('make_payment'))
				}//end of function pay1()

	        public function makepayment(){

	        	 $message 		            = $this->input->get_post('message');

	        	 $message_type 		        = $this->input->get_post('message_type');
 
	        	 $loans   			        = $this->loan->findBy(array('loan_status'=>0),array(0,20));

	        	 $this->page->title         = "Mombo Loan System | Make Payment";

	        	 $this->page->name      	= 'mombo-make-payment';

	        	 $this->msg['page'] 	 	= $this->page;

	        	 $this->msg['criteria']  	= '';

	        	 $this->msg['message']      = $message;

	        	 $this->msg['message_type'] = $message_type;

	        	 $this->msg['loans']     	= $loans;

	        	 $this->sendResponse($this->msg,array(

	        	 		$this->header => $this->msg,

	        	 		'mombo/templates/makepayment' => $this->msg,

	        	 		$this->footer => $this->msg,

	        	 ));  
	        }
			
			public function makeapayment(){
							
					$type     = strtolower($this->input->get_post('type'));
					
					$loan_id  = (int) $this->input->get_post('loan_id');
					
					$id       = 0;
					
                    $current_tab = 'loan_payments';
					
					$model    = null;
					
					$loan     = null;
					
					
					//redirect(base_url().'loans/loanpaymentsandcharges/?message=Under Development! Use the main Make Payment menu.&message_type=warning&current_tab='.$current_tab.'&loan_id='.$loan_id);
					
					
					switch($type){
							
							case 'payment': $id = (int) $this->input->get_post('payment_id'); $current_tab = 'loan_payments'; break;
							
							case 'charge' : $id = (int) $this->input->get_post('charge_id');  $current_tab = 'loan_charges'; break;
							
							default:break;
					
					}
					
					if($id && $loan_id){
					
								if($type == 'payment'){
								
								     $model = 'expected_payment';
								
								}elseif($type == 'charge'){
								
								     $model = 'loan_charge';
								
								}else{
									   redirect(base_url().'loans/loanpaymentsandcharges/?message=Error minimum action requirements not met&message_type=warning&current_tab='.$current_tab.'&loan_id='.$loan_id);
								
								}
								
								$item = $this->$model->findOne($id);
								
								$loan = $this->loan->findOne($loan_id);
								
								if(null != $item && null != $loan){
								       
									       if($this->input->post('make_payment')){
										          
												    if($this->input->get_post('payment_channel') != 'cheque'){
													
														$collection_account = $this->account->findOne($this->sys_option->findBy(array(
												
																'name'=>'loan_receipt_account'
																
														))->row(0,'systemoption_model')->value);
														
													}else{
													   
													    
														$collection_account = $this->account->findOne($this->sys_option->findBy(array(
												
																'name'=>'cheque_receipt_account'
																
														))->row(0,'systemoption_model')->value);
													
													}
													
													 $customer_account = $this->customer_account->findBy(array(
											
															'customer'=>$loan->customer->id,
															
													   ))->row(0,'customeraccount_model');
										   
										            $payment = $item;
													
													$amount_paid = 0;
										   
										            $payment_amount   = $this->input->get_post('payment_amount');
													
													$payment_channel  = $this->input->get_post('payment_channel');
													
													if(!is_numeric($payment_amount))redirect(base_url().'loans/makeapayment/?message=Please provide an numeric payment amount&message_type=warning&loan_id='.$loan_id.'&type='.$type.'&'.$type.'_id='.$payment->id);
													
													if(empty($payment_channel))redirect(base_url().'loans/makeapayment/?message=Please provide a payment channel&message_type=warning&loan_id='.$loan_id.'&type='.$type.'&'.$type.'_id='.$payment->id);
													
													if($payment->balance >= $payment_amount){
															
															$payment->balance -= $payment_amount;
															
															$amount_paid       = $payment_amount;
															
															$payment_amount    = 0;
													
													
													}else{
															
															$amount_paid       = $payment->balance;
													
													        $payment_amount   -= $payment->balance;
															
															$payment->balance  = 0;
													}
													
													
													$collection_account->account_balance += $amount_paid;
													
													$customer_account->balance -= $amount_paid;
										   
													if($type == 'payment'){
													
													         $interest_amount = $payment->interest_amount_balance;
															 
															 $int_amount_paid = 0;
															
															 if($interest_amount > 0 && $payment_amount > 0){
															 
																		if($payment->interest_amount_balance >= $payment_amount){
																		
																				$payment->interest_amount_balance -= $payment_amount;
																				
																				$int_amount_paid = $payment_amount;
																		
																		}else{
																		
																		        $payment_amount -= $payment->interest_amount_balance;
																				
																				$int_amount_paid     = $payment->interest_amount_balance;
																				
																				$payment->interest_amount_balance = 0;
																		
																		}
																		
																		
																		$interest_payment = array(
																		
																				 'transaction_code' => $payment->transaction_code,
																 
																				 'payment'=> $payment->id,
																				 
																				 'payment_amount' => $int_amount_paid,
																				 
																				 'payment_date' => date('Y-m-d',time()),
																				 
																				 'payment_channel' => $payment_channel,
																				 
																				 'desc' => "Payment for customer loan interest. ".$this->input->get_post('payment_description'),

																		
																		);
																		
																		$interest_debit_transaction = array(
																		
																				'object' => $this->sys_object->findBy(array('name'=>'payment'))->row(0,'systemobject_model')->id,

                                                            			  		'transaction_code' => $payment->transaction_code,

                                                            			  		'account' => $collection_account->id,

                                                            			  		'transactiontype' => 1,

                                                            			  		'description' => "Payment for customer loan interest. ".$this->input->get_post('payment_description'),


                                                            			  		'date' => date('Y-m-d',time()),

                                                            			  		'amounttransacted' => $int_amount_paid,

                                                            			  		'user' => $this->session->userdata('userid'),
																		
																		
																		);
																		
																		$interest_credit_transaction = array(
																		        'object' => $this->sys_object->findBy(array('name'=>'payment'))->row(0,'systemobject_model')->id,

                                                            			  		'transaction_code' => $payment->transaction_code,

                                                            			  		'account' => $customer_account->id,

                                                            			  		'transactiontype' => 0,

                                                            			  		'description' => "Payment for loan interest. ".$this->input->get_post('payment_description'),


                                                            			  		'date' => date('Y-m-d',time()),

                                                            			  		'amounttransacted' => $int_amount_paid,

                                                            			  		'user' => $this->session->userdata('userid'),
																		        
																		);
																		
																		
																		$payment_made = $this->payment->create($interest_payment);
																		
																		$int_debited      = $this->transaction->create($interest_debit_transaction);
																		
																		$int_credited     = $this->transaction->create($interest_credit_transaction);
																		
																		if(!$payment_made && !$int_debited && !$int_credited){
																		  
																		    redirect(base_url().'loans/makeapayment/?message=Error recording payment. Please try again&message_type=warning&loan_id='.$loan_id.'&'.$type.'&'.$type.'_id='.$payment->id);
																		
																		}
																		
																		$loan->loan_balance_amount -= $int_amount_paid;
																		
																		$collection_account->account_balance += $int_amount_paid;
																		
																		$customer_account->balance -= $int_amount_paid;
																		
																		$points = floor($int_amount_paid / 500);
																		
																		$loan->customer->loyaltypoints = $points;
																		
																		$loan->customer->update();
																		
																		
																		
															 
															 }
															 
															 
														  $loan_payment = array(
																
																 'transaction_code' => $payment->transaction_code,
																 
																 'payment'=> $payment->id,
																 
																 'payment_amount' => $amount_paid,
																 
																 'payment_date' => date('Y-m-d',time()),
																 
																 'payment_channel' => $payment_channel,
																 
																 'desc' => "Payment for customer loan installment. ".$this->input->get_post('payment_description'),

														  
														  );
														  
														  $loan->loan_balance_amount -= $amount_paid;
															 
														  if(!$this->payment->create($loan_payment)){
																redirect(base_url().'loans/makeapayment/?message=Error recording payment. Please try again&message_type=warning&loan_id='.$loan_id.'&'.$type.'&'.$type.'_id='.$payment->id);
														  
														  }
															 
														  if($payment->balance == 0 && $payment->interest_amount_balance == 0) $payment->paid = 1;
													
													}elseif($type == 'charge'){
													
														  if($payment->balance == 0) $payment->paid = 1;
														  
														  if(!$this->charge_payment->create(array(
																	
																	'charge' => $payment->id,
																	
																	'date' => date('Y-m-d',time()),
																	
																	'amount' => $amount_paid,
																	
																	'channel' => $payment_channel,
																	
																	'transaction_code' => $payment->transaction_code,
														  
														   ))){
														   
														        redirect(base_url().'loans/makeapayment/?message=Error recording payment. Please try again&message_type=warning&loan_id='.$loan_id.'&'.$type.'&'.$type.'_id='.$payment->id);
																
														   }
														   
														  
													
													}
													
													$object = 'payment';
													
													$description_object = " installment";
													
													if($type == 'charge'){
													
													    $object = 'charge';
														
														$description_object = $payment->name;
														
												    }
													
													$payment_debit_transaction   = array(
													
															'object' => $this->sys_object->findBy(array('name'=>$object))->row(0,'systemobject_model')->id,

															'transaction_code' => $payment->transaction_code,

															'account' => $collection_account->id,

															'transactiontype' => 1,

															'description' => "Payment for loan ".$description_object.". ".$this->input->get_post('payment_description'),


															'date' => date('Y-m-d',time()),

															'amounttransacted' => $amount_paid,

															'user' => $this->session->userdata('userid'),
													);
													
													$payment_credit_transaction  = array(
															
															'object' => $this->sys_object->findBy(array('name'=>$object))->row(0,'systemobject_model')->id,

															'transaction_code' => $payment->transaction_code,

															'account' => $customer_account->id,

															'transactiontype' => 0,

															'description' => "Payment for loan ".$description_object.". ".$this->input->get_post('payment_description'),


															'date' => date('Y-m-d',time()),

															'amounttransacted' => $amount_paid,

															'user' => $this->session->userdata('userid'),
													
													);
													
													$debited    = $this->transaction->create($payment_debit_transaction);
													
													$credited   = $this->transaction->create($payment_credit_transaction);
													
													if(!$debited && !$credited)redirect(base_url().'loans/makeapayment/?message=Error recording transactions. Please try again&message_type=warning&loan_id='.$loan_id.'&'.$type.'&'.$type.'_id='.$payment->id);
													
												    if($payment->update()){
													
													          
																		
															  $collection_account->update();
																		
															  $customer_account->update();
													
															  $charges = $this->loan_charge->findBy(array('loan'=>$loan->id,'paid'=>0));

															   
															  if($loan->loan_balance_amount <= 0 && $charges->num_rows() <= 0){

																    $loan->loan_balance_amount  = 0;
																	
																	$loan->loan_status = 1;

															  } 

															  $loan->update();
															  
															  if($loan->loan_status == 1)redirect(base_url().'loans/loanpaymentsandcharges/?message=Loan item has been settled&message_type=success');
															 
															   //send sms and email
															  redirect(base_url().'loans/loanpaymentsandcharges/?message=Payment made successfully &message_type=success&current_tab='.$current_tab.'&loan_id='.$loan_id);
												
												    }else{
													
													    redirect(base_url().'loans/makeapayment/?message=Error recording payment. Please try again&message_type=warning&loan_id='.$loan_id.'&'.$type.'&'.$type.'_id='.$payment->id);
													
													}
										   
										   }else{
										   
												$this->$model = $item;
										   
										   }
										  
								}else{
								        
										redirect(base_url().'loans/loanpaymentsandcharges/?message=Error minimum action requirements not met&message_type=warning&current_tab='.$current_tab.'&loan_id='.$loan_id);
								
								}
					
					}else{
					
					     if($type== 'charge') $current_tab = 'loan_charges';
						 
						 if(!$loan_id) $loan_id = rand(5,20);
						 
						 redirect(base_url().'loans/loanpaymentsandcharges/?message=Error minimum action requirements not met&message_type=warning&current_tab='.$current_tab.'&loan_id='.$loan_id);
					
					}
					
					
					$this->page->title         = "Mombo Loan System | Make Payment";
					
					$this->page->name          = 'mombo-make-a-payment';
					
					$this->msg['page']         = $this->page;
					
					$this->msg['criteria']     = '';
					
					$this->msg['message']      = $this->input->get_post('message');
					
					$this->msg['message_type'] = $this->input->get_post('message_type');
					
					$this->msg['item']         = $this->$model;
					
					$this->msg['type']         = $type;
					
					$this->msg['loan']         = $loan;
 					
					$this->sendResponse($this->msg,array(
					   
					      $this->header => $this->msg,
						  
						  'mombo/templates/makeapayment' => $this->msg,
						  
						  $this->footer => $this->msg,
					
					));
			}
			
			public function waivercharge(){
					$this->load->model('loan_transactions_model');
					$charge_id     = (int) $this->input->get_post('charge_id');
					
					$loan_id       = (int) $this->input->get_post('loan_id');
					
					$message       = $this->input->get_post('message');
					
					$message_type  = $this->input->get_post('message_type');
					
					if(!$charge_id && !$loan_id) redirect(base_url().'loans/loansissued/?message=Error. action minimum requirements not met&message_type=warning');
					
					$charge = $this->loan_charge->findOne($charge_id);
					
					$loan   = $this->loan->findOne($loan_id);
					
					if(null == $charge || $loan == null)redirect(base_url().'loans/loansissued/?message=Error. charge item not found&message_type=warning');
					
					if($this->input->get_post('waiver_charge')){
					
							$waiver_amount    = $this->input->get_post('waiver_amount');
							
							$charge->waiver  += (float) $waiver_amount;
							
							$charge->balance -= (float) $waiver_amount;
							
							if($charge->balance == 0) $charge->paid = 1;
							
							if($charge->update()){
							
                                $charges = $this->loan_charge->findBy(array('loan'=>$loan->id, 'paid'=>0));
								
								if($loan->loan_balance_amount <= 0 && $charges->num_rows() <= 0 && $loan->loan_status == 0){
								
										$loan->loan_status = 1;
										
										$loan->update();
								
								}
								foreach($charge->result('charge_model') as $c){
										$charge_name = $c->name;
									}
								//add loan transaction
								$trans = 'Waiver for '.$charge->name; 
								$trans_description = '-';
								$is_credit = 1;
								$amount = (float) $waiver_amount;
								$this->loan_transactions_model->add_transaction($loan_id,$trans,$trans_description,$is_credit,$amount);

								//send sms and email
								
								redirect(base_url().'loans/loanpaymentsandcharges/?message=Charge successfully waived!&message_type=success&current_tab=loan_charges&loan_id='.$loan->id);
								
						    }
							
							$message      = "Error updating charge waiver. Please try again";
							
							$message_type =  'warning';
			
					}
					 
					$this->page->title          = "Mombo Loan System | Waiver Charge";
					
					$this->page->name           = 'mombo-waiver-charge';
					
					$this->msg['page']          = $this->page;
					
					$this->msg['criteria']      = '';
					
					$this->msg['message']       = $message;
					
					$this->msg['message_type']  = $message_type;
					
					$this->msg['loan']          = $loan;
					
					$this->msg['charge']        = $charge;
					
					$this->sendResponse($this->msg,array(
					
							$this->header => $this->msg,
							
							'mombo/templates/waivercharge'=>$this->msg,
							
							$this->footer => $this->msg,
					));
			}
			
			public function chargefeeonloan(){
			
			      $loan            = (int) $this->input->get_post('loan_id');
				  
				  $charge          = $this->input->get_post('charge');
				  
				  $charge_amount   = $this->input->get_post('charge_amount');
				  
				  $message         = null;
				  
				  $message_type    = null;
				  
				  
				  if($loan){
					  
						 $loan  = $this->loan->findOne($loan);
						 
						 if($loan != null){
						 
								 $this->loan = $loan;
								  
								 if($this->input->get_post('charge_loan')){
								 
											 if($charge && in_array($charge,array('upaidcheque_fee','latepayment_fee','transaction_fee','interest_fee','service_fee'))){
											  
														if($charge_amount && is_numeric($charge_amount)){
														
																		 $current_time_stamp = time();
																		 
																		 $customer_account   = $this->customer_account->findBy(array(
																		 
																				'customer' => $loan->customer->id
																				
																		 ))->row(0,'customeraccount_model');

																		 $d_charge = $charge;
														
																		 $charge = array(
																		 
																				'transaction_code' => $loan->transaction_code,
																				
																				'name' => $d_charge,
																				
																				'loan' => $loan->id,
																				
																				'date' => date('Y-m-d',$current_time_stamp),
																				
																				'amount' => $charge_amount,
																				
																				'balance' => $charge_amount,
																				
																				'paid'=>0,
																		 
																		 );
																		 
																		 $debit_transaction = array(
																
																				'object' => $this->sys_object->findBy(array('name'=>'charge'))->row(0,'systemobject_model')->id,

																				'transaction_code' => $loan->transaction_code,

																				'account' => $loan->customer->id,

																				'transactiontype' => 1,

																				'description' => $d_charge.$this->input->get_post('charge_description'),

																				'date' => date('Y-m-d',$current_time_stamp),

																				'amounttransacted' => $charge_amount,

																				'user' => $this->session->userdata('userid'),
																		);
																		
																		$customer_account->balance += $charge_amount;
																		
																		$loan->loan_status = 0;

																		$c_updated = $customer_account->update();

																		$l_updated = $loan->update();
																		
																		if($c_updated && $l_updated){

																			   $ch_created = $this->loan_charge->create($charge);

																			   $t_created = $this->transaction->create($debit_transaction);
																		
																			   if($ch_created && $t_created){
																			   
																						//send sms and email
																						redirect(base_url().'loans/loansissued/?message=Loan charged successfully!&message=success');
																			   
																			   }
																		
																		}
																		
																		$message      = "Error. Applying charge to loan. Please try again";
																		
																		$message_type  = 'warning';
														
														}else{
														
																$message = "Please provide a valid charge amount";
										   
																$message_type = "warning";
														
														}
										  
										  
										  }else{
										  
												 $message = "Charge item type not found. Please correct your inputs and try again";
									   
												 $message_type = "warning";
										  
										  }
										  
									}
							}else{
							
									redirect(base_url().'loans/loansissued/?message=Error. Loan item not found or doesnt exists&message=warning');
							}
				   
					  }else{
						   
						   redirect(base_url().'loans/loansissued/?message=Error. Action minimum requirement not met.Please try again&message=warning');
					  }
					  
				  
				  $this->page->title             =  "Mombo Loan System | Charge Loan";
				  
				  $this->page->name              = 'mombo-charge-loan';
				  
				  $this->msg['page']             = $this->page;
				  
				  $this->msg['message']			 = $message;
				  
				  $this->msg['message_type']     = $message_type;
				  
				  $this->msg['loan']             = $this->loan;
				  
				  $this->sendResponse($this->msg,array(
				  
							$this->header => $this->msg,
							
							'mombo/templates/chargeloan' => $this->msg,
							
							$this->footer => $this->msg,
				  ));
			}
			
			public function reschedulepayment(){
			
			      $payment_id = (int) $this->input->get_post('payment_id');
				  
				  $loan_id    = (int) $this->input->get_post('loan_id');
				  
				  if(!$payment_id && !$loan_id) redirect(base_url().'loans/loansissued/?message=Error. Action minimum requirement not met.Please try again&message_type=warning');
				  
				  $payment   = $this->expected_payment->findOne($payment_id);
				  
				  $loan      = $this->loan->findOne($loan_id);
				  
				  if(!$payment && !$loan) redirect(base_url().'loans/loansissued/?message=Error. Payment item or loan item not found&message_type=warning');
				  
				  if($this->input->get_post('reschedule_payment')){
				  
							$new_date                 = $this->input->get_post('new_date');
							
							$expected_payments        = $this->expected_payment->findWhere('date_expected >',$payment->date_expected);
							
							$customer_account         = $this->customer_account->findBy(array('customer'=>$loan->customer->id))->row(0,'customeraccount_model');
							
							$payment->date_expected   = $new_date;
							
							$current_time_stamp       = time();
							
							$new_time_stamp           = date_create($payment->date_expected)->getTimestamp();
							
							$loan_repayment_frequency = $loan->loan_product->loan_repayment_frequency;
							
							$days = 0;
							
							switch($loan_repayment_frequency){
							
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
							
							
							foreach($expected_payments->result('expectedpayment_model') as $pay){
							
								      $new_time_stamp += ($days * 24 * 60 * 60);
									  
									  $pay->date_expected = date('Y-m-d',$new_time_stamp);
									  
									  //$pay->update();
							
							}
							$reschedulement_fee   = $loan->getReschedulementFee();
							
							$customer_account->balance += $reschedulement_fee;
							
							$charge = array(
												   
									'transaction_code' => $loan->transaction_code,
									
									'name' => 'reschedulment_charge',
									
									'loan' => $loan->id,
									
									'date' => date('Y-m-d',$current_time_stamp),
									
									'amount' => $reschedulement_fee,
									
									'balance' => $reschedulement_fee,
									
									'paid'=>0,
							 
							);
							
							$debit_transaction =  array(
							
									'object' => $this->sys_object->findBy(array('name'=>'charge'))->row(0,'systemobject_model')->id,

									'transaction_code' => $loan->transaction_code,

									'account' => $customer_account->id,

									'transactiontype' => 1,

									'description' => "Payment reschedulement fee for payment expected on ".$payment->date_expected,

									'date' => date('Y-m-d',time()),

									'amounttransacted' => $reschedulement_fee,

									'user' => $this->session->userdata('userid'),
							
							
							);
							
							//if(!$this->loan_charge->create($charge) && !$this->transaction->create($debit_transaction))redirect(base_url().'loans/loanpaymentsandcharges/?message=Error updating loan charges&message_type=warning&loan_id='.$loan->id);
							
							if($payment->update() /* && $customer_account->update() */){

								 //send sms and email

								 redirect(base_url().'loans/loanpaymentsandcharges/?message=Loan payment rescheduled successfully!&message_type=success&loan_id='.$loan->id);
							
							}

							$_POST['message']      = "Error rescheduling loan. Please try again";
							
							$_POST['message_type'] = 'warning';
				  
				  
				  }
				  
				  $this->page->title         = "Mombo Loan System | Reschedule Payment";
				  
				  $this->page->name           = 'mombo-reschedule-payment';
				  
				  $this->msg['page']          = $this->page;
				  
				  $this->msg['criteria']      = '';
				  
				  $this->msg['message']       = $this->input->get_post('message');
				  
				  $this->msg['message_type']  = $this->input->get_post('message_type');
				  
				  $this->msg['payment']       = $payment;
				  
				  $this->msg['loan']          = $loan;
				  
				  $this->sendResponse($this->msg,array(
				  
				        $this->header => $this->msg,
						
						'mombo/templates/rescheduleloan' => $this->msg,
						
						$this->footer => $this->msg,
				  
				  ));
				  
				  
			}
			
			public function loanpayments($p_code = 0, $p_c_id = 0,$loan_id){//$p_code => payment code, $p_c_id => payment channel id
				 $this->load->model('chargestotalpayment_model'); 
				 $this->load->model('penalties_model');
				 $this->load->model('loan_transactions_model');
				 
			     $payments = array();
				 
				 $expectedpayments = array();

				 if($this->input->get_post('start_date') && $this->input->get_post('end_date')){
				 		
					   $start_date = $this->input->get_post('start_date').' 00:00:00';
					   $end_date = $this->input->get_post('end_date').' 23:59:59';
                      
                       $payments = $this->chargestotalpayment_model->get_filtered_payments($start_date,$end_date);

				 	   $expectedpayments = $this->chargestotalpayment_model->get_filtered_expected_payments($this->input->get_post('start_date'),$this->input->get_post('end_date'));

				 }else{
				 	 if($p_code != 0 && $p_c_id == 1){
					 	
					 	$total_cheque_amount = $this->chargestotalpayment_model->get_cheque_amount($p_code);
						
					 	$total_amount = 0;
					 	$payments_to_cancel = $this->chargestotalpayment_model->get_payments_to_cancel($p_code);
						foreach($payments_to_cancel as $payment_to_cancel){
							$payment_expected_id = $payment_to_cancel['payment'];
							$amount_to_cancel = $payment_to_cancel['payment_amount'];
							$for_principal = $payment_to_cancel['for_principal'];
							$total_amount += $amount_to_cancel;
							if($this->chargestotalpayment_model->update_expected_payment($payment_expected_id,$amount_to_cancel,$for_principal) == -1){
								echo 'error occured!!'; exit;
							}
							else{
								if($this->chargestotalpayment_model->update_loan_status($p_code,$amount_to_cancel) == -1){
									echo 'error occured here!!!'; exit;
								}
								
							}
						}
						
						$charges_payments_to_cancel = $this->chargestotalpayment_model->get_charges_payments_to_cancel($p_code);
						foreach($charges_payments_to_cancel as $charge_payment_to_cancel){
							$charge_id = $charge_payment_to_cancel['charge'];
							$amount_to_cancel = $charge_payment_to_cancel['amount'];
							$total_amount += $amount_to_cancel;
							if($this->chargestotalpayment_model->update_charge_payment($charge_id,$amount_to_cancel) == -1){
								echo 'error occured here!!'; exit;
							}
						}
						if($total_cheque_amount != 0){
							$this->chargestotalpayment_model->modify_loan_status($loan_id,0);
							$cheque_penalty_constants = $this->chargestotalpayment_model->get_cheque_constants();
							$fixed_penalty_amount = $cheque_penalty_constants['fixed_amount'];
							$varied_penalty_amount = round( ($cheque_penalty_constants['percent']*$total_cheque_amount),2);
							$bouncing_cheque_penalty = $fixed_penalty_amount + $varied_penalty_amount;
							$bouncing_cheque_penalty = round($bouncing_cheque_penalty);
							
							$all_payment_id = $this->chargestotalpayment_model->get_all_payment_id($p_code);
							if($this->chargestotalpayment_model->add_bouncing_cheque($all_payment_id,$loan_id,$total_cheque_amount,$bouncing_cheque_penalty) == -1){
								echo 'error occured here.'; exit;
							}
							
							
							if($this->chargestotalpayment_model->add_bouncing_penalty($p_code,$bouncing_cheque_penalty) == -1){
								echo 'error occured here.'; exit;
							}
							else{
								if($bouncing_cheque_penalty > 0){
									$total_amount_cust = $total_cheque_amount + $bouncing_cheque_penalty;
									$customer_id = $this->chargestotalpayment_model->update_customer_balance($p_code,$total_amount_cust);
									$customer = $this->chargestotalpayment_model->get_customer_name($customer_id);															$customer_first_name = $customer["name"];
									$customer_mobile = $customer["mobiletel"];
									$message = 'Dear '.$customer_first_name.', kindly be advised that your cheque payment of KSH. '.$total_cheque_amount.' has been dishonoured.';
																		
									send_sms($customer_mobile,$message);
									
									$sent_date = date("Y-m-d");
									$this->penalties_model->set_sent_sms($customer_mobile, $message, $sent_date);
									
									//echo $customer_mobile.' '.$message; 
									
									$message = 'Dear '.$customer_first_name.', kindly be advised that your loan has accrued a dishonoured cheque penalty of KSH. '.$bouncing_cheque_penalty.'. Remit your payment immediately.';
									
									send_sms($customer_mobile,$message);
									
									$sent_date = date("Y-m-d");
									$this->penalties_model->set_sent_sms($customer_mobile, $message, $sent_date);
									
									//echo $customer_mobile.' '.$message; 
								}
							}
							
							if($this->chargestotalpayment_model->update_bank_balance($total_cheque_amount) == -1){
								echo 'error occured here!!!!'; exit;
							}
							else{
								$this->chargestotalpayment_model->update_payment_history($p_code);
								
								$this->msg['message_type'] = 'success';
								$this->msg['message'] = 'Payment has been cancelled!';
							}	
							
							//add loan transaction
							$trans = 'Dishonoured Cheque'; 
							$trans_description = '-';
							$is_credit = 0;
							$this->loan_transactions_model->add_transaction($loan_id,$trans,$trans_description,$is_credit,$total_cheque_amount);
							$trans = 'Bounced Cheque Fee'; 
							$trans_description = '-';
							$is_credit = 0;
							$this->loan_transactions_model->add_transaction($loan_id,$trans,$trans_description,$is_credit,$bouncing_cheque_penalty);
						
								
						}
					 }
					 
					 $payments =  $this->chargestotalpayment_model->get_all_payments();
					 
				 	 $expectedpayments =  $this->chargestotalpayment_model->get_expected_payments();
				 }
				 
				 $this->page->title               = "Mombo Loan System | Payments";
				 
				 $this->page->name                = 'mombo-loan-payments';
				 
				 $this->msg['page']               = $this->page;
				 
				 $this->msg['payments']           = $payments;
				 
				 $this->msg['expectedpayments']   = $expectedpayments;
				 
				 $this->sendResponse($this->msg,array(
					
					    $this->header => $this->msg,
						
						'mombo/templates/payments' => $this->msg,
						
						$this->footer => $this->msg,
				 
				 ));
			
			
			}
			
			public function loansdenied(){
			
				 $loans = $this->loan->findBy(array('request_status' => 3));
				 
				 $this->page->title      = "Mombo Loan System | Denied Loan Requests";
				 
				 $this->page->name       = 'mombo-loan-payments';
				 
				 $this->msg['page']      = $this->page;
				 
				 $this->msg['loans']     = $loans;
				 
				 $this->sendResponse($this->msg,array(
					
					    $this->header => $this->msg,
						
						'mombo/templates/deniedloans' => $this->msg,
						
						$this->footer => $this->msg,
				 
				 ));
			
			}
			
			public function collateralsandgaurantors(){
			
			     $collaterals = $this->collateral->findAll();
				 
				 $gaurantors  = $this->gaurantor->findAll();
				 
				 $this->page->title        = "Mombo Loan System | Collateral & Gaurantors";
				 
				 $this->page->name         = 'mombo-collaterals-gaurantors';
				 
				 $this->msg['page']        = $this->page;
				 
				 $this->msg['collaterals'] = $collaterals;
				 
				 $this->msg['gaurantors']  = $gaurantors;
				 
				 $this->sendResponse($this->msg,array(
						
						$this->header => $this->msg,
						
						'mombo/templates/collateralandgaurantors' => $this->msg,
						
						$this->footer => $this->msg,
				 ));
			}

			public function penalties(){

				   $penalties  = array();

				    if($this->input->get_post('start_date') && $this->input->get_post('end_date')){

                       $start_date  = date_create($this->input->get_post('start_date'));

                       $end_date    = date_create($this->input->get_post('end_date'));

                       $start_date  = $start_date->getTimestamp();

                       $end_date    = $end_date->getTimestamp();

                       $rpenalties  = $this->loan_charge->findAll();

                       foreach($rpenalties->result('charge_model') as $charge){

                       		 $timestamp = date_create($charge->date)->getTimestamp();

                       		 if($timestamp >= $start_date && $timestamp <= $end_date){

                       		 	  $penalties[$charge->id] = $charge;

                       		 }

                       }

				   }else{

				   	    $penalties  = $this->loan_charge->findAll()->result('charge_model');
 
				   }

				   $this->page->title       = "Mombo Loan System | Penalties";

				   $this->page->name  		= 'mombo-loans-penalties';

				   $this->msg['page'] 		= $this->page;

				   $this->msg['penalties']  = $penalties;

				   $this->sendResponse($this->msg,array(

				   		$this->header => $this->msg,

				   		'mombo/templates/penalties'=>$this->msg,

				   		$this->footer=>$this->msg,

				   ));

			}
			
			
			public function debtsrecovery(){
				$this->load->model('debtcollection_model');
				
				$customers = array();
				$debts_amounts = array();
				$loan_ids = array();
				$expected_ids = $this->debtcollection_model->get_debt_expected_ids();
				foreach($expected_ids as $expected_id){
					$expected_initial_payment = $this->debtcollection_model->get_initial_expected($expected_id['expected_id']);
					$loan_id = $expected_initial_payment['loan'];
					if( ! (in_array($loan_id,$loan_ids)) ){
					 	 $loan_ids[] = $loan_id;
						 $charges_amount = 0;
						 $expected_charges_payments = $this->debtcollection_model->get_charges($loan_id);
						 foreach($expected_charges_payments as $expected_charge_payment){
						 	$charges_amount += $expected_charge_payment['balance'];
						 }
						 $debts_amounts[$loan_id] = $expected_initial_payment['balance'] + $expected_initial_payment['interest_amount_balance'] + $charges_amount;
						 $loan_details = $this->debtcollection_model->get_loan_product($loan_id);
						 $customer_id = $loan_details['customer'];
						 $customer_details = $this->debtcollection_model->get_customer($customer_id);
						 $customer_name = $customer_details['name'].' '.$customer_details['other_names'];
						 $customer_mobile = $customer_details['mobiletel'];
						 $customers[$loan_id] = $customer_id.'*'.$customer_name.'*'.$customer_mobile;
					 }
					 else{
					 	$debts_amounts[$loan_id] += $expected_initial_payment['balance'] + $expected_initial_payment['interest_amount_balance'];
					 }
				}
				
				$unpaid_cheques = $this->debtcollection_model->get_unpaid_cheques(); 
								 
				$this->page->title      = "Mombo Loan System | Debts Recovery Unit";
				 
				$this->page->name       = 'mombo-debt-recovery';
				 
				$this->msg['page']      = $this->page;
				 
				$this->msg['loan_ids'] = $loan_ids;
				$this->msg['customers'] = $customers;
				$this->msg['debts_amounts'] = $debts_amounts;
				$this->msg['unpaid_cheques'] = $unpaid_cheques;
				 
				$this->sendResponse($this->msg,array(
					
			    	$this->header => $this->msg,
						
						'mombo/templates/debts' => $this->msg,
						
						$this->footer => $this->msg,
				 
				));
			
			}
			
			public function settle_reward($redeemed_id = 0){
				$this->page->title      = "Mombo Loan System | Settle Reward";
				 
				$this->page->name       = 'mombo-settle-reward';
				
				if($redeemed_id > 0){
					$this->msg['redeemed_id'] = $redeemed_id;
					$this->msg['cust_name'] = $this->input->get_post('cust_name');
					$this->msg['cust_fname'] = $this->input->get_post('cust_fname');
					$this->msg['rew_type'] = $this->input->get_post('rew_type');
					$this->msg['rew_value'] = $this->input->get_post('rew_value');
					$this->msg['phone'] = $this->input->get_post('msisdn');
					$this->msg['message_type'] = 'info';
					$this->msg['message'] = 'Customer Name: '.$this->msg['cust_name'].'<br />Reward Type: '.$this->msg['rew_type'].'<br />Reward Value: Ksh. '.$this->msg['rew_value'].'<br />Phone Number: '.$this->msg['phone'].'<br /><br />';
				} 
				 
				$this->sendResponse($this->msg,array(
					
			    	$this->header => $this->msg,
						
						'mombo/templates/settlereward' => $this->msg,
						
						$this->footer => $this->msg,
				 
				));
			}
			
			public function rewards($redeemed_id = 0){
				$this->load->model('rewards_model');
				$this->load->model('penalties_model');
				
				if($redeemed_id > 0){
					$this->load->model('pay_model');
					$this->load->model('reminders_model');
					$this->load->model('loan_transactions_model');
					
					$cust_name = $this->input->get_post('cust_fname');
					$rew_type = $this->input->get_post('rew_type');
					$rew_value = $this->input->get_post('rew_value');
					$date = $this->input->get_post('date');
					$payment_channel = $this->input->get_post('payment_channel');
					$reference_number = $this->input->get_post('reference_num');
					$description = $this->input->get_post('payment_description');
					if($payment_channel != 'cheque'){
						//Mombo account affected Cash Account 
						$mombo_account = $this->pay_model->get_affected_account('Cash Account');
					}else{
						//Mombo account affected Chase Account 
						$mombo_account = $this->pay_model->get_affected_account('Chase Account');
					}
					
					$to_account_string = $this->rewards_model->get_account_string('Loyalty Programme(cashback)');
					
					$transfer = array();
					$transfer['from_account_id'] = $mombo_account;
					$transfer['to_account_string'] = $to_account_string; //'c*45*5';
					$transfer['amount'] = $rew_value;
					$transfer['reference_number'] = $reference_number;
					$transfer['description'] = $description;
					$transfer['date'] = $date;
					$transfer['parent_id'] = 0; //$parent_id;
					$transfer['date_submitted'] = date('Y-m-d H:i:s');
					$transfer['approved'] = 0;
									
					$insert  = $this->transfers->create($transfer);
					
					if($insert){ //check if inserted successfully
						$updated = $this->rewards_model->settle_reward($redeemed_id,$date);
						
						$cust_id = $this->rewards_model->get_cust_id($redeemed_id);
						
						$cust_details = $this->rewards_model->get_cust_details($cust_id);
						
						$recipient =  $cust_details['email'];
						$subject = "Mombo Reward";
						$body = "Dear ".$cust_name.",\n\nYou have been awarded KES ".$rew_value." of Airtime as a ";
						$body .= "result of redeeming your Mombo Loyal points. We appreciate your Loyalty.";
						$headers = "From: admin@mombo.co.ke";
						@mail($recipient, $subject, $body,$headers); 
						
						$message = "Dear ".$cust_name.", you have been awarded KES ".$rew_value." of Airtime as a ";
						$message .= "result of redeeming your Mombo Loyal points. We appreciate your Loyalty.";
						$customer_mobile  = $cust_details['mobiletel'];
						send_sms($customer_mobile,$message);
						
						$sent_date = date("Y-m-d");
						$this->penalties_model->set_sent_sms($customer_mobile, $message, $sent_date);
						
						$this->msg['message_type'] = 'info';
						$this->msg['message'] = 'The reward of '.$rew_type.' of value '.$rew_value.' for '.$cust_name.' is now awaiting approval';
					}else{
						$this->msg['message_type'] = 'warning';
						$this->msg['message'] = 'The reward of '.$rew_type.' of value '.$rew_value.' for '.$cust_name.' failed to be settled. Please retry!!';
					}
				} 
				
				$unsettled = $this->rewards_model->get_redeemed_rewards(); 
				$settled = $this->rewards_model->get_redeemed_rewards(1); //echo $settled; exit;
								 
				$this->page->title      = "Mombo Loan System | Mombo Rewards";
				 
				$this->page->name       = 'mombo-rewards';
				 
				$this->msg['page']      = $this->page;
				 
				$this->msg['unsettled'] = $unsettled;
				$this->msg['settled'] = $settled;
				 
				$this->sendResponse($this->msg,array(
					
			    	$this->header => $this->msg,
						
						'mombo/templates/rewards' => $this->msg,
						
						$this->footer => $this->msg,
				 
				));
			
			}
			
			
	
			public function loansummary(){
			
			
			}
			
			
			public function dobulkaction(){
			
			}
	
	/******End  Loan Payments******/
	 
}

