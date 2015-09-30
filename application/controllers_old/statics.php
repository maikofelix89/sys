<?php if(!defined('BASEPATH')) exit("Access Denied!!");

require_once 'site.php';

class Statics extends Site{

     public function index(){
	 
			redirect(base_url());
	   
	 }
	 
	
	 public function about(){
	 
			$this->page->title = "Mombo Ltd | About us";
			
			$this->page->name  = 'mombo';
			
			$this->msg['page'] = $this->page;
			
			$this->sendPage('site/static/about');
		
	 }
	 
	 public function products(){
	 
			$this->page->title = "Mombo Ltd | Products";
			
			$this->page->name  = 'loans';
			
			$this->msg['page'] = $this->page;
			
			$this->sendPage('site/static/products');
	 }
	 
	 public function requirements(){
	 
			$this->page->title = "Mombo Ltd | Requirements";
			
			$this->page->name  = 'loans';
			
			$this->msg['page'] = $this->page;
			
			$this->sendPage('site/static/requirements');
		
	 }
	 
	 public function terms(){
	 
			$this->page->title = "Mombo Ltd | Terms and Conditions";
			
			$this->page->name  = 'loans';
			
			$this->msg['page'] = $this->page;
			
			$this->sendPage('site/static/terms');
			
	 }
	 
	 public function penalties(){
	 
			$this->page->title = "Mombo Ltd | Penalties";
			
			$this->page->name  = 'loans';
			
			$this->msg['page'] = $this->page;
			
			$this->sendPage('site/static/penalties');
			
	 }
	 
	 public function privacy(){
	 
			$this->page->title = "Mombo Ltd | Privacy Policy";
			
			$this->page->name  = 'loans';
			
			$this->msg['page'] = $this->page;
			
			$this->sendPage('site/static/privacy');
			
	 }
	 
	 public function calculator(){
	 
			$this->page->title = "Mombo Ltd | Calculator";
			
			$this->page->name  = 'calculator';
			
			$this->msg['page'] = $this->page;
			
			$this->sendPage('site/pages/calculator');
			
	 }
}