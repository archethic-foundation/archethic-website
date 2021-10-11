function drags(dragElement, resizeElement, container) {
    var _autoslide = container.data('autoslide');
    var _iconcolor = container.data('iconcolor');
    var _handlestyle = container.data('handlestyle');
    var _handlecolor = container.data('handlecolor');
    var _captioncolor = container.data('captioncolor');
    var _captionbg = container.data('captionbg');
    var _captionminwidth = parseInt(container.data('captionminwidth'), 10);
    var _width = container.width();
    var _icon = dragElement.find('i');
    var _tooltipTitle = _icon.attr('title');
    var _tooltip;
    var _slideID = 0;


    if(_captioncolor!=""){
      jQuery(".cq-beforeafter-caption", container).css('color', _captioncolor);
    }
    if(_captionbg!=""){
      jQuery(".cq-beforeafter-caption", container).css('background-color', _captionbg);
    }
    if(_captionminwidth>0){
      jQuery(".cq-beforeafter-caption", container).css('min-width', _captionminwidth);
    }

    if(_iconcolor!="") _icon.css('color', _iconcolor);
    if(_handlestyle=="customized"&&_handlecolor!=""){
        dragElement.find('i').css({
          "background-color": _handlecolor,
          "border": '1px solid ' + _handlecolor,
          "box-shadow": "none"
        });
    }
    if(_tooltipTitle!=""){
      _tooltip = dragElement.find('i').tooltipster({
        content: _tooltipTitle,
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
      _tooltip.tooltipster('show');
    }


    function _slideshow(){
        clearTimeout(_slideID);
        _slideID = setTimeout(_autoslideHandle, _autoslide*1000);
    }
    function _autoslideHandle() {
        if(dragElement.position().left>0){
            dragElement.animate({
              'left': 0},{
                duration: 800,
                step: function(now){
                    resizeElement.css('width', now);
                    if(_tooltip){
                      _tooltip.tooltipster('reposition');
                      _tooltip.tooltipster('show');
                    }
                },
                complete: function(){
                    _slideshow();
                }
              });
        }else{
            dragElement.animate({
              'left': _width},
              {
                duration: 800,
                step: function(now){
                    resizeElement.css('width', now);
                    if(_tooltip){
                      _tooltip.tooltipster('reposition');
                      _tooltip.tooltipster('show');
                    }
                },
                complete: function(){
                    _slideshow();
                }
              });
        }

    }

    if(_autoslide>0){
        _slideshow();
    }

  var _leaveID = 0;
  container.on('mouseover vmouseover', function(event) {
    if(_tooltip){
        _tooltip.tooltipster('hide');
      }
      if(_autoslide>0){
          clearTimeout(_slideID);
      }
    }).on('mouseleave vmouseout', function(event) {
      if(_autoslide>0){
          _slideshow();
      }
    if(_tooltip){
      clearTimeout(_leaveID);
      _leaveID = setTimeout(function() {
        _tooltip.tooltipster('reposition');
        _tooltip.tooltipster('show');
      }, 800);
    }
  });



  // Initialize the dragging event on mousedown.
  dragElement.on('mousedown vmousedown', function(e) {
    dragElement.addClass('cq-compareslider-draggable');
    resizeElement.addClass('cq-compareslider-resizable');
    // Get the initial position
    var dragWidth = dragElement.outerWidth(),
        posX = dragElement.offset().left + dragWidth - e.pageX,
        containerOffset = container.offset().left,
        containerWidth = container.outerWidth();

    // Set limits
    minLeft = containerOffset;
    maxLeft = containerOffset + containerWidth - dragWidth;

    // Calculate the dragging distance on mousemove.
    dragElement.parents().on("mousemove vmousemove", function(e) {
      leftValue = e.pageX + posX - dragWidth;
      // Prevent going off limits
      if ( leftValue < minLeft) {
        leftValue = minLeft;
      } else if (leftValue > maxLeft) {
        leftValue = maxLeft;
      }

      // Translate the handle's left value to masked divs width.
      widthValue = (leftValue + dragWidth/2 - containerOffset)*100/containerWidth+'%';

      // Set the new values for the slider and the handle.
      // Bind mouseup events to stop dragging.
      jQuery('.cq-compareslider-draggable').css('left', widthValue).on('mouseup vmouseup', function () {
        jQuery(this).removeClass('cq-compareslider-draggable');
        resizeElement.removeClass('cq-compareslider-resizable');
      });
      jQuery('.cq-compareslider-resizable').css('width', widthValue);
    }).on('mouseup vmouseup', function(){
      dragElement.removeClass('cq-compareslider-draggable');
      resizeElement.removeClass('cq-compareslider-resizable');
    });
    e.preventDefault();
  }).on('mouseup vmouseup', function(e){
    dragElement.removeClass('cq-compareslider-draggable');
    resizeElement.removeClass('cq-compareslider-resizable');
  });
}

// Call & init
jQuery(document).ready(function($){
  "use strict";
  jQuery('.cq-beforeafter').each(function(){
    var cur = jQuery(this);
    // Adjust the slider
    var width = cur.width();
    cur.find('.cq-beforeafter-resize img.cq-beforeafter-img').css({
      'min-width': width,
      'width': width,
      'opacity': 1
    });

    var _handle = cur.find('.cq-beforeafter-handle');
    var _resize = cur.find('.cq-beforeafter-resize');
    // Bind dragging events
    drags(_handle, _resize, cur);

  });
});

// Update sliders on resize.
jQuery(window).resize(function($){
  jQuery('.cq-beforeafter').each(function(){
    var cur = jQuery(this);
    var width = cur.width();
    cur.find('.cq-beforeafter-resize img.cq-beforeafter-img').css({
      'min-width': width,
      'width': width
    });
  });
});

