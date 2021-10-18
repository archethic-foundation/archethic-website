var cq_notify_easein_arr = ['tada', 'swing', 'shake', 'bounce', 'wobble', 'pulse', 'rollIn', 'fadeIn', 'fadeInUp', 'fadeInDown', 'fadeInLeft', 'fadeInRight', 'fadeInRight', 'bounceIn', 'bounceInDown', 'bounceInUp', 'bounceInLeft', 'bounceInRight', 'rotateIn', 'rotateInDownLeft', 'rotateInDownRight', 'rotateInUpLeft', 'rotateInUpRight', 'fadeInLeftBig', 'fadeInRightBig', 'fadeInUpBig', 'fadeInDownBig', 'flipInX', 'flipInY', 'lightSpeedIn'];
var cq_notify_easeout_arr = ['rollOut', 'fadeOut', 'fadeOutUp', 'fadeOutDown', 'fadeOutLeft', 'fadeOutRight', 'fadeOutRight', 'bounceOut', 'bounceOutDown', 'bounceOutUp', 'bounceOutLeft', 'bounceOutRight', 'rotateOut', 'rotateOutDownLeft', 'rotateOutDownRight', 'rotateOutUpLeft', 'rotateOutUpRight', 'fadeOutLeftBig', 'fadeOutRightBig', 'fadeOutUpBig', 'fadeOutDownBig', 'flipOutX', 'flipOutY', 'lightSpeedOut'];
;(function($){
	"use strict";
	$.fn.extend({
		scrollNotify: function(options) {
	      	// plugin default options, it's extendable
			var settings = {
				// container: '#cq-scroll-notification',
				opacity: 100,
				imageWidth: 80,
				width: 300,
				height: 'auto',
				background: '#FFF',
				color: '#CCC',
				imageFloat: 'right',
				position: 'topLeft',
				top: '',
				right: '',
				bottom: '',
				left: '',
				appearFrom: 0,
				appearTo: 'all',
				easeIn: 'fadeInUp',
				easeOut: 'fadeOutDown',
				autohideDelay: '',
				initShow: 'scrolling',
				displayDefault: '',
				closeButton: false,
				pauseHover: true
			};
  			// extends settings with options provided
	        if (options) {
				$.extend(settings, options);
			}
			var _this = this.css({
				'background': settings.background,
				'color': settings.color
			});
			_this.css('top', settings.top);
			_this.css('right', settings.right);
			_this.css('bottom', settings.bottom);
			_this.css('left', settings.left);

			if(settings.initShow=="loaded"){
				if(!$.cookie('cq_notify_close_cookie')) _this.show();
			}else{
				_this.hide();
			}


			var _easeinNum = cq_notify_easein_arr.length;
			var _easeoutNum = cq_notify_easeout_arr.length;
			var _easeIn, _easeOut;
			if(settings.easeIn.toLowerCase()=="random"){
				_easeIn = cq_notify_easein_arr[Math.floor(Math.random()*_easeinNum)];
				_this.data('easein', _easeIn);
			}else{
				_easeIn = settings.easeIn;
			}
			if(settings.easeOut.toLowerCase()=="random"){
				_easeOut = cq_notify_easeout_arr[Math.floor(Math.random()*_easeoutNum)];
			}else{
				_easeOut = settings.easeOut;
			}
			if(settings.closeButton){
				var _closeButton = $('<span class="cq-notify-closebutton"></span>')
				if(settings.closePosition=="left"){
					_closeButton.css({
						left: '-8px'
					});
				}
				_this.append(_closeButton);
				_closeButton.on('click', _this, function(event) {
					_appearFrom = $(document).height();
					event.preventDefault();
					clearTimeout(_hideID);
					if(Modernizr.csstransitions){
						_this.removeClass(_easeIn).addClass('animated '+_easeOut).on('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function(event) {
									$(this).hide();
								});
					}else{
						_this.stop(true, true).animate({
							'opacity': 0},
							400, function() {
								$(this).hide();
						});
					}
					if(settings.cookie=="on"){
					    $.cookie('cq_notify_close_cookie', true, { expires: settings.days, path: '/' });
					}
				});
			}
			if(settings.width!="") _this.css('width', settings.width);
			if(settings.height!="") _this.css('height', settings.height);
			if(settings.opacity!=1){
				// _this.css('opacity', settings.opacity);
				var _oldBg = _this.css('backgroundColor'); //rgb(100,100,100)
				var _newBg = _oldBg.replace('rgb', 'rgba').replace(')', ','+settings.opacity+')'); //rgba(100,100,100,.8)
				_this.css({backgroundColor: _newBg});
			}
			if(_this.find('.cq-notify-image')){
				_this.find('.cq-notify-image').addClass('float'+settings.imageFloat)
				if(settings.imageWidth!=""){
					_this.find('.cq-notify-image').css('width', settings.imageWidth);
				}
			}

			if(settings.pauseHover){
				_this.on('mouseover', function(event) {
					clearTimeout(_hideID);
				});
			}

			var _hideID = 0;
			var _appearFrom = settings.appearFrom;
			if(settings.cookie!="on")$.removeCookie('cq_notify_close_cookie', {path: '/' });
			if($.cookie('cq_notify_close_cookie')) {
				_this.hide();
				return;
			}
			$(window).on('scroll', function(event) {
				// if($(this).scrollTop()<=0){
					// _appearFrom = settings.appearFrom;
				// }
				if(settings.displayDefault=="on"){
					if(Modernizr.csstransitions){
						if($(this).scrollTop()>0){
							_this.removeClass(_easeIn).addClass('animated '+_easeOut).on('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function(event) {
									$(this).hide();
								});
						}else{
							_this.off('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd');
								_this.show().removeClass(_easeOut).addClass('animated '+ _easeIn);
								if(settings.autohideDelay!=''&&settings.autohideDelay>0){
									// clearTimeout(_hideID);
									_hideID = setTimeout(function() {
										_this.removeClass(_easeIn).addClass(_easeOut).on('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function(event) {
												$(this).hide();
										});
									}, settings.autohideDelay);
								}

						}

					}else{
						if($(this).scrollTop()>0){
							_this.stop(true, true).animate({
								'opacity': 0},
								400, function() {
									$(this).hide();
							});
						}else{
							_this.show().animate({opacity: 1}, 400);
								if(settings.autohideDelay!=''&&settings.autohideDelay>0){
									_hideID = setTimeout(function() {
										_this.stop(true, true).animate({
											'opacity': 0},
											400, function() {
												$(this).hide();
										});
									}, settings.autohideDelay);
								}


						}
					}
					return false;

				}
				clearTimeout(_hideID);
				if($(this).scrollTop()<=_appearFrom&&settings.initShow=="scrolling"){
					if(Modernizr.csstransitions){
						_this.removeClass(_easeIn).addClass('animated '+_easeOut).on('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function(event) {
									$(this).hide();
								});
					}else{
						_this.stop(true, true).animate({
							'opacity': 0},
							400, function() {
								$(this).hide();
						});
					}
				}else{
					if(settings.appearTo!="all"){
						// display in a position range
						if($(this).scrollTop()<=settings.appearTo){
							if(Modernizr.csstransitions){
								_this.off('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd');
								_this.show().removeClass(_easeOut).addClass('animated '+ _easeIn);
								if(settings.autohideDelay!=''&&settings.autohideDelay>0){
									// clearTimeout(_hideID);
									_hideID = setTimeout(function() {
										_this.removeClass(_easeIn).addClass(_easeOut).on('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function(event) {
												$(this).hide();
										});
									}, settings.autohideDelay);
								}
							}else{
								_this.show().animate({opacity: 1}, 400);
								if(settings.autohideDelay!=''&&settings.autohideDelay>0){
									_hideID = setTimeout(function() {
										_this.stop(true, true).animate({
											'opacity': 0},
											400, function() {
												$(this).hide();
										});
									}, settings.autohideDelay);
								}
							}

						}else{
							if(Modernizr.csstransitions){
								_this.removeClass(_easeIn).addClass(_easeOut).on('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function(event) {
									$(this).hide();
								});
							}else{
								_this.stop(true, true).animate({
									'opacity': 0},
									400, function() {
										$(this).hide();
								});
							}
						}

					}else{
						// display in whole window
						if(Modernizr.csstransitions){
							_this.off('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd');
							_this.show().removeClass(_easeOut).addClass('animated '+ _easeIn);
							if(settings.autohideDelay!=''&&settings.autohideDelay>0){
								// clearTimeout(_hideID);
								_hideID = setTimeout(function() {
									_this.removeClass(_easeIn).addClass(_easeOut).on('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function(event) {
											$(this).hide();
										});
								}, settings.autohideDelay);
							}
						}else{
							_this.show().animate({opacity: 1}, 400);
							if(settings.autohideDelay!=''&&settings.autohideDelay>0){
								_hideID = setTimeout(function() {
									_this.stop(true, true).animate({
										'opacity': 0},
										400, function() {
											$(this).hide();
									});
								}, settings.autohideDelay);
							}

						}

					}
				}
			});
		}

	});

})(jQuery);

