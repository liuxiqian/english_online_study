getNextWord:function (wordId,type) {
        var deferred = $q.defer();
        var promise = deferred.promise;

        $http.get('{:U("Study/nextNewWordAjax")}')
           .success(function(data,status){
                console.log(data);
                if (data.status === "SUCCESS") {
                    nextWord = data.data;
                    deferred.resolve(data.data);
                }
                else{
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