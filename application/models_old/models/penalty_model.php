<?php
	class Penalty_model extends CI_Model{
	   public $penalty_id;
       public $penalty_type_id;
       public $loan_id;
       public $user_id;
       public $penalty_amount;
       public $last_updated;
       public $penalty_type;
       public $penalty_status;
       public $penalty_desc;
       public $payment_date;
       protected $modelTable  = "loan_penalties";
	   
	   public function __construct(array $data = null){
		   parent::__construct($data);
		   $this->errors = array(                    
            		 'penalty_id'=>'',
                     'penalty_type_id'=>'',
                     'loan_id'=>'',
                     'user_id'=>'',
                     'penalty_amount'=>'',
                     'last_updated'=>'',
                     'penalty_type'=>'',
                     'penalty_status'=>'',
                     'penalty_desc'=>'',
                     'payment_date'=>'',
              );
		  
	   }
	   
	   public function rules(){
	      return array(                      
		              'penalty_id'=>array(),
                      'penalty_type_id'=>array(),
                      'loan_id'=>array(),
                      'user_id'=>array(),
                      'penalty_amount'=>array(),
                      'last_updated'=>array(),
                      'penalty_type'=>array(),
                      'penalty_status'=>array(),
                      'penalty_desc'=>array(),
                      'payment_date'=>array(),
              );
	   }

	}
