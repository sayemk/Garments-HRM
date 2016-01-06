jQuery(document).ready(function($) {
	  $('form').validate({ 
        
        rules: {
            
            name: {
                required: true,
            },
            address: {
               required: true
            }
        },

    });
});