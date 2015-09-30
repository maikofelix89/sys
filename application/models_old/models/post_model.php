<?php
	class Post_model extends CI_Model{
	   public $user;
       public $post;
       public $time;
       public $exclude;
       protected $modelTable  = "mombo_posts";
	   
	   public function __construct(array $data = null){
		   parent::__construct($data);
		   $this->errors = array(
					 'id'=>'',
                     'user'=>'',
                     'post'=>'',
                     'time'=>'',
                     'exclude'=>'',
              );
		  
	   }
	   
	   public function rules(){
	      return array(
					  'id'=>array(),
                      'user'=>array(),
                      'post'=>array(),
                      'time'=>array(),
                      'exclude'=>array(),
              );
	   }

	}
