(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';

		$('.delete-btn').on("click", function(){
			var id = $(this).attr("data-id");
			var conf = confirm("Press OK to confirm removal of this business.");
			if(conf){
				$(this).attr('disabled','disabled');
				window.location.href="/wp-admin/admin.php?page=wpbdf_remove_business_page&delid="+id;
			}
		});

		$('.edit-btn').on("click", function(){
			var id = $(this).attr("data-id");
			window.location.href="/wp-admin/admin.php?page=wpbdf_edit_business&id="+id;
		});

		$('.act-btn').on("click", function(){
			var id = $(this).attr("data-id");
			window.location.href="/wp-admin/admin.php?page=wpbdf_act_business&id="+id;
		});

		$('.deact-btn').on("click", function(){
			var id = $(this).attr("data-id");
			window.location.href="/wp-admin/admin.php?page=wpbdf_deact_business&id="+id;
		});

		$('#multi-select-option').on("change", function(){
			var actiontype = $(this).val();
			var ids = "";
			$( "[name=multi-check]" ).each(function( index ) {
			  if($(this).is(':checked')){
			  	ids+=$(this).val()+"|";
			  }
			});
			if(ids==""){
				alert("You must select some rows first.");
			}else{
				if(actiontype=="rem"){
					var conf = confirm("Press OK to confirm removal of selected businesses.");
					var actionurl = "/wp-admin/admin.php?page=wpbdf_remove_business_page&theids="+ids;
				}else if(actiontype=="enable"){
					conf = confirm("Press OK to confirm enabling of selected businesses.");
					actionurl = "/wp-admin/admin.php?page=wpbdf_act_business&theids="+ids;
				}else if(actiontype=="disable"){
					conf = confirm("Press OK to confirm disabling of selected businesses.");
					actionurl = "/wp-admin/admin.php?page=wpbdf_deact_business&theids="+ids;
				}
				if(conf){
					$('input[type=button],input[type=submit]').attr('disabled','disabled');
					window.location.href=actionurl;
				}
			}
		});

		
	});

		
})(jQuery, this);
