jQuery(document).ready(function($) {
  "use strict";
   function _is_msie() {
      var ua = window.navigator.userAgent;
      var msie = ua.indexOf("MSIE ");
      if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)){
          return true;
      }else{
          return false;
      }

  }
  $('.cq-twoface-box-container').each(function(index) {
    var _this = $(this);
    var _twoface = $(this).find('.cq-twoface-box');
    var _timeid;
    var _frontbg = $(this).data('frontbg');
    var _frontavatar = $(this).data('frontavatar');
    var _frontfullimage = $(this).data('frontfullimage');
    var _backavatar = $(this).data('backavatar');
    var _backfullimage = $(this).data('backfullimage');
    var _backbg = $(this).data('backbg');
    var _iconcolor = $(this).data('iconcolor');
    var _fontcolor = $(this).data('contentcolor') || $(this).data('fontcolor');
    var _cubedirection = $(this).data('cubedirection');
    var _cubeheight = $(this).data('cubeheight') || '200px';
    var _avatarsize = parseInt($(this).data('avatarsize') || '80', 10);
    var _contentsize = $(this).data('contentsize');
    var _titlesize = $(this).data('titlesize');
    var _contentwidth = $(this).data('contentwidth');
    var _rotatecube = parseInt($(this).data('rotatecube'));
    var _cubewidth = $(this).data('cubewidth');
    var _cubemargin = $(this).data('cubemargin');
    _this.css({
      'margin': _cubemargin
    });
    var _face1 = '.' + $(this).data('face1');
    var _face2 = '.' + $(this).data('face2');
    $(this).find(_face1).css('background-color', _frontbg);
    $(this).find(_face2).css('background-color', _backbg);
    _twoface.css({
      'width': _cubewidth,
      'height': _cubeheight
    });
    if(_contentsize!="") _this.find('.cq-face-item').css('font-size', _contentsize);
    if(_titlesize!="") _this.find('.cq-face-title').css('font-size', _titlesize);
    _this.find('.cq-face-avatar').css({
      'color': _iconcolor,
      'width': _avatarsize,
      'height': _avatarsize,
      'font-size': _avatarsize,
      'line-height': _avatarsize + 'px'
    });

    if(_frontfullimage!=""){
        _this.find('.cq-face-item').each(function(index) {
            if(index==0){
                $(this).css({
                    'background': 'url(' + _frontfullimage + ') no-repeat center center',
                    'background-size': 'cover'
                });
            }
        });
    }
    if(_backfullimage!=""){
        _this.find('.cq-face-item').each(function(index) {
            if(index==1){
                $(this).css({
                    'background': 'url(' + _backfullimage + ') no-repeat center center',
                    'background-size': 'cover'
                });
            }
        });
    }




    function _resettranslatez(){

        if(_cubedirection=="bottomtop"&&_cubeheight!="200px"&&!_is_msie()){
            _this.find(_face1).css({
              '-webkit-transform' : 'translateZ(' + _cubeheight*0.5 + 'px)',
              '-moz-transform' : 'translateZ(' + _cubeheight*0.5 + 'px)',
              '-ms-transform' : 'translateZ(' + _cubeheight*0.5 + 'px)',
              'transform' : 'translateZ(' + _cubeheight*0.5 + 'px)'
            });
            _this.find(_face2).css({
              '-webkit-transform' : 'rotateX(-90deg) translateZ(' + _cubeheight*0.5 + 'px)',
              '-moz-transform' : 'rotateX(-90deg) translateZ(' + _cubeheight*0.5 + 'px)',
              '-ms-transform' : 'rotateX(-90deg) translateZ(' + _cubeheight*0.5 + 'px)',
              'transform' : 'rotateX(-90deg) translateZ(' + _cubeheight*0.5 + 'px)'
            });

        }

        if(_cubedirection!="bottomtop"&&!_is_msie()){
            _this.find(_face1).css({
              '-webkit-transform': 'translateZ(' + (_this.find('.cq-twoface-box').width()*0.5) + 'px)',
              '-moz-transform': 'translateZ(' + (_this.find('.cq-twoface-box').width()*0.5) + 'px)',
              '-ms-transform': 'translateZ(' + (_this.find('.cq-twoface-box').width()*0.5) + 'px)',
              'transform': 'translateZ(' + (_this.find('.cq-twoface-box').width()*0.5) + 'px)'
            });
            _this.find(_face2).css({
              '-webkit-transform': 'rotateY(-90deg) translateZ(' + (_this.find('.cq-twoface-box').width()*0.5 - 1) + 'px)',
              '-moz-transform': 'rotateY(-90deg) translateZ(' + (_this.find('.cq-twoface-box').width()*0.5 - 1) + 'px)',
              '-ms-transform': 'rotateY(-90deg) translateZ(' + (_this.find('.cq-twoface-box').width()*0.5 - 1) + 'px)',
              'transform': 'rotateY(-90deg) translateZ(' + (_this.find('.cq-twoface-box').width()*0.5 - 1) + 'px)'
            });
        }
    }

    if(_is_msie()){
        _this.find(_face2).css({
          '-ms-transform': 'rotateY(0deg) translateZ(0)',
          'transform': 'rotateY(0deg) translateZ(0)'
        });
        if(_cubedirection=="bottomtop"){
            _twoface.removeClass('showback_ie').addClass('showfront_ie');
        }else{
            _twoface.removeClass('showright_ie').addClass('showleft_ie');
        }


    }

    $(window).on('resize', function(event) {
        if(_cubedirection!="bottomtop"){
            _resettranslatez();
        }
    });
    _resettranslatez();

    var _slideID = 0;
    function _slideshow(){
        clearTimeout(_slideID);
        _slideID = setTimeout(function() {
            if(_isover){
                _this.trigger('mouseleave');
            }else{
                _this.trigger('mouseover');
            }
        }, _rotatecube*1000);
    }
    if(_rotatecube>0){
        _slideshow();
    }


    $(this).find('.cq-face-content').css({
      'color': _fontcolor,
      'width': _contentwidth
    });;
    $(this).find('.cq-face-content .cq-face-title').css('color', _fontcolor);
    var _isover = false;
    $(this).on('mouseover', function(event) {
        _isover = true;
        clearTimeout(_slideID);
        if(_is_msie()){
          if(_cubedirection=="bottomtop"){
              _twoface.removeClass('showfront_ie').addClass('showback_ie');
          }else{
              _twoface.removeClass('showleft_ie').addClass('showright_ie');
          }
        }else{
          if(_cubedirection=="bottomtop"){
              _twoface.removeClass('showfront').addClass('showback');
          }else{
              _twoface.removeClass('showleft').addClass('showright');
          }

        }
        _twoface.one('transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd',function(e) {
            if(_rotatecube>0){
                _slideshow();
            }
        });

    }).on('mouseleave', function(event) {
      clearTimeout(_timeid);
      clearTimeout(_slideID);
      _isover = false;
      _timeid = setTimeout(function() {
            if(_is_msie()){
              if(_cubedirection=="bottomtop"){
                  _twoface.removeClass('showback_ie').addClass('showfront_ie');
              }else{
                  _twoface.removeClass('showright_ie').addClass('showleft_ie');
              }
            }else{
              if(_cubedirection=="bottomtop"){
                  _twoface.removeClass('showback').addClass('showfront');
              }else{
                  _twoface.removeClass('showright').addClass('showleft');
              }
            }
            _twoface.one('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd',function(e) {
                if(_rotatecube>0){
                    _slideshow();
                }
            });
      }, 300);
    });

  });
});

