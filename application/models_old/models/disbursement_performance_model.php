<?php
class Disbursement_performance_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_details($date_check,$date,$date_check1){ 
		$details = array();
		
		$this->db->select("percent");
		$this->db->where("date_ LIKE '".$date."%'");
		$this->db->where("is_deleted = 0");
		$query = $this->db->get("t_disbursement_targets");
		$disbursement_target_array = $query->row_array();
		$disbursement_target = $disbursement_target_array["percent"];
		
		$this->db->select("product_id,percent");
		$this->db->where("date_ LIKE '".$date."%'");
		$this->db->where("is_deleted = 0");
		$query = $this->db->get("t_products_targets");
		$products = $query->result_array();
		foreach($products as $product){
			$product_id = $product["product_id"]; //echo "fff ".$product_id; exit;
			$target = $product["percent"] * $disbursement_target * $this->get_loans_opening_bal($date_check,$date,$date_check1); 
			//echo $target; exit;
			$target_amount = number_format($target,2,'.',','); //echo $target; exit;
			$actual = $this->get_actual($date,$product_id); //echo $actual; exit;
			$actual_amount = number_format($actual,2,'.',','); //echo $actual; exit;
			$performance = round(($actual/$target)*100,2); 
			//echo $product_id."*".$target_amount."*".$actual_amount."*".$performance; exit;
			$details[] = $product_id."*".$target."*".$actual."*".$performance;
		}
		return $details;
	}
	
	public function get_loans_opening_bal($date_check,$date,$date_check1){
		$this->db->select("id");
		$this->db->where("request_status = 2 AND loan_issue_date < '".$date_check."' AND (loan_status = 0 OR date_settled >= '".$date_check."')");
		$query = $this->db->get("loans");
		$loan_ids = $query->result_array();
		$loan_opening_bal = 0;
		
		foreach($loan_ids as $loan_id){ 
			/*if($loan_product_id == 3){ echo "test ".$loan_opening_bal."<br />"; }*/
			$this->db->select("balance");
			//$this->db->where("loan = ".$loan_id["id"]." AND paid = 0 AND initial_expected_date <= '".$date_check1."'");
			$this->db->where("loan = ".$loan_id["id"]." AND paid = 0 ");
			$query = $this->db->get("loan_expected_payments");
			$balances = $query->result_array();
			foreach($balances as $balance){ 
				//if($loan_product_id == 3){ /*echo "test1 ".$loan_opening_bal."<br />";*/ }
				$loan_opening_bal += $balance["balance"];
				/*if($loan_product_id == 3){
					echo "here ".$loan_id["id"]." ".$loan_opening_bal."<br />";
				}*/
			}
			
			$this->db->select("interest_amount_balance");
			$this->db->where("loan = ".$loan_id["id"]." AND paid = 0");
			//$this->db->where("loan = ".$loan_id["id"]." AND paid = 0 ");
			$query = $this->db->get("loan_expected_payments");
			$balances = $query->result_array();
			foreach($balances as $balance){ 
				//if($loan_product_id == 3){ /*echo "test1 ".$loan_opening_bal."<br />";*/ }
				$loan_opening_bal += $balance["interest_amount_balance"];
				/*if($loan_product_id == 3){
					echo "here ".$loan_id["id"]." ".$loan_opening_bal."<br />";
				}*/
			}
			
			/*echo "test2 ".$loan_opening_bal."<br />";*/
			$this->db->select("amount");
			$this->db->where("loan_id = ".$loan_id["id"]." AND paid = 0 AND dateTime < '".$date_check." 00:00:00'");
			$query = $this->db->get("t_transaction_fees");
			$balances = $query->result_array();
			foreach($balances as $balance){
				$loan_opening_bal += $balance["amount"];
				/*echo "test3 ".$loan_opening_bal."<br />";*/
			}
			
			$this->db->select("balance");
			$this->db->where("loan = ".$loan_id["id"]." AND paid = 0 AND date < '".$date_check."'");
			$query = $this->db->get("loan_charges");
			$balances = $query->result_array();
			foreach($balances as $balance){
				$loan_opening_bal += $balance["balance"];
				/*if($loan_product_id == 3){
					echo "hapa ".$loan_id["id"]." ".$loan_opening_bal."<br />";
				}*/
			}
			
			$this->db->select("id");
			//$this->db->where("loan = ".$loan_id["id"]." AND initial_expected_date <= '".$date_check1."'");
			$this->db->where("loan = ".$loan_id["id"]);
			$query = $this->db->get("loan_expected_payments");
			$expected_ids = $query->result_array();
			foreach($expected_ids as $expected_id){
				$this->db->select("payment_amount");
				$this->db->where("payment = ".$expected_id["id"]." AND payment_date >= '".$date_check."' AND is_deleted = 0");
				$query = $this->db->get("loan_payments");
				$payments = $query->result_array();
				foreach($payments as $payment){
					$loan_opening_bal += $payment["payment_amount"];
					/*if($loan_product_id == 3){
						echo "sss ".$loan_id["id"]." ".$payment["payment_amount"]."<br />";
					}*/
				}
			}
			
			$this->db->select("id");
			$this->db->where("loan = ".$loan_id["id"]." AND date < '".$date_check."'");
			$query = $this->db->get("loan_charges");
			$charge_ids = $query->result_array();
			foreach($charge_ids as $charge_id){
				$this->db->select("amount");
				$this->db->where("charge = ".$charge_id["id"]." AND date >= '".$date_check."' AND is_deleted = 0");
				$query = $this->db->get("loan_charges_payments");
				$amounts = $query->result_array();
				foreach($amounts as $amount){
					$loan_opening_bal += $amount["amount"];
					/*if($loan_product_id == 3){
						echo "ggg ".$loan_id["id"]." ".$amount["amount"]."<br />";
					}*/
				}
			}
		
		}
		return $loan_opening_bal;
	}
	
	public function get_actual($date,$product_id){
		$actual_disbursement = 0;
		$this->db->select("loan_principle_amount");
		$this->db->where("loan_issue_date LIKE '".$date."%' AND loan_product = ".$product_id." AND request_status = 2");
		$query = $this->db->get("loans");
		$disbursements = $query->result_array();
		foreach($disbursements as $disbursement){
			$actual_disbursement += $disbursement["loan_principle_amount"];
		}
		return $actual_disbursement;
	}
	
	public function get_previous_collection_target($date,$date1){
		$this->db->select("id,loan,balance,interest_amount_balance,initial_expected_date,date_expected");
		$this->db->where("date_expected LIKE '".$date."%' OR initial_expected_date <= '".$date1."'");
		$query = $this->db->get("loan_expected_payments");
		$expected_payments = $query->result_array();
		$all_details = array();
		$total_target_amount = 0;
		$total_actual_amount = 0;
		$performance = 0;
		$expected_ids = array();
		$charge_ids_array = array();
		$initial_expected_date = "";
		foreach($expected_payments as $expected_payment){
			
			if(in_array($expected_payment["id"],$expected_ids)) continue;
			$target_amount = 0;
			$actual_amount = 0;
			$loan_id = $expected_payment["loan"];
			$date_expected = $expected_payment["date_expected"];
			//$loan_ids[] = $expected_payment["loan"];
						
			$this->db->select("customer,loan_product");
			$this->db->where("id = ".$loan_id);
			$query = $this->db->get("loans");
			$loan_details = $query->row_array();
			$customer_id = $loan_details["customer"];
			$loan_product_id = $loan_details["loan_product"];
			
			$this->db->select("loan_product_name");
			$this->db->where("id = ".$loan_product_id);
			$query = $this->db->get("loan_products");
			$loan_product = $query->row_array();
			$loan_product_name = $loan_product["loan_product_name"];
			
			$this->db->select("name,other_names");
			$this->db->where("id = ".$customer_id);
			$query = $this->db->get("customers");
			$customer_details = $query->row_array();
			$customer_name = $customer_details["name"]." ".$customer_details["other_names"];
			
			if($loan_product_id != 2){ 
				$expected_ids[] = $expected_payment["id"];
				$target_amount += $expected_payment["balance"] + $expected_payment["interest_amount_balance"];
				$total_target_amount += $expected_payment["balance"] + $expected_payment["interest_amount_balance"];
				$initial_expected_date = $expected_payment["initial_expected_date"];
			}
			else{ 
				$this->db->select("id,loan,balance,interest_amount_balance,initial_expected_date,date_expected");
				$this->db->where("loan = ".$loan_id." AND (initial_expected_date <= '".$date1."' OR initial_expected_date LIKE '".$date."%')");
				$query = $this->db->get("loan_expected_payments");
				$expec_payments = $query->result_array();
				foreach($expec_payments as $expec_payment){ 
					$date_expected = $expec_payment["date_expected"];
					$initial_expected_date = $expec_payment["initial_expected_date"];
					$expected_ids[] = $expec_payment["id"];
					//if($loan_id == 97) echo "hapa ".$loan_id." here ".$expec_payment["id"]." ";
					$target_amount += $expec_payment["balance"] + $expec_payment["interest_amount_balance"];
					$total_target_amount += $expec_payment["balance"] + $expec_payment["interest_amount_balance"];
					$this->db->select("payment_amount");
					$this->db->where("payment = ".$expec_payment["id"]." AND payment_date LIKE '".$date."%' AND is_deleted = 0");
					$query = $this->db->get("loan_payments");
					$payments = $query->result_array(); 
					foreach($payments as $payment){ 
						$target_amount += $payment["payment_amount"];
						$total_target_amount += $payment["payment_amount"];
						$actual_amount += $payment["payment_amount"];
					}
				}
				
				$this->db->select("id");
				$this->db->where("loan = ".$loan_id." AND initial_expected_date > '".$date1."'");
				$query = $this->db->get("loan_expected_payments");
				$expe_payments = $query->result_array();
				foreach($expe_payments as $expe_payment){ 
					$expected_ids[] = $expe_payment["id"];
					$this->db->select("payment_amount");
					$this->db->where("payment = ".$expe_payment["id"]." AND payment_date LIKE '".$date."%' AND is_deleted = 0");
					$query = $this->db->get("loan_payments");
					$payments_made = $query->result_array(); 
					foreach($payments_made as $payment_made){ 
						$actual_amount += $payment_made["payment_amount"];
					}
				}
			}
			if($loan_product_id == 3 || $loan_product_id == 4){
				$this->db->select("balance,date");
				$this->db->where("loan = ".$loan_id." AND paid = 0 AND date LIKE '".$date."%'");
				$query = $this->db->get("loan_charges");
				$charges = $query->result_array();
				foreach($charges as $charge){
					$date_determiner_ = strtotime($charge["date"]." +7 day");
					$date_determiner = date('Y-m', $date_determiner_);
					
					if($date_determiner != $date){
						continue;
					}
					
					$target_amount += $charge["balance"];
					$total_target_amount += $charge["balance"];
				}
			}
			else{
				$this->db->select("balance");
				$this->db->where("loan = ".$loan_id." AND paid = 0 AND date < '".$date."-01'");
				$query = $this->db->get("loan_charges");
				$charges = $query->result_array();
				foreach($charges as $charge){
					$target_amount += $charge["balance"];
					$total_target_amount += $charge["balance"];
				}
			}
						
			if($loan_product_id == 3 || $loan_product_id == 4){
				$this->db->select("id,date");
				$this->db->where("loan = ".$loan_id." AND date LIKE '".$date."%'");
				$query = $this->db->get("loan_charges");
				$charge_ids = $query->result_array();
				foreach($charge_ids as $charge_id){ 
					$date_determiner_ = strtotime($charge_id["date"]." +7 day");
					$date_determiner = date('Y-m', $date_determiner_);
					
					if($date_determiner != $date){
						continue;
					}
					
					$charge_ids_array[] = $charge_id["id"];
					$this->db->select("amount");
					$this->db->where("charge = ".$charge_id["id"]." AND date LIKE '".$date."%' AND is_deleted = 0");
					$query = $this->db->get("loan_charges_payments");
					$charge_payments = $query->result_array(); 
					foreach($charge_payments as $charge_payment){ 
						$target_amount += $charge_payment["amount"];
						$total_target_amount += $charge_payment["amount"];
					}
				}
			}
			else{
				$this->db->select("id");
				$this->db->where("loan = ".$loan_id." AND date < '".$date."-01'");
				$query = $this->db->get("loan_charges");
				$charge_ids = $query->result_array();
				foreach($charge_ids as $charge_id){ 
					$charge_ids_array[] = $charge_id["id"];
					$this->db->select("amount");
					$this->db->where("charge = ".$charge_id["id"]." AND date LIKE '".$date."%' AND is_deleted = 0");
					$query = $this->db->get("loan_charges_payments");
					$charge_payments = $query->result_array(); 
					foreach($charge_payments as $charge_payment){ 
						$target_amount += $charge_payment["amount"];
						$total_target_amount += $charge_payment["amount"];
					}
				}
			}
			
			$this->db->select("id");
			$this->db->where("loan = ".$loan_id);
			$query = $this->db->get("loan_charges");
			$charge_ids = $query->result_array();
			foreach($charge_ids as $charge_id){ 
				$this->db->select("amount");
				$this->db->where("charge = ".$charge_id["id"]." AND date LIKE '".$date."%' AND is_deleted = 0");
				$query = $this->db->get("loan_charges_payments");
				$charge_payments = $query->result_array(); 
				foreach($charge_payments as $charge_payment){ 
					$actual_amount += $charge_payment["amount"];
				}
			}
			
						
			if($loan_product_id <> 2){
				$this->db->select("payment_amount");
				$this->db->where("payment = ".$expected_payment["id"]." AND payment_date LIKE '".$date."%' AND is_deleted = 0");
				$query = $this->db->get("loan_payments");
				$payments = $query->result_array(); 
				foreach($payments as $payment){ 
					$target_amount += $payment["payment_amount"];
					$total_target_amount += $payment["payment_amount"];
					$actual_amount += $payment["payment_amount"];
				}
			}
			
			
			if($target_amount == 0 && $actual_amount == 0){
				continue;
			}
			/*$all_details[] = $customer_name."*".$customer_id."*".$loan_product_name."*".$loan_id."*".$target_amount."*".$actual_amount."*".$date_expected."*".$initial_expected_date;*/
			
		}	
		return $total_target_amount;
	}
	
	public function get_loan_product($id){
		$this->db->select("loan_product_name");
		$this->db->where("id = ".$id);
		$query = $this->db->get("loan_products");
		$product_array = $query->row_array();
		return $product_array["loan_product_name"];
	}
	
	
	
	
	public function get_all_details($date,$date1){ 
		$this->db->select("id,loan,balance,interest_amount_balance,initial_expected_date,date_expected");
		$this->db->where("date_expected LIKE '".$date."%' OR initial_expected_date <= '".$date1."'");
		$query = $this->db->get("loan_expected_payments");
		$expected_payments = $query->result_array();
		$all_details = array();
		$total_target_amount = 0;
		$total_actual_amount = 0;
		$performance = 0;
		$expected_ids = array();
		$charge_ids_array = array();
		$initial_expected_date = "";
		foreach($expected_payments as $expected_payment){
			
			if(in_array($expected_payment["id"],$expected_ids)) continue;
			$target_amount = 0;
			$actual_amount = 0;
			$loan_id = $expected_payment["loan"];
			$date_expected = $expected_payment["date_expected"];
			//$loan_ids[] = $expected_payment["loan"];
						
			$this->db->select("customer,loan_product");
			$this->db->where("id = ".$loan_id);
			$query = $this->db->get("loans");
			$loan_details = $query->row_array();
			$customer_id = $loan_details["customer"];
			$loan_product_id = $loan_details["loan_product"];
			
			$this->db->select("loan_product_name");
			$this->db->where("id = ".$loan_product_id);
			$query = $this->db->get("loan_products");
			$loan_product = $query->row_array();
			$loan_product_name = $loan_product["loan_product_name"];
			
			$this->db->select("name,other_names");
			$this->db->where("id = ".$customer_id);
			$query = $this->db->get("customers");
			$customer_details = $query->row_array();
			$customer_name = $customer_details["name"]." ".$customer_details["other_names"];
			
			if($loan_product_id != 2){ 
				$expected_ids[] = $expected_payment["id"];
				$target_amount += $expected_payment["balance"] + $expected_payment["interest_amount_balance"];
				$initial_expected_date = $expected_payment["initial_expected_date"];
			}
			else{ 
				$this->db->select("id,loan,balance,interest_amount_balance,initial_expected_date,date_expected");
				$this->db->where("loan = ".$loan_id." AND (initial_expected_date <= '".$date1."' OR initial_expected_date LIKE '".$date."%')");
				$query = $this->db->get("loan_expected_payments");
				$expec_payments = $query->result_array();
				foreach($expec_payments as $expec_payment){ 
					$date_expected = $expec_payment["date_expected"];
					$initial_expected_date = $expec_payment["initial_expected_date"];
					$expected_ids[] = $expec_payment["id"];
					//if($loan_id == 97) echo "hapa ".$loan_id." here ".$expec_payment["id"]." ";
					$target_amount += $expec_payment["balance"] + $expec_payment["interest_amount_balance"];
					$this->db->select("payment_amount");
					$this->db->where("payment = ".$expec_payment["id"]." AND payment_date LIKE '".$date."%' AND is_deleted = 0");
					$query = $this->db->get("loan_payments");
					$payments = $query->result_array(); 
					foreach($payments as $payment){ 
						$target_amount += $payment["payment_amount"];
						$actual_amount += $payment["payment_amount"];
					}
				}
				
				$this->db->select("id");
				$this->db->where("loan = ".$loan_id." AND initial_expected_date > '".$date1."'");
				$query = $this->db->get("loan_expected_payments");
				$expe_payments = $query->result_array();
				foreach($expe_payments as $expe_payment){ 
					$expected_ids[] = $expe_payment["id"];
					$this->db->select("payment_amount");
					$this->db->where("payment = ".$expe_payment["id"]." AND payment_date LIKE '".$date."%' AND is_deleted = 0");
					$query = $this->db->get("loan_payments");
					$payments_made = $query->result_array(); 
					foreach($payments_made as $payment_made){ 
						$actual_amount += $payment_made["payment_amount"];
					}
				}
			}
			if($loan_product_id == 3 || $loan_product_id == 4){
				$this->db->select("balance,date");
				$this->db->where("loan = ".$loan_id." AND paid = 0 AND date LIKE '".$date."%'");
				$query = $this->db->get("loan_charges");
				$charges = $query->result_array();
				foreach($charges as $charge){
					$date_determiner_ = strtotime($charge["date"]." +7 day");
					$date_determiner = date('Y-m', $date_determiner_);
					
					if($date_determiner != $date){
						continue;
					}
					
					$target_amount += $charge["balance"];
					$total_target_amount += $charge["balance"];
				}
			}
			else{
				$this->db->select("balance");
				$this->db->where("loan = ".$loan_id." AND paid = 0 AND date < '".$date."-01'");
				$query = $this->db->get("loan_charges");
				$charges = $query->result_array();
				foreach($charges as $charge){
					$target_amount += $charge["balance"];
					$total_target_amount += $charge["balance"];
				}
			}
						
			if($loan_product_id == 3 || $loan_product_id == 4){
				$this->db->select("id,date");
				$this->db->where("loan = ".$loan_id." AND date LIKE '".$date."%'");
				$query = $this->db->get("loan_charges");
				$charge_ids = $query->result_array();
				foreach($charge_ids as $charge_id){ 
					$date_determiner_ = strtotime($charge_id["date"]." +7 day");
					$date_determiner = date('Y-m', $date_determiner_);
					
					if($date_determiner != $date){
						continue;
					}
					
					$charge_ids_array[] = $charge_id["id"];
					$this->db->select("amount");
					$this->db->where("charge = ".$charge_id["id"]." AND date LIKE '".$date."%' AND is_deleted = 0");
					$query = $this->db->get("loan_charges_payments");
					$charge_payments = $query->result_array(); 
					foreach($charge_payments as $charge_payment){ 
						$target_amount += $charge_payment["amount"];
						$total_target_amount += $charge_payment["amount"];
					}
				}
			}
			else{
				$this->db->select("id");
				$this->db->where("loan = ".$loan_id." AND date < '".$date."-01'");
				$query = $this->db->get("loan_charges");
				$charge_ids = $query->result_array();
				foreach($charge_ids as $charge_id){ 
					$charge_ids_array[] = $charge_id["id"];
					$this->db->select("amount");
					$this->db->where("charge = ".$charge_id["id"]." AND date LIKE '".$date."%' AND is_deleted = 0");
					$query = $this->db->get("loan_charges_payments");
					$charge_payments = $query->result_array(); 
					foreach($charge_payments as $charge_payment){ 
						$target_amount += $charge_payment["amount"];
						$total_target_amount += $charge_payment["amount"];
					}
				}
			}
			
			$this->db->select("id");
			$this->db->where("loan = ".$loan_id);
			$query = $this->db->get("loan_charges");
			$charge_ids = $query->result_array();
			foreach($charge_ids as $charge_id){ 
				$this->db->select("amount");
				$this->db->where("charge = ".$charge_id["id"]." AND date LIKE '".$date."%' AND is_deleted = 0");
				$query = $this->db->get("loan_charges_payments");
				$charge_payments = $query->result_array(); 
				foreach($charge_payments as $charge_payment){ 
					$actual_amount += $charge_payment["amount"];
				}
			}
			
						
			if($loan_product_id <> 2){
				$this->db->select("payment_amount");
				$this->db->where("payment = ".$expected_payment["id"]." AND payment_date LIKE '".$date."%' AND is_deleted = 0");
				$query = $this->db->get("loan_payments");
				$payments = $query->result_array(); 
				foreach($payments as $payment){ 
					$target_amount += $payment["payment_amount"];
					$actual_amount += $payment["payment_amount"];
				}
			}
			
			
			if($target_amount == 0 && $actual_amount == 0){
				continue;
			}
			$all_details[] = $customer_name."*".$customer_id."*".$loan_product_name."*".$loan_id."*".$target_amount."*".$actual_amount."*".$date_expected."*".$initial_expected_date;
			
		}
		
		//target = 0
		$this->db->select("id,loan,date_expected,initial_expected_date");
		$this->db->where("date_expected NOT LIKE '".$date."%'");
		$query = $this->db->get("loan_expected_payments");
		$unexpected_payments = $query->result_array();
		$loan_ids = array();
		foreach($unexpected_payments as $unexpected_payment){
			
			if(in_array($unexpected_payment["id"],$expected_ids)){
				continue;
			}
			
			$date_expected = $unexpected_payment["date_expected"];
			$initial_expected_date = $unexpected_payment["initial_expected_date"];
			
			$check = FALSE;
			$loan_id = $unexpected_payment["loan"];
			
			//if($loan_id == 97) echo "hapa1 ".$loan_id." here ".$unexpected_payment["id"]." ";
			
			$actual_amount = 0;
			$target_amount = 0;
			
			$this->db->select("customer,loan_product");
			$this->db->where("id = ".$loan_id);
			$query = $this->db->get("loans");
			$loan_details = $query->row_array();
			$customer_id = $loan_details["customer"];
			$loan_product_id = $loan_details["loan_product"];
			
			$this->db->select("loan_product_name");
			$this->db->where("id = ".$loan_product_id);
			$query = $this->db->get("loan_products");
			$loan_product = $query->row_array();
			$loan_product_name = $loan_product["loan_product_name"];
			
			$this->db->select("name,other_names");
			$this->db->where("id = ".$customer_id);
			$query = $this->db->get("customers");
			$customer_details = $query->row_array();
			$customer_name = $customer_details["name"]." ".$customer_details["other_names"];
			
			if( ! in_array($loan_id,$loan_ids) ){
				$loan_ids[] = $loan_id;
				$this->db->select("id");
				$this->db->where("loan = ".$loan_id);
				$query = $this->db->get("loan_charges");
				$charge_ids = $query->result_array();
				foreach($charge_ids as $charge_id){ 
					if(in_array($charge_id["id"],$charge_ids_array)) continue;
					$this->db->select("amount");
					$this->db->where("charge = ".$charge_id["id"]." AND date LIKE '".$date."%' AND is_deleted = 0");
					$query = $this->db->get("loan_charges_payments");
					$charge_payments = $query->result_array(); 
					foreach($charge_payments as $charge_payment){ 
						$check = TRUE;
						$actual_amount += $charge_payment["amount"];
					}
				}
				
				$this->db->select("id");
				$this->db->where("loan = ".$loan_id);
				$query = $this->db->get("loan_expected_payments");
				$unexpected = $query->result_array();
				foreach($unexpected as $unexpected){
					if(in_array($unexpected["id"],$expected_ids)){
						continue;
					}
					$this->db->select("payment_amount");
					$this->db->where("payment = ".$unexpected["id"]." AND payment_date LIKE '".$date."%' AND is_deleted = 0");
					$query = $this->db->get("loan_payments");
					$payments_ = $query->result_array(); 
					foreach($payments_ as $payment_){ 
						$check = TRUE;
						$actual_amount += $payment_["payment_amount"];
					}
				}
			}
			
			if($check){
				 $all_details[] = $customer_name."*".$customer_id."*".$loan_product_name."*".$loan_id."*".$target_amount."*".$actual_amount."*".$date_expected."*".$initial_expected_date;
			}
		}
		
		return $all_details;
	}
	
}