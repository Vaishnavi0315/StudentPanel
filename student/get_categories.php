<?php
$servername = 'localhost';
 $username = 'ollatoin_oneminduser';
 $password = 'ollato@2020';
 $dbname = 'ollatoin_onemind';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/*
$sql = "SELECT id, name FROM categories";
$result = $conn->query($sql);

$categories = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

echo json_encode($categories);

*/



$sql2 ="SELECT user_id, time_slot FROM useravailability";
$result = $conn->query($sql2);
$timeSlotUA = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $timeSlotUA[] = $row;
    }
}

echo json_encode($timeSlotUA);


$conn->close();
?>
