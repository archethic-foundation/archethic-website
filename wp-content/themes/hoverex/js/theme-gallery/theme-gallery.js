// GalleryFx - animated gallery items with preview mode
;(function(window) {

	'use strict';

	if (!window.Modernizr) return;

	var support = { transitions: Modernizr.csstransitions },
		// transition end event name
		transEndEventNames = { 'WebkitTransition': 'webkitTransitionEnd', 'MozTransition': 'transitionend', 'OTransition': 'oTransitionEnd', 'msTransition': 'MSTransitionEnd', 'transition': 'transitionend' },
		transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
		onEndTransition = function( el, callback ) {
			var onEndCallbackFn = function( e ) {
				if ( support.transitions ) {
					if ( e.target != this ) return;
					this.removeEventListener( transEndEventName, onEndCallbackFn );
				}
				if( callback && typeof callback === 'function' ) { callback.call(this); }
			};
			if ( support.transitions ) {
				el.addEventListener( transEndEventName, onEndCallbackFn );
			} else {
				onEndCallbackFn();
			}
		};

	// some helper functions
	function throttle(fn, delay) {
		var allowSample = true;
		return function(e) {
			if (allowSample) {
				allowSample = false;
				setTimeout(function() { allowSample = true; }, delay);
				fn(e);
			}
		};
	}
	function nextSibling(el) {
		var nextSibling = el.nextSibling;
		while (nextSibling && nextSibling.nodeType != 1) {
			nextSibling = nextSibling.nextSibling
		}
		return nextSibling;
	}
	function extend( a, b ) {
		for ( var key in b ) { 
			if ( b.hasOwnProperty( key ) ) {
				a[key] = b[key];
			}
		}
		return a;
	}

	// GalleryFx obj
	function GalleryFx(el, options) {
		this.galleryEl = el;
		this.options = extend( {}, this.options );
		extend( this.options, options );
		
		this.items = [].slice.call(this.galleryEl.querySelectorAll('.post_layout_gallery'));

		if (jQuery(this.galleryEl).next('.gallery_preview').length == 0) {
			jQuery(this.galleryEl).after('<div class="gallery_preview'+(this.options.previewClass ? ' '+this.options.previewClass : '')+'">\
				<a href="#" class="gallery_preview_close icon-cancel"></a>\
				<div class="gallery_preview_description"></div>\
			</div>');
		}
		this.previewEl = nextSibling(this.galleryEl);
		this.isExpanded = false;
		this.isAnimating = false;
		this.closeCtrl = this.previewEl.querySelector('.gallery_preview_close');
		this.previewDescriptionEl = this.previewEl.querySelector('.gallery_preview_description');

		this._init();
	}

	// options
	GalleryFx.prototype.options = {
		pagemargin : 0,						// Additional margins for the preview window
		imgPosition : { x : 1, y : 1 },		// Preview window size
											// x and y can have values from 0 to 1 (percentage).
											// If negative then it means the alignment is left and/or top rather than right and/or bottom
											// So, as an example, if we want our large image to be positioned vertically on 25% of the screen and centered horizontally the values would be x:1,y:-0.25
		previewClass : '',					// Extra class for the preview block
		onInit : function(instance) { return false; },
		onResize : function(instance) { return false; },
		onOpenItem : function(instance, item) { return false; },
		onCloseItem : function(instance, item) { return false; },
		onExpand : function() { return false; }
	}

	GalleryFx.prototype._init = function() {
		// callback
		this.options.onInit(this);

		var self = this;
		// init masonry after all images are loaded
		imagesLoaded( this.galleryEl, function() {
			// init/bind events
			self._initEvents();
			// create the large image and append it to the DOM
			self._setOriginal();
			// create the clone image and append it to the DOM
			self._setClone();
		});
	};

	GalleryFx.prototype.appendItems = function() {
		// init/bind events
		this.items = [].slice.call(this.galleryEl.querySelectorAll('.post_layout_gallery'));
		this._initEvents();
	};


	// initialize/bind events
	GalleryFx.prototype._initEvents = function () {
		var self = this,
			clickEvent = (document.ontouchstart!==null ? 'click' : 'touchstart');

		this.items.forEach(function(item) {
			if (classie.has(item, 'inited')) return;
			classie.add(item, 'inited');

			var touchend = function(e) {
					e.preventDefault();
					self._openItem(e, item);
					item.removeEventListener('touchend', touchend);	
				},
				touchmove = function(e) {
					item.removeEventListener('touchend', touchend);	
				},
				manageTouch = function() {
					item.addEventListener('touchend', touchend);
					item.addEventListener('touchmove', touchmove);
				};

			item.addEventListener(clickEvent, function(e) {
				if (clickEvent === 'click') {
					e.preventDefault();
					self._openItem(e, item);
				} else {
					manageTouch();
				}
			});
		});

		// close expanded image
		this.closeCtrl.addEventListener('click', function(e) {
			self._closeItem(); 
			e.preventDefault();
			return false;
		});

		window.addEventListener('resize', throttle(function(e) {
			// callback
			self.options.onResize(self);
		}, 10));
	}

	// open a gallery item
	GalleryFx.prototype._openItem = function(ev, item) {
		if ( this.isAnimating || this.isExpanded ) return;
		this.isAnimating = true;
		this.isExpanded = true;

		// item's image
		var galleryImg = item.querySelector('img'),
			galleryImgOffset = galleryImg.getBoundingClientRect();

		// index of current item
		this.current = this.items.indexOf(item);

		// set the src of the original image element (large image)
		this._setOriginal(item.getAttribute('data-src'));
		
		// callback
		this.options.onOpenItem(this, item);

		// set the clone image
		this._setClone(galleryImg.src, {
			width : galleryImg.offsetWidth,
			height : galleryImg.offsetHeight,
			left : galleryImgOffset.left,
			top : galleryImgOffset.top
		});

		// hide original gallery item
		classie.add(item, 'gallery_item_current');

		// calculate the transform value for the clone to animate to the full image view
		var win = this._getWinSize(),
			originalSizeArr = item.getAttribute('data-size').split('x'),
			originalSize = {width: originalSizeArr[0], height: originalSizeArr[1]},
			dx = ((this.options.imgPosition.x > 0 ? 1-Math.abs(this.options.imgPosition.x) : Math.abs(this.options.imgPosition.x)) * win.width + this.options.imgPosition.x * win.width/2) - galleryImgOffset.left - 0.5 * galleryImg.offsetWidth,
			dy = ((this.options.imgPosition.y > 0 ? 1-Math.abs(this.options.imgPosition.y) : Math.abs(this.options.imgPosition.y)) * win.height + this.options.imgPosition.y * win.height/2) - galleryImgOffset.top - 0.5 * galleryImg.offsetHeight,
			z = Math.min( Math.min(win.width*Math.abs(this.options.imgPosition.x) - this.options.pagemargin, originalSize.width - this.options.pagemargin)/galleryImg.offsetWidth, Math.min(win.height*Math.abs(this.options.imgPosition.y) - this.options.pagemargin, originalSize.height - this.options.pagemargin)/galleryImg.offsetHeight );

		// apply transform to the clone
		this.cloneImg.style.WebkitTransform = 'translate3d(' + dx + 'px, ' + dy + 'px, 0) scale3d(' + z + ', ' + z + ', 1)';
		this.cloneImg.style.transform = 'translate3d(' + dx + 'px, ' + dy + 'px, 0) scale3d(' + z + ', ' + z + ', 1)';

		// add the description if any
		var descriptionEl = item.querySelector('.post_details');
		if( descriptionEl ) {
			this.previewDescriptionEl.innerHTML = descriptionEl.innerHTML;
		}

		var self = this;
		setTimeout(function() { 
			// controls the elements inside the expanded view
			classie.add(self.previewEl, 'gallery_preview_show');
			// callback
			self.options.onExpand();
		}, 0);

		// after the clone animates..
		onEndTransition(this.cloneImg, function() {
			// when the original/large image is loaded..
			imagesLoaded(self.originalImg, function() {
				// close button just gets shown after the large image gets loaded
				classie.add(self.previewEl, 'gallery_preview_image_loaded');
				// animate the opacity to 1
				self.originalImg.style.opacity = 1;
				// and once that's done..
				onEndTransition(self.originalImg, function() {
					// reset cloneImg
					self.cloneImg.style.opacity = 0;
					self.cloneImg.style.WebkitTransform = 'translate3d(0,0,0) scale3d(1,1,1)';
					self.cloneImg.style.transform = 'translate3d(0,0,0) scale3d(1,1,1)';
					// end animating
					self.isAnimating = false;
				});
			});	
		});
	};

	// create/set the original/large image element
	GalleryFx.prototype._setOriginal = function(src) {
		if (!src) {
			this.originalImg = document.createElement('img');
			this.originalImg.className = 'gallery_preview_image_original';
			this.originalImg.style.opacity = 0;
			this.originalImg.style.maxWidth = 'calc(' + parseInt(Math.abs(this.options.imgPosition.x)*100) + 'vw - ' + this.options.pagemargin + 'px)';
			this.originalImg.style.maxHeight = 'calc(' + parseInt(Math.abs(this.options.imgPosition.y)*100) + 'vh - ' + this.options.pagemargin + 'px)';
			// need it because of firefox
			this.originalImg.style.WebkitTransform = 'translate3d(0,0,0) scale3d(1,1,1)';
			this.originalImg.style.transform = 'translate3d(0,0,0) scale3d(1,1,1)';
			src = '';
			this.previewEl.appendChild(this.originalImg);
		}

		this.originalImg.setAttribute('src', src);
	};

	// create/set the clone image element
	GalleryFx.prototype._setClone = function(src, settings) {
		if (!src) {
			this.cloneImg = document.createElement('img');
			this.cloneImg.className = 'gallery_preview_image_clone';
			src = '';
			this.cloneImg.style.opacity = 0;
			this.previewEl.appendChild(this.cloneImg);
		} else {
			this.cloneImg.style.opacity = 1;
			// set top/left/width/height of gallery item's image to the clone
			this.cloneImg.style.width = settings.width  + 'px';
			this.cloneImg.style.height = settings.height  + 'px';
			this.cloneImg.style.top = settings.top  + 'px';
			this.cloneImg.style.left = settings.left  + 'px';
		}

		this.cloneImg.setAttribute('src', src);
	};

	// close the original/large image view
	GalleryFx.prototype._closeItem = function() {

		if ( !this.isExpanded || this.isAnimating ) return;
		this.isExpanded = false;
		this.isAnimating = true;

		// the gallery item's image and its offset
		var galleryItem = this.items[this.current],
			galleryImg = galleryItem.querySelector('img'),
			galleryImgOffset = galleryImg.getBoundingClientRect(),
			self = this;

		classie.remove(this.previewEl, 'gallery_preview_show');
		classie.remove(this.previewEl, 'gallery_preview_image_loaded');
		
		// callback
		this.options.onCloseItem(this, galleryItem);

		// large image will animate back to the position of its gallery's item
		classie.add(this.originalImg, 'gallery_preview_image_animate');

		// set the transform to the original/large image
		var win = this._getWinSize(),
			dx = galleryImgOffset.left + galleryImg.offsetWidth/2 - ((this.options.imgPosition.x > 0 ? 1-Math.abs(this.options.imgPosition.x) : Math.abs(this.options.imgPosition.x)) * win.width + this.options.imgPosition.x * win.width/2),
			dy = galleryImgOffset.top + galleryImg.offsetHeight/2 - ((this.options.imgPosition.y > 0 ? 1-Math.abs(this.options.imgPosition.y) : Math.abs(this.options.imgPosition.y)) * win.height + this.options.imgPosition.y * win.height/2),
			z = galleryImg.offsetWidth/this.originalImg.offsetWidth;

		this.originalImg.style.WebkitTransform = 'translate3d(' + dx + 'px, ' + dy + 'px, 0) scale3d(' + z + ', ' + z + ', 1)';
		this.originalImg.style.transform = 'translate3d(' + dx + 'px, ' + dy + 'px, 0) scale3d(' + z + ', ' + z + ', 1)';	
		
		// once that's done..
		onEndTransition(this.originalImg, function() {
			// clear description
			self.previewDescriptionEl.innerHTML = '';
			// show original gallery item
			classie.remove(galleryItem, 'gallery_item_current');
			// fade out the original image
			setTimeout(function() { self.originalImg.style.opacity = 0;	}, 60);
			// and after that
			onEndTransition(self.originalImg, function() {
				// reset original/large image
				classie.remove(self.originalImg, 'animate');
				self.originalImg.style.WebkitTransform = 'translate3d(0,0,0) scale3d(1,1,1)';
				self.originalImg.style.transform = 'translate3d(0,0,0) scale3d(1,1,1)';
				// end animating
				self.isAnimating = false;
			});
		});
	};

	// gets the window sizes
	GalleryFx.prototype._getWinSize = function() {
		return {
			width: document.documentElement.clientWidth,
			height: window.innerHeight
		};
	};

	window.GalleryFx = GalleryFx;
	
	
	// Create and init GalleryFx object
	jQuery(document).on('action.init_hidden_elements', function(e, cont) {

		cont.find('.portfolio_wrap,.masonry_wrap,.post_format_gallery .gallery').each(function() {
			
			var portfolio = jQuery(this);
			if (portfolio.parents('div:hidden,article:hidden').length > 0) return;
			if (!portfolio.hasClass('inited')) {
				if (!portfolio.hasClass('gallery_wrap')) portfolio.addClass('inited');
				var portfolio_dom = portfolio.get(0);
				// init masonry after all images are loaded
				imagesLoaded( portfolio_dom, function() {
					// item selector
					var selector = portfolio.hasClass('portfolio_wrap') 
										? '.post_layout_portfolio' 
										: (portfolio.hasClass('gallery') 
											? '.gallery-item'
											: '.masonry_item')
					// initialize masonry
					portfolio.masonry({
						itemSelector: selector,
						columnWidth: selector,
						percentPosition: true
					});
					jQuery(window).trigger('resize');
				});
			} else {
				// Relayout after 
				setTimeout(function() { portfolio.masonry(); }, 310);
			}
		});
		
		var support = { transitions: Modernizr.csstransitions },
			// transition end event name
			transEndEventNames = { 'WebkitTransition': 'webkitTransitionEnd', 'MozTransition': 'transitionend', 'OTransition': 'oTransitionEnd', 'msTransition': 'MSTransitionEnd', 'transition': 'transitionend' },
			transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
			onEndTransition = function( el, callback ) {
				var onEndCallbackFn = function( e ) {
					if ( support.transitions ) {
						if( e.target != this ) return;
						this.removeEventListener( transEndEventName, onEndCallbackFn );
					}
					if ( callback && typeof callback === 'function' ) { callback.call(this); }
				};
				if ( support.transitions ) {
					el.addEventListener( transEndEventName, onEndCallbackFn );
				} else {
					onEndCallbackFn();
				}
			};
	
		
		cont.find('.gallery_wrap:not(.inited)').each(function(idx) {
			if (jQuery(this).parents('div:hidden,article:hidden').length > 0) return;
			if (!HOVEREX_STORAGE['GalleryFx']) HOVEREX_STORAGE['GalleryFx'] = {};
			var id = jQuery(this).addClass('inited').attr('id');
			if (id == undefined) {
				id = 'gallery_fx_'+Math.random();
				id = id.replace('.', '');
				jQuery(this).attr('id', id);
			}
			HOVEREX_STORAGE['GalleryFx'][id] = new GalleryFx(this, {
				previewClass: 'scheme_dark',
				imgPosition: {
					x: -0.5,
					y: 1
				},
				onOpenItem: function(instance, item) {
					instance.items.forEach(function(el) {
						if (item != el) {
							var delay = Math.floor(Math.random() * 50);
							el.style.WebkitTransition = 'opacity .5s ' + delay + 'ms cubic-bezier(.7,0,.3,1), -webkit-transform .5s ' + delay + 'ms cubic-bezier(.7,0,.3,1)';
							el.style.transition = 'opacity .5s ' + delay + 'ms cubic-bezier(.7,0,.3,1), transform .5s ' + delay + 'ms cubic-bezier(.7,0,.3,1)';
							el.style.WebkitTransform = 'scale3d(0.1,0.1,1)';
							el.style.transform = 'scale3d(0.1,0.1,1)';
							el.style.opacity = 0;
						}
					});
				},
				onCloseItem: function(instance, item) {
					instance.items.forEach(function(el) {
						if (item != el) {
							el.style.WebkitTransition = 'opacity .4s, -webkit-transform .4s';
							el.style.transition = 'opacity .4s, transform .4s';
							el.style.WebkitTransform = 'scale3d(1,1,1)';
							el.style.transform = 'scale3d(1,1,1)';
							el.style.opacity = 1;
		
							onEndTransition(el, function() {
								el.style.transition = 'none';
								el.style.WebkitTransform = 'none';
							});
						}
					});
				},
				onExpand: function() {
					var content = jQuery('.gallery_preview');
					if (content.length > 0) {
						content.find('.inited').removeClass('inited');
						jQuery(document).trigger('action.init_hidden_elements', [content]);
					}
				}
			});
		});
	});
	
})(window);