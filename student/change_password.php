<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        echo "Passwords do not match. Please try again.";
        exit;
    }

    // Here you can add code to update the password in the database
    // Ensure to hash the password before storing it

    echo "Password updated successfully!";
}
?>
