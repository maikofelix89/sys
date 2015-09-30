<?php
	class Loanpurpose_model extends CI_Model{
	   public $purpose_name;
       protected $modelTable  = "loanpurpose";
	   
	   public function __construct(array $data = null){
		   parent::__construct($data);
		   $this->errors = array(
					 'id'=>'',
                     'purpose_name'=>'',
              );
		  
	   }
	   
	   public function rules(){
	      return array(
					  'id'=>array(),
                      'purpose_name'=>array(),
              );
	   }

	}
