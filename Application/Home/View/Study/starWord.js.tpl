<script type="text/javascript">
var app = angular.module('yunzhi', ['ui.bootstrap', 'ionic', 'ngAnimate', 'ngCookies']);

app.controller("starWordController", function($scope, $timeout, $uibModal, $log, $http, $location, $stateParams, Word) {
    $scope.word = {:json_encode($Word->getJsonData())};
    

    // 取下一单词
    $scope.nextWord = function()
    {
        $scope.word = Word.getNextWord($scope.word.id);
    };

    // 取上一单词
    $scope.preWord = function()
    {
        $scope.word = Word.getPreWord($scope.word.id);
    };

    //获取单词读音
    $scope.speak = function(){
        speak($scope.word);
    };


    $scope.firstWord = Word.getFirstWord(); // 取首单词
    $scope.lastWord = Word.getLastWord();   // 尾单词
    $scope.isFirst =  false;                // 是否首单词
    $scope.isLast = false;                  // 是否尾单词

    // 对当前单词的变化进行监控，判断是否是首或尾单词，如果是，对应隐藏相应按钮
    $scope.$watch('word',function(){
        if ($scope.firstWord.id == $scope.word.id)
        {
            $scope.isFirst = true;
        }
        else
        {
            $scope.isFirst = false;
        }

        if ($scope.lastWord.id == $scope.word.id)
        {
            $scope.isLast = true;
        }
        else
        {
            $scope.isLast = false;
        }
    });
});

// 重写WordFactory
app.factory("Word", function($http){
    var allWords = [<?php foreach($Word->getCourse()->getAllStarWords() as $word)
            echo json_encode($word->getJsonData()) . ',';?>];
    var word = {:json_encode($Word->getJsonData())};
    var getWord = function()
    {
        return word;
    }

    var getWordById = function (id)
    {
        angular.forEach(allWords, function(value,key){
            if (id == value.id)
            {
                return value;
            }
        });
    };

    // 获取第一个单词
    var getFirstWord = function()
    {
        if (allWords.length > 0)
        {
            return allWords[0];
        }
        else
        {
            return {};
        }
    }
    var addMyNewWord = function(wordId, callback)
    {
        addNewWord(wordId, $http, callback);
    };


    // 获取最后一个单词
    var getLastWord = function()
    {
        if (allWords.length > 0)
        {
            return allWords[allWords.length - 1]
        }
        else
        {
            return {};
        }
    }

    // 获取下一个单词.注意在forEach中，无法使用break使其中断循环.
    // 相关资料参考：http://stackoverflow.com/questions/6260756/how-to-stop-javascript-foreach
    var getNextWord = function(id){
        var i = 0;
        allWords.forEach(function(element, index){
            if (i === 1)
            {
                word = element;
                i = 0;
            }

            if (id == element.id)
            {
                i = 1;
            }
        });
        return word;
    };

    // 获取上一下单词
    var getPreWord = function(id){
        var i = 0;
        angular.forEach(allWords, function(value,key){
            if (id == value.id)
            {
                i = 1;
            }

            if ( i === 0)
            {
                word = value;
            }
        });
        return word;
    };

    return {
        allWords: allWords,
        getWordById: getWordById,
        getNextWord: getNextWord,
        getPreWord: getPreWord,
        getFirstWord: getFirstWord,
        getLastWord: getLastWord,
        getWord: getWord,
        addNewWord:addMyNewWord,
    };
});
</script>
