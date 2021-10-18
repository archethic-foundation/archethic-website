jQuery(document).ready(function() {
	jQuery('#addonsdata, .btn-save').submit(function(event) {
		jQuery('.nm-saved').hide();
		jQuery('.nm-loading').show();
		event.preventDefault();
		var data = jQuery(this).serialize();
		data = data + '&action=vc_save_data';
		jQuery.post(ajaxurl, data, function(resp) {
			jQuery('.nm-loading').hide();
			jQuery('.nm-saved').show();
		});
	});
});