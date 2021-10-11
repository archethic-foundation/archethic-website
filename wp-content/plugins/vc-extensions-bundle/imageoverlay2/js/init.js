jQuery(document).ready(function($) {
    "use strict";
    function hexToRgb(hex) {
        // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
        var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
        hex = hex.replace(shorthandRegex, function(m, r, g, b) {
            return r + r + g + g + b + b;
        });

        var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? {
            r: parseInt(result[1], 16),
            g: parseInt(result[2], 16),
            b: parseInt(result[3], 16)
        } : null;
    }
    $('.cq-imageoverlay2-container').each(function(index) {
        var _this = $(this);
        var _overlaycolor = $(this).data('overlaycolor');
        var _overlaysize = $(this).data('overlaysize');
        var _overlayshape = $(this).data('overlayshape');
        var _overlaymargin = $(this).data('overlaymargin');
        var _elementheight = parseInt($(this).data('elementheight'));
        var _titlesize = $(this).data('titlesize');
        var _contentsize = $(this).data('contentsize');
        var _contentcolor = $(this).data('contentcolor');
        var _elementmargin = $(this).data('elementmargin');
        var _titlesize = $(this).data('titlesize');
        var _contentsize = $(this).data('contentsize');
        var _image= $(this).data('image');
        var _overlaycolor;
        var _overlaystyle = $(this).data('overlaystyle');

        if(_overlaystyle!="customized"){
            _overlaycolor = hexToRgb($(this).data('overlaycolor'));
            if(_overlaycolor){
                _overlaycolor = 'rgba(' + _overlaycolor.r + ', ' + _overlaycolor.g + ', ' + _overlaycolor.b + ', ' + '0.7)';
            }
        }else{
            _overlaycolor = $(this).data('overlaycolor');
        }

        var _background = $(this).find('.cq-imageoverlay2-background');
        var _maxsize = Math.max($(this).width(), $(this).height());


        if(_contentcolor!=""){
            $(this).find('.cq-imageoverlay2-title, cq-imageoverlay2-icon, .cq-imageoverlay2-content').css('color', _contentcolor);
        }

        if(_elementheight!=""){
            $(this).css({
                height: _elementheight
            });
        }

        if(_titlesize!=""){
            $(this).find('.cq-imageoverlay2-title, cq-imageoverlay2-icon').css({
                'font-size': _titlesize
            });
        }

        if(_contentsize!=""){
            $(this).find('.cq-imageoverlay2-content').css({
                'font-size': _contentsize
            });
        }


        var _containerwidth, _containerheight;
        _containerwidth = $(this).width();
        _containerheight = $(this).height();
        var _image = $('.cq-imageoverlay2-img', _this);

        $(this).find('.cq-imageoverlay2').css({
            'height': _this.height(),
        });


        var _theImage = $(".cq-imageoverlay2-img", _this)[0];
        $("<img/>")
            .attr("src", $(_theImage).attr("src"))
            .load(function() {
                $(window).trigger('resize');
        });



        $(this).find('.cq-imageoverlay2-background').css({
            'background-color': _overlaycolor
        });


        _background.css({
          'width': _maxsize*4,
          'height': _maxsize*4
        });
        var _imageheight;
        $(window).on('resize', function(event) {
            _maxsize = Math.max(_this.width(), _this.height());
            _background.css({
              'width': _maxsize*4,
              'height': _maxsize*4
            });

            _imageheight = _this.find('img').height();
            if(_imageheight>0) _this.css('max-height', _imageheight);


        });
        if(_elementmargin!="") $(this).css('margin', _elementmargin);


    });
});

