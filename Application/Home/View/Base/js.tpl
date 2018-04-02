<script type="text/javascript">
    // Create a couple of global variables to use. 
    
    var ratedisplay = document.getElementById("rate"); // Rate display area

    //  Alternates between play and pause based on the value of the paused property
    function togglePlay(audio, src) {
        var audioElm = document.getElementById(audio); // Audio element

       if (audioElm.paused == true) {
         playAudio(audio, src);    //  if player is paused, then play the file
       } else {
         pauseAudio(audio, src);   //  if player is playing, then pause
       }
     }

    function playAudio(audio, src) {
        var audioElm = document.getElementById(audio); // Audio element
         document.getElementById("playbutton").innerHTML = "Pause"; // Set button text == Pause
         // Get file from text box and assign it to the source of the audio element 
         audioElm.src = src;
         audioElm.play();
    }

    function pauseAudio(audio) {
        var audioElm = document.getElementById(audio); // Audio element
         document.getElementById("playbutton").innerHTML = "play"; // Set button text == Play
         audioElm.pause();
    }



</script>
    