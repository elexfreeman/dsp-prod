/**
 * Created by elex on 25.12.2016.
 */


/* Contact Controller */
dspApp.controller('proflPlanCtrl',[
    '$rootScope','$scope','$http', '$location', '$routeParams',
    function($rootScope, $scope, $http, $location, $routeParam ) {


        $scope.toLink = function(link) {
            $location.path(base_url + link);
        }
        $scope.age_list = [
            21,24,27,30,33,36,39,42,45,48,51,54,57,60,63,66,69,76,72,75,78,81,84,87,90,93,96,99
        ];



        $scope.month_list = [
            {m:'01',month:'Январь'},
            {m:'02',month:'Февраль'},
            {m:'03',month:'Март'},
            {m:'04',month:'Апрель'},
            {m:'05',month:'Май'},
            {m:'06',month:'Июнь'},
            {m:'07',month:'Июль'},
            {m:'08',month:'Август'},
            {m:'09',month:'Сентябрь'},
            {m:'10',month:'Октябрь'},
            {m:'11',month:'Ноябрь'},
            {m:'12',month:'Декабрь'}
        ];

        $scope.patient = {
            month:'',
            age:'',
            TMODOC:'',
            DOCTOR:''
        }



        $("html, body").animate({scrollTop: 0}, 100);

        $scope.Logout = function() {
            $http.get(api_url + "dsp_auth/logout")
                .then(function(response) {
                        $location.path(base_url + 'login');
                });
        };

        $scope.initBt = function(params) {
            $scope.bsTable = {
                options: {
                    //data: rows,
                    ajax:$scope.GetPatients,
                    rowStyle: function (row, index) {
                        return { classes: 'none' };
                    },
                    cache: false,
                   /* height: 700,*/
                    /*striped: true,*/
                    pagination: true,
                    pageSize: 30,
                    pageList: [5, 10, 25, 50, 100, 200],
                    search: false,
                    sidePagination:'server',
                    showColumns: false,
                    /*showRefresh: false,*/
                    minimumCountColumns: 2,
                    clickToSelect: true,
                    /*showToggle: true,*/
                    locale: 'ru-RU',
                    /*maintainSelected: true,*/
                    columns: [
                        {   field: 'state',
                            checkbox: true
                        },
                        {
                            field: 'COUNTER',
                            title: '№',
                            align: 'center',
                            valign: 'bottom',
                            sortable: true
                        },
                        {
                            field: 'SURNAME',
                            title: 'SURNAME',
                            align: 'center',
                            valign: 'bottom',
                            sortable: true
                        },
                        {
                            field: 'NAME',
                            title: 'NAME',
                            align: 'center',
                            valign: 'middle',
                            sortable: true
                       },
                        {
                        field: 'SECNAME',
                        title: 'SECNAME',
                        align: 'left',
                        valign: 'top',
                        sortable: true
                    }, {
                        field: 'BIRTHDAY',
                        title: 'BIRTHDAY',
                        align: 'left',
                        valign: 'top',
                        sortable: true
                    }, {
                        field: 'LPUBASE',
                        title: 'LPUBASE',
                        align: 'left',
                        valign: 'top',
                        sortable: true
                    }]
                }
            };
            function flagFormatter(value, row, index) {
                return '<img src="' + row.flagImage + '"/>'
            }
        }

        $scope.GetPatients = function(params) {
            console.log(params.data);
            /*проверяем на авторизацию*/
            var send_data = {
                patient:$scope.patient,
                data:params.data
            }

            $http.post(
                api_url + "dsp_patients/GetPatients",
                $.param(send_data)
            )
                .success(function (response) {
                    console.info(response);
                    if(response.auth==0) {
                        $location.path(base_url + 'login');
                    }
                    else {
                        params.success(response.patients);
                    }

                });


        };

        $scope.initBt();
    }
]);