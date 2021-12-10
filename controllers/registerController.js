/// <reference path="../app.js" />

// loginController is a controller for the login page with username, password, and login function 
app.controller("registerController", function ($scope, $http) {
    model = $scope;

    model.register = function () {
        if (model.validate()) {
            model.validate();
            $http.post('/api/register', {
                username: model.username,
                password: model.password,
                email: model.email
            }).then(function (response) {
                console.log(response.data);
                // if login is successful, redirect to home page
                if (response.data.status == 1 || response.data.status == 3) { // if status is 1, login is successful, if status is 3 user already logged in  
                    window.location.href = '/login';
                }
                // if login is unsuccessful, display error message
                else {
                    model.error = response.data.message;
                }
            });
        }
    }
    //validate email format, password, and username are not empty
    model.validate = function () {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (model.username == null || model.username == "") {
            model.error = "Username cannot be empty";
            return false;
        }
        else if (model.password == null || model.password == "") {
            model.error = "Password cannot be empty";
            return false;
        }
        else if (model.email == null || model.email == "") {
            model.error = "Email cannot be empty";
            return false;
        }
        else if (!re.test(model.email)) {
            model.error = "Invalid email format";
            return false;
        }
        else {
            return true;
        }

    }

    model.username = "";

    model.email = "";

    model.password = "";

    model.error = "";

});