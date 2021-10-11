function _is_msie() {
      var ua = window.navigator.userAgent;
      var msie = ua.indexOf("MSIE ");
      if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)){
          return true;
      }else{
          return false;
      }

  }

jQuery(document).ready(function($) {
  "use strict";
  $('.cq-flipbox-container').each(function(index) {
    var _this = $(this);
    var _timeid;
    var _frontbg = $(this).data('frontbg');
    var _backbg = $(this).data('backbg');
    var _iconcolor = $(this).data('iconcolor');
    var _iconbg = $(this).data('iconbg');
    var _frontcontentcolor = $(this).data('frontcontentcolor');
    var _backcontentcolor = $(this).data('backcontentcolor');
    var _cubedirection = $(this).data('cubedirection');
    var _elementheight = $(this).data('elementheight') || '200px';
    var _avatarsize = parseInt($(this).data('avatarsize') || '80', 10);
    var _titlesize = $(this).data('titlesize');
    var _contentsize = $(this).data('contentsize');
    var _contentwidth = $(this).data('contentwidth');
    var _rotatecube = parseInt($(this).data('rotatecube'));
    var _elementwidth = $(this).data('elementwidth');
    var _elementmargin = $(this).data('elementmargin');
    var _cardborder = $(this).data('cardborder');
    var _cardbordersize = $(this).data('cardbordersize');
    var _bordercolor = $(this).data('bordercolor');
    var _backbuttonbg = $(this).data('backbuttonbg');
    var _backbuttonhoverbg = $(this).data('backbuttonhoverbg');
    var _contentmargintop = $(this).data('contentmargintop');
    var _cardshape = $(this).data('cardshape');
    var _avatartype = $(this).data('avatartype');
    var _frontfullimage = $(this).data('frontfullimage');
    var _backavatar = $(this).data('backavatar');
    var _backfullimage = $(this).data('backfullimage');

    if(_elementmargin==""){
      _this.css({
        'margin-top': _avatarsize*0.5
      });
    }else{
      _this.css({
        'margin': _elementmargin
      });
    }
    var _face1 = '.' + $(this).data('face1');
    var _face2 = '.' + $(this).data('face2');
    $(this).find(_face1).css('background-color', _frontbg);
    $(this).find(_face2).css('background-color', _backbg);
    if(/* _avatartype=="fullimage"&& */_frontfullimage!=""){
        $(this).find(_face1).css({
            'background': 'url(' + _frontfullimage + ') no-repeat',
            'background-size': 'cover',
            'background-position': 'center center'
        });
    }
    if(/* _backavatar=="fullimage"&& */_backfullimage!=""){
        $(this).find(_face2).css({
            'background': 'url(' + _backfullimage + ') no-repeat',
            'background-size': 'cover',
            'background-position': 'center center'
        });
    }


    $(this).find('.cq-flipbox-button').css({
      'background-color': _backbuttonbg
    });

    if(_is_msie()){
      $(this).on('mouseover', function(event) {
        $(this).find('.cq-flipbox-flipper').css({
          '-ms-transform': 'rotateX(0deg) rotateY(0deg)',
          'transform': 'rotateX(0deg) rotateY(0deg)'
        })
        $(this).find(_face1).hide();
        $(this).find(_face2).css({
          '-ms-transform': 'rotateX(0deg)',
          'transform': 'rotateX(0deg)'
        }).show();
      }).on('mouseleave', function(event) {
        $(this).find(_face1).show();
        $(this).find(_face2).hide();
      });
    }

    $(this).find('.cq-flipbox-button').on('mouseover', function(event) {
        $(this).css('background-color', _backbuttonhoverbg);
    }).on('mouseleave', function(event) {
        $(this).css('background-color', _backbuttonbg||'#3BAFDA');
    });

    if(_cardborder!="none"){
      $(this).find(_face1).css({
        'border-width': _cardbordersize || '1px',
        'border-style': _cardborder,
        'border-color': _bordercolor,
      });
      $(this).find(_face2).css({
        'border-width': _cardbordersize || '1px',
        'border-style': _cardborder,
        'border-color': _bordercolor,
      });
    }




    _this.find('.cq-flipbox-item').each(function(index) {
        if(_cardshape=="square") $(this).css('border-radius', '0');
    });

    $('.cq-flipbox-content',$(this).find(_face1)).css('color', _frontcontentcolor);
    $('.cq-flipbox-title',$(this).find(_face1)).css('color', _frontcontentcolor);
    $('.cq-flipbox-content',$(this).find(_face2)).css('color', _backcontentcolor);
    $('.cq-flipbox-title',$(this).find(_face2)).css('color', _backcontentcolor);
    _this.css({
      'width': _elementwidth,
      'height': _elementheight
    });
    _this.find('.cq-flipbox-content').css({
      'width': _contentwidth,
      'margin-top': _contentmargintop,
      'font-size': _contentsize
    });
    _this.find('h4.cq-flipbox-title').css('font-size', _titlesize);
    _this.find('.cq-flipbox-avatar, .cq-flipbox-cardavatar').css({
      'color': _iconcolor,
      'background-color': _iconbg,
      'width': _avatarsize,
      'height': _avatarsize,
      'font-size': _avatarsize*0.5 + 'px',
      'line-height': _avatarsize + 'px'
    });

  });
});

