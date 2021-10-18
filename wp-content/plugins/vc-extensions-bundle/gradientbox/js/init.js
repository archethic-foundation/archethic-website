jQuery(document).ready(function($) {
    "use strict";
    $('.cq-gradientbox').each(function(index) {
        var _startcolor = $(this).data('startcolor');
        var _endcolor = $(this).data('endcolor');
        var _avatartype = $(this).data('avatartype');
        var _avatarimage = $(this).data('avatarimage');
        var _titlealign = $(this).data('titlealign');
        var _gradientbackground = $(this).data('gradientbackground');
        var _avatarbgsize = $(this).data('avatarbgsize');
        var _iconfontsize = $(this).data('iconfontsize');
        var _iconcolor = $(this).data('iconcolor');
        var _iconbgcolor = $(this).data('iconbgcolor');
        var _contentbgcolor = $(this).data('contentbgcolor');
        var _contentcolor = $(this).data('contentcolor');
        var _titlesize = $(this).data('titlesize');
        var _tooltip = $(this).data('tooltip');
        var _boxheight = $(this).data('boxheight');

        if(_boxheight!=""){
            $(this).css('height', parseInt(_boxheight));
        }

        if(_tooltip!=""){
            $(this).tooltipster({
                content: _tooltip,
                position: 'top',
                offsetY: '-4',
                delay: 200,
                speed: 300,
                touchDevices: true,
                interactive: false,
                animation: 'fade',
                theme: 'tooltipster-shadow',
                contentAsHTML: true
            });
            $(this).on('click', function(event) {
              _tooltip.tooltipster('hide');

            });
        }


        if(_avatartype=="image"&&_avatarimage!=""){
            $(this).find('.cq-gradientbox-avatarcontainer').css({
              'background': 'url('+_avatarimage+') no-repeat center center',
              'background-size': 'cover'
            });
        }

        if(_avatarbgsize!=""){
            $(this).find('.cq-gradientbox-avatarcontainer').css({
              'width': parseInt(_avatarbgsize),
              'height': parseInt(_avatarbgsize)
            });
            $(this).find('.cq-gradientbox-icon').css('line-height', parseInt(_avatarbgsize) + 'px');
        }

        if(_iconfontsize!=""){
            $(this).find('.cq-gradientbox-icon').css('font-size', _iconfontsize);
        }

        if(_iconcolor!=""){
            $(this).find('.cq-gradientbox-icon').css('color', _iconcolor);
        }

        if(_iconbgcolor!=""){
            $(this).find('.cq-gradientbox-icon').css('background-color', _iconbgcolor);
        }


        if(_contentbgcolor!=""){
            $(this).find('.cq-gradientbox-contentcontainer').css('background-color', _contentbgcolor);
        }

        if(_contentcolor!=""){
            $(this).find('.cq-gradientbox-contentcontainer, .cq-gradientbox-title').css('color', _contentcolor);
        }

        if(_titlealign!=""){
            $(this).find('.cq-gradientbox-title').css('text-align', _titlealign);
            if(_titlealign=="right"){
                $(this).find('.cq-gradientbox-content').css('text-align', _titlealign);
            }
        }
        if(_titlesize!=""){
            $(this).find('.cq-gradientbox-title').css('font-size', _titlesize);
        }
        if(_startcolor!=""&&_gradientbackground=="customized"){
            $(this).css('background', '-moz-linear-gradient(top, ' + _startcolor + ' 0%, ' + _endcolor + ' 100%)');
            $(this).css('background', '-webkit-gradient(linear,left top,left bottom,from(' + _startcolor + '),to(' + _endcolor + '))');
            $(this).css('background', '-o-linear-gradient(top, ' + _startcolor + ' 0%, ' + _endcolor + ' 100%)');
            $(this).css('background', '-ms-linear-gradient(top, ' + _startcolor + ' 0%, ' + _endcolor + ' 100%)');
            $(this).css('background', 'linear, to bottom, ' + _startcolor + ' 0%, ' + _endcolor + ' 100%');
            $(this).css({ 'filter': 'progid:DXImageTransform.Microsoft.gradient(startColorstr=' + _startcolor + ', endColorstr=' + _endcolor + ')' });
        }
    });
});
