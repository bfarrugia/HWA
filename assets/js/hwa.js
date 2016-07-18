$(function () {
    // Create JS object for page setup as needed
    hwa = {
        init: function(){
            // If correct form in place, initialize registration
            if($('#user_registration_form').length){
                this.registration.init();
            }
        },
        registration: {
            init: function(){
                // Utilize Parsley.JS library for client-side validation
                window.Parsley.addValidator('zipCode',{
                    requirementType: 'regexp',
                    validateString: function(val, req){
                        var matches = val.match(req);
                        if(matches && matches.length){
                            if(val.indexOf('-') > 0)
                                return matches[0].length == 10;
                            return matches[0].length == 5;
                        }
                        return false;
                    },
                    messages: {
                        en: 'ZIP code must be 5 or 9 digits'
                    }
                });

                // Add a fancy dash with the ZIP code
                $('#zip').on('keyup', function(){
                    var val = $(this).val();
                    if(val.length > 5){
                        if(val.indexOf('-') < 0){
                            val = val.slice(0,5) + '-' + val.slice(5, val.length);
                        }

                        $(this).val(val);
                    }
                }).on('change', function(){
                    var val = $(this).val();
                    if(val.length == 6 && val.indexOf('-') > 0){
                        val = val.replace('-','');
                    }
                });

                // Initialize validators
                $('#user_registration_form').parsley();
            }
        }
    };

    $(document).ready(function(){
        hwa.init();
    });
});