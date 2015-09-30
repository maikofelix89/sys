<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/
 
 $hook = array(
     /* 'post_controller_constructor'=>array(
	       array(
				'class'=>'AccessControl',
				'function'=>'authorize',
				'filename'=>'accesscontrol.php',
				'filepath'=>'hooks/accesscontrol',
			),
	  ),*/
	  
	  'post_controller'=>array(
	  
			'class' => '',
			
			'function' => 'save_last_p',
			
			'filename' => 'lastpage.php',
			
			'filepath' => 'hooks'
	  
	  ),
 );
 
/* End of file hooks.php */
/* Location: ./application/config/hooks.php */