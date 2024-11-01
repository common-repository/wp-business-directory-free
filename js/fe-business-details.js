(function ($, root, undefined) {
	
	$(function () {

		document.btnpos="standard";
		resize();
		alignFooterContent();
		

		function resize(){
			window.addEventListener('resize', function(event){
				  alignFooterContent();
			});			
		}

		function alignFooterContent(){
			if($('.footer-content').length>0){
				if($(window).width() <= 840 && document.btnpos=="standard") {
					document.btnpos="moved";
					$('.footer-content').insertBefore('#footer-placemarker-bottom');
				}else if($(window).width() > 840 && document.btnpos=="moved"){
					document.btnpos="standard";
					$('.footer-content').insertBefore('#footer-placemarker-top');
				}
			}
		}

		
				
	});

		
})(jQuery, this);