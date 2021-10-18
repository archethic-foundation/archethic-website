jQuery(document).ready(function($) {
    "use strict";
    $('.cq-tabs').each(function(index) {
        var _this = $(this);
        var _tabsstyle = $(this).data('tabsstyle');
        var _titlecolor = $(this).data('titlecolor');
        var _titlebg = $(this).data('titlebg');
        var _titlehovercolor = $(this).data('titlehovercolor');
        var _titlehoverbg = $(this).data('titlehoverbg');
        var _rotatetabs = parseInt($(this).data('rotatetabs'));
        var _tabnumbers = $(this).find('ul.cq-tabmenu li').length;
        var _currentIndex = 0;
        $(this).find('ul.cq-tabmenu').addClass('active').find('> li:eq(0)').addClass('current');
        $(this).find('ul.cq-tabmenu li').each(function(index) {
            if(index==0){
                if(_tabsstyle=="style2"||_tabsstyle=="style1"){
                    $(this).find('a').css({
                       'background': _titlehoverbg,
                       'color': _titlehovercolor
                    });

                }else{
                    $(this).find('a').css({
                       'color': _titlehovercolor
                    });
                    $(this).css({
                       'background': _titlehoverbg,
                       'color': _titlehovercolor
                   });

                }

            }
            $(this).on('mouseover', function(event) {
                if(_tabsstyle=="style2"||_tabsstyle=="style1"){
                    $(this).find('a').css({
                       'background': _titlehoverbg,
                       'color': _titlehovercolor
                   });

                }else{
                    $(this).find('a').css({
                       'color': _titlehovercolor
                    });
                    $(this).css({
                       'background': _titlehoverbg,
                       'color': _titlehovercolor
                   });

                }

            }).on('mouseleave', function(event) {
                if(!$(this).hasClass('current')){
                    if(_tabsstyle=="style2"||_tabsstyle=="style1"){
                        $(this).find('a').css({
                           'background': _titlebg,
                           'color': _titlecolor
                        });
                    }else{
                        $(this).find('a').css({
                           'color': _titlecolor
                        });
                        $(this).css({
                           'background': _titlebg,
                           'color': _titlecolor
                        });
                    }
                }
            });

        });


        $(this).find('ul.cq-tabmenu li a').click(function (g) {
            var tab = $(this).closest('.cq-tabs'),
                index = $(this).closest('li').index();
            tab.find('ul.cq-tabmenu > li').removeClass('current');
            if(_tabsstyle=="style2"||_tabsstyle=="style1"){
                tab.find('ul.cq-tabmenu > li').find('a').css({'background': _titlebg, 'color': _titlecolor });
            }else{
                tab.find('ul.cq-tabmenu > li').find('a').css({'color': _titlecolor });
                tab.find('ul.cq-tabmenu > li').css({'background': _titlebg, 'color': _titlecolor });
            }
            var _current = $(this).closest('li').addClass('current');
            if(_tabsstyle=="style2"||_tabsstyle=="style1"){
                _current.find('a').css({'background': _titlehoverbg, 'color': _titlehovercolor });
            }else{
                _current.find('a').css({'color': _titlehovercolor });
                _current.css({'background': _titlehoverbg, 'color': _titlehovercolor });
            }

            tab.find('.cq-tabcontent').find('div.cq-tabitem').not('div.cq-tabitem:eq(' + index + ')').slideUp(400, function(){
                if(_rotatetabs>0){
                    _slideshow();
                }

            });
            tab.find('.cq-tabcontent').find('div.cq-tabitem:eq(' + index + ')').slideDown();
            _currentIndex = index;
            g.preventDefault();
        });

        var _slideID = 0;
        function _slideshow(){
            clearTimeout(_slideID);
            _currentIndex++;
            if(_currentIndex>_tabnumbers-1) _currentIndex = 0;
            _slideID = setTimeout(function() {
                _this.find('ul.cq-tabmenu li').each(function(index) {
                    if(_currentIndex==index){
                        $(this).find('a').trigger('click');
                    }
                });

            }, _rotatetabs*1000);
        }
        if(_rotatetabs>0){
            _slideshow();
        }

      });


});
