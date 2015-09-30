<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// ------------------------------------------------------------------------

/**
 * Check whether user is authenticated
 *
 * @access	public
 * @param	string
 * @param	bool	whether or not the content is an image file
 * @return	string
 */
 
 if(!function_exists('is_logged_in'))    
{
    function is_logged_in()
    {
	    $CI =& get_instance();
	    $is_logged_in = $CI->session->userdata('user_id');
	    if(!isset($is_logged_in) || $is_logged_in != true)
	    {
	       redirect(base_url().'admin_login');    
	    }  
    }
}

/* End of file security_helper.php */
/* Location: ./application/helpers/login_helper.php */