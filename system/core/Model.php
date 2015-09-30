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
 * CodeIgniter Model Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/config.html
 */
class CI_Model {
		 public $id;
		 protected $modelTable;
		 protected $isClean = true;
		 protected $isUpdating = false;
		 protected $errors  = array();
		/**
		 * Constructor
		 *
		 * @access public
		 */
		public function __construct(array $data = null)
		{
		   if(!empty($data)){
			   foreach($data as $prop=>$val){
				   $this->$prop($val);
			   }
		   }
		  log_message('debug', "Model Class Initialized");
		}
		
	
		public function rules(){
		   return array();
		}
		
		public function relations(){
		   return array();
		}
		
		public function attributes(array $attr = null){
		     if(is_array($attr) && !empty($attr)){
                  foreach($attr as $prop=>$value){
				        $this->$prop = $value;
				  }
             }	 
		}
		
		/**
		 * __get
		 *
		 * Allows models to access CI's loaded classes using the same
		 * syntax as controllers.
		 *
		 * @param	string
		 * @access private
		 */
		function __get($key)
		{
			$CI =& get_instance();
			return $CI->$key;
		}
		

		
		/**
		 *This method returns a string representation of
		 *the current state of the object.
		 *@return string  current state of the object
		*/
	   public function __toString(){
		  return sprintf("%s",var_dump($this));
	   }
	   
	   /**
		*This checks whether a particular method exists in a class
		*@param $method, name of the method
		*@return bool , returns true if class has the method, false otherwise.
		*/
	   public function hasMethod($method){
			$method = trim($method);
			return method_exists($this,$method);
	   }
	  
	  
	   /**
		*This checks whether a particular property exists in a class
		*@param $property, name of the property
		*@return bool , returns true if class has the property, false otherwise.
		*/
	   public function hasProperty($property){
		   $property = trim($property);
		   return property_exists($this,$property);
	   }
	   
	   /**
		*This checks whether a particular class property exists in a class
		*@param $property, name of the property
		*@return bool , returns true if class has the property, false otherwise.
		*/
	   public static function hasClassProperty($property){
		   $property = trim($property);
		   return property_exists(get_called_class(),$property);
	   }
	   
	   /**
		*This checks whether a particular class method exists in a class
		*@param $method, name of the method
		*@return bool , returns true if class has the method, false otherwise.
		*/
	   public static function hasClassMethod($method){
		   $method = trim($method);
		   return method_exists(get_called_class(),$method);
	   }
	   
	   /**
		*This checks whether an object is an instance of class or 
		*has it as one of its parent.
		*Its just a wrapper for PHP's is_a() method 
		*
		*@params $class, Name of the parent class or class 
		*@return bool, true if its an instance and is a member of subclass of the $class, false otherwise
		*/
	   public function is_a($class){
		   $class = trim($class);
		   $yes   = (($this instanceof $class))? true : false;
		   return $yes;
	   }
	   
	   /**
		*This returns an array of methods of this particular class
		*@return $methods, methods defined in the class
		*/
	   public function methods(){
		   $methods = get_class_methods($this);
		   return $methods;
	   }
	   
	   /**
		*This returns an array of public methods of this particular class
		*@return $methods, public methods defined in the class
		*/
	   public function publicMethods(){
	   
	   }
	   
	   /**
		*This returns an array of private methods of this particular class
		*@return $methods, public methods defined in the class
		*/
	   public function privateMethods(){
		 
	   }

		  /**
		*This returns an array of properties of this particular class
		*@return $properties, properties defined in the class
		*/
	   public function properties(){
		   $properties = get_class_vars($this);
		   return $properties;
	   }
	   
	   /**
		*This returns an array of public properties of this particular class
		*@return $properties, public properties defined in the class
		*/
	   public function publicProperties(){
	   
	   }
	   
	   /**
		*This returns an array of private properties of this particular class
		*@return $properties, public propertiess defined in the class
		*/
	   public function privateProperties(){
		 
	   }	
	   
