<?php
class Statements_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_transaction_fees($current_date){
		$this->db->select("amount");
		$this->db->where("dateTime LIKE '".$current_date."%'");
		$query = $this->db->get("t_transaction_fees");
		return $query->result_array();
	}
	
	public function get_interest($date){
		$this->db->select("total_interest_amount");
		$this->db->where("loan_product <> 2 AND request_status=2 AND loan_issue_date LIKE '".$date."%'");
		$query = $this->db->get("loans");
		return $query->result_array();
	}
	
	public function get_interest_b($date){
		$this->db->select("id");
		$this->db->where("loan_product = 2 AND request_status=2");
		$query = $this->db->get("loans");
		$loan_ids = $query->result_array();
		$interest = 0;
		foreach($loan_ids as $loan_id){
			$this->db->select("interest_amount");
			$this->db->where("loan = ".$loan_id["id"]." AND initial_expected_date LIKE '".$date."%'");
			$query = $this->db->get("loan_expected_payments");
			$amounts = $query->result_array();
			foreach($amounts as $amount){
				$interest += $amount["interest_amount"];
			}
		}
		
		return $interest;
	}
	
	public function get_charges($current_date){
		$this->db->select("name,amount,waiver");
		$this->db->where("date_time LIKE '".$current_date."%'");
		$query = $this->db->get("loan_charges");
		return $query->result_array();
	}
	
	public function get_exp_accts(){
		$this->db->select("id");
		$this->db->where("is_exp = 1");
		$query = $this->db->get("accounts");
		return $query->result_array();
	}
	
	public function get_expenditures($account_id,$date){ 
		$this->db->select("account,sub_account,amounttransacted");
		$this->db->where("account = ".$account_id." AND date LIKE '".$date."%' AND transactiontype = 1 AND is_deleted = 0");
		$query = $this->db->get("account_transactions");
		return $query->result_array();
	}
	
	public function get_account($account_id){
		$this->db->select("account_name,has_child");
		$this->db->where("id = ".$account_id);
		$query = $this->db->get("accounts");
		if($query->num_rows() == 0){
			return 0;
		}
		return $query->row_array();
	}
	
	public function get_sub_accounts($account_id){
		$this->db->select("id,account_name");
		$this->db->where("parent_id = ".$account_id);
		$query = $this->db->get("t_sub_accounts");
		
		return $query->result_array();
	}
	
	public function get_sub_account($sub_account_id){
		$this->db->select("account_name");
		$this->db->where("id = ".$sub_account_id." AND is_exp = 1");
		$query = $this->db->get("t_sub_accounts");
		
		return $query->row_array();
	}
	
		public function get_interests_c($date){
		$this->db->select("id");
		$this->db->where("request_status = 2");
		$query = $this->db->get("loans");
		$loan_ids = $query->result_array();
		$interest = 0;
		foreach($loan_ids as $loan_id){
			//if($loan_product_id == 1) echo $loan_id["id"]." ";
			$this->db->select("id");
			$this->db->where("loan = ".$loan_id["id"]);
			$query = $this->db->get("loan_expected_payments");
			$expected_ids = $query->result_array();
			foreach($expected_ids as $expected_id){
				$this->db->select("payment_amount");
				$this->db->where("payment = ".$expected_id["id"]." AND for_principal = 0 AND payment_date LIKE '".$date."%' AND is_deleted = 0");
				$query = $this->db->get("loan_payments");
				$payments = $query->result_array();
				foreach($payments as $payment){
					$interest += $payment["payment_amount"];
				}
			}
		}
		return $interest;
	}
	
	public function get_charges_c($date,$name){
		$this->db->select("id");
		$this->db->where("request_status = 2");
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
				$this->db->where("charge = ".$charge_id["id"]." AND date LIKE '".$date."%' AND is_deleted = 0");
				$query = $this->db->get("loan_charges_payments");
				$amounts = $query->result_array();
				foreach($amounts as $amount){
					$charges += $amount["amount"];
				}
			}
		}
		
		return $charges;
	}
	
	public function get_other_income_accts(){ //echo "here"; exit;
		$this->db->select("id");
		$this->db->where("is_income = 1");
		$query = $this->db->get("accounts");
		return $query->result_array();
	}
	
	public function get_other_incomes($id,$date){
		$this->db->select("account_id,amount");
		$this->db->where("account_id = $id AND date_submitted LIKE '".$date."%'"); //echo "account_id = $id AND date_submitted LIKE '".$date."%'"; exit;
		$query = $this->db->get("t_finance_income");
		return $query->result_array();
	}
	
}