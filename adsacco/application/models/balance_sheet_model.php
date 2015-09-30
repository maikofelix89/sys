<?php
class Balance_sheet_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	
	public function get_savings($date){
		$savings = array();
		
		$this->db->select("id,account_name,account_balance");
		$this->db->where("is_exp = 0");
		$query = $this->db->get("accounts");
		$accounts = $query->result_array();
					
		foreach($accounts as $account){ 
			$account_name = $account["account_name"];
			$account_id = (int) $account["id"];
			$current_bal = $account["account_balance"];
			
			$this->db->select("transactiontype,amounttransacted");
			$this->db->where("account = $account_id AND is_deleted = 0 AND date > '".$date."'");
			$query_amounts = $this->db->get("account_transactions");
			$amounts = $query_amounts->result_array();
			foreach($amounts as $amount){
				if($amount["transactiontype"] == 1){
					$current_bal -= $amount["amounttransacted"];
				}
				else{
					$current_bal += $amount["amounttransacted"];
				}
			}
			$savings[] = $account_name."*".$current_bal;
		}
							
		return $savings;
	}
	
	public function get_total_amount_due($date)
	{
		$this->db->select("id");
		$this->db->where("request_status = 2 AND loan_issue_date <= '".$date."'");
		$query = $this->db->get("loans");
		$loan_ids = $query->result_array();
		$total_amount_due = 0;
		foreach($loan_ids as $loan_id){
			$this->db->select("balance");
			$this->db->where("loan = ".$loan_id["id"]." AND paid = 0");
			$query = $this->db->get("loan_expected_payments");
			$balances = $query->result_array();
			foreach($balances as $balance){
				$total_amount_due += $balance["balance"];
			}
			
			$this->db->select("interest_amount_balance");
			$this->db->where("loan = ".$loan_id["id"]." AND paid = 0");
			$query = $this->db->get("loan_expected_payments");
			$balances = $query->result_array();
			foreach($balances as $balance){
				$total_amount_due += $balance["interest_amount_balance"];
			}
			
			$this->db->select("amount");
			$this->db->where("loan_id = ".$loan_id["id"]." AND paid = 0 AND dateTime <= '".$date." 23:59:59'");
			$query = $this->db->get("t_transaction_fees");
			$balances = $query->result_array();
			foreach($balances as $balance){
				$total_amount_due += $balance["amount"];
			}
			
			$this->db->select("balance");
			$this->db->where("loan = ".$loan_id["id"]." AND paid = 0 AND date <= '".$date."'");
			$query = $this->db->get("loan_charges");
			$balances = $query->result_array();
			foreach($balances as $balance){
				$total_amount_due += $balance["balance"];
			}
			
			$this->db->select("id");
			//$this->db->where("loan = ".$loan_id["id"]." AND initial_expected_date <= '".$date_plus."'");
			$this->db->where("loan = ".$loan_id["id"]);
			$query = $this->db->get("loan_expected_payments");
			$expected_ids = $query->result_array();
			foreach($expected_ids as $expected_id){
				$this->db->select("payment_amount");
				$this->db->where("payment = ".$expected_id["id"]." AND payment_date > '".$date."' AND is_deleted = 0");
				$query = $this->db->get("loan_payments");
				$payments = $query->result_array();
				foreach($payments as $payment){ //if($loan_product_id == 5) echo $expected_id["id"]." ".$payment["payment_amount"]." ".$query;
					$total_amount_due += $payment["payment_amount"];
					/*if($loan_product_id == 3){
						echo "sss ".$loan_id["id"]." ".$payment["payment_amount"]."<br />";
					}*/
				}
			}
			
			$this->db->select("id");
			$this->db->where("loan = ".$loan_id["id"]." AND date <= '".$date."'");
			$query = $this->db->get("loan_charges");
			$charge_ids = $query->result_array();
			foreach($charge_ids as $charge_id){
				$this->db->select("amount");
				$this->db->where("charge = ".$charge_id["id"]." AND date > '".$date."' AND is_deleted = 0");
				$query = $this->db->get("loan_charges_payments");
				$amounts = $query->result_array();
				foreach($amounts as $amount){
					$total_amount_due += $amount["amount"];
					/*if($loan_product_id == 3){
						echo "ggg ".$loan_id["id"]." ".$amount["amount"]."<br />";
					}*/
				}
			}
		}
		return $total_amount_due;
	}
	
	public function get_creditors_amount($date,$id){
		$account_id = (int) $id;
		$creditors = array();
		
		$this->db->select("account_name,account_balance");
		$this->db->where("id = $account_id AND is_exp = 2");
		$query = $this->db->get("accounts");
		$account = $query->row_array();
				
		$account_name = $account["account_name"]; 
		$current_bal = $account["account_balance"]; //echo $current_bal."ff"; exit;
		$current_bal = abs($current_bal);
		
		$this->db->select("transactiontype,amounttransacted");
		$this->db->where("account = $account_id AND is_deleted = 0 AND date > '".$date."'");
		$query_amounts = $this->db->get("account_transactions");
		$amounts = $query_amounts->result_array();
		foreach($amounts as $amount){
			if($amount["transactiontype"] == 1){
				$current_bal += $amount["amounttransacted"];
			}
			else{
				$current_bal -= $amount["amounttransacted"];
			}
		}
		$current_bal = $current_bal;
		$creditors[] = $account_name."*".$current_bal;
									
		return $creditors;
	}
	
	public function get_opening_bal_equity(){
		$opening_bal_equity = 0;
		$this->db->select("account_opening_balance");
		$this->db->where("is_exp = 0");
		$query = $this->db->get("accounts");
		$accounts = $query->result_array();
					
		foreach($accounts as $account){ 
			$opening_bal_equity += $account["account_opening_balance"];		
		}
		return $opening_bal_equity;
	}
	
	public function get_transaction_fees($date){
		$this->db->select("amount");
		$this->db->where("dateTime <= '".$date." 23:59:59'");
		$query = $this->db->get("t_transaction_fees");
		return $query->result_array();
	}
	
	public function get_interest($date){
		$this->db->select("total_interest_amount");
		$this->db->where("loan_product <> 2 AND request_status=2 AND loan_issue_date <= '".$date."'");
		$query = $this->db->get("loans");
		return $query->result_array();
	}
	
	public function get_interest_b($date){
		$this->db->select("id");
		$this->db->where("loan_product = 2 AND request_status=2 AND loan_issue_date <= '".$date."'");
		$query = $this->db->get("loans");
		$loan_ids = $query->result_array();
		$interest = 0;
		foreach($loan_ids as $loan_id){
			$this->db->select("interest_amount");
			$this->db->where("loan = ".$loan_id["id"]);
			$query = $this->db->get("loan_expected_payments");
			$amounts = $query->result_array();
			foreach($amounts as $amount){
				$interest += $amount["interest_amount"];
			}
		}
		
		return $interest;
	}
	
	public function get_charges($date){
		$this->db->select("name,amount,waiver");
		$this->db->where("date_time <= '".$date." 23:59:59'");
		$query = $this->db->get("loan_charges");
		return $query->result_array();
	}
	
	public function get_charges_c($date,$name){
		$this->db->select("id");
		$this->db->where("request_status = 2 AND loan_issue_date <= '".$date."'");
		$query = $this->db->get("loans");
		$loan_ids = $query->result_array();
		$charges = 0;
		
		foreach($loan_ids as $loan_id){
			$this->db->select("id");
			$this->db->where("name = '".$name."' AND loan = ".$loan_id["id"]);
			$query = $this->db->get("loan_charges");
			$charge_ids = $query->result_array();
			foreach($charge_ids as $charge_id){
				$this->db->select("amount");
				$this->db->where("charge = ".$charge_id["id"]." AND date <= '".$date."' AND is_deleted = 0");
				$query = $this->db->get("loan_charges_payments");
				$amounts = $query->result_array();
				foreach($amounts as $amount){
					$charges += $amount["amount"];
				}
			}
		}
		
		return $charges;
	}
	
	public function get_exp_accts(){
		$this->db->select("id");
		$this->db->where("is_exp = 1");
		$query = $this->db->get("accounts");
		return $query->result_array();
	}
	
	public function get_expenditures($account_id,$date){ 
		$this->db->select("account,sub_account,amounttransacted");
		$this->db->where("account = ".$account_id." AND date <= '".$date."' AND transactiontype = 1 AND is_deleted = 0");
		$query = $this->db->get("account_transactions");
		return $query->result_array();
	}
	
}