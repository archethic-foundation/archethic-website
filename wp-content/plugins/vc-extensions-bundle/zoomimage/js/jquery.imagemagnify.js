(function ($, window, document) {
  'use strict';
  var defaults = {
    radius: 100,
    borderSize: 12,
    moveBy: 'press',
    dropinAnimation: false,
    x: 0,
    y: 0
  };

  var CQ_Magnify = function (element, options) {
    this.element = element;
    this.options = $.extend(defaults, options);
    this.init();
  };

  CQ_Magnify.prototype.init = function () {
    var self = this,
      imageURL = this.element.data('largeimage'),
      isPressed = false,
      moveBy = (this.element.data('moveby') || self.options.moveBy).toLowerCase(),
      borderSize = this.element.data('bordersize') || self.options.borderSize,
      radius = this.element.data('radius') || self.options.radius,
      dropinAnimation = this.element.data('dropinanimation') || self.options.dropinAnimation,
      updateRatioID = undefined;
    if(!imageURL) {
      imageURL = this.element[0].src;
    }

    this.container = $('<div>').addClass('cq-magnify').insertAfter(this.element);
    this.element.detach().appendTo(this.container);
    this.glassElement = $('<div>').addClass('cq-magnify-glass').css({
      'background-image': 'url(' + imageURL + ')',
      'width': radius * 2,
      'height': radius * 2
    }).appendTo(this.container);

    this.largeImage        = new Image();
    this.largeImage.src    = imageURL;

    $(this.largeImage).on('load', function () {
      self.ratioX = self.container.innerWidth() / self.largeImage.width;
      self.ratioY = self.container.innerHeight() / self.largeImage.height;
      if(moveBy=="press"||moveBy=="none"){
        var x        = self.element.data('x') || self.options.x,
            y        = self.element.data('y') || self.options.y,
            glassX  = x - radius - borderSize,
            glassY  = y - radius - borderSize,
            imageX   = (((x - self.container.innerWidth()) / self.ratioX) * -1) - self.largeImage.width + radius,
            imageY   = (((y - self.container.innerHeight()) / self.ratioY) * -1) - self.largeImage.height + radius;
            self.glassElement.css({
              'top':  glassY,
              'left': glassX,
              'background-position': imageX + 'px ' + imageY + 'px'
            }).show().addClass('cq-dropin0 cq-dropInDown');

      }


      // hide the magnifier glass in small device
      // &&(x>0||y>0)
      if($(window).width()<=320) self.glassElement.hide();

      self.container.on('touchstart', function (event) {
        self.glassElement.show();
      });

      self.container.on('touchmove', function (event) {
        var touch = event.originalEvent.touches[0] || event.originalEvent.changedTouches[0];
        var offset = self.container.offset(),
            x        = touch.pageX - offset.left,
            y        = touch.pageY - offset.top,
            glassX  = x - radius - borderSize,
            glassY  = y - radius - borderSize,
            imageX   = (((x - self.container.innerWidth()) / self.ratioX) * -1) - self.largeImage.width + radius,
            imageY   = (((y - self.container.innerHeight()) / self.ratioY) * -1) - self.largeImage.height + radius;

        self.glassElement.css({
          'top':  glassY,
          'left': glassX,
          'background-position': imageX + 'px ' + imageY + 'px'
        });
        if (touch.pageX < offset.left || touch.pageY < offset.top || x > self.container.innerWidth() || y > self.container.innerHeight()) {
          self.glassElement.hide();
        }
        return false;
      });

      self.container.on('touchend', function (event) {
          return false;
      })


      self.container.on('mouseenter', function () {
        if(moveBy!="none") self.glassElement.show().addClass('drag');
      });

      self.container.on('mousedown', function () {
        isPressed = true;
        if(moveBy!="none") self.glassElement.removeClass('drag').addClass('dragging');
      });

      self.container.on('mouseup', function () {
        isPressed = false;
        if(moveBy!="none") self.glassElement.removeClass('dragging').addClass('drag');
      });

      self.container.on('mousemove', function (e) {
        var offset = self.container.offset(),
          x        = e.pageX - offset.left,
          y        = e.pageY - offset.top,
          glassX  = x - radius - borderSize,
          glassY  = y - radius - borderSize,
          imageX   = (((x - self.container.innerWidth()) / self.ratioX) * -1) - self.largeImage.width + radius,
          imageY   = (((y - self.container.innerHeight()) / self.ratioY) * -1) - self.largeImage.height + radius;
        if(moveBy=="press"){
          if(isPressed){
            self.glassElement.css({
              'background-image': 'url(' + imageURL + ')',
              'top':  glassY,
              'left': glassX,
              'background-position': imageX + 'px ' + imageY + 'px'
            });
          }

        }else if(moveBy=="hover"){
          self.glassElement.css({
            'background-image': 'url(' + imageURL + ')',
            'top':  glassY,
            'left': glassX,
            'background-position': imageX + 'px ' + imageY + 'px'
          }).addClass('hidecursor');

        }

        if (e.pageX < offset.left || e.pageY < offset.top || x > self.container.innerWidth() || y > self.container.innerHeight()) {
          self.glassElement.hide();
          // self.glassElement.animate({
          //   opacity: 0},
          //   300, function() {
          //   $(this).hide();
          // });

        }
      });

      $(window).on('resize', function () {
        if (typeof updateRatioID === "undefined") {
          updateRatioID = setTimeout(function () {
            self.ratioX = self.container.innerWidth() / self.largeImage.width;
            self.ratioY = self.container.innerHeight() / self.largeImage.height;
            updateRatioID = undefined;
          }, 200);
        }
      });
      $(window).trigger('resize');

    });
  };

  $.fn.cq_magnify = function (options) {
    return this.each(function () {
      if (!$.data(this, 'cq-magnify')) {
        $.data(this, 'cq-magnify', new CQ_Magnify($(this), options));
      }
    });
  };
}(jQuery, window, document));

