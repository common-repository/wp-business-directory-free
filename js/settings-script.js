(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';

		$('#link_ownership').on("change", function(){
			if(!$(this).is(':checked')){
				$('#link_members').prop('checked', false);
				$('#link_members').prop('disabled', true);
			}else{

				$('#link_members').prop('disabled', false);
			}
		});


		$('#map').on("change", function(){
			if(!$(this).is(':checked')){
				$('#dir').prop('checked', false);
				$('#dir').prop('disabled', true);
			}else{
				$('#dir').prop('disabled', false);
			}
		});

		$('.payment_gateway').on("click", function(){
				var op = $(this).val();
				if ($(this).is(':checked')) {
					$('#'+op).show();
					wpdbf_forceRequirements(op);
				}else{
					$('#'+op).hide();
					wpdbf_forceRequirements("no"+op);

				}
		});
		
	});


	//onload, force select options check for payment type
	$('.payment_gateway').each(function () {
		var op = $(this).val();
		if($(this).is(':checked')){
			$('#'+op).show();
			wpdbf_forceRequirements(op);
		}else{
			$('#'+op).hide();
			wpdbf_forceRequirements("no"+op);
		}
	});

	function wpdbf_forceRequirements(op){
		if(op=="ppec"){
					
					$("#ppec_account").prop('required',true);
					/*$("#ppec_sandbox_id").prop('required',true);
					$("#ppec_production_id").prop('required',true);*/
		
					wpdbf_checkppec();

		}else if(op=="bt"){

					$("#bt_name").prop('required',true);
					$("#bt_iban").prop('required',true);
					$("#bt_acc").prop('required',true);

		}else if(op=="noppec"){

					$("#ppec_account").prop('required',false);
					$("#ppec_sandbox_id").prop('required',false);
					$("#ppec_production_id").prop('required',false);

					$('#ppec_status').unbind("change");

		}else if(op=="nobt"){

					$("#bt_name").prop('required',false);
					$("#bt_iban").prop('required',false);
					$("#bt_acc").prop('required',false);
		}
	}

	function wpdbf_checkppec(){
		$('#ppec_status').on("change",function(){
						if($(this).val()=="sandbox"){
							$("#ppec_sandbox_id").prop('required',true);
							$("#ppec_production_id").prop('required',false);
						}else if($(this).val()=="production"){
							$("#ppec_sandbox_id").prop('required',false);
							$("#ppec_production_id").prop('required',true);
						}
		});
	}

		
})(jQuery, this);

function wpdbf_validate(){
	if(document.getElementById("google_api").value=="" && document.getElementById("map").checked == true){
		alert("The Google Map system requires an API key");
		return false;
	}else{
		return true;
	}
}
