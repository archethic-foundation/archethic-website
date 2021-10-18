jQuery(document).ready(function($) {
    "use strict";
    $('.cq-typewriter-container').each(function(index) {
        var _this = $(this);
        var _textblock = $(this).find('.cq-typewriter');
        var _gradientcolor = $(this).data('gradientcolor');
        var _backgroundtype = $(this).data('backgroundtype');
        var _fontcolor = _textblock.data('fontcolor');
        var _fontsize = _textblock.data('fontsize');
        var _delaytime = parseFloat(_textblock.data('delaytime'));
        var _isparallax = _this.data('isparallax');
        var _parallaxx = parseFloat(_this.data('parallaxx'));
        var _parallaxy = parseFloat(_this.data('parallaxy'));
        var _elementwidth = _textblock.data('elementwidth');
        var _elementheight = _textblock.data('elementheight');
        var _elementmargin = _textblock.data('elementmargin');
        var _imagerepeat = _textblock.data('imagerepeat');
        var _looptype = _textblock.data('looptype');
        var _backgroundshape = _textblock.data('backgroundshape');

        _this.css({
            'border-radius': _backgroundshape,
            'margin': _elementmargin,
            'width': _elementwidth,
            'height': _elementheight
        });

        if(_fontsize!=""){
            _textblock.css('font-size', _fontsize);
        }

        if(_backgroundtype=="gradient"&&_gradientcolor!=""){
            _this.css({
              'background-color' : _gradientcolor,
              'background-image' : '-webkit-linear-gradient(top, hsl(0, 80%, 70%), ' + _gradientcolor + ')',
              'background-image' : '-moz-linear-gradient(top, hsl(0, 80%, 70%), ' + _gradientcolor + ')',
              'background-image' : 'o-linear-gradient(top, hsl(0, 80%, 70%), ' + _gradientcolor + ')',
              'background-image' : 'linear-gradient(to bottom, hsl(0, 80%, 70%), ' + _gradientcolor + ')'
            });
        }

        if(_fontcolor!=""){
            _this.css({
                'color': _fontcolor
            });
            _this.find('.typewriter-link').css('color', _fontcolor);
        }

        $(this).find('.cq-typewriter-text').addClass('cq-typewriter-text'+index);

        var _imgurl = '';
        if(_isparallax=="yes"){
            if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                _imgurl = _this.find('img').attr('src');
                _this.find('img').hide();
                if(_imgurl!=""){
                    _this.css({
                        'background-image': 'url(' + _imgurl + ')',
                        'background-size': 'cover'
                    });
                }
            }else{
                $(this).on('mousemove', function(e) {
                    var offset = $(this).offset();
                    var xPos = e.pageX - offset.left;
                    var yPos = e.pageY - offset.top;

                    var mouseXPercent = Math.round(xPos / $(this).width() * 100);
                    var mouseYPercent = Math.round(yPos / $(this).height() * 100);

                    var diffX = -$(this).width();
                    var diffY = -$(this).height();

                    var myX = diffX * (mouseXPercent/_parallaxx);
                    var myY = diffY * (mouseYPercent/_parallaxy);

                    $(this).find('img').animate({left: myX, top: myY}, {duration: 50, queue: false, easing: 'linear'});

                });

            }
        }else{

        }


        var theater = new TheaterJS();
        var _index = index;
        var _differentbgarr = [];
        var _bgIndex = 0;

        theater.describe("TypeWriter"+index, .8, '.cq-typewriter-text'+index);
        theater.on("say:start, erase:start", function (eventName) {
            var self    = this,
                current = self.current.voice;
            self.utils.addClass(current, "saying");
        }).on("say:end, erase:end", function (eventName) {
            var self    = this,
                current = self.current.voice;
            self.utils.removeClass(current, "saying");
        });
        var _length = $(this).find('.cq-typewriter-hiddentext').length;
        $(this).find('.cq-typewriter-hiddentext').each(function(index1) {
            if($(this).html()!="")theater.write("TypeWriter" + _index + ":" + $(this).html(), _delaytime*1000);
            if(index1>=_length-1&&_looptype!="no"){
                theater.write(function () { theater.play(true); });
            }
        });


    });

});


