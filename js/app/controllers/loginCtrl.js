/**
 * Created by elex on 25.12.2016.
 */

/* Contact Controller */
dspApp.controller('loginCtrl',[
    '$scope','$http', '$location', '$routeParams',
    function($scope, $http, $location, $routeParam) {

        $("html, body").animate({scrollTop: 0}, 100);
        $scope.LoginError = false;
        /*вход*/
        $scope.Login = function() {
            $http.post(
                api_url + "dsp_auth/login",
                $.param($scope.user)
            )
                .success(function (response) {
                    $scope.resp = response;

                    if($scope.resp.status==1) {
                        $location.path(base_url);

                    } else $scope.LoginError = true;

                });
        }

        /*проверяем на авторизацию*/
        $http.get(api_url + "dsp_auth/isAuth")
            .then(function(response) {
                if(response.data.auth==1) {
                    $location.path(base_url);
                }

            });

    }
]);