jQuery(document).ready(function($) {
	jQuery('#cq-scroll-notification').each(function() {
		jQuery(this).scrollNotify({
			opacity: jQuery(this).data('opacity'),
			imageWidth: jQuery(this).data('imagewidth'),
			width: jQuery(this).data('width'),
			height: jQuery(this).data('height'),
			background: jQuery(this).data('background'),
			color: jQuery(this).data('textcolor'),
			imageFloat: jQuery(this).data('imagefloat'),
			position: jQuery(this).data('position'),
			top: jQuery(this).data('positiontop'),
			right: jQuery(this).data('positionright'),
			bottom: jQuery(this).data('positionbottom'),
			left: jQuery(this).data('positionleft'),
			appearFrom: jQuery(this).data('from'),
			appearTo: jQuery(this).data('to'),
			easeIn: jQuery(this).data('easein'),
			easeOut: jQuery(this).data('easeout'),
			autohideDelay: jQuery(this).data('autohidedelay'),
			closeButton : jQuery(this).data('closebutton'),
			closePosition : jQuery(this).data('closeposition'),
			cookie : jQuery(this).data('cookie'),
			days : jQuery(this).data('days'),
			autohideDelay : jQuery(this).data('autohidedelay'),
			displayDefault : jQuery(this).data('displaybydefault'),
			initShow: jQuery(this).data('displaywhen')
	    })
	});
});
