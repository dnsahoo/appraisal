$(document).ready(function(){
    $("#login").validate({
        rules: {
            username: {
                required: true,
                
            },
            password: {
                required: true,
                
            }
        },
        messages: {
            username: {
                required: "Please enter a username",
                
            },
            password: {
                required: "Please enter a password",
                
            }
        }
    });
   $("#login-btn").click(function(){
       if($("#login").valid()){
           $("#login").submit();
       }
   }); 
  
   

});