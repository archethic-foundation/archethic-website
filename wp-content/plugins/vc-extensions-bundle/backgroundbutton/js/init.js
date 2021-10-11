jQuery(document).ready(function($) {
    "use strict";
    $('.cq-bgbutton-container').each(function(index, el) {
        var _this = $(this);
        var _image = $(this).data('buttonimage');
        var _startcolor = $(this).data('startcolor');
        var _endcolor = $(this).data('endcolor');
        var _fontsize = $(this).data('fontsize');
        var _textcolor = $(this).data('textcolor');
        var _iconcolor = $(this).data('iconcolor');
        var _icon2size = $(this).data('icon2size');
        var _linktype = $(this).data('linktype');
        var _tooltip = $(this).data('tooltip');
        var _istooltip = $(this).data('istooltip');
        var _autoclose = $(this).data('autoclose') == "yes" ? true : false;
        var _autoloaded = $(this).data('autoloaded') == "yes" ? true : false;
        var _iconanimation = $(this).data('iconanimation');


        if(_fontsize!=""){
            $('.cq-bgbutton', _this).css({
                'font-size': _fontsize,
                'line-height': _fontsize
            });;
            $('.cq-bgbutton-icon1', _this).css({
                'font-size': _fontsize,
                'line-height': _fontsize
            });
        }
        if(_icon2size!=""){
            $('.cq-bgbutton-icon2', _this).css('font-size', _icon2size);
        }
        if(_textcolor!=""){
            $('.cq-bgbutton', _this).css('color', _textcolor);
        }
        if(_iconcolor!=""){
            $('.cq-bgbutton-icon1', _this).css('color', _iconcolor);
            $('.cq-bgbutton-icon2', _this).css('color', _iconcolor);
        }

        $('.cq-bgbutton', _this).css({
            'background-image': '-webkit-linear-gradient(top, '+ _startcolor +', '+ _endcolor +'), url("' + _image + '")',
            'background-image': 'linear-gradient(to bottom, '+ _startcolor +', '+ _endcolor +'), url("' + _image + '")'
        });



        var _lightboxmargin = $(this).data('lightboxmargin') == "" ? 20 : parseInt($(this).data('lightboxmargin'))
        var _lightLink = $("a.cq-bgbutton-lightbox", _this);
        var _videowidth = $(this).data('videowidth') == "" ? 640 : parseInt($(this).data('videowidth'));
        var _minwidth = $(this).data('minwidth') == "" ? 0 : parseInt($(this).data('minwidth'));
        var _tooltipanimation = $(this).data('tooltipanimation') == "" ? 'fade' :$(this).data('tooltipanimation');

        if(_linktype=="lightbox"){
            _lightLink.boxer({
                margin: _lightboxmargin,
                fixed : true
            });
        }else if(_linktype=="lightbox_custom"){
            var _lightboxURL = _lightLink.attr('href');
            if(_lightboxURL.indexOf('youtube')>-1||_lightboxURL.indexOf('vimeo')>-1){
                _lightLink.lightbox({
                    "viewportFill": 1,
                    "fixed": true,
                    "margin": 10,
                    "videoWidth": _videowidth,
                    "retina": true,
                    "minWidth": 320
                });
            }else{
                _lightLink.boxer({
                    margin: _lightboxmargin,
                    fixed : true
                });
            }

        }
        if(_tooltip!=""&&_istooltip=="yes"){
            var _tooltip = $('.cq-bgbutton', _this).tooltipster({
                content: _tooltip,
                position: 'top',
                offsetY: '-4',
                delay: 200,
                minWidth: _minwidth,
                autoClose: _autoclose,
                interactive: true,
                speed: 300,
                touchDevices: true,
                animation: _tooltipanimation,
                theme: 'tooltipster-shadow',
                contentAsHTML: true
            });
            $(this).on('click', function(event) {
              _tooltip.tooltipster('hide');
            });
            if(_autoloaded) _tooltip.tooltipster('show');
        }


    });
});
