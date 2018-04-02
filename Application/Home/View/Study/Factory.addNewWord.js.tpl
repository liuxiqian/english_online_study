<script type="text/javascript">
var addNewWord = function(wordId, $http, callback = undefined) {
    $http.get('{:U("Vocabulary/addToNewWordAjax")}', {
            params: {
                id: wordId
            }
        })
        .success(function(response) {
            if (response.status == 'SUCCESS') {
                if (typeof(callback) === 'function')
                {
                    callback();
                }
            } else {
                alert(response.data);
            }
        })
        .error(function(response) {
            alert("系统或网络错误");
            console.log(response);
        });
};
</script>
