<?php
	class Product_model extends CI_Model{
	   public $loan_product_name;
       public $loan_product_description;
       public $interest_type;
       public $interest_rate;
       public $minimum_amount_loaned;
       public $maximum_amount_loaned;
       public $minimum_duration;
       public $maximum_duration;
       public $status;
       public $loan_repayment_frequency;
       public $repayment_frequency_single;
       public $reschedulement_fee_exact;
       public $reschedulement_fee_percent;
       public $reschedulement_fee_interms;
       public $transaction_fee_exact;
       public $transaction_fee_percent;
       public $transaction_fee_interms;
       public $loan_service_fee_exact;
       public $loan_service_fee_percent;
       public $loan_service_fee_interms;
       public $loan_service_fee_frequency;
       public $late_payment_fee_exact;
       public $late_payment_fee_percent;
       public $late_payment_fee_interms;
       public $late_payment_fee_frequency;
       public $interest_fee_exact;
       public $interest_fee_interms;
       public $interest_fee_percent;
       public $interest_fee_frequency;
       protected $modelTable  = "loan_products";
	   
	   public function __construct(array $data = null){
		   parent::__construct($data);
		   $this->errors = array(
					 'id'=>'',
                     'loan_product_name'=>'',
                     'loan_product_description'=>'',
                     'interest_type'=>'',
                     'interest_rate'=>'',
                     'minimum_amount_loaned'=>'',
                     'maximum_amount_loaned'=>'',
                     'minimum_duration'=>'',
                     'maximum_duration'=>'',
                     'status'=>'',
                     'loan_repayment_frequency'=>'',
                     'repayment_frequency_single'=>'',
                     'reschedulement_fee_exact'=>'',
                     'reschedulement_fee_percent'=>'',
                     'reschedulement_fee_interms'=>'',
                     'transaction_fee_exact'=>'',
                     'transaction_fee_percent'=>'',
                     'transaction_fee_interms'=>'',
                     'loan_service_fee_exact'=>'',
                     'loan_service_fee_percent'=>'',
                     'loan_service_fee_interms'=>'',
                     'loan_service_fee_frequency'=>'',
                     'late_payment_fee_exact'=>'',
                     'late_payment_fee_percent'=>'',
                     'late_payment_fee_interms'=>'',
                     'late_payment_fee_frequency'=>'',
                     'interest_fee_exact'=>'',
                     'interest_fee_interms'=>'',
                     'interest_fee_percent'=>'',
                     'interest_fee_frequency'=>'',
              );
		  
	   }
	   
	  
	    public function rules(){
	   
			  return array(
			  
					  'id'=>array(),
					  
					  'loan_product_name'=>array(
					  
							'required' => true,
							
							'alphabet' => true,
							
					  ),
					  
					  'loan_product_description'=>array(
							
							'required' => true,
					  ),
					  
					  'interest_type'=>array(
					  
							'required' => true,
							
							'alphabed' => true,
					  
					   ),
					   
					  'interest_rate'=>array(
					  
							'required' => true,
							
							'numeric' => true,
					  
					   ),
					   
					  'minimum_amount_loaned'=>array(
					  
							'required' => true,
							
							'numeric' => true,
					  
					   ),
					   
					  'maximum_amount_loaned'=>array(
					  
							'required' => true,
							
							'numeric' => true,
					  
					   ),
					   
					  'minimum_duration'=>array(
					  
							'required' => true,
							
							'numeric' => true,
					  
					   ),
					   
					  'maximum_duration'=>array(
					  
							'required' => true,
							
							'numeric' => true,
					  
					   ),
					   
					  'status'=>array(
					  
					   ),
					   
					  'loan_repayment_frequency'=>array(
					     
						    'required' => true,
							
							'alphabet' => true,
					  
					  ),
			  );
			  
	   }


	}
