<?php
	class Loan_model extends CI_Model{
	   public $id;
	   public $transaction_code;
       public $customer;
       public $loan_product;
       public $loan_principle_amount;
       public $loan_duration;
       public $loan_issue_date;
       public $loan_due_date;
       public $total_interest_amount;
       public $loan_balance_amount;
       public $request_status;
       public $loan_status;
       public $loan_amount_payable;
       public $installment_amount;
       public $installment_interest;
	   public $collateral;
       public $gaurantor;
	   public $guarantor_b;
	   public $date_settled;
	   public $disbursement_description;
	   public $discounted;
	   public $penalizable;
       protected $modelTable  = "loans";
	   
	   public function __construct(array $data = null){
		   parent::__construct($data);
		   $this->errors = array(
					 'id'=>'',
                     'transaction_code'=>'',
                     'customer'=>'',
                     'loan_product'=>'',
                     'loan_principle_amount'=>'',
                     'loan_duration'=>'',
                     'loan_issue_date'=>'',
                     'loan_due_date'=>'',
                     'total_interest_amount'=>'',
                     'loan_balance_amount'=>'',
                     'request_status'=>'',
                     'loan_status'=>'',
                     'loan_amount_payable'=>'',
                     'installment_amount'=>'',
                     'installment_interest'=>'',
					 'collateral'=>'',
                     'gaurantor'=>'',
					 'guarantor_b'=>'',
					 'date_settled'=>'',
					 'disbursement_description'=>'',
					 'discounted'=>'',
					 'penalizable'=>''
              );
		  
	   }
	   
	   public function rules(){
	      return array(
					  'id'=>array(),
                      'transaction_code'=>array(),
                      'customer'=>array(),
                      'loan_product'=>array(),
                      'loan_principle_amount'=>array(),
                      'loan_duration'=>array(),
                      'loan_issue_date'=>array(),
                      'loan_due_date'=>array(),
                      'total_interest_amount'=>array(),
                      'loan_balance_amount'=>array(),
                      'request_status'=>array(),
                      'loan_status'=>array(),
                      'loan_amount_payable'=>array(),
                      'installment_amount'=>array(),
                      'installment_interest'=>array(),
					  'collateral'=>array(),
                      'gaurantor'=>array(),
					  'guarantor_b'=>array(),
					  'date_settled'=>array(),
					  'disbursement_description'=>array(),
					  'discounted'=>array(),
					  'penalizable'=>array()
              );
	   }


      public function relations(){
        return array(
            'id'=>array(),
                      'customer'=>array(
                      
                            'class'=>'customer_model',   
                         
                            'rel_type'=>'one-to-one',
                         
                            'foreign_key_name'=>'id'
               
                      ),
					  
					  'collateral'=>array(

                           'class'=>'collateral_model',

                           'rel_type'=>'one-to-one',

                           'foreign_key_name'=>'id'
                       ),

                      'loan_product'=>array(

                           'class'=>'product_model',

                           'rel_type'=>'one-to-one',

                           'foreign_key_name'=>'id'
                       ),
					   
					  'gaurantor'=>array(
						    
						   'class'=>'gaurantor_model',

                           'rel_type'=>'one-to-one',

                           'foreign_key_name'=>'id'
						),
              );
     }
	 
	 public function waive_interest($payment_id,$amt,$loan_id){
	 	$this->db->where('id', $payment_id);
		$this->db->set('interest_amount', 'interest_amount - '.$amt, FALSE);
		$this->db->set('interest_amount_balance', 'interest_amount_balance - '.$amt, FALSE);
		$this->db->set('amount', 'amount - '.$amt, FALSE);
		$this->db->update('loan_expected_payments');
		
		$this->db->where('id', $loan_id);
		$this->db->set('loan_balance_amount', 'loan_balance_amount - '.$amt, FALSE);
		$this->db->set('total_interest_amount', 'total_interest_amount - '.$amt, FALSE);
		$this->db->set('loan_amount_payable', 'loan_amount_payable - '.$amt, FALSE);
		$this->db->update('loans');
	 }
	 
	 
	 public function penalization($type,$loan_id){
	 	$this->db->where('loan', $loan_id);
		$this->db->where('paid', 0);
		$this->db->set('penalizable', $type, FALSE);
		$this->db->update('loan_expected_payments');
	 }
	 
	 
	 public function get_filtered_loans($start_date,$end_date,$status,$per_page){ return 0;
	 	$this->db->select("*");
		if($status == -1){
			$this->db->where("request_status = 2 AND loan_issue_date >= '".$start_date."' AND loan_issue_date <= '".$end_date."'");
		}
		else{
			$this->db->where("request_status = 2 AND loan_issue_date >= '".$start_date."' AND loan_issue_date <= '".$end_date."' AND loan_status = ".$status);
		}
		$this->db->limit(20, $per_page);
		$query = $this->db->get("loans");
		if($query->num_rows() > 0){ 
			return $query->result_array();
		}
		
		return 0;
	 }
	 
	 public function get_customer($id)
	{
		$this->db->select('name,other_names');
		$this->db->where('id', $id);
		$query_id = $this->db->get('customers');
		$id_array = $query_id->row_array();
		$name = $id_array['name'];
		$other_names = $id_array['other_names'];
		return $name." ".$other_names;
	}
	 
	 public function get_loan_product($id)
	{
		$this->db->select('loan_product_name');
		$this->db->where('id', $id);
		$query_id = $this->db->get('loan_products');
		$id_array = $query_id->row_array();
		$id = $id_array['loan_product_name'];
		return $id;
	}

    public function getTransactionFee(){


           $trans_fee = 0;

           $trans_fee += $this->loan_product->transaction_fee_exact;
           
           $exact_fee = $trans_fee;

           if($this->loan_product->transaction_fee_interms ){

                     $trans_fee = ($this->loan_product->transaction_fee_percent / 100);

                     switch($this->loan_product->transaction_fee_interms){

                             case 'principle'   : $trans_fee =  $trans_fee * $this->loan_principle_amount; break;

                             case 'installment_amount'  : $trans_fee =  ($trans_fee * ($this->installment_amount + $this->installment_interest)); break;

                             case 'loan_total'      : $trans_fee = $trans_fee * $this->loan_amount_payable;  break;

                             case 'interest_amount' : $trans_fee = $trans_fee * $this->installment_interest;   break;

                             case 'loan_balance'    : $trans_fee = $trans_fee * $this->loan_balance_amount;  break;

                             case 'loan_maximum_loaned': $trans_fee = $trans_fee * $this->loan_product->maximum_amount_loaned; break;

                             case 'loan_minimum_loaned' : $trans_fee = $trans_fee * $this->loan_product->minimum_amount_loaned; break;

                             default:break;

                     }


                     if($exact_fee > $trans_fee) $trans_fee = $exact_fee;

           }


           return $trans_fee;

    }


    public function getReschedulementFee(){

           $trans_fee = 0;

           $trans_fee += $this->loan_product->reschedulement_fee_exact;

           $exact_fee = $trans_fee;

           if($this->loan_product->reschedulement_fee_interms){

                     $trans_fee = ($this->loan_product->reschedulement_fee_percent / 100);

                     switch($this->loan_product->reschedulement_fee_interms){

                             case 'principle'   : $trans_fee =  $trans_fee * $this->loan_principle_amount; break;

                             case 'installment_amount'  : $trans_fee =  ($trans_fee * ($this->installment_amount + $this->installment_interest)); break;

                             case 'loan_total'      : $trans_fee = $trans_fee * $this->loan_amount_payable;  break;

                             case 'interest_amount' : $trans_fee = $trans_fee * $this->installment_interest;   break;

                             case 'loan_balance'    : $trans_fee = $trans_fee * $this->loan_balance_amount;  break;

                             case 'loan_maximum_loaned': $trans_fee = $trans_fee * $this->loan_product->maximum_amount_loaned; break;

                             case 'loan_minimum_loaned' : $trans_fee = $trans_fee * $this->loan_product->minimum_amount_loaned; break;

                             default:break;

                     }

                     if($exact_fee > $trans_fee) $trans_fee = $exact_fee;

           }


           return $trans_fee;


		

    }


    public function getLatePaymentFee(){

		   $late_fee = 0;

           $late_fee += $this->loan_product->late_payment_fee_exact;

           $exact_fee = $late_fee;
		   
			if($this->loan_product->late_payment_fee_interms){

				 $trans_fee = ($this->loan_product->late_payment_fee_percent / 100);

				 switch($this->loan_product->late_payment_fee_interms){

						 case 'principle'   : $late_fee =  $late_fee * $this->loan_principle_amount; break;

						 case 'installment_amount'  : $late_fee =  ($late_fee * ($this->installment_amount + $this->installment_interest)); break;

						 case 'loan_total'      : $late_fee = $late_fee * $this->loan_amount_payable;  break;

						 case 'interest_amount' : $late_fee = $late_fee * $this->installment_interest;   break;

						 case 'loan_balance'    : $late_fee = $late_fee * $this->loan_balance_amount;  break;

						 case 'loan_maximum_loaned': $late_fee = $late_fee * $this->loan_product->maximum_amount_loaned; break;

						 case 'loan_minimum_loaned' : $late_fee = $late_fee * $this->loan_product->minimum_amount_loaned; break;

						 default:break;

				 }

				 if($exact_fee > $late_fee) $late_fee = $exact_fee;

           }


           return $late_fee;


    }


    public function getServiceFee(){

           $trans_fee = 0;

           $trans_fee += $this->loan_product->loan_service_fee_exact;

           $exact_fee = $trans_fee;

           if($this->loan_product->loan_service_fee_interms){

                     $trans_fee = ($this->loan_product->loan_service_fee_percent / 100);

                     switch($this->loan_product->loan_service_fee_interms){

                             case 'principle'   : $trans_fee =  $trans_fee * $this->loan_principle_amount; break;

                             case 'installment_amount'  : $trans_fee =  ($trans_fee * ($this->installment_amount + $this->installment_interest)); break;

                             case 'loan_total'      : $trans_fee = $trans_fee * $this->loan_amount_payable;  break;

                             case 'interest_amount' : $trans_fee = ($trans_fee * ($this->getInstallmentArrears()));   break;

                             case 'loan_balance'    : $trans_fee = ($trans_fee * ($this->getLoanBalance()));  break;

                             case 'loan_maximum_loaned': $trans_fee = $trans_fee * $this->loan_product->maximum_amount_loaned; break;

                             case 'loan_minimum_loaned' : $trans_fee = $trans_fee * $this->loan_product->minimum_amount_loaned; break;

                             default:break;

                     }

                     if($exact_fee > $trans_fee) $trans_fee = $exact_fee;

           }


           return $trans_fee;

    }
	
	public function getInterestCharge(){
	
	     $charge_frequency = strtolower($this->loan_product->interest_fee_frequency);
			 
			 $interest_charge  = 0;
			 
			 if($charge_frequency && $charge_frequency != '' && $charge_frequency != 'none' && $this->loan_product->interest_fee_percentage > 0){
			 
  					 $days = 0;
  					 
  					 switch($charge_frequency){
  					  
  								case 'monthly':$days = 31;break;
  								
  								case 'annually':$days= 365;break;
  								
  								case 'weekly':$days=7; break;
  								
  								case 'per-two-months': $days = 63; break;
  								
  								case 'per-three-months':$days=93;break;
  								
  								case 'quartely':$days=124;break;
  								
  								case 'per-five-months':$days = 155;break;
  								
  								case 'twice-annually':$days=186;break;
  								
  								case 'per-seven-months':$days = 217;break;
  								
  								case 'per-eight-months':$days = 248;break;
  								
  								case 'per-nine-months':$days = 279;break;
  								
  								case 'per-ten-months':$days = 310;break;
  								
  								case 'per-elleven-months':$days = 341;break;
  								
  								default:break;
  					 }
					 
					   $interest_charge = round(($this->getLoanBalance() * ($this->loan_product->interest_fee_percentage/100) * (ceil($days/31))),2);

		    }
		 
		    return $interest_charge;

    }


    public function getLoanBalance(){

        $this->load->model('charge_model','lcharge');

        $charges = $this->lcharge->findBy(array('loan'=>$this->id));

        $balance = $this->loan_balance_amount;

        foreach ($charges->result('charge_model') as $charges) {

              $balance += $charges->balance;

        }

        return $balance;

    }
	
	public function get_balance_due($loan_id){
		$balance = 0;
		$this->load->model('expectedpayment_model','expected');

        $prin_ints = $this->expected->findBy(array('loan'=>$loan_id));

        foreach ($prin_ints->result('expectedpayment_model') as $prin_int) {

              $balance += $prin_int->balance + $prin_int->interest_amount_balance;

        }

        $this->load->model('charge_model','lcharge');

        $charges = $this->lcharge->findBy(array('loan'=>$loan_id));

        foreach ($charges->result('charge_model') as $charges) {

              $balance += $charges->balance;

        }

        return $balance;

    }



    public function getInstallmentArrears(){

        $this->load->model('charge_model','lcharge');

        $this->load->model('expectedpayment_model','expayment');

        $charges  = $this->lcharge->findBy(array('loan'=>$this->id));

        $payments = $this->expayment->findBy(array('loan'=>$this->id));

        $balance  = 0;

        foreach ($charges->result('charge_model') as $charges) {

              $balance += $charges->balance;

        }

        foreach ($payments->result('expectedpayment_model') as $payment) {

              $ptimestamp = date_create($payment->date_expected)->getTimestamp();

              $ctimestamp = time();

              if($ctimestamp > $ptimestamp) $balance += $payment->balance;

        }

        return $balance;

    }
	
	public function get_clients_by_criteria($criteria)
	{
		$this->db->select("id,name,other_names,idnumber,profilepic");
		$this->db->where("(name LIKE '%$criteria%' OR other_names LIKE '%$criteria%' OR idnumber LIKE '%$criteria%' OR mobiletel LIKE '%$criteria%') AND status = 1");
		$query = $this->db->get("customers");
		if($query->num_rows() > 0){ 
			return $query->result_array();
		}
		
		return 0;			
	}
	
	public function get_loans_by_client($cust_id){
		$this->db->select("profilepic");
		$this->db->where("id = ".$cust_id);
		$query = $this->db->get("customers");
		$profile_pic_array = $query->row_array();
		$profile_pic = $profile_pic_array['profilepic'];
		$result = $profile_pic."~";
		
		$this->db->select("id,loan_product");
		$this->db->where("customer = ".$cust_id." AND request_status = 2 AND loan_status = 0");
		$query = $this->db->get("loans");
		$loan_product_array = $query->result_array();
		$count = 0;
		foreach($loan_product_array as $loan_product_id){
			$this->db->select("loan_product_name");
			$this->db->where("id = ".$loan_product_id['loan_product']);
			$query = $this->db->get("loan_products");
			$arr = $query->row_array();
			if(0 == $count){
				$result .= $loan_product_id['id']."*".$arr['loan_product_name'];
			}
			else{
				$result .= "^".$loan_product_id['id']."*".$arr['loan_product_name'];
			}
			$count++;
		}
		echo $result;
	}
	
	public function get_loan_details($loan_id){
		$this->db->select("amount, balance, interest_amount, interest_amount_balance, date_expected");
		$this->db->where("loan = ".$loan_id." AND paid = 0");
		$query = $this->db->get("loan_expected_payments");
		$payments = $query->result_array();
		$count = 0;
		$result = "";
		foreach($payments as $payment){
			if(0 == $count){
				$result = $payment["amount"]."*".$payment["balance"]."*".$payment["interest_amount"]."*".$payment["interest_amount_balance"]."*".$payment["date_expected"];
			}
			else{
				$result .= "^".$payment["amount"]."*".$payment["balance"]."*".$payment["interest_amount"]."*".$payment["interest_amount_balance"]."*".$payment["date_expected"];
			}
			$count++;
		}
		
		$this->db->select("name, date, amount, balance");
		$this->db->where("loan = ".$loan_id." AND paid = 0");
		$query = $this->db->get("loan_charges");
		$charges = $query->result_array();
		$count1 = 0;
		foreach($charges as $charge){
			if(0 == $count1){
				$result .= "~".$charge["name"]."*".$charge["date"]."*".$charge["amount"]."*".$charge["balance"];
			}
			else{
				$result .= "^".$charge["name"]."*".$charge["date"]."*".$charge["amount"]."*".$charge["balance"];
			}
			$count1++;
		}
		echo $result;
	}
	
	public function get_charge($loan_id,$charge_name, $datelike)
	{ 
		$this->db->select("id");
		$this->db->where("loan = $loan_id AND name = '$charge_name' AND date_time LIKE 'datelike%'");
		$query = $this->db->get("loan_charges");
		if($query->num_rows() > 0){ 
			return true;
		}
		
		return false;			
	}
	
	public function get_loan_transaction_code($loan_id)
	{ 
		$this->db->select("transaction_code");
		$this->db->where("id = $loan_id");
		$query = $this->db->get("loans");
		$row = $query->row_array();
		return $row['transaction_code'];			
	}

	public function insert_charge_fee($transaction_code,$name,$loan_id,$amount){
		$data = array(
			'transaction_code' => $transaction_code,
			'name' => $name,
			'loan' => $loan_id,
			'date' => date('Y-m-d'),
			'amount' => $amount,
			'balance' => $amount
		);
		$this->db->insert('loan_charges', $data);
		$id = $this->db->insert_id();
		if($id < 1){
			return false;
		}
		return true;
	}
}
