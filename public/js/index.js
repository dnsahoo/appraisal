$(document).ready(function () {
setTimeout( "jQuery('.alert-success').hide();",5000 );
setTimeout( "jQuery('.alert-error').hide();",5000 );
    
  $("#contact_form").validate({
        rules: {
            major_responsibilities: {
                required : true
            },
            self_rating_1: {
                check_rating : true
            },
            self_rating_2: {
                check_rating : true
            },
            self_rating_3: {
                check_rating : true
            },
            self_rating_4: {
                check_rating : true
            },
            self_rating_5: {
                check_rating : true
            },
            self_rating_6: {
                check_rating : true
            },
            self_rating_7: {
                check_rating : true
            },
            self_rating_8: {
                check_rating : true
            },
            self_rating_9: {
                check_rating : true
            }
        },
        messages: {
            major_responsibilities: {
                required: "Please enter your responsibilities."
            },
            self_rating_1: {
                check_rating: "Your rating should not be 0."
            },
            self_rating_2: {
                check_rating: "Your rating should not be 0."
            },
            self_rating_3: {
                check_rating: "Your rating should not be 0."
            },
            self_rating_4: {
                check_rating: "Your rating should not be 0."
            },
            self_rating_5: {
                check_rating: "Your rating should not be 0."
            },
            self_rating_6: {
                check_rating: "Your rating should not be 0."
            },
            self_rating_7: {
                check_rating: "Your rating should not be 0."
            },
            self_rating_8: {
                check_rating: "Your rating should not be 0."
            },
            self_rating_9: {
                check_rating: "Your rating should not be 0."
            }
        }
    }); 
    $.validator.addMethod("check_rating", 
        function (value, element, params) {
            if(parseInt(value) === parseInt('0'))
                return false;
            else
                return true;
        }, 
        function(params, element) {
           //return '';
        }
    );
    $("#submit-btn").click(function(){
       if($("#contact_form").valid()){
           $("#save_for_later").val('0');
           $("#contact_form").submit();
       }
   }); 
    $("#save_btn").click(function(){
        $("#save_for_later").val('1');
        $("#contact_form").submit();
   }); 
    
});