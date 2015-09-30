<div class="navbar">
    <div class="navbar-inner">
            <ul class="nav pull-right">
                   <li id="fat-menu" class="dropdown">
                    <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-user  icon-white"></i> Mombo System Users
                        <i class="icon-caret-down icon-white"></i>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a tabindex="-1" href="<?php echo base_url();?>users/">All Users</a></li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="<?php echo base_url();?>users/?type=active">Active Users</a></li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="<?php echo base_url();?>users/?type=inactive">Deactivated Users</a></li>
                    </ul>
                </li>
			    <li id="fat-menu" class="dropdown">
                    <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-user  icon-white"></i> Customer Accounts
                        <i class="icon-caret-down"></i>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a tabindex="-1" href="<?php echo base_url();?>customers/">All Customers</a></li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="<?php echo base_url();?>customers/?type=new">New Customers</a></li>
                         <li class="divider"></li>
                        <li><a tabindex="-1" href="<?php echo base_url();?>customers/?type=active">Active Customers</a></li>
						 <li class="divider"></li>
						 <li><a tabindex="-1" href="<?php echo base_url();?>customers/?type=inactive">Deactivated Customers</a></li>
						 <li class="divider"></li>
						 <li><a tabindex="-1" href="<?php echo base_url();?>customers/?type=reject">Rejected Customers</a></li>
						 <li class="divider"></li>
						 <li><a tabindex="-1" href="<?php echo base_url();?>customers/birthdays">Customer Birthdays</a></li>
                    </ul>
                </li>
			   
			   <li id="fat-menu" class="dropdown">
                    <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-user  icon-white"></i> Guarantor
                        <i class="icon-caret-down"></i>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a tabindex="-1" href="<?php echo base_url();?>gaurantors/">All Guarantor</a></li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="<?php echo base_url();?>gaurantors/?type=new">New Guarantor</a></li>
                         <li class="divider"></li>
                        <li><a tabindex="-1" href="<?php echo base_url();?>gaurantors/?type=active">Active Guarantor</a></li>
						 <li class="divider"></li>
						 <li><a tabindex="-1" href="<?php echo base_url();?>gaurantors/?type=inactive">Deactivated Guarantor</a></li>
						 <li class="divider"></li>
						 <li><a tabindex="-1" href="<?php echo base_url();?>gaurantors/?type=reject">Rejected Guarantor</a></li>
                    </ul>
                </li>
			   
			    <li id="fat-menu" class="dropdown">
                    <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-list-alt  icon-white"></i> Statements
                        <i class="icon-caret-down"></i>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a tabindex="-1" href="?income_statement">Profit & Loss</a></li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="?expenditures">Expenditures</a></li>
					
                    </ul>
                </li>
			   
			   
			 
			   
			   
			     <li id="fat-menu" class="dropdown">
                    <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-tasks icon-white"></i>  Payments
                        <i class="icon-caret-down"></i>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a tabindex="-1" href="?payments_made">View Payments</a></li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="?add_payments">Update Payments</a></li>
						 <li class="divider"></li>
                        <li><a tabindex="-1" href="#">Pending Payments</a></li>
                    </ul>
                </li>
                
				
                
                  <li id="fat-menu" class="dropdown">
                    <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-file  icon-white  icon-white"></i> Loans
                        <i class="icon-caret-down"></i>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a tabindex="-1" href="?issued_loans">Issued Loans</a></li>
                        <li class="divider visible-phone"></li>
                        <li><a tabindex="-1" class="visible-phone" href="?issue_loan">Issue Loan</a></li>
                        <li class="divider visible-phone"></li>
                        <li><a tabindex="-1" href="?loan_request">Loan Requests</a></li>
                    </ul>
                </li>
                
                
                <li id="fat-menu" class="dropdown">
                    <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-user  icon-white"></i> <?php echo $this->session->userdata('user_fullname'); ?>
                        <i class="icon-caret-down"></i>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a tabindex="-1" href="#">My Account</a></li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="#">Messages</a></li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="<?php echo base_url();?>mombo/logout/">Logout</a></li>
                    </ul>
                </li>
                
            </ul>
            <a class="brand" href="<?php echo base_url().'mombo/home/';?>"><span class="first">Mombo </span> <span class="second">Investment Limited</span></a>
    </div>
</div>

<div class="sidebar-nav" style="min-height:960px;border-right:3px solid #888">

    <a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-home"></i> Mombo Panel</a>

    <ul id="dashboard-menu" class="nav nav-list collapse in">

        <li ><a href="<?php echo base_url().'mombo/home/'; ?>">Dashboard</a></li>

        <li ><a href="<?php echo base_url().'systemsettings/'; ?>">System Management</a></li>
		
        <li ><a href="<?php echo base_url().'sms/outbox/'; ?>">SMS Outbox</a></li>
		<li ><a href="<?php echo base_url().'finance_transfers/'; ?>">Finance Transfers</a></li>
		<li><a href="<?php echo base_url().'financial_statements/'; ?>">Financial Statements</a></li>
		<li><a href="<?php echo base_url().'mombo_reports/'; ?>">Mombo Reports</a></li>
		<li><a href="<?php echo base_url().'pre_fees/'; ?>">Loan Pre-Fees</a></li>
    </ul>
	
    <a href="#loans-menu" class="nav-header" data-toggle="collapse"><i class="icon-file"></i> Loans<span class="label label-info"></span></a>

    <ul id="loans-menu" class="nav nav-list collapse in">
		 <li ><a href="<?php echo base_url().'loans/debtsrecovery'; ?>">Debts Recovery</a></li>
         <li ><a href="<?php echo base_url().'loans/makepayment'; ?>">Make Payment</a></li>

         <li ><a href="<?php echo base_url().'loans/loanrequests'; ?>">Loan Requests</a></li>

         <li ><a href="<?php echo base_url().'loans/loansissued'; ?>">Loans Issued</a></li>

         <li ><a href="<?php echo base_url().'loans/loanpayments'; ?>">Loan Payments</a></li>

         <li ><a href="<?php echo base_url().'loans/penalties'; ?>">Loan Penalties</a></li>

         <li ><a href="<?php echo base_url().'loans/loanproducts/'; ?>">Loan Products</a></li>
		 
		 <li ><a href="<?php echo base_url().'loans/rewards/'; ?>">Mombo Loyal</a></li>

        <li ><a href="#">Summary</a></li>

    </ul>

    <a href="#accounts-menu" class="nav-header" data-toggle="collapse"><i class="icon-book"></i> Accounts<span class="label label-info"></span></a>

    <ul id="accounts-menu" class="nav nav-list collapse in">

        <li><a href="<?php echo base_url().'accounts/';?>" >All Accounts</a></li>

        <?php 
           
           $CI = & get_instance();

           $CI->load->model('account_model','accmod');

           $main_accounts = $CI->accmod->findBy(array('is_exp' => 0));

        ?>

        <?php if($main_accounts->num_rows() > 0){ ?>

             <?php foreach($main_accounts->result('account_model') as $account){ ?>

       				<li><a href="<?php echo base_url().'accounts/accountsummary/?account_id='.$account->id; ?>" > <?php echo $account->account_name;?> </a></li>

       		 <?php } ?>

       	<?php } ?>

        <li><a href="<?php echo base_url().'accounts/customeraccounts/'; ?>">Customer Legder Accounts</a></li>

         <li><a href="<?php echo base_url().'accounts/reconcilliationstatements/'; ?>">Reconciliation Statements</a></li>

        <li><a href="<?php echo base_url().'accounts/'; ?>">Account Activity Logs</a></li>

        <li><a href="<?php echo base_url().'accounts/'; ?>">Summary</a></li>
      
    </ul>

    <a href="#statistics" class="nav-header" data-toggle="collapse"><i class="icon-file"></i>Statistics<span class="label label-info"></span></a>

    <style type="text/css">

        div#statistics span{

               font-family:monospace;

               font-size: 14px;

               color:#fff;

               display:inline-block;

               margin-left:-2px;

        }

         div#statistics span.st-value{

              font-size:12px;

              font-family:Helvetica,Arial,sans-serif;

              text-align:right;

              margin-left:5px;

        }

        div#statistics span.st-yellow{
              
              color:#e1a921;

        }

        div#statistics span.st-green{

              color:#5af410;
        }

    </style>

    <?php 
       
        $CI->load->model('loan_model','loan');

        $CI->load->model('customer_model','customer');

        $CI->load->model('payment_model','payment');

        $CI->load->model('charge_model','charge');

        $CI->load->model('account_model','account');

        $registeredCustomers = $CI->customer->findBy(array(

              'status' => 1,

        ));

        $newCustomers = $CI->customer->findBy(array(

              'status' => 0,

        ));


        $settledLoans = $CI->loan->findBy(array(

              'loan_status' => 1,

              'request_status' => 2

        ));

        $unSettledLoans = $CI->loan->findBy(array(

              'loan_status' => 0,

              'request_status' => 2,

        ));

        $cash_account = $CI->account->findBy(array(

             'account_name'=>'Cash Account'

        ))->row(0,'account_model');

        $coll_account = $CI->account->findBy(array(

             'account_name'=>'Collection Account'

        ))->row(0,'account_model');

        $bank_account = $CI->account->findBy(array(

             'account_name'=>'Chase Account'

        ))->row(0,'account_model');

        $amountOut = 0;

        $principleOut = 0;

        $totalCharges = 0;

        foreach ($unSettledLoans->result('loan_model') as $loan) {

              $amountOut += $loan->loan_balance_amount;

              $charges = $CI->charge->findBy(array('loan'=>$loan->id));

              foreach ($charges->result('charge_model') as $charge) {

                   $amountOut += $charge->balance;
                   $totalCharges += $charge->amount;
                # code...
              }



              $principleOut += $loan->loan_principle_amount;
        }



        foreach ($settledLoans->result('loan_model') as $loan) {

              $principleOut += $loan->loan_principle_amount;
        }


        $amountIn  = $CI->payment->doSQLFunction('SUM','payment_amount');

    ?>

    <div id="statistics" class="nav nav-list collapse in" style="background-color:#000;color:#fff;margin-left:-10px;">

           <span class="st-label">Cash Available</span><span class="st-value st-green">Ksh. <?php echo $coll_account->account_balance+$cash_account->account_balance+$bank_account->account_balance; ?></span><br/><br/>

           <span class="st-label">Registered Customers</span><span class="st-value st-green"><?php echo $registeredCustomers->num_rows(); ?></span>
           <span class="st-label">New Applications</span><span class="st-value st-yellow"><?php echo $newCustomers->num_rows(); ?></span><br/>

           <span class="st-label">Settled Loans</span><span class="st-value st-green"><?php echo $settledLoans->num_rows(); ?></span>
           <span class="st-label">UnSettled Loans</span><span class="st-value st-yellow"><?php echo $unSettledLoans->num_rows(); ?></span><br/>

           <span class="st-label">Total Amount In</span><span class="st-value st-green">Ksh. <?php echo $amountIn; ?></span>
           <span class="st-label">Total Amount Out</span><span class="st-value st-yellow">Ksh. <?php echo $amountOut; ?></span><br/>

           <span class="st-label">Total Princ Out</span><span class="st-value st-green">Ksh. <?php echo $principleOut; ?></span>

           <br/>
           <span class="st-label">Total Charges</span><span class="st-value st-green">Ksh. <?php echo $totalCharges; ?></span>

    </div>
</div>
<div class="content">
<style type="text/css">

        #app-search-form{
            margin-right:20%;
            margin-top:1%;
            margin-left:1%;

        }

        #search-box{

             height:35px;
             padding:4px;
             width:150%;
        }

        #search-go-btn,#search-options-btn{
              height:45px;
        }

</style>

<form id="app-search-form" class="pull-right" method="POST" action="<?php echo base_url().'search/'; ?>">
                    
    <div class="input-append">
      
      <input name="search_query" ="span2" id="search-box" type="text">

       <input type="hidden" class="btn btn-success" name="search_in"/>

      <input type="submit" class="btn btn-success" id="search-go-btn" value="Search"/>
   
    </div>

</form>

<div class="" style=""></div>