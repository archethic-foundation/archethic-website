/**
 * Init and resize sliders
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.1
 */

/* global jQuery:false */
/* global TRX_ADDONS_STORAGE:false */

(function() {

	"use strict";
	
	jQuery(document).on('action.init_hidden_elements', trx_addons_init_hidden_sliders);
	
	// Init sliders with engine=swiper
	function trx_addons_init_sliders(e, container) {
		// Create Swiper Controllers
		if (container.find('.sc_slider_controller:not(.inited)').length > 0) {
			container.find('.sc_slider_controller:not(.inited)')
				.each(function () {
					var controller = jQuery(this).addClass('inited');
					var slider_id = controller.data('slider-id');
					if (!slider_id) return;
					
					var controller_id = controller.attr('id');
					if (controller_id == undefined) {
						controller_id = 'sc_slider_controller_'+Math.random();
						controller_id = controller_id.replace('.', '');
						controller.attr('id', controller_id);
					}
	
					jQuery('#'+slider_id+' .slider_container').attr('data-controller', controller_id);
	
					var controller_style = controller.data('style');
					var controller_effect = controller.data('effect');
					var controller_direction = controller.data('direction');
					var controller_interval = controller.data('interval');
					var controller_height = controller.data('height');
					var controller_per_view = controller.data('slides-per-view');
					var controller_space = controller.data('slides-space');
					var controller_controls = controller.data('controls');
	
					var controller_html = '';
					jQuery('#'+slider_id+' .swiper-slide')
						.each(function (idx) {
							var slide = jQuery(this);
							var image = slide.data('image');
							var title = slide.data('title');
							var cats = slide.data('cats');
							var date = slide.data('date');
							controller_html += '<div class="slider-slide swiper-slide"'
													+ ' style="'
															+ (image !== undefined ? 'background-image: url('+image+');' : '')
															+ '"'
													+ '>'
													+ '<div class="sc_slider_controller_info">'
														+ '<span class="sc_slider_controller_info_number">'+(idx < 9 ? '0' : '')+(idx+1)+'</span>'
														+ '<span class="sc_slider_controller_info_title">'+title+'</span>'
													+ '</div>'
												+ '</div>';
						});
					controller.html('<div id="'+controller_id+'_outer"'
										+ ' class="slider_outer slider_swiper_outer slider_style_controller'
													+ ' slider_outer_' + (controller_controls == 1 ? 'controls slider_outer_controls_side' : 'nocontrols')
													+ ' slider_outer_nopagination'
													+ ' slider_outer_' + (controller_per_view==1 ? 'one' : 'multi')
													+ ' slider_outer_direction_' + (controller_direction=='vertical' ? 'vertical' : 'horizontal')
													+ '"'
										+ '>'
											+ '<div id="'+controller_id+'_swiper"'
												+' class="slider_container slider_swiper swiper-slider-container'
														+ ' slider_' + (controller_controls == 1 ? 'controls slider_controls_side' : 'nocontrols')
														+ ' slider_nopagination'
														+ ' slider_notitles'
														+ ' slider_noresize'
														+ ' slider_' + (controller_per_view==1 ? 'one' : 'multi')
														+ ' slider_direction_' + (controller_direction=='vertical' ? 'vertical' : 'horizontal')
														+ '"'
												+ ' data-slides-min-width="100"'
												+ ' data-controlled-slider="'+slider_id+'"'
												+ ' data-direction="' + (controller_direction=='vertical' ? 'vertical' : 'horizontal') + '"'
												+ (controller_effect !== undefined ? ' data-effect="' + controller_effect + '"' : '')
												+ (controller_interval !== undefined ? ' data-interval="' + controller_interval + '"' : '')
												+ (controller_per_view !== undefined ? ' data-slides-per-view="' + controller_per_view + '"' : '')
												+ (controller_space !== undefined ? ' data-slides-space="' + controller_space + '"' : '')
												+ (controller_height !== undefined ? ' style="height:'+controller_height+'"' : '')
											+ '>'
												+ '<div class="slider-wrapper swiper-wrapper">'
													+ controller_html
												+ '</div>'
											+ '</div>'
											+ (controller_controls == 1
												? '<div class="slider_controls_wrap"><a class="slider_prev swiper-button-prev" href="#"></a><a class="slider_next swiper-button-next" href="#"></a></div>'
												: ''
												)
										+ '</div>'
					);
				});
		}


		// Create Swiper Controls
		if (container.find('.sc_slider_controls:not(.inited)').length > 0) {
			container.find('.sc_slider_controls:not(.inited)')
				.each(function () {
					var controls = jQuery(this).addClass('inited');
					var slider_id = controls.data('slider-id');
					if (!slider_id) return;
					slider_id = jQuery('#'+slider_id+' .slider_swiper').attr('id');
					if (!slider_id) return;
					controls.on('click', 'a', function(e) {
						if (jQuery(this).hasClass('slider_next'))
							TRX_ADDONS_STORAGE['swipers'][slider_id].slideNext();
						else
							TRX_ADDONS_STORAGE['swipers'][slider_id].slidePrev();
						e.preventDefault();
						return false;
					});
					if (controls.find('.slider_progress_bar').length > 0) {
						var bar = controls.find('.slider_progress_bar');
						jQuery('#'+slider_id).on('slider_init slide_change_start', function(e) {
							if (TRX_ADDONS_STORAGE['swipers'][slider_id]) {
								var s = TRX_ADDONS_STORAGE['swipers'][slider_id];
								var current = jQuery(s.slides[s.activeIndex]).data('slide-number') + 1,
									total = s.params.loop ? Math.ceil((s.slides.length - s.loopedSlides * 2) / s.params.slidesPerGroup) : s.snapGrid.length;
								if (total > 0) bar.width(Math.ceil(current/total*100)+'%');
							}
						});
						bar.parent().on('click', function(e) {
							var s = TRX_ADDONS_STORAGE['swipers'][slider_id];
							var total = s.params.loop ? Math.ceil((s.slides.length - s.loopedSlides * 2) / s.params.slidesPerGroup) : s.snapGrid.length;
							var slide_number = Math.max(0, Math.min(total-1, Math.floor(total * e.offsetX / jQuery(this).width())));
							var slide_idx = jQuery('#'+slider_id).find('[data-slide-number="'+slide_number+'"]').index();
							s.slideTo(slide_idx);
							e.preventDefault();
							return false;
						});
					}
				});
		}
				
	
		// Swiper Slider
		if (container.find('.slider_swiper:not(.inited)').length > 0) {
			container.find('.slider_swiper:not(.inited)')
				.each(function () {
	
					// If slider inside the invisible block - exit
					if (jQuery(this).parents('div:hidden,article:hidden').length > 0)
						return;
					
					// Check attr id for slider. If not exists - generate it
					var slider = jQuery(this);
					var id = slider.attr('id');
					if (id == undefined) {
						id = 'swiper_'+Math.random();
						id = id.replace('.', '');
						slider.attr('id', id);
					}
					var cont = slider.parent().hasClass('slider_swiper_outer') ? slider.parent().attr('id', id+'_outer') : slider;
					var cont_id = cont.attr('id');

					// If this slider is controller for the other slider
					var is_controller = slider.parents('.sc_slider_controller').length > 0;
					var controller_id = slider.data('controller');
					
					// Enum all slides
					slider.find('.swiper-slide').each(function(idx) {
						jQuery(this).attr('data-slide-number', idx);
					});
	
					// Show slider, but make it invisible
					slider.css({
						'display': 'block',
						'opacity': 0
						})
						.addClass(id)
						.addClass('inited')
						.data('settings', {mode: 'horizontal'});		// VC hook
						
					// Direction of slides change
					var direction = slider.data('direction');
					if (direction != 'vertical') direction = 'horizontal';
	
					// Min width of the slides in swiper (used for validate slides_per_view on small screen)
					var smw = slider.data('slides-min-width');
					if (smw === undefined) {
						smw = 150;
						slider.attr('data-slides-min-width', smw);
					}
	
					// Validate Slides per view on small screen
					var spv = slider.data('slides-per-view');

					if (spv == undefined || slider.parents('.widget_nav_menu').length > 0) {
						spv = 1;
						slider.attr('data-slides-per-view', spv);
					}
					var width = slider.width();
					if (width == 0) width = slider.parent().width();
					if (direction == 'horizontal') {
						if (width / spv < smw) spv = Math.max(1, Math.floor(width / smw));
					}
					
					// Space between slides
					var space = slider.data('slides-space');
					if (space == undefined) space = 0;
					
					// Autoplay interval
					var interval = slider.data('interval');
					if (interval === undefined) interval = Math.round(5000 * (1 + Math.random()));
					if (isNaN(interval)) interval = 0;
					
					if (TRX_ADDONS_STORAGE['swipers'] === undefined) TRX_ADDONS_STORAGE['swipers'] = {};

					TRX_ADDONS_STORAGE['swipers'][id] = new Swiper('.'+id, {
						direction: direction,
						calculateHeight: !slider.hasClass('slider_height_fixed'),
						resizeReInit: true,
						autoResize: true,
						effect: slider.data('effect') ? slider.data('effect') : 'slide',
						pagination: slider.hasClass('slider_pagination') ? '#'+cont_id+' .slider_pagination_wrap' : false,
						paginationClickable: slider.hasClass('slider_pagination') ? '#'+cont_id+' .slider_pagination_wrap' : false,
						paginationType: slider.hasClass('slider_pagination') && slider.data('pagination') ? slider.data('pagination') : 'bullets',
						nextButton: slider.hasClass('slider_controls') ? '#'+cont_id+' .slider_next' : false,
						prevButton: slider.hasClass('slider_controls') ? '#'+cont_id+' .slider_prev' : false,
						autoplay: slider.hasClass('slider_noautoplay') || interval==0 ? false : parseInt(interval, 10),
						autoplayDisableOnInteraction: true,
						initialSlide: 0,
						slidesPerView: spv,
						loopedSlides: spv,
						spaceBetween: space,
						speed: 600,
						centeredSlides: false,	//is_controller,
						loop: true,				//!is_controller
						grabCursor: !is_controller,
						slideToClickedSlide: is_controller,
						touchRatio: is_controller ? 0.2 : 1,
						onSlideChangeStart: function (swiper) {
							// Change outside title
							cont.find('.slider_titles_outside_wrap .active').removeClass('active').fadeOut();
							// Update controller or controlled slider
							var controlled_slider = jQuery('#'+slider.data(is_controller ? 'controlled-slider' : 'controller')+' .slider_swiper');
							var controlled_id = controlled_slider.attr('id');
							if (TRX_ADDONS_STORAGE['swipers'][controlled_id] && jQuery('#'+controlled_id).attr('data-busy')!=1) {
								slider.attr('data-busy', 1);
								setTimeout(function() { slider.attr('data-busy', 0); }, 300);
								var slide_number = jQuery(swiper.slides[swiper.activeIndex]).data('slide-number');
								var slide_idx = controlled_slider.find('[data-slide-number="'+slide_number+'"]').index();
								TRX_ADDONS_STORAGE['swipers'][controlled_id].slideTo(slide_idx);
							}
							slider.trigger('slide_change_start');
						},
						onSlideChangeEnd: function (swiper) {
							var slide_number = jQuery(swiper.slides[swiper.activeIndex]).data('slide-number');
							// Change outside title
							var titles = cont.find('.slider_titles_outside_wrap .slide_info');
							if (titles.length > 0) {
								//titles.eq((swiper.activeIndex-1)%titles.length).addClass('active').fadeIn();
								titles.eq(slide_number).addClass('active').fadeIn(300);
							}
							// Mark active custom pagination bullet
							cont.find('.swiper-pagination-custom > span')
								.removeClass('swiper-pagination-button-active')
								.eq(slide_number)
								.addClass('swiper-pagination-button-active');
							// Remove video
							cont.find('.trx_addons_video_player.with_cover.video_play').removeClass('video_play').find('.video_embed').empty();
							// Unlock slider/controller
							slider.attr('data-busy', 0);
							slider.trigger('slide_change_end');
						}
					});
					slider.trigger('slider_init');
					// Custom pagination
					cont.find('.swiper-pagination-custom').on('click', '>span', function(e) {
						jQuery(this).siblings().removeClass('swiper-pagination-button-active');
						var t = jQuery(this).addClass('swiper-pagination-button-active').index()
								* TRX_ADDONS_STORAGE['swipers'][id].params.slidesPerGroup;
						TRX_ADDONS_STORAGE['swipers'][id].params.loop && (t += TRX_ADDONS_STORAGE['swipers'][id].loopedSlides),
						TRX_ADDONS_STORAGE['swipers'][id].slideTo(t);
						e.preventDefault();
						return false;
					});

					slider.attr('data-busy', 1).animate({'opacity':1}, 'fast');
					setTimeout(function() { 
						slider.attr('data-busy', 0); 
						trx_addons_set_controller_height(controller_id, slider);
					}, 300);
					
					// Generate 'scroll' event after the slider is showed
					jQuery(window).trigger('scroll');
				});
		}
				
	
		// ElastiStack Slider
		if (container.find('.slider_elastistack:not(.inited)').length > 0) {
			container.find('.slider_elastistack:not(.inited)')
				.each(function () {
	
					// If slider inside the invisible block - exit
					if (jQuery(this).parents('div:hidden,article:hidden').length > 0)
						return;
					
					// Check attr id for slider. If not exists - generate it
					var slider = jQuery(this);
					var id = slider.attr('id');
					if (id == undefined) {
						id = 'elastistack_'+Math.random();
						id = id.replace('.', '');
						slider.attr('id', id);
					}
					var cont = slider.parent().hasClass('slider_outer') ? slider.parent().attr('id', id+'_outer') : slider;
					var cont_id = cont.attr('id');
					var images = slider.find('ul.stack__images').attr('id', id+'_images');
					var images_id = images.attr('id');
					
					slider.css({
						'display': 'block',
						'opacity': 0
						})
						.addClass(id)
						.addClass('inited')
						.data('settings', {mode: 'horizontal'});		// VC hook
					
					// Set height for images container before init to make stack
					trx_addons_resize_sliders(e, cont);
					
					var stack = new ElastiStack( images.get(0), {
							onUpdateStack : function(idx) {
								// Change outside title
								var titles = cont.find('.slider_titles_outside_wrap');
								if (titles.length > 0) {
									titles.find('.active').removeClass('active').hide();
									titles.find('.slide_info').eq(idx).addClass('active').fadeIn(300);
								}
								// Remove video
								cont.find('.trx_addons_video_player.with_cover.video_play').removeClass('video_play').find('.video_embed').empty();
								slider.trigger('slide_change_end');
							}
						});

					// Next button
					cont.find('.slider_next').on('click', function(e) {
						stack.nextItem( { transform : 'translate3d(0, -60px, 400px)' } );
						e.preventDefault();
						return false;
					});
					
					// Activate first title
					cont.find('.slider_titles_outside_wrap .slide_info').eq(0).addClass('active').fadeIn(300);

					// Show slider
					slider.animate({'opacity':1}, 'fast', function() {
						stack._setStackStyle();
					});
				});
		}
	}
	
	
	// Init previously hidden sliders with engine=swiper
	function trx_addons_init_hidden_sliders(e, container) {
		// Init sliders in this container
		trx_addons_init_sliders(e, container);
		// Check slides per view on current window size
		trx_addons_resize_sliders(e, container);
	}
	
	// Sliders: Resize
	jQuery(document).on('action.resize_trx_addons', trx_addons_resize_sliders);
	function trx_addons_resize_sliders(e, container) {
		if (container === undefined) container = jQuery('body');
		container.find('.slider_container.inited').each(function() {

			// If slider in the hidden block - don't resize it
			var slider = jQuery(this);
			if (slider.parents('div:hidden,article:hidden').length > 0) return;
			var id = slider.attr('id');
	
			var direction = slider.data('direction');
			if (direction != 'vertical') direction = 'horizontal';
			var slider_width = slider.width();
			var last_width = slider.data('last-width');
			if (isNaN(last_width)) last_width = 0;
			if (last_width==0 || last_width!=slider_width) {
				if (direction != 'vertical') slider.data('last-width', slider_width);
				// Need to call onResize handlers
				var on_resize = false;
				// Change slides_per_view
				var spv = slider.data('slides-per-view');
				if (spv == undefined || slider.parents('.widget_nav_menu').length > 0) {
					spv = 1;
				}
				if (slider.hasClass('slider_swiper')) {
					if (TRX_ADDONS_STORAGE['swipers'][id].params.slidesPerView != 'auto') {
						if (direction=='horizontal') {
							var smw = slider.data('slides-min-width');
							if (slider_width / spv < smw) {
								spv = Math.max(1, Math.floor(slider_width / smw));
							}
							if (TRX_ADDONS_STORAGE['swipers'][id].params.slidesPerView != spv) {
								TRX_ADDONS_STORAGE['swipers'][id].params.slidesPerView = spv;
								TRX_ADDONS_STORAGE['swipers'][id].params.loopedSlides = spv;
								//TRX_ADDONS_STORAGE['swipers'][id].reInit();
							}
						}
						on_resize = true;
					}
				}
				// Change slider height
				if ( !slider.hasClass('slider_noresize') || slider.height()==0 ) {
					var slide = slider.find('.slider-slide').eq(0);
					var slide_width = slide.width();
					var slide_height = slide.height();
					var ratio = slider.data('ratio');
					if (ratio===undefined || (''+ratio).indexOf(':')<1) {
						ratio = slide_height > 0 ? slide_width+':'+slide_height : "16:9";
						slider.attr('data-ratio', ratio);
					}
					ratio = ratio.split(':');
					var ratio_x = !isNaN(ratio[0]) ? Number(ratio[0]) : 16;
					var ratio_y = !isNaN(ratio[1]) ? Number(ratio[1]) : 9;
					var height = Math.floor((spv==1 ? slider_width : slide_width)/ratio_x*ratio_y);
					slider.height(height);
					on_resize = true;
					/*
					// Move outside titles
					if (slider.next('.slider_titles_outside_wrap').length == 1) {
						slider.next('.slider_titles_outside_wrap').css({'top': height+'px'});
					}
					*/
					if (slider.hasClass('slider_elastistack')) {
						slider.find('.slider-wrapper,.stack__images,.slider-slide').height(height);
					}
					// Change controller height
					trx_addons_set_controller_height(slider.data('controller'), slider);
				}
				// Call onResize handlers
				if (on_resize && slider.hasClass('slider_swiper') && typeof TRX_ADDONS_STORAGE['swipers'][id].onResize !== 'undefined')
					TRX_ADDONS_STORAGE['swipers'][id].onResize();

			}
		});
	}
	
	// Set controller height
	function trx_addons_set_controller_height(controller_id, slider) {
		var controller = controller_id ? jQuery('#'+controller_id) : false;
		if (controller && controller.length > 0 
			&& controller.hasClass('sc_slider_controller_vertical') 
			&& controller.hasClass('sc_slider_controller_height_auto')) {
			if (jQuery(window).width() >= 768) {
				var paddings = parseFloat(controller.css('paddingTop'));
				if (isNaN(paddings)) paddings = 0;
				controller.find('.slider_container').height(slider.height() - 2*paddings);
			} else {
				var controller_spv = controller.data('slides-per-view');
				if (isNaN(controller_spv)) controller_spv = 1;
				controller.find('.slider_container').height(controller_spv*100);
			}
		}
	}

})();