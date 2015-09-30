<?php if(!defined('BASEPATH')) exit("Access Denied");

class Site extends CI_Controller{
    protected $header = 'site/layout/header';
	protected $footer = 'site/layout/footer';
	 public function sendPage($page){
	    $this->sendResponse($this->msg,array(
		  $this->header=>$this->msg,
		  $page=>$this->msg,
		  $this->footer=>'',
		));
	 }
}
	