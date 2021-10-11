jQuery(document).ready(function($) {
  "use strict";
  $(".cq-skewbox").each(function(index) {
      var _currentItem = 1;
      var _this = $(this);
      var _itemNumbs = $(".cq-skewbox-item", _this).length;
      var _elementArr = []
      var _autoslide = parseInt($(this).data('autoslide'), 10);
      var _elementheight = parseInt($(this).data('elementheight'), 10);
      var _titlesize = $(this).data('titlesize');
      var _labelsize = $(this).data('labelsize');
      var _timerID = 0;
      var _isDown = true;

      $('.cq-skewbox-item').each(function(index) {
          $('.cq-skewbox-content', $(this)).each(function(index) {
            var _bgcolor = $(this).data('bgcolor');
            if(_bgcolor!="") $(this).css('background', _bgcolor);
          });

      });
      if(_elementheight>0){
        _this.css('height', _elementheight);
      }
      if(_titlesize!=""){
        $('.cq-skewbox-title', _this).css('font-size', _titlesize);
      }
      if(_labelsize!=""){
        $('.cq-skewbox-label', _this).css('font-size', _labelsize);
      }
      $('.cq-skewbox-item', _this).each(function(n) {
          _elementArr[n] = $(this)
      });
      function navigateUp() {
        if (_currentItem === 1) return;
        _currentItem--;
        pagination(_currentItem, _this, _itemNumbs);
      };

      function navigateDown() {
        if (_currentItem === _itemNumbs){
          return false;
        }else{

        }
        _currentItem++;
        pagination(_currentItem, _this, _itemNumbs);
      };
      $('.cq-skewbox-downnav', _this).on('click', function(event) {
        navigateDown();
        event.preventDefault();
      });
      $('.cq-skewbox-upnav', _this).on('click', function(event) {
        navigateUp();
        event.preventDefault();
      });

      function _slideshow(){
        clearTimeout(_timerID);
        if(_autoslide>0){
            _timerID = setTimeout(function() {
                if(_currentItem>=_itemNumbs){
                  _isDown = false;
                }
                if(_currentItem<=1){
                  _isDown = true;
                }
                if(_isDown){
                  navigateDown();
                }else{
                  navigateUp();
                }
                _slideshow();
            }, _autoslide*1000);
        }
      }
      _slideshow();
      _this.on('mouseover', function(event) {
        clearTimeout(_timerID);
      }).on('mouseleave', function(event) {
        if(_autoslide>0) _slideshow();
      });

  });

  function pagination(n, _container, _itemNumbs) {
    var _prevItem, _currentItem, _nextItem = null;
    _prevItem = $('.cq-skewbox-item-' + (n - 1), _container);
    _currentItem = $('.cq-skewbox-item-' + n, _container);
    _nextItem = $('.cq-skewbox-item-' + (n + 1), _container);
    _currentItem.removeClass("inactive").addClass("active");
    _prevItem.addClass("inactive");
    _nextItem.removeClass("active");
  };


});
