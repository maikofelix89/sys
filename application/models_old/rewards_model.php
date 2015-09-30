<?php
class Rewards_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_redeemed_rewards($is_settled = 0){
		$this->db->select("id,cust_id,reward_id,producer,date_created,date_processed");
		$this->db->where("used = ".$is_settled);
		$this->db->order_by("id", "desc");
		$query = $this->db->get("t_cust_rewards");
		$redeemed_rewards = $query->result_array();
		$count = 0;
		foreach($redeemed_rewards as $redeemed_reward){
			$redeemed_id = $redeemed_reward['id'];
			$cust_id = $redeemed_reward['cust_id'];
			$reward_id = $redeemed_reward['reward_id'];
			$producer = $redeemed_reward['producer'];
			$date_submitted = $redeemed_reward['date_created'];
			$date_settled = $redeemed_reward['date_processed'];
			
			$this->db->select("name, other_names,mobiletel");
			$this->db->where("id = ".$cust_id);
			$query = $this->db->get("customers");
			$customer = $query->row_array();
			$customer_name = $customer['name']." ".$customer['other_names'];
			$customer_fname = $customer['name'];
			$customer_phone = $customer['mobiletel'];
			
			$this->db->select("point_id, value, type");
			$this->db->where("id = ".$reward_id);
			$query = $this->db->get("t_rewards");
			$reward_params = $query->row_array();
			$point_id = $reward_params['point_id'];
			$value = $reward_params['value'];
			$type_id = $reward_params['type'];
			
			$this->db->select("points");
			$this->db->where("id = ".$point_id);
			$query = $this->db->get("t_points");
			$points_array = $query->row_array();
			$points = $points_array['points'];
			
			$this->db->select("name");
			$this->db->where("id = ".$type_id);
			$query = $this->db->get("t_reward_types");
			$points_array = $query->row_array();
			$reward_type = $points_array['name'];
			
			if(0 == $count){				
				$result = $cust_id."*".$customer_name."*".$points."*".$type_id."*".$reward_type."*".$value."*".$date_submitted."*".$date_settled."*".$redeemed_id."*".$producer."*".$customer_phone."*".$customer_fname;
			}
			else{
				$result .= "^".$cust_id."*".$customer_name."*".$points."*".$type_id."*".$reward_type."*".$value."*".$date_submitted."*".$date_settled."*".$redeemed_id."*".$producer."*".$customer_phone."*".$customer_fname;
			}
			$count++;
			//echo $producer; exit;
		}
		
		if(0 != $count){
			return $result;
		}
		else{
			return 0;
		}
	}
	
	public function get_redeemed_discount_reward($cust_id){
		$this->db->select("id,reward_id");
		$this->db->where("cust_id = ".$cust_id." AND used = 0");
		$query = $this->db->get("t_cust_rewards");
		$redeemed_rewards = $query->result_array();
		$count = 0;
		foreach($redeemed_rewards as $redeemed_reward){
			$redeemed_id = $redeemed_reward['id'];
			$reward_id = $redeemed_reward['reward_id'];
			
			$this->db->select("point_id, value, type");
			$this->db->where("id = ".$reward_id);
			$query = $this->db->get("t_rewards");
			$reward_params = $query->row_array();
			$point_id = $reward_params['point_id'];
			$value = $reward_params['value'];
			$type_id = $reward_params['type'];
			
			$this->db->select("name");
			$this->db->where("id = ".$type_id);
			$query = $this->db->get("t_reward_types");
			$points_array = $query->row_array();
			$reward_type = $points_array['name'];
			
			if($reward_type != 'Percentage Discount on Loan Interest'){
				continue;
			}
			
			if(0 == $count){				
				$result = $value."*".$redeemed_id;
			}
			else{
				$result .= "^".$value."*".$redeemed_id;
			}
			$count++;
		}
		
		if(0 != $count){
			return $result;
		}
		else{
			return 0;
		}
	}

	public function settle_reward($id,$date)
	{
		$data = array(
			'used' => 1,
			'date_processed' => $date
		);
		
		$this->db->where('id', $id);
		$this->db->where('used', 0);
		$this->db->update('t_cust_rewards', $data);
		
		return $this->db->affected_rows();
	}
	
	public function settle_rewards($ids,$loan_id)
	{
		$date = date('Y-m-d H:i:s');
		$data = array(
			'used' => 1,
			'date_processed' => $date,
			'loan_id' => $loan_id
		);
		for($i = 0; $i < count($ids); $i++){ 
			$this->db->where('id', $ids[$i]);
			$this->db->update('t_cust_rewards', $data);
		}
			
		return $this->db->affected_rows();
	}
	
	public function get_account_string($name)
	{
		$this->db->select('id,parent_id');
		$this->db->where('account_name',$name);
		$query = $this->db->get('t_sub_accounts');
		$result = $query->row_array();
		return 'c*'.$result['id'].'*'.$result['parent_id'];
		
	}
	
	public function get_cust_id($redeemed_id)
	{
		$this->db->select('cust_id');
		$this->db->where('id',$redeemed_id);
		$query = $this->db->get('t_cust_rewards');
		$result = $query->row_array();
		return $result['cust_id'];
		
	}
	
	public function get_cust_details($cust_id)
	{
		$this->db->select('mobiletel,email');
		$this->db->where('id',$cust_id);
		$query = $this->db->get('customers');
		$result = $query->row_array();
		return $result;
		
	}
	
}