<?php
ob_start(); // Start output buffering

$servername = 'localhost';
$username = 'ollatoin_oneminduser';
$password = 'ollato@2020';
$dbname = 'ollatoin_onemind';

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    echo "Failed to connect to the database.";
}

// Function to handle file upload
function handleFileUpload($file) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    // Check file type
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        return "Sorry, only JPG, JPEG, & PNG files are allowed.";
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        return "Sorry, file already exists.";
    }

    // Check file size
    if ($file["size"] > 500000) { // 500KB
        return "Sorry, your file is too large.";
    }

    // Try to upload file
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return $targetFile; // Return the file path if successful
    } else {
        return "Sorry, there was an error uploading your file.";
    }
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Start the session
    session_start();

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

    // Handle file upload
    if (isset($_FILES["student-pic"])) {
        $fileUploadResult = handleFileUpload($_FILES["student-pic"]);
        if (strpos($fileUploadResult, "Sorry") === 0) {
            echo $fileUploadResult;
            exit(); // Stop further execution if file upload fails
        } else {
            $student_pic = $fileUploadResult;
        }
    } else {
        $student_pic = null;
    }

    // Insert data into the database
    $sql = "INSERT INTO stdregistration (name, dob, gender, phone, email, parents_phone, parents_email, school, qualification, password, student_pic) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo "Error preparing statement: " . $conn->error;
    } else {
        $stmt->bind_param("sssssssssss", $name, $dob, $gender, $phone, $email, $parents_phone, $parents_email, $school, $qualification, $hashed_password, $student_pic);

        if ($stmt->execute()) {
            echo "Successfully registered.";
        } else {
            echo "Error executing statement: " . $stmt->error;
        }
        
        $stmt->close();
    }

    // Close the database connection
    $conn->close();
}

ob_end_flush(); // End output buffering and flush the output
?>
