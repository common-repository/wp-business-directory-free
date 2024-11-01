


(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';

        $('.library_remover_button').on("click",function(){
            var id = $(this).attr("data-img-id");
             $('#img_'+id).val("");
            $('.image_'+id+'_thumbnail_container').html('<img src="'+document.defaultImage+'" class="default-image" />');
            $(this).parent().find("img").removeClass("transparent_class");
            $(this).css("display","none");
        });

        $('#logo_remove_button').on("click",function(){
            $('#logoid').val("");
            $('#img_file_view').html('<img src="'+document.defaultImage+'"  class="default-image" />');
            $(this).parent().find("img").removeClass("transparent_class");
            $(this).css("display","none");
        });

        if($('#cancel-btn').length>0){
          $('#cancel-btn').on("click",function(){
            if(document.cancelurl!=""){
              window.location.href=document.cancelurl;
            }else{
              window.location.href="./";
            }
          });
        }

        $('.decimal').keyup(function(){
          var val = $(this).val();
          if(isNaN(val)){
               val = val.replace(/[^0-9\.]/g,'');
               if(val.split('.').length>2) 
                   val =val.replace(/\.+$/,"");
          }
          $(this).val(val); 
      });​


        $('#img_file,#img_file_1,#img_file_2,#img_file_3,#img_file_4,#img_file_5').on('change', function () {
            var par = $(this).parent();
            var has_selected_file = $(this).filter(function(){
                return $.trim(this.value) != ''
            }).length  > 0 ;

            if (has_selected_file) { 
               var imgsel = par.find("img");
               var fileExtension = ['jpeg', 'jpg', 'png', 'gif'];
                if ($(this).val()!="" && $.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                    alert("Invalid file format.\nPlease use one of the following image types:\n"+fileExtension.join(', '));
                    $(this).val("");
                    imgsel.attr('src', document.defaultImage);
                }else{                 
                  imgsel.attr('src', document.defaultUploadedImage);
                }
            }else{
                var img = par.find("img");
                img.addClass("transparent_class");
            }
        });




		$('#business_form').submit(function( e ) {


                  var ext = $('#img_file').val().split('.').pop().toLowerCase();
                  var ext1 = $('#img_file_1').val().split('.').pop().toLowerCase();
                  var ext2 = $('#img_file_2').val().split('.').pop().toLowerCase();
                  var ext3 = $('#img_file_3').val().split('.').pop().toLowerCase();
                  var ext4 = $('#img_file_4').val().split('.').pop().toLowerCase();
                  var ext5 = $('#img_file_5').val().split('.').pop().toLowerCase();
                  if(ext!="" && $.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
                        alert('Invalid image format on logo.');
                        e.preventDefault();
                  }else if(ext1!="" && $.inArray(ext1, ['gif','png','jpg','jpeg']) == -1) {
                        alert('Invalid image format (image 1).');
                        e.preventDefault();
                  }else if(ext2!="" && $.inArray(ext2, ['gif','png','jpg','jpeg']) == -1) {
                        alert('Invalid image format (image 2).');
                        e.preventDefault();
                  }else if(ext3!="" && $.inArray(ext3, ['gif','png','jpg','jpeg']) == -1) {
                        alert('Invalid image format (image 3).');
                        e.preventDefault();
                  }else if(ext4!="" && $.inArray(ext4, ['gif','png','jpg','jpeg']) == -1) {
                        alert('Invalid image format (image 4).');
                        e.preventDefault();
                  }else if(ext5!="" && $.inArray(ext5, ['gif','png','jpg','jpeg']) == -1) {
                        alert('Invalid image format (image 5).');
                        e.preventDefault();
                  }else{

                        $('#submit').attr("disabled","disabled");
                        var orgtext = $('#submit').val();
                        $('#submit').val("Please wait...");

            		    var cats = "";
                        $.each($("input[name='cats[]']:checked"), function(){         
                            cats+="|"+$(this).val();
                        });

                        $('#cat').val(cats+"|");

            			var typs = "";
                        $.each($("input[name='types[]']:checked"), function(){         
                            typs+="|"+$(this).val();
                        });

                        $('#typ').val(typs+"|");


                        var social = "";
                        if($("#tw").val!=""){
                        	social+="|tw^"+$("#tw").val();
                        }
                        if($("#fb").val!=""){
                        	social+="|fb^"+$("#fb").val();
                        }
                        if($("#gp").val!=""){
                        	social+="|gp^"+$("#gp").val();
                        }
                        if($("#li").val!=""){
                        	social+="|li^"+$("#li").val();
                        }
                        if($("#in").val!=""){
                        	social+="|in^"+$("#in").val();
                        }
                        if($("#yt").val!=""){
                        	social+="|yt^"+$("#yt").val();
                        }

                        $('#social').val(social);
                  }

		});

    var dateToday = new Date(); 			

		
	});


		
})(jQuery, this);
