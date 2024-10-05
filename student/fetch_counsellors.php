<?php

$servername = 'localhost';
$username = 'ollatoin_oneminduser';
$password = 'ollato@2020';
$dbname = 'ollatoin_onemind';

echo 'fetch_counsellors.php called';

$conn = new mysqli("$servername", "$username", "$password", "$dbname");
echo 'mysqli connection established';

if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

$mode = $_POST['mode'];
echo 'mode:', $mode;

$sql = "SELECT user_id FROM useravailability WHERE mode =?";
echo 'ql:', $sql;

$stmt = $conn->prepare($sql);


$stmt->bind_param("s", $mode);


$stmt->execute();

$result = $stmt->get_result();
echo 'esult fetched';

$counsellors = array();

while($row = $result->fetch_assoc()) {
    $counsellors[] = $row;
    echo 'row fetched:', $row;
}

$stmt->close();
echo 'tmt closed';

$conn->close();
echo 'conn closed';

echo json_encode($counsellors);
echo 'json encoded and sent';
?>
