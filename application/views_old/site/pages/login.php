<!-- __________________________________________________ Start Middle -->
<section id="middle">
	<div class="cont_nav">
		<a href="<?php  echo base_url();?>">Home</a>&nbsp;/&nbsp;Login
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
			
		<form id="my_form" action="" class="well" method="post" enctype="multipart/formdata">

				<h3 class="entry-title"><a href="">Login</a></h3>
				<div class="entry-content">
					
					<div class="cl"></div>
					
					<div class="form_info cmsms_input">
						<label for="contact_email">Member Id<span> *</span></label>
						<input type="text" name="nationid" id="nationid" value="" size="22" tabindex="4" class="input-small" />
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

    </section>
<!-- __________________________________________________ Finish Content -->
</section>
<!-- __________________________________________________ Finish Middle -->

<!-- __________________________________________________ Bottom Section -->