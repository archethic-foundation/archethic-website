function hexToRgb(hex) {
  // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
  var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
  hex = hex.replace(shorthandRegex, function(m, r, g, b) {
      return r + r + g + g + b + b;
  });

  var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
  return result ? {
      r: parseInt(result[1], 16),
      g: parseInt(result[2], 16),
      b: parseInt(result[3], 16)
  } : null;
}

jQuery(document).ready(function($) {
    "use strict";
    $('.cqtooltip-wrapper').each(function() {
      var _this = $(this);
      var _tooltipstyle = $(this).data('tooltipstyle');
      var _tooltipanimation = $(this).data('tooltipanimation');
      var _trigger = $(this).data('trigger') || "hover";
      var _maxwidth = $(this).data('maxwidth') || 320;
      var _opacity = $(this).data('opacity') || 0.5;
      var _isdisplayall = $(this).data('isdisplayall');
      var _displayednum = parseInt($(this).data('displayednum'));
      var _marginoffset = $(this).data('marginoffset') || '0';
      var _newbg;

      if(_marginoffset!="0"){
          $(window).on('resize', function(event) {
              var _windowwidth = $(this).width();
              if(_windowwidth<=540){
                  $('.hotspot-item', _this).each(function(index) {
                      $(this).css('margin', _marginoffset);
                  })
              }else{
                  $('.hotspot-item', _this).each(function(index) {
                      $(this).css('margin', '0');
                  })
              }
          });
          $(window).trigger('resize');
      }

      $('.cq-tooltip', $(this)).each(function(index) {
        var _tooltip = $(this);
        var _iconbg = $(this).data('iconbg');
        var _bg = $(this).css('background-color');
        var _arrowposition = $(this).data('arrowposition') || 'top';
        if(_bg.indexOf('a') == -1){
          _newbg = _bg.replace(')', ', '+_opacity+')').replace('rgb', 'rgba');
        }else{
          _newbg = _bg;
        }
        $(this).css('background-color', _newbg);
        if(_iconbg!=""){
          $(this).attr('style', 'background-color: ' + _iconbg + ' !important');
        }
        $(this).on('click', function(event) {
          if($(this).attr('href')==""||$(this).attr('href')=="#") event.preventDefault();
        });
        var _content = $(this).data('tooltip');
        var _offsetx = $(window).width()<=480?0:2;
        var _offsety = 0;


        $(this).tooltipster({
          content: _content,
          position: _arrowposition,
          offsetX: _offsetx,
          offsetY: _offsety,
          maxWidth: _maxwidth,
          delay: 100,
          speed: 300,
          interactive: true,
          animation: _tooltipanimation,
          trigger: _trigger,
          contentAsHTML: true,
          theme   : 'tooltipster-' + _tooltipstyle,
        });
        if(_isdisplayall=="on"){
            setTimeout(function() {
              _tooltip.tooltipster('show');
            }, 600);
        }else if(_isdisplayall=="specify"&&(_displayednum-1)==index){
              setTimeout(function() {
                _tooltip.tooltipster('show');
              }, 600);
        }

  });


  });


});

