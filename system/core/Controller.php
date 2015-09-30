<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	private static $instance;
	protected $msg;
	protected $code;
	protected $response = null;
	protected $models   = array();
	protected $helpers  = array();
	protected $accept   = null;
	protected $header = 'layout/header';
    protected $footer = 'layout/footer';

	/**
	 * Constructor
	 */
	public function __construct()
	{
		self::$instance =& $this;
		
		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');

		$this->load->initialize();
		
		log_message('debug', "Controller Class Initialized");
		foreach($this->models as $model=>$class){
			$this->load->model($class,$model);
		}
		$this->load->model('page_model','page');
		$this->accept   = $this->input->get_request_header('Accept',true);
		$this->accept   = $this->accept[0];
		//$this->response = new HTTPResponse();
		//$this->response->setType($this->accept);
	}

	public static function &get_instance(){
		return self::$instance;
	}
	protected function send_jsonheaders(){
	   //Start sending response headers
		header('HTTP/1.1 200 OK');
		header('Content-Type: application/json');
	}
	protected function sendResponse(array $ajdata=null,array $views = null){
	   if($this->input->get('aj')){
	        //content negotiation
	        if(!empty($ajdata)){
			     ob_start();
				 $response = @json_encode($ajdata);
				 $this->send_jsonheaders();
				 echo $response;
				 ob_end_flush();
		    }
		    
	   }else{
	        if(!empty($views)){
			  foreach($views as $view=>$data){
			    $this->load->view($view,$data);
			  }
			}
	   }
	}
}
// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */