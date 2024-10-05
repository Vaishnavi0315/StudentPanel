<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'config.php';

// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$email = $_SESSION["email"];

$sql = "SELECT id, email, name, dob, gender, phone, school, qualification, student_pic FROM stdregistration WHERE email = ?";
if($stmt = mysqli_prepare($link, $sql)){
    mysqli_stmt_bind_param($stmt, "s", $email);
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1){
            mysqli_stmt_bind_result($stmt, $id, $email, $name, $dob, $gender, $phone, $school, $qualification, $student_pic);
            if(mysqli_stmt_fetch($stmt)){
                // Fetch was successful, now we have all the details in variables
            } else {
                echo "Error fetching details.";
            }
        } else {
            echo "No record found.";
        }
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Unable to prepare the statement.";
}
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

if($new_password != $confirm_password) {
        echo '<script>alert("Passwords do not match. Please try again.")</script>';
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql1 = "UPDATE stdregistration SET password =? WHERE email =?";
        if($stmt = mysqli_prepare($link, $sql1)){
            mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $email);
            if(mysqli_stmt_execute($stmt)){
                echo '<script>alert("Password updated successfully.")</script>';
            } else {
                echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
            }
            mysqli_stmt_close($stmt);
        } else {
            echo '<script>alert("Unable to prepare the statement.")</script>';
        }
    }
}
mysqli_close($link);

// Set default profile picture if none exists
if (empty($student_pic)) {
    $student_pic = 'uploads/shikamaru.jpg';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   
    <!-- Flatpickr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    <title>Profile Management</title>
    <link rel="stylesheet" href="updatePro.css">
    <script>
         // JavaScript to handle the logout action
        function logout() {
            window.location.href = 'logout.php';
        }

        // Add event listener to logout button
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('.logout').addEventListener('click', logout);
        });
    </script>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="uploads/ollato.png" alt="Logo" class="sidebar-logo">
          <ul>
                <li class="nav-tabs"><a href="studentDashboard.php"><span><?php echo htmlspecialchars($name);?></span></a></li>
                <li><a href="packages.html"><i class="fa-solid fa-gift"></i>   Packages</a></li>
                <li><a href="lan.php"><i class="fas fa-tasks"></i>   Assessment</a></li>
                <li><i class="fa-solid fa-cloud-arrow-down"></i> Download Summary</li>
                <li>Report</li>
                <li><a href="fetchExplm.php"><i class="fa fa-calendar-check-o"></i> Book Session</a></li>
                <li><a href="sessionMag.php"><i class="fa-solid fa-building"></i> Session Management</a></li>
                <li><a href="videocalling.html"><i class="fa fa-bell"></i> Notifications</a></li>
                <li><a href="feedbackform.php"><i class="fa-solid fa-comments"></i> FeedBack</a></li>
                <li><a href="updatePro.php"><i class="fa-solid fa-user"></i> Edit Profile</a></li>
                <button class="collapse-btn"><i class="fas fa-angle-left"></i></button>
                <button class="logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </ul>
    </div>
    </div>
    <div class="content-container">
  <div class="content">
    <header>
      <!-- header content -->
      <div class="brand-name">Ollato's Mind Mapping Programme</div>
                    <div class="user-profile">
                        <span><?php echo htmlspecialchars($name); ?></span>
                         <i class="fas fa-user profile-icon"></i>
                    </div>
    </header>
    <div class="container">
        <div class="tabs">
            <button class="tablink" onclick="openTab(event, 'EditProfile')" id="defaultOpen">Edit Profile</button>
            <button class="tablink" onclick="openTab(event, 'ChangePassword')">Change Password</button>
        </div>

        <div id="EditProfile" class="tabcontent">
            <form action="updateprofile.php" method="post" enctype="multipart/form-data">
                <div class="profile-header">
                    <img src="<?php echo $student_pic; ?>" alt="Profile Picture" class="profile-pic">
                    <input type="file" id="profile-pic-input" name="profile-pic-input" style="display:none;">
                    <button type="button" class="edit-pic-btn" onclick="document.getElementById('profile-pic-input').click();" style="font-weight: bold;">Edit</button>

                </div>
               <!--... -->
<!--... -->

<div class="form-group">
    <label for="name">Your Name</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name);?>" readonly>
</div>
<div class="form-group">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email);?>" readonly>
</div>
<div class="form-group">
    <label for="contact_no">Contact No</label>
    <input type="text" id="contact_no" name="contact_no" value="<?php echo htmlspecialchars($phone);?>" pattern="\d{10}" maxlength="10" placeholder="Enter your contact number" title="Please enter exactly 10 digits">
</div>
<div class="form-group">
    <label for="qualification">Standard</label>
    <input type="text" id="qualification" name="qualification" value="<?php echo htmlspecialchars($qualification);?>">
</div>

<!--... -->
<!--... -->
                <button type="submit" class="save-btn">Save</button>
            </form>
        </div>

        <!-- Rest of the code remains the same -->
                   <div id="ChangePassword" class="tabcontent">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" id="new_password" name="new_password" placeholder="Enter new password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
        </div>
        <button type="submit" class="save-btn">Update Password</button>
    </form>
</div>
                     
                </div>
                
            
            </div>
            </div>
            <script src="proUpdate.js"></script>
        </body>
        
        </html>
