<?php

$host = "localhost";
$user = "root";
$password = "";
$db = "student_project";

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    error_log('Database connection failed: ' . $conn->connect_error);
    die('Database connection error');
}

$conn->set_charset('utf8mb4');

?>