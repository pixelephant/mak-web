$(function(){ 
	
	$("#belepes").click(function(e){
		
	  e.preventDefault();
	  
	  var user = $("#user").val();
	  var pass = $("#pass").val();
	  
		$.post("login/login.php",{
	    	"user" : user,
	    	"pass" : pass,
	    	"action" : 'login'
	      },function(resp){
	    	 if(resp == 'sikeres'){
	    		 window.location = 'felhasznalokezeles.php'
	    	 }else{
	    		 
	    	 }
	      });
		
	});
});