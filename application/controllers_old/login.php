<?php if(!defined('BASEPATH')) exit("Access Denied!!");

require_once 'site.php';

class Login extends Site{

    protected $models = array(
			
			'customer' => 'customer_model',
			
			'loan' => 'loan_model',
			
			'product' => 'product_model'
			
	);


	public function index(){
		
		    $this->page->title      = "Mombo Investment Ltd | Login";
			
			$this->page->name       = 'login';
			
			$this->msg['page']      = $this->page;

			$this->sendPage('site/pages/login',$this->msg);
	}


}