<?php
	class Comment_model extends CI_Model{
	   public $user;
       public $post;
       public $comment;
       public $time;
       public $exclude;
       protected $modelTable  = "mombo_comments";
	   
	   public function __construct(array $data = null){
		   parent::__construct($data);
		   $this->errors = array(
					 'id'=>'',
                     'user'=>'',
                     'post'=>'',
                     'comment'=>'',
                     'time'=>'',
                     'exclude'=>'',
              );
		  
	   }
	   
	   public function rules(){
	      return array(
					  'id'=>array(),
                      'user'=>array(),
                      'post'=>array(),
                      'comment'=>array(),
                      'time'=>array(),
                      'exclude'=>array(),
              );
	   }

	}
