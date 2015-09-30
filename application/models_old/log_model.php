<?php if(!defined('BASEPATH')) exit("Access Denied");

class Log_model extends CI_Model{
   public $type;
   public $meta;
   protected $modelTable = 'mombo_logs';
   public function __construct(array $log = null){
	   parent::__construct();
   }
}
