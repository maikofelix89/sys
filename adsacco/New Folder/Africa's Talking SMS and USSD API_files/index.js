function unhide(divID) {
    var item = document.getElementById(divID);
    if (item) { 
    	item.className=(item.className=='hidden')?'unhidden':'hidden';
    }
}

$(function()

{
	//hide login
	$(".auth_button").click(
		function()
		  {
			  var thetarget = $(this).attr("thetarget");
			  if(!$(this).hasClass("auth_button_active"))
			  {
				  $(".auth_button").removeClass("auth_button_active");
				  $(this).addClass("auth_button_active");
				  
				  $(".auth_body_sec").css("visibility","hidden");
				  $(".auth_body_sec").css("display","none");
				  
				  $("."+thetarget).css("visibility","visible");
				  $("."+thetarget).css("display","inline");
			  }
			  
		  });
	
	$('#login_shortcut').click(
		function()
		  {
			  	 var thesource = $(this).attr("thesource");
				 var thetarget = $(this).attr("thetarget");
				 
				  $(".auth_button").removeClass("auth_button_active");
				  $("."+thesource).addClass("auth_button_active");
				  
				  $(".auth_body_sec").css("visibility","hidden");
				  $(".auth_body_sec").css("display","none");
				  
				  $("."+thetarget).css("visibility","visible");
				  $("."+thetarget).css("display","inline");
			
		});
	
	$('.auth_button_gen_key').click(
		function()
	   {
		 var thesource = $(this).attr("thesource");
		 var message = "You are about to generate a "+thesource+" API Key\n\n";
		 message = message+"Please note that this will affect operations on any systems already using the old key."
		 var confirmed = confirm(message);
		
		if(confirmed)
		 {
			 //start off
			 $(".generation_results").text("Please Wait..");
			 var dataString = "type="+thesource;
			 $.ajax({
						type: "POST",		
						url: "/account/dashboard/generatekey",		
						dataType:"json",		
						cache: false,		
						data: dataString,		
						beforeSend:function(){			
						//showModalSendingWait();
						},		
						complete:function(){		
						//hideModalSendingWait();
						},
						success: function(response)
						{
							if(response.is_ok)
							{
								var key = response.key;
								var htmx = 'Your new api key is:';
								
								 htmx=htmx+"<br/><br/>";
								 htmx=htmx+key ;
								 htmx=htmx+"<br/><br/>";								 
								 htmx=htmx+"Please record this value for later use as you will not see it from this dashboard on subsequent visits."
								 
								 $(".generation_results").html(htmx);
							}
							else
							{
								$(".generation_results").text("Sorry, key generation failed.");
							}
						},
						error: function(xhr, ajaxOptions, thrownError)
						{
							$(".generation_results").text("Sorry, key generation failed. Please check your connection and retry.");
						}
					});
			 
			 
					 
		 }
		 else
		 {
			 return false;
		}
		 
			  
	 });




});