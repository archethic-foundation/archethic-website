jQuery(document).ready(function($) {
    "use strict";
    $('.cq-stackblock').each(function(index) {
        var _elementheight = $(this).data('elementheight');
        var _contentwidth = $(this).data('contentwidth');
        var _textalign = $(this).data('textalign');
        var _fontsize = $(this).data('fontsize');
        var _tooltip = $(this).data('tooltip');

        if(_elementheight!=""){
            $('.cq-stackblock-card', $(this)).css({
                'height': parseInt(_elementheight)
            });
            $(this).addClass('vertical-middle');
        }

        if(_contentwidth!=""){
            $('.cq-stackblock-content', $(this)).css({
                'width': _contentwidth,
                'margin': '0 auto'
            });
        }

        if(_textalign!=""){
            $('.cq-stackblock-content', $(this)).css({
                'text-align': _textalign
            });
        }

        if(_tooltip!=""){
            var _stackTooltip = $(this).tooltipster({
                content: _tooltip,
                position: 'top',
                offsetY: '-4',
                delay: 200,
                speed: 300,
                touchDevices: true,
                interactive: false,
                animation: 'fade',
                theme: 'tooltipster-shadow',
                contentAsHTML: true
            });
        }

    });
});
