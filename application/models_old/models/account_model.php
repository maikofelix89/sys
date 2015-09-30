<?php
	class Account_model extends CI_Model{
	   public $id;
	   public $account_name;
       public $account_opening_balance;
       public $account_balance;
       public $account_desc;
       public $is_exp;
	   public $is_income;
	   public $has_child;
       protected $modelTable  = "accounts";
	   
	   public function __construct(array $data = null){
		   parent::__construct($data);
		   $this->errors = array(
					 'id'=>'',
                     'account_name'=>'',
                     'account_opening_balance'=>'',
                     'account_balance'=>'',
                     'account_desc'=>'',
                     'is_exp'=>'',
					 'is_income'=>'',
					 'has_child'=>'',
              );
		  
	   }
	   
	   public function rules(){
	   
			  return array(
			  
					  'id'=>array(),
					  
					  'account_name'=>array(
					  
							'required' => true,
							
							'alphabet' => true,
					   ),
					   
					  'account_opening_balance'=>array(
					  
							'required' => true,
							
							'numeric' => true,
							
					   ),
					  
					  'account_desc'=>array(
					  
					        'alphanumeric' => true,
					  
					  ),
						  
			   );
	   }
	   
	   public function get_accounts(){
		   	$this->db->select("*");
			$query = $this->db->get("accounts");
		   	return $query->result_array();
	   }
	   
	   public function get_account($id){
		   	$this->db->select("account_name");
			$this->db->where("id = $id");
			$query = $this->db->get("accounts");
		   	$row = $query->row_array();
			return $row['account_name'];
	   }
	   
	   public function find_accounts($acct_id){
	   	$this->db->select("*");
		//$this->db->where("is_exp = 1");
		$this->db->where("id NOT IN(3,".$acct_id.")");
		$query = $this->db->get("accounts");
	   	return $query->result_array();
	   }
		
	   public function find_sub_accounts($parent_id){
	   	$this->db->select("*");
		$this->db->where("parent_id = ".$parent_id);
		//$this->db->where("is_exp = 1");
		$query = $this->db->get("t_sub_accounts");
	   	return $query->result_array();
	   }
	   
	   public function update_account_balance($account_id,$amount,$flag){
	   		$this->db->where('id', $account_id);
			if($flag == 1){
				$this->db->set('account_balance', 'account_balance + '.$amount, FALSE);
			}
			else{
				$this->db->set('account_balance', 'account_balance - '.$amount, FALSE);
			}
			$this->db->update('accounts');
			return $this->db->affected_rows();
	   }
	   
	    public function update_sub_account_balance($account_id,$amount,$flag){
	   		$this->db->where('id', $account_id);
			if($flag == 1){
				$this->db->set('account_balance', 'account_balance + '.$amount, FALSE);
			}
			else{
				$this->db->set('account_balance', 'account_balance - '.$amount, FALSE);
			}
			$this->db->update('t_sub_accounts');
			return $this->db->affected_rows();
	   }
	   
	   public function insert_transaction($obj,$t_code,$acct,$sub_acct,$t_type,$description,$date,$amount,$usr,$p_code,$ref_num){
			$data = array(
				'object' => $obj,
				'transaction_code' => $t_code,
				'account' => $acct,
				'sub_account' => $sub_acct,
				'transactiontype' => $t_type,
				'description' => $description,
				'date' => $date,
				'transactiontype' => $t_type,
				'amounttransacted' => $amount,
				'user' => $usr,
				'payment_code' => $p_code,
				'ref_num' => $ref_num
			);
			return $this->db->insert('account_transactions', $data);
		}
		
		public function insert_income($account_id,$amount,$transaction_code,$user_id){
			$data = array(
				'account_id' => $account_id,
				'amount' => $amount,
				'transaction_code' => $transaction_code,
				'submitted_by' => $user_id
			);
			return $this->db->insert('t_finance_income', $data);
		}
	   
	   public function update_account_has_child($acct_id){
	   	$this->db->where('id', $acct_id);
		$this->db->set('has_child',1);
		$this->db->update('accounts');
		return $this->db->affected_rows();
	   }
	   
	}
