<?php
	class Sms_model extends CI_Model{
	   public $message;
       public $date;
       public $too;
      protected $modelTable  = "sms_outbox";
	   
	   public function __construct(array $data = null){
		   parent::__construct($data);
		   $this->errors = array(
					 'id'=>'',
                     'message'=>'',
                     'date'=>'',
                     'too'=>'',
              );
		  
	   }
	   
	   public function rules(){
	      return array(
					  'id'=>array(),
                      'message'=>array(),
                      'date'=>array(),
                      'too'=>array(),
              );
	   }
	   
	   public function getAll(){
	   		$this->db->select('*');
			$this->db->order_by("id", "desc");
			$this->db->limit(200);
			$query = $this->db->get('sms_outbox');
			if($query->num_rows() > 0){
				return $query->result_array();
			}
			return 0;
	   }

	}