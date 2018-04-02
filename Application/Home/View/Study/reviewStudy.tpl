getNextWord:function (wordId, nextWordId, type, callback = undefined) {
    // 向后台传入数据，直接记录返回值，不做任何的处理。
    $http.get('{:U("Study/setReviewWordAjax")}',
        {
            params:
            {
                wordId:wordId, 
                nextWordId:nextWordId, 
                type:type
            }
        })
        .success(function(data,status){
            console.log(data);
            if (data.status === "SUCCESS")
            {
                if (typeof(callback) === 'function')
                {
                    callback(data.data);
                }
            } else {
                console.log('error:' + data.message);
            }
            
        });
}