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

    $(this).find('.cq-imageaccordion').each(function() {
        var _this = $(this);
        var _titlesize = $(this).data('titlesize');
        var _contentsize = $(this).data('contentsize');
        var _elementheight =$(this).data('elementheight');
        var _unfoldfirst = $(this).data('unfoldfirst');
        var _captionbgstyle = $(this).data('captionbgstyle');
        var _captiontextcolor = $(this).data('captiontextcolor');
        var _captionbgcolor;

        if(_captionbgstyle!="customized"){
            _captionbgcolor = hexToRgb($(this).data('captionbgcolor'));
            _captionbgcolor = 'rgba(' + _captionbgcolor.r + ', ' + _captionbgcolor.g + ', ' + _captionbgcolor.b + ', ' + '0.8)';
        }else{
            _captionbgcolor = $(this).data('captionbgcolor');
        }
        $(this).find('.cq-imageaccordion-caption').css({
            'background-color': _captionbgcolor
        });
        if(_captiontextcolor!=""){
            $(this).find('.cq-imageaccordion-title, .cq-imageaccordion-content').css({
                'color': _captiontextcolor
            });
        }

        if(_elementheight!="") {
            $(this).css('height', _elementheight);
            $(this).find('.cq-imageaccordion-link').css('height', _elementheight);
        }

        if(_unfoldfirst=="cq-imageaccordion-unfoldfirst"){
            $(this).on('mouseover', function(event) {
                $(this).removeClass(_unfoldfirst)
            }).on('mouseleave', function(event) {
                $(this).addClass(_unfoldfirst)
            });
        }

        var _itemnum = $(this).find('li.cq-imageaccordion-listitem').length - 1;
        $(window).on('resize', function(event) {
            var _elementwidth = _this.width();
            _this.find('.cq-imageaccordion-caption').css('min-width', _elementwidth);
            if($(this).width()<600){
                _this.css('height', 'auto');
                _this.find('.cq-imageaccordion-link').css({
                    'height': '120',
                    'position': 'absolute',
                    'bottom': '0'
                });
            }
            if(_this.hasClass('cq-accordion-large')){
                _this.find('.cq-imageaccordion-title, .cq-imageaccordion-content').css('width', _elementwidth*(1-0.08*_itemnum)-24);
            }else if(_this.hasClass('cq-accordion-none')){
            }else{
                _this.find('.cq-imageaccordion-title, .cq-imageaccordion-content').css('width', _elementwidth*(1-0.04*_itemnum)-24);
            }
        });
        $(window).trigger('resize');

        $(this).find('li.cq-imageaccordion-listitem').each(function(index) {
            if(_elementheight!="") $(this).css('height', _elementheight);
            var _img = $(this).data('image');


            if(_titlesize!=""){
                $(this).find('.cq-imageaccordion-title').css('font-size', _titlesize);
            }
            if(_contentsize!=""){
                $(this).find('.cq-imageaccordion-content').css('font-size', _contentsize);
            }
            $(this).css({
                'background-image': 'url(' + _img + ')'
            });



        });
    });

});
