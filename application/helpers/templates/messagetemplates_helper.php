<?php

 define('DIR_PATH',dirname(__FILE__).'/');
 
 function get_charge_email_template(){
 
 
      return file_get_contents(DIR_PATH.'templates/email-charge-template.html');
	  
 }
 
 function get_charge_sms_template(){
 
	 return file_get_contents(DIR_PATH.'templates/sms-charge-template.txt');

 }
 
 function get_registration_email_template(){
 
	return file_get_contents(DIR_PATH.'templates/email-registration-template.html');
	
 }
 
 function get_registration_sms_template(){
 
	return file_get_contents(DIR_PATH.'templates/sms-registration-template.txt');
	
 }
 
 
 function get_accountactivation_email_template(){
 
	return file_get_contents(DIR_PATH.'templates/email-accountactivation-template.html');
	
 }
 
 function get_accountactivation_sms_template(){
 
	return file_get_contents(DIR_PATH.'templates/sms-accountactivation-template.txt');
	
 }
 
 
 function get_loanaccept_email_template(){
 
	return file_get_contents(DIR_PATH.'templates/email-loanaccept-template.html');
	
 }
 
 function get_loanaccept_sms_template(){
 
	return file_get_contents(DIR_PATH.'templates/sms-loanaccept-template.txt');
	
 }
 
 function get_wallpost_email_template(){
 
	return file_get_contents(DIR_PATH.'templates/email-wallpost-template.html');
	
 }
 
  function  get_paymentreminder_email_template(){
    
	 return file_get_contents(DIR_PATH.'templates/email-paymentreminder-template.html');
	 

 }
 
 function  get_paymentreminder_sms_template(){
    
	 return file_get_contents(DIR_PATH.'templates/sms-paymentreminder-template.txt');
	 
 }
 
 function get_paymentreceived_email_template(){
 
      return file_get_contents(DIR_PATH.'templates/sms-paymentreceived-template.html');
 
 }
 
 function get_paymentreceived_sms_template(){
 
      return file_get_contents(DIR_PATH.'templates/sms-paymentreceived-template.txt');
 
 }
 
 
 function get_one_day_paymentreminder_email(){
 
    return file_get_contents(DIR_PATH.'templates/email-onedaypaymentreminder-template.html');
 
 }
 
 function get_four_days_paymentreminder_email(){
 
    return file_get_contents(DIR_PATH.'templates/email-fourdaypaymentreminder-template.html');
 
 }
 
 
 function get_one_day_paymentreminder_sms(){
 
    return file_get_contents(DIR_PATH.'templates/sms-onedaypaymentreminder-template.txt');
 
 }
 
 function get_four_days_business_paymentreminder_sms(){
 
    return file_get_contents(DIR_PATH.'templates/sms-fourdaypaymentreminder-template.txt');
 
 }
 
  function get_unpaidcheque_email(){
 
    return file_get_contents(DIR_PATH.'templates/email-unpaidcheque-template.html');
 
 }
 
 function get_unpaidcheque_sms(){
 
    return file_get_contents(DIR_PATH.'templates/sms-unpaidcheque-template.txt');
 
 }
 
 
 
 
 