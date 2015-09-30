<?php
	class Transfers_model extends CI_Model{
	   public $id;
	   public $from_account_id;
       public $to_account_string;
       public $amount;
       public $reference_number;
	   public $description;
       public $date;
	   public $parent_id;
	   public $date_submitted;
	   //public $date_modified;
	   public $approved;
       protected $modelTable  = "t_finance_transfers";
	   
	   public function __construct(array $data = null){
		   parent::__construct($data);
		   $this->errors = array(
					 'id'=>'',
                     'from_account_id'=>'',
                     'to_account_string'=>'',
                     'amount'=>'',
                     'reference_number'=>'',
                     'description'=>'',
					 'date'=>'',
					 'parent_id'=>'',
                     'date_submitted'=>'',
                     'approved'=>'',
			);
		  
	   }
	   
	   public function rules(){
	   
			  return array(
			  
					  'id'=>array(),
					  
					  'amount'=>array(
					  
							'required' => true,
							
					   ),
					  
				);
	   }
	   
	   public function get_filtered_transfers($start,$end,$status)
		{
			$i = 0;
			$details = array();
			$this->db->select("*");
			$this->db->where("approved = ".$status." AND date >= '".$start."' AND date <= '".$end."'");
			$this->db->order_by("id","desc");
			$query = $this->db->get("t_finance_transfers");
			$filtered_array = $query->result_array();
			foreach($filtered_array as $filtered){
				$to_account_string = $filtered['to_account_string'];
				$to_account_array = explode("*",$to_account_string);
				if($to_account_array[0] == 'p'){
					$this->db->select("account_name");
					$this->db->where("id = ".$to_account_array[1]);
					$query_account = $this->db->get("accounts");
					$to_account_name_array = $query_account->row_array();
					$to_account_name = $to_account_name_array["account_name"];
				}else{
					$this->db->select("account_name");
					$this->db->where("id = ".$to_account_array[1]);
					$query_sub_account = $this->db->get("t_sub_accounts");
					$to_account_name_array = $query_sub_account->row_array();
					$to_account_name = $to_account_name_array["account_name"];
				}
				
				if($filtered['parent_id'] == 0){
					$this->db->select("account_name");
					$this->db->where("id = ".$filtered['from_account_id']);
					$query_account = $this->db->get("accounts");
					$from_account_name_array = $query_account->row_array();
					$from_account_name = $from_account_name_array["account_name"];
				}
				else{
					$this->db->select("account_name");
					$this->db->where("id = ".$filtered['from_account_id']);
					$query_account = $this->db->get("t_sub_accounts");
					$from_account_name_array = $query_account->row_array();
					$from_account_name = $from_account_name_array["account_name"];
				}
											
				$details[$i] = $from_account_name.'^'.$to_account_name.'^'.$filtered['from_account_id'].'^'.$filtered['to_account_string'].'^'.$filtered['amount'].'^'.$filtered['reference_number'].'^'.$filtered['description'].'^'.$filtered['date'].'^'.$filtered['parent_id'].'^'.$filtered['date_submitted'].'^'.$filtered['id'];
				$i++;
			}
			return $details;
		}
	   
	   	public function get_transfers($status)
		{
			$i = 0;
			$details = array();
			$this->db->select("*");
			$this->db->where("approved = ".$status);
			$this->db->order_by("id","desc");
			$query = $this->db->get("t_finance_transfers");
			$all_array = $query->result_array();
			foreach($all_array as $all){
				$to_account_string = $all['to_account_string'];
				$to_account_array = explode("*",$to_account_string);
				if($to_account_array[0] == 'p'){
					$this->db->select("account_name");
					$this->db->where("id = ".$to_account_array[1]);
					$query_account = $this->db->get("accounts");
					$to_account_name_array = $query_account->row_array();
					$to_account_name = $to_account_name_array["account_name"];
				}else{
					$this->db->select("account_name");
					$this->db->where("id = ".$to_account_array[1]);
					$query_sub_account = $this->db->get("t_sub_accounts");
					$to_account_name_array = $query_sub_account->row_array();
					$to_account_name = $to_account_name_array["account_name"];
				}
				
				if($all['parent_id'] == 0){
					$this->db->select("account_name");
					$this->db->where("id = ".$all['from_account_id']);
					$query_account = $this->db->get("accounts");
					$from_account_name_array = $query_account->row_array();
					$from_account_name = $from_account_name_array["account_name"];
				}
				else{
					$this->db->select("account_name");
					$this->db->where("id = ".$all['from_account_id']);
					$query_account = $this->db->get("t_sub_accounts");
					$from_account_name_array = $query_account->row_array();
					$from_account_name = $from_account_name_array["account_name"];
				}
											
				$details[$i] = $from_account_name.'^'.$to_account_name.'^'.$all['from_account_id'].'^'.$all['to_account_string'].'^'.$all['amount'].'^'.$all['reference_number'].'^'.$all['description'].'^'.$all['date'].'^'.$all['parent_id'].'^'.$all['date_submitted'].'^'.$all['id'];
				
				$i++;
			}
			return $details;
		}
		
		public function update_status($id,$approve){
			$data = array(
               'approved' => $approve
            );

			$this->db->where('id', $id);
			return $this->db->update('t_finance_transfers', $data); 
		}
	   
	}