<?php

class Penalties_model extends CI_Model {
	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_customers_a()
	{
		$this->db->select('id, loan, balance, interest_amount_balance, date_expected, transaction_code, DATEDIFF(date_expected,CURDATE())');
		$this->db->where('paid = 0 AND penalizable = 1 AND DATEDIFF(date_expected,CURDATE())  IN (-1,-8,-15,-22) AND (balance > 0 OR interest_amount_balance > 0)');
		$query = $this->db->get('loan_expected_payments');
		$customers = $query->result_array();
		
		$customers_dets = array();
		
		foreach($customers as $customer){
			$loan_id = $customer['loan'];
			$transaction_code = $customer['transaction_code'];
			
			//Retrieving arrears
			$arrears = 0;
			$this->db->select('balance, interest_amount_balance');
			$this->db->where('loan ='.$loan_id.' AND paid = 0 AND DATEDIFF(CURDATE(),date_expected) > 22 
			AND (balance > 0 OR interest_amount_balance > 0)');
			$query_arrears = $this->db->get('loan_expected_payments');
			$arrears_array = $query_arrears->result_array();
			foreach($arrears_array as $arrear){
				$arrears += $arrear['balance'] + $arrear['interest_amount_balance'];
			}
			
			//Retrieving customer id
			$this->db->select('customer');
			$this->db->where('id', $loan_id);
			$query_cust_id = $this->db->get('loans');
			$cust_id_array = $query_cust_id->row_array();
			$cust_id = $cust_id_array['customer'];
			
			//Retrieve loan charges
			$charges = 0;
			$this->db->select('balance');
			$this->db->where('loan ='.$loan_id.' AND balance > 0 AND paid = 0');
			$query_charges = $this->db->get('loan_charges');
			$charges_array = $query_charges->result_array();
			foreach($charges_array as $charge){
				$charges += $charge['balance'];
			}
			
			//Retrieving customer details
			$this->db->select('name, other_names, mobiletel');
			$this->db->where('id', $cust_id);
			$query_cust_dets = $this->db->get('customers');
			$cust_dets_array = $query_cust_dets->row_array();
			$cust_first_name = $cust_dets_array['name'];
			$cust_other_names = $cust_dets_array['other_names'];
			$cust_mobile = $cust_dets_array['mobiletel'];
			
			$customers_dets[] = $cust_first_name.'*'.$cust_other_names.'*'.$cust_mobile.'*'.$customer['balance'].'*'
			.$customer['interest_amount_balance'].'*'.$charges.'*'.$arrears.'*'.$customer['date_expected'].'*'.$loan_id.'*'.$transaction_code.'*'.$customer['id'];
		}
		return $customers_dets;
	}
	
	public function get_customers_b()
	{
		$this->db->select('id, loan, balance, interest_amount_balance, date_expected, transaction_code,penalty_date, DATEDIFF(date_expected,CURDATE())');
		$this->db->where('paid = 0 AND penalizable = 1 AND DATEDIFF(date_expected,CURDATE())  IN (-1) AND (balance > 0 OR interest_amount_balance > 0)');
		$query = $this->db->get('loan_expected_payments');
		$customers = $query->result_array();
		
		$customers_dets = array();
		
		foreach($customers as $customer){ //echo $customer['DATEDIFF(date_expected,penalty_date)']; exit;
			$loan_id = $customer['loan'];
			$transaction_code = $customer['transaction_code'];
			
					
			if(is_null($customer['penalty_date'])){
				$penalty_date = "0000-00-00";
			}
			else{
				$penalty_date = $customer['penalty_date'];
				$now = time(); // or your date as well
				$expected_time = strtotime($customer['date_expected']);
				$penalty_time = strtotime($penalty_date);
				$datediff = $expected_time - $penalty_time;
				if(floor($datediff/(60*60*24)) < 7){
					$penalty_date = "0000-00-00";
				}
				//echo $penalty_date.floor($datediff/(60*60*24)); exit;
			}
			
					
			
			//Retrieving customer id
			$this->db->select('customer');
			$this->db->where('id', $loan_id);
			$query_cust_id = $this->db->get('loans');
			$cust_id_array = $query_cust_id->row_array();
			$cust_id = $cust_id_array['customer'];
						
			//Retrieve loan charges
			$charges = 0;
			$this->db->select('balance');
			$this->db->where('loan ='.$loan_id.' AND balance > 0 AND paid = 0');
			$query_charges = $this->db->get('loan_charges');
			$charges_array = $query_charges->result_array();
			foreach($charges_array as $charge){
				$charges += $charge['balance'];
			}
			
			//Retrieving customer details
			$this->db->select('name, other_names, mobiletel');
			$this->db->where('id', $cust_id);
			$query_cust_dets = $this->db->get('customers');
			$cust_dets_array = $query_cust_dets->row_array();
			$cust_first_name = $cust_dets_array['name'];
			$cust_other_names = $cust_dets_array['other_names'];
			$cust_mobile = $cust_dets_array['mobiletel'];
			
			$customers_dets[] = $cust_first_name.'*'.$cust_other_names.'*'.$cust_mobile.'*'.$customer['balance'].'*'
			.$customer['interest_amount_balance'].'*'.$charges.'*'.$customer['date_expected'].'*'.$loan_id.'*'.$transaction_code.'*'.$customer['id'].'*'.$penalty_date;
		}
		return $customers_dets;
	}
	
	public function get_customers_c()
	{
		$date = date("Y-m-d"); //echo $date; exit;
		$this->db->select("id, loan, balance, interest_amount_balance, date_expected, transaction_code");
		$this->db->where("paid = 0 AND penalizable = 1 AND penalty_date = '".$date."' AND (balance > 0 OR interest_amount_balance > 0)");
		$query = $this->db->get("loan_expected_payments");
		$customers = $query->result_array();
		
		$customers_dets = array();
		
		foreach($customers as $customer){
			$expected_time = strtotime($customer['date_expected']);
			$penalty_time = strtotime($date);
			$datediff = $expected_time - $penalty_time;
			if(floor($datediff/(60*60*24)) < 7){
				continue;
			}
			$loan_id = $customer['loan'];
			$transaction_code = $customer['transaction_code'];
			
			//Retrieving customer id
			$this->db->select('customer');
			$this->db->where('id', $loan_id);
			$query_cust_id = $this->db->get('loans');
			$cust_id_array = $query_cust_id->row_array();
			$cust_id = $cust_id_array['customer'];
			
			
			//Retrieve loan charges
			$charges = 0;
			$this->db->select('balance');
			$this->db->where('loan ='.$loan_id.' AND balance > 0 AND paid = 0');
			$query_charges = $this->db->get('loan_charges');
			$charges_array = $query_charges->result_array();
			foreach($charges_array as $charge){
				$charges += $charge['balance'];
			}
			
			//Retrieving customer details
			$this->db->select('name, other_names, mobiletel');
			$this->db->where('id', $cust_id);
			$query_cust_dets = $this->db->get('customers');
			$cust_dets_array = $query_cust_dets->row_array();
			$cust_first_name = $cust_dets_array['name'];
			$cust_other_names = $cust_dets_array['other_names'];
			$cust_mobile = $cust_dets_array['mobiletel'];
			
			$customers_dets[] = $cust_first_name.'*'.$cust_other_names.'*'.$cust_mobile.'*'.$customer['balance'].'*'
			.$customer['interest_amount_balance'].'*'.$charges.'*'.$customer['date_expected'].'*'.$loan_id.'*'.$transaction_code.'*'.$customer['id'];
		}
		return $customers_dets;
	}
	
	public function set_new_due_date($id, $new_date_due)
	{
		$data = array(
			'date_expected' => $new_date_due
		);
		
		$this->db->where('id', $id);
		$this->db->update('loan_expected_payments', $data);
	}
	
	public function set_new_penalty_date($id, $new_penalty_date)
	{
		$data = array(
			'penalty_date' => $new_penalty_date
		);
		
		$this->db->where('id', $id);
		$this->db->update('loan_expected_payments', $data);
	}
	
	public function get_loan_product($transactioncode)
	{
		$this->db->select('loan_product');
		$this->db->where('transaction_code', $transactioncode);
		$query_id = $this->db->get('loans');
		$id_array = $query_id->row_array();
		$id = $id_array['loan_product'];
		return $id;
	}
	
	public function get_percent($transactioncode)
	{
		$this->db->select('loan_product');
		$this->db->where('transaction_code', $transactioncode);
		$query_id = $this->db->get('loans');
		$id_array = $query_id->row_array();
		$id = $id_array['loan_product'];
		
		$this->db->select('late_payment_fee_percent');
		$this->db->where('id', $id);
		$query_percent = $this->db->get('loan_products');
		$percent_array = $query_percent->row_array();
		$percent = $percent_array['late_payment_fee_percent'];
		return $percent;
	}
	
	public function get_interest_percent($transactioncode)
	{
		$this->db->select('loan_product');
		$this->db->where('transaction_code', $transactioncode);
		$query_id = $this->db->get('loans');
		$id_array = $query_id->row_array();
		$id = $id_array['loan_product'];
		
		$this->db->select('interest_fee_percent');
		$this->db->where('id', $id);
		$query_percent = $this->db->get('loan_products');
		$percent_array = $query_percent->row_array();
		$percent = $percent_array['interest_fee_percent'];
		return $percent;
	}
	
	public function set_penalty($transaction_code,$penalty_name, $loan_id, $date, $penalty)
	{
		$data = array(
			'transaction_code' => $transaction_code,
			'name' => $penalty_name,
			'loan' => $loan_id,
			'date' => $date,
			'amount' => $penalty,
			'balance' => $penalty
		);
		
		return $this->db->insert('loan_charges', $data);
	}
	
	public function set_sent_sms($dest,$msg_payload,$datesent){
			
		$data = array(
			'message' => $msg_payload,
			'date' => $datesent,
			'too' => $dest
		);
		
		return $this->db->insert('sms_outbox', $data);
	}
}
	