<?php
class Pay_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_loan($id)
	{
		$query = $this->db->get_where('loans', array('id' => $id));
		return $query->row_array();
	}
	
	public function get_affected_account($acctname)
	{
		$query = $this->db->get_where('accounts', array('account_name' => $acctname));
		$row = $query->row_array();
		return $row['id'];
	}
	
	public function get_customer_account($id)
	{
		$query = $this->db->get_where('customer_accounts', array('customer' => $id));
		$row = $query->row_array();
		return $row['id'];
	}
	
	public function get_customer_details($id)
	{
		$query = $this->db->get_where('customers', array('id' => $id));
		return $query->row_array();
	}
		
	public function get_charges($id){
		$this->db->select('*');
		$this->db->where('loan = '.$id.' AND paid = 0');
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get('loan_charges');
		if($query->num_rows() > 0){
			return  $query->result_array(); 
		}
		return 0;
	}
	
	public function get_expected_payments($id){
		$this->db->select('*');
		$this->db->where('loan = '.$id.' AND paid = 0');
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get('loan_expected_payments');
		if($query->num_rows() > 0){
			return  $query->result_array(); 
		}
		return 0;
	}
	
	public function update_charge_balance($id, $amt, $paid){
		$this->db->where('id', $id);
		$this->db->set('balance', 'balance - '.$amt, FALSE);
		$this->db->set('paid', $paid, FALSE);
		$this->db->update('loan_charges');
	}
	
	public function insert_charge_payment($id,$date,$amount,$channel,$t_code,$p_code){
		$data = array(
			'charge' => $id,
			'date' => $date,
			'amount' => $amount,
			'channel' => $channel,
			'transaction_code' => $t_code,
			'payment_code' => $p_code
		);
		return $this->db->insert('loan_charges_payments', $data);
	}
	
	public function insert_transaction($obj,$t_code,$acct,$t_type,$description,$date,$amount,$usr,$p_code){
		$data = array(
			'object' => $obj,
			'transaction_code' => $t_code,
			'account' => $acct,
			'transactiontype' => $t_type,
			'description' => $description,
			'date' => $date,
			'transactiontype' => $t_type,
			'amounttransacted' => $amount,
			'user' => $usr,
			'payment_code' => $p_code
		);
		return $this->db->insert('account_transactions', $data);
	}
	
	public function update_account_balance($account,$amount){
		$this->db->where('id', $account);
		$this->db->set('account_balance', 'account_balance + '.$amount, FALSE);
		$this->db->update('accounts');
	}
	
	public function update_interest_balance($id, $amt){
		$this->db->where('id', $id);
		$this->db->set('interest_amount_balance', 'interest_amount_balance - '.$amt, FALSE);
		//$this->db->set('paid', $paid, FALSE);
		$this->db->update('loan_expected_payments');
	}
	
	public function update_installment_balance($id, $amt, $paid){
		$this->db->where('id', $id);
		$this->db->set('balance', 'balance - '.$amt, FALSE);
		$this->db->set('paid', $paid, FALSE);
		$this->db->update('loan_expected_payments');
		
		if($paid == 1){
			$this->db->where('expected_id', $id);
			$this->db->set('is_paid', $paid, FALSE);
			$this->db->update('t_debt_collection');
		}
	}
	
	public function insert_payment($id,$t_code,$amount,$date,$channel,$description,$p_code,$is_principal){
		$data = array(
			'payment' => $id,
			'transaction_code' => $t_code,
			'payment_amount' => $amount,
			'payment_date' => $date,
			'payment_channel' => $channel,
			'desc' => $description,
			'payment_code' => $p_code,
			'for_principal' => $is_principal
		);
		return $this->db->insert('loan_payments', $data);
	}
	
	public function update_loan_balance($id,$amt){
		$this->db->where('id', $id);
		$this->db->set('loan_balance_amount', 'loan_balance_amount - '.$amt, FALSE);
		$this->db->update('loans');
	}
	
	public function update_points($customer_id,$loan_id,$interest_amt){
		/* $this->db->select('total_interest_amount');
		$this->db->where('id = '.$loan_id);
		$query = $this->db->get('loans');
		$result = $query->row_array(); 
		$interest = $result['total_interest_amount']; */
		
		$amount = $interest_amt/100;
		$points = floor($amount);
				
		$this->db->where('id', $customer_id);
		$this->db->set('loyaltypoints', 'loyaltypoints + '.$points, FALSE);
		$this->db->update('customers');
	}
	
	public function update_loan_status($id){
		$date = date("Y-m-d");
		$this->db->where("id", $id);
		$this->db->set("loan_status", 1, FALSE);
		$this->db->set("date_settled", "'".$date."'", FALSE);
		$this->db->update("loans");
	}
	
	public function update_customer_account($id,$amt){
		$this->db->where('customer', $id);
		$this->db->set('balance', 'balance - '.$amt, FALSE);
		$this->db->update('customer_accounts');
	}
	
	public function add_full_payment($l_id,$amount,$pay_channel_id,$description,$p_code){
		$data = array(
			'loan_id' => $l_id,
			'amount' => $amount,
			'payment_channel_id' => $pay_channel_id,
			'description' => $description,
			'payment_code' => $p_code
		);
		return $this->db->insert('t_loan_all_payments', $data);
	}
	
	public function update_disbursement_description($id,$description){
		$this->db->where("id", $id);
		$this->db->set("disbursement_description", "$description");
		$this->db->update("loans");
	}
	
	public function get_bouncing_cheques($loan_id){
		$this->db->select("*");
		$this->db->where("loan_id = ".$loan_id." AND is_settled = 0");
		$query = $this->db->get("t_cheques_bouncing");
		return $query->result_array();
	}
	
	public function update_bouncing_cheque($id,$amount_to_pay_penalty,$amount_to_pay_amount,$is_settled,$all_payment_id){
		$this->db->where('id', $id);
		$this->db->set('penalty_bal', 'penalty_bal - '.$amount_to_pay_penalty, FALSE);
		$this->db->set('amount_bal', 'amount_bal - '.$amount_to_pay_amount, FALSE);
		if($is_settled){
			$this->db->set('is_settled', 'is_settled + '.$is_settled, FALSE);
		}
		$this->db->update('t_cheques_bouncing');
		
		if($is_settled){
			//echo $all_payment_id; exit;
			$this->db->where('id', $all_payment_id);
			$this->db->set('is_deleted', 'is_deleted +'.$is_settled, FALSE);
			$this->db->update('t_loan_all_payments');
		}
	}
	
	public function get_loan_product($id)
	{
		$this->db->select('loan_product_name');
		$this->db->where('id',$id);
		$query = $this->db->get('loan_products');
		$result = $query->row_array();
		return $result['loan_product_name'];
	}
	
	public function get_rewards($cust_id){
		$this->db->select("id,reward_id");
		$this->db->where("cust_id = ".$cust_id." AND used = 0");
		$query = $this->db->get("t_cust_rewards");
		$redeemed_rewards = $query->result_array();
		$count = 0;
		foreach($redeemed_rewards as $redeemed_reward){
			$redeemed_id = $redeemed_reward['id'];
			$cust_id = $redeemed_reward['cust_id'];
			$reward_id = $redeemed_reward['reward_id'];
			$date_submitted = $redeemed_reward['date_created'];
			$date_settled = $redeemed_reward['date_processed'];
			
			$this->db->select("name, other_names");
			$this->db->where("id = ".$cust_id);
			$query = $this->db->get("customers");
			$customer = $query->row_array();
			$customer_name = $customer['name']." ".$customer['other_names'];
			
			$this->db->select("point_id, value, type");
			$this->db->where("id = ".$reward_id);
			$query = $this->db->get("t_rewards");
			$reward_params = $query->row_array();
			$point_id = $reward_params['point_id'];
			$value = $reward_params['value'];
			$type_id = $reward_params['type'];
			
			$this->db->select("points");
			$this->db->where("id = ".$point_id);
			$query = $this->db->get("t_points");
			$points_array = $query->row_array();
			$points = $points_array['points'];
			
			$this->db->select("name");
			$this->db->where("id = ".$type_id);
			$query = $this->db->get("t_reward_types");
			$points_array = $query->row_array();
			$reward_type = $points_array['name'];
			
			if(0 == $count){				
				$result = $cust_id."*".$customer_name."*".$points."*".$type_id."*".$reward_type."*".$value."*".$date_submitted."*".$date_settled."*".$redeemed_id;
			}
			else{
				$result .= "^".$cust_id."*".$customer_name."*".$points."*".$type_id."*".$reward_type."*".$value."*".$date_submitted."*".$date_settled."*".$redeemed_id;
			}
			$count++;
		}
		
		if(0 != $count){
			return $result;
		}
		else{
			return 0;
		}
	}
}