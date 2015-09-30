<div class="header">
       <h1 class="page-title">Customers</h1>
 </div>
        
        <ul class="breadcrumb">
            <li><a href="?home">Home</a> <span class="divider">/</span></li>
            <li class="active">Users</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
    <div class="btn-group">
      <a href="<?php echo base_url();?>customers/"  class="btn <?php if(isset($customer_type) && $customer_type == 'all') echo 'btn-primary';?> ?>">All Customers</a>
      <a href="<?php echo base_url();?>customers/?type=new"      class="btn <?php if(isset($customer_type) && $customer_type == 'new') echo 'btn-primary';?> ?>">New Customers</a>
      <a href="<?php echo base_url();?>customers/?type=active"   class="btn <?php if(isset($customer_type) && $customer_type == 'active') echo 'btn-primary';?>">Activated Customers</a>
      <a href="<?php echo base_url();?>customers/?type=inactive" class="btn <?php if(isset($customer_type) && $customer_type == 'inactive') echo 'btn-primary';?> ?>">Inactive Customers</a>
    </div>
    <div class="btn-group pull-right">
      <a href="<?php echo base_url().'customers/addnewcustomer/';?>" class="btn btn-success"><i class="icon-plus"></i> New Customer</a>
      <a href="<?php echo base_url().'customers/exportimport/';?>" class="btn btn-primary">Import & Export Records</a>
    </div>
</div>
<div class="well">
		<div class="tabbable">
		  <ul class="nav nav-tabs">
		    <li class="active"><a href="#tab1" data-toggle="tab">Export</a></li>
		    <li><a href="#tab2" data-toggle="tab">Import (Upload Customers Excel)</a></li>
		  </ul>
		  <div class="tab-content">
		    <div class="tab-pane active" id="tab1">
                  <h3 class="muted">Choose export format</h3>
                  <a href="#" class="btn btn-info">Export to Excel</a>
                  <a href="#" class="btn btn-info">Export to CSV</a>
		    </div>
		    <div class="tab-pane" id="tab2">
			     <form  class="" method="POST" >
			     </form>
		    </div>
		  </div>
		</div>
</div>