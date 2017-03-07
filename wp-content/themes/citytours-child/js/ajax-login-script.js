jQuery(document).ready(function($) {

    // Show the login dialog box on click
    $('a#show_login').on('click', function(e){
        $('body').prepend('<div class="login_overlay"></div>');
        $('form#login').fadeIn(500);
        $('div.login_overlay, form#login a.close').on('click', function(){
            $('div.login_overlay').remove();
            $('form#login').hide();
        });
        e.preventDefault();
    });
	
	$('a#forgot_pw').on('click', function(e){
		$('form.loginform').hide();
		$('form#forgot_password').show();
	});
	$('a#login_popup').on('click', function(e){
		$('form#forgot_password').hide();
		$('form.loginform').show();		
	});
	
	

    // Perform AJAX login on form submit
    $('form.loginform').on('submit', function(e){
        $('form.loginform p.status').show().text(ajax_login_object.loadingmessage);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: { 
                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'username': $('form.loginform #username').val(), 
                'password': $('form.loginform #password').val(), 
                'security': $('form.loginform #security').val() },
            success: function(data){				
                $('form.loginform p.status').text(data.message);
                if (data.loggedin == true){
                    document.location.href = ajax_login_object.redirecturl;
                }
            }
        });
        e.preventDefault();
    });
	
	$('form#forgot_password').on('submit', function(e){
		if (!$(this).valid()) return false;
		$('form#forgot_password p.status', this).show().text(ajax_login_object.loadingmessage);
		ctrl = $(this);
		$.ajax({
			type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
			data: { 
				'action': 'ajaxforgotpassword', 
				'user_login': $('#user_login').val(), 
				'security': $('#forgotsecurity').val(), 
			},
			success: function(data){					
				$('p.status',ctrl).text(data.message);				
			}
		});
		e.preventDefault();
		return false;
	});

	// Client side form validation
    if(jQuery('#forgot_password').length)
		jQuery('#forgot_password').validate();

});