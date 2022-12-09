 // Set the date we're counting down to
 var countDownDate = new Date("Dec 10, 2022 14:00:00").getTime();

 // Update the count down every 1 second
 var x = setInterval(function() {
 
   // Get today's date and time
   var now = new Date().getTime();
     
   // Find the distance between now and the count down date
   var distance = countDownDate - now;
     
   // Time calculations for days, hours, minutes and seconds
   var days = Math.floor(distance / (1000 * 60 * 60 * 24));
   var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
   var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
   var seconds = Math.floor((distance % (1000 * 60)) / 1000);
     
   // Output the result in an element with id="demo"
   document.getElementById("text").innerHTML = `Archethic Public Blockchain starts in`;
   
   document.getElementById("demo").innerHTML = days + " day " + hours + " hours "
   + minutes + " min " + seconds + " sec UTC";
     
   // If the count down is over, write some text 
   if (distance < 0) {
     clearInterval(x);
     document.getElementById("text").innerHTML = `Archethic Public Blockchain is Live`;
     document.getElementById("demo").innerHTML = `<a href="aewallet.html" target="_blank">
     <div class="sc_button color_style_default sc_button_bordered sc_button_size_small sc_button_icon_left button_transparent"
         style="margin-left:10px;margin-top:10px;">Install App</div>
     </a>
     <a href="https://mainnet.archethic.net/explorer" target="_blank">
     <div class="sc_button color_style_default sc_button_bordered sc_button_size_small sc_button_icon_left button_transparent"
         style="margin-left:10px;margin-top:10px;">Explorer</div>
     </a>`;
   }
 }, 1000);  