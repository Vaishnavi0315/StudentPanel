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


$sql1 = "SELECT question_Text FROM stufeedQ";
if ($stmt = mysqli_prepare($link, $sql1)) {
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $num_questions = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_bind_result($stmt, $question_Text);
    $questions = array();
    while (mysqli_stmt_fetch($stmt)) {
        $questions[] = $question_Text;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Error fetching questions.";
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
    <title>Feedback</title>
    <style>
         /* Style the form */
 
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
     
}

body {
    display: flex;
    height: 100vh;
    background-color: #f4f4f4;
     font-family: Arial, sans-serif;
            margin: 0;
}

.sidebar {
    position: fixed; /* Makes the sidebar fixed */
    top: 0;
    left: 0;
    height: 100%;
    width: 250px; /* Adjust the width as needed */
    background-color: #644537;
    color: white;
    padding-top: 20px;
    overflow-y: auto; /* Allows scrolling if content overflows */
}

.sidebar-header {
    display: flex;
    flex-direction: column;
    align-items: center; /* Centers items horizontally */
}

.sidebar-logo {
  height: 100px;
  width: 100px;
  margin-bottom: 20px;
  background-color: #ede6e2;
  border-radius: 50%;
  overflow: hidden;
  box-shadow: 0 0 0 5px #ede6e2; /* Add this line to create a subtle border */
}

.nav-tabs {
    text-align: center;
    background-color: #5b5a5a; 
    margin-bottom: 10px;
    border-radius: 10px;
    padding: 10px 0;
}

.sidebar ul {
    list-style-type: none;
    padding-left: 0; /* Remove default padding */
}

.sidebar li {
    padding: 10px 0;
}

.sidebar a {
    color: white;
    text-decoration: none;
}

.sidebar ul li a:hover {
    background-color: #575757;
}
.collapse-btn, .logout {
    width: 80%;
    padding: 10px 0;
    margin: 10px 0;
    border: none;
    border-radius: 50px;
    text-align: center;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: grey;
}
 .logout {
            background-color: #a08b82;
            color: white;
        }

.logout i {
    margin-right: 10px;
}
header {
    position: fixed; /* Set position to fixed */
    top: 0; /* Set top to 0 to align with the top of the page */
    left: 250px; /* Set left to 250px to align with the end of the sidebar */
    width: calc(100% - 250px); /* Set width to fill the remaining space */
    background-color: #ffffff; /* White background color */
    color: grey;
    display: flex;
    align-items: center;
    padding: 0.5em 20px;
    justify-content: space-between;
    height: 64px; /* Fixed header height */
    margin-bottom: 20px;
    border-bottom: 3px solid #ccc; /* Optional: add a bottom border for separation */
    z-index: 1000; /* Add this line to bring the header to the front */
}

.brand-name {
    font-size: 1.5em;
    flex-grow: 1;
    text-align: left;
     color: #1a1414;
}

.user-profile {
    display: flex;
    align-items: center;
    color: #1a1414;
}

.user-profile span {
    margin-right: 10px;
     color: #1a1414;
}
.content {
    margin-left: 250px; /* Same as the sidebar width plus some space */
    
    padding: 80px;
    flex-grow: 1; /* Allows the content to grow and take up remaining space */
    
}
#feedback-form {
  position: relative; /* Ensures the pseudo-element is positioned correctly */
  width: 50%;
  height: auto;
  margin: 20px auto;
  padding: 20px 30px 10px 40px;
  
  border-radius: 10px;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
  background-color: white;
  
  background-repeat: no-repeat;
  background-position: center;
  background-size: contain;
  z-index: 1; /* border: 1px solid #ccc; Ensures content stays above the overlay */
}

#feedback-form::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%; 
  background-repeat: no-repeat;
  background-position: bottom;
  background-size: contain;
  opacity: 0.2; /* 
 Adjust this value to set desired opacity */
  z-index: -1; /* Ensures the overlay stays behind the content */
  border-radius: 10px; /*  Match the border-radius of the form */
}
h3 {
            text-align: center;
            font-size: 22px; /* Font size */
            margin-top: 5px; /* Space above */
            margin-bottom: 5px; /* Space below */
            padding: 8px; /* Padding inside the element */
            border-radius: 5px; /* Rounded corners */
           
        } 
      

