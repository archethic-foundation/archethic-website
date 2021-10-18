var METRO_AUTO_REINIT;
var METRO_LOCALE;
var METRO_WEEK_START;
var METRO_DIALOG = false;

(function($){
    $.Metro = function(params){
        params = $.extend({
        }, params);
    };

    $.Metro.getDeviceSize = function(){
        var device_width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
        var device_height = (window.innerHeight > 0) ? window.innerHeight : screen.height;
        return {
            width: device_width,
            height: device_height
        }
    }

})(jQuery);

jQuery(function($){
    $('html').on('click', function(e){
        $('.dropdown-menu').each(function(i, el){
            if (!$(el).hasClass('keep-open') && $(el).css('display')=='block') {
                $(el).hide();
            }
        });
    });
});

jQuery(function($){
    $(window).on('resize', function(){
        if (METRO_DIALOG) {
            var top = ($(window).height() - METRO_DIALOG.outerHeight()) / 2;
            var left = ($(window).width() - METRO_DIALOG.outerWidth()) / 2;
            METRO_DIALOG.css({
                top: top, left: left
            });
        }
    });
});

(function( $ ) {
    $.widget("metro.carousel", {

        version: "1.0.0",

        options: {
            auto: true,
            period: 2000,
            duration: 500,
            effect: 'slowdown', // slide, fade, switch, slowdown
            direction: 'left',
            markers: {
                show: true,
                type: 'default',
                position: 'left' //bottom-left, bottom-right, bottom-center, top-left, top-right, top-center
            },
            controls: true,
            stop: true,
            width: '100%',
            height: 300
        },

        _slides: {},
        _currentIndex: 0,
        _interval: 0,
        _outPosition: 0,

        _create: function(){
            var that = this, o = this.options,
                element = carousel = this.element,
                controls = carousel.find('.controls');

            if (element.data('auto') != undefined) o.auto = element.data('auto');
            if (element.data('period') != undefined) o.period = element.data('period');
            if (element.data('duration') != undefined) o.duration = element.data('duration');
            if (element.data('effect') != undefined) o.effect = element.data('effect');
            if (element.data('direction') != undefined) o.direction = element.data('direction');
            if (element.data('width') != undefined) o.width = element.data('width');
            if (element.data('height') != undefined) o.height = element.data('height');
            if (element.data('stop') != undefined) o.stop = element.data('stop');
            if (element.data('controls') != undefined) o.controls = element.data('controls');
            if (element.data('markersShow') != undefined) o.markers.show = element.data('markersShow');
            if (element.data('markersType') != undefined) o.markers.type = element.data('markersType');
            if (element.data('markersPosition') != undefined) o.markers.position = element.data('markersPosition');

            carousel.css({
                'width': this.options.width,
                'height': this.options.height
            });

            this._slides = carousel.find('.slide');

            if (this._slides.length <= 1) return;

            if (this.options.markers !== false && this.options.markers.show && this._slides.length > 1) {
                this._markers(that);
            }

            if (this.options.controls && this._slides.length > 1) {
                carousel.find('.controls.left').on('click', function(){
                    that._slideTo('prior');
                });
                carousel.find('.controls.right').on('click', function(){
                    that._slideTo('next');
                });
            } else {
                controls.hide();
            }

            if (this.options.stop) {
                carousel
                    .on('mouseenter', function(){
                        clearInterval(that._interval);
                    })
                    .on('mouseleave', function(){
                        if (that.options.auto) that._autoStart(), that.options.period;
                    })
            }

            if (this.options.auto) {
                this._autoStart();
            }
        },

        _autoStart: function(){
            var that = this;
            this._interval = setInterval(function(){
                if (that.options.direction == 'left') {
                    that._slideTo('next')
                } else {
                    that._slideTo('prior')
                }
            }, this.options.period);
        },

        _slideTo: function(direction){
            var
                currentSlide = this._slides[this._currentIndex],
                nextSlide;

            if (direction == undefined) direction = 'next';

            if (direction === 'prior') {
                this._currentIndex -= 1;
                if (this._currentIndex < 0) this._currentIndex = this._slides.length - 1;

                this._outPosition = this.element.width();

            } else if (direction === 'next') {
                this._currentIndex += 1;
                if (this._currentIndex >= this._slides.length) this._currentIndex = 0;

                this._outPosition = -this.element.width();

            }

            nextSlide = this._slides[this._currentIndex];

            switch (this.options.effect) {
                case 'switch': this._effectSwitch(currentSlide, nextSlide); break;
                case 'slowdown': this._effectSlowdown(currentSlide, nextSlide, this.options.duration); break;
                case 'fade': this._effectFade(currentSlide, nextSlide, this.options.duration); break;
                default: this._effectSlide(currentSlide, nextSlide, this.options.duration);
            }

            var carousel = this.element, that = this;
            carousel.find('.markers ul li a').each(function(){
                var index = $(this).data('num');
                if (index === that._currentIndex) {
                    $(this).parent().addClass('active');
                } else {
                    $(this).parent().removeClass('active');
                }
            });
        },

        _slideToSlide: function(slideIndex){
            var
                currentSlide = this._slides[this._currentIndex],
                nextSlide = this._slides[slideIndex];

            if (slideIndex > this._currentIndex) {
                this._outPosition = -this.element.width();
            } else {
                this._outPosition = this.element.width();
            }

            switch (this.options.effect) {
                case 'switch' : this._effectSwitch(currentSlide, nextSlide); break;
                case 'slowdown': this._effectSlowdown(currentSlide, nextSlide, this.options.duration); break;
                case 'fade': this._effectFade(currentSlide, nextSlide, this.options.duration); break;
                default : this._effectSlide(currentSlide, nextSlide, this.options.duration);
            }

            this._currentIndex = slideIndex;
        },

        _markers: function (that) {
            var div, ul, li, i, markers;

            div = $('<div class="markers '+this.options.markers.type+'" />');
            ul = $('<ul></ul>').appendTo(div);

            for (i = 0; i < this._slides.length; i++) {
                li = $('<li><a href="javascript:void(0)" data-num="' + i + '"></a></li>');
                if (i === 0) {
                    li.addClass('active');
                }
                li.appendTo(ul);
            }


            ul.find('li a').removeClass('active').on('click', function () {
                var $this = $(this),
                    index = $this.data('num');

                ul.find('li').removeClass('active');
                $this.parent().addClass('active');

                if (index == that._currentIndex) {
                    return true;
                }

                that._slideToSlide(index);
                return true;
            });

            div.appendTo(this.element);

            switch (this.options.markers.position) {
                case 'top-left' : {
                    div.css({
                        left: '10px',
                        right: 'auto',
                        bottom: 'auto',
                        top: '10px'
                    });
                    break;
                }
                case 'top-right' : {
                    div.css({
                        left: 'auto',
                        right: '10px',
                        bottom: 'auto',
                        top: '10px'
                    });
                    break;
                }
                case 'top-center' : {
                    div.css({
                        left: this.element.width()/2 - div.width()/2,
                        right: 'auto',
                        bottom: 'auto',
                        top: '10px'
                    });
                    break;
                }
                case 'bottom-left' : {
                    div.css({
                        left: '10px',
                        right: 'auto'
                    });
                    break;
                }
                case 'bottom-right' : {
                    div.css({
                        right: '10px',
                        left: 'auto'
                    });
                    break;
                }
                case 'bottom-center' : {
                    div.css({
                        left: this.element.width()/2 - div.width()/2,
                        right: 'auto'
                    });
                    break;
                }
            }
        },


        _effectSwitch: function(currentSlide, nextSlide){
            $(currentSlide)
                .hide();
            $(nextSlide)
                .css({left: 0})
                .show();
        },

        _effectSlide: function(currentSlide, nextSlide, duration){
            $(currentSlide)
                .animate({left: this._outPosition}, duration);
            $(nextSlide)
                .css('left', this._outPosition * -1)
                .show()
                .animate({left: 0}, {'duration':duration, 'easing': 'easeOutCirc'});
        },

        _effectSlowdown: function(currentSlide, nextSlide, duration){
            var options = {
                'duration': duration,
                'easing': 'doubleSqrt'
            };
            $.easing.doubleSqrt = function(t) {
                return Math.sqrt(Math.sqrt(t));
            };

            $(currentSlide)
                .animate({left: this._outPosition}, options);


            //$(nextSlide).find('.subslide').hide();
            $(nextSlide)
                .css('left', this._outPosition * -1)
                .show()
                .animate({left: 0}, options);

            //setTimeout(function(){
            //    $(nextSlide).find('.subslide').fadeIn();
            //}, 500);

        },

        _effectFade: function(currentSlide, nextSlide, duration){
            $(currentSlide)
                .fadeOut(duration);
            $(nextSlide)
                .css({left: 0})
                .fadeIn(duration);
        },


        _destroy: function(){

        },

        _setOption: function(key, value){
            this._super('_setOption', key, value);
        }
    });
})( jQuery );


