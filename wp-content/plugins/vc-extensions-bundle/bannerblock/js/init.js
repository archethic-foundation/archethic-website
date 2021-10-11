jQuery(document).ready(function($) {
  "use strict";
  var $root = $('html, body');
  $('.cq-bannerblock').each(function(index) {
      var _this = $(this);
      var _titleborder = $(this).data('titleborder');
      var _titlebordercolor = $(this).data('titlebordercolor');
      var _titlebordersize = $(this).data('titlebordersize');
      var _bannertitlesize = $(this).data('bannertitlesize');
      var _bannercontentsize = $(this).data('bannercontentsize');
      var _buttonborder = $(this).data('buttonborder');
      var _buttonbordersize = $(this).data('buttonbordersize');
      var _buttonbordercolor = $(this).data('buttonbordercolor');
      var _backbuttoncolor = $(this).data('backbuttoncolor');
      var _backbuttonbg = $(this).data('backbuttonbg');
      var _backbuttonhovercolor = $(this).data('backbuttonhovercolor');
      var _backbuttonhoverbg = $(this).data('backbuttonhoverbg');
      var _titleborderwidth = $(this).data('titleborderwidth');
      var _buttonshape = $(this).data('buttonshape');
      var _buttonpadding = $(this).data('buttonpadding');
      var _elementheight = $(this).data('elementheight');
      var _elementmargin = $(this).data('elementmargin');
      var _issmoothscroll = $(this).data('issmoothscroll');
      var _isarrow = $(this).data('isarrow');
      var _arrowsize = $(this).data('arrowsize');
      var _arrowcolor = $(this).data('arrowcolor');
      var _buttonfontsize = $(this).data('buttonfontsize');
      var _textcolor = $(this).data('textcolor');
      var _arrowoffset = $(this).data('arrowoffset');

      var _button = $(this).find('.cq-bannerblock-buttonlink');

      if(_arrowoffset!=""){
        if(_isarrow=="arrowtop"||_isarrow=="circletop"){
            $('.cq-bannerblock-arrow', _this).css({
              'top': _arrowoffset
            });
        }
        if(_isarrow=="circletop"){
            $('.cq-bannerblock-circle', _this).css({
              'top': _arrowoffset
            });
        }

        if(_isarrow=="arrowbottom"){
            $('.cq-bannerblock-arrow', _this).css({
              'bottom': _arrowoffset
            });
        }
        if(_isarrow=="circlebottom"){
            $('.cq-bannerblock-circle', _this).css({
              'bottom': _arrowoffset
            });
        }


      }

      if(_issmoothscroll=="yes"){
          $('.cq-bannerblock-link', _this).smoothScroll({
            speed: 'auto',
            autoCoefficient: 1
          });
      }
      if(_buttonfontsize!=""){
          _button.css('font-size', _buttonfontsize);
      }

      if(_arrowsize!=""){
          if(_isarrow=="arrowtop"){
              $('.cq-bannerblock-arrow', _this).css({
                'border-left-width': _arrowsize,
                'border-right-width': _arrowsize,
                'border-top-color': _arrowcolor,
                'border-top-width': _arrowsize
              });
          }else if(_isarrow=="arrowbottom"){
              $('.cq-bannerblock-arrow', _this).css({
                'border-left-width': _arrowsize,
                'border-right-width': _arrowsize,
                'border-bottom-color': _arrowcolor,
                'border-bottom-width': _arrowsize
              });
          }else if(_isarrow=="circletop"){
              $('.cq-bannerblock-circle', _this).css({
                'background-color': _arrowcolor,
                'width': _arrowsize,
                'height': _arrowsize,
                'margin-top': -_arrowsize*0.5,
              });
          }else if(_isarrow=="circlebottom"){
              $('.cq-bannerblock-circle', _this).css({
                'background-color': _arrowcolor,
                'width': _arrowsize,
                'width': _arrowsize,
                'height': _arrowsize,
                'margin-bottom': -_arrowsize*0.5,
              });
          }
      }

      if(_arrowcolor!=""){
          if(_isarrow=="arrowtop"){
              $('.cq-bannerblock-arrow', _this).css({
                'border-top-color': _arrowcolor
              });
          }else if(_isarrow=="arrowbottom"){
              $('.cq-bannerblock-arrow', _this).css({
                'border-bottom-color': _arrowcolor
              });
          }else if(_isarrow=="circletop"){
              $('.cq-bannerblock-circle', _this).css({
                'background-color': _arrowcolor
              });
          }else if(_isarrow=="circlebottom"){
              $('.cq-bannerblock-circle', _this).css({
                'background-color': _arrowcolor
              });
          }
      }



      if(_elementheight!=""){
          $(this).css('height', _elementheight);
      }
      $(this).find('.cq-bannerblock-title').css('color', _textcolor);
      $(this).find('.cq-bannerblock-content').css('color', _textcolor);
      if(_elementmargin!=""){
          $(this).find('.cq-bannerblock-content').css('margin', _elementmargin);
      }
      if(_bannertitlesize!=""){
          $(this).find('.cq-bannerblock-title').css('font-size', _bannertitlesize);
      }
      if(_bannercontentsize!=""){
          $(this).find('.cq-bannerblock-desc').css('font-size', _bannercontentsize);
      }
      if(_titleborderwidth!=""){
          $(this).find('.cq-bannerblock-line').css('width', _titleborderwidth);
      }


      _button.css({
        'color': _backbuttoncolor,
        'background-color': _backbuttonbg
      });

      if(_buttonpadding!=""){
        _button.css('padding', _buttonpadding);
      }
      if(_buttonshape!=""){
        _button.css('border-radius', _buttonshape);
      }

      if(_backbuttonhoverbg!=""||_backbuttonhovercolor!=""){
          _button.on('mouseover', function(event) {
            $(this).css({
              'color': _backbuttonhovercolor,
              'background-color': _backbuttonhoverbg
            });
          }).on('mouseleave', function(event) {
            $(this).css({
              'color': _backbuttoncolor,
              'background-color': _backbuttonbg
            });
          })
      }

      if(_buttonborder!="none"||_buttonborder!=""){
          _button.css({
            'border-style': _buttonborder,
            'border-width': _buttonbordersize,
            'border-color': _buttonbordercolor
          });


      }


      if(_titleborder!="none"){
          $(this).find('.cq-bannerblock-line').css({
            'border-top-style': _titleborder,
            'border-top-width': _titlebordersize,
            'border-top-color': _titlebordercolor
          });
      }

  });
});

