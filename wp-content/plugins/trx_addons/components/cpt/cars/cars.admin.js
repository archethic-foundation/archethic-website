/* global jQuery:false */
/* global TRX_ADDONS_STORAGE:false */

jQuery(document).ready(function() {
	"use strict";
	
	// Field "Maker" is changed - refresh states
	//--------------------------------------------------------
	jQuery('body').on('change', 'select.cars_maker,select#trx_addons_maker,select[name="trx_addons_options_field_maker"],select[name*="cars_maker"]', function () {
		var fld = jQuery(this);
		var slave_fld = fld.hasClass('cars_maker')
							? fld.parents('.vc_edit-form-tab').find('select.cars_model')												// VC
							: (fld.parents('.siteorigin-widget-field,[class*="widget_field_type_"]').length > 0
								? fld.parents('.siteorigin-widget-field,[class*="widget_field_type_"]').next().find('select')											// SOW
								: (fld.attr('name')=='trx_addons_options_field_maker'
									? fld.parents('.trx_addons_options_section').find('select[name="trx_addons_options_field_model"]')	// TRX_Addons Options
									: fld.parents('form').find('select#trx_addons_model')												// Meta fields
									)
								);
		if (slave_fld.length > 0) {
			var slave_lbl = fld.hasClass('cars_maker')
							? slave_fld.parent().prev()																		// VC
							: (slave_fld.parents('.siteorigin-widget-field,[class*="widget_field_type_"]').length > 0
								? slave_fld.parents('.siteorigin-widget-field,[class*="widget_field_type_"]').find('.siteorigin-widget-field-label,label.widget_field_title')		// SOW
								: (fld.attr('name')=='trx_addons_options_field_maker'
									? slave_fld.parents('.trx_addons_options_item').find('.trx_addons_options_item_title')	// TRX_Addons Options
									: slave_fld.parents('form').find('label#trx_addons_model_label')						// Meta fields
									)
								);
			trx_addons_refresh_list('models', fld.val(), slave_fld, slave_lbl, true);
		}
	});
	
});