<?php
// Juanda Gilang Purnomo

// Database connection parameters
$host = 'localhost';
$db = 'payroll';
$user = 'root';
$pass = '';

// Create a new MySQLi instance
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    // If there is an error, display the error message
    die("Connection failed: " . $conn->connect_error);
}
