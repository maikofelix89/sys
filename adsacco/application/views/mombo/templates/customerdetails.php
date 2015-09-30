<?php	
	if(isset($customer) && null != $customer){

			$this->load->view('mombo/templates/customer',array(

					 'customer'=>$customer,

					 'loans' => $loans
				 
			   )
		    );
			
	}else{

			$this->load->view('mombo/templates/record404',array('message'=>"Sorry customer record not found!"));

	}