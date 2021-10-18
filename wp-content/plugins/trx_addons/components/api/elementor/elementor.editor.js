/* global jQuery:false, elementor:false */

jQuery(document).ready(function() {
	"use strict";


	// Refresh taxonomies when post type is changed
	//-------------------------------------------------------------------------------
	var tax_lists = {},
		fields_state = false,
		pmv = false;

	// Refresh taxonomies and terms lists when post type is changed in Elementor editor
	jQuery('#elementor-panel')
		.on('change', 'select[data-setting="post_type"],select[data-setting="taxonomy"]', function (e) {
			var cat_fld = jQuery(this).parents('.elementor-control').next().find('select');
			if (cat_fld.length > 0) {
				var cat_lbl = jQuery(this).parents('.elementor-control').next().find('label.elementor-control-title');
				// Restore fields values when panel is just opened
				if (fields_state !== false 
					&& jQuery(this).data('setting')=='taxonomy'
					&& fields_state.post_type == jQuery(this).parents('.elementor-control').prev().find('select').val()
				   	&& fields_state.tax_val !== false) {
						jQuery(this).val(fields_state.tax_val);
						fields_state.tax_val = false;
						jQuery(this).trigger('change');
						return false;
				}
				trx_addons_refresh_list(cat_fld.data('setting')=='taxonomy'
											? 'taxonomies'
											: 'terms',
										jQuery(this).val(),
										cat_fld,
										cat_lbl);
			}
			return false;
		});

	// Store taxonomies and terms to restore it when shortcode params open again
	jQuery('#elementor-panel')
		.on('change', 'select[data-setting="cat"],select[data-setting="category"]', function () {
			var tax_fld = jQuery(this).parents('.elementor-control').prev().find('select[data-setting="taxonomy"]');
			if (tax_fld.length > 0) {
				var post_fld = tax_fld.parents('.elementor-control').prev().find('select[data-setting="post_type"]');
				if (post_fld.length > 0) {
					// Restore fields values when panel is just opened
					if (fields_state !== false && fields_state.post_type == post_fld.val()) {
						jQuery(this).val(fields_state.terms_val);
						fields_state = false;
						jQuery(this).trigger('change');	// Refresh preview area
					} else {
						tax_lists[post_fld.data('element-cid')] = {
							'taxonomies': tax_fld.html(),	//.data('items'),
							'terms': jQuery(this).html()	//.data('items')
						};
					}
				}
			}
		})
		.on('click', '.elementor-panel-navigation-tab', function() {
			if (pmv !== false)
				trx_addons_elementor_open_panel(pmv.panel, pmv.model, pmv.view, true);
		});
	
	
	// Add Elementor's hooks and elements
	if (window.elementor !== undefined && window.elementor.hooks !== undefined) {
		// Add hook on panel open
		elementor.hooks.addAction( 'panel/open_editor/widget', trx_addons_elementor_open_panel);
	}

	// Store taxonomies and terms to restore it when shortcode params open again
	function trx_addons_elementor_open_panel( panel, model, view, tab_chg ) {
		if (panel.content !== undefined) {
			//Reset panel, model, view
			if (arguments[3]===undefined || arguments[3]===false)
				var tab_chg = false;
			if (!tab_chg) pmv = false;
			var post_fld = panel.content.$el.find( 'select[data-setting="post_type"]' );
			var tax_fld = panel.content.$el.find( 'select[data-setting="taxonomy"]' );
			var terms_fld = panel.content.$el.find( 'select[data-setting="cat"],select[data-setting="category"]' );
			// If this widget haven't fields 'post_type', 'taxonomy' or 'cat' - exit
			if (post_fld.length==0 || tax_fld.length == 0 || terms_fld.length == 0)
				return;
			// Save panel, model, view to use it when tabs are clicked
			if (!tab_chg) pmv = {'panel':panel, 'model': model, 'view':view};
			// Add view.cid to the field 'post_type'
			var el_cid = view.cid;
			post_fld.attr('data-element-cid', el_cid);
			var post_type = post_fld.val();
			var tax_val = model.getSetting(tax_fld.data('setting'));
			var terms_val = model.getSetting(terms_fld.data('setting'));
			// If list of taxonomies is correct - exit
			if (tax_fld.find('option[value="'+tax_val+'"]').length > 0 && terms_fld.find('option[value="'+terms_val+'"]').length > 0)
				return;
			// If we have stored list of items - use it
			if (tax_lists[el_cid] !== undefined) {
				tax_fld.html(tax_lists[el_cid].taxonomies).val(tax_val);
				terms_fld.html(tax_lists[el_cid].terms).val(terms_val);
			} else {
				fields_state = {'post_type': post_type, 'tax_val': tax_val, 'terms_val': terms_val};
				post_fld.trigger('change');
			}
		}
	}

	
	// Return layout with social icons
	//--------------------------------------------------------------------
	window.trx_addons_get_socials_links = function(icons, style, show) {
		var output = '',
			show_icons = show.indexOf('icons') >= 0,
			show_names = show.indexOf('names') >= 0;
		if (icons.length > 0 && typeof icons[0].name != 'undefined') {
			var sn='', fn='', title='', url='';
			for (var i=0; i<icons.length; i++) {
				sn = icons[i].name;
				fn = style=='icons' ? sn.replace('trx_addons_icon-', '').replace('icon-', '') : trx_addons_get_basename(sn);
				title = icons[i].title != '' ? icons[i].title : trx_addons_proper(fn);
				url = icons[i].url;
				if (trx_addons_is_off(url)) continue;
				output += '<a target="_blank" href="' + url + '"'
								+ ' class="social_item social_item_style_' + style + ' social_item_type_' + show + '">'
							+ (show_icons
								? '<span class="social_icon social_icon_' + fn + '"'
									+ (style=='bg' ? ' style="background-image: url(' + sn + ');"' : '')
									+ '>'
										+ (style=='icons' 
											? '<span class="' + sn + '"></span>' 
											: (style=='images' 
												? '<img src="' + sn + '" alt="' + title + '" />' 
												: '<span class="social_hover" style="background-image: url(' + sn + ');"></span>'
												)
										 	)
									+ '</span>'
								: '')
							+ (show_names
								? '<span class="social_name social_' + fn + '">' + title + '</span>'
								: '')
						+ '</a>';
			}
		}
		return output;
	};


	// Make panel categories as accordion
	//-------------------------------------------------------------------
	var last_active_title = false;

	// Check for click on the category title
	jQuery('#elementor-panel')
		.on('click', '.panel-elements-category-title', function(e) {
			// Click on the active title
			if (jQuery(this).hasClass('panel-elements-category-title-active')) {
/*
				jQuery(this)
					.removeClass('panel-elements-category-title-active')
					.parents('#elementor-panel-categories').removeClass('elementor-panel-categories-has-active');
				last_active_title = false;
*/
			// Click on the inactive title
			} else {
				jQuery(this)
					.parents('#elementor-panel-categories')	//.addClass('elementor-panel-categories-has-active')
					.find('.panel-elements-category-title-active').removeClass('panel-elements-category-title-active');
				last_active_title = jQuery(this).attr('class');
				restore_active_title();
				//jQuery(this).addClass('panel-elements-category-title-active');
			}
		});

	// Check for click on the 'Add Element' button
	jQuery('#elementor-panel')
		.on('click', '#elementor-panel-header-add-button', function(e) {
			restore_active_title();
		});

	// Check for click outside the document in the preview area
	if (window.elementor !== undefined && elementor.$preview !== undefined) {
		elementor.$preview.on( 'load', function() {
			try {
				var previewWindow = elementor.$preview[0].contentWindow;
				if ( ! previewWindow.elementorFrontend ) {
					return;
				}
				var $previewBody = elementor.$preview.contents();
				var $previewElementorWrap = $previewBody.find( '#elementor' );
				if ($previewElementorWrap.length == 0) {
					return;
				}
				// Click on preview outside the document (Editor area)
				$previewBody.on( 'click.trx_addons', function( event ) {
					try {
						var $target = jQuery( event.target ),
							editMode = elementor.channels.dataEditMode.request( 'activeMode' ),
							isClickInsideElementor = !! $target.closest( '#elementor, .pen-menu' ).length,
							isTargetInsideDocument = this.contains( $target[0] ),
							isEmptyView = $target.hasClass('elementor-empty-view')
											|| $target.closest( '.elementor-empty-view' ).length > 0
											|| ($target.hasClass('elementor-editor-element-remove') 
												&& $target.closest('.elementor-editor-element-remove').length > 0);
						if ( isClickInsideElementor && 'edit' === editMode && !isEmptyView || !isTargetInsideDocument ) {
							return;
						}

						if ( !isClickInsideElementor || isEmptyView ) {
							if ( 'elements' === elementor.getPanelView().getCurrentPageName() ) {
								restore_active_title();
							}
						}
					} catch (e) {
					}
				} );
			} catch (e) {
			}
		});
	}

	// Restore last title
	function restore_active_title() {
		if (last_active_title !== false) {
			setTimeout(function(){
				var title = jQuery('#elementor-panel')
								.find('.'+last_active_title.split(' ').join('.')).addClass('panel-elements-category-title-active');
				if (title.length > 0) {
					title.parents('#elementor-panel-categories').addClass('elementor-panel-categories-has-active');
					jQuery('#elementor-panel-content-wrapper').scrollTop(
							jQuery('#elementor-panel-elements-navigation').outerHeight()
							+ jQuery('#elementor-panel-elements-search-area').outerHeight()
							+ title.parent().index()*(title.outerHeight()+2)
						);
				}
			}, 0);
		}
	}
});