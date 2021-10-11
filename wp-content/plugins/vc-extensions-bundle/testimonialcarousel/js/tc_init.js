jQuery(document).ready(function($) {
  "use strict";
  $('.cq-testimonialcarousel').each(function() {
      var _this = $(this);
      var _italic = $(this).data('italic') == 'on' ? 'italic' : 'normal';
      var _tnumber = $(this).data('tnumber');
      var _twidth = $(this).data('twidth');
      var _avatarwidth = $(this).data('avatarwidth');
      var _avatarheight = $(this).data('avatarheight');
      var _tmargin = $(this).data('tmargin');
      var _tpadding = $(this).data('tpadding');
      var _arrowmarginleft = $(this).data('arrowmarginleft');
      var _namemargin = $(this).data('namemargin');
      var _avatarmarginleft = $(this).data('avatarmarginleft');
      var _tbackgroundcolor = $(this).data('tbackgroundcolor');
      var _ttextcolor = $(this).data('ttextcolor');
      var _autoplay = $(this).data('autoplay') == "on" ? true:false;
      var _autoplayspeed = $(this).data('autoplayspeed');
      var _noloop = $(this).data('noloop') == "on" ? false:true;
      var _font = $(this).data('font');
      var _fontsize = $(this).data('fontsize');
      var _namesize = $(this).data('namesize');
      var _subtitlesize = $(this).data('subtitlesize');
      var _notooltip = $(this).data('notooltip') == "on" ? true:false;

      $(this).find('.headshot').each(function(index) {
        $(this).css({
          'margin-left': _avatarmarginleft,
          'width': _avatarwidth,
          'height': _avatarheight
        });
      });


      if(_namemargin!=""){
        $(this).find('.testimonial-info').css({
          'margin': _namemargin
        });
      }

      if(_namesize!=""){
        $(this).find('.testimonial-info > h4').css({
          'font-size': _namesize
        });
      }

      if(_subtitlesize!=""){
        $(this).find('.testimonial-info > p').css({
          'font-size': _subtitlesize
        });
      }


      if(_arrowmarginleft!=""){
        $(this).find('.arrow-down').css({
          'margin-left': _arrowmarginleft
        });
      }


      $(this).find('.testimonial').each(function(index) {
        var _color = $(this).data('color');
        var _background = $(this).data('background');
        if(_twidth!=""&&_twidth>0){
          $(this).css({
            'width': _twidth
          });
        }
        if(_tmargin!=""){
          $(this).css({
            'margin': _tmargin
          });
        }
        if(_fontsize!=""){
          $(this).css({
            'font-size': _fontsize
          });
        }

        if(_tpadding!=""){
          $(this).css({
            'padding': _tpadding
          });
        }

        if(_font!=""){
          $(this).css({
            'font-family': _font
          });
        }


        var _bg = _background || _tbackgroundcolor;
        var _tcolor = _color || _ttextcolor;

        $(this).css({
          'font-style': _italic,
          'color': _tcolor,
          'background-color': _bg
        });
        $(this).next('.arrow-down').css({
          'border-top-color': _bg
        });

      });


      // the tooltip
      function _updateTooltip(){
        $('.testimonial-info', _this).find('i').each(function(index) {
          var _title = $(this).attr('title');
          $(this).tooltipster({
            delay: 2600,
            animation: 'grow',
            position: 'top',
            offsetY: -4,
            delay: 50,
            theme: 'tooltipster-shadow'
          });
        });
      }


      _this.slick({
          dots: true,
          arrows: false,
          autoplay: _autoplay,
          autoplaySpeed: _autoplayspeed,
          infinite: _noloop,
          speed: 300,
          slidesToShow: _tnumber,
          slidesToScroll: 1,
          onInit: function(){
            if(!_notooltip) _updateTooltip();
          },
          responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: _tnumber,
                    arrows: false,
                    dots: true
                }
            }, {
                breakpoint: 960,
                settings: {
                    arrows: false,
                    slidesToShow: (_tnumber-1)>0?(_tnumber-1):1,
                    slidesToScroll: 1,
                    dots: true
                }
            },{
                breakpoint: 640,
                settings: {
                    arrows: false,
                    slidesToShow: (_tnumber-2)>0?(_tnumber-2):1,
                    slidesToScroll: 1,
                    dots: true
                }
            }, {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true
                }
            }]
      });



  });

});
