var stopButton = document.getElementById('video-close-button-id');

stopButton.onclick = function() {
  var myPlayer = document.getElementById("youtube-player-id"); 
  myPlayer.setAttribute("src", "https://www.youtube.com/embed/AGM3osVKn24?autoplay=0&enablejsapi=1");
};

var stopButton1 = document.getElementById('video-close-button-id1');

stopButton1.onclick = function() {
  var myPlayer1 = document.getElementById("youtube-player-id1"); 
  myPlayer1.setAttribute("src", "https://www.youtube.com/embed/WH-0bZeeHsY?autoplay=0&enablejsapi=1");
};

var stopButton2 = document.getElementById('video-close-button-id2');

stopButton2.onclick = function() {
  var myPlayer2 = document.getElementById("youtube-player-id2"); 
  myPlayer2.setAttribute("src", "https://www.youtube.com/embed/K1JZVosWgQo?autoplay=0&enablejsapi=1");
};