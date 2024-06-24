<?php
// Juanda Gilang Purnomo
require 'connect.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Create a MySQLi instance
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    error_log('Connection failed: ' . $conn->connect_error);
    echo json_encode(['status' => 'Connection failed: ' . $conn->connect_error]);
    die();
}

$method = $_SERVER['REQUEST_METHOD'];
error_log('Request Method: ' . $method);

switch ($method) {
    case 'GET':
        error_log('GET Request');
        $sql = "SELECT * FROM employees";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode($data);
        } else {
            echo json_encode(['status' => 'No employees found']);
        }
        break;

    case 'POST':
        error_log('POST Request');
        $data = json_decode(file_get_contents('php://input'), true);
        $name = $conn->real_escape_string($data['name']);
        $position = $conn->real_escape_string($data['position']);
        $salary = $conn->real_escape_string($data['salary']);
        $sql = "INSERT INTO employees (name, position, salary) VALUES ('$name', '$position', '$salary')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['status' => 'Employee added successfully']);
        } else {
            echo json_encode(['status' => 'Error: ' . $conn->error]);
        }
        break;

    case 'PUT':
        error_log('PUT Request');
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $conn->real_escape_string($data['id']);
        $name = $conn->real_escape_string($data['name']);
        $position = $conn->real_escape_string($data['position']);
        $salary = $conn->real_escape_string($data['salary']);
        $sql = "UPDATE employees SET name='$name', position='$position', salary='$salary' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['status' => 'Employee updated successfully']);
        } else {
            echo json_encode(['status' => 'Error: ' . $conn->error]);
        }
        break;

    case 'DELETE':
        error_log('DELETE Request');
        if (isset($_GET['id'])) {
            $id = $conn->real_escape_string($_GET['id']);
            error_log('Received ID: ' . $id);

            // Delete related payroll entries first
            $sql = "DELETE FROM payroll WHERE employee_id='$id'";
            if ($conn->query($sql) === TRUE) {
                // Then delete the employee
                $sql = "DELETE FROM employees WHERE id='$id'";
                if ($conn->query($sql) === TRUE) {
                    echo json_encode(['status' => 'Employee deleted successfully']);
                } else {
                    echo json_encode(['status' => 'Error: ' . $conn->error]);
                }
            } else {
                echo json_encode(['status' => 'Error: ' . $conn->error]);
            }
        } else {
            echo json_encode(['status' => 'Invalid ID']);
        }
        break;

    default:
        echo json_encode(['status' => 'Invalid request']);
        break;
}

$conn->close();
