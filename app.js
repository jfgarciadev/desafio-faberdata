var app = angular.module('myApp', ['ngRoute']);
app.config(function ($routeProvider, $locationProvider) {
    $routeProvider

        .when('/login', {
            templateUrl: 'pages/login.html',
            controller: 'loginController'
        })
        .when('/register', {
            templateUrl: 'pages/register.html',
            controller: 'loginController'
        })
        .when('/home', {
            templateUrl: 'pages/home.html',
            controller: 'homeController'
        })

    $routeProvider.when('/home/:idgroup', {
        templateUrl: 'pages/home.html',
        controller: 'homeController'
    })
    $routeProvider.otherwise({
        redirectTo: '/login'
    });
    //$routeProvider.otherwise({ redirectTo: '/' });
    $locationProvider.hashPrefix('');
    $locationProvider.html5Mode(true);

});
app.controller('myController', function ($scope, $http) {
    $scope.message = "AngularJS";
});
