<?php
	class User_model extends CI_Model{
	   public $user_fullname;
       public $user_email;
       public $user_password;
       public $user_phone;
       public $user_type;
       public $user_status;
       public $user_photo;
       public $user_description;
       protected $modelTable  = "users";
	   
	   public function __construct(array $data = null){
		   parent::__construct($data);
		   $this->errors = array(
					 'id'=>'',
                     'user_fullname'=>'',
                     'user_email'=>'',
                     'user_password'=>'',
                     'user_phone'=>'',
                     'user_type'=>'',
                     'user_status'=>'',
                     'user_photo'=>'',
                     'user_description'=>'',
              );
		  
	   }
	   
	   public function rules(){
	      return array(
					  'id'=>array(),
                      'user_fullname'=>array(),
                      'user_email'=>array(),
                      'user_password'=>array(),
                      'user_phone'=>array(),
                      'user_type'=>array(),
                      'user_status'=>array(),
                      'user_photo'=>array(),
                      'user_description'=>array(),
              );
	   }

	}
