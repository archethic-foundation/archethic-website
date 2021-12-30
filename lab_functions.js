// Terms and Conditions Popup

$("#open-terms").on('click', () => {
    console.log("OPen Popup Clicked")
    $("#popup-root").removeClass("hidden");
  })
  
  $("#close-terms").on('click', () => {
    $("#popup-root").addClass("hidden");
  })

  const swiper = new Swiper('.swiper', {
    // Optional parameters
    direction: 'horizontal',
    loop: false,
    speed: 400,
    spaceBetween: 10,
    slidesPerView: 4,
    breakpoints: {
      // when window width is >= 320px
      450: {
        slidesPerView: 1,
        spaceBetween: 40
      },
      // when window width is >= 640px
      768: {
        slidesPerView: 2,
        spaceBetween: 40
      }, 
      960: {
        slidesPerView: 3,
        spaceBetween: 30
      },
      1280: {
        slidesPerView: 4,
        spaceBetween: 50
      }
      
    },
    // If we need pagination
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
  });

  // Video Popups

  $(document).ready(function(){
  
    $('.popup-btn-1').on('click', function(){
      $('.video-popup-1').fadeIn('slow');
      return false;
    });
    
    $('.popup-bg-1').on('click', function(){
      $('.video-popup-1').slideUp('slow');
      return false;
    });
    
     $('.close-btn-1').on('click', function(){
       $('.video-popup-1').fadeOut('slow');
        return false;
     });

     $('.popup-btn-2').on('click', function(){
      $('.video-popup-2').fadeIn('slow');
      return false;
    });
    
    $('.popup-bg-2').on('click', function(){
      $('.video-popup-2').slideUp('slow');
      return false;
    });
    
     $('.close-btn-2').on('click', function(){
       $('.video-popup-2').fadeOut('slow');
        return false;
     });

     $('.popup-btn-3').on('click', function(){
      $('.video-popup-3').fadeIn('slow');
      return false;
    });
    
    $('.popup-bg-3').on('click', function(){
      $('.video-popup-3').slideUp('slow');
      return false;
    });
    
     $('.close-btn-3').on('click', function(){
       $('.video-popup-3').fadeOut('slow');
        return false;
     });

     $('.popup-btn-4').on('click', function(){
      $('.video-popup-4').fadeIn('slow');
      return false;
    });
    
    $('.popup-bg-4').on('click', function(){
      $('.video-popup-4').slideUp('slow');
      return false;
    });
    
     $('.close-btn-4').on('click', function(){
       $('.video-popup-4').fadeOut('slow');
        return false;
     });
    
  });

  