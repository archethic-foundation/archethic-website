//-------------------------------------------
// Options handlers
//-------------------------------------------

/* global jQuery:false */
/* global TRX_ADDONS_STORAGE:false */

jQuery(document).ready(function() {

	"use strict";

	// Submit form
	jQuery('.trx_addons_options_button_submit').on('click', function() {
		jQuery(this).parents('form').submit();
	});

	// Init fields
	trx_addons_options_init_fields();
	jQuery(document).on('action.init_hidden_elements', trx_addons_options_init_fields);
	
	// Check fields dependencies
	jQuery('.trx_addons_options .trx_addons_options_section').each(function () {
		trx_addons_options_check_dependencies(jQuery(this));
	});
	jQuery('.trx_addons_options .trx_addons_options_item_field [name^="trx_addons_options_field_"]').on('change', function () {
		trx_addons_options_check_dependencies(jQuery(this).parents('.trx_addons_options_section'));
	});
	
	
	// Init fields at first run and after clone group
	function trx_addons_options_init_fields(e, container) {
		
		if (container === undefined) container = jQuery('.trx_addons_options ');
			
		// Init jQuery Tabs
		if (jQuery.ui && jQuery.ui.tabs) {
			container.find('#trx_addons_options_tabs:not(.inited)').addClass('inited').tabs({
				create: function( event, ui ) {
					if (ui.panel.length > 0) jQuery(document).trigger('admin_action.init_hidden_elements', [ui.panel]);
				},
				activate: function( event, ui ) {
					if (ui.newPanel.length > 0) jQuery(document).trigger('admin_action.init_hidden_elements', [ui.newPanel]);
				}
			});
		}
		
		// Init jQuery Accordion
		if (jQuery.ui && jQuery.ui.accordion) {
			container.find('.trx_addons_options_panels:not(.inited)').addClass('inited').accordion({
				'header': '.trx_addons_options_panel_title',
				'heightStyle': 'content',
				create: function( event, ui ) {
					if (ui.panel.length > 0) jQuery(document).trigger('admin_action.init_hidden_elements', [ui.panel]);
				},
				activate: function( event, ui ) {
					if (ui.newPanel.length > 0) jQuery(document).trigger('admin_action.init_hidden_elements', [ui.newPanel]);
				}
			});
		}
		
		// Init checklist
		container.find('.trx_addons_options_item_choises:not(.inited)').addClass('inited')
			.on('change', 'input[type="checkbox"]', function() {
				var choises = '';
				var cont = jQuery(this).parents('.trx_addons_options_item_choises');
				cont.find('input[type="checkbox"]').each(function() {
					choises += (choises ? '|' : '') + jQuery(this).data('name') + '=' + (jQuery(this).get(0).checked ? jQuery(this).val() : '0');
				});
				cont.find('input[type="hidden"]').eq(0).val(choises).trigger('change');
			})
			.each(function() {
				if (jQuery.ui.sortable && jQuery(this).hasClass('trx_addons_options_sortable')) {
					var id = jQuery(this).attr('id');
					if (id === undefined)
						jQuery(this).attr('id', 'trx_addons_options_sortable_'+(''+Math.random()).replace('.', ''));
					jQuery(this).sortable({
						items: ".trx_addons_options_item_sortable",
						placeholder: ' trx_addons_options_item_label trx_addons_options_sortable_placeholder',
						update: function(event, ui) {
							var choises = '';
							ui.item.parent().find('input[type="checkbox"]').each(function() {
								choises += (choises ? '|' : '') 
										+ jQuery(this).data('name') + '=' + (jQuery(this).get(0).checked ? jQuery(this).val() : '0');
							});
							ui.item.siblings('input[type="hidden"]').eq(0).val(choises).trigger('change');
						}
					})
					.disableSelection();
				}
			});
	
		// Init Select2
		if (jQuery.fn && jQuery.fn.select2) 
			container.find('.trx_addons_options_item_select2 select:not(.inited)').addClass('inited').select2();
	
		// Init datepicker
		if (jQuery.ui.datepicker) {
			container.find('.trx_addons_options_item_date input[type="text"]:not(.inited)').addClass('inited')
				.each(function () {
					var curDate = jQuery(this).val();
					jQuery(this).datepicker({
						dateFormat: jQuery(this).data('format'),
						numberOfMonths: jQuery(this).data('months'),
						gotoCurrent: true,
						changeMonth: true,
						changeYear: true,
						defaultDate: curDate,
						onSelect: function (text, ui) {
							ui.input.trigger('change');
						}
					});
				});
		}
	
		// Init masked input
		container.find('.trx_addons_options_item input[data-mask]:not(.inited)').addClass('inited')
			.each(function () {
				if (jQuery.fn && jQuery.fn.mask) jQuery(this).mask(''+jQuery(this).data('mask'));
			});


		// Button with action
		container.find('.trx_addons_options_item_button input[type="button"]:not(.inited)').addClass('inited')
			.on('click', function(e) {
				jQuery.post(TRX_ADDONS_STORAGE['ajax_url'], {
					action: jQuery(this).data('action'),
					nonce: TRX_ADDONS_STORAGE['ajax_nonce'],
				}).done(function(response) {
					var rez = {};
					if (response=='' || response==0) {
						rez = { error: TRX_ADDONS_STORAGE['msg_ajax_error'] };
					} else {
						try {
							rez = JSON.parse(response);
						} catch (e) {
							rez = { error: TRX_ADDONS_STORAGE['msg_ajax_error'] };
							console.log(response);
						}
					}
					alert(rez.error ? rez.error : rez.success);
				});
				e.preventDefault();
				return false;
			});
	
		// Init cloned fields
		trx_addons_options_clone_toggle_buttons(container);
		container.find('.trx_addons_options_group:not(.inited)').addClass('inited').each(function() {
			jQuery(this)
				// Button 'Clone'
				.on('click', '.trx_addons_options_clone > .trx_addons_options_clone_control_add', function (e) {
					var clone_obj = jQuery(this).parents('.trx_addons_options_clone'),
						group = clone_obj.parents('.trx_addons_options_group');
					// Clone fields
					trx_addons_options_clone(clone_obj);
					// Enable/Disable clone buttons
					trx_addons_options_clone_toggle_buttons(group);
					// Prevent bubble event
					e.preventDefault();
					return false;
				})
				// Button 'Delete'
				.on('click', '.trx_addons_options_clone > .trx_addons_options_clone_control_delete', function (e) {
					var clone_obj = jQuery(this).parents('.trx_addons_options_clone'),
						clone_idx = clone_obj.index(),
						group = clone_obj.parents('.trx_addons_options_group');
					// Delete clone
					clone_obj.remove();
					// Change fields index
					trx_addons_options_clone_change_index(group, clone_idx);
					// Enable/Disable clone buttons
					trx_addons_options_clone_toggle_buttons(group);
					// Prevent bubble event
					e.preventDefault();
					return false;
				});
			// Sort clones
			if (jQuery.ui.sortable) {
				var id = jQuery(this).attr('id');
				if (id === undefined)
					jQuery(this).attr('id', 'trx_addons_options_sortable_'+(''+Math.random()).replace('.', ''));
				jQuery(this)
					.sortable({
						items: '.trx_addons_options_clone',
						handle: '.trx_addons_options_clone_control_move',
						placeholder: ' trx_addons_options_clone trx_addons_options_clone_placeholder',
						start: function (event, ui) {
							// Make the placeholder has the same height as dragged item
							ui.placeholder.height(ui.item.height());
						},
						update: function(event, ui) {
							// Change fields index
							trx_addons_options_clone_change_index(ui.item.parents('.trx_addons_options_group'), 0);
						}
					});
			}
		});
		
		// Check clone controls for enable/disable
		function trx_addons_options_clone_toggle_buttons(container) {
			if (!container.hasClass('trx_addons_options_group'))
				container = container.find('.trx_addons_options_group');
			container.each(function() {
				var group = jQuery(this);
				if (group.find('.trx_addons_options_clone').length > 1)
					group.find('.trx_addons_options_clone_control_delete,.trx_addons_options_clone_control_move').show();
				else
					group.find('.trx_addons_options_clone_control_delete,.trx_addons_options_clone_control_move').hide();
			});
		}
		
		// Replace number in the param's name like 'floor_plans[0][image]'
		function trx_addons_options_clone_replace_index(name, idx_new) {
			name = name.replace(/\[\d\]/, '['+idx_new+']');
			return name;
		}
		
		// Change index in each field in the clone
		function trx_addons_options_clone_change_index(group, from_idx) {
			group.find('.trx_addons_options_clone').each(function(idx) {
				if (idx < from_idx) return;
				jQuery(this).find('.trx_addons_options_item_field').each(function() {
					var field = jQuery(this);
					field.attr('data-param', trx_addons_options_clone_replace_index(field.data('param'), idx));
					field.find('> :input').each(function() {
						var input = jQuery(this),
							id = input.attr('id'),
							name = input.attr('name');
						if (!name) return;
						name = trx_addons_options_clone_replace_index(name, idx);
						input.attr('name', name);
						if (id) {
							var id_new = name.replace(/\[/g, '_').replace(/\]/g, '');
							input.attr('id', id_new);
							var linked_field = field.find('[data-linked-field="'+id+'"]');
							if (linked_field.length > 0) {
								linked_field.attr('data-linked-field', id_new);
								if (linked_field.attr('id'))
									linked_field.attr('id', linked_field.attr('id').replace(id, id_new));
							}
						}
					});
				});
			});
		}
		
		// Clone set of the fields
		function trx_addons_options_clone(obj) {
			var group = obj.parent(),
				clones = group.find('.trx_addons_options_clone'),
				clone = obj.clone(),
				inputs = clone.find('.trx_addons_options_item_field > :input'),
				obj_idx = obj.index();
			// Remove class 'inited' from all elements
			clone.find('.inited').removeClass('inited');
			// Reset value for fields
			inputs.each(function() {
				var input = jQuery(this);
				if (input.is(':radio') || input.is(':checkbox')) {
					input.prop('checked', false);
				} else if (input.is('select')) {
					input.prop('selectedIndex', -1);
				} else {
					input.val('');
				}
				// Remove image preview
				input.parents('.trx_addons_options_item_field').find('.trx_addons_media_selector_preview').empty();
				// Remove class 'inited' from selectors
				input.next('[class*="_selector"].inited').removeClass('inited');
			});
			// Insert Clone
			clone.insertAfter(obj);
			// Change fields index. Must run before trigger clone event
			trx_addons_options_clone_change_index(group, obj_idx);
			// Fire init actions for cloned fields
			jQuery(document).trigger('action.init_hidden_elements', [clone.parents('.trx_addons_options')]);
		}
	}

	// Return value of the field
	function trx_addons_options_get_field_value(fld) {
		var ctrl = fld.parents('.trx_addons_options_item_field');
		var val = fld.attr('type')=='checkbox' || fld.attr('type')=='radio' 
					? (ctrl.find('[name^="trx_addons_options_field_"]:checked').length > 0
						? (ctrl.find('[name^="trx_addons_options_field_"]:checked').val()!=''
							&& ''+ctrl.find('[name^="trx_addons_options_field_"]:checked').val()!='0'
								? ctrl.find('[name^="trx_addons_options_field_"]:checked').val()
								: 1
							)
						: 0
						)
					: fld.val();
		if (val===undefined || val===null) val = '';
		return val;
	}
	
	// Check for dependencies
	function trx_addons_options_check_dependencies(cont) {
		if (typeof TRX_ADDONS_DEPENDENCIES == 'undefined') return;
		cont.find('.trx_addons_options_item_field').each(function() {
			var ctrl = jQuery(this), id = ctrl.data('param');
			if (id == undefined) return;
			var depend = false;
			for (var fld in TRX_ADDONS_DEPENDENCIES) {
				if (fld == id) {
					depend = TRX_ADDONS_DEPENDENCIES[id];
					break;
				}
			}
			if (depend) {
				var dep_cnt = 0, dep_all = 0;
				var dep_cmp = typeof depend.compare != 'undefined' ? depend.compare.toLowerCase() : 'and';
				var dep_strict = typeof depend.strict != 'undefined';
				var fld=null, val='', name='', subname='', i;
				var parts = '', parts2 = '';
				for (i in depend) {
					if (i == 'compare' || i == 'strict') continue;
					dep_all++;
					name = i;
					subname = '';
					if (name.indexOf('[') > 0) {
						parts = name.split('[');
						name = parts[0];
						subname = parts[1].replace(']', '');
					}
					if (name.charAt(0)=='#') {
						fld = jQuery(name);
						if (fld.length > 0 && !fld.hasClass('trx_addons_inited')) {
							fld.addClass('trx_addons_inited').on('change', function () {
								jQuery('.trx_addons_options .trx_addons_options_section').each(function () {
									trx_addons_options_check_dependencies(jQuery(this));
								});
							});
						}
					} else
						fld = cont.find('[name="trx_addons_options_field_'+name+'"]');
					if (fld.length > 0) {
						val = trx_addons_options_get_field_value(fld);
						if (subname!='') {
							parts = val.split('|');
							for (var p=0; p < parts.length; p++) {
								parts2 = parts[p].split('=');
								if (parts2[0]==subname) {
									val = parts2[1];
								}
							}
						}
						for (var j in depend[i]) {
							if ( 
								   (depend[i][j]=='not_empty' && val!='')	// Main field value is not empty - show current field
								|| (depend[i][j]=='is_empty' && val=='')	// Main field value is empty - show current field
								|| (val!=='' && (!isNaN(depend[i][j]) 		// Main field value equal to specified value - show current field
													? val==depend[i][j]
													: (dep_strict 
															? val==depend[i][j]
															: (''+val).indexOf(depend[i][j])==0
														)
												)
									)
								|| (val!=='' && (""+depend[i][j]).charAt(0)=='^' && (''+val).indexOf(depend[i][j].substr(1))==-1)
																			// Main field value not equal to specified value - show current field
							) {
								dep_cnt++;
								break;
							}
						}
					}
					if (dep_cnt > 0 && dep_cmp == 'or')
						break;
				}
				if ((dep_cnt > 0 && dep_cmp == 'or') || (dep_cnt == dep_all && dep_cmp == 'and')) {
					ctrl.parents('.trx_addons_options_item').show().removeClass('trx_addons_options_no_use');
				} else {
					ctrl.parents('.trx_addons_options_item').hide().addClass('trx_addons_options_no_use');
				}
			}
		});
	}

});