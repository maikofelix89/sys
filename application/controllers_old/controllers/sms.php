<?php if(!defined('BASEPATH')) exit("Access Denied");

class Sms extends CI_Controller{

	  /* protected $models = array(

            'sms' => 'sms_model',

            'customer' => 'customer_model'
	   );*/


	   protected $header = 'mombo/layout/header';

	   protected $footer = 'mombo/layout/footer';
	   
	   public function __construct()
		{
		    parent::__construct();
			
		    //function inside autoloaded helper, check if user is logged in, if not redirects to login page
		    is_logged_in();
		}

	   public function index(){

              $this->outbox();
	   }

	   public function outbox(){

	   	     //$sms =  $this->sms->findAll();
	   	     $this->load->model('sms_model'); 
	   	     $sms =  $this->sms_model->getAll();
			 $dates = array();
			 $recipients = array();
			 $messages = array();
			 $i = 0;
			 foreach($sms as $msg){
			 	$dates[$i] = $msg['date'];
				$recipients[$i] = $msg['too'];
				$messages[$i] = $msg['message'];
				$i++;
			 }
	   	     //echo 'Under development'; exit;

	   	     $this->page->title = "Mombo Loan System | SMS Outbox";

	   	     $this->page->name  = "mombo-sms-outbox";

	   	     $this->msg['page'] = $this->page;

	   	     $this->msg['sms']  = $i;
			 $this->msg['dates']  = $dates;
			 $this->msg['recipients']  = $recipients;
			 $this->msg['messages']  = $messages;

	   	     $this->sendResponse($this->msg,array(

	   	     	  $this->header => $this->msg,

	   	     	  'mombo/templates/smslist' => $this->msg,

	   	     	  $this->footer => $this->msg,

	   	     ));
	   }
}