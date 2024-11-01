document.lastacthere=999;

(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';

		

		$('.delete-btn').on("click", function(){
			var id = $(this).attr("data-id");
			var conf = confirm("Press OK to confirm removal of this business.");
			if(conf){
				$(this).attr('disabled','disabled');
				window.location.href="/wp-admin/admin.php?page=wpbdf_remove_business_page&delid="+id;
			}else{
				$( '#act[value=1]').attr('selected',true);
				$( '#act').val(1);
				document.lastacthere=1;
			}
		});
		

		$('#getlonglat').on("click", function(){
			wpdbf_quickRetrieval()
		});

		if(document.autoget==true){wpdbf_quickRetrieval();}
		setTimeout(function(){if(document.autoget==true){wpdbf_quickRetrieval();} }, 1000);
		setTimeout(function(){if(document.autoget==true){wpdbf_quickRetrieval();} }, 2000);
		setTimeout(function(){if(document.autoget==true){wpdbf_quickRetrieval();} }, 3000);

		function wpdbf_quickRetrieval(){
			if(document.canmap){
				document.autoget=false;
				var address = $('#address').val();
				var postcode = $('#postcode').val();
				var country = $('#country').val();
				if(country=="" || postcode == "" || address == ""){
					$('.longlaterr').show();
				}else{
					$('.longlaterr').hide();
					wpdbf_getAddress(address,postcode,country);
				}
			}
		}

		$('#long,#lat').on('change',function(){
			if($('#long').val()!="" && $('#lat').val()!="" ){
				wpdbf_autoCheckPosition();
			}
		})


        $('[name=act]').on('change', function(e) {
          
          if( !$(this).is('input') ) {

	          if(this.value == 1){
	          	
	          
	          }else{

	          
	          }
	          
	      }else{

	      	if(this.checked) {

		        

		    }else{

		    

          	}

	      }
        });

		



		$('#business_form').submit(function() {
		

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


        });

		function wpdbf_autoCheckPosition(){
			var address = $('#address').val();
			var postcode = $('#postcode').val();
			var country = $('#country').val();
			var lat = $('#lat').val();
			var lng = $('#long').val();

			wpdbf_getAddress(address,postcode,country);

		}


		//Retrieve long and lat details
		function wpdbf_getAddress(address,postcode,country){
			var geocoder = new google.maps.Geocoder();
			geocoder.geocode({address: address+", "+postcode+", "+country}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					    var coords = results[0].geometry.location;

					    //if(coords.lat()!="")
					    	{$('#lat').val(coords.lat());}
						//if(coords.lng()!="")
							{$('#long').val(coords.lng());}
						var bounds = new google.maps.LatLngBounds();
					    var latlng = new google.maps.LatLng(coords.lat(),coords.lng());
					    wpdbf_createMarker(latlng,$('#name').val(),address+", "+postcode+", "+country);
					    bounds.extend(latlng);

					    // Don't zoom in too far on only one marker
					    if (bounds.getNorthEast().equals(bounds.getSouthWest())) {
					       var extendPoint1 = new google.maps.LatLng(bounds.getNorthEast().lat() + 0.0005, bounds.getNorthEast().lng() + 0.0005);
					       var extendPoint2 = new google.maps.LatLng(bounds.getNorthEast().lat() - 0.0005, bounds.getNorthEast().lng() - 0.0005);
					       bounds.extend(extendPoint1);
					       bounds.extend(extendPoint2);
					    }

					    map.fitBounds(bounds);
				} else {
					   if($('#long').val()!="" || $('#lat').val()!=""){
					   	$('.longlaterr.errorsmall').html("Could not detect the correct longitude / latitude co-ordinates from this address. Your current longitutde / latitude co-ordinates may therefore be incorrect. Please check address and click the \"Auto-fill long / lat\" button.");
					   }else{
					   	$('.longlaterr.errorsmall').html("Could not detect longitude / latitude co-ordinates from this address. Please check address and click the \"Auto-fill long / lat\" button.");					   	
					   }
					   $('.longlaterr.errorsmall').show();
				}
			});
		}
		

		function wpdbf_createMarker(latlng, name, address) {
		  var html = "<b>" + name + "</b> <br/>" + address;
		  wpdbf_clearMarker();
		  var marker = new google.maps.Marker({
		    map: map,
		    position: latlng
		  });
		  google.maps.event.addListener(marker, 'click', function() {
		    infoWindow.setContent(html);
		    infoWindow.open(map, marker);
		  });
		  markers.push(marker);
		}

		function wpdbf_clearMarker(){

		  for (var i = 0; i < markers.length; i++) {
		    markers[i].setMap(null);
		  }
		  markers.length = 0;
		}



		//if admin declines a new business, it needs to be removed. Force a delete button click
		$( "#act" ).click(function() {
		  if($(this).val() == -2 && document.lastacthere !=-2){
			$( '#act[value=-2]').attr('selected',true);
			document.lastacthere=-2;
			$( ".delete-btn" ).click();			
		  }else{
		  	document.lastacthere=$(this).val();
		  }
		});

		$('.decimal').keyup(function(){
		    var val = $(this).val();
		    if(isNaN(val)){
		         val = val.replace(/[^0-9\.]/g,'');
		         if(val.split('.').length>2) 
		             val =val.replace(/\.+$/,"");
		    }
		    $(this).val(val); 
		});
	});

		
})(jQuery, this);



/*function validate_business_form(){


				var cats = "";
	            jQuery.each(jQuery("input[name='cats[]']:checked"), function(){         
	                cats+="|"+jQuery(this).val();
	            });

	            jQuery('#cat').val(cats+"|");

	            alert(cats);

				var typs = "";
	            jQuery.each(jQuery("input[name='types[]']:checked"), function(){         
	                typs+="|"+jQuery(this).val();
	            });

	            jQuery('#typ').val(typs+"|");

	            alert(typ);


	            var social = "";
	            if(jQuery("#tw").val!=""){
	            	social+="|tw^"+jQuery("#tw").val();
	            }
	            if(jQuery("#fb").val!=""){
	            	social+="|fb^"+jQuery("#fb").val();
	            }
	            if(jQuery("#gp").val!=""){
	            	social+="|gp^"+jQuery("#gp").val();
	            }
	            if(jQuery("#li").val!=""){
	            	social+="|li^"+jQuery("#li").val();
	            }
	            if(jQuery("#in").val!=""){
	            	social+="|in^"+jQuery("#in").val();
	            }
	            if(jQuery("#yt").val!=""){
	            	social+="|yt^"+jQuery("#yt").val();
	            }

	            jQuery('#social').val(social);

	            return true;

}*/