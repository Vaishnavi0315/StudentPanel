<?php
session_start();
require_once 'config.php';
// Create connection

// Retrieve user_id (you need to implement how to get this based on your application's context)
$user_id = $_SESSION['user_id']; // Example session variable storing user_id

// Fetch data from assessments table for the given user_id
$sql = "SELECT * FROM assessments WHERE user_id = $user_id";
$result = $link->query($sql);

if ($result->num_rows > 0) {
  // Initialize counters for never, rarely, sometimes, often
  $never_total = 0;
  $rarely_total = 0;
  $sometimes_total = 0;
  $often_total = 0;

  // Assuming the columns are named q1, q2, ..., q30 in the assessments table
  while($row = $result->fetch_assoc()) {
    // Aggregate counts
    $never_total += intval($row['q1'] == 'never');
    $rarely_total += intval($row['q1'] == 'rarely');
    $sometimes_total += intval($row['q1'] == 'sometimes');
    $often_total += intval($row['q1'] == 'often');

    // Repeat for q2 to q30 or adjust as per your table structure
  }

  // Store aggregated counts into assessment_responses table
  $insert_sql = "INSERT INTO assessment_responses (user_id, never, rarely, sometimes, often)
                VALUES ('$user_id', $never_total, $rarely_total, $sometimes_total, $often_total)";

  if ($link->query($insert_sql) === TRUE) {
    echo "Assessment responses stored successfully.";
  } else {
    echo "Error: " . $insert_sql . "<br>" . $link->error;
  }
} else {
  echo "No assessments found for this user.";
}

$link->close();
?>
