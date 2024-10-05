<?php
session_start(); // Initialize the session

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuration
$servername = 'localhost';
$username = 'ollatoin_oneminduser';
$password = 'ollato@2020';
$dbname = 'ollatoin_onemind';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the posted data
$counsellor_id = $_POST['user_id'];
$student_id = $_SESSION["id"]; // assuming you have the student ID in the session
$b_duration = $_POST['duration'];
$b_date = $_POST['date'];
$b_mode = $_POST['mode'];
$b_time_slot = $_POST['time_slot']; // Add this line to get the selected time slot

// Insert data into session_management table
$stmt = $conn->prepare("INSERT INTO session_management (counsellor_id, student_id, b_duration, b_date, b_mode, b_time_slot, Booked) 
                        VALUES (?, ?, ?, ?, ?, ?, 1)");

if (!$stmt) {
    echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
}

// Bind the parameters
$stmt->bind_param("iiisss", $counsellor_id, $student_id, $b_duration, $b_date, $b_mode, $b_time_slot);

// Execute the statement
$stmt->execute();


// Check if the execution was successful
if ($stmt->affected_rows > 0) {
    ?>
    <script>
        alert("Payment successful! Your session has been booked.");
    </script>
    <?php
} else {
    ?>
    <script>
        alert("Error: Unable to book session.");
    </script>
    <?php
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>