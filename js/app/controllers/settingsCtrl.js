/**
 * Created by elex on 25.12.2016.
 */


/* Contact Controller */
dspApp.controller('settingsCtrl',[
    '$rootScope','$scope','$http', '$location', '$routeParams',
    function($rootScope, $scope, $http, $location, $routeParam ) {
        $scope.toLink = function(link) {
            $location.path(base_url + link);
        };

        /*проверяем на авторизацию*/
        $http.get(api_url + "dsp_auth/isAuth")
            .then(function(response) {
                if(response.data.status==0) {
                    $location.path(base_url+'login');
                }
            });

        $http.get(api_url + "dsp_auth/GetUserSettings")
            .then(function(response) {
               $scope.s = response.data;
                $scope.s.tfoms_date_planning = new Date(moment($scope.s.tfoms_date_planning).format('YYYY'), parseInt(moment($scope.s.tfoms_date_planning).format('MM'))-1, moment($scope.s.tfoms_date_planning).format('DD'));
            });



        $("html, body").animate({scrollTop: 0}, 100);

        $scope.Logout = function() {
            $http.get(api_url + "dsp_auth/logout")
                .then(function(response) {
                        $location.path(base_url + 'login');
                });
        };

        $scope.toLink = function(link) {
            $location.path(base_url + link);
        };

        $scope.SettingsSave = function(){
            $scope.s.tfoms_date_planning = moment($scope.s.tfoms_date_planning).format('YYYY-MM-DD');
            console.info($scope.s.tfoms_date_planning);
            $http.post(
                api_url + "dsp_auth/SettingsSave",
                $.param($scope.s)
            )
                .success(function (response) {
                    console.info(response);
                    if(response.auth==0) {
                        $location.path(base_url + 'login');
                    }
                    else {
                        $location.path(base_url);
                    }

                });
        }



    }
]);