
		

		function wpdbf_previewData(typ){

	        var subject = document.getElementById("email_subject_"+typ).value;
	        subject = subject.replace(/</g, "&lt;");
	        subject = subject.replace(/>/g, "&gt;");
	        subject = subject.replace(/\n/g, "");
	        
	        var html = document.getElementById("email_type_"+typ).value;

	        var message = document.getElementById("email_message_"+typ).value;
	        message = message.replace(/[<br>]+$/, '<br>');
	        if(html==1){
	            message = message.replace(/\n/g, "<br>");
	        }else if(html==0){
	            message = message.replace(/<BR>/g, "&lt;br&gt;");
	            message = message.replace(/<br>/g, "&lt;br&gt;");
	            message = message.replace(/</g, "&lt;");
	            message = message.replace(/>/g, "&gt;");
	            message = message.replace(/\n/g, "<br>");
	        }
	        
	        var email_msg = "<div class='email_msg'>"+message+"</div>";
	        jQuery('#email-preview').html("<div class='email_subject'>Subject: "+subject+"</div><div class='email_msg'>"+message+"</div><div class='preview-btn-container'><input type='button' value='Close Preview' id='close-preview-btn' class='button' /></div>");
	        jQuery('#email-preview-container').show("fast");
	        jQuery('#email-preview').show("fast");
	        jQuery('#close-preview-btn').on("click",function(){
	        	jQuery('#email-preview-container').hide("fast");
	        	jQuery('#email-preview').hide("fast");
	        	jQuery('#email-preview').html("");
	        	jQuery('#close-preview-btn').unbind("click");
	        	jQuery('#email-preview-container').unbind("click");
	        });
	        jQuery('#email-preview-container').on("click",function(){
	        	jQuery('#email-preview-container').hide("fast");
	        	jQuery('#email-preview').hide("fast");
	        	jQuery('#close-preview-btn').unbind("click");
	        	jQuery('#email-preview-container').unbind("click");
	        	jQuery('#email-preview').html("");
	        });

	    }

		
		

