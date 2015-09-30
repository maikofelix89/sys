<?php
  function block_user_ip(){
       
  }
  
  function block_user_cookie(){
        setcookie('app_access_sts','boolean_true',(time()+(60)));
  }
  
  function user_not_blocked(){
     $blocked = 'boolean_false';
     if(array_key_exists('app_access_sts',$_COOKIE)){
        $blocked = $_COOKIE['app_access_sts'];
	 }
	 
	 if($blocked == 'boolean_false'){
	     return true;
	 }
     return false;
  }