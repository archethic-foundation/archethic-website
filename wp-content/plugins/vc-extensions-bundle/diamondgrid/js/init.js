jQuery(document).ready(function($) {
    "use strict";
    $('.cq-diamondgrid-container').each(function(index, el) {
        var _this = $(this);
        var _tooltipposition = $(this).data('tooltipposition');
        var _itembgcolor = $(this).data('itembgcolor');
        if(_itembgcolor!="") $('.cq-diamondgrid-ul', _this).css('background-color', _itembgcolor);
        $('.cq-diamondgrid-item', _this).each(function(_item) {
            var _imageURL = $(this).data('image');
            if(_imageURL!=""&&_imageURL!="undefined"&&_imageURL){
                $(this).css({
                    'background-image': 'url(' + _imageURL + ')'
                });
            }

        });

        var _lightboxmargin = $(this).data('lightboxmargin') == "" ? 20 : parseInt($(this).data('lightboxmargin'))
        var _minwidth = $(this).data('minwidth') == "" ? 0 : parseInt($(this).data('minwidth'));
        _lightboxmargin = 20;
        $("a.cq-diamondgrid-prettyphoto", _this).prettyPhoto({
        });
        $('.cq-diamondgrid-lightbox', _this).each(function(index, el) {
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
        $('.cq-diamondgrid-itemcontainer', _this).each(function(_index) {
            var _itemcontainer = $(this);
            var _iconcolor = $(this).data('iconcolor');
            var _iconhovercolor = $(this).data('iconhovercolor');
            var _backgroundcolor = $(this).data('backgroundcolor');
            var _backgroundhovercolor = $(this).data('backgroundhovercolor');
            var _itembgcolor = $(this).data('itembgcolor');
            if(_backgroundcolor!="") $(this).css('background-color', _backgroundcolor);

            var _tooltip = $(this).attr('title');
            var _realtooltipposition = "top";
            var _tooltipanimation = $(this).data('tooltipanimation') == "" ? 'swing' :$(this).data('tooltipanimation');
            if(_tooltip!=""){
                var _tooltip = $('.cq-diamondgrid-item', _itemcontainer).tooltipster({
                    content: _tooltip,
                    position: _realtooltipposition,
                    delay: 200,
                    interactive: true,
                    speed: 300,
                    touchDevices: true,
                    animation: _tooltipanimation,
                    theme: 'tooltipster-shadow',
                    contentAsHTML: true
                });
            }



            if(_backgroundhovercolor!=""){
               $(this).on('mouseover', function(event) {
                    $(this).css('background-color', _backgroundhovercolor);
               }).on('mouseleave', function(event) {
                    if(_backgroundcolor!="") {
                        $(this).css('background-color', _backgroundcolor);
                    }else{
                        $(this).css('background-color', '');
                    }
                });

            }

            if(_iconcolor!="") $('.cq-diamondgrid-icon', $(this)).css('color', _iconcolor);
            if(_iconhovercolor!=""){
               $(this).on('mouseover', function(event) {
                    $('.cq-diamondgrid-icon', $(this)).css('color', _iconhovercolor);
               }).on('mouseleave', function(event) {
                    if(_backgroundcolor!="") {
                        $(this).css('background-color', _backgroundcolor);
                    }else{
                        $(this).css('background-color', '');
                    }
                    if(_iconcolor!=""){
                         $('.cq-diamondgrid-icon', $(this)).css('color', _iconcolor);
                    }else{
                         $('.cq-diamondgrid-icon', $(this)).css('color', '');
                    }
               });
            }

        });


    });
});