.question {
  margin-bottom: 20px;
}

.question label {
  display: block;
  margin-bottom: 10px;
  font-weight: bold;
  font-size: 18px;
}

.question input[type="radio"] {
  margin-right: 10px;
}

.rating {
  margin-bottom: 20px;
  display: flex;
  flex-direction: row-reverse;
  justify-content: flex-end;
  border-radius: 50px;
}

.rating input[type="radio"] {
  display: none;
}

.rating label {
  font-size: 30px; /* Increase font size to make stars bigger */
  cursor: pointer;
  color: #333333;
  margin: 0 30px; /* Reduce margin to make stars closer together */
  transition: transform 0.2s; /* Add transition effect */
  transform: rotateY(20deg); /* Add a slight curve to the stars */
}

.rating label:hover,
.rating label:hover ~ label {
 color: #FF9900;
  transform: scale(1.2) rotateY(20deg); /* Increase size and maintain curve on hover */
}

.rating input[type="radio"]:checked ~ label {
 color: #FF9900;
  transform: rotateY(20deg); /* Maintain curve when checked */
}

.comments {
  margin-bottom: 10px;
}

.comments label {
  display: block;
  margin-bottom: 10px;
  font-weight: bold;
  font-size: 18px;
}

.comments textarea {
  width: 100%;
  height: 50px;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 5px;
  resize: vertical;
  box-shadow: 0 0 3px rgba(0, 0, 0, 0.1);
  background-color: transparent;
}

.submit-btn {
  background-color: #007bff;
  color:white;
  padding: 10px 20px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
  display: block;
  margin: 20px auto;
  text-align: center;
}

.submit-btn:hover {
  background-color: #0069d9;
}
      
      
      
    </style>
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
         
    <div class="content">
    <header>
                <div class="brand-name">Ollato's Mind Mapping Programme</div>
                <div class="user-profile">
                   <?php echo $name; ?></span>
                    <i class="fas fa-user profile-icon"></i>
                </div>
            </header>
   <form action="feedbackform1.php" id="feedback-form" method="post">
       <br>
  <h3 style="text-align: center;">Please let us know your thoughts on our service.</h3>
    <br>
    <div style="border-bottom: 2px solid #ccc; margin: 10px 0;"></div>
    <p  style="text-align: center;"></p>
    <br>
    <?php $i = 1; foreach ($questions as $question) { ?>
        <div class="question">
            <label for="<?php echo $question; ?>"><?php echo $question; ?></label>
            <div class="rating">
                <input type="radio" id="<?php echo $question;?>-star5" name="q<?php echo $i;?>" value="5">
                <label for="<?php echo $question;?>-star5">&#9733;</label>
                <input type="radio" id="<?php echo $question;?>-star4" name="q<?php echo $i;?>" value="4">
                <label for="<?php echo $question;?>-star4">&#9733;</label>
                <input type="radio" id="<?php echo $question;?>-star3" name="q<?php echo $i;?>" value="3">
                <label for="<?php echo $question;?>-star3">&#9733;</label>
                <input type="radio" id="<?php echo $question;?>-star2" name="q<?php echo $i;?>" value="2">
                <label for="<?php echo $question;?>-star2">&#9733;</label>
                <input type="radio" id="<?php echo $question;?>-star1" name="q<?php echo $i;?>" value="1">
                <label for="<?php echo $question;?>-star1">&#9733;</label>
            </div>
        </div>
    <?php $i++; } ?>
    <!-- Additional Comments -->
    
    <div style="border-bottom: 2px solid #ccc; margin: 10px 0;"></div>
    <br>
    <div class="comments">
        <label for="comments" style="text-align: center;">Additional Comments:</label>
        <textarea id="comments" name="comments"></textarea>
    </div>
    <!-- Std_id input field -->
    <input type="hidden" name="std_id" value="<?php echo $id; ?>">
    <!-- Submit Button -->
    <button class="submit-btn"type="submit" value="Submit &nbsp;" onclick="SaveNext()" >Submit</button> 
</form>
     </div>
</body>
</html>