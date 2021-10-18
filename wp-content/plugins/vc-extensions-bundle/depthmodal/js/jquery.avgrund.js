(function($) {
    "use strict";
    $.fn.vcModal = function(options) {
        var _this = this;

        var settings = $.extend({
            'container' : '.avgrund-container',
            'param' : 'value'
        }, options);

        var _container = $(document.documentElement).addClass('avgrund-ready');
        var _popup = _this.find('.avgrund-popup');
        var _content = _this.find('.avgrund-content');
        var _contentstr = _this.find('.avgrund-content').contents();
        _this.data('content', _contentstr);
        var _width = $(this).data('width');
        if(_this.data('loadedvisible')!='on'){
        	_popup.hide();
        }
        _popup.css({
        	'padding': '0',
    		'color': _this.data('textcolor'),
    		'background': _this.data('background'),
        	'margin-top': _this.data('margintop')
    	});
        if(_this.data('popupposition')!=""){
            _popup.css('position', _this.data('popupposition'));
        }
        if(typeof _width == 'string'){
        	// percent value of the width
        	_width = _width.replace(/[^\d\.]/g, '');
        	_popup.css({
	        	'width': _this.data('width'),
	        	'margin-left': -_width*.5 + '%'
        	});

        }else{
        	// fixed value of the width
        	_popup.css({
	        	'margin-left': -_width*.5,
	        	'width': _this.data('width')
        	});
        }

        $('.avgrund-cover').each(function(index) {
        	if(index>0) $(this).remove();

		});
        var _cover = _this.find('.avgrund-cover');
        var _openBtn = _this.find('.avgrund-btn');
        var _vcBtn = _openBtn.next('.vc_btn');
        var _closeBtn = _this.find('.avgrund-close');
		_popup.insertAfter('body');
		_cover.insertAfter('body');

		_closeBtn.on('click', deactivate);

		if(_vcBtn[0]){
			_vcBtn.on('click', function(event) {
	        	activate();
	        	event.preventDefault();
	        });
		}

        _openBtn.on('click', function(event) {
        	activate();
        	event.preventDefault();
        });

        function openModal(){

        }
        function activate() {

			$(document).on('click touchstart', onDocumentClick);
			$(document).on('keyup', onDocumentKeyUp);
            if(_popup.find('.avgrund-content').contents().html()==""||!_popup.find('.avgrund-content').contents().html()) {
                _popup.find('.avgrund-content').contents().detach();
                _this.data('content').appendTo(_popup.find('.avgrund-content'));
            }
			_popup.show().addClass('avgrund-popup-animate');
			_popup.addClass('no-transition');

			setTimeout( function() {
				_popup.removeClass('no-transition');
				_container.addClass('avgrund-active');
			}, 0 );

		}

		function onDocumentClick(event){
			if($(event.target).hasClass('avgrund-cover')){
				deactivate();
			}
		}

		function onDocumentKeyUp(event){
			if( event.keyCode === 27 ) {
				deactivate();
			}
		}

		function deactivate(event) {
			$(document).off('click touchstart', onDocumentClick);
			$(document).off('keyup', onDocumentKeyUp);
			_container.removeClass('avgrund-active');
			_popup.removeClass('avgrund-popup-animate');
            _popup.find('.avgrund-content').contents().detach();
			return false;
		}


        return this;
    };
})(jQuery);


jQuery(document).ready(function($) {
	$('.avgrund-container').each(function(index) {
		$(this).vcModal();
	});
});
