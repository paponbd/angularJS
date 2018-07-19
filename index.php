<!doctype html>
<html>
    <head>
        <title>AngularJS Addressbook</title>
        <link href="bootstrap.min.css" rel="stylesheet">
        <script src="angular.min.js"></script>
        
    </head>
    <body >
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
          <div class="container">
            <div class="row">
              <div class="navbar-header col-md-8">
                <button type="button" class="navbar-toggle" toggle="collapse" target=".navbar-ex1-collapse">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" rel="home" title="AngularJS Authentication App"><big>AngularJS Addressbook</big>   <small> A Restfull Web App</small></a>
              </div>
             
               
            </div>
          </div>
        </div>

        <div ng-app='myapp' ng-controller="userCtrl" style="margin-top: 40px" class="container">
            <h3 class="bg-success" ">Enter a new address to remember</h3>
            <form class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-sm-2">Name:</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" placeholder="Enter name" ng-model="name">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2">Email:</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" placeholder="Enter name" ng-model="email">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Phone No.:</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" placeholder="Enter name" ng-model="phone">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Address:</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control" placeholder="Enter name" ng-model="address">
                    </div>
                </div>
                <div class="form-group">        
                    <div class="col-sm-offset-2 col-sm-5">
                    <input type="button" class="btn btn-default btn-success" value="Submit" ng-click="add()">
                    </div>
                    <div class="col-sm-offst-2 col-sm-5">
                    <input type="button" class="btn btn-default btn-success" value="Update" ng-click="update()">
                    </div>    
                </div>
            </form>
            <div class="container">
            <table class="table table-striped">
                
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone No.</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
                
                <tr ng-repeat="user in users">
                <td>{{user.name}}</td>
                <td>{{user.email}}</td>
                <td>{{user.phone}}</td>
                <td>{{user.address}}</td>
                <td> <div class="btn-group">
                      <button type="button" class="btn btn-primary" ng-click='BindSelectedData(user)'>Edit</button>
                      <button type="button" class="btn btn-danger" ng-click='remove($index,user.id);'>Delete</button>
                    </div>
                </tr>
                
            </table>
            </div>
        </div>
        
        <!-- Script -->
        <script>
        var fetch = angular.module('myapp', []);

        fetch.controller('userCtrl', ['$scope', '$http', function ($scope, $http) {

            // Get all records
            $http({
                method: 'post',
                url: 'addremove.php',
                data: {request_type:1},

            }).then(function successCallback(response) {
                $scope.users = response.data;
            });

            // Add new record
            $scope.add = function(){

                var len = $scope.users.length;
                $http({
                method: 'post',
                url: 'addremove.php',
                data: {name:$scope.name,email:$scope.email,phone:$scope.phone,address:$scope.address,request_type:2,len:len},
                }).then(function successCallback(response) {
                    $scope.users.push(response.data[0]);
                });
                clearModel();
            }

            // Delete record
            $scope.remove = function(index,userid){
               
                $http({
                method: 'post',
                url: 'addremove.php',
                data: {userid:userid,request_type:3},
                }).then(function successCallback(response) {
                    $scope.users.splice(index, 1);
                }); 
            }
            function clearModel(){
                $scope.name = "";
                $scope.email = "";
                $scope.phone = "";
                $scope.address = "";
            };
            $scope.BindSelectedData = function(user){
                $scope.name=user.name;
                $scope.email=user.email;
                $scope.phone=user.phone;
                $scope.address=user.address;
                $scope.id=user.id;
            };

            $scope.update = function(){

                var id = $scope.id;
                $http({
                method: 'post',
                url: 'addremove.php',
                data: {name:$scope.name,email:$scope.email,phone:$scope.phone,address:$scope.address,request_type:4,id:id},
                }).then(function successCallback(response) {
                    $scope.users.push(response.data[0]);
                });
                clearModel();
            }
            
        }]);

        </script>
        <footer style="margin-top: 150px">&copy; created by syfur rahman papon</footer>
    </body>

</html>
