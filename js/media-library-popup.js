/*document.set_to_post_id = null;*/ //If you're having privilege issues uploading new images to media library, try changing this id to 1, 10, 100...or any other number


document._container = null;
document._input = null;
document._delbtn = null;
document._response = null;
document._id = null;


(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';


		// Uploading files
		var file_frame;
		var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id


		//selecting thumbnails
		$('#logo_selector_button').on('click', function( e ){

		    //e.preventDefault();
		    wpdbf_setVals('.thumbnail_container','#business_logo','#logo_remove_button');
		    wpdbf_openMedia();

		});
		//Selecting images
		$('#image_1_selector_button').on('click', function( e ){

		    //e.preventDefault();
		    wpdbf_setVals('.image_1_thumbnail_container','#business_image_1','#image_1_remove_button');
		    wpdbf_openMedia();

		});
		$('#image_2_selector_button').on('click', function( e ){

		    e.preventDefault();
		    wpdbf_setVals('.image_2_thumbnail_container','#business_image_2','#image_2_remove_button');
		    wpdbf_openMedia();

		});
		$('#image_3_selector_button').on('click', function( e ){

		    e.preventDefault();
		    wpdbf_setVals('.image_3_thumbnail_container','#business_image_3','#image_3_remove_button');
		    wpdbf_openMedia();

		});
		$('#image_4_selector_button').on('click', function( e ){

		    e.preventDefault();
		    wpdbf_setVals('.image_4_thumbnail_container','#business_image_4','#image_4_remove_button');
		    wpdbf_openMedia();

		});
		$('#image_5_selector_button').on('click', function( e ){

		    e.preventDefault();
		    wpdbf_setVals('.image_5_thumbnail_container','#business_image_5','#image_5_remove_button');
		    wpdbf_openMedia();

		});

		function wpdbf_setVals(_container,_input,_delbtn){
			document._container = _container;
			document._input = _input;
			document._delbtn = _delbtn;
		}


		jQuery('#logo_remove_button').on('click', function( event ){
		    event.preventDefault();
		   jQuery('#business_logo').val("0");
		   var def = jQuery(this).attr("data-default");
		   jQuery('.thumbnail_container').html("<img src='"+def+"' data-default='"+def+"'>");
		   jQuery('#logo_remove_button').hide();
		});
		jQuery('#image_1_remove_button').on('click', function( event ){
		    event.preventDefault();
		   jQuery('#business_image_1').val("");
		   var def = jQuery(this).attr("data-default");
		   jQuery('.image_1_thumbnail_container').html("<img src='"+def+"' data-default='"+def+"'>");
		   jQuery('#image_1_remove_button').hide();
		});
		jQuery('#image_2_remove_button').on('click', function( event ){
		    event.preventDefault();
		   jQuery('#business_image_2').val("");
		   var def = jQuery(this).attr("data-default");
		   jQuery('.image_2_thumbnail_container').html("<img src='"+def+"' data-default='"+def+"'>");
		   jQuery('#image_2_remove_button').hide();

		});
		jQuery('#image_3_remove_button').on('click', function( event ){
		    event.preventDefault();
		   jQuery('#business_image_3').val("");
		   var def = jQuery(this).attr("data-default");
		   jQuery('.image_3_thumbnail_container').html("<img src='"+def+"' data-default='"+def+"'>");
		   jQuery('#image_3_remove_button').hide();

		});
		jQuery('#image_4_remove_button').on('click', function( event ){
		    event.preventDefault();
		   jQuery('#business_image_4').val("");
		   var def = jQuery(this).attr("data-default");
		   jQuery('.image_4_thumbnail_container').html("<img src='"+def+"' data-default='"+def+"'>");
		   jQuery('#image_4_remove_button').hide();

		});
		jQuery('#image_5_remove_button').on('click', function( event ){
		    event.preventDefault();
		   $('#business_image_5').val("");
		   var def = jQuery(this).attr("data-default");
		   jQuery('.image_5_thumbnail_container').html("<img src='"+def+"' data-default='"+def+"'>");
		   $('#image_5_remove_button').hide();

		});


		function wpdbf_openMedia(){//event){
			//event.preventDefault();
			// If the media frame already exists, reopen it.
		    if ( file_frame ) {
		      // Set the post ID to what we want
		      file_frame.uploader.uploader.param( 'post_id', document.set_to_post_id );
		      // Open frame
		      file_frame.open();
		      return;
		    } else {
		      // Set the wp.media post id so the uploader grabs the ID we want when initialised
		      wp.media.model.settings.post.id = document.set_to_post_id;
		    }

		    // Create the media frame.
		    file_frame = wp.media.frames.file_frame = wp.media({
		      title: jQuery( this ).data( 'uploader_title' ),
		      button: {
		        text: jQuery( this ).data( 'uploader_button_text' ),
		      },
		      multiple: true
		    });

		    // When an image is selected, run a callback.
		    file_frame.on( 'select', function() {

		      // We set multiple to false so only get one image from the uploader
		      //attachment = file_frame.state().get('selection').first().toJSON();
		      var selection = file_frame.state().get('selection');

			  selection.map( function( attachment ) {

			      attachment = attachment.toJSON();

			      wpdbf_createThumbnail(attachment.id);

			  });
			  	      
		      // Restore the main post ID
		      wp.media.model.settings.post.id = wp_media_post_id;

		    });

		    // Finally, open the modal
		    file_frame.open();

		}


		function wpdbf_createThumbnail(_id){

			      var data = {

						'action': 'get_business_image',

						'id': _id

					};

					// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
					jQuery.post(ajaxurl, data, function(response) {

						if(response) {
							wpdbf_updateImageShow(_id,response);

						}

					});
		   

		}

		  function wpdbf_updateImageShow(_id,_response){
		  		$(document._input).val(_id);
				$(document._container).html(_response); 
				$(document._delbtn).show();
				document._container = null;
		    	document._input = null;
		    	document._delbtn = null;
		  }

		  
		  // Restore the main ID when the add media button is pressed
		  jQuery('a.add_media').on('click', function() {
		   // wp.media.model.settings.post.id = wp_media_post_id;
		  });


		  //piggyback this js with some additional requirements


			
	});
	
})(jQuery, this);

		  //also piggyback a force delete call in edit page
          function wpdbf_forceconfdel(){
                jQuery('#wpbdf_delete_form').submit();
          }