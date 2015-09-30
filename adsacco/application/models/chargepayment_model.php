<?php
	class Chargepayment_model extends CI_Model{
	   public $charge;
       public $date;
       public $amount;
       public $channel;
       public $transaction_code;
       protected $modelTable  = "loan_charges_payments";
	   
	   public function __construct(array $data = null){
		   parent::__construct($data);
		   $this->errors = array(
					 'id'=>'',
                     'charge'=>'',
                     'date'=>'',
                     'amount'=>'',
                     'channel'=>'',
                     'transaction_code'=>'',
              );
		  
	   }
	   
	   public function rules(){
	      return array(
					  'id'=>array(),
                      'charge'=>array(),
                      'date'=>array(),
                      'amount'=>array(),
                      'channel'=>array(),
                      'transaction_code'=>array(),
              );
	   }

	}
