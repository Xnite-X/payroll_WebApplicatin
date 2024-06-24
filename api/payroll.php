<?php
// Juanda Gilang Purnomo

require 'connect.php';

// Set the response headers to allow cross-origin requests and JSON content type
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Create a MySQLi instance
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    // If there is an error, display the error message
    echo json_encode(["message" => "Error: " . $conn->connect_error]);
    die();
}

// Handle GET requests
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $sql = "SELECT * FROM payroll";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $payrolls = [];
        while ($row = $result->fetch_assoc()) {
            $payrolls[] = $row;
        }
        echo json_encode($payrolls);
    } else {
        echo json_encode(["message" => "No payroll records found"]);
    }
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->employee_id, $data->month, $data->salary)) {
        $employee_id = $data->employee_id;
        $month = $data->month;
        $salary = $data->salary;

        $sql = "INSERT INTO payroll (employee_id, month, salary) VALUES ('$employee_id', '$month', '$salary')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["message" => "Payroll added successfully"]);
        } else {
            echo json_encode(["message" => "Error: " . $conn->error]);
        }
    } else {
        echo json_encode(["message" => "Invalid input"]);
    }
}
