
<!-- __________________________________________________ Start Middle -->
				<section id="middle">
					<div class="cont_nav">
						<a href="<?php  echo base_url();?>">Home</a>&nbsp;/&nbsp;<a href="<?php  echo base_url().'products/';?>">Loans</a>&nbsp;/&nbsp;Registration
					</div>
					
<!-- __________________________________________________ Start Content -->
					<section id="middle_content">
						<div class="entry">
						<?php if(isset($message)){ ?>
							<div class="box error_box">
								<table>
									<tr>
										<td>&nbsp;</td>
										<td><p><?php echo $message;?> </p></td>
									</tr>
								</table>
							</div>
						<?php } ?>
							
					<form id="my_form" action="" method="post" enctype="multipart/formdata">
						<aside class="related_posts">
							    <ul>
							      <li>
							         <a href="#" class="current">
							              <span>Application Form</span>
							         </a>
							      </li>
								</ul>
								<div class="cl"></div>
								<div class="related_posts_content">
										<div class="box notice_box1">
												<table>
												
														<tr>
															<td> Surname <span>*</span> </td>
															<td >  <input type="text" name="customer_surname" id="customer_surname" value="<?php if(array_key_exists('customer_surname', $_POST) && $value = $_POST['customer_surname']){ echo $value; } ?>" placeholder="Sur Names" /></td>
															<td>Other Names <span>*</span> </td>
															<td >  <input type="text" name="customer_othernames" id="customer_othernames" value="<?php if(array_key_exists('customer_othernames', $_POST) && $value = $_POST['customer_othernames']){ echo $value; } ?>" placeholder="Other Names" /></td>
																	
														</tr>
													
														<tr>
															<td>ID/Passport Number  <span>*</span></td>
															<td><input type="text" name="customer_idnum" id="customer_idnum" value="<?php if(array_key_exists('customer_idnum', $_POST) && $value = $_POST['customer_idnum']){ echo $value; } ?>" placeholder="e.g. 123456"</td>
														</tr>
														
														<tr>
															<td>Mobile Number: <span>*</span> </td>
															<td><input type="text" name="customer_phone" id="customer_phone" value="<?php if(array_key_exists('customer_phone', $_POST) && $value = $_POST['customer_phone']){ echo $value; } ?>" placeholder="e.g. 254XXXXXXXX" /></td>
															<td>Email: </td>
															<td><input type="text" name="customer_email" id="customer_email" value="<?php if(array_key_exists('customer_email', $_POST) && $value = $_POST['customer_email']){ echo $value; } ?>" placeholder="e.g. somebody@gmail.com" /></td>
															
														</tr>
													    <input type="hidden" name="status"  id="customer_status" value="0" /></td>
													    <tr>
															<td> Employment </td>
															<td >  &nbsp;&nbsp;&nbsp;<input type="radio" name="customer_employername" id="employername" value="employed" selected="<?php if(array_key_exists('customer_employername', $_POST) && 'employed' == $_POST['customer_employername']){ echo 'selected'; } ?>" placeholder="e.g Name" />&nbsp;&nbsp;&nbsp;Employed</td>
															<td >  <input type="radio" name="customer_employername" id="employername" value="selfemployed" selected="<?php if(array_key_exists('customer_employername', $_POST) && 'selfemployed' == $_POST['customer_employername']){ echo 'selected'; } ?>" placeholder="e.g Name" />&nbsp;&nbsp;&nbsp;Self Employed</td>
													    </tr>
														<tr>
															<td> Amount looking For : </td>
															<td >  <input type="text" name="customer_loan_amount" id="customer_loan_amount" value="<?php if(array_key_exists('customer_loan_amount', $_POST) && $value = $_POST['customer_loan_amount']){ echo $value; } ?>" placeholder="e.g  10000" /></td>		
														</tr>
													
														<tr>
															<td>Purpose For The Loan : </td>
															<td>
																<select name="customer_loan_purpose" id="customer_loan_purpose">
																	<option selected="selected">Select Purpose of loan</option>
																	<?php foreach($products->result('product_model') as $product){ ?>
																		<option value="<?php echo $product->id; if(array_key_exists('customer_loan_purpose', $_POST) && $value = $_POST['customer_loan_purpose'] && $value == $product->id) echo '" selected="selected'; ?>"><?php echo $product->loan_product_name;?></option>
																     <?php } ?>
																</select>
															 </td>
														</tr>
														<tr>
															<td> Loan Duration : </td>
															<td >  <input type="text" name="customer_loan_duration" id="customer_loan_duration" value="<?php if(array_key_exists('customer_loan_duration', $_POST) && $value = $_POST['customer_loan_duration']){ echo $value; } ?>" placeholder="e.g 2" /></td>		
														</tr>
											
														<tr>
															<td colspan="5"><input type="hidden" name="registrationsubmit" id="registrationsubmit" value="registrationsubmit"/> <a href="javascript:{}" class="button" onclick="document.getElementById('my_form').submit(); return false;"><span>Register</span></a></td>		
														</tr>
											
									      </table>

								       </div>
							     </div>
							</aside>
						<div class="cl"></div>
					</form>
					</section>
<!-- __________________________________________________ Finish Content -->
				</section>
<!-- __________________________________________________ Finish Middle -->

<!-- __________________________________________________ Bottom Section -->