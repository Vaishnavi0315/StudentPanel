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
    <style>
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


header .brand-name {
    font-size: 1.5em;
    font-weight: bold;
    color: #1a1414;
    
}

header .user-profile {
    display: flex;
    align-items: center;
     color: #1a1414;
}

header .user-profile span {
    margin-right: 10px;
     color: #1a1414;
}

header .profile-icon {
    font-size: 1.5em;
}
.welcome {
    margin: 20px 0;
    text-align: center;
    background-color: #e9e9e9a6;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
     color: #1a1414;
}

.welcome h2 {
    margin: 0;
    font-size: 1.5em;
     color: #1a1414;
}

/* .card {
    margin: 20px auto; Add this line to center the card horizontally 
    width: 50%; Adjust the width to your liking
    justify-content: center;
    align-items: center;
    background-color: white;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    border-top: solid 2px brown;
    border-bottom: solid 2px brown;
} */
.card img {
    margin: 20px auto; /* Add this line to center the image horizontally */
    display: block; /* Add this line to center the image vertically */
    border-radius: 50%;
    width: 150px;
    height: 150px;
    object-fit: cover;
}

.card-content {
    display: center;
    flex-direction: column;
     color: #1a1414;
}
.card-content p {
    margin: 10px 0; /* Adjust the top and bottom margin to add space */
}

.card-content .std p {
    margin: 15px 0; /* Adjust the top and bottom margin to add space for .std p tags specifically */
}

.
.card-content p {
    margin: 5px 0;
}
.card-content p strong {
    display: inline-block;
    width: 180px;
}
.card-container {
  display: flex;
  justify-content: space-between;
  padding: 20px;
}
.card {
  width: 45%; /* Adjust the width to your liking */
  margin-right: 20px;
  background-color: white;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    border-top: solid 2px brown;
    border-bottom: solid 2px brown;
}

.session-container {
  width: 50%; /* Adjust the width to your liking */
  background-color: white;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    border-top: solid 2px brown;
    border-bottom: solid 2px brown;
}

.content-container {
   display: flex;
  flex-direction: column;
  flex-grow: 1;
  height: 100vh; /* Full height of the viewport */

}

.counsellor-info h3, .education-info h3 {
    margin-top: 0;
}


.session-info {
    display: flex;
    justify-content: space-between;
    padding: 5px;
  background-color: #efefefa6;
  border-radius: 5px;
  margin: 0px;
}

.session-box {
    background-color: white;
    padding: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: left;
    flex-grow: 1;
    margin: 0 10px;
    border-width: 3px;
    border-style: solid;
    border-radius: 5px;
    display: flex;
    justify-content: space-around;
    align-items: center;
}

.completed-session {
    border-color: #28a745;
  color: #28a745;
  display: flex;
  justify-content: space-around;
  align-items: center;
}

.ongoing-session {
    border-color: #ffc107;
    color: #ffc107;
}

.pending-session {
    border-color: #dc3545;
    color: #dc3545;
}

.session-box h3 {
    margin-top: 0;
    color: inherit;
}

.session-details {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.session-number {
    font-size: 24px;
    font-weight: bold;
    color: black;
}

.session-box img {
    width: 50px;
    height: 50px;
    object-fit: cover;
}
.circular-progress {
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 20px;
}

.circular-progress div[role="progressbar"] {
  --size: 12rem;
  --fg: #369;
  --bg: #def;
  --pgPercentage: var(--value);
  animation: growProgressBar 3s 1 forwards;
  width: var(--size);
  height: var(--size);
  border-radius: 50%;
  display: grid;
  place-items: center;
  background: 
    radial-gradient(closest-side, white 80%, transparent 0 99.9%, white 0),
    conic-gradient(var(--fg) calc(var(--pgPercentage) * 1%), var(--bg) 0)
    ;
  font-family: Helvetica, Arial, sans-serif;
  font-size: calc(var(--size) / 5);
  color: var(--fg);
}

.circular-progress div[role="progressbar"]::before {
  counter-reset: percentage var(--value);
  content: counter(percentage) '%';
}
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Assessment Test</title>
    <link rel="stylesheet" href="lan.css">
    <script src="lan.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   
    <!-- Flatpickr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
     <link rel="stylesheet" href="sideHead.css">
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
            <img src="ollato-logo.jpg" alt="Logo" class="sidebar-logo">
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
    <div class="welcome">
      <h3>Welcome, <?php echo htmlspecialchars($name); ?></h3>
    </div>
    <div class="card-container">
      <div class="card">
          <div class="welcome">
          <h3>Student Details</h3>
        </div>
        <img src="<?php echo htmlspecialchars($student_pic); ?>" alt="Student Picture">
        <div class="card-content">
          <!-- student information content -->
           <p><strong>Student ID:</strong> <?php echo htmlspecialchars($id); ?></p>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                    <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($dob); ?></p>
                    <p><strong>Gender:</strong> <?php echo htmlspecialchars($gender); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
                    <p><strong>School/Institute Name:</strong> <?php echo htmlspecialchars($school); ?></p>
                    <p><strong>Highest Qualification:</strong> <?php echo htmlspecialchars($qualification); ?></p>
               
        </div>
      </div>
      <div class="session-container">
        <div class="welcome">
          <h3>Assessment Details</h3>
        </div>
        <div class="session-info">
          <!-- session info content -->
          
                        <div class="circular-progress">
      <div role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="--value:65"></div>
    </div>
                        
        </div>
      </div>
    </div>
  </div>
</div>



    
</body>
</html>