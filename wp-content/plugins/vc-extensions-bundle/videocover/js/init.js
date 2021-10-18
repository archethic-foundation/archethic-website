jQuery(document).ready(function($) {
    "use strict";
    $('.cq-videocover-lightbox, .cq-videocover-imglightbox').each(function(index) {
    	var _videowidth = $(this).data('videowidth') == "" ? 800 : parseInt($(this).data('videowidth'))
    	if($(this).attr('href')!=""){
			$(this).lightbox({
	        	"fixed": true,
	        	"margin": 10,
	        	"videoWidth": _videowidth,
	        	"minWidth": 320
	        });
    	}
    });
    $('.cq-videocover').each(function(index, el) {
    	var _iconsize = $(this).data('iconsize');
    	var _iconbgsize = $(this).data('iconbgsize');
    	var _iconcolor = $(this).data('iconcolor');
    	var _iconbgcolor = $(this).data('iconbgcolor');
        var _iconposition = $(this).data('iconposition');
        var _imagetooltip = $(this).data('tooltip');
        var _tooltip = null;
        if(_imagetooltip!=""){
            if(_iconposition=="center"){
                _tooltip = $(this).tooltipster({
                    content: _imagetooltip,
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

            }else{
                _tooltip = $('.cq-videocover-iconcontainer', $(this)).tooltipster({
                    content: _imagetooltip,
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

            $(this).on('click', function(event) {
                if(_tooltip) _tooltip.tooltipster('hide');

            });
        }
    	if(_iconsize!=""){
    		$(this).find('.cq-videocover-icon, .cq-videocover-label').css({
    			'font-size': _iconsize
    		});
    	}
    	if(_iconbgsize!=""){
    		_iconbgsize = parseInt(_iconbgsize) + 'px';
    		$(this).find('.cq-videocover-iconcontainer').css({
    			'width': _iconbgsize,
    			'height': _iconbgsize
    		});
    		$(this).find('.cq-videocover-icon, .cq-videocover-label').css({
    			'line-height': _iconbgsize
    		})
    	}

    	if(_iconcolor!=""){
    		$(this).find('.cq-videocover-icon, .cq-videocover-label').css({
    			'color': _iconcolor
    		});
    	}
    	if(_iconbgcolor!=""){
    		$(this).find('.cq-videocover-iconcontainer').css({
    			'background-color': _iconbgcolor
    		});
    	}



    });
});