(function( $ ) {
    $.widget("metro.livetile", {

        version: "1.0.0",

        options: {
            effect: 'slideLeft',
            period: 4000,
            duration: 700,
            easing: 'doubleSqrt'
        },

        _frames: {},
        _currentIndex: 0,
        _interval: 0,
        _outPosition: 0,
        _size: {},

        _create: function(){
            var that = this,
                element = this.element;

            if (element.data('effect') != undefined) {this.options.effect = element.data('effect');}
            if (element.data('direction') != undefined) {this.options.direction = element.data('direction');}
            if (element.data('period') != undefined) {this.options.period = element.data('period');}
            if (element.data('duration') != undefined) {this.options.duration = element.data('duration');}
            if (element.data('easing') != undefined) {this.options.easing = element.data('easing');}

            //this._frames = element.children(".tile-content, .event-content");
            this._frames = element.children("[class*='-content']");
            //console.log(this._frames);

            if (this._frames.length <= 1) return;

            $.easing.doubleSqrt = function(t) {return Math.sqrt(Math.sqrt(t));};

            this._size = {
                'width': element.width(),
                'height': element.height()
            };

            element.on('mouseenter', function(){
                that.stop();
            });

            element.on('mouseleave', function(){
                that.start();
            });

            this.start();
        },

        start: function(){
            var that = this;
            this._interval = setInterval(function(){
                that._animate();
            }, this.options.period);
        },

        stop: function(){
            clearInterval(this._interval);
        },

        _animate: function(){
            var currentFrame = this._frames[this._currentIndex], nextFrame;
            this._currentIndex += 1;
            if (this._currentIndex >= this._frames.length) this._currentIndex = 0;
            nextFrame = this._frames[this._currentIndex];

            switch (this.options.effect) {
                case 'slideLeft': this._effectSlideLeft(currentFrame, nextFrame); break;
                case 'slideRight': this._effectSlideRight(currentFrame, nextFrame); break;
                case 'slideDown': this._effectSlideDown(currentFrame, nextFrame); break;
                case 'slideUpDown': this._effectSlideUpDown(currentFrame, nextFrame); break;
                case 'slideLeftRight': this._effectSlideLeftRight(currentFrame, nextFrame); break;
                default: this._effectSlideUp(currentFrame, nextFrame);
            }
        },

        _effectSlideLeftRight: function(currentFrame, nextFrame){
            if (this._currentIndex % 2 == 0)
                this._effectSlideLeft(currentFrame, nextFrame);
            else
                this._effectSlideRight(currentFrame, nextFrame);
        },

        _effectSlideUpDown: function(currentFrame, nextFrame){
            if (this._currentIndex % 2 == 0)
                this._effectSlideUp(currentFrame, nextFrame);
            else
                this._effectSlideDown(currentFrame, nextFrame);
        },

        _effectSlideUp: function(currentFrame, nextFrame){
            var _out = this._size.height;
            var options = {
                'duration': this.options.duration,
                'easing': this.options.easing
            };

            $(currentFrame)
                .animate({top: -_out}, options);
            $(nextFrame)
                .css({top: _out})
                .show()
                .animate({top: 0}, options);
        },

        _effectSlideDown: function(currentFrame, nextFrame){
            var _out = this._size.height;
            var options = {
                'duration': this.options.duration,
                'easing': this.options.easing
            };

            $(currentFrame)
                .animate({top: _out}, options);
            $(nextFrame)
                .css({top: -_out})
                .show()
                .animate({top: 0}, options);
        },

        _effectSlideLeft: function(currentFrame, nextFrame){
            var _out = this._size.width;
            var options = {
                'duration': this.options.duration,
                'easing': this.options.easing
            };

            $(currentFrame)
                .animate({left: _out * -1}, options);
            $(nextFrame)
                .css({left: _out})
                .show()
                .animate({left: 0}, options);
        },

        _effectSlideRight: function(currentFrame, nextFrame){
            var _out = this._size.width;
            var options = {
                'duration': this.options.duration,
                'easing': this.options.easing
            };

            $(currentFrame)
                .animate({left: _out}, options);
            $(nextFrame)
                .css({left: -_out})
                .show()
                .animate({left: 0}, options);
        },

        _destroy: function(){},

        _setOption: function(key, value){
            this._super('_setOption', key, value);
        }
    })
})( jQuery );



