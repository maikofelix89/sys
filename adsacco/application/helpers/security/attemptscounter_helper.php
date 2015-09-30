<?php
	function init_attempts_counter($max_attempts = 5){
		$CI =& get_instance();
		$att = $CI->session->userdata('lg_attempts');
		$CI->session->set_userdata('max_lg_attempts',$max_attempts);
		if(!isset($att))
			$CI->session->set_userdata('lg_attempts',0);
	}
	 
	function increment_att_counter(){
		$CI =& get_instance();
		$att = $CI->session->userdata('lg_attempts');
		$att += 1;
		$CI->session->set_userdata('lg_attempts',$att);
	}
	 
	function get_attempts_tried(){
		$CI =& get_instance();
		return $CI->session->userdata('lg_attempts');
	}
	 
	function doubt_used_up(){
		$CI =& get_instance();
		$max = $CI->session->userdata('max_lg_attempts');
		$att = $CI->session->userdata('lg_attempts');
		//echo $att.'>'.$max;
		if($att > $max) return true;
		return false;
	}

	function clear_counter(){
	   $CI =& get_instance();
	   $CI->session->set_userdata('lg_attempts',0);
	}