'use strict';
var base_url = '/develop/';
var api_url = base_url+'api/';
var views_url = base_url+'js/app/views/';

var controllers_url = base_url+'js/app/controllers/';
/* App Module */

var dspApp = angular.module('dspApp', ['ngAnimate','ngResource','ngSanitize','ngRoute', 'httpPostFix','bsTable']);

dspApp.config([
    '$routeProvider', '$locationProvider',
    function($routeProvide, $locationProvider){

        /*вклучаем урлы без #*/
        $locationProvider.html5Mode({
            enabled: true,
            requireBase: false
        });

        /*маршруты с контролеррами и view*/
        $routeProvide
            /*главная страница*/
            .when(base_url,{
                templateUrl:views_url + 'main/index.html',
                controller:'mainCtrl'
            })
            .when(base_url+'dispPlan',{
                templateUrl:views_url + 'plans/dispPlan.html',
                controller:'dispPlanCtrl'
            })
            .when(base_url+'proflPlan',{
                templateUrl:views_url + 'plans/proflPlan.html',
                controller:'proflPlanCtrl'
            })
            /*личный кабинет*/
            .when(base_url+'login',{
                templateUrl:views_url + 'login/index.html',
                controller:'loginCtrl'
            })
            /*Загрузка среза*/
            .when(base_url+'loader',{
                templateUrl:views_url + 'loader/loader.html',
                controller:'loaderCtrl'
            })
            /*Спасибо*/
            .when(base_url+'thx',{
                templateUrl:views_url + 'loader/thx.html',
                controller:'loaderCtrl'
            })
            /*другая страница*/
            /*todo 303 redirect*/
            .otherwise({
                redirectTo: '/dsp/'
            });
    }
]);


/*загружаем в память шаблоны*/
dspApp.run(function($rootScope,$templateCache, $http) {
    /*Заголовок страницы*/

    /*загружаем шаблоны в память чтобы потом летало*/
    $http.get(views_url + 'main/index.html')
        .then(function(response) {
            console.info(response);
            $templateCache.put(views_url + 'main/index.html', response.data);
        });

    $http.get(views_url + 'login/index.html')
        .then(function(response) {
            console.info(response);
            $templateCache.put(views_url + 'login/index.html', response.data);
        });

    $http.get(views_url + 'plans/dispPlan.html')
        .then(function(response) {
            console.info(response);
            $templateCache.put(views_url + 'plans/dispPlan.html', response.data);
        });

    $http.get(views_url + 'plans/proflPlan.html')
        .then(function(response) {
            console.info(response);
            $templateCache.put(views_url + 'plans/proflPlan.html', response.data);
        });

    $rootScope.exit_link = base_url + 'api/dsp_auth/logout';



});

