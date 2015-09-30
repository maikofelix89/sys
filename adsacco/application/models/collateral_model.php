<?php
	class Collateral_model extends CI_Model{
	   public $loan;
       public $name;
       public $description;
       protected $modelTable  = "collateral";
	   
	   public function __construct(array $data = null){
		   parent::__construct($data);
		   $this->errors = array(
					 'id'=>'',
                     'loan'=>'',
                     'name'=>'',
                     'description'=>'',
              );
		  
	   }
	   
	   public function rules(){
	      return array(
					  'id'=>array(),
                      'loan'=>array(),
                      'name'=>array(),
                      'description'=>array(),
              );
	   }

	}
