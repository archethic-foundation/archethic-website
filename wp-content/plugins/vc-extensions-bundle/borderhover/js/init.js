jQuery(document).ready(function($) {
    "use strict";
  $(".cq-borderhover").each(function(index) {
        var _this = $(this);
        var _elementheight = parseInt($(this).data('elementheight'), 10);
        var _lightboxmargin = $(this).data('lightboxmargin') == "" ? 20 : parseInt($(this).data('lightboxmargin'))
        var _minwidth = $(this).data('minwidth') == "" ? 0 : parseInt($(this).data('minwidth'));
        var _bordercolor = $(this).data('bordercolor');

        if(_bordercolor!=""){
            $('.cq-borderhover-leftborder', _this).css('border-left-color', _bordercolor);
            $('.cq-borderhover-rightborder', _this).css('border-right-color', _bordercolor);
            $('.cq-borderhover-bottomborder', _this).css('border-bottom-color', _bordercolor);
            $('.cq-borderhover-topborder', _this).css('border-top-color', _bordercolor);
        }

        if(_elementheight>0){
            $('.cq-borderhover-item', _this).css('height', _elementheight);
        }

        $("a.cq-borderhover-prettyphoto", _this).prettyPhoto({
        });
        $('.cq-borderhover-lightbox', _this).each(function(index, el) {
            var _videowidth = $(this).data('videowidth') == "" ? 640 : parseInt($(this).data('videowidth'));
            var _linktype = $(this).data('linktype');
            var _lightboxmode = $(this).data('lightboxmode');
            var _isgallery = $(this).data('isgallery') == "yes" ? true : false;

            if(_linktype=="lightbox"){
                if(_lightboxmode=="prettyphoto"){
                }else{
                    $(this).boxer({
                        margin: _lightboxmargin,
                        fixed : true
                    });
                }
            }else if(_linktype=="lightbox_custom"){
                var _lightboxURL = $(this).attr('href');
                if(_lightboxURL.indexOf('youtube')>-1||_lightboxURL.indexOf('vimeo')>-1){
                    $(this).lightbox({
                        "viewportFill": 1,
                        "fixed": true,
                        "margin": 10,
                        "videoWidth": _videowidth,
                        "retina": true,
                        "minWidth": 320
                    });
                }else{
                    $(this).boxer({
                        margin: _lightboxmargin,
                        fixed : true
                    });
                }

            }

        });

  })

});
