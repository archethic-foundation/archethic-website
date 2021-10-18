jQuery(document).ready(function($) {
    "use strict";
    $('.cq-avatarblock').each(function(index, el) {
        var _this = $(this);
        var _tooltip = $(this).data('tooltip');
        var _bgcolor = $(this).data('bgcolor');
        var _custombgcolor = $(this).data('custombgcolor');
        var _contentheight = $(this).data('contentheight');
        var _bordercolor = $(this).data('bordercolor');
        if(_bordercolor!=""){
        	$('.cq-avatarblock-avatar', _this).css('border', '4px solid ' + _bordercolor);
        }
        if(_contentheight!=""){
	        $('.cq-avatarblock-content', _this).css('height', _contentheight);
        }
        if(_bgcolor=="customized"&&_custombgcolor!=""){
        	$('.cq-avatarblock-contentcontainer, .cq-avatarblock-avatar', _this).css('background-color', _custombgcolor);
        }
        if(_tooltip&&_tooltip!==""){
            var _tooltip = $('.cq-avatarblock-avatar', _this).tooltipster({
                content: _tooltip,
                position: 'top',
                delay: 200,
                interactive: true,
                speed: 300,
                touchDevices: true,
                animation: 'grow',
                theme: 'tooltipster-shadow',
                contentAsHTML: true
            });
        }

    });
});
