$(document).ready(function(){
	$("#submit").click(function(){					   				   
		$(".error").hide();
		var hasError = false;
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		
		var emailToVal = $("#emailTo").val();
		if(emailToVal == '') {
			$("#emailTo").after('<span class="error">You forgot to enter the email address to send to.</span>');
			hasError = true;
		} else if(!emailReg.test(emailToVal)) {	
			$("#emailTo").after('<span class="error">Enter a valid email address to send to.</span>');
			hasError = true;
		}
		
		var businessVal = $("#business-name").val();
		if(businessVal == '') {
			$("#business-name").after('<span class="error">Please enter your business name.</span>');
			hasError = true;
		}
		
		var nameVal = $("#contact-name").val();
		if(nameVal == '') {
			$("#contact-name").after('<span class="error">Please enter your name.</span>');
			hasError = true;
		}
		
		var addressVal = $("#business-address").val();
		if(addressVal == '') {
			$("#business-address").after('<span class="error">Please enter your address.</span>');
			hasError = true;
		}
		
		var emailFromVal = $("#business-email").val();
		if(emailFromVal == '') {
			$("#business-email").after('<span class="error">Please enter your email address so we may contact you.</span>');
			hasError = true;
		} else if(!emailReg.test(emailFromVal)) {	
			$("#business-email").after('<span class="error">Please enter a valid email address.</span>');
			hasError = true;
		}
		
		var licenseVal = $("#business-license").val();
		if(licenseVal == '') {
			$("#business-license").after('<span class="error">Please enter your License number.</span>');
			hasError = true;
		}
		
		var urlVal = $("#business-url").val();
		
		if(hasError == false) {
			$(this).hide();
			$("#sendEmail td.buttons").append('<img src="'+BASE_HREF+'_css/img/loading.gif" alt="Loading" id="loading" />');
			
			var newMessage = '::Business name::    '+businessVal+'\n';
			newMessage += '::Contact name::    '+nameVal+'\n';
			newMessage += '::Address::    '+addressVal+'\n';
			newMessage += '::Resale license::    '+licenseVal+'\n';
			
			var newHTMLMessage = 'Business name: '+businessVal+'<br/>';
			
			if(urlVal) {
				newMessage += '\n::Website::    '+urlVal;
			}
			
			$.post("_includes/sendemail.php",
   				{ emailTo: emailToVal, fromName: nameVal, emailFrom: emailFromVal, subject: 'Wholesale Information Request from:: '+businessVal, message: newMessage },
   					function(data){
						$("#page_content").slideUp("normal")
						$("#sendEmail").slideUp("normal", function() {				   
							
							$("#sendEmail").before('<h3>What to Expect Next:</h3><p>Thank you for your interest in opening a Thirsties Wholesale Account! We have received your initial application.</p><p>We will verify your Tax ID resale license. Please note, this is not the same as an EIN. If you have provided your EIN number rather than a state issued business number or resale Tax ID, we cannot proceed any further with your application. Please resubmit with the proper information Next we will look to see that you have a personally hosted,  fully-activated website or a brick and mortar location. So long as these first steps check out, you will hear back from us via email within 2-3 days.</p><p>Thanks again for your interest!</p>');											
						});
   					}
				 );
		}
		
		return false;
	});						   
});