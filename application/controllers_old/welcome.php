<?php if(!defined('BASEPATH')) exit("Access Denied!!");

require_once 'site.php';

class Welcome extends Site{
    public function index(){
	    $this->page->title = "Mombo Investement Limited | Home";
		$this->page->name  = 'sitehome';
		$this->msg['page'] = $this->page;
	    $this->sendPage('site/static/home');
	}
	
	public function login(){
	
	}
	
	public function logout(){
	
	}
}