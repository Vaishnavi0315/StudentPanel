<?php
$servername = 'localhost';
 $username = 'ollatoin_oneminduser';
 $password = 'ollato@2020';
 $dbname = 'ollatoin_onemind';

 $conn = mysqli_connect($servername, $username, $password, $dbname);
 if (!$conn) {
   die("Connection failed: ". mysqli_connect_error());
 }

// Get form data
$name = $_POST['full_name'];
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// Check if passwords match
if ($new_password != $confirm_password) {
    echo "Error: New password and confirm password do not match.";
    exit;
}

// Check if current password is correct
$query = "SELECT password FROM stdregistration WHERE full_name = '$name'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hashed_password = $row['password'];

    if (!password_verify($current_password, $hashed_password)) {
        echo "Error: Current password is incorrect.";
        exit;
    }
} else {
    echo "Error: Username not found.";
    exit;
}

// Hash new password
$new_password_hash = password_hash($new_password, PASSWORD_BCRYPT);

// Update password
$query = "UPDATE stdregistration SET password = '$new_password_hash' WHERE  full_name = '$name'";
if ($conn->query($query) === TRUE) {
    echo "Password changed successfully.";
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}

$conn->close();
?>