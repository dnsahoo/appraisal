$(document).ready(function () {
    $('#contact_form').bootstrapValidator({
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            name: {
                validators: {
					regexp : {
                        regexp : /^[a-z\s]+$/i,
                        message : 'Name can only consist of alphabetical characters'
                    },
                    stringLength: {
                        min: 2,
                    },
                    notEmpty: {
                        message: 'Please give your name'
                    }
                }
            },
			email: {
                validators: {
                    notEmpty: {
                        message: 'Please supply your email address'
                    },
                    emailAddress: {
                        message: 'Please supply a valid email address'
                    }
                }
            },
            globallogic_eid: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Employee ID'
                    },
					numeric: {
                        message: 'Please give valid employee id',
                        transformer: function($field, validatorName, validator) {
                            var value = $field.val();
                            return value.replace(',', '');
                        }
                    }
                }
            },
            designation: {
                validators: {
					regexp : {
                        regexp : /^[a-z\s]+$/i,
                        message : 'Designation can only consist of alphabetical characters'
                    },
                    notEmpty: {
                        message: 'Please give your designation'
                    }
                }
            },
            process: {
                validators: {
					regexp : {
                        regexp : /^[a-z\s]+$/i,
                        message : 'Process can only consist of alphabetical characters'
                    },
                    notEmpty: {
                        message: 'Please give your process'
                    }

                }
            },
            doj: {
                validators: {
					/*regexp : {
                        regexp : /^\d{2}[./-]\d{2}[./-]\d{4}$/,
                        message : 'Doj must be in dd/mm/yyyy format'
                    },
					*/
                    notEmpty: {
                        message: 'Please choose your Doj'
                    }
                }
            },
            supervisor_or_manager_email: {
                validators: {
                    notEmpty: {
                        message: 'Please supply your manager email address'
                    },
                    emailAddress: {
                        message: 'Please supply a valid email address'
                    }
                }
            },
            major_responsibilities: {
                validators: {
                    notEmpty: {
                        message: "Please select your Major Responsibilities / KRA's"
                    }
                }
            },
            self_rating_1: {
                validators: {
				notEmpty: {
                        message: 'Please rate between 1 to 5'
                    }
                }
            },
            key_pointers_1: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Key Pointers'
                    }
                }
            },
             self_rating_2: {
                validators: {
                   lessThan: {
                        value: 1,
                        message: 'Please rate between 1 to 5'
                    }
                }
            },
            key_pointers_2: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Key Pointers'
                    }
                }
            },
            self_rating_3: {
                validators: {
                   lessThan: {
                        value: 1,
                        message: 'Please rate between 1 to 5'
                    }
                }
            },
            key_pointers_3: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Key Pointers'
                    }
                }
            },
            self_rating_4: {
                validators: {
                   lessThan: {
                        value: 1,
                        message: 'Please rate between 1 to 5'
                    }
                }
            },
            key_pointers_4: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Key Pointers'
                    }
                }
            },
            self_rating_5: {
                validators: {
                   lessThan: {
                        value: 1,
                        message: 'Please rate between 1 to 5'
                    }
                }
            },
            key_pointers_5: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Key Pointers'
                    }
                }
            },
            self_rating_6: {
                validators: {
                  lessThan: {
                        value: 1,
                        message: 'Please rate between 1 to 5'
                    }
                }
            },
            key_pointers_6: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Key Pointers'
                    }
                }
            },
            self_rating_7: {
                validators: {
                   lessThan: {
                        value: 1,
                        message: 'Please rate between 1 to 5'
                    }
                }
            },
            key_pointers_7: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Key Pointers'
                    }
                }
            },
            self_rating_8: {
                validators: {
                  lessThan: {
                        value: 1,
                        message: 'Please rate between 1 to 5'
                    }
                }
            },
            key_pointers_8: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Key Pointers'
                    }
                }
            },
			self_rating_9: {
                validators: {
                   lessThan: {
                        value: 1,
                        message: 'Please rate between 1 to 5'
                    }
                }
            },
            key_pointers_9: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Key Pointers'
                    }
                }
            },
			
			managers_rating_1: {
                validators: {
                   lessThan: {
                        value: 1,
                        message: 'Please rate between 1 to 5'
                    }
                }
            },
            comments_1: {
                validators: {
                    notEmpty: {
                        message: 'Please give your comments'
                    }
                }
            },
			
			managers_rating_2: {
                validators: {
                    lessThan: {
                        value: 1,
                        message: 'Please rate between 1 to 5'
                    }
                }
            },
            comments_2: {
                validators: {
                    notEmpty: {
                        message: 'Please give your comments'
                    }
                }
            },
			
			managers_rating_3: {
                validators: {
                   lessThan: {
                        value: 1,
                        message: 'Please rate between 1 to 5'
                    }
                }
            },
            comments_3: {
                validators: {
                    notEmpty: {
                        message: 'Please give your comments'
                    }
                }
            },
			
			managers_rating_4: {
                validators: {
                   lessThan: {
                        value: 1,
                        message: 'Please rate between 1 to 5'
                    }
                }
            },
            comments_4: {
                validators: {
                    notEmpty: {
                        message: 'Please give your comments'
                    }
                }
            },
			
			managers_rating_5: {
                validators: {
                  lessThan: {
                        value: 1,
                        message: 'Please rate between 1 to 5'
                    }
                }
            },
            comments_5: {
                validators: {
                    notEmpty: {
                        message: 'Please give your comments'
                    }
                }
            },
			
			managers_rating_6: {
                validators: {
                  lessThan: {
                        value: 1,
                        message: 'Please rate between 1 to 5'
                    }
                }
            },
            comments_6: {
                validators: {
                    notEmpty: {
                        message: 'Please give your comments'
                    }
                }
            },
			
			managers_rating_7: {
                validators: {
                   lessThan: {
                        value: 1,
                        message: 'Please rate between 1 to 5'
                    }
                }
            },
            comments_7: {
                validators: {
                    notEmpty: {
                        message: 'Please give your comments'
                    }
                }
            },
			
			managers_rating_8: {
                validators: {
                   lessThan: {
                        value: 1,
                        message: 'Please rate between 1 to 5'
                    }
                }
            },
            comments_8: {
                validators: {
                    notEmpty: {
                        message: 'Please give your comments'
                    }
                }
            },
			
			managers_rating_9: {
                validators: {
                  lessThan: {
                        value: 1,
                        message: 'Please rate between 1 to 5'
                    }
                }
            },
            comments_9: {
                validators: {
                    notEmpty: {
                        message: 'Please give your comments'
                    }
                }
            },
            /* comment: {
             validators: {
             stringLength: {
             min: 10,
             max: 200,
             message:'Please enter at least 10 characters and no more than 200'
             },
             notEmpty: {
             message: 'Please give a description of your project'
             }
             }
             } */
        }
    })
            .on('success.form.bv', function (e) {
                $('#success_message').slideDown({opacity: "show"}, "slow") // Do something ...
                $('#contact_form').data('bootstrapValidator').resetForm();

                // Prevent form submission
                e.preventDefault();

                // Get the form instance
                var $form = $(e.target);

                // Get the BootstrapValidator instance
                var bv = $form.data('bootstrapValidator');

                // Use Ajax to submit form data
                $.post($form.attr('action'), $form.serialize(), function (result) {
                    console.log(result);
                }, 'json');
            });
			
});