jQuery(document).ready(function($) {
  "use strict";
  var _numArr = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'];
  var _numArrLen = _numArr.length;
  $('.cq-stackgallery').each(function(index) {
    var _this = $(this);
    var _width = $(this).data('width');
    var _height = $(this).data('height');
    var _easein = $(this).data('easein');
    var _easeout = $(this).data('easeout');
    var _slideshow = $(this).data('slideshow') == 'yes' ? true : false;
    var _slideshowdelay = $(this).data('slideshowdelay') || 5000;
    var _notooltip = $(this).data('notooltip') || 'off';

    $(this).css({
      'height': _this.data('containerheight') || _height + 80
    });

    $(this).find('.stackgallery-next').parent('a').on('click', function(event) {
      _nextItem();
      event.stopPropagation();
      event.preventDefault();
    });

    var _slideshowint;
    var _isplaying = false;

    function _startslideshow(){
      if(_slideshow){
          clearInterval(_slideshowint);
          _slideshowint = setInterval( function(){
            _nextItem(null);
          }, _slideshowdelay);
          _isplaying = true;
          _this.data('slideshowint', _slideshowint);
      }
    }
    _startslideshow();

    $(this).find('.stackgallery-prev').parent('a').on('click', _prevItem);

    $(this).find('img.stackgallery-item').each(function(index) {

      var _flagNum = Math.floor(Math.random() * 2) * 2 - 1;
      var _deg = (_flagNum * _numArr[Math.floor(Math.random()*_numArrLen)]).toString();
      $(this).css({
        'width': _width,
        'height': _height,
        'top': '50%',
        'left': '50%',
        'opacity': '1',
        'margin-top': -_height*0.5,
        'margin-left': -_width*0.5,
        '-moz-transform': 'rotate(' + _deg + 'deg)',
        '-ms-transform': 'rotate(' + _deg + 'deg)',
        '-webkit-transform': 'rotate(' + _deg + 'deg)',
        'transform': 'rotate(' + _deg + 'deg)'
      }).data('deg', _deg);
    });


    var _isqueue = false;
    function _resetTooltip(_currentshowitem){
      try{
          _this.tooltipster('destroy');
        }catch(error){}
        var _title = _currentshowitem.attr('title');
        if(_title!=""&&_notooltip!="on"){
          _this.tooltipster({
            content: _title,
            delay: 200,
            animation: 'grow',
            position: 'top',
            offsetY: -(_this.height()-_height)*.5,
            delay: 50,
            theme: 'tooltipster-shadow'
          });
          _this.tooltipster('show');
        }

    }


    var _lastitem = $(this).find('img.stackgallery-item').last();
    _lastitem.transition({
        rotate: 0,
        x: 0
    }, 300, 'linear')
   _resetTooltip(_lastitem);

    function _nextItem(event){
        if(_slideshow) clearInterval(_this.data('slideshowint'));
        var _lastitem = _this.find('img.stackgallery-item').last();
        var _firstitem = _this.find('img.stackgallery-item').first();
        var _currentshowitem = _lastitem.prev('img.stackgallery-item');
        _resetTooltip(_currentshowitem);
        var _flagSide = 1;
        if(event)  _flagSide = (event.pageX - _this.offset().left) > _this.width()*.5 ? 1 : -1;
        var _orideg = _lastitem.data('deg');
        var _deg = -290;
        if(_isqueue) return;
        else{
          _isqueue = true;
          _currentshowitem.transition({
              rotate: 0,
              x: 0
          }, 300, 'linear')
          _lastitem.transition({
              rotate: _orideg,
              x: _flagSide*_width*1.2
          }, 400, _easein, function(){
              $(this).transition({
                x: 0,
                rotate: _orideg
              }, 300, _easeout, function(){
                $(this).insertBefore(_firstitem);
                $(this).removeClass('back');
                _isqueue = false;
                _startslideshow();
              }).addClass('back');
          });
        }

    }

    function _prevItem(event){
        if(_slideshow) clearInterval(_this.data('slideshowint'));
        if(event){
          event.stopPropagation();
          event.preventDefault();
        }
        var _lastitem = _this.find('img.stackgallery-item').last();
        var _firstitem = _this.find('img.stackgallery-item').first();
        var _currentshowitem = _lastitem.prev('img.stackgallery-item');
        var _flagSide = -1;
        var _orideg = _lastitem.data('deg');
        var _deg = -290;
        if(_isqueue) return;
        else{
          _isqueue = true;
          _currentshowitem.transition({
              rotate: _orideg,
              x: 0
          }, 300, 'linear')
          _firstitem.transition({
              rotate: _orideg,
              x: _flagSide*_width*1.2
          }, 300, _easein, function(){
              $(this).addClass('front').transition({
                x: 0,
                rotate: 0
              }, 300, _easeout, function(){
                $(this).insertAfter(_lastitem);
                $(this).removeClass('front');
                _resetTooltip(_firstitem);
                _isqueue = false;
                _startslideshow();
              });
          });
        }

    }

    $(this).on('click', function(event){
        var _flagSide = (event.pageX - _this.offset().left) > _this.width()*.5 ? 1 : -1;
        if(_flagSide>0){
          _nextItem(event);
        }else{
          _prevItem(event);
        }

    }).on('mouseover', function(event) {
        if(_slideshow) clearInterval(_this.data('slideshowint'));
        _isplaying = false;

    }).on('mouseleave', function(event) {
          _startslideshow();
    });


    var _ratio = _height/_width;
    $(window).on('resize', function(event) {
          if(_this.width()<=320){
              _this.find('.stackgallery-next').parent('a').parent('div').hide();
              _this.find('.stackgallery-prev').parent('a').parent('div').hide();
          }else{
              _this.find('.stackgallery-next').parent('a').parent('div').show();
              _this.find('.stackgallery-prev').parent('a').parent('div').show();
          }
          _this.find('img.stackgallery-item').each(function(index) {
              var _w = $(this).width();
              var _h = _w*_ratio;
              $(this).css({
                'height': _h,
                'margin-left': -_w*.5,
                'margin-top': -_h*.5
              });
          });


    });

    $(window).trigger('resize');


  });
});
