<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE counsellorFilter";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}

// Use the new database
$conn->select_db("counsellorFilter");

// Create table
$sql = "CREATE TABLE filter (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    expertise VARCHAR(50) NOT NULL,
    mode VARCHAR(50) NOT NULL,
    time VARCHAR(10) NOT NULL,
    duration VARCHAR(10) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table filter created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
