<?php
require_once 'config.php';

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$id = $_SESSION["id"];
$email = $_SESSION["email"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $phone = trim($_POST["contact_no"]);
    $standard = trim($_POST["qualification"]);
    $profile_pic = $_FILES["profile-pic-input"];

    $sql = "SELECT * FROM stdregistration WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id); // Note: "i" for integer
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) == 1) {
                // Update profile pic
                if ($profile_pic["size"] > 0) {
                    $target_dir = "uploads/";
                    $target_file = $target_dir . basename($profile_pic["name"]);
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                    // Check if image file is a actual image or fake image
                    $check = getimagesize($profile_pic["tmp_name"]);
                    if ($check !== false) {
                        $uploadOk = 1;
                    } else {
                        $uploadOk = 0;
                    }

                    // Check if file already exists
                    if (file_exists($target_file)) {
                        $uploadOk = 0;
                    }

                    // Check file size
                    if ($profile_pic["size"] > 500000) {
                        $uploadOk = 0;
                    }

                    // Allow certain file formats
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                        $uploadOk = 0;
                    }

                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        echo "Sorry, your file was not uploaded.";
                    } else {
                        if (move_uploaded_file($profile_pic["tmp_name"], $target_file)) {
                            $sql = "UPDATE stdregistration SET student_pic = ? WHERE id = ? AND email = ? AND name = ?";
                            if ($stmt = mysqli_prepare($link, $sql)) {
                                mysqli_stmt_bind_param($stmt, "siss", $target_file, $id, $email, $name);
                                mysqli_stmt_execute($stmt);
                            }
                        } else {
                            echo "Sorry, there was an error uploading your file.";
                        }
                    }
                }

                // Update contact no and standard
                $sql = "UPDATE stdregistration SET phone = ?, qualification = ? WHERE id = ? AND email = ? AND name = ?";
                if ($stmt = mysqli_prepare($link, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ssiis", $phone, $standard, $id, $email, $name);
                    mysqli_stmt_execute($stmt);
                }
            } else {
                echo "Invalid credentials.";
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }
}
mysqli_close($link);
?>
