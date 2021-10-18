jQuery(document).ready(function($) {
    "use strict";
    $('.cq-newsblock').each(function(index) {
        var _this = $(this);
        var _isloop = _this.data('isloop') == "yes" ? true : false;
        var _hoverdisable = _this.data('hoverdisable') == "yes" ? true : false;
        var _autodelay = parseInt(_this.data('autodelay'), 10);
        var _autodelayObj;
        if(_autodelay > 0){
            _autodelayObj = {
                delay: _autodelay*1000,
                disableOnInteraction: _hoverdisable,
            }
        }else{
            _autodelayObj = false;
        }

        var swiper = new Swiper(_this,  {
          direction: 'vertical',
          loop: _isloop,
          autoHeight: true,
          spaceBetween: 80,
          autoplay: _autodelayObj,
          navigation: {
            nextEl: $('.cq-newsblock-btnnext', _this),
            prevEl: $('.cq-newsblock-btnprev', _this),
          },
        });


    });

});
