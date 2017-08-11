

	function checkTextError(obj){
		if($(obj).attr('data-error-text')){
			if($(obj).hasClass('chosen-select') || $(obj).hasClass('select2_demo_1')){
				
				$(obj).parent().find('.text-error').remove();
				$(obj).parent().find('.chosen-container').after('<div class="text-error text-left">'+$(obj).attr('data-error-text')+'</div>');
				
				$(obj).parent().find('.select2-selection--single').after('<div class="text-error text-left">'+$(obj).attr('data-error-text')+'</div>');
			}
			else
			if($(obj).attr('data-show-parent')){
				$(obj).parent().parent().find('.text-error').remove();
				$(obj).parent().after('<div class="text-error text-left">'+$(obj).attr('data-error-text')+'</div>');
			}
			else{
				$(obj).parent().find('.text-error').remove();
				$(obj).after('<div class="text-error text-left">'+$(obj).attr('data-error-text')+'</div>');	
			}
		}
	}
	// Globle validation method 
	ajaxRequestOn = false;
	function checkValidation(form_id){

		$(document).find('.error-border').removeClass('error-border');
		$(document).find('.text-error').remove();
		$(document).find('.text-success').remove();
		
		is_valid = true;

		
		var num = /^[0-9 ]+$/;
		var alpha = /^[a-zA-Z ]+$/;
		var alphanumers = /^[a-zA-Z0-9 ]+$/;
		var emailReg = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;



		// For input tpye fields
		$.each($('#'+form_id).find('input,textarea'), function(k,v){
			
			if($(this).hasClass('mandate')){

				validationType = $(this).attr('data-valid-type');

				var validationTypes = validationType.split(" "); 
				for(var i=0; i<= validationTypes.length; i++){

					// validation to check empty
					if(validationTypes[i]=='nEmpty'){

						if($(this).val()=='')
						{
							is_valid =  false;
							$(this).addClass('error-border');
							checkTextError(this);
						}
					}

					// validation to check only alpha
					if(validationTypes[i]=='alpha'){

						if(!alpha.test($(this).val()))
						{
							is_valid =  false;
							$(this).addClass('error-border');
							checkTextError(this);
						}
					}

					// validation only for number
					if(validationTypes[i]=='num'){

						if(!num.test($(this).val()))
						{
							is_valid =  false;
							$(this).addClass('error-border');
							checkTextError(this);
						}

					}

					// validation only for email
					if(validationTypes[i]=='email'){

						if(!emailReg.test($(this).val()))
						{
							is_valid =  false;
							$(this).addClass('error-border');
							checkTextError(this);
						}
					}

					if(validationTypes[i]=='length'){

						length = $(this).attr('data-length-value');
						
						if(length!=null){
							if($(this).val().length!=length)
							{
								is_valid =  false;
								$(this).addClass('error-border');

								checkTextError(this);
								
							}
						}
					}

					if(validationTypes[i]=='max'){

						max = $(this).attr('data-max-value');
						
						if(max!=null){
							
							if(eval($(this).val()) > eval(max))
							{
								is_valid =  false;
								$(this).addClass('error-border');
								checkTextError(this);
							}
						}
					}
					if(validationTypes[i]=='min'){

						min = $(this).attr('data-min-value');
						
						if(min!=null){
							if(eval($(this).val()) < eval(min))
							{
								is_valid =  false;
								$(this).addClass('error-border');
								checkTextError(this);
							}
						}
					}

				}
				
			}
		});

		// For select tpye fields
		$.each($('#'+form_id).find('select'), function(k,v){
			
			if($(this).hasClass('mandate')){

				validationType = $(this).attr('data-valid-type');
				// Validation to check empty
				if(validationType=='nEmpty'){

					if($(this).val()=='')
					{
						is_valid =  false;
						$(this).addClass('error-border');
						checkTextError(this);
					}
				}
			}

		});
		return is_valid;
	}

	$(document).on('click','input,select, .chosen-container, .select2-selection--single', function(){
		$(this).removeClass('error-border');
		$(this).parent().find('.text-error').remove();
		$(this).parent().find('.text-error').remove();
		
	});

	
