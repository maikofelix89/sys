<?php
class Chargestotalpayment_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_total_charges($id)
	{
		$total_charge = 0;
		$this->db->select("amount,waiver");
		$this->db->where("loan = ".$id." AND name <> 'transction_fee' ");
		$query = $this->db->get("loan_charges");
		$charges_array = $query->result_array();
		foreach($charges_array as $charge){
			$total_charge += $charge['amount'] - $charge['waiver'];
		}
		return $total_charge;
	}
	
	public function get_amount_paid($t_code)
	{
		$total_amount_paid = 0;
		$charges_paid = 0;
		$main_payments = 0;
		
		$this->db->select("amount");
		$this->db->where("is_deleted = 0 AND transaction_code = '".$t_code."'");
		$query = $this->db->get("loan_charges_payments");
		$charges_paid_array = $query->result_array();
		foreach($charges_paid_array as $charge_paid){
			$charges_paid += $charge_paid["amount"];
		}
		
		$this->db->select("payment_amount");
		$this->db->where("is_deleted = 0 AND transaction_code = '".$t_code."'");
		$query_main = $this->db->get("loan_payments");
		$main_payments_array = $query_main->result_array();
		foreach($main_payments_array as $main_payment){
			$main_payments += $main_payment["payment_amount"];
		}
		
		$total_amount_paid = $charges_paid + $main_payments;
		
		return $total_amount_paid;		
	}
	
	
	//
	public function get_outstanding_principal()
	{
		$outstanding_bal = 0;
		$this->db->select("balance");
		$this->db->where("paid = 0");
		$query = $this->db->get("loan_expected_payments");
		$result_array = $query->result_array();
		foreach($result_array as $result){
			$outstanding_bal += $result["balance"];
		}
		
		return $outstanding_bal;		
	}
	
	public function get_outstanding_interest()
	{
		$outstanding_bal = 0;
		$this->db->select("interest_amount_balance");
		$this->db->where("paid = 0");
		$query = $this->db->get("loan_expected_payments");
		$result_array = $query->result_array();
		foreach($result_array as $result){
			$outstanding_bal += $result["interest_amount_balance"];
		}
		
		return $outstanding_bal;		
	}
	
	public function get_outstanding_charges()
	{
		$outstanding_bal = 0;
		$this->db->select("balance");
		$this->db->where("paid = 0");
		$query = $this->db->get("loan_charges");
		$result_array = $query->result_array();
		foreach($result_array as $result){
			$outstanding_bal += $result["balance"];
		}
		
		return $outstanding_bal;		
	}
	
	///
	public function get_payments_made()
	{
		$total_amount_paid = 0;
		$charges_paid = 0;
		$main_payments = 0;
		
		$this->db->select("amount");
		$this->db->where("is_deleted = 0");
		$query = $this->db->get("loan_charges_payments");
		$charges_paid_array = $query->result_array();
		foreach($charges_paid_array as $charge_paid){
			$charges_paid += $charge_paid["amount"];
		}
		
		$this->db->select("payment_amount");
		$this->db->where("is_deleted = 0 ");
		$query_main = $this->db->get("loan_payments");
		$main_payments_array = $query_main->result_array();
		foreach($main_payments_array as $main_payment){
			$main_payments += $main_payment["payment_amount"];
		}
		
		$total_amount_paid = $charges_paid + $main_payments;
		
		return $total_amount_paid;		
	}
	
	///
	//
	public function get_total_amount_due()
	{
		$total_amount_due = 0;
		
		$this->db->select("balance,interest_amount_balance");
		$this->db->where("paid = 0");
		$query = $this->db->get("loan_expected_payments");
		$result_array = $query->result_array();
		foreach($result_array as $result){
			$total_amount_due  += $result["balance"] + $result["interest_amount_balance"];
		}
		
		
		$this->db->select("balance");
		$this->db->where("paid = 0");
		$query = $this->db->get("loan_charges");
		$result = $query->result_array();
		foreach($result as $charge_bal){
			$total_amount_due  += $charge_bal["balance"];
		}
		
		return $total_amount_due;		
	}
	
	
	public function get_all_payments()
	{
		$i = 0;
		$details = array();
		$this->db->select("*");
		$this->db->where("is_deleted = 0");
		$this->db->order_by("id","desc");
		$this->db->limit(200);
		$query = $this->db->get("t_loan_all_payments");
		$all_payments_array = $query->result_array();
		foreach($all_payments_array as $payment){
			$customer = '';
			$this->db->select("id,customer,loan_product");
			$this->db->where("id = '".$payment['loan_id']."'");
			$query_loan = $this->db->get("loans");
			$customer_array = $query_loan->row_array();
			$customer_id = $customer_array['customer'];
			$loan_product_id = $customer_array['loan_product'];
			$loan_id = $customer_array['id'];
						
			$this->db->select("loan_product_name");
			$this->db->where("id = ".$loan_product_id);
			$query_loan_product = $this->db->get("loan_products");
			$loan_product_array = $query_loan_product->row_array();
			$loan_product_name = $loan_product_array['loan_product_name'];
			
			$this->db->select("id,name,other_names");
			$this->db->where("id = ".$customer_id);
			$query_customer = $this->db->get("customers");
			$customer_array = $query_customer->row_array();
			$customer_name = $customer_array['name'].' '.$customer_array['other_names'];
			$customer_id = $customer_array['id'];
			$details[$i] = $payment['date_time'].'*'.$customer_name.'*'.$payment['amount'].'*'.$payment['description'].'*'.$customer_id.'*'.$loan_product_name.'*'.$payment['payment_code'].'*'.$payment['payment_channel_id'].'*'.$loan_id ;
			$i++;
		}
		return $details;
	}
	
	public function get_filtered_payments($start, $end)
	{
		$i = 0;
		$details = array();
		$this->db->select("*");
		$this->db->where("is_deleted = 0 AND date_time >= '".$start."' AND date_time <= '".$end."'");
		$this->db->order_by("id","desc");
		$query = $this->db->get("t_loan_all_payments");
		$all_payments_array = $query->result_array();
		foreach($all_payments_array as $payment){
			$customer = '';
			$this->db->select("customer,loan_product");
			$this->db->where("id = '".$payment['loan_id']."'");
			$query_loan = $this->db->get("loans");
			$customer_array = $query_loan->row_array();
			$customer_id = $customer_array['customer'];
			$loan_product_id = $customer_array['loan_product'];
						
			$this->db->select("loan_product_name");
			$this->db->where("id = ".$loan_product_id);
			$query_loan_product = $this->db->get("loan_products");
			$loan_product_array = $query_loan_product->row_array();
			$loan_product_name = $loan_product_array['loan_product_name'];
			
			$this->db->select("id,name,other_names");
			$this->db->where("id = ".$customer_id);
			$query_customer = $this->db->get("customers");
			$customer_array = $query_customer->row_array();
			$customer_name = $customer_array['name'].' '.$customer_array['other_names'];
			$customer_id = $customer_array['id'];
			$details[$i] = $payment['date_time'].'*'.$customer_name.'*'.$payment['amount'].'*'.$payment['description'].'*'.$customer_id.'*'.$loan_product_name.'*'.$payment['payment_code'].'*'.$payment['payment_channel_id'];
			$i++;
		}
		return $details;
	}
	
	public function get_expected_payments()
	{
		$i = 0;
		$details = array();
		$this->db->select("loan,balance,interest_amount_balance,date_expected");
		$this->db->where("paid = 0");
		$query = $this->db->get("loan_expected_payments");
		$expected_payments_array = $query->result_array();
		
		$loan_ids = array();
		$j = 0;
		
		foreach($expected_payments_array as $expected_payment){
			$charges_expected = 0;
						
			$this->db->select("customer,loan_product");
			$this->db->where("id = '".$expected_payment['loan']."'");
			$query_loan = $this->db->get("loans");
			$customer_array = $query_loan->row_array();
			$customer_id = $customer_array['customer'];
			$loan_product_id = $customer_array['loan_product'];
						
			$this->db->select("loan_product_name");
			$this->db->where("id = ".$loan_product_id);
			$query_loan_product = $this->db->get("loan_products");
			$loan_product_array = $query_loan_product->row_array();
			$loan_product_name = $loan_product_array['loan_product_name'];
						
			$this->db->select("id,name,other_names");
			$this->db->where("id = ".$customer_id);
			$query_customer = $this->db->get("customers");
			$customer_array = $query_customer->row_array();
			$customer_name = $customer_array['name'].' '.$customer_array['other_names'];
			$customer_id = $customer_array['id'];
			
			if( ! (in_array($expected_payment['loan'], $loan_ids)) ){
				$this->db->select("balance,waiver");
				$this->db->where("paid = 0 AND loan = ".$expected_payment['loan']);
				$query_charges = $this->db->get("loan_charges");
				$charges_array = $query_charges->result_array();
				foreach($charges_array as $charge){
					$charges_expected += $charge['balance'];
				}
				$loan_ids[$j] = $expected_payment['loan'];
				$j++;
			}
						
			$details[$i] = $expected_payment['balance'].'*'.$expected_payment['interest_amount_balance'].'*'.$charges_expected.'*'.$expected_payment['date_expected'].'*'.$customer_name.'*'.$customer_id.'*'.$loan_product_name;
			$i++;
		}
		
		return $details;
	}
	
	public function get_filtered_expected_payments($start,$end)
	{
		$i = 0;
		$details = array();
		$this->db->select("loan,balance,interest_amount_balance,date_expected");
		$this->db->where("paid = 0 AND date_expected >= '".$start."' AND date_expected <= '".$end."'");
		$query = $this->db->get("loan_expected_payments");
		$expected_payments_array = $query->result_array();
		
		$loan_ids = array();
		$j = 0;
		
		foreach($expected_payments_array as $expected_payment){
			$charges_expected = 0;
			
			$this->db->select("customer,loan_product");
			$this->db->where("id = '".$expected_payment['loan']."'");
			$query_loan = $this->db->get("loans");
			$customer_array = $query_loan->row_array();
			$customer_id = $customer_array['customer'];
			$loan_product_id = $customer_array['loan_product'];
						
			$this->db->select("loan_product_name");
			$this->db->where("id = ".$loan_product_id);
			$query_loan_product = $this->db->get("loan_products");
			$loan_product_array = $query_loan_product->row_array();
			$loan_product_name = $loan_product_array['loan_product_name'];
						
			$this->db->select("id,name,other_names");
			$this->db->where("id = ".$customer_id);
			$query_customer = $this->db->get("customers");
			$customer_array = $query_customer->row_array();
			$customer_name = $customer_array['name'].' '.$customer_array['other_names'];
			$customer_id = $customer_array['id'];
			
			if( ! (in_array($expected_payment['loan'], $loan_ids)) ){
				$this->db->select("balance,waiver");
				$this->db->where("paid = 0 AND loan = ".$expected_payment['loan']);
				$query_charges = $this->db->get("loan_charges");
				$charges_array = $query_charges->result_array();
				foreach($charges_array as $charge){
					$charges_expected += $charge['balance'];
				}
				$loan_ids[$j] = $expected_payment['loan'];
				$j++;
			}
			
			$details[$i] = $expected_payment['balance'].'*'.$expected_payment['interest_amount_balance'].'*'.$charges_expected.'*'.$expected_payment['date_expected'].'*'.$customer_name.'*'.$customer_id.'*'.$loan_product_name;
			$i++;
		}
		
		return $details;
	}
	
	public function get_payments_to_cancel($payment_code){
		$this->db->select("payment,payment_amount,for_principal");
		$this->db->where("is_deleted = 0 AND payment_code = '".$payment_code."'");
		$query = $this->db->get("loan_payments");
		return $query->result_array();
	}
	
	public function update_expected_payment($expected_id,$amount,$for_principal){
		$this->db->where('id', $expected_id);
		if($for_principal == 1){
			$this->db->set('balance', 'balance + '.$amount, FALSE);
		}
		else{
			$this->db->set('interest_amount_balance', 'interest_amount_balance + '.$amount, FALSE);
		}
		$this->db->set('paid', 0, FALSE);
		$this->db->update('loan_expected_payments');
		return $this->db->affected_rows();
	}
	
	public function get_charges_payments_to_cancel($payment_code){
		$this->db->select("charge,amount");
		$this->db->where("is_deleted = 0 AND payment_code = '".$payment_code."'");
		$query = $this->db->get("loan_charges_payments");
		return $query->result_array();
	}
	
	public function update_charge_payment($id,$amount){
		$this->db->where('id', $id);
		$this->db->set('balance', 'balance + '.$amount, FALSE);
		$this->db->set('paid', 0, FALSE);
		$this->db->update('loan_charges');
		return $this->db->affected_rows();
	}
	
	public function update_loan_status($payment_code,$amt_to_cancel){
		$this->db->select("loan_id");
		$this->db->where("payment_code = '".$payment_code."'");
		$query = $this->db->get("t_loan_all_payments");
		$id_array = $query->row_array();
		$id = $id_array['loan_id'];
		
		$this->db->where('id', $id);
		$this->db->set('loan_status',0, FALSE);
		$this->db->set('loan_balance_amount','loan_balance_amount + '.$amt_to_cancel, FALSE);
		$this->db->update('loans');
		return $this->db->affected_rows();
	}
	
	public function update_customer_balance($payment_code,$amt_to_cancel){
		$customer_id = 0;
		$this->db->select("loan_id");
		$this->db->where("payment_code = '".$payment_code."'");
		$query = $this->db->get("t_loan_all_payments");
		$id_array = $query->row_array();
		$id = $id_array['loan_id'];
		
		$this->db->select("customer");
		$this->db->where("id = ".$id);
		$query = $this->db->get("loans");
		$id_array = $query->row_array();
		$customer_id = $id_array['customer'];
		
		$this->db->where('customer', $customer_id);
		$this->db->set('balance','balance + '.$amt_to_cancel, FALSE);
		$this->db->update('customer_accounts');
		
		return $customer_id;
	}
	
	public function update_bank_balance($amount){
		$this->db->where('account_name', 'Chase Account');
		$this->db->set('account_balance', 'account_balance - '.$amount, FALSE);
		$this->db->update('accounts');
		return $this->db->affected_rows();
	}
	
	public function update_payment_history($payment_code){
				
		$this->db->where('payment_code', $payment_code);
		$this->db->set('is_deleted', 1, FALSE);
		$this->db->update('account_transactions');
				
		$this->db->where('payment_code', $payment_code);
		$this->db->set('is_deleted', 1, FALSE);
		$this->db->update('loan_charges_payments');
		
		
		$this->db->where('payment_code', $payment_code);
		$this->db->set('is_deleted', 1, FALSE);
		$this->db->update('loan_payments');
		
		
		$this->db->where('payment_code', $payment_code);
		$this->db->set('is_deleted', 1, FALSE);
		$this->db->update('t_loan_all_payments');
	}
	
	public function get_cheque_constants(){
		$this->db->select("fixed_amount,percent");
		$query = $this->db->get("t_cheques_bouncing_penalties");
		return $query->row_array();
	}
	
	public function add_bouncing_penalty($payment_code,$penalty_amount){
		$this->db->select("loan_id");
		$this->db->where("payment_code = '".$payment_code."'");
		$query = $this->db->get("t_loan_all_payments");
		$id_array = $query->row_array();
		$loan_id = $id_array['loan_id'];
		
		$this->db->select("transaction_code");
		$this->db->where("id = ".$loan_id);
		$query = $this->db->get("loans");
		$id_array = $query->row_array();
		$trans_code = $id_array['transaction_code'];
		
		$charge_name = 'bouncing cheque penalty';
		$date = date('Y-m-d');
		
		$data = array(
			'transaction_code' => $trans_code,
			'name' => $charge_name,
			'loan' => $loan_id,
			'date' => $date,
			'amount' => $penalty_amount,
			'balance' => $penalty_amount
		);
		$this->db->insert('loan_charges', $data);
		return $this->db->affected_rows();
	}
	
	public function get_customer_name($id){
		$this->db->select("name,mobiletel");
		$this->db->where("id = ".$id);
		$query = $this->db->get("customers");
		return $query->row_array();
	}
	
	public function get_cheque_amount($payment_code)
	{
		$this->db->select("amount");
		$this->db->where("is_deleted = 0");
		$this->db->where("payment_code = '".$payment_code."'");
		$query = $this->db->get("t_loan_all_payments");
		$amount_array = $query->row_array();
		return $amount_array["amount"];
	}
	
	public function get_all_payment_id($payment_code)
	{
		$this->db->select("id");
		$this->db->where("payment_code = '".$payment_code."'");
		$query = $this->db->get("t_loan_all_payments");
		$id_array = $query->row_array();
		return $id_array["id"];
	}
	
	public function add_bouncing_cheque($all_payment_id,$loan_id,$total_cheque_amount,$bouncing_cheque_penalty){
		$time_submitted = date("Y-m-d H:i:s");
		
		$data = array(
			'all_payment_id' => $all_payment_id,
			'loan_id' => $loan_id,
			'amount' => $total_cheque_amount,
			'amount_bal' => $total_cheque_amount,
			'penalty' => $bouncing_cheque_penalty,
			'penalty_bal' => $bouncing_cheque_penalty,
			'time_submitted' => $time_submitted
		);
		$this->db->insert('t_cheques_bouncing', $data);
		return $this->db->affected_rows();
	}
	
	public function modify_loan_status($loan_id,$status){
		$this->db->where('id', $loan_id);
		$this->db->set('loan_status', 'loan_status + '.$status, FALSE);
		$this->db->update('loans');
	}
}