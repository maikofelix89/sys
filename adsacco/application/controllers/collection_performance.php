<?php if(!defined('BASEPATH')) exit('Access Denied!!');

class Collection_performance extends CI_Controller{
    
	 protected $models = array(
	 
				'sys_object' => 'systemobject_model',
				
				'sys_option' => 'systemoption_model',
				
				'product' => 'product_model',
		 
				'loan' => 'loan_model',

				'loan_charge' => 'charge_model',
				
				'collateral' => 'collateral_model',
				
				'account' => 'account_model',
				
				'transaction' => 'transaction_model',
				
				'customer' => 'customer_model',
				
				'customer_account' => 'customeraccount_model',

				'expected_payment' => 'expectedpayment_model',

				'payment' => 'payment_model',

				'charge_payment' => 'chargepayment_model',
				
				'gaurantor' => 'gaurantor_model',
			
	 );
	 
	 protected $header = 'mombo/layout/header'; //set header template file
	  
	 protected $footer = 'mombo/layout/footer'; //set footer template file
	 
	 public function __construct()
	{
	    parent::__construct();
		
	    //function inside autoloaded helper, check if user is logged in, if not redirects to login page
	    is_logged_in();
	}

    		
	public function index($month = 0, $year = 0,$pdf = 0,$type = 'A'){ 
		$this->load->model('collection_performance_model'); 
		
		if($month == 0 && $year == 0){
			$date= date('Y-m');
			$date1 = date ('Y-m-t');
			$date_check = date('Y-m')."-01";
			$date_check1 = date ( 'Y-m-t' , strtotime($date) );
			$month_year = date('M, Y');
			$month = date('m');
			$m = date('M');
			$year = date('Y');
		}
		else{
			$date = date ( 'Y-m' , strtotime($year.'-'.$month) );
			$date1 = date ( 'Y-m-t' , strtotime($year.'-'.$month) );
			$date_check = date ( 'Y-m-d' , strtotime($year.'-'.$month.'-01') );
			$date_check1 = date ( 'Y-m-t' , strtotime($year.'-'.$month) );
			$month_year = date ( 'M,Y' , strtotime($year.'-'.$month) );
		}
		
		$l = date ( 't' , strtotime($date) );
				
		$date_aa = strtotime ( '+1 month' , strtotime ( $date ) ) ;
		$date_a = date ( 'Y-m' , $date_aa );
		
		
		$date_b = date("Y-m", mktime(0, 0, 0, date("m")-1, date("d"),   date("Y")));
		
		$week1 = $date.'-01 to '.$date.'-07';
		$week2 = $date.'-08 to '.$date.'-15';
		$week3 = $date.'-16 to '.$date.'-23';
		$week4 = $date.'-24 to '.$date1;
		
		$all_details = $this->collection_performance_model->get_all_details($date,$date1);
		$week1_details = $this->collection_performance_model->get_weekly_details($date.'-01',$date.'-07',$date,$date1,'01','07');
		$week2_details = $this->collection_performance_model->get_weekly_details($date.'-08',$date.'-15',$date,$date1,'08','15');
		$week3_details = $this->collection_performance_model->get_weekly_details($date.'-16',$date.'-23',$date,$date1,'16','23');
		$week4_details = $this->collection_performance_model->get_weekly_details($date.'-24',$date1,$date,$date1,'24',$l);
		
		if(! $pdf){
			$this->page->title      = "Mombo Loan System | Monthly Collection Performance";
		 
			$this->page->name       = 'mombo-monthly-collection-performance';
			 
			$this->msg['page']      = $this->page;
			 
			$this->msg['all_details'] = $all_details;
			$this->msg['week1_details'] = $week1_details;
			$this->msg['week2_details'] = $week2_details;
			$this->msg['week3_details'] = $week3_details;
			$this->msg['week4_details'] = $week4_details;
			$this->msg['week1'] = $date.'-01 to '.$date.'-07';
			$this->msg['week2'] = $date.'-08 to '.$date.'-15';
			$this->msg['week3'] = $date.'-16 to '.$date.'-23';
			$this->msg['week4'] = $date.'-24 to '.$date1;
			
			$this->msg['month_year'] = $month_year;
			$this->msg['month'] = $month;
			$this->msg['mwaka'] = $year;
			
					
			$this->sendResponse($this->msg,array(
				
		    	$this->header => $this->msg,
					
					'mombo/templates/collection_performance_view' => $this->msg,
					
					$this->footer => $this->msg,
			 
			));
		}
		else{
			if($type == 'A'){
				$img_url = 'img/logo2.png';
				$contentA = '<img src="'.$img_url.'"/><br />';
				$contentA .= '<strong>All</strong><br />';
				
				$contentA .= $month_year; 
				
				if( count($all_details) > 0 ){ 
					$contentA .= "<table>
		                    <thead>
		                          <tr>
		                               <th>#</th>
		                               <th>Name</th>
									   <th>Loan</th>
									   <th>Initial Date Expected</th>
									   <th>Date Expected</th>
									   <th>Target</th>
									   <th>Actual</th>
		                          </tr>
		                    </thead>
		                    <tbody>";
                        
						$total_target_amount = 0;
						$total_actual_amount = 0;
						$performance = 0;
						for($i = 0, $j = 1; $i < count($all_details); $i++){
							$details = explode("*",$all_details[$i]);
							$total_target_amount += $details[4];
							$total_actual_amount += $details[5];
							$contentA .= "<tr>";
								$contentA .= "<td>".$j."</td>";
								$contentA .= "<td>".$details[0]."</td>";
								$contentA .= "<td>".$details[2]."</td>";
								$contentA .= "<td>".$details[7]."</td>";
								$contentA .= "<td>".$details[6]."</td>";
								$contentA .= "<td>".number_format($details[4],2,'.',',')."</td>";
								$contentA .= "<td>".number_format($details[5],2,'.',',')."</td>";
							$contentA .= "</tr>";
							$j++;
						}
						$performance = round(($total_actual_amount/$total_target_amount)*100,2);
						
						$contentA .= "<tr>";
								$contentA .= "<td></td>";
								$contentA .= "<td></td>";
								$contentA .= "<td></td>";
								$contentA .= "<td></td>";
								$contentA .= "<td></td>";
								$contentA .= "<td style='color: purple'></td>";
								$contentA .= "<td style='color: blue'></td>";
						$contentA .= "</tr>";
						
						$contentA .= "<tr>";
								$contentA .= "<td></td>";
								$contentA .= "<td></td>";
								$contentA .= "<td></td>";
								$contentA .= "<td></td>";
								$contentA .= "<td></td>";
								$contentA .= "<td style='color: purple'>".number_format($total_target_amount,2,'.',',')."</td>";
								$contentA .= "<td style='color: blue'>".number_format($total_actual_amount,2,'.',',')."</td>";
						$contentA .= "</tr>";
						
						$contentA .= "<tr>";
							$contentA .= '<td colspan = "6" style="color: green;text-align:right">Performance: '.$performance.'%</td>';
						$contentA .= "</tr>
					
					 </tbody> 
                    </table>";
					$this->collection_performance_pdf($contentA,$month_year.'_Collection Performance');
					}else{ 
						$this->collection_performance_pdf('No result.',$month_year.'_Collection Performance');
					} 
			}
			elseif($type == '1'){
				$img_url = 'img/logo2.png';
				$content1 = '<img src="'.$img_url.'"/><br />';
								
				$content1 .= $month_year."<br />"; 
				$content1 .= "Week 1: ".$week1; 
					
                if( count($week1_details) > 0 ){ 
				  
						  $content1 .= "<table>
		                    <thead>
		                          <tr>
		                               <th>#</th>
		                               <th>Name</th>
									   <th>Loan</th>
									   <th>Initial Date Expected</th>
									   <th>Date Expected</th>
									   <th>Target</th>
									   <th>Actual</th>
		                          </tr>
		                    </thead>
		                    <tbody>";
                        
						$total_target_amount = 0;
						$total_actual_amount = 0;
						$performance = 0;
						for($i = 0, $j = 1; $i < count($week1_details); $i++){
							$details = explode("*",$week1_details[$i]);
							$total_target_amount += $details[4];
							$total_actual_amount += $details[5];
							$content1 .= "<tr>";
								$content1 .= "<td>".$j."</td>";
								$content1 .= "<td>".$details[0]."</td>";
								$content1 .= "<td>".$details[2]."</td>";
								$content1 .= "<td>".$details[7]."</td>";
								$content1 .= "<td>".$details[6]."</td>";
								$content1 .= "<td>".number_format($details[4],2,'.',',')."</td>";
								$content1 .= "<td>".number_format($details[5],2,'.',',')."</td>";
							$content1 .= "</tr>";
							$j++;
						}
						$performance = round(($total_actual_amount/$total_target_amount)*100,2);
						
						$content1 .= "<tr>";
								$content1 .= "<td></td>";
								$content1 .= "<td></td>";
								$content1 .= "<td></td>";
								$content1 .= "<td></td>";
								$content1 .= "<td></td>";
								$content1 .= "<td style='color: purple'></td>";
								$content1 .= "<td style='color: blue'></td>";
						$content1 .= "</tr>";
						
						$content1 .= "<tr>";
								$content1 .= "<td></td>";
								$content1 .= "<td></td>";
								$content1 .= "<td></td>";
								$content1 .= "<td></td>";
								$content1 .= "<td></td>";
								$content1 .= "<td style='color: purple'>".number_format($total_target_amount,2,'.',',')."</td>";
								$content1 .= "<td style='color: blue'>".number_format($total_actual_amount,2,'.',',')."</td>";
						$content1 .= "</tr>";
						
						$content1 .= "<tr>";
							$content1 .= '<td colspan = "6" style="color: green;text-align:right">Performance: '.$performance.'%</td>';
						$content1 .= "</tr>
					
					 </tbody> 
                    </table>";
					$this->collection_performance_pdf($content1,'Week 1 of '.$month_year.'_Collection Performance');
					}else{ 
						$this->collection_performance_pdf('No result.','Week 1 of '.$month_year.'_Collection Performance');
					} 
			}
			elseif($type == '2'){
				$img_url = 'img/logo2.png';
				$content2 = '<img src="'.$img_url.'"/><br />';
								
				$content2 .= $month_year."<br />"; 
				$content2 .= "Week 2: ".$week2; 
					
                if( count($week2_details) > 0 ){ 
				   	
						  $content2 .= "<table>
		                    <thead>
		                          <tr>
		                               <th>#</th>
		                               <th>Name</th>
									   <th>Loan</th>
									   <th>Initial Date Expected</th>
									   <th>Date Expected</th>
									   <th>Target</th>
									   <th>Actual</th>
		                          </tr>
		                    </thead>
		                    <tbody>";
                        
						$total_target_amount = 0;
						$total_actual_amount = 0;
						$performance = 0;
						for($i = 0, $j = 1; $i < count($week2_details); $i++){
							$details = explode("*",$week2_details[$i]);
							$total_target_amount += $details[4];
							$total_actual_amount += $details[5];
							$content2 .= "<tr>";
								$content2 .= "<td>".$j."</td>";
								$content2 .= "<td>".$details[0]."</td>";
								$content2 .= "<td>".$details[2]."</td>";
								$content2 .= "<td>".$details[7]."</td>";
								$content2 .= "<td>".$details[6]."</td>";
								$content2 .= "<td>".number_format($details[4],2,'.',',')."</td>";
								$content2 .= "<td>".number_format($details[5],2,'.',',')."</td>";
							$content2 .= "</tr>";
							$j++;
						}
						$performance = round(($total_actual_amount/$total_target_amount)*100,2);
						
						$content2 .= "<tr>";
								$content2 .= "<td></td>";
								$content2 .= "<td></td>";
								$content2 .= "<td></td>";
								$content2 .= "<td></td>";
								$content2 .= "<td></td>";
								$content2 .= "<td style='color: purple'></td>";
								$content2 .= "<td style='color: blue'></td>";
						$content2 .= "</tr>";
						
						$content2 .= "<tr>";
								$content2 .= "<td></td>";
								$content2 .= "<td></td>";
								$content2 .= "<td></td>";
								$content2 .= "<td></td>";
								$content2 .= "<td></td>";
								$content2 .= "<td style='color: purple'>".number_format($total_target_amount,2,'.',',')."</td>";
								$content2 .= "<td style='color: blue'>".number_format($total_actual_amount,2,'.',',')."</td>";
						$content2 .= "</tr>";
						
						$content2 .= "<tr>";
							$content2 .= '<td colspan = "6" style="color: green;text-align:right">Performance: '.$performance.'%</td>';
						$content2 .= "</tr>
					
					 </tbody> 
                    </table>";
					$this->collection_performance_pdf($content2,'Week 2 of '.$month_year.'_Collection Performance');
					}else{ 
						$this->collection_performance_pdf('No result.','Week 2 of '.$month_year.'_Collection Performance');
					} 
			}
			elseif($type == '3'){
				$img_url = 'img/logo2.png';
				$content3 = '<img src="'.$img_url.'"/><br />';
								
				$content3 .= $month_year."<br />"; 
				$content3 .= "Week 3: ".$week3; 
					
                if( count($week3_details) > 0 ){ 
				   
						  $content3 .= "<table>
		                    <thead>
		                          <tr>
		                               <th>#</th>
		                               <th>Name</th>
									   <th>Loan</th>
									   <th>Initial Date Expected</th>
									   <th>Date Expected</th>
									   <th>Target</th>
									   <th>Actual</th>
		                          </tr>
		                    </thead>
		                    <tbody>";
                        
						$total_target_amount = 0;
						$total_actual_amount = 0;
						$performance = 0;
						for($i = 0, $j = 1; $i < count($week3_details); $i++){
							$details = explode("*",$week3_details[$i]);
							$total_target_amount += $details[4];
							$total_actual_amount += $details[5];
							$content3 .= "<tr>";
								$content3 .= "<td>".$j."</td>";
								$content3 .= "<td>".$details[0]."</td>";
								$content3 .= "<td>".$details[2]."</td>";
								$content3 .= "<td>".$details[7]."</td>";
								$content3 .= "<td>".$details[6]."</td>";
								$content3 .= "<td>".number_format($details[4],2,'.',',')."</td>";
								$content3 .= "<td>".number_format($details[5],2,'.',',')."</td>";
							$content3 .= "</tr>";
							$j++;
						}
						$performance = round(($total_actual_amount/$total_target_amount)*100,2);
						
						$content3 .= "<tr>";
								$content3 .= "<td></td>";
								$content3 .= "<td></td>";
								$content3 .= "<td></td>";
								$content3 .= "<td></td>";
								$content3 .= "<td></td>";
								$content3 .= "<td style='color: purple'></td>";
								$content3 .= "<td style='color: blue'></td>";
						$content3 .= "</tr>";
						
						$content3 .= "<tr>";
								$content3 .= "<td></td>";
								$content3 .= "<td></td>";
								$content3 .= "<td></td>";
								$content3 .= "<td></td>";
								$content3 .= "<td></td>";
								$content3 .= "<td style='color: purple'>".number_format($total_target_amount,2,'.',',')."</td>";
								$content3 .= "<td style='color: blue'>".number_format($total_actual_amount,2,'.',',')."</td>";
						$content3 .= "</tr>";
						
											
						$content3 .= "<tr>";
							$content3 .= '<td colspan = "6" style="color: green;text-align:right">Performance: '.$performance.'%</td>';
						$content3 .= "</tr>
					
					 </tbody> 
                    </table>";
					$this->collection_performance_pdf($content3,'Week 3 of '.$month_year.'_Collection Performance');
					}else{ 
						$this->collection_performance_pdf('No result.','Week 3 of '.$month_year.'_Collection Performance');
					} 
			}
			elseif($type == '4'){
				$img_url = 'img/logo2.png';
				$content4 = '<img src="'.$img_url.'"/><br />';
								
				$content4 .= $month_year."<br />"; 
				$content4 .= "Week 4: ".$week4; 
                if( count($week4_details) > 0 ){ 
				   	
						  $content4 .= "<table>
		                    <thead>
		                          <tr>
		                               <th>#</th>
		                               <th>Name</th>
									   <th>Loan</th>
									   <th>Initial Date Expected</th>
									   <th>Date Expected</th>
									   <th>Target</th>
									   <th>Actual</th>
		                          </tr>
		                    </thead>
		                    <tbody>";
                        
						$total_target_amount = 0;
						$total_actual_amount = 0;
						$performance = 0;
						for($i = 0, $j = 1; $i < count($week4_details); $i++){
							$details = explode("*",$week4_details[$i]);
							$total_target_amount += $details[4];
							$total_actual_amount += $details[5];
							$content4 .= "<tr>";
								$content4 .= "<td>".$j."</td>";
								$content4 .= "<td>".$details[0]."</td>";
								$content4 .= "<td>".$details[2]."</td>";
								$content4 .= "<td>".$details[7]."</td>";
								$content4 .= "<td>".$details[6]."</td>";
								$content4 .= "<td>".number_format($details[4],2,'.',',')."</td>";
								$content4 .= "<td>".number_format($details[5],2,'.',',')."</td>";
							$content4 .= "</tr>";
							$j++;
						}
						$performance = round(($total_actual_amount/$total_target_amount)*100,2);
						
						$content4 .= "<tr>";
								$content4 .= "<td></td>";
								$content4 .= "<td></td>";
								$content4 .= "<td></td>";
								$content4 .= "<td></td>";
								$content4 .= "<td></td>";
								$content4 .= "<td style='color: purple'></td>";
								$content4 .= "<td style='color: blue'></td>";
						$content4 .= "</tr>";
						
						$content4 .= "<tr>";
								$content4 .= "<td></td>";
								$content4 .= "<td></td>";
								$content4 .= "<td></td>";
								$content4 .= "<td></td>";
								$content4 .= "<td></td>";
								$content4 .= "<td style='color: purple'>".number_format($total_target_amount,2,'.',',')."</td>";
								$content4 .= "<td style='color: blue'>".number_format($total_actual_amount,2,'.',',')."</td>";
						$content4 .= "</tr>";
						
						$content4 .= "<tr>";
							$content4 .= '<td colspan = "6" style="color: green;text-align:right">Performance: '.$performance.'%</td>';
						$content4 .= "</tr>
					
					 </tbody> 
                    </table>";
					$this->collection_performance_pdf($content4,'Week 4 of '.$month_year.'_Collection Performance');
					}else{ 
						$this->collection_performance_pdf('No result.','Week 4 of '.$month_year.'_Collection Performance');
					} 
			}
		}
	
	}
	
	public function collection_performance_pdf($content,$filename = 'Collection Performance'){
	  	//echo 'hehehehe'; exit;
		$content = urldecode($content);
		//Load the library
		$this->load->library('html2pdf');

		//Set folder to save PDF to
		$this->html2pdf->folder('./customer/pdfs/');

		//Set the filename to save/download as
		$this->html2pdf->filename($filename); 

		//Set the paper defaults
		$this->html2pdf->paper('a4', 'portrait');

		//Load html view
		$this->html2pdf->html($content);
		
		//Create the PDF
		$this->html2pdf->create('download'); //other option 'save'
	 }
	 
}