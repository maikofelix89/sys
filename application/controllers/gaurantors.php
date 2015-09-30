<?php if(!defined('BASEPATH')) exit('Access Denied!!');

class Gaurantors extends CI_Controller{ 
      //register models to autoload for controller
      protected $models = array(
	  
			 'gaurantor'=>'gaurantor_model',
			 
			 'customer'=>'customer_model',
			 
			 'loan' => 'loan_model',

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
			  
			  //holds gaurantor records returned
			  $gaurantors  = null;
			  
			  //flag for gaurantor type to return based on their status column/field
			  //default to all
			  $gaurantor_type    = null;
			  
			  //get user submitted gaurantor type
			  if($gaurantor_type = $this->input->get_post('type')){
			  
					  //get members that satisfy user gaurantor type critiria
					  $status = 1; //gaurantor status flag
					  
					  switch(strtolower($gaurantor_type)):
					  
							   case 'inactive':$status = 2;break;
							   
							   case 'new'     :$status = 0;break;
							   
							   case 'active'  :$status = 1; break;
							   case 'reject'  :$status = 3; break;
							   
							   default        :break;	
						   
					  endswitch;
					  
					  //get gaurantors that have status chosen above
					  $gaurantors = $this->gaurantor->findBy(array(
					  
							'status'=>$status
							
					     ),array(
					   
					        (int)$this->input->get_post('per_page'),
							
							20,
					     )
					  );
				  
			  }else{
			  
					 $gaurantor_type = 'all';
					 
					 $gaurantors = $this->gaurantor->findAll(array((int)$this->input->get_post('per_page'),20));
				 
			  }
			  
			  //populate response data
			  $this->page->title         = "Mombo Loan System | Gaurantors";
			  
			  $this->page->name          = 'mombo-gaurantors';
			  
			  $this->msg['page']         = $this->page;
			  
			  $this->msg['gaurantor_type']= $gaurantor_type;
			  
			  $this->msg['gaurantors']    = $gaurantors;
			  
			  $this->msg['message']      = $message;
			  
			  $this->msg['message_type'] = $message_type;
			  
			  $this->sendResponse($this->msg,array(
			  
					$this->header=>$this->msg,
					
					'mombo/templates/gaurantors'=>$this->msg,
					
					$this->footer=>$this->msg,
				
			  ));
	  }
	  
	  
	  
	  public function findgaurantors(){
	  
	         $criteria = $this->input->get_post('criteria');
			 
			 $query    = $this->input->get_post('query');
			 
			 $gaurantors = null;
			 
			 if($criteria && in_array($criteria,array('active','inactive','new'))){
			            
						$status = 0;
						
						switch($criteria){
						
						      case 'active': $status = 1;break;
							  
							  case 'inactive':$status = 2;break;
							  
							  case 'new':$status = 0;break;
						
						}
						
						$gaurantors = $this->gaurantor->findBy(array(
							 'status' => $status,
						));
						
			 }else{
			 
			         $gaurantors = $this->gaurantor->findBy(array(
					 
							'status' => 1
							
					 ));
			 
			 }
			 
			 $this->msg['gaurantors'] = $gaurantors;
			 
			 $this->sendResponse($this->msg);
	  
	  }
	  
	  public function getclient(){
	  
	         $criteria = $this->input->get_post('criteria');
			 $gaurantors = $this->loan->get_clients_by_criteria($criteria);
			 $count = 0;
			 $result = '';
			 if(0 == $gaurantors){
				$result = 0;
			 }
			 else{
				foreach($gaurantors as $gaurantor){
					if(0 == $count){
						$result = $gaurantor['id'].'*'.$gaurantor['name'].' '.$gaurantor['other_names'].'*'.$gaurantor['idnumber'];
					}
					else{
						$result .= '~'.$gaurantor['id'].'*'.$gaurantor['name'].' '.$gaurantor['other_names'].'*'.$gaurantor['idnumber'];
					}
					$count++;
				 }
			 }
			 
			 echo $result;
	  }
	  
	  public function getclientloans(){
	  
	         $client_id = $this->input->get_post('gaurantor_id');
			 return $this->loan->get_loans_by_client($client_id);
	  }
	  