	  /**
	   *Provides access to inaccessible properties
	   *
	   *@param $property String, name of the property
	   *@return mixed, the value referenced by the property
	   *	
	   public function __get($property){
		  $property = ($this->hasProperty($property)) ? $this->$property() : null;
		  return $property;
	   }
		*/
	   /**
	   *Allows changing of inaccessible properties
	   *
	   *@param $property String, name of the property
	   *@param $value Mixed, value of the property
	   */	
	   public function __set($property,$value){
		  if($this->hasProperty($property)){
				$this->$property = $value;
		  }
	   }
	   
	   /**
		*This will allow object properties to be accessed like functions
		*/
	   public function __call($func,$args){
		  if(!empty($args)){
			  if($this->hasProperty($func)){
				 $this->$func= $args[0];
				 return $this;
			  }
		  }else{
			  if($this->hasProperty($func)){
				 return $this->$func;
			  }
		  }
	   }
	   
	   /**
		*This will allow object properties to be accessed like functions
		*/
	   public static function __callStatic($func,$args){
		  if(!empty($args)){
			   if(self::hasClassProperty($func)){
					self::$$func = $args[0];
			   }
		  }else{
			   if(self::hasClassProperty($func)){
					return self::$$func;
			   }
		  }
	   }
	   
	   public function doSQLFunction($function,$field,$args=array()){
	         $function = strtolower(trim($function));
			 $field    = strtolower(trim($field));
			 switch($function){
			     case 'sum':return $this->doSQLSUMOn($field,$args);
			 }
	   }
	   
	   private function doSQLSUMon($field,$args){
	        if(empty($args)){

	        	$records = $this->findAll();

	        }else{

	        	$records = $this->findBy($args);

	        }
			$total   = 0;
			foreach($records->result(get_class($this)) as $record){
			     $value = $record->$field();
				 if(!is_numeric($value)){
				    break;
				 }
				 $total += $value;
			}
			return $total;
	   }
	   
	   public function loadRelations($record){
	   
	       foreach($this->relations() as $relation=>$model){
		          
				 $relmodel = strtolower(get_class($this)).$relation.'_rmodel';
				 
				 if(!empty($model)){
				  
					 $rel_type = (array_key_exists('rel_type',$model)) ? $model['rel_type'] : '';
					 
					 switch(strtolower($rel_type)){
					 
						case 'one-to-many':  
						
							 $this->load->model($model['class'],$relmodel);
							 
							 $record->$relation = $this->$relmodel->findBy(array(
							 
									$model['foreign_key_name'] => $record->$relation(),
									
							   )
							   
							 );
						break;
						
						case 'one-to-one':
						
							 $this->load->model($model['class'],$relmodel);
							 
							 $key = $model['foreign_key_name'];
							 
							 $record->$relation = $this->$relmodel->findBy(array($key => $record->$relation()))->row(0,$model['class']);
							
							 break;
							 
						default:break;
						
					 }
				 }
			}
	   }

	   //Returns results based on arguments.
		public function findBy(array $params,$limit = array(),$orderby = array()){
			$limit_start = null;
			$limit_end   = null;
			$query       = null;
			if(!empty($limt)){
				 $limit_start = $limt[0];
				 $limit_end   = $limt[1];
				 $query = $this->db->get_where($this->modelTable,$params,$limit_end,$limit_start);
			}else{
			
			     if(!empty($orderby)){
				    
					$this->db->order_by($orderby[0],$orderby[1]);
			        $query = $this->db->get_where($this->modelTable,$params);
				
				}else{
				
				    $query = $this->db->get_where($this->modelTable,$params);
				    
				}
			}
			
			foreach($query->result(strtolower(get_class($this))) as $record){
			    $this->loadRelations($record);
			}
			return $query;
		}
		
