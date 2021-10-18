jQuery(document).ready(function($) {
    "use strict";
    $('.cq-hovercard').each(function(index, el) {
        var _this = $(this);
        var _linktype = $(this).data('linktype');
        var _contentcolor = $(this).data('contentcolor');
        var _iconcolor = $(this).data('iconcolor');
        var _bgtype = $(this).data('bgtype');
        var _captionoffset = $(this).data('captionoffset');
        var _bgheight = $(this).data('bgheight') == "" ? 240 : parseInt($(this).data('bgheight'))
        var _videowidth = $(this).data('videowidth') == "" ? 640 : parseInt($(this).data('videowidth'))
        var _lightboxmargin = $(this).data('lightboxmargin') == "" ? 20 : parseInt($(this).data('lightboxmargin'))
        var _lightLink = $("a.cq-hovercard-lightbox", _this);
        if(_captionoffset!=""){
            $('.cq-hovercard-textcontainer', _this).css('top', _captionoffset);
        }
        if(_contentcolor!=""){
            $('.cq-hovercard-title, .cq-hovercard-content', _this).css('color', _contentcolor);
        }
        if(_iconcolor!=""){
            $('.cq-hovercard-icon', _this).css('color', _iconcolor);
        }
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
                    // "mobile": true,
                    "minWidth": 320
                });
            }else{
                _lightLink.boxer({
                    margin: _lightboxmargin,
                    fixed : true
                });
            }

        }



    });
});
