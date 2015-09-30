<?php
	class Loan_transactions_model extends CI_Model{
	 	public function __construct()
		{
			$this->load->database();
		}
		
		public function insert_principal($loan_id,$principal,$description){
			$data = array(
				'loan_id' => $loan_id,
				'transaction' => "Loan Issued",
				'description' => $description,
				'is_credit' => 0,
				'amount' => $principal,
				'balance' => $principal
			);
			
			return $this->db->insert('t_loan_transactions', $data);
		}
		
		public function insert_interest($loan_id,$principal,$interest){
			$balance = $principal + $interest;
			$data = array(
				'loan_id' => $loan_id,
				'transaction' => "Interest",
				'description' => "-",
				'is_credit' => 0,
				'amount' => $interest,
				'balance' => $balance
			);
			
			return $this->db->insert('t_loan_transactions', $data);
		}
		
		public function add_transaction($loan_id,$trans,$description,$is_credit,$total_pay_amount){
			$this->db->select("balance");
			$this->db->where("loan_id = ".$loan_id);
			$this->db->order_by("id","desc");
			$this->db->limit(1);
			$query = $this->db->get("t_loan_transactions");
			$result = $query->row_array();
			$balance = $result["balance"];
			$new_balance = 0;
			if($is_credit){
				$new_balance = $balance - $total_pay_amount;
			}
			else{
				$new_balance = $balance + $total_pay_amount;
			}
			
			$data = array(
				'loan_id' => $loan_id,
				'transaction' => $trans,
				'description' => $description,
				'is_credit' => $is_credit,
				'amount' => $total_pay_amount,
				'balance' => $new_balance
			);
			
			return $this->db->insert('t_loan_transactions', $data);
		}
		
		public function get_loan_transactions($loan_id){
			$this->db->select("*");
			$this->db->where("loan_id = ".$loan_id);
			$this->db->order_by("id","asc");
			$query = $this->db->get("t_loan_transactions");
			return $query->result_array();
		}
		
    }