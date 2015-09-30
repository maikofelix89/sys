<div class="navbar">
    <div class="navbar-inner">
        <ul class="nav pull-right"></ul>
        <a class="brand" href="index.html">
            <span class="first">Mombo</span> 
            <span class="second">Investment LTD</span>
        </a>
    </div>
</div>
<div class="row-fluid">
    <div class="dialog">
        <?php if(isset($message)){ ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <?php echo $message;?>
            </div>
         <?php } ?>
        <div class="block">
		<?php if(true){ ?>
            <p class="block-heading">Log In</p>
            <div class="block-body">
                <form method="post" action="<?php echo base_url();?>admin_login/">
                    <label>Username</label>
                    <input type="text" class="span12" name="username" placeholder="Enter your email">
                    <label>Password</label>
                    <input type="password" class="span12" name="password" placeholder="Enter your password">
                    <input type="submit" name="login_btn" class="btn btn-primary pull-right" value="Sign In">
                    <label class="remember-me"><input type="checkbox"> Remember me</label>
                    <div class="clearfix"></div>
                </form>
            </div>
			<?php }else{  ?>
			  <p class="block-heading">Account Locked</p>
              <div class="block-body">
                <h5>You have tried logging in more than 7 times, account is now locked. Contact the administrator for support. Or you can use the <a href="<?php echo base_url();?>account/forgotpassword/">forgot password</a> feature to get a new password.</h5>
              </div>
			<?php } ?>
        </div>
        <p class="pull-right" style=""><a href="#" target="blank"></a></p>
        <p><a href="reset-password.php">Forgot your password?</a></p>
    </div>
</div>