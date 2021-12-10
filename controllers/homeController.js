/// <reference path="../app.js" />

// loginController is a controller for the login page with username, password, and login function 
app.controller("homeController", function ($scope, $http, $routeParams)  {

    model = $scope;

    model.inputs= {createGroupInput:  ''};
    model.createGroupInputShow = false;
    model.groups = [];
    model.tasks = [];
    model.newTask = {
        title: '',
        description: '',
        status: 0,
        group_id: ''
    };

    model.hasUrlGroupId = false;
    model.groupId = $routeParams.idgroup; 

    model.init = function () {
        model.hasUrlGroupId = false;
        console.log($routeParams);
        //post to api/login.php to check if user is logged in
        $http.post("api/login").then(function (response) {
            if (response.data.status != 3) {
                //if user not logged in, redirect to login page
                window.location.href = "/login";
            }else{
                //get groups from api/groups.php
                $http.get("api/group").then(function (response) {
                    model.groups = response.data;
                    console.log(model.groups);
                });
            }

        });
    }

    model.logout = function () {
        $http.post("api/logout").then(function (response) {
            window.location.href = "/login";
        });
    }

    model.createTask = function () {
        console.log(model.newTask);
        if($routeParams.idgroup){
            model.newTask.group_id = $routeParams.idgroup;
            $http.post("api/task", model.newTask).then(function () {
                model.newTask = {
                    title: '',
                    description: '',
                    status: 0,
                    group_id: ''
                };
                model.getTasks();
            });
        }
    }

    model.getTasks = function () {
        if($routeParams.idgroup){
            model.hasUrlGroupId = true;
            $http.get("api/task?group_id="+$routeParams.idgroup).then(function (response) {
                console.log(response.data);
                model.tasks = response.data;
            });
        }
    }

    model.deleteTask = function (id) {
        $http.delete("api/task?task_id=" + id).then(function () {
            model.getTasks();
        });
    }
    model.deleteGroup= function (id) {
        $http.delete("api/group?group_id=" + id).then(function () {
            window.location.href = '/home';            
        });
    }

    model.updateTask = function (task) {
        $http.put("api/task", task )
    }

    model.createGroup = function (event) {
      console.log(model);
      if (event.which == 13 && model.inputs.createGroupInput.length > 3) {
        $http.post("api/group", 
        {title: model.inputs.createGroupInput}
        ).then(function (response) {
            model.inputs.createGroupInput = '';
            model.createGroupInputShow = false;
          model.init();
        });
        
      }
    }
});