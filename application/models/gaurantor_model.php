<?php
	class Gaurantor_model extends CI_Model{
	   public $id;
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
	   public $status;	
       
       protected $modelTable  = "loan_gaurantors";
	   
	   public function __construct(array $data = null){
		   parent::__construct($data);
		   $this->errors = array(
					 'id'=>'',
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
					 'status'=>''
              );
		  
	   }
	   
	   public function rules(){
	      return array(
					  'id'=>array(),
            'name'=>array('required'=>true),
            'other_names'=>array(),
			'email'=>array('required'=>true,'email'=>true,'unique'=>true),
            'mobile'=>array('required'=>true,'unique'=>true,'numeric'=>true),
			'residentialarea'=>array(),
			'estate'=>array(),
			'houseno'=>array(),
			'idnumber'=>array('required'=>true,'unique'=>true),
			'profilepic'=>array(),
			'name_of_business'=>array(),
			'business_tel'=>array(),
			'business_location'=>array(),
			'business_address'=>array(),
			'employer_name'=>array(),
			'employer_tel'=>array(),
			'employer_location'=>array(),
			'dateOfBirth'=>array(),
			'status'=>array()
         );
	   }
	   
	   public function get_guarantors_by_criteria($criteria)
		{
			$this->db->select("id,name,other_names,idnumber,profilepic");
			$this->db->where("(name LIKE '%$criteria%' OR other_names LIKE '%$criteria%' OR idnumber LIKE '%$criteria%' OR mobile LIKE '%$criteria%') AND status = 1");
			$query = $this->db->get("loan_gaurantors");
			if($query->num_rows() > 0){ 
				return $query->result_array();
			}
			
			return 0;			
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