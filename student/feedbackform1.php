<?php
// Database connection
$servername = "localhost";
$username = "ollatoin_oneminduser";
$password = "ollato@2020";
$dbname = "ollatoin_onemind";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $comments = $_POST['comments'];
    $std_id = $_POST['std_id'];

    // Retrieve Std_name from stdregistration table
    $sql = "SELECT name FROM stdregistration WHERE id = '$std_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $std_name = $row["name"];

    // Insert data into database
    $questions = $_POST;
    unset($questions['comments']);
    unset($questions['std_id']);
    $q1 = array_shift($questions);
    $q2 = array_shift($questions);
    $q3 = array_shift($questions);
    $q4 = array_shift($questions);
    $q5 = array_shift($questions);

    $sql = "INSERT INTO feedbackform (q1, q2, q3, q4, q5, comments, Std_id, Std_name) VALUES ('$q1', '$q2', '$q3', '$q4', '$q5', '$comments', '$std_id', '$std_name')";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Your feedback is recorded successfully! Thankyou."); window.location.href = "studentDashboard.php";</script>';
    } else {
        echo '<script>alert("Error: ' . $sql . '\n' . $conn->error . '")</script>';
    }
}
$conn->close();
?>