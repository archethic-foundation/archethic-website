jQuery('.fluidbox-image').each(function() {
	"use strict";
	var _float = jQuery(this).data('float');
	jQuery(this).fluidbox({
		stackIndex: 1000
	});
});
