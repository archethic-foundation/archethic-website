// Function to reveal lightbox and adding YouTube autoplay
function revealVideo(div,video_id) {
    var video = document.getElementById(video_id).src;
    document.getElementById(video_id).src = video; 
    // adding autoplay to the URL
    document.getElementById(div).style.display = 'block';
  }
  
  // Hiding the lightbox and removing YouTube autoplay
  function hideVideo(div,video_id) {
    var video = document.getElementById(video_id).src;
    var cleaned = video.replace('&autoplay=1',''); 
    document.getElementById(video_id).src = cleaned;
    document.getElementById(div).style.display = 'none';
  }