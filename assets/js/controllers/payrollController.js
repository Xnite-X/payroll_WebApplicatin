app.controller('payrollController', function($scope, $http) {
    $scope.getEmployees = function() {
        $http.get('api/employees.php').then(function(response) {
            $scope.employees = response.data;
        }).catch(function(error) {
            console.error('Error fetching employees:', error);
        });
    };
    $scope.getEmployees();

    $scope.addPayroll = function() {
        var payroll = {
            employee_id: $scope.employee_id, 
            month: $scope.month,
            salary: $scope.salary
        };
        $http.post('api/payroll.php', payroll).then(function(response) {
            $scope.getPayrolls();
        }).catch(function(error) {
            console.error('Error adding payroll:', error);
        });
    };

    $scope.getPayrolls = function() {
        $http.get('api/payroll.php').then(function(response) {
            $scope.payrolls = response.data;
        }).catch(function(error) {
            console.error('Error fetching payrolls:', error);
        });
    };
    $scope.getPayrolls();

    // Juanda Gilang Purnomno
});
