<?php
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the data from POST request
$date = $_POST['date'];
$expertise = $_POST['expertise'];
$mode = $_POST['mode'];
$time = $_POST['time'];
$duration = $_POST['duration'];

// Insert the data into database
$sql = "INSERT INTO sessions (date, expertise, mode, time, duration) VALUES ('$date', '$expertise', '$mode', '$time', '$duration')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
