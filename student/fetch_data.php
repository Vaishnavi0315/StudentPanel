<?php
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

$sql = "SELECT questionNo, questionText FROM QuestionManagement";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $questions = array();
    while($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }
    echo json_encode($questions);
} else {
    echo json_encode([]);
}
$conn->close();
?>
