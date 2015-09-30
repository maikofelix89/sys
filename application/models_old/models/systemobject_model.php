<?php
	class Systemobject_model extends CI_Model{
	   public $name;
       protected $modelTable  = "system_objects";
	   
	   public function __construct(array $data = null){
		   parent::__construct($data);
		   $this->errors = array(
					 'id'=>'',
                     'name'=>'',
              );
		  
	   }
	   
	   public function rules(){
	      return array(
					  'id'=>array(),
                      'name'=>array(),
              );
	   }

	}
