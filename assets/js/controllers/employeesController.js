app.controller('employeesController', function($scope, $http) {
    $scope.getEmployees = function() {
        $http.get('api/employees.php').then(function(response) {
            $scope.employees = response.data;
        }).catch(function(error) {
            console.error('Error fetching employees:', error);
        });
    }

    $scope.addEmployee = function() {
        var employee = {
            name: $scope.newName,
            position: $scope.newPosition,
            salary: $scope.newSalary
        };

        $http.post('api/employees.php', employee).then(function(response) {
            $scope.getEmployees();
            $scope.newName = '';
            $scope.newPosition = '';
            $scope.newSalary = '';
        }).catch(function(error) {
            console.error('Error adding employee:', error);
        });
    }

    $scope.editEmployee = function(employee) {
        $scope.isEditing = true;
        $scope.currentEmployee = angular.copy(employee);
    }

    $scope.updateEmployee = function() {
        $http.put('api/employees.php', $scope.currentEmployee).then(function(response) {
            $scope.getEmployees();
            $scope.isEditing = false;
            $scope.currentEmployee = {};
        }).catch(function(error) {
            console.error('Error updating employee:', error);
        });
    }

    $scope.cancelEdit = function() {
        $scope.isEditing = false;
        $scope.currentEmployee = {};
    }


    $scope.deleteEmployee = function(id) {
        $http.delete('api/employees.php', {
            params: { id: id }
        }).then(function(response) {
            console.log('Response:', response.data);
            $scope.getEmployees();
        }).catch(function(error) {
            console.error('Error deleting employee:', error);
        });
    }
    
    
// Juanda Gilang Purnomo
    $scope.getEmployees();
});
