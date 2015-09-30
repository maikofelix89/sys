<?php
	class Payment_model extends CI_Model{
	   public $payment;
       public $transaction_code;
       public $payment_amount;
       public $payment_date;
       public $payment_channel;
       public $desc;
       protected $modelTable  = "loan_payments";
	   
	   public function __construct(array $data = null){
		   parent::__construct($data);
		   $this->errors = array(
					 'id'=>'',
                     'payment'=>'',
                     'transaction_code'=>'',
                     'payment_amount'=>'',
                     'payment_date'=>'',
                     'payment_channel'=>'',
                     'desc'=>'',
              );
		  
	   }
	   
	   public function rules(){
	      return array(
					  'id'=>array(),
                      'payment'=>array(),
                      'transaction_code'=>array(),
                      'payment_amount'=>array(),
                      'payment_date'=>array(),
                      'payment_channel'=>array(),
                      'desc'=>array(),
              );
	   }

       public function relations(){
        return array(
            'id'=>array(),
                      'payment'=>array(
                            'class' => 'expectedpayment_model',

                            'rel_type' => 'one-to-one',

                            'foreign_key_name' => 'id'
                       ),
                      'transaction_code'=>array(),
                      'payment_amount'=>array(),
                      'payment_date'=>array(),
                      'payment_channel'=>array(),
                      'desc'=>array(),
              );
     }

	}
