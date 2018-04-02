<script type="text/javascript">
var speak = function(Word, type = 'uk'){    // 发音
    var src = Word.audioUkUrl;
    if (type == 'us')
    {
        var src = Word.audioUsUrl;
    }
    
    if (window.HTMLAudioElement) {
        try {
            var Audio = document.getElementById('audio');
            Audio.src = src;
            Audio.play();
        } catch (e) {
            if (window.console && console.error("Error:" + e));
        }
    }
}
</script>
