// Juanda Gilang Purnomo
var app = angular.module('payrollApp', ['ngRoute']);

app.config(function($routeProvider) {
    $routeProvider
        .when("/", {
            templateUrl: "partials/dashboard.html",
            controller: "dashboardController"
        })
        .when("/employees", {
            templateUrl: "partials/employees.html",
            controller: "employeesController"
        })
        .when("/payroll", {
            templateUrl: "partials/payroll.html",
            controller: "payrollController"
        })
        .otherwise({
            redirectTo: "/"
        });
});
