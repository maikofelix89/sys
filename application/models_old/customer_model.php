<?php
	class Customer_model extends CI_Model{
	   public $name;
       public $employer_name;
       public $officephysicallocation;
       public $officetel;
       public $dateemployed;
       public $currentposition;
       public $nameofbusiness;
       public $physicalbusinessaddress;
       public $industry;
       public $other_names;
       public $idnumber;
       public $area;
       public $estate;
       public $road_street;
       public $houseno;
       public $pobox;
       public $status;
       public $postalcode;
       public $town;
       public $mobiletel;
       public $email;
       public $password;
       public $profilepic;
       public $member_id;
       public $loyaltypoints;
	   public $dateOfBirth;
       protected $modelTable  = "customers";
	   
	   public function __construct(array $data = null){
		   parent::__construct($data);
		   $this->errors = array(
					 'id'=>'',
                     'name'=>'',
                     'employer_name'=>'',
                     'officephysicallocation'=>'',
                     'officetel'=>'',
                     'dateemployed'=>'',
                     'currentposition'=>'',
                     'nameofbusiness'=>'',
                     'physicalbusinessaddress'=>'',
                     'industry'=>'',
                     'other_names'=>'',
                     'idnumber'=>'',
                     'area'=>'',
                     'estate'=>'',
                     'road_street'=>'',
                     'houseno'=>'',
                     'pobox'=>'',
                     'status'=>'',
                     'postalcode'=>'',
                     'town'=>'',
                     'mobiletel'=>'',
                     'email'=>'',
                     'password'=>'',
                     'profilepic'=>'',
                     'member_id'=>'',
					 'loyaltypoints'=>'',
					 'dateOfBirth'=>'',
              );
		  
	   }
	   
	   public function rules(){
	      return array(
					  'id'=>array(),
            'name'=>array('required'=>true),
            'employer_name'=>array(),
            'officephysicallocation'=>array(),
            'officetel'=>array(),
            'dateemployed'=>array(),
            'currentposition'=>array(),
            'nameofbusiness'=>array(),
            'physicalbusinessaddress'=>array(),
            'industry'=>array(),
            'other_names'=>array('required'=>true,'alphabet'=>true),
            'idnumber'=>array('required'=>true,'unique'=>true),
            'area'=>array(),
            'estate'=>array(),
            'road_street'=>array(),
            'houseno'=>array(),
            'pobox'=>array(),
            'status'=>array(),
            'postalcode'=>array(),
            'town'=>array(),
            'mobiletel'=>array('required'=>true,'unique'=>true,'numeric'=>true),
            'email'=>array('required'=>true,'email'=>true,'unique'=>true),
            'password'=>array(),
            'profilepic'=>array(),
            'member_id'=>array(),
			'loyaltypoints'=>array(),
            'dateOfBirth'=>array(),
         );
	   }
	   
	   public function get_today_birthdays(){
			$datelike = '%'.date('m-d'); //echo $datelike;
			$this->db->select("id,name,other_names,mobiletel,email,dateOfBirth");
			$this->db->where("dateOfBirth LIKE '".$datelike."'");
			$this->db->order_by("name", "asc");
			$this->db->order_by("other_names", "asc");
			$query = $this->db->get("customers");
			return $query->result_array();
	   }
	   
	    public function get_upcoming_birthdays($day = 1){
			$datelike = '%'.date("m-d", strtotime("+ ".$day." day")); 
			$this->db->select("id,name,other_names,mobiletel,email,dateOfBirth");
			$this->db->where("dateOfBirth LIKE '".$datelike."'");
			$this->db->order_by("name", "asc");
			$this->db->order_by("other_names", "asc");
			$query = $this->db->get("customers");
			return $query->result_array();
	   }

	}