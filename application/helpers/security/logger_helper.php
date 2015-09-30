<?php
   function to_xml_log($type,array $data){
        app_log($type,$data,'xml');
   }
   
   function to_db_log($type,array $data){
        app_log($type,$data,'db');
   }
   
   function app_log($type,array $data,$log_type = 'xml'){
       //Get CI global object instance used to access app config and utils
       $CI   =& get_instance();
	   //convert type of log string to lower
	   $type = strtolower($type);
	   //logpath based on log type
	   $log = null;
	   //log_file_string
	   $log_file = null;
	   //Root element for the log type xml file
	   $docroot = '';
	   //Properties of each entry given the log type
	   $entry_properties = array();
	   //set log type parameters based on log type 
	  if(!empty($data)){
			if($log_type == 'xml'){
				if($type == "access"){
				  $log_file =  $CI->config->item('sec_access_log_file');
				  $docroot  = 'application-access-log';
				  $entry_properties = array(
					   'access-time',//Time of login
					   'user-ip-address',//IP address of client 
					   'userid',
					   'usergroup',
					   'username',
					   'host-name',
					   'user-agent',//Browser or useragent used
					   'at-attempt-no',//Logged in attempts made before success
				  );
				  
			   }elseif($type == "unaccess"){
				  $log_file = $CI->config->item('sec_unaccess_log_file');
				  $docroot  = 'application-unaccess-log';
				  $entry_properties = array(
					   'access-time',
					   'user-ip-address',
					   'userid-entered',
					   'password-entered',
					   'host-name',
					   'user-agent',
					   'at-attempt-no',
				  );
			   }elseif($type == "dblog"){
				  $log_file = $CI->config->item('sec_dbaccess_log_file');
				  $docroot  = 'application-db-log';
				  $entry_properties = array(
				  
				  );
			   }elseif($type == "block"){
				  $log_file  = $CI->config->item('sec_block_log_file');
				  $docroot  = 'application-block-log';
				  $entry_properties = array(
					   'access-time',
					   'user-ip-address',
					   'userid-entered',
					   'password-entered',
					   'host-name',
					   'user-agent',
				  );
			   }
			   
			   if($log_file != null){
						//Load file helper for working with files
						$CI->load->helper('file');
						//Load the log xml file
						//read_file($log_file);
						$log   = @simplexml_load_file($log_file);
						//count the number of entries logged so far
						$children = count($log->entries->children());
						//If number of entries exceed 200, rename the log file to the next log number
						if($children > 2){
							//create a new xml document with the current time stamp on it
							$prev_log = str_replace('.xml','',$log_file).'__ON__'.str_replace('  ','__AT__',date('Y_m_d  G i s')).'.xml';
							//Write the existing logs to the new file
							@write_file($prev_log,$log->asXML());
							//create a new log template for the log type
							$newLog = '<?xml version="1.0" encoding="UTF-8"?>
										 <'.$docroot.'><entries></entries></'.$docroot.'>';
							//clear the log file with the new template
							@write_file($log_file,$newLog,'w');
							//load the new cleared or old log file if not cleared
							$log = @simplexml_load_file($log_file);
						}
						
						//add new entry child to the entries
						$entry = $log->entries->addChild('entry');
						//loop through the entry property array setting the entry
						//properties if only provided in the data param with the right key
						foreach($entry_properties as $property){
						  if(array_key_exists($property,$data)){
							 $entry->addChild($property,$data[$property]);
						  }else{
							 $entry->addChild($property,"Not Available");
						  }
						}
						//Finally write the new entries to the log file
						@write_file($log_file,$log->asXML());
						//Return true no matter what
					return true;
			    }
		   }else{
                if($log_type == 'db'){
				    //Load log model class
                    $CI->load->model('log_model','Log');
					//set log type
					switch($type){
					      case 'access':  $CI->Log->type = 'access';break;
						  case 'unaccess':$CI->Log->type = 'unaccess';break;
						  case 'dblog':   $CI->Log->type = 'dblog';break;
						  case 'block':   $CI->Log->type = 'block';break;
						  default:break;
					}
					//set log meta
					$CI->Log->meta = json_encode($data);
					//log to db
					if($CI->Log->save()) return true;
                }				
		   }
	 }
     return false;	   
   }