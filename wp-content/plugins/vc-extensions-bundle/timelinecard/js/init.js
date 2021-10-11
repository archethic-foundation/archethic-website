jQuery(document).ready(function($) {
    "use strict";
    $('.cq-timelinecard').each(function(index) {
        var _this = $(this);
        var _elementheight = parseInt($(this).data('elementheight'), 10);
        var _textcolor = $(this).data('textcolor');
        var _titlecolor = $(this).data('titlecolor');
        var _titlefontsize = $(this).data('titlefontsize');
        var _subtitlecolor = $(this).data('subtitlecolor');
        var _subtitlefontsize = $(this).data('subtitlefontsize');
        var _bordercolor = $(this).data('bordercolor');

        if(_textcolor!=""){
            $('.cq-timelinecard-headertitle, cq-timelinecard-headersub', _this).css('color', _textcolor);
        }
        if(_bordercolor!=""){
            $('.cq-timelinecard-border', _this).css('background-color', _bordercolor);
        }

        $('.cq-timelinecard-listitem', _this).each(function(index) {
            var _iconcolor = $(this).data('iconcolor');
            var _iconbgcolor = $(this).data('iconbgcolor');
            var _datecolor = $(this).data('datecolor');
            var _titlecolor = $(this).data('titlecolor');

            if(_iconcolor!=""){
                $('.cq-timelinecard-icon', $(this)).css('color', _iconcolor);
            }
            if(_iconbgcolor!=""){
                $('.cq-timelinecard-iconcontainer', $(this)).css('background', _iconbgcolor);
            }
            if(_datecolor!=""){
                $('.cq-timelinecard-date', $(this)).css('color', _datecolor);
            }
            if(_titlecolor!=""){
                $('.cq-timelinecard-title', $(this)).css('color', _titlecolor);
            }

        });

        if(_titlecolor!=""){
            $(".cq-timelinecard-headertitle", _this).css('color', _titlecolor);
        }
        if(_titlefontsize!=""){
            $(".cq-timelinecard-headertitle", _this).css('font-size', _titlefontsize);
        }

        if(_subtitlecolor!=""){
            $(".cq-timelinecard-headersub", _this).css('color', _subtitlecolor);
        }
        if(_subtitlefontsize!=""){
            $(".cq-timelinecard-headersub", _this).css('font-size', _subtitlefontsize);
        }


    });

});
