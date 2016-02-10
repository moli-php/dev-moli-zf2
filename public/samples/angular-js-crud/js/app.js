var app = angular.module('callingcardApp', ['ngRoute','ngResource','ngAnimate']);

app.config(function ($routeProvider) {
    $routeProvider
    .when('/customers',
    {
        controller : 'custController',
        templateUrl : 'angular-js-crud-template'
    })
    .when('/orders',
    {
        controller : 'orderController',
        templateUrl : 'angular-js-crud-template/orders'
    })
    .when('/profile/:id',
    {
        controller : 'profileController',
        templateUrl : 'angular-js-crud-template/profile'
    })
    .when('/products',
    {
        controller : 'productController',
        templateUrl : 'angular-js-crud-template/products'
    })
    .when('/:action/:page/:id?',
    {
        controller : 'actionController',
        templateUrl : 'angular-js-crud-template/action'
    })
    .otherwise({
        redirectTo: '/customers'
    });	
});