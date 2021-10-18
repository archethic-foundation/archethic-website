jQuery(document).ready(function($) {
    "use strict";
    $('.cq-sidebysidev2').each(function(index) {
        var _this = $(this);
        var _headerArr = [];
        var _dataArr = [];
        var _leftside = $('.cq-sidebysidev2-side', _this).first();
        var _rightside = $('.cq-sidebysidev2-side', _this).last();
        var _container = $('.cq-sidebysidev2-container', _this);
        var _autodelay = parseInt($(this).data('autodelay'), 10);
        _leftside.mouseenter(function() {
          _container.addClass('left-is-hovered');
          clearTimeout(_slideID);
        }).mouseleave(function() {
          _container.removeClass('left-is-hovered');
          if(_autodelay>0) _slideID = setTimeout(_autoSlide, _autodelay*1000);
        });

        _rightside.mouseenter(function() {
          _container.addClass('right-is-hovered');
          clearTimeout(_slideID);
        }).mouseleave(function() {
          _container.removeClass('right-is-hovered');
          if(_autodelay>0) _slideID = setTimeout(_autoSlide, _autodelay*1000);
        });
        $(document).on('touchstart', function(event) {
            if (!$(event.target).closest('.cq-sidebysidev2').length) {
                _container.removeClass('left-is-hovered');
                _container.removeClass('right-is-hovered');
            }

        });

        var _slideID = 0;
        var _isHovered = 0;
        function _autoSlide(){
            if(_isHovered<1){
               _leftside.trigger('mouseleave');
               _rightside.trigger('mouseenter');
               _isHovered = 1;
            }else{
               _rightside.trigger('mouseleave');
               _leftside.trigger('mouseenter');
               _isHovered = 0;
            }
            clearTimeout(_slideID);
            if(_autodelay>0) _slideID = setTimeout(_autoSlide, _autodelay*1000);
        }

        if(_autodelay>0) _slideID = setTimeout(_autoSlide, _autodelay*1000);


    });

});
