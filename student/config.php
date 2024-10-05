<?php
// Database configuration
$servername = 'localhost';
$username = 'ollatoin_oneminduser';
$password = 'ollato@2020';
$dbname = 'ollatoin_onemind';

// Attempt to connect to MySQL database
$link = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
/*
<?php
session_start();

$servername = 'localhost';
$username = 'ollatoin_oneminduser';
$password = 'ollato@2020';
$dbname = 'ollatoin_onemind';

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM stdregistration WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];
        
        if (password_verify($password, $hashed_password)) {
            // Login successful
            $_SESSION['email'] = $email;
            header("Location: lan.html"); // Redirect to profile page
            exit();
        } else {
            // Invalid password
            echo "<script>alert('Incorrect password. Please try again.');</script>";
        }
    } else {
        // Email not found
        echo "<script>alert('Email not registered. Please register first.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>*/

// Start session
session_start();
?>
