<section id="middle">
<!-- __________________________________________________ Start Top -->
					<section id="top">
						<div class="slider">
							<div class="fullwidthbanner">
								<ul>
									<li data-transition="boxfade" data-slotamount="4">
										<img src="images/mombo.jpg" alt="" />
										<div class="caption lfb" data-x="40" data-y="0" data-speed="900" data-start="500" data-easing="easeOutBack">
											<img src="images/mombo.jpg" alt="" />
										</div>
										<h1 class="caption lfr w40" data-x="640" data-y="215" data-speed="900" data-start="1400" data-easing="easeOutBack">     Your Future</h1>
										<h2 class="caption lfr w40 color_3" data-x="640" data-y="295" data-speed="900" data-start="1700" data-easing="easeOutBack">Today</h2>
									</li>
									
									<li data-transition="boxfade" data-slotamount="6">
										<img src="images/pixel.png" alt="" />
										<div class="caption lfb" data-x="350" data-y="0" data-speed="500" data-start="1100" data-easing="easeOutBack">
											<img src="images/img/slide_3.jpg" alt="" />
										</div>
										<h3 class="caption lfr w40" data-x="150" data-y="240" data-speed="900" data-start="300" data-easing="easeOutBack">Apply</h3>
										
									</li>
									<li data-transition="boxfade" data-slotamount="4">
										<img src="images/pixel.png" alt="" />
										<div class="caption lfb" data-x="650" data-y="0" data-speed="900" data-start="500" data-easing="easeOutBack">
											<img src="images/business.jpg" alt="" />
										</div>
										<h4 class="caption lfl w35" data-x="160" data-y="235" data-speed="900" data-start="1400" data-easing="easeOutBack">Do business with us</h4>
										<h4 class="caption lfl w35 color_3" data-x="230" data-y="295" data-speed="900" data-start="1700" data-easing="easeOutBack">Enjoy simplicity & transparency</h4>
									</li>
									
									<li data-transition="boxfade" data-slotamount="6">
										<img src="images/pixel.png" alt="" />
										<div class="caption lfb" data-x="350" data-y="0" data-speed="500" data-start="1100" data-easing="easeOutBack">
											<img src="images/coins.jpg" alt="" />
										</div>
										<h4 class="caption lfr w40" data-x="150" data-y="240" data-speed="900" data-start="300" data-easing="easeOutBack">Invest with us</h4>
										<h4 class="caption lfl w35 color_3" data-x="230" data-y="295" data-speed="900" data-start="1700" data-easing="easeOutBack">And see your money grow</h4>
									</li>
								</ul>
								<div class="rev_shadow"></div>
								<div class="tp-bannertimer"></div>
							</div>	
						</div>
					</section>
<!-- __________________________________________________ Finish Top -->

<!-- __________________________________________________ Start Content -->

					<section id="middle_content">
						<div class="entry">
							<div class="divider"></div>
							<section class="post_type_shortcode">
								<article class="portfolio format-album hentry one_third">
									<?php

									if(isset($_SESSION['userid'])){
										?>
										<h4 class="entry-title"><a href="">welcome</a></h4>
											<div class="entry-content">
												<p><?php echo $_SESSION['name']?></p>
											</div>
										<?php
									}else{
										?>
									<form id='login_form' action="" method="post"/>
									<h3 class="entry-title"><a href="">Login</a></h3>
									<div class="entry-content">
										
										<div class="cl"></div>
										
										<div class="form_info cmsms_input">
											<label for="contact_email">Member Id<span> *</span></label>
											<input type="text" name="nationid" id="nationid" value="" size="22" tabindex="4" />
										</div>
										<div class="cl"></div>
										<div class="form_info cmsms_input">
											<label for="contact_name">Password<span> *</span></label>
											<input type="password" name="password" id="password" value="" size="22" tabindex="3" />
										</div>
										</br>
										<div>
										
										<input type="hidden" class="button" name="login" id="login" value="submit" tabindex="8" /><a href="javascript:{}" class="button" onclick="document.getElementById('login_form').submit(); return false;"><span>LOGIN</span></a>
										
										<div class="cl"></div>
										<div class="form_info cmsms_input">
										<a href="forgotpass.php"><span>Forgot Password ?</span></a>
										</div>
										</br>
										<div>
										<div class="cl"></div>
										
										</br>
										<div>	
											
										</div>
									</div>
									</form>
										<?php } ?>
								
								</article>
								<article class="portfolio format-album hentry one_third">
									<header class="entry-header">
										<h3 class="entry-title"><a href="<?php echo base_url(); ?>">MOMBO</a></h3>
									</header>
									<div class="entry-content">
										<p>Mombo Investment Ltd offers credit facilities, loan products and participates in venture capitalism. Our microfinance services targets a diversified customer base of both...<a href="<?php echo base_url().'about/'; ?>" class="button"><span>Read more</span></a> </p>
									</div>
								</article>
								<article class="portfolio format-album hentry one_third">
									<header class="entry-header">
										<h3 class="entry-title"><a href="<?php echo base_url().'products/'; ?>">Loans</a></h3>
									</header>
									<div class="entry-content">
										<p>We pride ourselves on the simplicity and transparency of our business practices and procedures. Contact us and we would be delighted to discuss your financing requirements. </p>
									</div>
									<a href="<?php echo base_url().'apply/'; ?>" class="button"><span>Apply Now</span></a> 
								</article>
							</section>
							<div class="cl"></div>
						</div>
					</section>
<!-- __________________________________________________ Finish Content -->

<!-- __________________________________________________ Start Middle Sidebar-->
					
<!-- __________________________________________________ Finish Middle Sidebar-->
				</section>
<!-- __________________________________________________ Finish Middle -->

<!-- __________________________________________________ Bottom Section -->