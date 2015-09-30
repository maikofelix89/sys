<?php if(!defined('BASEPATH')) exit("Access Denied");

class Systemsettings extends CI_Controller{
		
		protected $models = array(
		
				'option' => 'systemoption_model',
				
				'sobject' => 'systemobject_model',
				
				'log' => 'log_model',
				
				'accounts_logs' => 'transaction_model',
				
				'loan' => 'loan_model',
				
				'product' => 'product_model',
				
				'account' => 'account_model'
		
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
		
				$systemoptions  = $this->option->findAll();
				
				$systemobjects = $this->sobject->findAll();
				
				$access_logs    = $this->log->findAll();
		
				$this->page->title 				= "Mombo Loan System | System Management";
				
				$this->page->name  				= 'mombo-system-options';
				
				$this->msg['page']			    = $this->page;
				
				$this->msg['message']           = $this->input->get_post('message');
				
				$this->msg['message_type']      = $this->input->get_post('message_type');
				
				$this->msg['system_options']    = $systemoptions;
				
				$this->msg['system_objects']    = $systemobjects;
				
				$this->msg['access_logs']       = $access_logs;
				
				$this->sendResponse($this->msg,array(
				
						$this->header => $this->msg,
						
						'mombo/templates/systemsettings' => $this->msg,
						
						$this->footer => $this->msg,
				
				));
		
		}
		
		public function editsettings(){
		
		        $options = $this->option->findAll();
		
				if($this->input->post('edit_settings')){
				
						 foreach($options->result('systemoption_model') as $option){
						 
								$option->value = $this->input->post($option->name);
								
								if($option->update()){
								
										continue;
								
								}else{
 
										redirect(base_url().'systemsettings/?message=error updating system option : '.$option->name.'&message_type=warning');
								
								}
						 
						 }
						 
						 redirect(base_url().'systemsettings/?message=System settings updated successfully!&message_type=success');
				
				}
				
				
				
				$this->page->title 		= "Mombo Loan System | Edit System Settings";
				
				$this->page->name  		= 'mombo-edit-settings';
				
				$this->msg['page'] 		= $this->page;
				
				$this->msg['options']   = $options;
				
				$this->msg['accounts'] = $this->account->findAll();
 				
				$this->sendResponse($this->msg,array(
					
						
						$this->header => $this->msg,
						
						'mombo/templates/editsystemsettings' => $this->msg,
						
						$this->footer => $this->msg,
						
				  )
				);
		
		}
		
		public function editsystemobject(){
		
		}
		
		public function addsystemoption(){
		
		}
		
		
}