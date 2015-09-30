<?php if(!defined('BASEPATH')) exit('Access Denied!!');

$currentTime = time();
$flagDate =  date('H:i',$currentTime);    
		   
if (strtotime($flagDate) != strtotime('08:12')){
	if (strtotime($flagDate) != strtotime('09:12')){
		echo "Fuck off!!!";
		exit;
	}	
}

class Debt_collection extends CI_Controller{ 
	public function index(){
		
		$this->load->model('debtcollection_model');
		
		$this->load->model('penalties_model');
		
		$this->load->model('loan_transactions_model');
		
		//get grace period of each loan product
		$grace_periods = $this->debtcollection_model->get_grace_period();
		
		//get all expected payment
		$expected_payments = $this->debtcollection_model->get_expected_payments();
		$is_penalty = 0;
		$is_reminder = 0;
		foreach($expected_payments as $expected_payment){
			$loan_product = $this->debtcollection_model->get_loan_product($expected_payment["loan"]);
			$loan_product_id = $loan_product["loan_product"];
			$customer_id = $loan_product["customer"];
			
			$amount_due = $this->debtcollection_model->get_amount_due($expected_payment["id"],$expected_payment["loan"]);
			$grace_days = 0;
			$percent = 0;
			foreach($grace_periods as $grace_period){
				if($grace_period["id"] == $loan_product_id){
					$grace_days = $grace_period["grace_days"];
					$percent = $grace_period["past_grace_percent"];
					break;
				}
			}
			if($grace_days == 0){
				continue;
			}
			$current_date = strtotime(date('Y-m-d')); 
			$date_diff = $current_date - strtotime($expected_payment["initial_expected_date"]);
			$days_elapsed = floor($date_diff/(60*60*24));
			
			$days_to_debt_collection = $grace_days - $days_elapsed;
			/*echo $expected_payment["initial_expected_date"]." ".$date_diff." ".$grace_days." ".$days_elapsed." ".$days_to_debt_collection."<br />"; */
			if( ($days_to_debt_collection == 5) || ($days_to_debt_collection == 3) || ($days_to_debt_collection == 1) ){
				//send reminder message
				
				$collection_date = date("d M Y", strtotime("+".$days_to_debt_collection." day", $current_date));
				$customer = $this->debtcollection_model->get_customer($customer_id);
				$customer_first_name = $customer["name"];
				$customer_mobile = $customer["mobiletel"];
				
				$message = 'Dear '.$customer_first_name.', be advised that your loan is in arrears of KSH. '.$amount_due.' and on '.$collection_date.' your loan will be transfered to Debt Recovery Unit. Kindly clear your debt before the aforesaid date.';
					
				send_sms($customer_mobile,$message);
				
				$sent_date = date("Y-m-d");
				$this->penalties_model->set_sent_sms($customer_mobile, $message, $sent_date);
				$is_reminder = 1;
			}
			
			
			if( $days_elapsed == ($grace_days + 1) ){
				$charges_amount = 0;
				$penalty_amount = 0;
				$charges = $this->debtcollection_model->get_charges($expected_payment["loan"]);
				
				$customer = $this->debtcollection_model->get_customer($customer_id);
				
				$customer_first_name = $customer["name"];
				$customer_mobile = $customer["mobiletel"];
				
				$add_to_debt = $this->debtcollection_model->add_to_debt($expected_payment["id"]);
				
				foreach($charges as $charge){
					$charges_amount += $charge["balance"] - $charge["waiver"];
				}
				
				$penalty_amount = $percent * ($expected_payment["balance"] + $expected_payment["interest_amount_balance"] + $charges_amount);
				$penalty_amount = round($penalty_amount);
				$penalty_name = 'Debt recovery penalty';
				$date = date("Y-m-d");
				$loan_id = $expected_payment["loan"];
				$transaction_code = $expected_payment["transaction_code"];
				if($penalty_amount > 0){
					$this->penalties_model->set_penalty($transaction_code,$penalty_name, $loan_id, $date, $penalty_amount);
									
					$message = 'Dear '.$customer_first_name.', kindly be advised that your loan arrears of KSH. '.$amount_due.' has accrued a debt recovery penalty of KSH. '.$penalty_amount;
					
					send_sms($customer_mobile,$message);
					
					$sent_date = date("Y-m-d");
					$this->penalties_model->set_sent_sms($customer_mobile, $message, $sent_date);
					
					//add loan transaction
					$trans = 'Debt Collection Fee'; 
					$trans_description = '-';
					$is_credit = 0;
					$this->loan_transactions_model->add_transaction($loan_id,$trans,$trans_description,$is_credit,$penalty_amount);
					
					//echo $customer_mobile.' '.$message; 
					$is_penalty = 1;
				}
			}
		}
		if($is_reminder == 1){
			echo 'Grace reminder executed.<br />';
		}
		if($is_penalty == 1){
			echo 'Debt Collection penalty executed.<br />';
		}
		echo 'here!';
	}
        
			
}