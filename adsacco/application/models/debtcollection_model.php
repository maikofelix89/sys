<?php
class Debtcollection_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_grace_period(){
		$this->db->select("id,grace_days,past_grace_percent");
		$query = $this->db->get("loan_products");
		return $query->result_array();
	}
	
	public function get_expected_payments(){
		$this->db->select("id,loan,transaction_code,initial_expected_date,balance,interest_amount_balance");
		$this->db->where("paid = 0");
		$query = $this->db->get("loan_expected_payments");
		return $query->result_array();
	}
	
	public function get_charges($loan_id){
		$this->db->select("id,balance,waiver");
		$this->db->where("paid = 0");
		$this->db->where("loan = ".$loan_id);
		$query = $this->db->get("loan_charges");
		return $query->result_array();
	}
	
	public function get_loan_product($loan_id){
		$this->db->select("customer,loan_product");
		$this->db->where("id = ".$loan_id);
		$query = $this->db->get("loans");
		return $query->row_array();
	}
	
	public function get_customer($customer_id){
		$this->db->select("name,other_names,mobiletel");
		$this->db->where("id = ".$customer_id);
		$query = $this->db->get("customers");
		return $query->row_array();
	}
	
	public function add_to_debt($expected_id){
		$data = array(
			'expected_id' => $expected_id
		);
		return $this->db->insert('t_debt_collection', $data);
	}
	
	public function get_debt_expected_ids(){
		$this->db->select("expected_id");
		$this->db->where("is_paid = 0");
		$query = $this->db->get("t_debt_collection");
		return $query->result_array();
	}
	
	public function get_initial_expected($expected_id){
		$this->db->select("loan,transaction_code,date_expected,balance,interest_amount_balance");
		$this->db->where("paid = 0 AND id = ".$expected_id);
		$query = $this->db->get("loan_expected_payments");
		return $query->row_array();
	}
	
	public function get_unpaid_cheques(){
		$this->db->select("loan_id,amount,payment_code,is_deleted");
		$this->db->where("payment_channel_id = 1 AND is_deleted IN(1,2)"); //is_deleted==1:is deleted and thus unsettled. is_deleted==2:settled
		$this->db->order_by("is_deleted", "ASC");
		$this->db->order_by("id", "ASC");
		$query = $this->db->get("t_loan_all_payments");
		return $query->result_array();
	}
	
	public function get_customer_details($loan_id){
		$this->db->select("customer");
		$this->db->where("id = ".$loan_id);
		$query = $this->db->get("loans");
		$customer_id_array =  $query->row_array();
		$customer_id = $customer_id_array["customer"];
		
		$this->db->select("id,name,other_names,mobiletel");
		$this->db->where("id = ".$customer_id);
		$query = $this->db->get("customers");
		return $query->row_array();
	}
	
	public function get_amount_due($expected_id,$loan_id){
		$total_amount = 0;
		$this->db->select("balance,interest_amount_balance");
		$this->db->where("paid = 0 AND id = ".$expected_id);
		$query = $this->db->get("loan_expected_payments");
		$amounts = $query->result_array();
		foreach($amounts as $amount){
			$total_amount += $amount["balance"] + $amount["interest_amount_balance"];
		}
		
		$this->db->select('balance');
		$this->db->where('loan ='.$loan_id.' AND balance > 0 AND paid = 0');
		$query_charges = $this->db->get('loan_charges');
		$charges_array = $query_charges->result_array();
		foreach($charges_array as $charge){
			$total_amount += $charge['balance'];
		}
		
		return $total_amount;
	}
}