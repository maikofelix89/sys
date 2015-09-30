<?php
class Customer_balance_detail_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	
	public function get_balance_details($date){
		$balance_details = array();
		
		$this->db->select("id,customer,loan_product,collateral");
		$this->db->where("loan_issue_date < '".$date."' AND request_status = 2 AND (loan_status = 0 OR date_settled > '".$date."')");
		$query = $this->db->get("loans");
		$loan_ids = $query->result_array();
					
		foreach($loan_ids as $loan_id){ 
			$total_amount_due = 0;
			$earliest_due_date = 0;
			
			$this->db->select("name,other_names,mobiletel");
			$this->db->where("id = ".$loan_id["customer"]);
			$query = $this->db->get("customers");
			$customer = $query->row_array();
			//$customer_id = (int) $customer["id"];
			$full_name = $customer["name"]." ".$customer["other_names"];
			$mobile_number = $customer["mobiletel"]; 
			
			$collateral = "-";
			if( !(is_null($loan_id["collateral"])) ){
				$this->db->select("name");
				$this->db->where("id = ".$loan_id["collateral"]);
				$query = $this->db->get("collateral");
				$collateral_array = $query->row_array();
				$collateral = $collateral_array["name"];
			}
						
			$this->db->select("loan_product_name");
			$this->db->where("id = ".$loan_id["loan_product"]);
			$query = $this->db->get("loan_products");
			$loan_product_array = $query->row_array();
			$loan_product = $loan_product_array["loan_product_name"];
		
			$this->db->select("balance,interest_amount_balance,date_expected");
			$this->db->where("loan = ".$loan_id["id"]." AND paid = 0 ");
			$query = $this->db->get("loan_expected_payments");
			$balances = $query->result_array();
			foreach($balances as $balance){ 
				$total_amount_due += $balance["balance"] + $balance["interest_amount_balance"];
				if( ($earliest_due_date == 0) && ($balance["date_expected"] >= $date) ){
					$earliest_due_date = $balance["date_expected"];
				}
			}
			
			/*$this->db->select("interest_amount_balance");
			$this->db->where("loan = ".$loan_id["id"]." AND paid = 0");
			//$this->db->where("loan = ".$loan_id["id"]." AND paid = 0 ");
			$query = $this->db->get("loan_expected_payments");
			$balances = $query->result_array();
			foreach($balances as $balance){ 
				$total_amount_due += $balance["interest_amount_balance"];
				
			}*/
			
			/*echo "test2 ".$loan_opening_bal."<br />";*/
			$this->db->select("amount");
			$this->db->where("loan_id = ".$loan_id["id"]." AND paid = 0 AND dateTime <= '".$date." 00:00:00'");
			$query = $this->db->get("t_transaction_fees");
			$balances = $query->result_array();
			foreach($balances as $balance){
				$total_amount_due += $balance["amount"];
				/*echo "test3 ".$loan_opening_bal."<br />";*/
			}
			
			$this->db->select("balance");
			$this->db->where("loan = ".$loan_id["id"]." AND paid = 0 AND date <= '".$date."'");
			$query = $this->db->get("loan_charges");
			$balances = $query->result_array();
			foreach($balances as $balance){
				$total_amount_due += $balance["balance"];
				/*if($loan_product_id == 3){
					echo "hapa ".$loan_id["id"]." ".$loan_opening_bal."<br />";
				}*/
			}
			
			$this->db->select("id,initial_expected_date,date_expected");
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
					$total_amount_due += $payment["payment_amount"];
					if( ($date <= $expected_id["initial_expected_date"]) && ($earliest_due_date > $expected_id["initial_expected_date"]) ){
						$earliest_due_date = $expected_id["date_expected"];
					}
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
			//echo "here ".$total_amount_due; exit;
			if($total_amount_due > 0){
				 $balance_details[] = $full_name."*".$mobile_number."*".$loan_product."*".$collateral."*".$total_amount_due."*".$earliest_due_date;
			}
		}
						
		return $balance_details;
	}
	
}