/**
 * Shortcode Skills
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

/* global jQuery:false */
/* global TRX_ADDONS_STORAGE:false */

(function() {

	"use strict";
	
	jQuery(document).on('action.init_hidden_elements', trx_addons_sc_skills_init);
	jQuery(document).on('action.scroll_trx_addons', trx_addons_sc_skills_init);
	jQuery(document).on('action.resize_trx_addons', trx_addons_sc_skills_resize);
	
	// Skills init
	function trx_addons_sc_skills_init(e, container) {
	
		if (container === undefined) container = jQuery('body');
	
		var scrollPosition = jQuery(window).scrollTop() + jQuery(window).height();
	
		container.find('.sc_skills_item:not(.inited)').each(function () {
			var skillsItem = jQuery(this);
			// If item now invisible
			if (jQuery(this).parents('div:hidden,article:hidden').length > 0) {
				return;
			}
			var scrollSkills = skillsItem.offset().top;
			if (scrollPosition > scrollSkills) {
				var init_ok = true;
				var skills = skillsItem.parents('.sc_skills').eq(0);
				var type = skills.data('type');
				var total = (type=='pie' && skills.hasClass('sc_skills_compact_on')) 
								? skillsItem.find('.sc_skills_data .pie') 
								: skillsItem.find('.sc_skills_total').eq(0);
				var start = parseFloat(total.data('start'));
				var stop = parseFloat(total.data('stop'));
				var maximum = parseInt(total.data('max'), 10);
				var startPercent = Math.round(start/maximum*100);
				var stopPercent = Math.round(stop/maximum*100);
				var ed = total.data('ed');
				var speed = parseInt(total.data('speed'), 10);
				var step = start!=parseInt(start, 10) || stop!=parseInt(stop, 10)
							? parseFloat(total.data('step'))
							: parseInt(total.data('step'), 10);
				var duration = parseInt(total.data('duration'), 10);
				if (isNaN(duration)) duration = Math.ceil(maximum/step)*speed;
				
				if (type == 'bar') {
					var dir = skills.data('dir');
					var count = skillsItem.find('.sc_skills_count').eq(0);
					if (dir=='horizontal')
						count.css('width', startPercent + '%').animate({ width: stopPercent + '%' }, duration);
					else if (dir=='vertical')
						count.css('height', startPercent + '%').animate({ height: stopPercent + '%' }, duration);
					trx_addons_sc_skills_animate_counter(start, stop, speed, step, ed, total);
				
				} else if (type == 'counter') {
					trx_addons_sc_skills_animate_counter(start, stop, speed, step, ed, total);
	
				} else if (type == 'pie') {
					if (window.Chart) {
						var steps = parseInt(total.data('steps'), 10);
						var bg_color = total.data('bg_color');
						var border_color = total.data('border_color');
						var cutout = parseInt(total.data('cutout'), 10);
						var easing = total.data('easing');
						var options = {
							segmentShowStroke: border_color!='',
							segmentStrokeColor: border_color,
							segmentStrokeWidth: border_color!='' ? 1 : 0,
							percentageInnerCutout: cutout,
							animation: skillsItem.parents('.vc_row[data-vc-full-width="true"]').length==0,
							animationSteps: steps,
							animationEasing: easing,
							animateRotate: true,
							animateScale: skillsItem.parents('.vc_row[data-vc-full-width="true"]').length==0,
						};
						var pieData = [];
						total.each(function() {
							var color = jQuery(this).data('color');
							var stop = parseInt(jQuery(this).data('stop'), 10);
							var stopPercent = Math.round(stop/maximum*100);
							pieData.push({
								value: stopPercent,
								color: color
							});
						});
						if (total.length == 1) {
							trx_addons_sc_skills_animate_counter(start, stop, Math.round(1500/steps), step, ed, total);
							pieData.push({
								value: 100-stopPercent,
								color: bg_color
							});
						}
						var canvas = skillsItem.find('canvas');
						canvas
							.data('pie-data', pieData)
							.data('pie-options', options)
							.attr({width: skillsItem.width(), height: skillsItem.width()})
							.css({width: skillsItem.width(), height: skillsItem.height()});
						new Chart(canvas.get(0).getContext("2d")).Doughnut(pieData, options);
					} else
						init_ok = false;
				}
				if (init_ok) skillsItem.addClass('inited');
			}
		});
	}
	
	// Skills counter animation
	function trx_addons_sc_skills_animate_counter(start, stop, speed, step, ed, total) {
		start = Math.min(stop, start + step);
		// Example of format output number: leave 2 decimals and separate it with ',' and use dot '.' as thousands delimiter
		//total.text(Number(start).formatMoney(2, ',', '.')+ed);
		total.text(start+ed);
		if (start < stop) {
			setTimeout(function () {
				trx_addons_sc_skills_animate_counter(start, stop, speed, step, ed, total);
			}, speed);
		}
	}

	// Resize Pie Skills
	function trx_addons_sc_skills_resize() {
		jQuery('.sc_skills_pie canvas').each(function () {
			var canvas = jQuery(this);
			// If item now invisible
			if (canvas.parents('div:hidden,article:hidden').length > 0) {
				return;
			}
			var skillsItem = canvas.parent();
			if (skillsItem.width() != canvas.width()) {
				var data = canvas.data('pie-data');
				var opt = canvas.data('pie-options');
				if (data === undefined || opt === undefined) return;
				canvas.empty()
					.attr({width: skillsItem.width(), height: skillsItem.width()})
					.css({width: skillsItem.width(), height: skillsItem.height()});
				opt.animation = false;
				new Chart(canvas.get(0).getContext("2d")).Doughnut(data, opt);
			}
		});
	}

})();