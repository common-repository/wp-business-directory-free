(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';
		$.ajaxSetup({ cache: false });


		$('#wpbdf-form').on("submit",function(e){

			$('#loc_err').html("");


			if(document.canDistance){
				
				if( document.getElementById('_tcp').value!="" && (document.getElementById('_lng').value=="" ||  document.getElementById('_lat').value=="")){
					e.preventDefault();
					$('#wpbdf-search').prop('value', "Searching");
					$('#wpbdf-search').prop("disabled","true");
					//get long lat
					wpdbf_searchLocations(document.getElementById('_tcp').value,document.getElementById('_country').value);
				}

			}
		});

		$('#_tcp,#_country').on("focus blur change",function(){
			wpdbf_checkDistanceAccess();			
		});

		$('#_country').on("change",function(){
			if(this.value==""){
				$("#_country").attr("required", false);
				$('#_tcp').val("");
				$('#_tcp').attr("disabled",true);
				$('#_tcp').attr("placeholder", $('#_tcp').attr("data-orgwithout") );
			}else{
				$('#_tcp').attr("disabled",false);
				$('#_tcp').attr("placeholder", $('#_tcp').attr("data-orgwith") );
			}
		});

		$('#_tcp').on("focus blur change",function(){
			if($(this).val()!=""){
				$("#_country").attr("required", true);
			}else{
				$("#_country").attr("required", false);
			}
		});

		$('.business').on("click",function(e){
			if(e.target.nodeName!="a"){
				var id = $(this).attr("data-id");
				$('.business').unbind("click");
				document.querySelector("#view_bus_"+id).click();
			}
			
		});

		

		function wpdbf_checkDistanceAccess(){
			if(document.canDistance){
				if($('#_tcp').val()=="" || $('#_country').val()==""){
					$('#_radius').prop('disabled', true);
					$("#_order option[value='distance']").prop("disabled",true);
					if($("#_order").val()=='distance') {$('#_order option:first-child').attr("selected", "selected");}
				}else{				
					$('#_radius').prop('disabled', false);
					$("#_order option[value='distance']").prop("disabled",false);
				}
			}
		}
		

		function wpdbf_searchLocations(_tcp,_country) {

				var lng=0;
				var lat=0;
				//Check we haven't already got this long and lat - if we do we don't need to use our GM quoter
				var data = {
					'action': 'checkLongLat',
					'_tcp': _tcp,
					'_country': _country
				};

				jQuery.post(ajaxurl, data, function(response) {
					  var longlat = $.parseJSON(response);
					  if(longlat.ok=="1"){
					  	//recycling
						document.getElementById('_lng').value = longlat.lng;
						document.getElementById('_lat').value = longlat.lat;
						$('#wpbdf-form').submit();
					  }else{
					  	//not found - use Google to get details
					  	wpdbf_getLongLatFromGoogle(_tcp,_country);
					  }			  

				});


		}

		//Didn't find long/lat in our db, so let's use Google to get the details
		//Note - where may not be just where. It depends what the user has entered
		function wpdbf_getLongLatFromGoogle(_tcp,_country) {
			if(document.canDistance){
				var geocoder = new google.maps.Geocoder();
				geocoder.geocode({address: _tcp+" "+_country}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						  var coords = results[0].geometry.location;
						  document.getElementById('_lng').value = coords.lng();
						  document.getElementById('_lat').value = coords.lat();
						  document.getElementById('_save_longlat').value = 1;					  
						  	$('#wpbdf-form').submit();
					}else {				
						$('#businesses').html("");	  
						if(document.canMap){
							$('#map-container .message').fadeIn("fast");
						  	$('#map-container .message .msg').html(document.location_not_found_message);
							$('#wait').fadeOut("fast");
						}else{
							$('#loc_err').html(document.location_not_found_message);
						}
					}
				});
			}
		}


		function wpdbf_noResultsMessage(){
			$('#map-container .message').fadeIn("fast");
			$('#map-container .message .msg').html(document.location_not_found_message);
			$('#wait').fadeOut("fast");
		}
		if(document.numresults==0){
			wpdbf_noResultsMessage();
		}

		wpdbf_setMapPoints();
		function wpdbf_setMapPoints() {

			if(typeof google !== 'undefined'){

				if(document.map_array=="" || document.map_array!=null & document.map_array!=undefined && document.map_array!="undefined"){
					
					//console.log(document.map_array);
			    
			    	wpdbf_clearLocations();

			    	$('#wait').show();

					var bounds = new google.maps.LatLngBounds();

					var data = document.map_array;

					if(data.length>0){

							for (var i = 0; i < data.length; ++i) {

									var name = data[i].name;
								    var address = data[i].address;
								    if(data[i].postcode!=""){
								    	address=address+","+data[i].postcode;
								    }
								    if(data[i].country!=""){
								    	address=address+","+data[i].country;
								    }
								    address = address.replace(/,/g, ',<br>'); 
								    var distance = parseFloat(data[i].distance);
								    var latlng = new google.maps.LatLng(
								        parseFloat(data[i].lat),
								        parseFloat(data[i].lng)
								    );
								    var returnedtyp = data[i].typ;
								    var returnedtyp = returnedtyp.replace(/\|/g, ', ');

								    var id = data[i].id;
								    var where = _tcp;
								    if(where==""){
								    	where = _country;
								    }else{
								    	where = where + " "+_country;
								    }
								    wpdbf_createOption(name, distance, i);
								    var smalldist = distance.toFixed(1);
								    var ds="";
								    var feature = data[i].feature;
								    if(smalldist!=NaN && !isNaN(smalldist) && smalldist!="NaN" && smalldist!="" && smalldist!=null){
								    	ds = "<em style='margin-top:5px;font-size:0.9em;color:#999;'>"+smalldist+" miles from location</em>";
								    }
								    wpdbf_createMarker(latlng, "<span style='font-weight:bold;'>"+name+"</span><br>"+ds+"<br><span style='margin-top:5px;display:block;'>"+address+"</span>",name,feature);
								    bounds.extend(latlng);
								    map_wpbdf.fitBounds(bounds);
								    var letter = ""+(labelIndex);
						    }

							$('#wait').fadeOut("fast");

					}else{
							//We've done everything we can. Fail...
							$('#map-container .message').fadeIn("fast");
						  	$('#map-container .message .msg').html(document.business_not_found_message);
							$('#wait').fadeOut("fast");
					}
		  

				}

			}else{
				//window.setTimeout("function(){wpdbf_setMapPoints();}",500);
			}

		}


		function wpdbf_createMarker(latlng, html,name,feature) {
	      labelIndex=labelIndex+1;
		  var html = html;
		  var mtc = document.MapTextColour;
		  var icn = document.MapIconBase;
		  if(feature==1){
		  	mtc = document.MapTextColourFeature;
		  	icn = document.MapIconBaseFeature;
		  }

		  var marker = new google.maps.Marker({
		    map: map_wpbdf,
		    position: latlng,
  			icon: icn,
  			label: {text: ""+labelIndex, color: mtc, weight:"bold"},  
		  });

		  google.maps.event.addListener(marker, 'click', function() {
		    infoWindow.setContent(html);
		    infoWindow.open(map_wpbdf, marker);
		  });
		  markers.push(marker);
		}

		function wpdbf_createOption(name, distance, num) {
		  var option = document.createElement("option");
		  option.value = num;
		  option.innerHTML = name + "(" + distance.toFixed(1) + ")";
		}

		function wpdbf_clearLocations() {
			if(infoWindow){
			  infoWindow.close();
			  for (var i = 0; i < markers.length; i++) {
			    markers[i].setMap(null);
			  }
			  markers.length = 0;

			  labelIndex = 0;
			}

		}

		$('#exit-btn').on("click",function(){
			$('#map-container .message').fadeOut("fast");
		});

		$('.adv-btn').on("click",function(){
			if($('.advanced').is(':visible')){
				$('.advanced').slideUp("200");
				$('.adv-btn').html($(this).attr("data-show-txt"));
			}else{
				$('.advanced').slideDown("200");
				$('.adv-btn').html($(this).attr("data-hide-txt"));
			}
		});
				
	});

		
})(jQuery, this);