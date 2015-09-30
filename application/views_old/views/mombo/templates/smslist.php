 <div class="header">
       <h1 class="page-title">SMS Outbox</h1>
 </div>
        
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url();?>mombo/">Home</a> <span class="divider">/</span></li>
            <li class="active"><a href="#">SMS</a><span class="divider">/</span></li>
            <li class="active">Outbox</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
    <div class="btn-group">
         <a href="<?php echo base_url();?>sms/outbox/"  class="btn btn-primary">
           All Outbox
         </a>
    </div>
</div>
<?php if(isset($message) && $message){ ?>
    <div class="alert alert-<?php echo $message_type; ?>">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <?php echo $message;?>
    </div>
<?php } ?>
<div class="well">

     <h4>SMS Outbox</h4>

     <div class="well">
           
                    <table class="table">

                            <thead style="background-color:#ccc;">

                                <tr>

                                        <th>Date</th>

                                        <th>From</th>

                                        <th>Receiver</th>

                                        <th>Message</th>

                                        <th>Status</th>

                                </tr>
                                
                            </thead>

                            <tbody>
                                
                                   <?php if( count($dates) == 0){
								   	echo 'No messages available';
								   }else{ ?>
								   <?php for($j = 0; $j < count($dates); $j++){?>
                                          <tr>
										  	   <td><?php echo $dates[$j]; ?></td>

                                                <td>MOMBO</td>

                                                <td><?php echo $recipients[$j]; ?></td>

                                                <td style="width:300px;height:auto;"><?php echo $messages[$j]; ?></td>

                                                <td><span class="label label-success">Sent</span></td>

                                          </tr>

                                   <?php } 
								   }?>
                            </tbody>

                    </table>

          </div>

<div>