<?php if(!defined('BASEPATH')) exit();

$currentTime = time();
$flagDate =  date('H:i',$currentTime);    
		   
if (strtotime($flagDate) != strtotime('09:00')){
	if (strtotime($flagDate) != strtotime('10:00')){
		echo "Fuck off!!!";
		//exit;
	}	
}

class Sms_reminders extends CI_Controller{
 
        public function index(){
        
			$this->load->model('reminders_model');
			
			$customers_details = $this->reminders_model->get_customers();
			
			for($i=0;$i<count($customers_details);$i++){
				$total_amt_due = 0;
				$customer = $customers_details[$i];
				$customer_details = explode('*', $customer);
				$customer_first_name = $customer_details[0];
				$customer_other_names = $customer_details[1];
				$customer_mobile = $customer_details[2];
				$principal_bal = $customer_details[3];
				$interest_bal = $customer_details[4];
				$charges_amt = $customer_details[5];
				$arrears_amt = $customer_details[6];
				$date_due = $customer_details[7];
				
				$total_amt_due = $principal_bal+$interest_bal+$charges_amt+$arrears_amt;
				
				
				$message = 'Dear '.$customer_first_name.', kindly be advised that your loan of KSH. '.$total_amt_due.' is due on '.$date_due.'. Amount breakdown; Month Principal: KSH. '.$principal_bal.', Month Interest: KSH. '.$interest_bal.', Penalties: KSH. '.$charges_amt.', Arrears: KSH. '.$arrears_amt;
				
				send_sms($customer_mobile,$message);
				
				$sent_date = date("Y-m-d");
				$this->reminders_model->set_sent_sms($customer_mobile, $message, $sent_date);
				
				//echo $customer_mobile.' '.$message; exit;
				//echo "here a ";
			}
			
			$customers_details_b = $this->reminders_model->get_customers_b();
			
			for($i=0;$i<count($customers_details_b);$i++){
				$total_amt_due = 0;
				$customer = $customers_details_b[$i];
				$customer_details_b = explode('*', $customer);
				$customer_first_name = $customer_details_b[0];
				$customer_other_names = $customer_details_b[1];
				$customer_mobile = $customer_details_b[2];
				$principal_bal = $customer_details_b[3];
				$interest_bal = $customer_details_b[4];
				$charges_amt = $customer_details_b[5];
				$arrears_amt = $customer_details_b[6];
				$date_due = $customer_details_b[7];
				$penalty_date = $customer_details_b[8];
				
				$total_amt_due = $principal_bal+$interest_bal+$charges_amt+$arrears_amt;
				
				//Dear (name), please be advised that you may reduce or clear your outstanding loan of ksh.(sum) on or before the (date)
				
				$message = 'Dear '.$customer_first_name.', please be advised that you may reduce or clear your outstanding loan of KSH. '.$total_amt_due.' before '.$penalty_date.'. Thank you.';
				
				send_sms($customer_mobile,$message);
				
				$sent_date = date("Y-m-d");
				$this->reminders_model->set_sent_sms($customer_mobile, $message, $sent_date);
				
				//echo $customer_mobile.' '.$message; exit;
				//echo "here b ";
			}
			
			echo "done";
		}

}		