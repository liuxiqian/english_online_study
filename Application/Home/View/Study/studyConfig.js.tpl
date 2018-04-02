<script type="text/javascript">
app.config(function($stateProvider, $urlRouterProvider, $httpProvider) {
    $stateProvider
        .state('half', {
            url: "/half",
            templateUrl: "studyHalf.html"
        })
        .state('half.index', {
            url: "/index",
            cache:"false",
            templateUrl: "studyHalfIndex.html"
        })
        .state('half.review', {
            url: "/review",
            cache:"false",
            templateUrl: "studyHalfReview.html"
        })
        .state('half.identify', {
            url: "/identify/:type",
            templateUrl: "studyHalfIdentify.html"
        })
        .state('studyWordDetail', {
            url: "/studyWordDetail/:type",
            templateUrl: "studyWordDetail.html"
        });
    $urlRouterProvider.otherwise("/half/index");

})
</script>
