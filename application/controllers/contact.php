<?php if(!defined('BASEPATH')) exit("Access Denied!!");

require_once 'site.php';

class Contact extends Site{
    public function index(){
	    $this->page->title = "Mombo Investment Ltd| Contact us";
		$this->page->name  = 'contact';
		$this->msg['page'] = $this->page;
	    $this->sendPage('site/pages/contact');
	}
}