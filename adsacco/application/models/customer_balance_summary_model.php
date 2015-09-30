<?php
class Customer_balance_summary_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	
	public function get_balance_summaries($date){
		$balance_summaries = array();
		
		$this->db->select("id,name,other_names");
		$query = $this->db->get("customers");
		$customers = $query->result_array();
		foreach($customers as $customer){ 
			$customer_id = (int) $customer["id"];
			$full_name = $customer["name"]." ".$customer["other_names"];
			$total_bal = 0;
			$this->db->select("id");
			$this->db->where("customer = $customer_id AND loan_issue_date <= '".$date."' AND request_status = 2 AND (loan_status = 0 OR date_settled > '".$date."')");
			$query = $this->db->get("loans");
			$loan_ids = $query->result_array();
					
			foreach($loan_ids as $loan_id){ 
				
				/*if($loan_product_id == 3){ echo "test ".$loan_opening_bal."<br />"; }*/
				$this->db->select("balance");
				//$this->db->where("loan = ".$loan_id["id"]." AND paid = 0 AND initial_expected_date <= '".$date_check1."'");
				$this->db->where("loan = ".$loan_id["id"]." AND paid = 0 ");
				$query = $this->db->get("loan_expected_payments");
				$balances = $query->result_array();
				foreach($balances as $balance){ 
					//if($loan_product_id == 3){ /*echo "test1 ".$loan_opening_bal."<br />";*/ }
					$total_bal += $balance["balance"];
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
					$total_bal += $balance["interest_amount_balance"];
					/*if($loan_product_id == 3){
						echo "here ".$loan_id["id"]." ".$loan_opening_bal."<br />";
					}*/
				}
				
				/*echo "test2 ".$loan_opening_bal."<br />";*/
				$this->db->select("amount");
				$this->db->where("loan_id = ".$loan_id["id"]." AND paid = 0 AND dateTime <= '".$date." 00:00:00'");
				$query = $this->db->get("t_transaction_fees");
				$balances = $query->result_array();
				foreach($balances as $balance){
					$total_bal += $balance["amount"];
					/*echo "test3 ".$loan_opening_bal."<br />";*/
				}
				
				$this->db->select("balance");
				$this->db->where("loan = ".$loan_id["id"]." AND paid = 0 AND date <= '".$date."'");
				$query = $this->db->get("loan_charges");
				$balances = $query->result_array();
				foreach($balances as $balance){
					$total_bal += $balance["balance"];
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
					$this->db->where("payment = ".$expected_id["id"]." AND payment_date > '".$date."' AND is_deleted = 0");
					$query = $this->db->get("loan_payments");
					$payments = $query->result_array();
					foreach($payments as $payment){
						$total_bal += $payment["payment_amount"];
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
						$total_bal += $amount["amount"];
						/*if($loan_product_id == 3){
							echo "ggg ".$loan_id["id"]." ".$amount["amount"]."<br />";
						}*/
					}
				}
			
			}
			if($total_bal > 0){
				 $balance_summaries[] = $full_name."*".$total_bal;
			}
			
		}
		return $balance_summaries;
	}
	
}