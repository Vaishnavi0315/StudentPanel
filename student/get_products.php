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


$category_id = intval($_GET['category_id']);
$sql = "SELECT name FROM products WHERE category_id = $category_id";
$result = $conn->query($sql);

$products = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

echo json_encode($products);

*/
$useravailability_id = intval($_GET['id']);
$sql3="SELECT full_name FROM users WHERE $useravailability_id= id";
$result = $conn->query($sql3);

$users=array();
if( $result->num_rows>0){
    while($row = $result -> fetch_assoc()){
        $users[] = $row;
    }
}

echo json_encode($users);
$conn->close();
?>


