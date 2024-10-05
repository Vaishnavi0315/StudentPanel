<?php
// save_assessment.php

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user ID (assuming it's passed from the client-side)
    $user_id = $_POST['user_id'];

    // Retrieve counts from POST data
    $never = $_POST['never'];
    $rarely = $_POST['rarely'];
    $sometimes = $_POST['sometimes'];
    $often = $_POST['often'];

    // Validate and sanitize input data (not shown in this example, but important for security)

    // Database connection parameters (adjust as per your database setup)
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

    // Prepare SQL statement to insert data into assessment_responses table
    $sql = "INSERT INTO assessment_responses (user_id, never, rarely, sometimes, often)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiii", $user_id, $never, $rarely, $sometimes, $often);

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "Data saved successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Handle other request methods or invalid requests
    http_response_code(405); // Method Not Allowed
    echo "Method Not Allowed";
}
?>
