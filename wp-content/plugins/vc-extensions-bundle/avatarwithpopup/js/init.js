function detectIE() {
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf('MSIE ');
    if (msie > 0) {
        // IE 10 or older => return version number
        return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
    }

    var trident = ua.indexOf('Trident/');
    if (trident > 0) {
        // IE 11 => return version number
        var rv = ua.indexOf('rv:');
        return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
    }

    var edge = ua.indexOf('Edge/');
    if (edge > 0) {
       // IE 12 => return version number
       return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
    }

    // other browser
    return false;
}
jQuery(document).ready(function($) {
    "use strict";
    $('.cq-avatarwithpopup').each(function(index, el) {
        var _this = $(this);
        var _avatartype = $(this).data('avatartype');
        var _avatarimage = $(this).data('avatarimage');
        var _avatarsize = parseInt($(this).data('avatarsize'));
        var _iconcolor = $(this).data('iconcolor');
        var _iconbgcolor = $(this).data('iconbgcolor');
        var _iconsize = $(this).data('iconsize');
        var _popupcolor = $(this).data('popupcolor');
        var _backgroundimage = $(this).data('backgroundimage');
        var _triggerby = $(this).data('triggerby');
        var _delaytime = parseInt($(this).data('delaytime'));
        var _avatarshape = $(this).data('avatarshape');
        var _elementheight = parseInt($(this).data('elementheight'));
        var _avatartextcolor = $(this).data('avatartextcolor');
        var _contentsize = $(this).data('contentsize');

        if(_elementheight!=""&&_elementheight>0){
            $('.cq-avatarwithpopup-insidecontainer', _this).css('height', _elementheight);
        }

        if(detectIE()){
            $('.cq-avatarwithpopup-popup', _this).addClass('isIE');
        }


        if(_contentsize!=""){
            $('.cq-avatarwithpopup-popup', _this).css('font-size', _contentsize);;
        }

        $('.cq-avatarwithpopup-icon', _this).css({
            'color': _iconcolor,
            'background-color': _iconbgcolor
        });

        if(_avatartextcolor!=""){
            $('.cq-avatarwithpopup-avatartitle, .cq-avatarwithpopup-avatarlabel', _this).css({
                'color': _avatartextcolor
            });
        }

        if((!$('.cq-avatarwithpopup-avatartitle', _this)[0])&&$('.cq-avatarwithpopup-avatarlabel', _this)[0]){
                $('.cq-avatarwithpopup-avatarlabelcontainer', _this).css('margin-top', '12px');
        }


        if(_popupcolor!=""){
            $('.cq-avatarwithpopup-title, .cq-avatarwithpopup-title h4, .cq-avatarwithpopup-content', _this).css('color', _popupcolor);
        }

        if(_avatarsize!=""&&_avatarsize>0){
            $('.cq-avatarwithpopup-avatar, .cq-avatarwithpopup-icon, .cq-avatarwithpopup-avatarimage', _this).css({
                'width': _avatarsize,
                'height': _avatarsize,
                'line-height': _avatarsize + 'px'
            });
        }

        if(_iconsize!=""&&_iconsize){
            $('.cq-avatarwithpopup-icon', _this).css({
                'font-size': _iconsize
            });
        }

        if(_avatarshape=="avatar-roundlarge"){
            $('.cq-avatarwithpopup-avatar, .cq-avatarwithpopup-icon, .cq-avatarwithpopup-avatarimage', _this).css('border-radius', '16px');
        }else if(_avatarshape=="avatar-square"){
            $('.cq-avatarwithpopup-avatar, .cq-avatarwithpopup-icon, .cq-avatarwithpopup-avatarimage', _this).css('border-radius', '0');
        }else if(_avatarshape=="avatar-roundsmall"){
            $('.cq-avatarwithpopup-avatar, .cq-avatarwithpopup-icon, .cq-avatarwithpopup-avatarimage', _this).css('border-radius', '8px');
        }else{
            $('.cq-avatarwithpopup-avatar, .cq-avatarwithpopup-icon, .cq-avatarwithpopup-avatarimage', _this).css('border-radius', '50%');
        }

        $('.cq-avatarwithpopup-insidecontainer', _this).perfectScrollbar();
        if(_avatartype=="image"&&_avatarimage!=""){
            $('.cq-avatarwithpopup-avatar', _this).css({
                'background': 'url('+_avatarimage+') no-repeat center center',
                'background-size': 'cover'
            });
        }
        var _isclicked = -1;
        var _slideshowID = 0;
        var _isopend = -1;
        var _leaveID;
        if(_triggerby=="bydefault"){
            if(!$('.cq-avatarwithpopup-avatar', _this).parent().is('a'))$('.cq-avatarwithpopup-avatar', _this).css('cursor', 'default');
            setTimeout(function() {
                $('.cq-avatarwithpopup-popup', _this).removeClass('cardOuttop').addClass('hotspotanimate cardIntop');
            }, 600);
        }else if(_triggerby=="hover1"){
            _this.on('mouseover', function(event) {
                clearTimeout(_leaveID);
                $('.cq-avatarwithpopup-popup', _this).removeClass('cardOuttop').addClass('hotspotanimate cardIntop');
            }).on('mouseleave', function(event) {
                clearTimeout(_leaveID);
                _leaveID = setTimeout(function() {
                    $('.cq-avatarwithpopup-popup', _this).removeClass('cardIntop hotspotanimate').addClass('cardOuttop hotspotanimate');
                }, 800);
            });
        }else if(_triggerby=="hover2"){
            _this.on('mouseover', function(event) {
                $('.cq-avatarwithpopup-popup', _this).removeClass('cardOuttop').addClass('hotspotanimate cardIntop');
            });
        }else if(_triggerby=="slideshow"){
            _slideshowID = setInterval(_triggerOpen, _delaytime*1000)
            _this.on('mouseover', function(event) {
                $('.cq-avatarwithpopup-popup', _this).removeClass('cardOuttop').addClass('hotspotanimate cardIntop');
                clearInterval(_slideshowID);
            }).on('mouseleave', function(event) {
                clearInterval(_slideshowID);
                _slideshowID = setInterval(_triggerOpen, _delaytime*1000)
            });
        }else{
            _this.on('click', function(event) {
                if(_isclicked==-1){
                    $('.cq-avatarwithpopup-popup', _this).removeClass('cardOuttop').addClass('hotspotanimate cardIntop');
                    _isclicked = 1;
                }else{
                    $('.cq-avatarwithpopup-popup', _this).removeClass('cardIntop hotspotanimate').addClass('cardOuttop hotspotanimate');
                    _isclicked = -1;
                }
                event.preventDefault();
            });
        }

        function _triggerOpen(){
            if(_isopend==-1){
                $('.cq-avatarwithpopup-popup', _this).removeClass('cardOuttop').addClass('hotspotanimate cardIntop');
                _isopend = 1;
            }else{
                $('.cq-avatarwithpopup-popup', _this).removeClass('cardIntop hotspotanimate').addClass('cardOuttop hotspotanimate');
                _isopend = -1;
            }
        }


    });
});
