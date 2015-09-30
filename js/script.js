// JavaScript Document

var host = "http://mombo.co.ke/";

var XMLHttpRequestObject = false;
		
if (window.XMLHttpRequest) {
	
	XMLHttpRequestObject = new XMLHttpRequest();
} 
		
else if (window.ActiveXObject) {
	XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
}

function customer_registration(){

		var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var surname = document.getElementById("surname").value;
	var oname = document.getElementById("oname").value;
	var idno = document.getElementById("idno").value;
	var pobox = document.getElementById("pobox").value;
	var pcode = document.getElementById("pcode").value;
	var phone1 = document.getElementById("phone1").value;
	var email = document.getElementById("email").value;
	var status = document.getElementById("status").value;
	var amount = document.getElementById("amount").value;
	var purpose = document.getElementById("purpose").value;
	
	if(status == 1){
		var employername = document.getElementById("employername").value;
		var pelocation = document.getElementById("pelocation").value;
		var officetel = document.getElementById("officetel").value;
		var date = document.getElementById("date").value;
		var currentposition = document.getElementById("currentposition").value;
		
			var url = host+"data/registration.php?surname="+surname+"&oname="+oname+"&idno="+idno+"&pobox="+pobox+"&pcode="+pcode+"&phone1="+phone1+"&email="+email+"&employername="+employername+"&pelocation="+pelocation+"&officetel="+officetel+"&date="+date+"&currentposition="+currentposition+"&amount="+amount+"&purpose="+purpose+"&status="+status;
				
	}else if(status == 2){
	
		var nameofbusiness = document.getElementById("nameofbusiness").value;
		var pblocation = document.getElementById("pblocation").value;
		var industry = document.getElementById("industry").value;
		
		var url = host+"data/registration.php?surname="+surname+"&oname="+oname+"&idno="+idno+"&pobox="+pobox+"&pcode="+pcode+"&phone1="+phone1+"&email="+email+"&nameofbusiness="+nameofbusiness+"&pblocation="+pblocation+"&industry="+industry+"&amount="+amount+"&purpose="+purpose+"&status="+status;
			
	}else if(status ==0){
	
		window.alert("Please choose your place of work");
	}

	if(XMLHttpRequestObject) {
		

				
		XMLHttpRequestObject.open("REQUEST", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				var response = XMLHttpRequestObject.responseText;
				window.alert(response);
		
				window.location="http://mombo.co.ke/";
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}

function login(){
		var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var nationid = document.getElementById("nationid").value;
	var password = document.getElementById("password").value;


	var url = host+"data/login.php?nationid="+nationid+"&password="+password;
	
	if(XMLHttpRequestObject) {
		
		XMLHttpRequestObject.open("REQUEST", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				var response = XMLHttpRequestObject.responseText;
				
				if(response == "success"){
					window.alert("You have logged in successful. Please Click Okay to continue");

					window.location="http://mombo.co.ke/socialsite.php";

				}
				else if(response == "fail"){

					window.alert(" Incorrect Details. Access Denied");
					document.getElementById("nationid").value = "";
					document.getElementById("password").value = "";
				}
			
			 }
				
		   }
		
				
		XMLHttpRequestObject.send(null);
	}
}

function submitpost(id){
	
		var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var post = document.getElementById("post").value;


	var url = host+"data/saveposts.php?id="+id+"&post="+post;
	
	if(XMLHttpRequestObject) {
		
		XMLHttpRequestObject.open("REQUEST", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				var response = XMLHttpRequestObject.responseText;
				window.location.reload(); 
			 }
				
		   }
		
				
		XMLHttpRequestObject.send(null);
	}
}

function submitcomments(id){

	var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var comment = document.getElementById("comment").value;
	var postid = document.getElementById("postid").value;


	var url = host+"data/savecomments.php?customerid="+id+"&comment="+comment+"&postid="+postid;
	
	if(XMLHttpRequestObject) {
		
		XMLHttpRequestObject.open("REQUEST", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				var response = XMLHttpRequestObject.responseText;
				window.location.reload(); 
			 }
				
		   }
		
				
		XMLHttpRequestObject.send(null);
	}
}
function Redirect()
{
    window.location="http://mombo.co.ke/";
}


function send_email(){
		var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var surname = document.getElementById("contact_name").value;
	var contact_email = document.getElementById("contact_email").value;
	var contact_subject = document.getElementById("contact_subject").value;
	var contact_message = document.getElementById("contact_message").value;

	if(XMLHttpRequestObject) {
		
		var obj = document.getElementById("registrationdiv");
				
		XMLHttpRequestObject.open("REQUEST", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				var response = XMLHttpRequestObject.responseText;
				obj.innerHTML = XMLHttpRequestObject.responseText;//handling text from the server
				
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}

function getemploymentinterface(id){

		var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	

	var url = host+"data/employment.php?id="+id;

	if(XMLHttpRequestObject) {
		
		var obj = document.getElementById("employmentstatus");
				
		XMLHttpRequestObject.open("REQUEST", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
				var response = XMLHttpRequestObject.responseText;
				obj.innerHTML = XMLHttpRequestObject.responseText;//handling text from the server

				
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}