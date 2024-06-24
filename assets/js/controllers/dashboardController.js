// Juanda Gilang Purnomo
app.controller('dashboardController', function($scope, $http) {
    $http.get('api/employees.php').then(function(response) {
        $scope.employees = response.data;
    });

    $http.get('api/payroll.php').then(function(response) {
        $scope.payrolls = response.data;
    });
});
