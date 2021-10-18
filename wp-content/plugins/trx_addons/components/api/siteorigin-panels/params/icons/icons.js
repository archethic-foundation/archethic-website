/* global jQuery:false */

(function() {
	"use strict";
	jQuery(document).on( 'sowsetupformfield', '.siteorigin-widget-field-type-icons,.so-panels-dialog .widget_field_type_icons', function(e) {
		jQuery(document).trigger('action.init_hidden_elements', [jQuery('.so-panels-dialog')]);
	});
})();