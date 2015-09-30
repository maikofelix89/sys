<!DOCTYPE html>
<!--[if lt IE 7]><html dir="ltr" lang="en-US" class="ie6"><![endif]-->
<!--[if IE 7]><html dir="ltr" lang="en-US" class="ie7"><![endif]-->
<!--[if IE 8]><html dir="ltr" lang="en-US" class="ie8"><![endif]-->
<!--[if gt IE 8]><!--><html dir="ltr" lang="en-US"><!--<![endif]-->
	<head>
		<meta content="text/html;charset=utf-8" http-equiv="content-type" />
		<meta name="description" content="Mombo Investment Ltd offers credit facilities, loan products and participates in venture capitalism. We give emergency, payday, business and personal loans at affordable interest rates." />
		<meta name="keywords" content="loans in nairobi,kenya, affordable loans, interest rates, business loans, emergency, cash, payday, personal, get loans" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<link rel="shortcut icon" href="<?php echo base_url();?>images/favicon.png" type="image/x-icon" />
	    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/bootstrap/css/bootstrap.css"/>
		<link rel="stylesheet" href="<?php echo base_url();?>css/style.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo base_url();?>css/styles/fonts.css" type="text/css" media="screen" />
		<link href='https://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,400italic' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="<?php echo base_url();?>css/styles/jquery.prettyPhoto.css" type="text/css" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/styles/jquery.revolution.css" media="screen" />
		<!--[if lt IE 9]>
			<link rel="stylesheet" href="css/styles/ie.css" type="text/css" />
			<link rel="stylesheet" href="css/styles/ieCss3.css" type="text/css" media="screen" />
		<![endif]-->
		<script>

		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		  ga('create', 'UA-42264494-1', 'mombo.co.ke');
		  ga('send', 'pageview');

		</script>
		<script src="<?php echo base_url();?>js/modernizr.custom.all.js" type="text/javascript"></script>
		<script src="<?php echo base_url();?>js/css3MediaQueries.js" type="text/javascript"></script>
		<script src="<?php echo base_url();?>js/jquery.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url();?>js/jquery.easing.js" type="text/javascript"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.revolution.plugin.min.js"></script>			
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.revolution.min.js"></script>
		<script src="<?php echo base_url();?>js/script.js" type="text/javascript"></script>
		<script>
		   (function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=232390146905510";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>
		<title><?php echo $page->title;?></title>
	</head>
	<body>
	<div id="fb-root"></div>

<!-- _________________________________________________ Start Page -->
		<section id="page">
			<a href="#" id="slide_top"></a>
			<div class="container">
			<link rel="icon" type="image/png" href="<?php echo base_url();?>images/favicon.png">
				<header id="header">
					<div class="navi_wrap">
						<div class="navi_left"></div>
						  <nav>
							<ul id="navigation">

								<li class="current_page_item">

									<a href="<?php echo base_url();?>"><span>Home</span></a>

								</li>

								<li class="drop">
									<a href="javascript:void(0);"><span>MOMBO</span></a>
									<ul>
										<li><a href="<?php echo base_url().'about/'?>"><span>About Us</span></a></li>
								
										<li><a href="<?php echo base_url().'downloads/'?>"><span>Downloads</span></a></li>
									</ul>
								</li>
								
								<li class="drop"><a href="javascript:void(0);"><span>Loans</span></a>
									<ul>
										<li>
									         <a href="<?php echo base_url().'products/'?>"><span>Products</span></a>
								        </li>
										<li><a href="<?php echo base_url().'requirements/'?>"><span>Requirements</span></a></li>
										<li class="drop">
											<a href="<?php echo base_url().'terms/'?>"><span>Terms & Conditions</span></a>
											<ul>
												<li><a href="<?php echo base_url().'penalties/'?>"><span>Penalties</span></a></li>
												<li><a href="<?php echo base_url().'privacy/'?>"><span>Privacy Policy</span></a></li>
											
											</ul>
										</li>
									<li><a href="<?php echo base_url().'apply/'?>"><span>Apply Now</span></a></li>
									</ul>
							    </li>
								<li>
										<a href="<?php echo base_url().'calculator/'?>"><span>Calculator</span></a>
								</li>
	                           <!-- Logged in navigation 
								<li class="drop">
									<a href="#"><span>Wall</span></a>
									<ul>
										<li><a href="<?php base_url().'myhome/profile'?>"><span>Personal Profile</span></a></li>
										<li><a href="<?php base_url().'logout/'?>"><span>Logout</span></a></li>
									</ul>
								</li>
								 <!-- End Logged in Navigation-->
								<li>
									<a href="<?php echo base_url().'contact/';?>"><span>Contact us</span></a>
								</li>
									<li>
									<a href="<?php echo base_url().'login/';?>"><span>Login</span></a>
								</li>

								</li>
									<li>
									<a href="<?php echo base_url().'apply/';?>"><span>Apply Now!</span></a>
								</li>
							</ul>
						</nav>
						<div class="navi_right">
							<div class="navi_right_inner">
								<a class="resp_navigation" href="javascript:void(0);"></a>
							</div>
						</div>
						<ul class="social_list">
							<li>
							   <a href="https://www.facebook.com/MomboInvestmentLtd?fref=ts" target="_new" class="link_tooltip" title="Facebook">
							       <img src="<?php echo base_url();?>images/socicons/facebook.png" alt="" />
							   </a>
							</li>
							<li>
							   <a href="https://twitter.com/MOMBOInv_Ltd" class="link_tooltip" target="_new" title="Twitter">
							       <img src="<?php echo base_url();?>images/socicons/twitter.png" alt="" />
							   </a>
							</li>
						</ul>
					</div>
					<div class="header_inner">
						<div class="custom_html">
							<a class="logo" href="index.php"></a>
						</div>
						<div class="custom_html">
							<h4 style="font-size:26px; margin:0;" class="color_3">Call <span style="color:#6633FF;">+254202323725</span></h4>
						</div>
						<ul class="social_list">
							<li>
								 <a href="https://www.facebook.com/MomboInvestmentLtd?fref=ts" target="_new" class="link_tooltip" title="Facebook">
								    <img src="<?php echo base_url();?>images/socicons/facebook.png" alt="" />
								 </a>
							 </li>
							 <li>
							 	 <a href="https://twitter.com/MOMBOInv_Ltd" class="link_tooltip" target="_new" title="Twitter">
							 	 	<img src="<?php echo base_url();?>images/socicons/twitter.png" alt="" />
							 	 </a>
							 </li>
						</ul>
					</div>
					<div class="cl"></div>
				</header>