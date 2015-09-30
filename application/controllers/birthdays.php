<?php if(!defined('BASEPATH')) exit('Access Denied!!');

$currentTime = time();
$flagDate =  date('H:i',$currentTime);    
		   
if (strtotime($flagDate) != strtotime('08:15')){
	if (strtotime($flagDate) != strtotime('09:15')){
		echo "Fuck off!!! ".$flagDate;
		exit;
	}	
}

class Birthdays extends CI_Controller{ 
	public function index(){
			echo "here";
			$this->load->model('reminders_model');
			$this->load->model('birthdays_model');
			
			$customers = $this->birthdays_model->get_customers();
			
			foreach($customers as $customer){
				
				$message = "Dear ".$customer['name'].", with old age comes wisdom. That said, we hope that as you turn a year older God grants you the knowledge to embrace all of life’s blessings. Happy Birthday.";
				
				send_sms($customer['mobiletel'],$message);
				
				$sent_date = date("Y-m-d");
				$this->reminders_model->set_sent_sms($customer['mobiletel'], $message, $sent_date);
				
				echo $customer['mobiletel'].' '.$message; 
			}
			
			$guarantors = $this->birthdays_model->get_guarantors();
			
			foreach($guarantors as $guarantor){
				
				$message = "Dear ".$guarantor['name'].", with old age comes wisdom. That said, we hope that as you turn a year older God grants you the knowledge to embrace all of life’s blessings. Happy Birthday.";
				
				//send_sms($guarantor['mobile'],$message);
				
				$sent_date = date("Y-m-d");
				$this->reminders_model->set_sent_sms($guarantor['mobile'], $message, $sent_date);
				
				//echo $guarantor['mobile'].' '.$message; 
			}
			echo 'here';
		}
}