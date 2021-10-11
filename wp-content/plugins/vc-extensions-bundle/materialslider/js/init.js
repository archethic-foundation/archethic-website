jQuery(document).ready(function($) {
  "use strict";
  $(".cq-materialslider").each(function(index) {
      var _this = $(this);
      var _animateDot = $('.cq-materialslider-bar', _this);
      var _slider = $(".cq-materialslider-container", _this);
      var _autoslide = parseInt($(this).data('autoslide'), 10);
      var _elementheight = parseInt($(this).data('elementheight'), 10) > 0?parseInt($(this).data('elementheight'), 10):320;
      var _titlesize = $(this).data('titlesize');
      var _labelsize = $(this).data('labelsize');
      var _autohide = $(this).data('autohide')=="yes"?true:false;
      var _minHeight = 360;
      var _maxHeight = 0;

      var _currentDotNum = 0;
      var _dotBtnArr = [];
      var _dotNums = $(".cq-materialslider-dot", _this).length;
      $('.cq-materialslider-slide', _this).each(function(index) {
          _elementheight = Math.max($(this).height(), _elementheight);
          if($(this).height()==0) $(this).css('height', _elementheight);
          var _titlecolor = $(this).data('titlecolor');
          var _labelcolor = $(this).data('labelcolor');
          var _bgcolor = $(this).data('bgcolor');
          $(this).css('background', _bgcolor);
          if(_titlesize!="") $('.cq-materialslider-title', $(this)).css('font-size', _titlesize);
          if(_labelsize!="") $('.cq-materialslider-description', $(this)).css('font-size', _labelsize);
          if(_titlecolor!="") $('.cq-materialslider-title', $(this)).css('color', _titlecolor);
          if(_labelcolor!="") $('.cq-materialslider-description', $(this)).css('color', _labelcolor);
      });


      function _tweakSlide(_curNum, _newNum){
            var newDirection = _newNum > _curNum ? 'right' : 'left';
            var currentDirection = _newNum < _curNum ? 'right' : 'left';
            _animateDot.removeClass('cq-materialslider-bar-' + currentDirection);
            _animateDot.addClass('cq-materialslider-bar-' + newDirection);
            _slider.attr('data-pos', _newNum);
            _currentDotNum = _newNum;
      }
      $(".cq-materialslider-dot", _this).each(function(index) {
          _dotBtnArr[index] = $(this);
          $(this).on('click', function(event) {
            var _currentPos = parseInt(_slider.attr('data-pos'));
            var _nextPos = parseInt($(this).attr('data-pos'));
            _tweakSlide(_currentPos, _nextPos);
            event.preventDefault();
          });

      });

      var _timeID = 0;
      function _slideshow() {
          clearTimeout(_timeID);
          if(_autoslide>0){
              _timeID = setTimeout(function() {
                var _prevDotNum = _currentDotNum;
                 _currentDotNum++;
                 var _nextDotNum = _currentDotNum;
                 if(_nextDotNum>_dotNums-1){
                    _nextDotNum = 0;
                 }
                 _tweakSlide(_prevDotNum, _nextDotNum);
                 _slideshow();

              }, _autoslide*1000);
          }

      }

      if(_autoslide>0) _slideshow();

      if(_autohide) $('.cq-materialslider-navigation', _this).animate({"opacity": 0}, 300);
      _this.on('mouseover', function(event) {
          if(_autoslide>0) clearTimeout(_timeID);
          $('.cq-materialslider-navigation', _this).stop(true, true).animate({"opacity": 1}, 300);
      }).on('mouseleave', function(event) {
          if(_autoslide>0) _slideshow();
          if(_autohide) $('.cq-materialslider-navigation', _this).delay(400).animate({"opacity": 0}, 300);
      });

      var _resizeMinHeight = 0;
      $(window).on('resize', function(event) {
          $('.cq-materialslider-slide', _this).each(function(index) {
              _resizeMinHeight = Math.min($(this).height(), _resizeMinHeight);
              if(_resizeMinHeight>0) _this.css('height', _resizeMinHeight);
          });

      });

  })
});
