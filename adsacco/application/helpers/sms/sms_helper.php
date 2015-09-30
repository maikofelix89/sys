<?php
	//**************************************************************************************************
	//IP allowed to execute this file
    
    /*$ALLOWED_IP = "127.0.0.1"; 
	
    $remote_ip = $_SERVER['REMOTE_ADDR'];
    
    if($remote_ip  != $ALLOWED_IP)
    {
		//echo "Access Denied for remote IP $remote_ip!";
	   exit;
    }
    */
   	//************************************************************************************************** 
	 require_once 'AfricasTalkingGateway.php';
	 
	//**************************************************************************************************
	//YOUR MESSAGING DETAILS
	//**************************************************************************************************
function send_sms ($to_original,$msg_original,$msg_id_original=null) { 
		$username = "mcharo"; //Your followme username
		
		$apikey   = "76d1c321f4e91473745e59585dc4e4a743b880d380d607fb755ce368e698d979";
		
		$from = "MOMBO"; //Your sender ID
		
		//For numbers that start with zero, add kenyan code to front
		if(preg_match('/^[07]([0-9]){8}/i',$to_original)) $to_original = '+254'.stristr(''.$to_original.'','7');
		//clean trailing whitespaces
		$to = trim($to_original.','); //Your receipient
		$msg = trim($msg_original); //Your Message
        //create new gateway connection instance
		$gateway = new AfricasTalkingGateway($username,$apikey);
		
		//send message 
		
		//$sent    = $gateway->sendMessage($to,$msg,$from);        //UNCOMMENT HERE
		
		
		//check if there is any result.No Result or empty array for error or failure.
		if(count($sent)) { 
		    //if successful return true
		    return true;

		} else { 
		    //otherwise send an email with error and return false;
				$recepient =  "peter@mombo.co.ke";
				$subject = " SMS not sent";
				$body = " The error code : ".$gateway->getErrorMessage()."\n\n
				Recipient : ".$to_original."	\n
				Message ID : ".$msg_id_original." \n
				Message : ".$msg_original." \n					
				 API_RCODE_SUCCESS, 100 \n
				 API_RCODE_DECRYPT_FAILED, 101 \n
				 API_RCODE_INVALID_AUTH, 102 \n
				 API_RCODE_INVALID_SEPARATOR, 103 \n
				 API_RCODE_INVALID_USERNAME, 104 \n
				 API_RCODE_INVALID_DATA, 105 \n
				 API_RCODE_INVALID_ID, 106 \n
				 API_RCODE_INVALID_RECEIVER, 107 \n
				 API_RCODE_INVALID_SMS, 108 \n
				 API_RCODE_ZERO_CREDIT, 109 \n
				 API_RCODE_INVALID_TIME, 110 \n
				 API_RCODE_ACCESS_DENIED, 111 \n
				 API_RCODE_DUPLICATE_SMS_ID, 112 \n
				 API_RCODE_INVALID_SALT, 113 \n
				 API_RCODE_ILLEGAL, 199 \n
				 API_RCODE_SERVER_MAINTENANCE, 500 \n
				 API_RCODE_INTERNAL_ERROR, 998 \n
				 API_RCODE_UNKNOWN, 999 \n
				 
				 From AskADoc  \n ";
				$headers = "From: admin@mombo.co.ke";
				@mail($recepient, $subject, $body,$headers);
				return false;
		}  
}	
	//**************************************************************************************************
?>
