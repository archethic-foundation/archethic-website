jQuery(document).ready(function($) {
  "use strict";
  $('.cq-ihover').each(function(index) {
  	var _this = $(this);
  	var _effect = _this.data('effect');
  	var _shape = _this.data('shape');
    var _bgcolor = _this.data('bgcolor');
    var _bgstyle = _this.data('bgstyle');
    var _titlecolor = _this.data('titlecolor');
    var _titlesize = _this.data('titlesize');
    var _desccolor = _this.data('desccolor');
    var _descsize = _this.data('descsize');
    var _iconcolor = _this.data('iconcolor');
    var _iconsize = _this.data('iconsize');
    var _containerwidth = _this.data('containerwidth');
    var _captionmargintop = _this.data('captionmargintop');
    var _videowidth = $(this).data('videowidth') == "" ? 800 : parseInt($(this).data('videowidth'));

    if(_containerwidth!=""){
        $(this).css({
          'width': _containerwidth,
          'margin': '0 auto'
        });
    }

  	$(this).find('.cq-ihover-container').each(function() {
      if(_captionmargintop!=""){
          $('.cq-ihover-text', $(this)).css('margin-top', _captionmargintop);
      }
      if(_titlesize!=""){
          $('.cq-ihover-title', $(this)).css('font-size', _titlesize);
      }
      if(_titlecolor!=""){
          $('.cq-ihover-title', $(this)).css({
            'color': _titlecolor,
            'border-bottom-color': _titlecolor
          });;
      }

      if(_descsize!=""){
          $('.cq-ihover-desc', $(this)).css('font-size', _descsize);
      }
      if(_desccolor!=""){
          $('.cq-ihover-desc', $(this)).css('color', _desccolor);
      }

      if(_iconsize!=""){
          $('i.cq-ihover-icon', $(this)).css({
            'font-size': _iconsize
          });
      }
      if(_iconcolor!=""){
          $('i.cq-ihover-icon', $(this)).css('color', _iconcolor);
      }



      if(_bgcolor!=""&&_bgstyle=="customized"){
          $('.cq-ihover-info, .mask1, .mask2, .cq-ihover-infoback', $(this)).css('background', _bgcolor);
      }

      if((_effect=="effect5"&&_shape=="circle")||(_effect=="effect20"&&_shape=="circle")||(_effect=="effect4"&&_shape=="square")){
          $('.cq-ihover-info', $(this)).css('background', 'none');
      }


      $("a.cq-ihover-lightbox", $(this)).each(function() {
        var _lightboxURL = $(this).attr('href');
        if(_lightboxURL.indexOf('youtube')>-1||_lightboxURL.indexOf('vimeo')>-1){
            $(this).lightbox({
                "viewportFill": 1,
                "fixed": true,
                "margin": 10,
                "videoWidth": _videowidth,
                "retina": true,
                "minWidth": 320
            });
        }else{
            $(this).boxer({
                fixed : true
            });
        }


      });





  		$(this).find('a.ihover-nothing').on('click', function(event) {
  			event.preventDefault();
  		});

  	});
  })
});