		//Returns results based on arguments.
		public function findAllLike(array $params,$limit = array(),$orderby = array()){
			$limit_start = null;
			$limit_end   = null;
			$query       = null;
			if(!empty($limt)){
				 $limit_start = $limt[0];
				 $limit_end   = $limt[1];
				 $this->db->or_like($this->modelTable,$params,$limit_end,$limit_start);
				 $query = $this->db->get();
			}else{
			    
				if(!empty($orderby)){
				
				    $this->db->or_like($this->modelTable,$params)->orderby($orderby[0],$orderby[1]);
					
				}else{
			     
				    $this->db->or_like($this->modelTable,$params);
			    }
				 
				 $query = $this->db->get();
			}
			
			foreach($query->result(strtolower(get_class($this))) as $record){
			    $this->loadRelations($record);
			}
			return $query;
		}
        
		
		public function rows(){
		  return $this->db->count_all($this->modelTable);
		}
		
		public function findAll(array $limt = null){
		  $limit_start = null;
		  $limit_end   = null;
		  $query       = null;
		  if(!empty($limt)){
			 $limit_start = $limt[0];
			 $limit_end   = $limt[1];
			 $query  = $this->db->get($this->modelTable,$limit_end,$limit_start);
		  }else{
			 $query  = $this->db->get($this->modelTable);
		  }
		  
		  foreach($query->result(strtolower(get_class($this))) as $record){
		       $this->loadRelations($record);
		  }
		  
		  return $query;
		}
		
		public function findWhere($exp,$value,array $limit = null){
		
		       $this->db->where($exp,$value);
			   
			   $query  = $this->db->get($this->modelTable);
			   
			   $result = $query->result();
			   
			   if(!empty($result)){
			   
				  foreach($query->result(strtolower(get_class($this))) as $record){
				  
					   $this->loadRelations($record);
					   
				  }
				  
				  return $query;
			   }
			   
			   return null;
			   
		}
		
		public function findOne($id){
		
		   $query  = $this->db->get_where($this->modelTable,array('id'=>$id));
		   
		   $result = $query->result();
		 
		   if(!empty($result)){
			  $record = $query->row(0,get_class($this));
              $this->loadRelations($record);
			  return $record;
		   }
		   return null;
		}		
		

		public function save(){
		  if($this->isClean){
			  return $this->db->insert($this->modelTable,$this);
		  }else{
			  return false;
		  }
		}
		
		public function update(){
		  if($this->isClean){
			  return $this->db->update($this->modelTable,$this,array('id'=>$this->id));
		  }else{
			  return false;
		  }
		}
		
		public function delete($id = null){
			if(!empty($id)){
				$this->id = (int) $id;
			}
			
			return $this->db->delete($this->modelTable,array('id'=>$this->id));
		}
		
		public function properror_set($property,$error){
			$this->errors[$property] = $error;
		}
		
		public function dirty(){
			$this->isClean = false;
		}
		
		public function validationerrors(){
		   return $this->errors;
		}
		
		
		public function recordDo($action,$properties,$messages){
			  switch(strotolower($action)){
			       case 'create':
				   case 'add':$this->create($properties,$messages);break;
				   case 'update':$this->doupdate($properties,$messages);break;
			  }
		}
		
		public function create($properties){
		     $this->attributes($properties);
		     $this->validate();
			 if($this->save()){
				  return true;
			 }else{
				  return false;
			 }
		}
		
		public function doupdate($properties){

			 $this->isUpdating = true;
		     $this->attributes($properties);
		     $this->validate();
			 if($this->update()){
				  return true;
			 }else{
				  return false;
			 }
		}

		public function start_transaction($test = false){

			return $this->db->trans_begin($test);
		}


		public function commit_transaction(){

			return $this->db->trans_commit();

		}

		public function rollback_transaction(){

			return $this->db->trans_rollback();
		}


		public function end_transaction(){

			return $this->db->trans_complete();

		}
		
