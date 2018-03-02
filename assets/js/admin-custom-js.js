jQuery(document).ready(function(){
	jQuery("#app-api-save").click(function(event){
		event.preventDefault();
		var facebook_app_id = jQuery("#inputFacebookappid").val();
		var facebook_app_scret =jQuery("#inputFacebookappscret").val();
		var dataform={
			 action: 'save_option',
			"facebook_app_id" : facebook_app_id,
			"facebook_app_scret" : facebook_app_scret
		}
		var security_check =jQuery('#secure-checker').val();
		jQuery.ajax({
			url: ajaxurl,
			type: 'POST',
			dataType: 'json',
			security: security_check
			data: dataform,
			success:function( response ){
				jQuery(".message-shown").html(response.success);
			},
			error:function( error ){

					alert("error");

			}
		});
	});
	jQuery(document).on("click",".toggle",function(){
		var jQuery_this = jQuery(this);
		if ( !jQuery_this.hasClass( 'off' ) ) {

			jQuery_this.parent( '.panel-heading' ).next().toggle();
		}
		else{
			jQuery_this.parent( '.panel-heading' ).next().toggle();
		}
	});
});
