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
                    stringLength: {
                        min: 2,
                    },
                    notEmpty: {
                        message: 'Please give your name'
                    }
                }
            },
            globallogic_eid: {
                validators: {
                    number: true,
                    number: {
                        message: 'Please give valid employee id'
                    },
                    notEmpty: {
                        message: 'Please give your Employee ID'
                    }
                }
            },
            designation: {
                validators: {
                    notEmpty: {
                        message: 'Please give your designation'
                    }
                }
            },
            process: {
                validators: {
                    notEmpty: {
                        message: 'Please give your process'
                    }

                }
            },
            doj: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Doj'
                    }
                }
            },
            supervisor_or_manager_name: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Supervisor / Manager Email'
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
            self_rating: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Self Rating'
                    },
                    min: 0,
                    max: 5
                }
            },
            key_pointers: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Key Pointers'
                    }
                }
            },
            self_rating1: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Self Rating'
                    }
                }
            },
            key_pointers1: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Key Pointers'
                    }
                }
            },
            self_rating2: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Self Rating'
                    }
                }
            },
            key_pointers2: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Key Pointers'
                    }
                }
            },
            self_rating3: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Self Rating'
                    }
                }
            },
            key_pointers3: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Key Pointers'
                    }
                }
            },
            self_rating4: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Self Rating'
                    }
                }
            },
            key_pointers4: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Key Pointers'
                    }
                }
            },
            self_rating5: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Self Rating'
                    }
                }
            },
            key_pointers5: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Key Pointers'
                    }
                }
            },
            self_rating6: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Self Rating'
                    }
                }
            },
            key_pointers6: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Key Pointers'
                    }
                }
            },
            self_rating7: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Self Rating'
                    }
                }
            },
            key_pointers7: {
                validators: {
                    notEmpty: {
                        message: 'Please give your Key Pointers'
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