	  public function getloandetails(){
	  
	         $loan_id = $this->input->get_post('loan_id');
			 return $this->loan->get_loan_details($loan_id);
	  }
	  
	  //performs various actions on gaurantor status to reduce coupling
	  public function dostatusaction(){
	  
			 $gaurantor_id = (int)$this->input->get_post('gaurantor_id'); //get gaurantor id
			 
			 $action      = $this->input->get_post('action'); //get action to perform
			 
			 $gaurantor    = $this->gaurantor->findOne($gaurantor_id); //find the gaurantor the action has been called on
			 
			 $message     = null; //confirm dialog message set to null
			 
			 if(null != $gaurantor && in_array($action,array('activate','accept','reject','deactivate'))){ //check if gaurantor record was found and action supported
			 
				   $yes_url        = base_url().'gaurantors/dostatusaction/?gaurantor_id='.$gaurantor_id.'&'; //url for action confirmed
				   
				   $on_success_url = base_url().'gaurantors/?type='; //url for action success
				   
				   $no_url         = base_url().'gaurantors/?type='; //url for action cancel
				   
				   $status         = null; //status to change gaurantor registration status 
				   
				   //set message and above items based on action being performed
				   switch(strtolower($action)){
				   
							case 'activate': //set variables for gaurantor activate action

								 $status      = 1;
								 
								 $message     = "Do you really want to activate this guarantor?";
								 
								 $yes_url    .= 'action=activate&confirmed=true&';
								 
								 $no_url     .= 'active';
								 
								 $on_success_url .= 'active&message=Guarantor activated successfully!';
								 
							break;
							
							case 'accept': //set variables for gaurantor registration accept action
							
								 $status      = 1;
								 
								 $message     = "Do you really want to approve this guarantor?";
								 
								 $yes_url    .= 'action=accept&confirmed=true&';
								 
								 $no_url     .= 'new';
								 
								 $on_success_url .= 'new&message=Guarantor request accepted!';
								 
							break;
							
							case 'reject': //set variables for gaurantor registration reject action
							
								 $status      = 3;
								 
								 $message     = "Do you really want to reject this guarantor?";
								 
								 $yes_url    .= 'action=reject&confirmed=true&';
								 
								 $no_url     .= 'new';
								 
								 $on_success_url .= 'new&message=Guarantor request rejected!';
								 
							break;
							
							case 'deactivate': //set variables for gaurantor deactivate action
							
								 $status      = 2;
								 
								 $message     = "Do you really want to deactivate this guarantor?";
								 
								 $yes_url    .= 'action=deactivate&confirmed=true&';
								 
								 $no_url     .= 'inactive';
								 
								 $on_success_url .= 'inactive&message=Guarantor deactivated successfully!';
								 
							break;
						
				   } 
				   if($this->input->get_post('confirmed')){ //proceed only if action has been confirmed
				   
				   
							$gaurantor->status = $status; //set new gaurantor status

							if($gaurantor->update()){ //update gaurantor record

									redirect($on_success_url.'&message_type=success');//redirect to gaurantors page

							}else{

									//if gaurantor update fialed. redirect to gaurantors list page with appropriate message
									redirect(base_url().'gaurantors/?message=Error performing action!&message_type=error');

							}
				   }else{
				   
							//if action has not been confirmed then populate template data for confirm page
							//and send page to user for confirmation
							$this->page->title         = "Mombo Loan System | Confirm Action";

							$this->page->name          = 'mombo-accept-gaurantor';

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
			 
				//if gaurantor record doesn't exists,return all gaurantors list
				$this->index();
				
			}
		
	  } 

	  
	  public function viewgaurantordetails(){
	         
			$gaurantor_id   = (int) $this->input->get_post('gaurantor_id'); //get gaurantor id
			
			$gaurantor      = $this->gaurantor->findOne($gaurantor_id); //get gaurantor with submitted id
			
			$message       = $this->input->get_post('message');
			
			$message_type  = $this->input->get_post('message_type');
			
			//populate template data
			$this->page->title         = "Mombo Loan System | Gaurantor Details";
			
			$this->page->name          = 'mombo-gaurantor-details';
			
			$this->msg['page']         = $this->page;
			
			$this->msg['gaurantor']     = $gaurantor;
			
			$this->msg['message']      = $message;
			
			$this->msg['message_type'] = $message_type;
			
			$this->msg['loans']        = $this->loan->findBy(array(
			
					'gaurantor' => (($gaurantor) ? $gaurantor->id : 0 ),
					'request_status' => 2
			));
			
		    $this->sendResponse($this->msg,array(
			
					$this->header => $this->msg,
					
					'mombo/templates/gaurantor' => $this->msg,
					
					$this->footer => $this->msg,
			    )
			);
	  }
	  
	  public function gaurantorloanstatement($loan_id,$customer_id,$gaurantor_id,$pdf = 0){
	  	$this->load->model('loan_transactions_model');
	  	$date = date('d-M-Y');
		$gaurantor = $this->gaurantor->findBy(array(

					'id' => $gaurantor_id,
			));
			/*foreach($gaurantor->result('gaurantor_model') as $cust){
				echo $cust->name;
			}*/
		
		$customer = $this->customer->findBy(array(

					'id' => $customer_id,
			));
			
		$loan = $this->loan->findBy(array(
			
					'id' => $loan_id,
			));
			/*foreach($loan->result('loan_model') as $cust_loan){
				echo $cust_loan->loan_product->loan_product_name;
			}*/
		$loan_transactions = $this->loan_transactions_model->get_loan_transactions($loan_id);
		/*foreach($loan_transactions as $loan_transaction){
			echo $loan_transaction["balance"]; 
		}*/
		
		
		if($pdf){
			if($customer->num_rows() > 0 ){ 
			  	$content = ""; 
			  	//$content = urlencode($content);
			   $img_url = 'img/logo2.png';
			   $content .= '<table>
			   	<tr class="muted">
								<th colspan="6" style="text-align: center;"><img src="'.$img_url.'"/></th>
							</tr>
							<!--<tr class="muted">
								<th colspan="6" style="text-align: center">Mombo Investment Limited</th>
							</tr>-->
							<tr class="muted">
								<th colspan="6" style="text-align: center">Loan Statement of Account as of '.$date.'</th>
							</tr>
							<tr class="muted">
								<th colspan="6" style="text-align: left">Borrower: '; 
								 	foreach($customer->result('customer_model') as $cust){
										$content .= $cust->name.' '.$cust->other_names;
										$file_name = $cust->name.' '.$cust->other_names;
									} 
								 $content .= '</th>
							</tr>
							<tr class="muted">
								<th colspan="6" style="text-align: left">Loan Product: '; 
								 	foreach($loan->result('loan_model') as $cust_loan){
										$content .= $cust_loan->loan_product->loan_product_name;
									}
								
								$content .= '</th>
							</tr>
							<tr class="muted">
								<th style="text-align: left;width: 100%">Loan Transaction Code: '; 
								 	foreach($loan->result('loan_model') as $cust_loan){
										$content .= $cust_loan->transaction_code;
									}
								
								$content .= '</th>
							</tr>
			   </table>';
					$content .= '<table border="1">
						<thead>
							
							<tr class="muted">
								<th style="text-align: left">Date</th>
								<th style="text-align: left">Transaction</th>
								<th style="text-align: left">Description</th>
								<th style="text-align: left">Debit</th>
								<th style="text-align: left">Credit</th>
								<th style="text-align: left">Balance</th>
							</tr>
						</thead>
						<tbody>'; 
									foreach($loan_transactions as $loan_transaction){
										$credit = "";
										$debit = "";
										if($loan_transaction["is_credit"]){
											$credit = $loan_transaction["amount"];
										}
										else{
											$debit = $loan_transaction["amount"];
										}
										$date_time = date("Y-m-d", strtotime($loan_transaction["date_time"]));
										$content .= '<tr>';
										$content .= '<td style="text-align: left">'.$date_time.'</td>'; 
										$content .= '<td style="text-align: left">'.$loan_transaction["transaction"].'</td>';
										$content .= '<td style="text-align: left">'.$loan_transaction["description"].'</td>';
										$content .= '<td style="text-align: left">'.$debit.'</td>';
										$content .= '<td style="text-align: left">'.$credit.'</td>';
										$content .= '<td style="text-align: left">'.$loan_transaction["balance"].'</td>';
										$content .= '</tr>';
									}
								
						$content .= '</tbody>
						
					</table>';
					//echo $content;
					$this->gaurantorloanpdf($content,$loan_id.'_'.$file_name);
					
				 }else{
                	 $this->gaurantorloanpdf('No customer found!');
				} 
				
		}
		else{
			//populate template data
			$this->page->title    = "Mombo Loan System | Customer Loan Statement";

			$this->page->name     = 'mombo-customer-loan-statement';

			$this->msg['page']    = $this->page;
			$this->msg['date'] = $date;
			$this->msg['gaurantor'] = $gaurantor;
			$this->msg['customer'] = $customer;
			$this->msg['loan'] = $loan;
			$this->msg['loan_id'] = $loan_id;
			$this->msg['customer_id'] = $customer_id;
			$this->msg['gaurantor_id'] = $gaurantor_id;
			$this->msg['loan_transactions'] = $loan_transactions;

			$this->sendResponse($this->msg,array(
			
				 $this->header =>$this->msg,
				 
				 'mombo/templates/gaurantor_loan' => $this->msg,
				 
				 $this->footer => $this->msg,
				 
			));	
		}
		
	  }
	  
	  
	  public function gaurantorloanpdf($content,$filename = 'Loan statement'){
	  	//echo 'hehehehe'; exit;
		$content = urldecode($content);
		//Load the library
		$this->load->library('html2pdf');

		//Set folder to save PDF to
		$this->html2pdf->folder('./gaurantor/pdfs/');

		//Set the filename to save/download as
		$this->html2pdf->filename($filename); 

		//Set the paper defaults
		$this->html2pdf->paper('a4', 'portrait');

		//Load html view
		$this->html2pdf->html($content);
		
		//Create the PDF
		$this->html2pdf->create('download'); //other option 'save'
	  }
	  
	  
	  
	  public function addnewgaurantor(){
	  
			$message = null; //add new form error message

			$errors  = array(); // contains validation error for submitted gaurantor properties

			if($this->input->post('add_guarantor')){ //proceed only if the register submit button has been clicked

					$gaurantor = $this->input->post('gaurantor'); //get the submitted gaurantor assoc array of form field
					
					$gaurantor['status']    = 0;
					
					
					$added  = $this->gaurantor->create($gaurantor);
					
					if($added){ //check if added successfully
					
							//if gaurantor added successfully redirect to gaurantors list page, with appropriate message
							redirect(base_url().'gaurantors/?message=Member added successfully&message_type=success');
						
					}else{
					
						   //else if not added successfully:
						   $message = 'Error adding member!'; //provide an error message
						   
						   $errors  = $this->gaurantor->validationerrors(); //get all validation errors if any
					   
					}
					
			}
             
			//populate template data
			$this->page->title    = "Mombo Loan System | Add New Guarantor";

			$this->page->name     = 'mombo-addnew-guarantor';

			$this->msg['page']    = $this->page;

			$this->msg['message'] = $message;

			$this->msg['errors']  = $errors;

			$this->sendResponse($this->msg,array(
			
				 $this->header =>$this->msg,
				 
				 'mombo/templates/addnewguarantor' => $this->msg,
				 
				 $this->footer => $this->msg,
				 
			));
	  }
	  
	  
	  public function updategaurantor(){
	  
			$message = null; //add new form error message

			$errors  = array(); // contains validation error for submitted gaurantor properties

			if($this->input->post('update_gaurantor')){ //proceed only if the register submit button has been clicked

					$gaurantor = $this->input->post('gaurantor'); //get the submitted gaurantor assoc array of form fields
					
					$added    = $this->gaurantor->doupdate($gaurantor);
					
					if($added){ //check if added successfully
					
							//if gaurantor added successfully redirect to gaurantors list page, with appropriate message
							redirect(base_url().'gaurantors/?message=Guarantor updated successfully&message_type=success');
						
					}else{
					
						   //else if not added successfully:
						   $message = 'Error updating member!'; //provide an error message
						   
						   $errors  = $this->gaurantor->validationerrors(); //get all validation errors if any
					   
					}
					
			}
             
			//populate template data
			$this->page->title    = "Mombo Loan System | Update Guarantor";

			$this->page->name     = 'mombo-update-guarantor';

			$this->msg['page']    = $this->page;

			$this->msg['message'] = $message;

			$this->msg['errors']  = $errors;
			
			$this->msg['gaurantor']  = $gaurantor;

			$this->sendResponse($this->msg,array(
			
				 $this->header =>$this->msg,
				 
				 'mombo/templates/editguarantordetails' => $this->msg,
				 
				 $this->footer => $this->msg,
				 
			));
	  
	  }
	  
	  
	  public function deletegaurantor(){
	  
	  }
	  
	  public function bulkaction(){
	  
	  }
	  
	  public function uploadpic(){
	  
				$gaurantor_id = (int) $this->input->post('gaurantor_id');
				
				$gaurantor    = $this->gaurantor->findOne($gaurantor_id);
				
				$message     = null;
				
				if($gaurantor && $this->input->post('upload_pic')){
				
						print_r($_FILES);
						if($_FILES['gaurantor_pic'] && $_FILES['gaurantor_pic']['name']){
									//echo "heheheheh"; exit;							
									$gaurantor_pic_uploaded 	    = $this->upload->do_upload('gaurantor_pic');
									
									if($gaurantor_pic_uploaded){
									
											$upload = $this->upload->data();
											
											$gaurantor->profilepic = $upload['file_name'];
											
											$gaurantor->update();
						
											redirect(base_url().'gaurantors/viewgaurantordetails/?message=Profile picture uploaded successfully&message_type=success&gaurantor_id='.$gaurantor->id);
														
									}else{
											
											$message = "<p>Error uploading gaurantor's picture.</p>".$this->upload->display_errors();;
											
											redirect(base_url().'gaurantors/viewgaurantordetails/?message='.$message.'&gaurantor_id='.$gaurantor->id);
									
									}
									
						}
						
						
						
				}
				
				redirect(base_url().'gaurantors/viewgaurantordetails/?message=Photo not uploaded&messsage_type=warning&gaurantor_id='.$gaurantor_id);
	  
	  }
	  
	  public function exportimport(){
	        
			//get user action
			$action = $this->input->get_post('action');
			
			if($action && in_array($action,array('import','export'))){
					
					
			}
			
			//populate template data
			$this->page->title = "Mombo Loan System | Gaurantor Records Export & Import";
			
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
		   
		        $gaurantor = array();
				
				$gaurantor['name']          = $this->input->get_post('cusname');
				
				$gaurantor['other_names']   = $this->input->get_post('cusothernames');
				
				$gaurantor['email']         = $this->input->get_post('cusemail');
				
				$gaurantor['idnumber']      = $this->input->get_post('cusidnumber');
				
				$gaurantor['mobiletel']     = $this->input->get_post('cusmobile');
				
			    $gaurantor['password']      = random_string('alnum',6,12);
				
				$gaurantor['status']        = 0;
				
				$gaurantor['member_id']     = 'MOMBO-MMID-'.substr($gaurantor['mobiletel'],3,7).'-'.random_string('numeric',4);
				
				$gaurantor['profilepic']    = 'avator.png';
				
				if($this->gaurantor->create($gaurantor)){
					 
					    $gaurantor = $this->gaurantor->findBy(array(
						
								'email' => $gaurantor['email'],
							 
						))->row(0,'gaurantor_model');
						
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
												
												$loan['gaurantor']                = $gaurantor->id;
												
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
														
														$to         = $gaurantor->email;
														
														$subject    = "Mombo Investement Ltd | Account Activated";
														
														$email      = get_registration_email_template();
														
														$email      = str_replace(array(
																	  '{base-url}',
																	  '{gaurantor-name}',
																	  '{password}',
																	  '{date}'),array(
																	    $this->config->item('siteurl'),
																	   $gaurantor->name,
																	   date('Y-m-d',time())
																	),$email);
														
														
														$this->email->from('gaurantorcare@mombo.co.ke','Mombo Investment Ltd');
														
														$this->email->to('requests@mombo.co.ke'); 
														
														$this->email->subject($subject);

														$this->email->message($email);											
														
														$this->email->send(); 
												
												}else{
												
													$message = "Error sending loan application";

													$code    = 503;
													
													$gaurantor->delete($gaurantor->id);
												
												}
										}else{
										
												 $message = "Your loan duration does not fall in the accepted range for the selected loan product. Between $product->maximum_duration and $product->minimum_duration $product->repayment_frequency_single"."s";
										      
										         $errors['loan_amount'] = 'invalid loan duration';
												 
												 $code   = 503;
												 
												 $gaurantor->delete($gaurantor->id);
										
										}
								 }else{  

								 	     $message = "Your loan amount does not fall in the accepted range for the selected loan product. Between Ksh. $product->maximum_amount_loaned and Ksh. $product->minimum_amount_loaned";
											
										 $errors['loan_amount'] = 'invalid loan amount';
										 
										 $code   = 503;
										 
										 $gaurantor->delete($gaurantor->id);
								 
								 }
						}else{
						    
							 $message = "Loan product chosen does not exists";
							 
							 $errors['loan_product'] = 'invalid value selected';
							 
							 $code   = 503;
							 
							 $gaurantor->delete($gaurantor->id);
						
						}
					
				
				}else{
				
				        $errors  = $this->gaurantor->validationerrors();
					    
					    $message = "Please review your inputs and make changes as required";
						
						$code    = 503;
				
				}
		   }
		   
		   $this->msg['errors']  = $errors;
		   
		   $this->msg['message'] = $message;
		   
		   $this->msg['code']    = $code;
		   
		   $this->sendResponse($this->msg);
	  
	  }
	  
	  
	  public function gaurantorapply(){
	  
			if($this->input->get_post('apply')){

				$gaurantor_id   = (int) $this->input->get_post('userid');
		   
		        $gaurantor = $this->gaurantor->findOne($gaurantor_id);
				
				if($gaurantor){
				
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
												
												$loan['gaurantor']   = $gaurantor->id;

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

	       			$result = $this->gaurantor->findBy(array(
                       
                           'email'=>$email,

                           'password' => $password,
                       
	       			))->row(0,'gaurantor_model');


	       			if($result){


	       				 $this->msg['message']  = "Login successfull!";

	       				 $this->msg['code']     = 200;
 
	       				 $this->msg['gaurantor'] = $result;


	       			}else{

	       				  $this->msg['message'] = "Login error!. Wrong password or email";

	       				  $this->msg['code'] = 503;
	       			}

	       }

	       $this->sendResponse($this->msg);
	  
	  }
	  
	  public function getloans(){

	  	    $userid    = (int) $this->input->get_post('userid');

	  	    $gaurantor  = $this->gaurantor->findOne($userid);

	  	    $loans     = array();

	  	    $charges   = array();

	  	    if($gaurantor){

	  	    		$rloans = $this->loan->findBy(array('gaurantor'=>$gaurantor->id,'request_status'=>2)); 

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

	  		$gaurantor = $this->gaurantor->findOne($userid);

	  		if($gaurantor){

	  			return false;

	  		}

	  		return true;

	  }
     

	  public function getpersonalstatement(){


  			if(!$this->isguest()){

  				 $loanid  = (int) $this->input->get_post('loanid');

  				 $loan    = $this->loan->findOne($loanid);

  				 if(null != $loan){
                       
                        $gaurantoraccount = $this->gaurantor_account->findBy(array(
                        	
                        	'gaurantor'=>$loan->gaurantor->id

                        ))->row(0,'gaurantoraccount_model');

  				 		$transactions    = $this->transaction->findBy(array(

  				 				 'account' => $gaurantoraccount->id,

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

  				 		$this->msg['gaurantoraccount'] = $gaurantoraccount;

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

            $gaurantor = $this->gaurantor->findOne($userid);

            if($gaurantor){

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

            $gaurantor    = $this->gaurantor->findOne($userid);

            if($gaurantor){

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

	  		$gaurantor = $this->gaurantor->findOne($userid);

	  		if($gaurantor){

	  				if($postText && !empty($postText) && null != $postText && $postText != ''){

	  					  $post = array(

	  					  		'user'=>$gaurantor->id,

	  					  		'post' => $postText,

	  					  		'time' => date('Y-m-d:h-m-s',time()),

	  					  		'exclude' => json_encode(array($gaurantor->id))

	  					  );

	  					  $created = $this->post->create($post);

	  					  if($created){

	  					  	   $this->msg['code'] = 200;

	  					  	   $this->msg['post'] = json_encode(array(
                                        
                                     'userName' => $gaurantor->name,

                                     'userPic' => $gaurantor->profilepic,

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

	  	    $gaurantor = $this->gaurantor->findOne($userid);

	  	    if($gaurantor){

	  	    		$post = $this->post->findOne($postid);

	  	    		if($post){

	  	    				if($commentText && !empty($commentText) && null != $commentText && $commentText != ''){

	  	    						 $comment = array(

	  	    						 		'user'=>$gaurantor->id,

	  	    						 		'post'=> $post->id,

	  	    						 		'comment'=> $commentText,

	  	    						 		'time'=>date('Y-m-d:H-m-s',time()),

	  					  		            'exclude' => json_encode(array($gaurantor->id))

	  	    						 );

	  	    						 $created = $this->comment->create($comment);

	  	    						 if($created){

	  	    						 			$this->msg['code'] = 200;

	  	    						 			$this->msg['comment'] = json_encode(array(

	  	    						 					'commentText' => $commentText,

	  	    						 					'userName' => $gaurantor->name,

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
 
	  	   $gaurantor  = $this->gaurantor->findBy(array(

	  	   	    'email' => $email

	  	   	))->row(0,'gaurantor_model');

	  	   if($gaurantor){
                   
                    $email_address = $gaurantor->email;

                    $email = "Dear ".ucwords($gaurantor->name).", your password is ".$gaurantor->password.". Please always keep your password safe.";

                    $this->email->from('gaurantorcare@mombo.co.ke','Mombo Investment Ltd');

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

		  	   	    			     $gaurantor = $this->gaurantor->findOne($userid);

		  	   	    			     if($gaurantor){

		  	   	    			     	     $gaurantor->password = $newpass;

		  	   	    			     	     $updated = $gaurantor->update();

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

              $gaurantor_id    = (int) $this->input->get_post('gaurantor_id');

              if($gaurantor_id){

                     $gaurantor = $this->gaurantor->findOne($gaurantor_id);

                     if($gaurantor){

                             $mob = $gaurantor->mobile;

                             send_sms($mob,$message);

                             $this->sms->create(array(
							   
							   'message' => $message,

                     	       'date' => date('Y-m-d',time()),

							   'too'=> $gaurantor->mobile,
                             ));

                     	    redirect(base_url().'gaurantors/viewgaurantordetails/?gaurantor_id='.$gaurantor->id.'&message=Message sent successfully&message_type=success');

                     }else{

                     	 redirect(base_url().'gaurantors/?message=error sending message,gaurantor doesnt exists&message_type=warning');

                     }
              }else{

              	    redirect(base_url().'gaurantors/?message=Error. Minimum action requirements not met&message_type=warning');

              }
	  }
	  
	  public function birthdays(){
				$this->load->model('gaurantor_model');
				
				//$gaurantors = array();
				
				$today = $this->gaurantor_model->get_today_birthdays();
				$today1 = $this->gaurantor_model->get_upcoming_birthdays(1); 
				$today2 = $this->gaurantor_model->get_upcoming_birthdays(2); 
				$today3 = $this->gaurantor_model->get_upcoming_birthdays(3); 
				$today4 = $this->gaurantor_model->get_upcoming_birthdays(4); 
				$today5 = $this->gaurantor_model->get_upcoming_birthdays(5); 
				$today6 = $this->gaurantor_model->get_upcoming_birthdays(6); 
				
				/*if(empty($today)){
					echo "here"; exit;
				} */
				
				/*foreach($today as $today_){
					echo $today_['dateOfBirth']; exit;
				}*/
								 
				$this->page->title      = "Mombo Loan System | Gaurantor Birthdays";
				 
				$this->page->name       = 'mombo-gaurantor-birthdays';
				 
				$this->msg['page']      = $this->page;
				 
				$this->msg['today'] = $today;
				$this->msg['today1'] = $today1;
				$this->msg['today2'] = $today2;
				$this->msg['today3'] = $today3;
				$this->msg['today4'] = $today4;
				$this->msg['today5'] = $today5;
				$this->msg['today6'] = $today6;
				 
				$this->sendResponse($this->msg,array(
					
			    	$this->header => $this->msg,
						
						'mombo/templates/birthdays' => $this->msg,
						
						$this->footer => $this->msg,
				 
				));
			
			}
			
			
			public function addcharge(){
				$this->load->model('chargestotalpayment_model'); 
				$this->load->model('loan_model');
				$this->load->model('loan_transactions_model');
				$charge_name = "Car Tracking Fee";
				$message = "";
				if($this->input->get_post('message',TRUE)){
					$this->msg['message'] = $this->input->get_post('message',TRUE);
					$this->msg['message_type'] = $this->input->get_post('message_type',TRUE);
				}
				if($this->input->get_post('loan_id',TRUE)){
					$this->msg['loan_id'] = $this->input->get_post('loan_id',TRUE);
					$loan_id = $this->input->get_post('loan_id',TRUE);
				}
				
				if($this->input->get_post('cust_id',TRUE)){
					$this->msg['cust_id'] = $this->input->get_post('cust_id',TRUE);
					$cust_id = $this->input->get_post('cust_id',TRUE);
				}
								
				if($this->loan_model->get_charge($loan_id,$charge_name, date('Y-m'))){
					redirect(base_url().'gaurantors/viewgaurantordetails/?gaurantor_id='.$cust_id.'/?message=The charge had already been added previously&message_type=warning');
				}
				
				if($this->input->get_post('submit',TRUE)){
					$charge_name = $this->input->get_post('charge',TRUE);
					$amount = $this->input->get_post('amount',TRUE);
					if($amount <= 0){
						redirect(base_url().'gaurantors/viewgaurantordetails/?gaurantor_id='.$cust_id.'/?message=Amount should be greater than zero&message_type=warning');
					}
					$loan_transaction_code = $this->loan_model->get_loan_transaction_code($loan_id); //echo $loan_transaction_code; exit;
					if(!$this->loan_model->insert_charge_fee($loan_transaction_code,$charge_name,$loan_id,$amount)){
						redirect(base_url().'gaurantors/viewgaurantordetails/?gaurantor_id='.$cust_id.'/?message=Error has occured. Please try again later.&message_type=warning');
					}
					else{
						$this->loan_transactions_model->add_transaction($loan_id,$charge_name,'-',0,$amount);
						redirect(base_url().'gaurantors/viewgaurantordetails/?gaurantor_id='.$cust_id.'/?message=The charge has been added successfuly&message_type=info');
					}
				}
				
								
							 
				$this->page->title      = "Mombo Loan System | Add Charge";
				 
				$this->page->name       = 'mombo-add-charge';
				 
				$this->msg['page']      = $this->page;
				 
				//$this->msg['today'] = $today;
				 
				$this->sendResponse($this->msg,array(
					
			    	$this->header => $this->msg,
						
						'mombo/templates/add_charge_view' => $this->msg,
						
						$this->footer => $this->msg,
				 
				));
			
			}
			
			public function getguarantor(){
	  
				 $criteria = $this->input->get_post('criteria');
				 $guarantors = $this->gaurantor->get_guarantors_by_criteria($criteria);
				 $count = 0;
				 $result = '';
				 if(0 == $guarantors){
					$result = 0;
				 }
				 else{
					foreach($guarantors as $guarantor){
						if(0 == $count){
							$result = $guarantor['id'].'*'.$guarantor['name'].' '.$guarantor['other_names'].'*'.$guarantor['idnumber'];
						}
						else{
							$result .= '~'.$guarantor['id'].'*'.$guarantor['name'].' '.$guarantor['other_names'].'*'.$guarantor['idnumber'];
						}
						$count++;
					 }
				 }
				 
				 echo $result;
		  }
			
}