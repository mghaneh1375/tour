
(function () {
    var app = angular.module("mainApp", ['infinite-scroll'], function ($interpolateProvider) {
        $interpolateProvider.startSymbol('[[');
        $interpolateProvider.endSymbol(']]')
    });

    app.config(['$qProvider', function ($qProvider) {
        $qProvider.errorOnUnhandledRejections(!1)
    }]);

    app.controller('RecentlyController', function ($scope, $http) {
        $scope.show = !1;
        $scope.disable = !1;
        $scope.firstTime = true;

        $scope.myPagingFunction = function () {
            if ($scope.disable)
                return;
            var top = $("#RecentlyControllerId").position().top;
            var scroll = $(window).scrollTop() + window.innerHeight;

            if($scope.firstTime) {
                $scope.firstTime = false;
                if(top > scroll)
                    return;
            }
            else {
                if (scroll < top || (scroll - top) / window.innerHeight < 0.4)
                    return;
            }
            $scope.disable = !0;
            $http.post(getLastRecentlyMainPath, {}).then(function (response) {
                if (response.data != null && response.data.length > 0)
                    $scope.show = !0;
                for (i = 0; i < response.data.length; i++) {
                    response.data[i].classRate = (response.data[i].rate == 0) ? 'ui_bubble_rating bubble_00' : (response.data[i].rate == 1) ? 'ui_bubble_rating bubble_10' : (response.data[i].rate == 2) ? 'ui_bubble_rating bubble_20' : (response.data[i].rate == 3) ? 'ui_bubble_rating bubble_30' : (response.data[i].rate == 4) ? 'ui_bubble_rating bubble_40' : 'ui_bubble_rating bubble_50'
                }
                $scope.data = response.data
            }).catch(function (err) {
                console.log(err)
            })
        }
    });

    app.controller('AdviceController', function ($scope, $http) {
        $scope.show = !1;
        $scope.disable = !1;
        $scope.myPagingFunction = function () {

            if ($scope.disable)
                return;

            var top = $("#AdviceControllerId").position().top;
            var scroll = $(window).scrollTop() + window.innerHeight;

            if (scroll < top || (scroll - top) / window.innerHeight < 0.6)
                return;

            $('.loader').removeClass('hidden');

            $scope.disable = !0;
            $http.post(getAdviceMainPath, data, config).then(function (response) {

                if (response.data != null && response.data.length > 0)
                    $scope.show = !0;
                for (i = 0; i < response.data.length; i++) {
                    response.data[i].classRate = (response.data[i].rate == 0) ? 'ui_bubble_rating bubble_00' : (response.data[i].rate == 1) ? 'ui_bubble_rating bubble_10' : (response.data[i].rate == 2) ? 'ui_bubble_rating bubble_20' : (response.data[i].rate == 3) ? 'ui_bubble_rating bubble_30' : (response.data[i].rate == 4) ? 'ui_bubble_rating bubble_40' : 'ui_bubble_rating bubble_50'
                }
                $scope.data = response.data;

                $('.loader').addClass('hidden');
            }).catch(function (err) {
                console.log(err)
            })
        }
    });

    app.controller('HotelController', function ($scope, $http) {
        $scope.show = !1;
        $scope.disable = !1;
        $scope.firstTime = true;

        $scope.myPagingFunction = function () {
            if ($scope.disable)
                return;
            var top = $("#HotelControllerId").position().top;
            var scroll = $(window).scrollTop() + window.innerHeight;

            if($scope.firstTime) {
                $scope.firstTime = false;
                if(top > scroll)
                    return;
            }
            else {
                if (scroll < top || (scroll - top) / window.innerHeight < 0.6)
                    return;
            }

            $scope.disable = !0;
            $http.post(getHotelsMainPath, data, config).then(function (response) {
                if (response.data != null && response.data.length > 0)
                    $scope.show = !0;
                for (i = 0; i < response.data.length; i++) {
                    response.data[i].classRate = (response.data[i].rate == 0) ? 'ui_bubble_rating bubble_00' : (response.data[i].rate == 1) ? 'ui_bubble_rating bubble_10' : (response.data[i].rate == 2) ? 'ui_bubble_rating bubble_20' : (response.data[i].rate == 3) ? 'ui_bubble_rating bubble_30' : (response.data[i].rate == 4) ? 'ui_bubble_rating bubble_40' : 'ui_bubble_rating bubble_50'
                }
                $scope.data = response.data
            }).catch(function (err) {
                console.log(err)
            })
        }
    });

    app.controller('AmakenController', function ($scope, $http) {
        $scope.show = !1;
        $scope.disable = !1;
        $scope.firstTime = true;

        $scope.myPagingFunction = function () {
            if ($scope.disable)
                return;
            var top = $("#AmakenControllerId").position().top;
            var scroll = $(window).scrollTop() + window.innerHeight;

            if($scope.firstTime) {
                $scope.firstTime = false;
                if(top > scroll)
                    return;
            }
            else {
                if (scroll < top || (scroll - top) / window.innerHeight < 0.6)
                    return;
            }
            $scope.disable = !0;
            $http.post(getAmakensMainPath, data, config).then(function (response) {

                if (response.data != null && response.data.length > 0)
                    $scope.show = !0;
                for (i = 0; i < response.data.length; i++) {
                    response.data[i].classRate = (response.data[i].rate == 0) ? 'ui_bubble_rating bubble_00' : (response.data[i].rate == 1) ? 'ui_bubble_rating bubble_10' : (response.data[i].rate == 2) ? 'ui_bubble_rating bubble_20' : (response.data[i].rate == 3) ? 'ui_bubble_rating bubble_30' : (response.data[i].rate == 4) ? 'ui_bubble_rating bubble_40' : 'ui_bubble_rating bubble_50'
                }
                $scope.data = response.data
            }).catch(function (err) {
                console.log(err)
            })
        }
    });

    app.controller('RestaurantController', function ($scope, $http) {
        $scope.show = !1;
        $scope.disable = !1;
        $scope.firstTime = true;

        $scope.myPagingFunction = function () {
            if ($scope.disable)
                return;
            var top = $("#RestaurantControllerId").position().top;
            var scroll = $(window).scrollTop() + window.innerHeight;
            if($scope.firstTime) {
                $scope.firstTime = false;
                if(top > scroll)
                    return;
            }
            else {
                if (scroll < top || (scroll - top) / window.innerHeight < 0.6)
                    return;
            }
            $scope.disable = !0;
            $http.post(getRestaurantsMainPath, data, config).then(function (response) {
                if (response.data != null && response.data.length > 0)
                    $scope.show = !0;
                for (i = 0; i < response.data.length; i++) {
                    response.data[i].classRate = (response.data[i].rate == 0) ? 'ui_bubble_rating bubble_00' : (response.data[i].rate == 1) ? 'ui_bubble_rating bubble_10' : (response.data[i].rate == 2) ? 'ui_bubble_rating bubble_20' : (response.data[i].rate == 3) ? 'ui_bubble_rating bubble_30' : (response.data[i].rate == 4) ? 'ui_bubble_rating bubble_40' : 'ui_bubble_rating bubble_50'
                }
                $scope.data = response.data
            }).catch(function (err) {
                console.log(err)
            })
        }
    });

    app.controller('FoodController', function ($scope, $http) {
        $scope.show = !1;
        $scope.disable = !1;
        $scope.myPagingFunction = function () {
            if ($scope.disable)
                return;
            var top = $("#FoodControllerId").position().top;
            var scroll = $(window).scrollTop() + window.innerHeight;

            if($scope.firstTime) {
                $scope.firstTime = false;
                if(top > scroll)
                    return;
            }
            else {
                if (scroll < top || (scroll - top) / window.innerHeight < 0.2)
                    return;
            }
            $scope.disable = !0;
            $http.post(getFoodsMainPath, data, config).then(function (response) {
                if (response.data != null && response.data.length > 0)
                    $scope.show = !0;
                for (i = 0; i < response.data.length; i++) {
                    response.data[i].classRate = (response.data[i].rate == 0) ? 'ui_bubble_rating bubble_00' : (response.data[i].rate == 1) ? 'ui_bubble_rating bubble_10' : (response.data[i].rate == 2) ? 'ui_bubble_rating bubble_20' : (response.data[i].rate == 3) ? 'ui_bubble_rating bubble_30' : (response.data[i].rate == 4) ? 'ui_bubble_rating bubble_40' : 'ui_bubble_rating bubble_50'
                }
                $scope.data = response.data
            }).catch(function (err) {
                console.log(err)
            })
        }
    });
})();