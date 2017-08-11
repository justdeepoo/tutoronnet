$.fn.ForceNumericOnly =function()
{
    return this.each(function()
    {
        $(this).keydown(function(e)
        {
            var key = e.charCode || e.keyCode || 0;
            // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
            // home, end, period, and numpad decimal
            return (
                key == 8 || 
                key == 9 ||
                key == 13 ||
                key == 46 ||
                key == 110 ||
                key == 190 ||
                (key >= 35 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
        });
    });
};

$(function(){
	
	var set = {};
	signup = false;
	set.btn_spin_html = '<img class="wait-loader" src="/skin/gyan/images/svg-icons/ring-alt.svg" width="25px">' ;
	ajaxRequestOn = false;
	first = true;

	function showSuccessNotification(message){
		setTimeout(function() {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 2000
        };
        toastr.success(message, 'Alert');

    }, 100);
	}
	

	$(document).on('submit','form[name="signup-form"]', function(e){	
		$(this).removeClass('error-border');
		$(this).parent().find('.text-error').remove();

		e.preventDefault();
		if(ajaxRequestOn == true)
		 	return false;
		
		if(checkValidation('signup-form')){

			$btn = $(this).find('button[type="submit"]');
	        btn_text = $btn.html();
	        $btn.html(set.btn_spin_html);
			
			

			ajaxRequestOn = true;

			$.ajax({
				type:'post',
				dataType:'json',
				url:'/secure/signup/',
				data:$(this).serialize(),
				complete:function(){
					ajaxRequestOn = false;

					$btn.html(btn_text);
				},
				error:function(){
					ajaxRequestOn = false;

					$btn.html(btn_text);
				},
				success:function(response){

					

					if(response.status!=200){

						if(response.status==201)
						{
							response = response.response;
							$.each(response, function(k,v){
								$('#'+k).addClass('error-border');
								if(v!=true){
									
									if($('#'+k).attr('data-show-parent')){
										$('#'+k).parent().parent().find('.text-error').remove();
										$('#'+k).parent().after('<div class="text-error text-left">'+v+'</div>');
									}
									else{
										$('#'+k).parent().find('.text-error').remove();
										$('#'+k).after('<div class="text-error text-left">'+v+'</div>');	
									}
									
								}
							});
						}
						if(response.status==203)
						{
							var error_messages = response.response.missing_keys;
							$.each(error_messages, function(k,v){
								$('#'+v.field_name).parent().append('<span class="text-error">'+v.error+'</span>');
							});
						}
					}
					else{

						//showSuccessNotification('Success! Your mobile has been verified successfully.');
						//location.reload();
						window.location = response.redirect_url;

					}
				}
			})
		}
	});

	$(document).on('submit','form[name="login-form"]', function(e){	
		$(this).removeClass('error-border');
		$(this).parent().find('.text-error').remove();

		e.preventDefault();
		if(ajaxRequestOn == true)
		 	return false;
		
		if(checkValidation('login-form')){

			$btn = $(this).find('button[type="submit"]');
	        btn_text = $btn.html();
	        $btn.html(set.btn_spin_html);
			
			

			ajaxRequestOn = true;

			$.ajax({
				type:'post',
				dataType:'json',
				url:'/secure/login/',
				data:$(this).serialize(),
				complete:function(){
					ajaxRequestOn = false;

					$btn.html(btn_text);
				},
				error:function(){
					ajaxRequestOn = false;

					$btn.html(btn_text);
				},
				success:function(response){

					if(response.status!=200){

						if(response.status==201)
						{
							response = response.response;
							$.each(response, function(k,v){
								$('#'+k).addClass('error-border');
								if(v!=true){
									
									if($('#'+k).attr('data-show-parent')){
										$('#'+k).parent().parent().find('.text-error').remove();
										$('#'+k).parent().after('<div class="text-error text-left">'+v+'</div>');
									}
									else{
										$('#'+k).parent().find('.text-error').remove();
										$('#'+k).after('<div class="text-error text-left">'+v+'</div>');	
									}
									
								}
							});
						}
						if(response.status==203)
						{
							var error_messages = response.response;
							$(document).find('.alert').removeClass('hide').addClass('alert-danger').html(error_messages);
							
							
						}
					}
					else{

						//showSuccessNotification('Success! Your mobile has been verified successfully.');
						//location.reload();
						window.location = response.redirect_url;

					}
				}
			})
		}
	});

	$(document).on('submit','form[name="question-form"]', function(e){	
		$(this).removeClass('error-border');
		$(this).parent().find('.text-error').remove();

		e.preventDefault();
		if(ajaxRequestOn == true)
		 	return false;


		
		if(checkValidation('question-form')){

			var formData = new FormData($(this)[0]);
            $btn = $(this).find('button[type="submit"]');
            var btn_text = $btn.html();
            $btn.html(set.btn_spin_html);
            
           

            ajaxRequestOn = true;

			$.ajax({
				
				url:'/secure/post_question/',
				data: formData,
                type: 'POST',
                dataType:'json',
                // THIS MUST BE DONE FOR FILE UPLOADING
                async: false,
                cache: false,
                contentType: false,
                processData: false,
				complete:function(){
					ajaxRequestOn = false;
					$btn.html(btn_text);
				},
				error:function(){
					ajaxRequestOn = false;

					$btn.html(btn_text);
				},
				success:function(response){

					if(response.status!=200){

						if(response.status==201)
						{
							if(response.validation_error)
							{
								response = response.response;
								$.each(response, function(k,v){
									$('#'+k).addClass('error-border');
									if(v!=true){
										
										if($('#'+k).attr('data-show-parent')){
											$('#'+k).parent().parent().find('.text-error').remove();
											$('#'+k).parent().after('<div class="text-error text-left">'+v+'</div>');
										}
										else{
											$('#'+k).parent().find('.text-error').remove();
											$('#'+k).after('<div class="text-error text-left">'+v+'</div>');	
										}
										
									}
								});
							}
						}
						if(response.status==203)
						{
							var error_messages = response.response;
							$(document).find('.alert').removeClass('hide').addClass('alert-danger').html(error_messages);
							
							
						}
					}
					else{

						
						location.reload();   

					}
				}
			})
		}
	});

	

	
	


});