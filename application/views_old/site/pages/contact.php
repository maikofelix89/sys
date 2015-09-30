<!-- __________________________    ______________ Start Middle -->
				<section id="middle">
					<div class="cont_nav">
						<a href="<?php echo base_url();?>">Home</a>&nbsp;/&nbsp;Contacts
					</div>
					<div class="headline">
						<h2>Contacts</h2>
					</div>
<!-- __________________________________________________ Start Content -->
					<div class="content_wrap">
						<section id="content">
							<div class="entry">
								<h2>Visit us</h2>
								<br />
								<div class="resizable_block">
									<div id="google_map_5" class="google_map fullwidth"></div>
								</div>
								<script type="text/javascript">
									jQuery(document).ready(function () { 
										jQuery('#google_map_5').gMap( { 
											zoom : 15, 
											markers : [ { 
												address : '', 
												latitude : -1.282944, 
												longitude : 36.820731, 
												html : '<strong>Mombo Investments, Kenya</strong><br><img src="images/bg-footer1.png">', 
												mapTypeControl : false, 
												popup : false 
											} ], 
											controls : [], 
											scrollwheel : true 
										} );
									} );
								</script>
								<br /><br /><br />
								<h2>Send us a message</h2>
								<div class="cmsms-form-builder">
									<div class="box success_box" style="display:none;">
										<table>
											<tr>
												<td>&nbsp;</td>
												<td>Thank You!<br>Your message has been sent successfully.</td>
											</tr>
										</table>
									</div>
									<script type="text/javascript">
										jQuery(document).ready(function () { 
											jQuery('#contactform').validationEngine('init');
											
											jQuery('#contactform a#contact_form_formsend').click(function () { 
												var form_builder_url = jQuery('#contact_form_url').val();
												
												jQuery('#contactform .loading').animate( { opacity : 1 }, 250);
												
												if (jQuery('#contactform').validationEngine('validate')) { 
													jQuery.post(form_builder_url, { 
														contact_name : jQuery('#contact_name').val(), 
														contact_email : jQuery('#contact_email').val(), 
														contact_subject : jQuery('#contact_subject').val(), 
														contact_message : jQuery('#contact_message').val(), 
														formname : 'contact_form', 
														formtype : 'contactf' 
													}, function () { 
														jQuery('#contactform .loading').animate( { opacity : 0 }, 250);
														
														document.getElementById('contactform').reset();
														
														jQuery('#contactform').parent().find('.box').hide();
														jQuery('#contactform').parent().find('.success_box').fadeIn('fast');
														jQuery('html, body').animate( { scrollTop : jQuery('#contactform').offset().top - 100 }, 'slow');
														jQuery('#contactform').parent().find('.success_box').delay(5000).fadeOut(1000);
													} );
													
													return false;
												} else { 
													jQuery('#contactform .loading').animate( { opacity : 0 }, 250);
													
													return false;
												}
											} );
										} );
									</script>
									<form action="#" method="post" id="contactform">
										<div class="form_info cmsms_input">
											<label for="contact_name">Name<span> *</span></label>
											<input type="text" name="contact_name" id="contact_name" value="" size="22" tabindex="3" class="validate[required,minSize[3],maxSize[100],custom[onlyLetterSp]]"/>
										</div>
										<div class="cl"></div>
										<div class="form_info cmsms_input">
											<label for="contact_email">Email<span> *</span></label>
											<input type="text" name="contact_email" id="contact_email" value="" size="22" tabindex="4" class="validate[required,custom[email]]" />
										</div>
										<div class="cl"></div>
										<div class="form_info cmsms_input">
											<label for="contact_subject">Subject<span> *</span></label>
											<input type="text" name="contact_subject" id="contact_subject" value="" size="22" tabindex="6" class="validate[required,minSize[3],maxSize[100]]" />
										</div>
										<div class="cl"></div>
										<div class="form_info cmsms_textarea">
											<label for="contact_message">Message<span> *</span></label>
											<textarea name="contact_message" id="contact_message" cols="28" rows="6" tabindex="7" class="validate[required,minSize[3]]" ></textarea>
										</div>
										<div><input type="hidden" name="contact_form_url" id="contact_form_url" value="<?php echo base_url().'site/contact/';?>" /></div><!-- Here you need to set the path to the sendmail file -->
										<div>
											<a href="#" class="button" id="contact_form_formsend" tabindex="8"><span>Send a message</span></a>
											<div class="loading"></div>
										</div>
									</form>
								</div>
							</div>
						</section>
<!-- __________________________________________________ Start Sidebar -->					
						<section id="sidebar">
							<div class="sidebar_inner"></div>
					        <code>
						        <h5>Contact Us.</h5>
								<p>P.O Box 105034-00101 Jamia-Nairobi.</p>
								<p>Tel: +25420-2323725</p>
								</p>Cell: 0727 772196</p>
								</p>Email: info@mombo.co.ke</p>
							</code>
						    <img class="" src="<?php echo base_url(); ?>images/img/about.jpg" alt="" />
						    
						<div class="cl"></div>
						</section>
						<div class="cl"></div>
<!-- _________________________________________ Finish Sidebar -->
					</div>
<!-- __________________________________________________ Finish Content -->
				</section>
<!-- __________________________________________________ Finish Middle -->