jQuery(document).ready(function($) {
    "use strict";
    $('.cq-userprofile').each(function(index) {
        var _this = $(this);
        var _autoslide = parseInt(_this.data('autoslide'), 10);

        $('.cq-userprofile-btn', _this).on('click', function(event) {
          $(this).toggleClass('active');
          return $('.cq-userprofile-iconcontainer', _this).toggleClass('open');

        });
        var _autoslideID = 0;
        function _autoToggle(){
            if(_autoslide>0){
                _autoslideID = setTimeout(function(){
                    clearTimeout(_autoslideID);
                    $('.cq-userprofile-btn', _this).trigger('click');
                    _autoToggle();
                }, _autoslide*1000);
            }
        }
        if(_autoslide>0) _autoToggle();

        _this.on('mouseover', function(event) {
            clearTimeout(_autoslideID);
            event.preventDefault();
        }).on('mouseleave', function(event) {
            event.preventDefault();
            if(_autoslide>0) _autoToggle();
        });


        $('.cq-userprofile-buttonlink', _this).each(function(index) {
        	var _title = $(this).data('icontooltip');
        	if(_title!=""){
        		$(this).tooltipster({
		          content: _title,
		          position: 'top',
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

        $('.cq-userprofile-avatar', _this).each(function(index) {
            var _title = $('.cq-userprofile-avatarlink', $(this)).data('avatartooltip');
            if(_title!=""){
                $(this).tooltipster({
                  content: _title,
                  position: 'top',
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



        var _avatar = $('.cq-userprofile-avatar', _this)[0];

        if(_avatar == undefined || _avatar == null){
        	$('.cq-userprofile-content', _this).css({
        		'padding-left': '16px',
        		'width': '100%'
        	});
        }

    });

});
