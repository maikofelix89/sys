<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 class AccessControl{
     public function authorize(){
	     $CI       = &get_instance();
		 $contr    = $CI->router->class;
		 $c_action = $CI->router->method;
	     $rules    = array();
	     $rules    = require_once 'rules.php';
		 $usertype = $CI->session->userdata('user_type');
         //echo $usertype;
		 if(!$usertype){
		    $usertype = 'guests';
		 }
		 
		 if(!empty($rules)){
		   //Loop through each module rules array
		   foreach($rules as $module){
		        //Check if current controller has rules defined 
		        if(array_key_exists($contr,$module['controllers'])){
				     //Load controller rules
				     $contr = $module['controllers'][$contr];
					 //Check if there are any access rules defined at the controller level
				     if(array_key_exists('c_level',$contr)){
					    $clevel_rules = array();
						//Load controller access rules
					    $clevel_rules = $contr['c_level'];
						//Check if user is authorized to access the controller
						if(!in_array($usertype,$clevel_rules)){
						    //Perform any action if defined.
							if(array_key_exists('action',$clevel_rules)){
							    $action = $clevel_rules['action'];
								//print_r($action);
								$act_class_file = dirname(__FILE__).'/actions/'.strtolower($action[0]).'.php';
							    if(file_exists($act_class_file)){
								    require_once $act_class_file;
									$class  = ucfirst(strtolower($action[0]));
									$method = $action[1];
									$class  = new $class();
									$class->$method();
								}else{
									 show_error(ucfirst(strtolower($action[0])).' Class Not Found!');
								}
							}
							//Throw an access denied error page
						    show_error('Access Denied!',305);
							exit();
						}
						//Otherwise continue to controller action
					 }
					 
					 //Check if requested controller has access rules defined at the action level
					 if(array_key_exists('a_level',$contr)){
					    $alevel_rules = array();
						//Load action rules
					    $alevel_rules = $contr['a_level'];
						//Check if there are any rules and if the requested action has rules defined
						if(!empty($alevel_rules) && array_key_exists($c_action,$alevel_rules)){
						    //Check if current user is authorized to perform that action
							if(!in_array($usertype,$alevel_rules[$c_action])){
							    //Perform any action if defined.
								if(array_key_exists('action',$alevel_rules[$c_action])){
									$action = $alevel_rules[$c_action]['action'];
									$act_class_file = dirname(__FILE__).'/actions/'.strtolower($action[0]).'.php';
									if(file_exists($act_class_file)){
										require_once $act_class_file;
										$class  = ucfirst(strtolower($action[0]));
										$method = $action[1];
										$class  = new $class();
										$class->$method();
									}else{
									    show_error(ucfirst(strtolower($action[0])).' Class Not Found!');
									}
								}
							    //If not throw an access denied error
								show_error('Access Denied!',305);
								exit();
							}
						}
					 }
					 
				}
				
				//If no rules have been defined for the controller then proceed
		   }
		 }
	 }
 }
 