		public function validate(){
			 $rules      = array();
	 
			 $modelrules = $this->rules();
			 
			 if(!empty($modelrules))$rules = $modelrules;
			 foreach($this->errors as $property=>$val){
				   if(array_key_exists($property,$rules)){
				        //echo $property.'<br/>';
						$ruls = $rules[$property];
						foreach($ruls as $rule=>$option){
								$value = $this->$property;
								$rule  = strtolower($rule);
								switch($rule){
									 case 'required'      : $this->required($property,$value);break;
									 case 'unique'        : $this->unique($property,$value);break;
									 case 'email'         : $this->email($property,$value);break;
									 case 'numeric'		  : $this->numeric($property,$value);break;
									 case 'alphanumeric'  : $this->alphanumeric($property,$value);break;
									 case 'alphabet'      : $this->alphabet($property,$value);break;
									 case 'maximumchars'  : $this->maximum_chars($property,$value,$option);break;
									 case 'maximum'       : $this->maximum($property,$value,$option);break;
									 case 'minimum'       : $this->minimum($property,$value,$option);break;
									 case 'range'         : $this->numeric_range($property,$value,$option);break;
								}
				  }
			 }
		}
								}

		public function unique($property,$value){
		  if(!empty($value) && null != $value && isset($value)){
				$record = $this->findBy(array(
				  $property =>$value
				))->row(0,get_class($this)); 
				
				if(null != $record && $record->id != $this->id){
				   $this->dirty();
				   $this->properror_set($property,'This '.ucwords($property).' already exists');
				}
           }
		}
		
		public function email($property,$value){
			if(!empty($value) && null != $value && isset($value)){
				 if(!preg_match('/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD',$value)){
					  $this->dirty();
					  $this->properror_set($property,'Invalid Email ddress');
				 }
			 }
		}
		
		public function numeric($property,$value){
			if(!empty($value) && null != $value && isset($value)){
				 if(!is_numeric($value)){
					 $this->dirty();
					 $this->properror_set($property,'invalid number, numeric only');
				 }
			}
		}
		
		public function alphanumeric($property,$value){
		   if(!empty($value) && null != $value && isset($value)){
			   if(!preg_match('/^[A-Za-z0-9]/',$value)){
				 $this->dirty();
				 $this->properror_set($property,'invalid input,alphanumeric only');
			   }
			}
		}
	  
	    public function alphabet($property,$value){
		   if(!empty($value) && null != $value && isset($value)){
			   if(!preg_match('/^[A-Za-z]/',$value)){
				 $this->dirty();
				 $this->properror_set($property,'invalid input, letters only');
			   }
			}
		}
	  
	    public function maximum_chars($property,$value,$args){
			if(!empty($value) && null != $value && isset($value)){
				 if((strlen($value) > $args)){
					 $this->dirty();
					 $this->properror_set($property,'characters cannot exceed '.$args.' characters');
				 }
			}
		}
	  
	    public function maximum($property,$value,$args){
			if(!empty($value) && null != $value && isset($value)){
				 if(is_numeric($value) && ($value > $args)){
					 $this->dirty();
					 $this->properror_set($property,'number cannot exceed '.$args);
				 }
			}
		}
	  
	    public function minumum($property,$value,$args){
			if(!empty($value) && null != $value && isset($value)){
				 if(is_numeric($value) && $value >= $args){
					 $this->dirty();
					 $this->properror_set($property,'number cannot be below'.$args);
				 }/*elseif(!is_string($value) && strlen($value) >= $args){
					 $model->dirty();
					 $model->properror_set($property,'text cannot be under '.$args.' characters');
				 }*/
			}
		}
	  
		public function numeric_range($property,$value,$args){
			   
		}
	  
		public function required($property,$value){
		   if(!isset($value) || empty($value) || $value ==  ''){
				$this->dirty();
				$this->properror_set($property,'field is required');
		   }
		}


		
		
}
// END Model Class

/* End of file Model.php */
/* Location: ./system/core/Model.php */