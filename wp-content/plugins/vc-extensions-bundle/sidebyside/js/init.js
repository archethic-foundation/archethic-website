jQuery(document).ready(function($) {
    "use strict";
    $('.cq-sidebyside-container').each(function(index) {
        var _this = $(this);
        var _divider = $(this).find('.cq-sidebyside-divider');
        var _card1titlecolor = $(this).data('card1titlecolor')
        var _carddirection = $(this).data('carddirection')
        var _card1contentcolor = $(this).data('card1contentcolor')
        var _card1iconcolor = $(this).data('card1iconcolor')
        var _card1bg = $(this).data('card1bg')
        var _card2titlecolor = $(this).data('card2titlecolor')
        var _card2contentcolor = $(this).data('card2contentcolor')
        var _card2iconcolor = $(this).data('card2iconcolor')
        var _card2bg = $(this).data('card2bg')
        var _card1iconsize = $(this).data('card1iconsize');
        var _card2iconsize = $(this).data('card2iconsize');
        var _cardheight = $(this).data('cardheight');
        var _dividerborder = $(this).data('dividerborder');
        var _dividerfontsize = $(this).data('dividerfontsize');
        var _dividerwidth = $(this).data('dividerwidth');
        var _dividerheight = $(this).data('dividerheight');
        var _contentsize = $(this).data('contentsize');
        var _titlesize = $(this).data('titlesize');
        var _contentwidth = $(this).data('contentwidth');
        var _elementwidth = $(this).data('elementwidth');
        var _cardmargin = $(this).data('cardmargin');
        var _card1avatar = $(this).data('card1avatar');
        var _card2avatar = $(this).data('card2avatar');
        var _tooltipposition = $(this).data('tooltipposition');
        var _isgap = $(this).data('isgap');
        var _gapcolor = $(this).data('gapcolor');
        var _followyoffset = parseInt($(this).data('followyoffset'));


        var _dividerbg = $(this).data('dividerbg')
        var _dividercolor = $(this).data('dividercolor')


        $(this).css({
            'margin': _cardmargin,
            'width': _elementwidth,
            'height': _cardheight
        });

        if(_isgap=="cq-isgap"&&_gapcolor!=""){
            if(_carddirection=="leftright"){
                $(this).find('.cq-sidecontent-1').css('border-right-color', _gapcolor);
                $(this).find('.cq-sidecontent-2').css('border-left-color', _gapcolor);
            }else{
                $(this).find('.cq-sidecontent-1').css('border-bottom-color', _gapcolor);
                $(this).find('.cq-sidecontent-2').css('border-top-color', _gapcolor);
            }
        }


        $(this).find('.cq-sidebyside-content').each(function(index) {
            var _title = $(this).data('cardtitle');
            var _avatar = $(this).data('cardavatar');
            var _iconcolor = $(this).data('iconcolor');

            if(_iconcolor!=""){
                $(this).find('.cq-sidebyside-cardicon, .cq-sidebyside-icontext').css('color', _iconcolor);
            }
            if(_followyoffset!=""){
                $(this).find('.cq-sidebyside-icontext').css({
                    '-webkit-transform': 'translateY(' + _followyoffset + 'px)',
                    '-moz-transform': 'translateY(' + _followyoffset + 'px)',
                    '-ms-transform': 'translateY(' + _followyoffset + 'px)',
                    'transform': 'translateY(' + _followyoffset + 'px)'
                });
            }

            if(_title!=""&&_avatar=="image"){
                $(this).tooltipster({
                  content: _title,
                  position: _tooltipposition,
                  delay: 100,
                  speed: 300,
                  touchDevices: false,
                  interactive: true,
                  animation: 'grow',
                  theme: 'tooltipster-shadow',
                  contentAsHTML: true
                });

            }
        });


        if(_card1avatar=="image"){
            var _paragraphy1 = $(this).find('.cq-sidebyside-paragraphy').eq(0);
            if(_paragraphy1&&_paragraphy1.data('image')){
                _paragraphy1.css({
                    'width' : '100%',
                    'height' : '100%',
                    'background-size': 'cover',
                    'background-image': 'url(' + _paragraphy1.data('image') + ')'
                });
            }
        }
        if(_card2avatar=="image"){
            var _paragraphy2 = $(this).find('.cq-sidebyside-paragraphy').eq(1);
            if(_paragraphy2&&_paragraphy2.data('image')!=""){
                _paragraphy2.css({
                    'width' : '100%',
                    'height' : '100%',
                    'background-size': 'cover',
                    'background-image': 'url(' + _paragraphy2.data('image') + ')'
                });
            }
        }


        $(this).find('.cq-sidecontent-1 .cq-sidebyside-iconcontainer').css({
            'font-size': _card1iconsize
        });
        $(this).find('.cq-sidecontent-2 .cq-sidebyside-iconcontainer').css({
            'font-size': _card2iconsize
        });
        $(this).find('.cq-sidecontent-1 .cq-sidebyside-cardicon').css({
            'font-size': _card1iconsize
        });
        $(this).find('.cq-sidecontent-2 .cq-sidebyside-cardicon').css({
            'font-size': _card2iconsize
        });

        $(this).find('.cq-sidebyside-divider').css({
            'color': _dividercolor,
            'font-size': _dividerfontsize,
            'line-height': _dividerheight,
            'width': _dividerwidth,
            'height': _dividerheight,
            'border-radius': _dividerborder,
            'background-color': _dividerbg
        });

        if(_card1bg!="")$(this).find('.cq-sidecontent-1').css('background-color', _card1bg);
        $(this).find('.cq-sidecontent-1 .cq-sidebyside-title').css({
            'color': _card1titlecolor,
            'width': _contentwidth,
            'font-size': _titlesize
        });
        $(this).find('.cq-sidecontent-1 .cq-sidebyside-text').css({
            'color': _card1contentcolor,
            'width': _contentwidth,
            'font-size': _contentsize
        });

        if(_card2bg!="")$(this).find('.cq-sidecontent-2').css('background-color', _card2bg);
        $(this).find('.cq-sidecontent-2 .cq-sidebyside-title').css({
            'color': _card2titlecolor,
            'width': _contentwidth,
            'font-size': _titlesize
        });
        $(this).find('.cq-sidecontent-2 .cq-sidebyside-text').css({
            'color': _card2contentcolor,
            'width': _contentwidth,
            'font-size': _contentsize
        });


        var _dw = parseInt(_divider.outerWidth());
        var _dh = parseInt(_divider.outerHeight());
        _divider.css({
            'top': 'calc(50% - ' + _dh*0.5 + 'px)',
            'left': 'calc(50% - ' + _dw*0.5 + 'px)'
        });
    });
});

