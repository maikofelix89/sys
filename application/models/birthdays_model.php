<?php
class Birthdays_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_customers()
	{
		$datelike = '%'.date('m-d'); //echo $datelike;
		$this->db->select("name, mobiletel");
		$this->db->where("dateOfBirth LIKE '".$datelike."'");
		$query = $this->db->get("customers");
		return $query->result_array();
	}
	
	public function get_guarantors()
	{
		$datelike = '%'.date('m-d');
		$this->db->select("name, mobile");
		$this->db->where("dateOfBirth LIKE '".$datelike."'");
		$query = $this->db->get("loan_gaurantors");
		return $query->result_array();
	}
}