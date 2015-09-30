<?php
	class Systemoption_model extends CI_Model{
	   public $name;
       public $value;
       protected $modelTable  = "system_options";
	   
	   public function __construct(array $data = null){
		   parent::__construct($data);
		   $this->errors = array(
					 'id'=>'',
                     'name'=>'',
                     'value'=>'',
              );
		  
	   }
	   
	   public function rules(){
	      return array(
					  'id'=>array(),
                      'name'=>array(),
                      'value'=>array(),
              );
	   }

	}
