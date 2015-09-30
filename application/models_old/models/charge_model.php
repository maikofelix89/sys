<?php
	class Charge_model extends CI_Model{
	   public $transaction_code;
       public $name;
       public $loan;
       public $date;
       public $amount;
       public $balance;
       public $waiver;
       public $paid;
       protected $modelTable  = "loan_charges";
	   
	   public function __construct(array $data = null){
		   parent::__construct($data);
		   $this->errors = array(
					 'id'=>'',
                     'transaction_code'=>'',
                     'name'=>'',
                     'loan'=>'',
                     'date'=>'',
                     'amount'=>'',
                     'balance'=>'',
                     'waiver'=>'',
                     'paid'=>'',
              );
		  
	   }
	   
	   public function rules(){
	      return array(
					  'id'=>array(),
                      'transaction_code'=>array(),
                      'name'=>array(),
                      'loan'=>array(),
                      'date'=>array(),
                      'amount'=>array(),
                      'balance'=>array(),
                      'waiver'=>array(),
                      'paid'=>array(),
              );
	   }
	   
	   public function insert_transaction_fee($data){
	   		$this->db->insert('t_transaction_fees', $data);
			return $this->db->affected_rows();
	   }
	}
