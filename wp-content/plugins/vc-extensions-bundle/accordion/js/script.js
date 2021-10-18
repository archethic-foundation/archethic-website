jQuery(document).ready(function($) {
    "use strict";
    $('.cq-accordion').each(function() {
        var _this = $(this);
        var _displayfirst = $(this).data('displayfirst') == "on" ? true : false;
        $(this).find('.accordion-content').each(function(index) {
        });
        $(this).find('li').each(function(index) {
          if(index==0&&_displayfirst) $(this).find('input').trigger('click');
          $(this).find('i').css('margin-top', ($(this).outerHeight()-9)*.5);
        });
    })
    $('.cq-accordion2').each(function() {
        var _this = $(this);
        var _titlebg = $(this).data('titlebg');
        var _titlecolor = $(this).data('titlecolor');
        var _titlehoverbg = $(this).data('titlehoverbg');
        var _titlehovercolor = $(this).data('titlehovercolor');
        var _displayfirst = $(this).data('displayfirst') == "on" ? true : false;
        $(this).find('.accordion-content').each(function(index) {
          $(this).children().first('p:empty').remove();
        });

        $(this).find('.accordionTitle').each(function(index) {
            $(this).css('background-color', _titlebg).on('mouseover', function(event) {
                $(this).css({
                  'background-color': _titlehoverbg,
                  'color': _titlehovercolor
                });
            }).on('mouseleave', function(event) {
                if(!$(this).hasClass('accordionTitleActive')){
                    $(this).css({
                      'background-color': _titlebg,
                      'color': _titlecolor
                    });
                }
            });
            if(index==0&&_displayfirst){
              var _content = $(this).parent().next();
              $(this).toggleClass('accordionTitleActive').css({
                  'background-color': _titlehoverbg,
                  'color': _titlehovercolor
                });

              if(_content.hasClass('accordionItemCollapsed')) {
                if(_content.hasClass('cq-animateOut')){
                  _content.removeClass('cq-animateOut');
                }
                _content.addClass('cq-animateIn');

              }else{
                 _content.removeClass('cq-animateIn');
                 _content.addClass('cq-animateOut');
              }
              _content.toggleClass('accordionItemCollapsed');
            }



        });
        $('.accordionTitle', $(this)).each(function(index) {
            $(this).on('click', function(event) {
              if($(this).hasClass('accordionTitle')){
                  var _content = $(this).parent().next();
                  $(this).toggleClass('accordionTitleActive');

                  if(_content.hasClass('accordionItemCollapsed')) {
                    if(_content.hasClass('cq-animateOut')){
                      _content.removeClass('cq-animateOut');
                    }
                    _content.addClass('cq-animateIn');

                  }else{
                     _content.removeClass('cq-animateIn');
                     _content.addClass('cq-animateOut');
                  }
                  _content.toggleClass('accordionItemCollapsed');
              }

              event.preventDefault();
            });
        });


    })

});

