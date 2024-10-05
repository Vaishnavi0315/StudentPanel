<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION["id"])) {
        $user_id = $_SESSION["id"];
        $name = trim($_POST["name"]);
        $contact_no = trim($_POST["contact_no"]);
        $standard = trim($_POST["standard"]);
        $profile_pic = "";

        // Handle profile picture upload
        if (isset($_FILES["student_pic"]) && $_FILES["student_pic"]["error"] == UPLOAD_ERR_OK) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["student_pic"]["name"]);
            $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if the uploaded file is an image
            $check = getimagesize($_FILES["student_pic"]["tmp_name"]);
            if ($check === false) {
                echo "File is not an image.";
                exit;
            }

            // Allow certain image file formats
            if ($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "gif") {
                echo "Only JPG, JPEG, PNG & GIF files are allowed.";
                exit;
            }

            // Upload the profile picture
            if (move_uploaded_file($_FILES["student_pic"]["tmp_name"], $target_file)) {
                $profile_pic = $target_file;
            } else {
                echo "Error uploading profile picture.";
                exit;
            }
        }

        // Update user data in the database
        $sql = "UPDATE stdregistration SET name = ?, phone = ?, standard = ?, student_pic = ? WHERE id = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssssi", $name, $contact_no, $standard, $profile_pic, $user_id);
            if (mysqli_stmt_execute($stmt)) {
                echo '<script>';
                echo 'alert("Data stored successfully");'; // Display popup message
                echo 'window.history.back();'; // Go back to previous page
                echo '</script>';
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        echo "No user ID found in session.";
    }
}

mysqli_close($link);
?>