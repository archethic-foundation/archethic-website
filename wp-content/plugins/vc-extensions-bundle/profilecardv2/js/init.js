jQuery(document).ready(function($) {
    "use strict";
    $('.cq-profilecardv2').each(function(index) {
        var _this = $(this);
        var _isopen = false;
        var _transition = "toggled";
        var _trigger = $(this).data('trigger');
        var _maxbutton = parseInt($(this).data('maxbutton'), 10);
        var _autodelay = parseInt($(this).data('autodelay'), 10);
        var _autodelayID = 0;

        if(_maxbutton>0){
            $('.vc_btn3-container', _this).css('max-width', _maxbutton + 'px');
        }

        if(_trigger=="click"){
            $('.cq-profilecardv2-content', _this).on(_trigger, function(event) {
                _userHover();
                event.preventDefault();
            });
        }else if(_trigger=="mouseover"){
            _this.on('mouseover', function(event) {
                if(_autodelay>0) clearTimeout(_autodelayID);
                if(!_isopen){
                    $('.cq-profilecardv2-panel', _this).addClass('cq-profilecardv2-panel-toggled');
                    $('.cq-profilecardv2-content', _this).addClass('cq-profilecardv2-content-'+_transition);
                    _isopen = true;
                }
                event.preventDefault();
            }).on('mouseleave', function(event) {
                if(_isopen){
                    setTimeout(function(){
                        $('.cq-profilecardv2-panel', _this).removeClass('cq-profilecardv2-panel-toggled');
                        $('.cq-profilecardv2-content', _this).removeClass('cq-profilecardv2-content-'+_transition);
                        _isopen = false;
                    }, 600)
                }
                if(_autodelay>0){
                    _autodelayID = setTimeout(_userHover, _autodelay*1000);
                }

                event.preventDefault();
            });
        }


        function _userHover(){
            if(_autodelay>0) clearTimeout(_autodelayID);

            if(!_isopen){
                $('.cq-profilecardv2-panel', _this).addClass('cq-profilecardv2-panel-toggled');
                $('.cq-profilecardv2-content', _this).addClass('cq-profilecardv2-content-'+_transition);
                _isopen = true;
            }else{
                $('.cq-profilecardv2-panel', _this).removeClass('cq-profilecardv2-panel-toggled');
                $('.cq-profilecardv2-content', _this).removeClass('cq-profilecardv2-content-'+_transition);
                _isopen = false;
            }

            if(_autodelay>0){
                _autodelayID = setTimeout(_userHover, _autodelay*1000);
            }

        }

        if(_autodelay>0){
            _autodelayID = setTimeout(_userHover, _autodelay*1000);
            _this.on('mouseover', function(event) {
                clearTimeout(_autodelayID);
                event.preventDefault();
            }).on('mouseleave', function(event) {
                _autodelayID = setTimeout(_userHover, _autodelay*1000);
                event.preventDefault();
            });
        }



    });

});
