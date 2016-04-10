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
    $("#login-ch-pswd").validate({
        rules: {
            username: {
                required: true,
                
            },
            password: {
                required: true,
                notEqualTo: "#o_password"
                
            },
            o_password: {
                required: true
            }
            
        },
        messages: {
            username: {
                required: "Please enter a username"
                
            },
            password: {
                required: "Please enter a password"
            }
        }
    });
   $("#submit_btn").click(function(){
       if($("#login-ch-pswd").valid()){
           $("#login-ch-pswd").submit();
       }
   }); 
    $.validator.addMethod("notEqualTo", function (value, element, param)
    {
        var target = $(param);
        if (value) return value != target.val();
        else return this.optional(element);
    }, "New password should not match with old password");
   

});