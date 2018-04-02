getNextWord:function (wordId, nextWordId, type) {
        var deferred = $q.defer();
        var promise = deferred.promise;

        $http.get('{:U("Study/nextWordAjax")}',{params:{wordId:wordId, nextWordId:nextWordId, type:type}})
           .success(function(data,status){
                console.log(data);
                if (data.status === "SUCCESS") {
                    nextWord = data.data;
                    deferred.resolve(data.data);
                }
                else{
                    console.log(data.data);
                    alert('data error');
                }
            })
           .error(function(data,status){
                deferred.reject();
                alert('not find this function');
           });
           console.log('return promise');
            return promise;
        }