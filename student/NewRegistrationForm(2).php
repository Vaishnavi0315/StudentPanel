<?php
$servername = 'localhost';
$username = 'ollatoin_oneminduser';
$password = 'ollato@2020';
$dbname = 'ollatoin_onemind';

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
  die("Connection failed: ". mysqli_connect_error());
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form data
  $name = $_POST["full-name"];
  $dob = $_POST["dob"];
  $gender = $_POST["gender"];
  $phone = $_POST["phone"];
  $email = $_POST["email"];
  $parents_phone = $_POST["parents-phone"];
  $parents_email = $_POST["parents-email"];
  $school = $_POST["school"];
  $qualification = $_POST["qualification"];
  $password = $_POST["password"];
  
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  
  
  // Insert the form data into the database
   $stmt = $conn->prepare("INSERT INTO stdregistration (name, dob, gender, phone, email, parents_phone, parents_email, school, qualification, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssssssss", $name, $dob, $gender, $phone, $email, $parents_phone, $parents_email, $school, $qualification, $hashed_password);


  if ($stmt->execute()) {
    echo "Profile updated successfully!";
  } else {
    echo "Error: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();
}
// Redirect back to the main page
header("Location: stumanage.php"); // Replace 'index.php' with the actual name of your main PHP file
exit();
?>