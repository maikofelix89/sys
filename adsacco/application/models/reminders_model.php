<?php
class Reminders_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_customers()
	{
		$this->db->select('loan, balance, interest_amount_balance, date_expected, DATEDIFF(date_expected,CURDATE())');
		$this->db->where('paid = 0 AND (penalty_date IS NULL OR DATEDIFF(date_expected,penalty_date) < 7) AND DATEDIFF(date_expected,CURDATE())  IN (1,4) AND (balance > 0 OR interest_amount_balance > 0)');
		$query = $this->db->get('loan_expected_payments');
		$customers = $query->result_array();
		
		$customers_dets = array();
		
		foreach($customers as $customer){
			$loan_id = $customer['loan'];
			
			//Retrieving arrears
			$arrears = 0;
			$this->db->select('balance, interest_amount_balance');
			$this->db->where('loan ='.$loan_id.' AND paid = 0 AND date_expected < CURDATE() AND (balance > 0 OR interest_amount_balance > 0)');
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
			
			$customers_dets[] = $cust_first_name.'*'.$cust_other_names.'*'.$cust_mobile.'*'
						.$customer['balance'].'*'.$customer['interest_amount_balance'].'*'.$charges.'*'.$arrears.'*'.$customer['date_expected'];
		}
		return $customers_dets;
	}
	
	public function get_customers_b()
	{
		$this->db->select('loan, balance, interest_amount_balance, date_expected,penalty_date, DATEDIFF(date_expected,CURDATE())');
		$this->db->where('paid = 0 AND penalty_date IS NOT NULL AND DATEDIFF(date_expected,penalty_date) >= 7 AND DATEDIFF(penalty_date,CURDATE())  IN (3) AND (balance > 0 OR interest_amount_balance > 0)');
		$query = $this->db->get('loan_expected_payments');
		$customers = $query->result_array();
		
		$customers_dets = array();
		
		foreach($customers as $customer){
			$loan_id = $customer['loan'];
			$penalty_date = $customer['penalty_date'];
			
			//Retrieving arrears
			$arrears = 0;
			$this->db->select('balance, interest_amount_balance');
			$this->db->where('loan ='.$loan_id.' AND paid = 0 AND date_expected < CURDATE() AND (balance > 0 OR interest_amount_balance > 0)');
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
			
			$customers_dets[] = $cust_first_name.'*'.$cust_other_names.'*'.$cust_mobile.'*'
						.$customer['balance'].'*'.$customer['interest_amount_balance'].'*'.$charges.'*'.$arrears.'*'.$customer['date_expected'].'*'.$penalty_date;
		}
		return $customers_dets;
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