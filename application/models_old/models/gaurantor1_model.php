<?php
	class Gaurantor_model extends CI_Model{
	   public $loan;
       public $name;
       public $other_names;
       public $email;
       public $mobile;
       public $residentialarea;
       public $estate;
       public $houseno;
       public $idnumber;
       public $profilepic;
       public $name_of_business;
       public $business_tel;
       public $business_location;
       public $business_address;
       public $employer_name;
       public $employer_tel;
       public $employer_location;
	   public $dateOfBirth;
       protected $modelTable  = "loan_gaurantors";
	   
	   public function __construct(array $data = null){
		   parent::__construct($data);
		   $this->errors = array(
					 'id'=>'',
                     'loan'=>'',
                     'name'=>'',
                     'other_names'=>'',
                     'email'=>'',
                     'mobile'=>'',
                     'residentialarea'=>'',
                     'estate'=>'',
                     'houseno'=>'',
                     'idnumber'=>'',
                     'profilepic'=>'',
                     'name_of_business'=>'',
                     'business_tel'=>'',
                     'business_location'=>'',
                     'business_address'=>'',
                     'employer_name'=>'',
                     'employer_tel'=>'',
                     'employer_location'=>'',
					 'dateOfBirth'=>'',
              );
		  
	   }
	   
	   public function rules(){
	      return array(
					  'id'=>array(),
                      'loan'=>array(),
                      'name'=>array(),
                      'other_names'=>array(),
                      'email'=>array(),
                      'mobile'=>array(),
                      'residentialarea'=>array(),
                      'estate'=>array(),
                      'houseno'=>array(),
                      'idnumber'=>array(),
                      'profilepic'=>array(),
                      'name_of_business'=>array(),
                      'business_tel'=>array(),
                      'business_location'=>array(),
                      'business_address'=>array(),
                      'employer_name'=>array(),
                      'employer_tel'=>array(),
                      'employer_location'=>array(),
					  'dateOfBirth'=>array(),
              );
	   }

	}
