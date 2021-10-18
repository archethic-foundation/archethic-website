
(function ( $ ) {
	"use strict";

	/*
	* Plugin trx_mscf_ajax provides Contact Form 7 ajax behaviour
	* */
	$.fn.trx_mscf_ajax = function(options) {
		$.fn.trx_mscf_ajax.options = $.extend( {}, $.fn.trx_mscf_ajax.defaults, options );

		return this.each(function(index, container) {
			if ($($.fn.trx_mscf_ajax.options.classes.step, $(container)).length > 0){
				$.fn.trx_mscf_ajax.init($(container));
			}
		});
	};

	$.fn.trx_mscf_ajax.defaults = {
		ajax_url: TRX_MSCF_GLOBALS['ajax_url'],
		ajax_nonce: TRX_MSCF_GLOBALS['ajax_nonce'],
		classes: {
			active: 'trx_mscf_active',
			hidden: 'trx_hidden',
			step: '.trx_mscf_step',
			next: '.trx_mscf_next',
			prev: '.trx_mscf_prev',
			progressbar: '.trx_mscf_progressbar',
			progressbar_template: 'trx_mscf_template'
		}
	};

	$.fn.trx_mscf_ajax.init = function ($container) {
		var defaults = $.fn.trx_mscf_ajax.options;

		$(defaults.classes.step, $container).each(function (ind, el) {
			if (ind === 0) {
				$(el).addClass(defaults.classes.active);
			}
			$(el).attr('data-step', ++ind);
		});

		// Next step click action
		$(defaults.classes.next, $container).stop().click(function (e) {
			e.preventDefault();
			var current_step_obj = $(e.target).closest(defaults.classes.step);

			if(current_step_obj.length > 0) {
				var current_step = parseInt( current_step_obj.attr('data-step') ),
					next_step_obj = $(defaults.classes.step + '[data-step=' + (++current_step) +']',$container);

				$.fn.trx_mscf_ajax.step_validate($container, current_step_obj, next_step_obj);
			} else {
				console.log('Cant find current step.');
			}
		});

		// Prev step click action
		$(defaults.classes.prev, $container).stop().click(function (e) {
			e.preventDefault();

			var current_step_obj = $(e.target).closest(defaults.classes.step);

			if(current_step_obj.length > 0) {
				var current_step = parseInt( current_step_obj.attr('data-step') ),
						prev_step_obj = $(defaults.classes.step + '[data-step=' + (--current_step) +']',$container);

				$.fn.trx_mscf_ajax.change_progressbar(current_step_obj, prev_step_obj, $container);
				$.fn.trx_mscf_ajax.do_step(current_step_obj, prev_step_obj);
			} else {
				console.log('Cant find current step.');
			}
		});

	};

	$.fn.trx_mscf_ajax.step_validate = function ($container, current_step_obj, next_step_obj) {
		var defaults = $.fn.trx_mscf_ajax.options,
			$form = $('form', $container),
			fields_to_check_names = $(current_step_obj).find(".wpcf7-form-control").map(function () {
				return this.name;
			}).get(),
			fields_to_check_serialized = $(current_step_obj).find(".wpcf7-form-control").serialize();

		if ( $(current_step_obj).find(".wpcf7-form-control[type='file']").length > 0 ) {
			$(current_step_obj).find(".wpcf7-form-control[type='file']").each(function(i, n) {
				fields_to_check_serialized += "&" + $(this).attr('name') + "=" + $(this).val();
			});
		}

		var	data = fields_to_check_serialized
				+ '&'+ 'action=' + 'trx_mscf_validate_fields'
				+ '&'+ 'trx_form_id=' + wpcf7.getId( $('form', $container) )
				+ '&'+ 'trx_fields_to_check=' + fields_to_check_names
				+ '&'+ 'trx_ajax_nonce=' + defaults.ajax_nonce;

		// Check fields validation
		if (fields_to_check_names.length > 0) {
			$.ajax({
				type : "post",
				dataType : "json",
				url : defaults.ajax_url,
				data : data,
				success: function(response) {
					var json_result = '';

					$.fn.trx_mscf_ajax.clear_error_messages($form, current_step_obj);

					try {
						json_result = (typeof response === 'object') ? response : JSON.parse(JSON.stringify(response));

						if (json_result.is_valid) {

							$.fn.trx_mscf_ajax.change_progressbar(current_step_obj, next_step_obj, $container);

							$.fn.trx_mscf_ajax.do_step(current_step_obj, next_step_obj);
						} else {
							// show errors
							var $message = $( '.wpcf7-response-output', $form );
							$.each( json_result.invalid_fields, function(i, n) {
								$(n.into, $form).each(function() {
									wpcf7.notValidTip(this, n.message);
									$( '.wpcf7-form-control', this ).addClass( 'wpcf7-not-valid' );
									$( '[aria-invalid]', this ).attr( 'aria-invalid', 'true' );
								} );
							} );
							$message.addClass( 'wpcf7-validation-errors' );
							$form.addClass( 'invalid' );
						}
					} catch (e) {
						console.log("error: "+e);
					}
				}
			});
		} else {
			// If no data to validate, just go on
			$.fn.trx_mscf_ajax.change_progressbar(current_step_obj, next_step_obj, $container);

			$.fn.trx_mscf_ajax.do_step(current_step_obj, next_step_obj);
		}

	};

	$.fn.trx_mscf_ajax.do_step = function (current_step_obj, next_step_obj) {
		var defaults = $.fn.trx_mscf_ajax.options;
		$(current_step_obj).removeClass(defaults.classes.active).addClass(defaults.classes.hidden);
		$(next_step_obj).removeClass(defaults.classes.hidden).addClass(defaults.classes.active);//.fadeIn();
	};

	$.fn.trx_mscf_ajax.clear_error_messages = function ($form, current_step_obj) {
 		$form.removeClass( 'invalid' );
		$( '.wpcf7-response-output', $form ).removeClass( 'wpcf7-validation-errors' );
		$('.wpcf7-form-control', current_step_obj).removeClass('wpcf7-not-valid');
		$('[aria-invalid]', current_step_obj).attr('aria-invalid', 'false');
		$('.wpcf7-not-valid-tip', current_step_obj).remove();
	};

	$.fn.trx_mscf_ajax.change_progressbar = function (current_step_obj, next_step_obj, $container) {
		var defaults = $.fn.trx_mscf_ajax.options;

		if ($(defaults.classes.progressbar, $container).length > 0) {
			var $progressbars = $(defaults.classes.progressbar, $container),

				current_step = parseInt( current_step_obj.attr('data-step') ),
				next_step = parseInt( next_step_obj.attr('data-step') );
			current_step--;
			next_step--;
			$progressbars.each(function (ind, el) {
				if (current_step < next_step) {
					$('li', el).eq(next_step).addClass('active');
				} else {
					$('li', el).eq(current_step).removeClass('active');
					$('li', el).eq(next_step).addClass('active');
				}
			});

		}
	};

}( jQuery ));

jQuery(document).ready(function () {
	"use strict";

	jQuery('.wpcf7').trx_mscf_ajax();
});