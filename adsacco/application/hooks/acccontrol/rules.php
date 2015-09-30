<?php
   return array(
       'system'=>array(
	      'controllers'=>array(
		      'welcome'=>array(
                  'a_level'=>array(
				      'index'=>array(
					      'guests'
					  ),
					  'login'=>array(
					      'guests'
					  ),
				  )
			  ),
			  
			  'mombo' => array(
					
					 'a_level' => array(
					 
					      'index' => array(
						       
							    'guests',
								
								'administrator'
						  ),
						  
						  'login' => array(
						      
							   'guests',
						  
						       'administrator'
							   
						  ),
						  
						  'logout' => array(
						  
						       'guests',
						  
						       'administrator'
							   
						  ),
					 
					 ),
			  ),
			  
			  'loans' => array(
			        'a_level' => array(
					     'index' => array(
								
								'administrator'
						  ),
					),
			  ),
		  ),
	   ),
   );