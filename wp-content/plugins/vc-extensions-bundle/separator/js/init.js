jQuery(document).ready(function($) {
  "use strict";
  $('.cq-hr').each(function(index) {
      var _this = $(this);

      var _bordercolor = $(this).data('bordercolor') || 'transparent';
      var _centerbordercolor = $(this).data('centerbordercolor') || 'transparent';
      var _borderstyle = $(this).data('borderstyle');
      var _bgcolor = $(this).data('bgcolor') || 'transparent';
      var _fontcolor = $(this).data('fontcolor');
      var _shape = $(this).data('shape');
      var _leftcolor = $(this).data('leftcolor');
      var _centercolor = $(this).data('centercolor');
      var _rightcolor = $(this).data('rightcolor');
      var _elementwidth = $(this).data('elementwidth') || '100%';
      var _bordersize = $(this).data('bordersize') || '1px';
      var _fontsize = $(this).data('fontsize') || '1em';
      var _titleposition = $(this).data('titleposition');
      var _titlewidth = $(this).data('titlewidth') || '';
      var _borderradius = $(this).data('borderradius');
      var _padding = $(this).data('padding');
      var _margin = $(this).data('margin');
      var _fontfamily = $(this).data('fontfamily');


      $(this).css({
        'margin': _margin,
        'width': _elementwidth
      });
      if(_borderstyle=="gradient-color"){
        $(this).css({
          'background-image': 'linear-gradient(to right, ' + _leftcolor +', ' + _centercolor + ', ' + _rightcolor + ')',
          'height': _bordersize,
          'border-bottom': 'none'
        });
      }else{
        $(this).css({
          'border-bottom-color': _bordercolor,
          'border-bottom-style': _borderstyle,
          'border-bottom-width': _bordersize
        });
      }

      $(this).find('.cq-hr-icon-container').css({
        'left': _titleposition
      });
      $(this).find('.cq-hr-symbol').css({
        'font-family': _fontfamily,
        'width': _titlewidth,
        'padding': _padding,
        'font-size': _fontsize,
        'color': _fontcolor,
        'border-radius': _borderradius,
        'background-color': _bgcolor,
        'border-style': _borderstyle,
        'border-color': _centerbordercolor
      });
  });
});

