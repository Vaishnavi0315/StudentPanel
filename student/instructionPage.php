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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   
    <title>Student Assessment Test</title>
    <link rel="stylesheet" href="instructionPg.css">
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
                <li><a href="feedbackform.html"><i class="fa-solid fa-comments"></i> FeedBack</a></li>
                <li><a href="updatePro.php"><i class="fa-solid fa-user"></i> Edit Profile</a></li>
                 <button class="collapse-btn"><i class="fas fa-angle-left"></i></button>
                <button class="logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </ul>
        </div>
    </div>
    <div class="main-container">
        <header>
                <div class="brand-name">Ollato's Mind Mapping Programme</div>
                <div class="user-profile">
                  <span><?php echo $name; ?></span>
                    <i class="fas fa-user profile-icon"></i>
                </div>
            </header>
        <div class="container">
            
            <h1>Welcome to the Assessment</h1>
            <p>Please read the instructions carefully before starting the assessment.</p>
        </div>
        <div class="instructions">
            <h2>Instructions:</h2>
            <ol>
                <li>Make sure you have a stable internet connection.</li>
                <li>Read each question carefully before answering.</li>
                <li>You cannot go back to the previous question once you move to the next one.</li>
                <li>There is a time limit of 60 minutes to complete the assessment.</li>
                <li>Do not refresh or close the browser window during the assessment.</li>
            </ol>
             <button class="start-button" id="start-button">Start Assessment</button>
        </div>
       
    </div>
    <script src="instructionPg2.js"></script>
</body>
</html>