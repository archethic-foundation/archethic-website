jQuery(document).ready(function($) {
    "use strict";
    $('.cq-imageoverlay').each(function(index) {
        var _this = $(this);
        var _overlaycolor = $(this).data('overlaycolor');
        var _overlaysize = $(this).data('overlaysize');
        var _overlayshape = $(this).data('overlayshape');
        var _overlaymargin = $(this).data('overlaymargin');
        var _titlesize = $(this).data('titlesize');
        var _contentsize = $(this).data('contentsize');
        var _contentcolor = $(this).data('contentcolor');
        var _elementmargin = $(this).data('elementmargin');
        if(_elementmargin!="") $(this).css('margin', _elementmargin);
        if(_overlayshape!="heart"){
            $(this).find('.cq-imageoverlay-overlay').css({
              'width': _overlaysize,
              'height': _overlaysize,
              'margin': _overlaymargin,
              'background-color': _overlaycolor
            });
        }else{
            $(this).find('.cq-imageoverlay-overlay').css({
              'margin': _overlaymargin
            });

            $(this).find('.cq-heart-before, .cq-heart-after').css({
              'background-color': _overlaycolor
            });

        }

        if(_titlesize!=""){
          $(this).find('.cq-imageoverlay-title').css({
            'font-size': _titlesize
          });
        }
        if(_contentcolor!=""){
          $(this).find('.cq-imageoverlay-title').css('color', _contentcolor);
          $(this).find('.cq-imageoverlay-content').css('color', _contentcolor);
        }
        $(this).find('i.vc_li').css({
          'margin-top' : '5px'
        });
        if($(this).find('.cq-imageoverlay-content')[0]){
           $(this).find('.cq-imageoverlay-title').css('margin-bottom', '4px');
        }
        if(_contentsize!=""){
          $(this).find('.cq-imageoverlay-content').css({
            'font-size': _contentsize
          });
        }


    });
});

