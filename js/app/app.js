'use strict';
var base_url = '/develop/';
var api_url = base_url+'api/';
var views_url = base_url+'js/app/views/';

var controllers_url = base_url+'js/app/controllers/';
/* App Module */

var dspApp = angular.module('dspApp', ['ngAnimate','ngResource','ngSanitize','ngRoute', 'httpPostFix','bsTable']);

var navbar = [
    {
        caption:'Рабочий стол',
        link:'',
        icon:'ti-panel'
    },
    {
        caption:'План диспансеризации',
        link:'dispPlan',
        icon:'ti-pie-chart'
    },
    {
        caption:'План профилактических осмотров',
        link:'proflPlan',
        icon:'ti-support'
    },
    {
        caption:'Загрузка<br>актуального среза РС ЕРЗЛ',
        link:'loader',
        icon:'ti-reload'
    },
    {
        caption:'Настройки',
        link:'settings',
        icon:'ti-settings'
    },
]

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
            .when(base_url+'settings',{
                templateUrl:views_url + 'main/settings.html',
                controller:'settingsCtrl'
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
    $rootScope.navbar = navbar;



    $rootScope.exit_link = base_url + 'api/dsp_auth/logout';



});

