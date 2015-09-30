<?php
	class customeraccount_model extends CI_Model{
	   public $customer;
       public $balance;
       protected $modelTable  = "customer_accounts";
	   
	   public function __construct(array $data = null){

		   parent::__construct($data);

		   $this->errors = array(
					 'id'=>'',
                     'customer'=>'',
                     'balance'=>'',
              );
		  
	   }
	   
	   public function rules(){
		      return array(
						  'id'=>array(),
	                      'customer'=>array(),
	                      'balance'=>array(),
	              );
	   }

	   public function relations(){
 			
 			 return array(
					  'id'=>array(),

                      'customer'=>array(

                      	 'class' => 'customer_model',

                      	 'rel_type'=>'one-to-one',

                         'foreign_key_name'=>'id'

                       ),

                      'balance'=>array(),
              );

	   }

	}
