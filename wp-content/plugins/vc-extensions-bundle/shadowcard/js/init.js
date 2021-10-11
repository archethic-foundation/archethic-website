jQuery(document).ready(function($) {
  "use strict";
  $(".cq-shadowcard").each(function(index) {
        var _card = $( '.cq-shadowcard-item', $(this) );
        var _tolerance = parseInt($(this).data('tolerance'), 10);
        var _elementheight = parseInt($(this).data('elementheight'), 10);
        var _titlesize = $(this).data('titlesize');
        var _titlecolor = $(this).data('titlecolor');

        if(_titlesize!=""){
            $('.cq-shadowcard-title', $(this)).css('font-size', _titlesize);
        }
        if(_titlecolor!=""){
            $('.cq-shadowcard-title', $(this)).css('color', _titlecolor);
        }
        if(_elementheight!=""){
            _card.css('height', _elementheight + 'px');
        }

        _card.on( 'mousemove', function( e ) {
          var $this   = $( this ),
            eX      = e.offsetX,
            eY      = e.offsetY,
            dim     = this.getBoundingClientRect();
            w     = dim.width/2,
            h     = dim.height/2,
            posX    = ( h - eY ) * ( _tolerance / h );
            posY    = ( w - eX ) * ( _tolerance / w ) * -1;

          $this.find( '.cq-shadowcard-link' ).css({
            'transform': 'rotateX( ' + posX + 'deg ) rotateY( ' + posY + 'deg )',
            'box-shadow': ( posY * -1 ) + 'px ' + ( posX + 14 ) + 'px 34px 0 rgba( 0, 0, 0, 0.1 )'
          });
          $this.find( '.highlight' ).css({
            'opacity': 1,
            'transform': 'translate3d( ' + ( posX * -4 ) + 'px, ' + ( posY * -4 ) + 'px, '  + '0 )'
          });
        });


        _card.on('mouseleave', function(event) {
          var $el = $( this ).find( '.cq-shadowcard-link' );
          $el.removeAttr( 'style' ).addClass( 'cq-shadowcard-ending' );
          setTimeout( function() {
            $el.removeClass( 'cq-shadowcard-ending' );
          }, 500 );

        });

  })

});
