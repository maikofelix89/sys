<?php
	class Transaction_model extends CI_Model{
	   public $object;
       public $transaction_code;
       public $account;
       public $transactiontype;
       public $description;
       public $date;
       public $amounttransacted;
       public $user;
	   public $payment_code;
	   public $acct_bal;
	   public $ref_num;
       protected $modelTable  = "account_transactions";
	   
	   public function __construct(array $data = null){
		   parent::__construct($data);
		   $this->errors = array(
					 'id'=>'',
                     'object'=>'',
                     'transaction_code'=>'',
                     'account'=>'',
                     'transactiontype'=>'',
                     'description'=>'',
                     'date'=>'',
                     'amounttransacted'=>'',
                     'user'=>'',
					 'payment_code'=>'',
					 'acct_bal'=>'',
					 'ref_num'=>'',
              );
		  
	   }
	   
	   public function rules(){
	      return array(
					  'id'=>array(),
                      'object'=>array(),
                      'transaction_code'=>array(),
                      'account'=>array(),
                      'transactiontype'=>array(),
                      'description'=>array(),
                      'date'=>array(),
                      'amounttransacted'=>array(),
                      'payment_code'=>array(),
					  'acct_bal'=>array(),
					  'ref_num'=>array(),
              );
	   }
	   
	   public function get_customer_id($transaction_code){
	   		
	   		$this->db->select("customer");
			$this->db->where("transaction_code = '".$transaction_code."'");
			$query = $this->db->get("loans");
			
			$customer_id_array = $query->row_array();
			return $query->num_rows() > 0 ? $customer_id_array["customer"]:0;
	   }
	   
	   public function get_customer($customer_id){
			$this->db->select("name,other_names,mobiletel");
			$this->db->where("id = ".$customer_id);
			$query = $this->db->get("customers");
			return $query->row_array();
		}
		
		 public function get_amount($payment_code){
			$this->db->select("amount");
			$this->db->where("payment_code = '".$payment_code."'");
			$this->db->where("is_deleted = 0");
			$query = $this->db->get("t_loan_all_payments");
			$amount_array = $query->row_array();
			return $amount_array["amount"];
		}
		
		public function update_transaction_details($payment_code,$new_payment_code){
			$this->db->where("payment_code = '".$payment_code."'");
			$this->db->set("is_deleted", 1, FALSE);
			$this->db->set("transfered_to", $new_payment_code);
			$this->db->update("account_transactions");
			return $this->db->affected_rows();
		}
		
		public function get_account_name($acct_id){
			$this->db->select("account_name");
			$this->db->where("id = ".$acct_id);
			$query = $this->db->get("accounts");
			$amount_array = $query->row_array();
			return $amount_array["account_name"];
		}
		
		public function insert_new_transaction($object,$trans_code,$acct,$type,$description,$date,$amount,$user_id,$payment_code){
			$data = array(
				'object' => $object,
				'transaction_code' => $trans_code,
				'account' => $acct,
				'transactiontype' => $type,
				'description' => $description,
				'date' => $date,
				'amounttransacted' => $amount,
				'user' => $user_id,
				'payment_code' => $payment_code
			);
			$this->db->insert('account_transactions', $data);
			return $this->db->affected_rows();
		}
		
		public function update_balance($account_id,$amount,$flag){
			$this->db->where('id', $account_id);
			if($flag == 1){
				$this->db->set('account_balance', 'account_balance + '.$amount, FALSE);
			}
			elseif($flag == 0){
				$this->db->set('account_balance', 'account_balance - '.$amount, FALSE);
			}
			
			$this->db->update('accounts');
			return $this->db->affected_rows();
		}
	}
