<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $page->title;?></title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible"/>
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"/> -->
	<meta name="viewport" content="width=device-width"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <link rel="shortcut icon" href="<?php echo base_url();?>images/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/bootstrap/css/bootstrap.css"/>
    <link href="<?php echo base_url();?>css/elements.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>css/theme.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url();?>js/datepicker/css/datepicker.css" rel="stylesheet" type="text/css"/>
  	<style>
    	.container {
    		background: #fff;
    	}

    	#alert 
    		display: none;
    	}
  	</style>
    <script src="<?php echo base_url();?>js/jquery-1.8.1.min.js" type="text/javascript"></script>

    <!-- Demo page code -->

    <style type="text/css">
        #line-chart {
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .brand { font-family: georgia, serif; }
        .brand .first {
            color: #ccc;
            font-style: italic;
        }
        .brand .second {
            color: #fff;
            font-weight: bold;
        }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico"/>
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png"/>
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
  <!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
  <!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
  <!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
  <!--[if (gt IE 9)|!(IE)]><!--> 
  <body class=""> 
  <!--<![endif]-->
  <noscript>
        <div class="well">
              <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    This application depends on JavaScript. So that you can enjoy a responsive and interactive user interface.<br/>
                    Please turn JavaScript on or get a better browser <a href="http://www.mozilla.org/">here</a>
              </div>
        </div>
  </noscript>

  <?php  if($this->session->userdata('user_id')){ $this->load->view('mombo/layout/adm-header'); }?>
