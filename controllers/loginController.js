/// <reference path="../app.js" />

// loginController is a controller for the login page with username, password, and login function 
app.controller("loginController", function ($scope, $http) {
    model = $scope;
    // login function
    model.login = function () {
        $http.post('/api/login', {
            username: model.username,
            password: model.password
        }).then(function (response) {
            console.log(response.data);
            // if login is successful, redirect to home page
            if (response.data.status == 1 || response.data.status == 3) { // if status is 1, login is successful, if status is 3 user already logged in  
                window.location.href = '/home';
            }
            // if login is unsuccessful, display error message
            else {
                model.error = response.data.message;
            }
        });
    }


    model.username = "";

    model.password = "";

    model.error = "";

});