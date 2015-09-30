<?php if(!defined('BASEPATH')) exit();

$currentTime = time();
$flagDate =  date('H:i',$currentTime);    
		   
if (strtotime($flagDate) != strtotime('08:05')){
	if (strtotime($flagDate) != strtotime('09:05')){
		echo "Fuck off!!!";
		//exit;
	}	
}

class Execute_penalties extends CI_Controller{
	 public function index(){
        
		$this->load->model('penalties_model');
		$this->load->model('loan_transactions_model');
		
		$customers_details = $this->penalties_model->get_customers_a();
		
		for($i=0;$i<count($customers_details);$i++){
			$total_amt_due = 0; 
			$late_payment_fee_percent = 0;
			$penalty = 0;
			
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
			$loan_id= $customer_details[8];
			$transaction_code= $customer_details[9];
			$expected_id = $customer_details[10];
			
			if( ($this->penalties_model->get_loan_product($transaction_code) == 1) || ($this->penalties_model->get_loan_product($transaction_code) == 5) ){
				continue;
			}
			
			
			$total_amt_due = $principal_bal+$interest_bal+$charges_amt+$arrears_amt;
			
			$late_payment_fee_percent = $this->penalties_model->get_percent($transaction_code);
			
			$penalty = round( ( ($late_payment_fee_percent * $total_amt_due)/100) );
			
			$penalty_name = 'latepayment_fee';
			$date = date("Y-m-d");
			if($penalty > 0){
				$this->penalties_model->set_penalty($transaction_code,$penalty_name, $loan_id, $date, $penalty);
				
				//add loan transaction
				$trans = 'Late Payment Fee'; 
				$trans_description = '-';
				$is_credit = 0;
				$this->loan_transactions_model->add_transaction($loan_id,$trans,$trans_description,$is_credit,$penalty);
			
			
				$message = 'Dear '.$customer_first_name.', kindly be advised that your loan is past due in payment and has accrued a late payment fee of KSH. '.$penalty.'. Remit your payment as soon as possible';
				
				send_sms($customer_mobile,$message);
				
				$sent_date = date("Y-m-d");
				$this->penalties_model->set_sent_sms($customer_mobile, $message, $sent_date);
				
				//echo $customer_mobile.' '.$message; 
			}
			
			if( ($this->penalties_model->get_loan_product($transaction_code) == 3) || ($this->penalties_model->get_loan_product($transaction_code) == 4) ){
				$new_time = strtotime($date_due." +7 day");
				$new_date_due = date('Y-m-d', $new_time);
				
				$this->penalties_model->set_new_due_date($expected_id, $new_date_due);
			}
			echo 'here a ';
		}
		
		$customers_details_personal = $this->penalties_model->get_customers_b();
		
		for($j=0;$j<count($customers_details_personal);$j++){
			$total_amt_due = 0; 
			$interest_fee_percent = 0;
			$interest_fee = 0;
			
			$customer = $customers_details_personal[$j];
			
			$customer_details = explode('*', $customer);
			$customer_first_name = $customer_details[0];
			$customer_other_names = $customer_details[1];
			$customer_mobile = $customer_details[2];
			$principal_bal = $customer_details[3];
			$interest_bal = $customer_details[4];
			$charges_amt = $customer_details[5];
			$date_due = $customer_details[6];
			$loan_id= $customer_details[7];
			$transaction_code= $customer_details[8];
			$expected_id= $customer_details[9];
			$penalty_date = $customer_details[10];
			
			if($penalty_date == "0000-00-00"){
				//echo "hapa";
			}
			//echo "here ".$penalty_date; exit;
			
			if($this->penalties_model->get_loan_product($transaction_code) != 1){
				if($this->penalties_model->get_loan_product($transaction_code) == 5){
					$new_time = strtotime($date_due." +1 month");
					$new_date_due = date('Y-m-d', $new_time);
					
					$this->penalties_model->set_new_due_date($expected_id, $new_date_due);	
					
				}
				continue;
			}
									
			$total_amt_due = $principal_bal+$interest_bal+$charges_amt;
			
			//$interest_fee_percent = $this->penalties_model->get_interest_percent($transaction_code);
			
			//$interest_fee = round( ( ($interest_fee_percent * $total_amt_due)/100) );
			
			$late_payment_fee_percent = $this->penalties_model->get_percent($transaction_code);
			
			$penalty = round( ( ($late_payment_fee_percent * $total_amt_due)/100) );
			
			$penalty_name = 'latepayment_fee';
			
			$new_time = strtotime($date_due." +1 month");
			$new_date_due = date('Y-m-d', $new_time);
			
			$this->penalties_model->set_new_due_date($expected_id, $new_date_due);
			
			//$interest_fee_name = 'latepayment_fee'; //'interest_fee';
			$date = date("Y-m-d");
			if($penalty > 0 && ($penalty_date == "0000-00-00")){
				$this->penalties_model->set_penalty($transaction_code,$penalty_name, $loan_id, $date, $penalty);
				
				$new_penalty_time = strtotime($date_due." +8 day");
				$new_penalty_date = date('Y-m-d', $new_penalty_time);
			
				$this->penalties_model->set_new_penalty_date($expected_id, $new_penalty_date);
				
				//add loan transaction
				$trans = 'Late Payment Fee'; //'Accrued Interest'; 
				$trans_description = '-';
				$is_credit = 0;
				$this->loan_transactions_model->add_transaction($loan_id,$trans,$trans_description,$is_credit,$penalty);
			
				//$message = 'Dear '.$customer_first_name.', kindly be advised that your loan has accrued an interest fee of KSH. '.$interest_fee;
				$message = 'Dear '.$customer_first_name.', kindly be advised that your loan has accrued a late payment fee of KSH. '.$penalty.'. Thank you.';
				send_sms($customer_mobile,$message);
				
				$sent_date = date("Y-m-d");
				$this->penalties_model->set_sent_sms($customer_mobile, $message, $sent_date);
				
				//echo $customer_mobile.' '.$message; 
			}
			echo 'here b ';
		}
		
		$customers_details_personal1 = $this->penalties_model->get_customers_c();
		for($j=0;$j<count($customers_details_personal1);$j++){ 
			$total_amt_due = 0; 
			$interest_fee_percent = 0;
			$interest_fee = 0;
			
			$customer = $customers_details_personal1[$j];
			
			$customer_details = explode('*', $customer);
			$customer_first_name = $customer_details[0];
			$customer_other_names = $customer_details[1];
			$customer_mobile = $customer_details[2];
			$principal_bal = $customer_details[3];
			$interest_bal = $customer_details[4];
			$charges_amt = $customer_details[5];
			$date_due = $customer_details[6];
			$loan_id= $customer_details[7];
			$transaction_code= $customer_details[8];
			$expected_id= $customer_details[9];
			
									
			$total_amt_due = $principal_bal+$interest_bal+$charges_amt;
			
			//$interest_fee_percent = $this->penalties_model->get_interest_percent($transaction_code);
			
			//$interest_fee = round( ( ($interest_fee_percent * $total_amt_due)/100) );
			$late_payment_fee_percent = $this->penalties_model->get_percent($transaction_code);
			
			$penalty = round( ( ($late_payment_fee_percent * $total_amt_due)/100) );
			
			$penalty_name = 'latepayment_fee';
			
			$date = date("Y-m-d");
			
			$new_penalty_time = strtotime($date." +7 day");
			$new_penalty_date = date('Y-m-d', $new_penalty_time);
			
			$this->penalties_model->set_new_penalty_date($expected_id, $new_penalty_date);
			
			//$interest_fee_name = 'latepayment_fee'; //'interest_fee';
			
			if($penalty > 0){
				$this->penalties_model->set_penalty($transaction_code,$penalty_name, $loan_id, $date, $penalty);
				
				//add loan transaction
				$trans = 'Late Payment Fee'; //'Accrued Interest'; 
				$trans_description = '-';
				$is_credit = 0;
				$this->loan_transactions_model->add_transaction($loan_id,$trans,$trans_description,$is_credit,$penalty);
			
				//$message = 'Dear '.$customer_first_name.', kindly be advised that your loan has accrued an interest fee of KSH. '.$interest_fee;
				$message = 'Dear '.$customer_first_name.', kindly be advised that your loan has accrued a late payment fee of KSH. '.$penalty.'. Thank you.';
				send_sms($customer_mobile,$message);
				
				$sent_date = date("Y-m-d");
				$this->penalties_model->set_sent_sms($customer_mobile, $message, $sent_date);
				
				//echo $customer_mobile.' '.$message; 
			}
			echo 'here c ';
		}
		
		echo 'here done!!';
	}
}