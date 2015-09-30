<?php
class Reports_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_loan_products(){
		$this->db->select("*");
		$query = $this->db->get("loan_products");
		return $query->result_array();
	}
	
	public function get_loan_opening_bal($loan_product_id,$date_check,$date,$date_check1){
		$this->db->select("id");
		$this->db->where("loan_product = ".$loan_product_id." AND request_status = 2 AND loan_issue_date < '".$date_check."' AND (loan_status = 0 OR date_settled >= '".$date_check."')");
		$query = $this->db->get("loans");
		$loan_ids = $query->result_array();
		$loan_opening_bal = 0;
		
		foreach($loan_ids as $loan_id){ 
			/*if($loan_product_id == 3){ echo "test ".$loan_opening_bal."<br />"; }*/
			$this->db->select("balance");
			//$this->db->where("loan = ".$loan_id["id"]." AND paid = 0 AND initial_expected_date <= '".$date_check1."'");
			$this->db->where("loan = ".$loan_id["id"]." AND paid = 0 ");
			$query = $this->db->get("loan_expected_payments");
			$balances = $query->result_array();
			foreach($balances as $balance){ 
				//if($loan_product_id == 3){ /*echo "test1 ".$loan_opening_bal."<br />";*/ }
				$loan_opening_bal += $balance["balance"];
				/*if($loan_product_id == 3){
					echo "here ".$loan_id["id"]." ".$loan_opening_bal."<br />";
				}*/
			}
			
			$this->db->select("interest_amount_balance");
			$this->db->where("loan = ".$loan_id["id"]." AND paid = 0 AND initial_expected_date <= '".$date_check1."'");
			//$this->db->where("loan = ".$loan_id["id"]." AND paid = 0 ");
			$query = $this->db->get("loan_expected_payments");
			$balances = $query->result_array();
			foreach($balances as $balance){ 
				//if($loan_product_id == 3){ /*echo "test1 ".$loan_opening_bal."<br />";*/ }
				$loan_opening_bal += $balance["interest_amount_balance"];
				/*if($loan_product_id == 3){
					echo "here ".$loan_id["id"]." ".$loan_opening_bal."<br />";
				}*/
			}
			
			/*echo "test2 ".$loan_opening_bal."<br />";*/
			$this->db->select("amount");
			$this->db->where("loan_id = ".$loan_id["id"]." AND paid = 0 AND dateTime < '".$date_check." 00:00:00'");
			$query = $this->db->get("t_transaction_fees");
			$balances = $query->result_array();
			foreach($balances as $balance){
				$loan_opening_bal += $balance["amount"];
				/*echo "test3 ".$loan_opening_bal."<br />";*/
			}
			
			$this->db->select("balance");
			$this->db->where("loan = ".$loan_id["id"]." AND paid = 0 AND date < '".$date_check."'");
			$query = $this->db->get("loan_charges");
			$balances = $query->result_array();
			foreach($balances as $balance){
				$loan_opening_bal += $balance["balance"];
				/*if($loan_product_id == 3){
					echo "hapa ".$loan_id["id"]." ".$loan_opening_bal."<br />";
				}*/
			}
			
			$this->db->select("id");
			//$this->db->where("loan = ".$loan_id["id"]." AND initial_expected_date <= '".$date_check1."'");
			$this->db->where("loan = ".$loan_id["id"]." AND initial_expected_date <= '".$date_check1."'");
			$query = $this->db->get("loan_expected_payments");
			$expected_ids = $query->result_array();
			foreach($expected_ids as $expected_id){
				$this->db->select("payment_amount");
				$this->db->where("payment = ".$expected_id["id"]." AND payment_date >= '".$date_check."' AND is_deleted = 0");
				$query = $this->db->get("loan_payments");
				$payments = $query->result_array();
				foreach($payments as $payment){
					$loan_opening_bal += $payment["payment_amount"];
					/*if($loan_product_id == 3){
						echo "sss ".$loan_id["id"]." ".$payment["payment_amount"]."<br />";
					}*/
				}
			}
			
			$this->db->select("id");
			$this->db->where("loan = ".$loan_id["id"]." AND date < '".$date_check."'");
			$query = $this->db->get("loan_charges");
			$charge_ids = $query->result_array();
			foreach($charge_ids as $charge_id){
				$this->db->select("amount");
				$this->db->where("charge = ".$charge_id["id"]." AND date >= '".$date_check."' AND is_deleted = 0");
				$query = $this->db->get("loan_charges_payments");
				$amounts = $query->result_array();
				foreach($amounts as $amount){
					$loan_opening_bal += $amount["amount"];
					/*if($loan_product_id == 3){
						echo "ggg ".$loan_id["id"]." ".$amount["amount"]."<br />";
					}*/
				}
			}
		
		}
		return $loan_opening_bal;
	}
	
	public function get_loan_fresh_disbursement($loan_product_id,$date){
		$this->db->select("loan_principle_amount");
		$this->db->where("loan_issue_date LIKE '".$date."%' AND loan_product = ".$loan_product_id." AND request_status=2");
		$query = $this->db->get("loans");
		$loan_principals = $query->result_array();
		$fresh_disbursements = 0;
		foreach($loan_principals as $loan_principal){
			$fresh_disbursements += $loan_principal["loan_principle_amount"];
		}
		return $fresh_disbursements;
	}
	
	public function get_loan_transaction_fees($loan_product_id,$date){
		$this->db->select("loan_id, amount");
		$this->db->where("dateTime LIKE '".$date."%'");
		$query = $this->db->get("t_transaction_fees");
		$transactions = $query->result_array();
		$transaction_fees = 0;
		
		$this->db->select("id");
		$this->db->where("loan_issue_date LIKE '".$date."%' AND loan_product = ".$loan_product_id." AND request_status=2");
		$query = $this->db->get("loans");
		$loan_ids = $query->result_array();
		foreach($loan_ids as $loan_id){
			foreach($transactions as $transaction){
				if($transaction['loan_id'] == $loan_id['id']) $transaction_fees += $transaction['amount'];
			}
		}
		
		return $transaction_fees;
	}
	
	public function get_interests_a($loan_product_id,$date,$date_a){
		$interest = 0;
		if($loan_product_id == 2){
			$this->db->select("id");
			$this->db->where("loan_product = ".$loan_product_id." AND request_status=2");
			$query = $this->db->get("loans");
			$loan_ids = $query->result_array();
			foreach($loan_ids as $loan_id){
				$this->db->select("interest_amount");
				$this->db->where("loan = ".$loan_id["id"]." AND initial_expected_date LIKE '".$date_a."%'");
				$query = $this->db->get("loan_expected_payments");
				$amounts = $query->result_array();
				foreach($amounts as $amount){
					$interest += $amount["interest_amount"];
				}
			}
		}
		else{
			$this->db->select("total_interest_amount");
			$this->db->where("loan_issue_date LIKE '".$date."%' AND loan_product = ".$loan_product_id);
			$query = $this->db->get("loans");
			$loan_interests = $query->result_array();
			foreach($loan_interests as $loan_interest){
				$interest += $loan_interest["total_interest_amount"];
			}
		}
		
		return $interest;
	}
	
	public function get_interests_c($loan_product_id,$date){
		$this->db->select("id");
		$this->db->where("loan_product = ".$loan_product_id." AND request_status=2");
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
	
	public function get_charges_a($loan_product_id,$date,$name){
		$this->db->select("id");
		$this->db->where("loan_product = ".$loan_product_id." AND request_status=2");
		$query = $this->db->get("loans");
		$loan_ids = $query->result_array();
		$charges = 0;
		foreach($loan_ids as $loan_id){
			$this->db->select("amount,waiver");
			$this->db->where("name = '".$name."' AND date LIKE '".$date."%' AND loan = ".$loan_id["id"]);
			$query = $this->db->get("loan_charges");
			$amounts = $query->result_array();
			foreach($amounts as $amount){ 
				$charges += $amount["amount"] - $amount["waiver"];
			}
		}
		return $charges;
	}
	
	public function get_charges_c($loan_product_id,$date,$name){
		$this->db->select("id");
		$this->db->where("loan_product = ".$loan_product_id." AND request_status=2");
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
	
	public function get_principal_collected($loan_product_id,$date){
		$this->db->select("id");
		$this->db->where("loan_product = ".$loan_product_id." AND request_status=2");
		$query = $this->db->get("loans");
		$loan_ids = $query->result_array();
		$principal = 0;
		foreach($loan_ids as $loan_id){
			$this->db->select("id");
			$this->db->where("loan = ".$loan_id["id"]);
			$query = $this->db->get("loan_expected_payments");
			$expected_ids = $query->result_array();
			foreach($expected_ids as $expected_id){
				$this->db->select("payment_amount");
				$this->db->where("payment = ".$expected_id["id"]." AND payment_date LIKE '".$date."%' AND for_principal = 1 AND is_deleted = 0");
				$query = $this->db->get("loan_payments");
				$payments = $query->result_array();
				foreach($payments as $payment){ //if($loan_product_id == 5) echo $expected_id["id"]." ".$payment["payment_amount"]." ".$query;
					$principal += $payment["payment_amount"];
				}
			}
		}
		return $principal;
	}
	
		public function get_loan_closing_bal($loan_product_id,$date_check,$date_check1,$date_plus){ //echo $date_check1;
		$this->db->select("id");
		$this->db->where("loan_product = ".$loan_product_id." AND request_status = 2 AND loan_issue_date <= '".$date_check1."'");
		$query = $this->db->get("loans");
		$loan_ids = $query->result_array();
		$loan_closing_bal = 0;
		foreach($loan_ids as $loan_id){
			$this->db->select("balance");
			//if($loan_product_id == 2){
				//$this->db->where("loan = ".$loan_id["id"]." AND paid = 0 AND initial_expected_date <= '".$date_plus."'");
				$this->db->where("loan = ".$loan_id["id"]." AND paid = 0");
			//}
			//else{
			//	$this->db->where("loan = ".$loan_id["id"]." AND paid = 0 AND date_expected <= ".$date_plus);
			//}
			$query = $this->db->get("loan_expected_payments");
			$balances = $query->result_array();
			foreach($balances as $balance){
				$loan_closing_bal += $balance["balance"];
			}
			
			$this->db->select("interest_amount_balance");
			//if($loan_product_id == 2){
				$this->db->where("loan = ".$loan_id["id"]." AND paid = 0 AND initial_expected_date <= '".$date_plus."'");
				//$this->db->where("loan = ".$loan_id["id"]." AND paid = 0");
			//}
			//else{
			//	$this->db->where("loan = ".$loan_id["id"]." AND paid = 0 AND date_expected <= ".$date_plus);
			//}
			$query = $this->db->get("loan_expected_payments");
			$balances = $query->result_array();
			foreach($balances as $balance){
				$loan_closing_bal += $balance["interest_amount_balance"];
			}
			
			$this->db->select("amount");
			$this->db->where("loan_id = ".$loan_id["id"]." AND paid = 0 AND dateTime <= '".$date_check1." 23:59:59'");
			$query = $this->db->get("t_transaction_fees");
			$balances = $query->result_array();
			foreach($balances as $balance){
				$loan_closing_bal += $balance["amount"];
			}
			
			$this->db->select("balance");
			$this->db->where("loan = ".$loan_id["id"]." AND paid = 0 AND date <= '".$date_check1."'");
			$query = $this->db->get("loan_charges");
			$balances = $query->result_array();
			foreach($balances as $balance){
				$loan_closing_bal += $balance["balance"];
			}
			
			$this->db->select("id");
			//$this->db->where("loan = ".$loan_id["id"]." AND initial_expected_date <= '".$date_plus."'");
			$this->db->where("loan = ".$loan_id["id"]);
			$query = $this->db->get("loan_expected_payments");
			$expected_ids = $query->result_array();
			foreach($expected_ids as $expected_id){
				$this->db->select("payment_amount");
				$this->db->where("payment = ".$expected_id["id"]." AND payment_date > '".$date_check1."' AND is_deleted = 0");
				$query = $this->db->get("loan_payments");
				$payments = $query->result_array();
				foreach($payments as $payment){ //if($loan_product_id == 5) echo $expected_id["id"]." ".$payment["payment_amount"]." ".$query;
					$loan_closing_bal += $payment["payment_amount"];
					/*if($loan_product_id == 3){
						echo "sss ".$loan_id["id"]." ".$payment["payment_amount"]."<br />";
					}*/
				}
			}
			
			$this->db->select("id");
			$this->db->where("loan = ".$loan_id["id"]." AND date <= '".$date_check1."'");
			$query = $this->db->get("loan_charges");
			$charge_ids = $query->result_array();
			foreach($charge_ids as $charge_id){
				$this->db->select("amount");
				$this->db->where("charge = ".$charge_id["id"]." AND date > '".$date_check1."' AND is_deleted = 0");
				$query = $this->db->get("loan_charges_payments");
				$amounts = $query->result_array();
				foreach($amounts as $amount){
					$loan_closing_bal += $amount["amount"];
					/*if($loan_product_id == 3){
						echo "ggg ".$loan_id["id"]." ".$amount["amount"]."<br />";
					}*/
				}
			}
		}
		return $loan_closing_bal;
	}
	
	
	
	
	
	
	public function get_principal_bal($loan_product_id,$date){
		$this->db->select("id");
		$this->db->where("loan_issue_date < '".$date."' AND loan_product = ".$loan_product_id." AND loan_status = 0 AND request_status=2");
		$query = $this->db->get("loans");
		$loan_ids = $query->result_array();
		$principal_bal = 0;
		foreach($loan_ids as $loan_id){
			$this->db->select("balance");
			$this->db->where("loan = ".$loan_id["id"]." AND paid = 0");
			$query = $this->db->get("loan_expected_payments");
			$balances = $query->result_array();
			foreach($balances as $balance){
				$principal_bal += $balance["balance"];
			}
		}
		return $principal_bal;
	}
	
	
	
	
	
	public function get_transaction_fees($current_date){
		$this->db->select("amount");
		$this->db->where("dateTime LIKE '".$current_date."%'");
		$query = $this->db->get("t_transaction_fees");
		return $query->result_array();
	}
	
	public function get_interest($current_date){
		$this->db->select("total_interest_amount");
		$this->db->where("loan_product <> 2 AND loan_issue_date LIKE '".$current_date."%' AND request_status=2");
		$query = $this->db->get("loans");
		return $query->result_array();
	}
	
	public function get_interest_b($current_date){
		$this->db->select("interest_amount");
		$this->db->where("loan_product = 2 AND initial_expected_date LIKE '".$current_date."%'");
		$query = $this->db->get("loan_expected_payments");
		return $query->result_array();
	}
	
	public function get_charges($current_date){
		$this->db->select("name,amount,waiver");
		$this->db->where("date_time LIKE '".$current_date."%'");
		$query = $this->db->get("loan_charges");
		return $query->result_array();
	}
	
}