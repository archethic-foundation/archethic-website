jQuery(document).ready(function($) {
    "use strict";
    $('.cq-comparecard').each(function(index, el) {
        var _this = $(this);
        var _autoslide = parseInt($(this).data('autoslide'), 10);
        var _slideID = 0;

        if(_autoslide>0){
            function _autoDelaySlide(){
                _slideID = setInterval(function() {
                    clearInterval(_slideID);
                    $('.cq-comparecard-checkbox', _this).trigger('click');
                    _autoDelaySlide();
                }, _autoslide*1000);
            }
            _autoDelaySlide();
        }

        _this.on('mouseover', function(event) {
            if(_autoslide>0) clearInterval(_slideID);
        }).on('mouseleave', function(event) {
            if(_autoslide>0) _autoDelaySlide();
        });

        function _resetItems(){
            if(_autoslide>0) clearInterval(_slideID);
            $('.cq-comparecard-item', _this).each(function(index, el) {
                if($(this).hasClass('cq-comparecard-in')){
                    $(this).removeClass('cq-comparecard-in').addClass('cq-comparecard-out');
                }
            });
        }

        $('.cq-comparecard-checkbox', _this).on('click', function(event) {
            if(_autoslide>0) clearInterval(_slideID);
            if($(this).prop("checked") == true){
                _itemArr[1].trigger('click');
            }else{
                _itemArr[0].trigger('click');
            }
        });
        var _itemArr = [];
        $('.cq-comparecard-item', _this).each(function(index, el) {
            var _tooltip = $(this).attr('title');
            if(_tooltip&&_tooltip!==""){
                var _tooltip = $('.cq-comparecard-avatar', $(this)).tooltipster({
                    content: _tooltip,
                    position: 'top',
                    delay: 200,
                    interactive: true,
                    speed: 300,
                    touchDevices: true,
                    animation: 'grow',
                    theme: 'tooltipster-shadow',
                    contentAsHTML: true
                });
            }

            _itemArr[index] = $(this);
            $(this).data('index', index);
            $(this).on('click', function(event) {
                _resetItems();
                $(this).removeClass('cq-comparecard-out').addClass('cq-comparecard-in');
                if($(this).data('index')==0){
                  $('.cq-comparecard-checkbox', _this).prop('checked', false);
                } else{
                  $('.cq-comparecard-checkbox', _this).prop('checked', true);
                }
            });
        });

    });
});
