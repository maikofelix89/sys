<?php
	class Expectedpayment_model extends CI_Model{
	   public $id;
	   public $loan;
       public $amount;
       public $balance;
       public $interest_amount;
       public $interest_amount_balance;
       public $date_expected;
       public $paid;
       public $transaction_code;
	   public $initial_expected_date;
       protected $modelTable  = "loan_expected_payments";
	   
	   public function __construct(array $data = null){
		   parent::__construct($data);
		   $this->errors = array(
					 'id'=>'',
                     'loan'=>'',
                     'amount'=>'',
                     'balance'=>'',
                     'interest_amount'=>'',
                     'interest_amount_balance'=>'',
                     'date_expected'=>'',
                     'paid'=>'',
                     'transaction_code'=>'',
					 'initial_expected_date'=>'',
              );
		  
	   }
	   
	   public function rules(){
	      return array(
					  'id'=>array(),
                      'loan'=>array(),
                      'amount'=>array(),
                      'balance'=>array(),
                      'interest_amount'=>array(),
                      'interest_amount_balance'=>array(),
                      'date_expected'=>array(),
                      'paid'=>array(),
                      'transaction_code'=>array(),
					  'initial_expected_date'=>array(),
              );
	   }

      public function relations(){
        return array(
            'id'=>array(),
                      'loan'=>array(

                            'class'=>'loan_model',   
                         
                            'rel_type'=>'one-to-one',
                         
                            'foreign_key_name'=>'id'
                       ),
                      'amount'=>array(),
                      'balance'=>array(),
                      'interest_amount'=>array(),
                      'interest_amount_balance'=>array(),
                      'date_expected'=>array(),
                      'paid'=>array(),
                      'transaction_code'=>array(),
              );
     }

	}
