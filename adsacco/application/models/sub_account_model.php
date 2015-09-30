<?php
	class Sub_account_model extends CI_Model{
	   public $id;
	   public $account_name;
       public $account_opening_balance;
       public $account_balance;
       public $account_desc;
       public $is_exp;
	  public $parent_id;
       protected $modelTable  = "t_sub_accounts";
	   
	   public function __construct(array $data = null){
		   parent::__construct($data);
		   $this->errors = array(
					 'id'=>'',
                     'account_name'=>'',
                     'account_opening_balance'=>'',
                     'account_balance'=>'',
                     'account_desc'=>'',
                     'is_exp'=>'',
					 'parent_id'=>'',
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
	   
	   public function find_accounts(){
		   	$this->db->select("*");
			$query = $this->db->get("accounts");
		   	return $query->result_array();
	   }
	   
	   public function find_sub_accounts(){
		   	$this->db->select("*");
			$query = $this->db->get("t_sub_accounts");
		   	return $query->result_array();
	   }
	   
	   public function get_sub_accounts($account_id){
	   		$this->db->select("*");
			$this->db->where("parent_id = ".$account_id);
			$query = $this->db->get("t_sub_accounts");
		   	return $query->result_array();
	   }
	   
	}
