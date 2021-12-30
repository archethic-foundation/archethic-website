var stopButton = document.getElementById('video-close-button-id');

stopButton.onclick = function() {
  var myPlayer = document.getElementById("youtube-player-id"); 
  myPlayer.setAttribute("src", " ");
};

var stopButton1 = document.getElementById('video-close-button-id1');

stopButton1.onclick = function() {
  var myPlayer1 = document.getElementById("youtube-player-id1"); 
  myPlayer1.setAttribute("src", " ");
};

var stopButton2 = document.getElementById('video-close-button-id2');

stopButton2.onclick = function() {
  var myPlayer2 = document.getElementById("youtube-player-id2"); 
  myPlayer2.setAttribute("src", " ");
};