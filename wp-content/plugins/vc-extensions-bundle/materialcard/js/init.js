jQuery(document).ready(function($) {
  "use strict";
  $('.cq-material-card').each(function(index) {
      var _this = $(this);
      var _bordercolor = $(this).data('bordercolor');
      var _colorstyle = $(this).data('colorstyle');
      var _titlecolor = $(this).data('titlecolor');
      var _contentcolor = $(this).data('contentcolor');
      var _isripple = $(this).data('isripple');
      var _cardwidth = $(this).data('cardwidth');
      var _titlemargin = $(this).data('titlemargin');

      if(_cardwidth!="") $(this).css('width', _cardwidth);

      if(_colorstyle!="customized"){
        _bordercolor = _colorstyle;
      }
      $(this).find('.material-card-title').css({
        'margin': _titlemargin,
        'color': _titlecolor
      });
      $(this).find('.material-card-content p').css({
        'color': _contentcolor
      });

      if($(this).find('.material-card-label')[0]){
        $(this).find('.material-card-content p:last').css({
          'margin-bottom': '2em'
        });
      }

      if(_bordercolor!=""){
        $(this).find('.material-card-content').css({
          'border-top-color': _bordercolor
        });
        $(this).find('.material-card-label').css({
          'background-color': _bordercolor
        });
      }
      $(this).find('.material-card-label-link').on('click', function(event) {
        if(_isripple!="on"){
            $(this).css({
              });

              var _circlediv = $('<div/>'),
                  btnOffset = $(this).offset(),
                  xPos = event.pageX - btnOffset.left,
                  yPos = event.pageY - btnOffset.top;

              _circlediv
                .addClass('ripple-circle')
                .css({
                  'background-color': _bordercolor,
                  top: yPos - 32,
                  left: xPos - 32
                })
                .appendTo($(this));
                _circlediv.one('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd',function(e) {
                    $(this).remove();
                });

        }

     });

  });
});

