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
<html>
<head>
    <style>
        /* Add your styles here */
       
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

body {
    display: flex;
    height: 100vh;
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
    position: absolute; /* Set position to absolute */
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

.boxx {
    display: none;
}

.boxx.active {
    display: block;
}

.content {
    margin-left: 250px; /* Same as the sidebar width plus some space */
    padding: 80px ;
    flex-grow: 1; /* Allows the content to grow and take up remaining space */
    background-color: #f4f4f4;
}

h2 {
    margin-bottom: 20px;
    background-color: #E9DCC9;
    padding: 10px;
}
        .search-counsellor {
            padding: 20px;
            margin-bottom: 30px;
            position: relative;
        }
        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            align-items: flex-start;
        }
        .filters > div {
            display: flex;
            flex-direction: column;
        }
        .filters label {
            margin-bottom: 5px;
        }
        .filters select, .filters input[type="date"] {
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            width: 180px;
        }
        .filters button {
            background-color: #337ab7;
            color: white;
            border: none;
            margin-top: 25px;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        .filters button:hover {
            background-color: #629ed2;
        }
        .counsellors {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 30px;
        }
        .counsellor-card {
            background-color: #d1f0f5;
            border: 1px solid #070707;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: 300px;
        }
        .counsellor-card img {
            border-radius: 50%;
            width: 80px;
            height: 80px;
            margin-bottom: 10px;
        }
        .counsellor-card h3 {
            margin-bottom: 10px;
        }
        .counsellor-card button {
            background-color: #337ab7;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        /* Styles for the popup */
/* Styles for the popup */
.popup {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 40%;
    transform: translate(-50%, -50%);
    background-color: #ffffff;
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    display: none;
}

.popup h2 {
    margin-top: 0;
    margin-bottom: 10px;
}

/* Flexbox layout for the first row of labels and inputs */
.popup .first-row {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.popup .first-row label {
    width: 45%;
}

.popup .first-row input[type="text"] {
    width: 45%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 10px;
}

.popup form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.popup label {
    margin-bottom: 5px;
    width: 100%;
}

.popup input[type="text"], .popup input[type="date"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 100%;
    margin-bottom: 10px;
}

.popup button[type="submit"] {
    background-color: #4CAF50;
    color: #ffffff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.popup button[type="submit"]:hover {
    background-color: #3e8e41;
}

/* Close button as X at the top right corner */
.popup .popup-close {
    position: absolute;
    top: 20px;
    right: 40px;
    background-color: transparent;
    color: #d9534f;
    border: none;
    font-size: 40px;
    cursor: pointer;
}

.popup .popup-close:hover {
    color: #c9302c;
}

/* Styles for other details in column layout */
.popup .other-details {
    width: 100%;
}

    </style>
     <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
                <li><a href="updatePro.html"><i class="fa-solid fa-user"></i> Edit Profile</a></li>
                <button class="collapse-btn"><i class="fas fa-angle-left"></i></button>
                <button class="logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
           </ul>
    </div>
</div>

<div class="content">
    <header>
                <div class="brand-name">Ollato's Mind Mapping Programme</div>
                <div class="user-profile">
                    <span><?php echo $name; ?></span>
                    <i class="fas fa-user profile-icon"></i>
                </div>
            </header>
    <h2>Book Session</h2>
    <form method="post" action="" class="search-counsellor" id="filter-form">
        <div class="filters">
            <div>
                <label for="mode">Select mode: <span class="required-field">*</span></label>
                <select id="mode" name="mode">
                    <option value="" selected disabled>Select a mode</option>
                    <option value="chat">Chat</option>
                    <option value="video-call">Video Call</option>
                    <option value="calling">Calling</option>
                    <option value="in-person">In Person</option>
                </select>
            </div>
            <div>
                <label for="time_slot">Select time slot: <span class="required-field">*</span></label>
                <select id="time_slot" name="time_slot">
                    <option value="" selected disabled>Select a time slot</option>
                    <option value="09:00:00">09:00:00</option>
                    <option value="10:00:00">10:00:00</option>
                    <option value="11:00:00">11:00:00</option>
                    <option value="12:00:00">12:00:00</option>
                    <option value="13:00:00">13:00:00</option>
                    <option value="14:00:00">14:00:00</option>
                    <option value="15:00:00">15:00:00</option>
                    <option value="16:00:00">16:00:00</option>
                    <option value="17:00:00">17:00:00</option>
                    
                </select>
            </div>
            <div>
                <label for="duration">Select duration: <span class="required-field">*</span></label>
                <select id="duration" name="duration">
                    <option value="" selected disabled>Select a duration</option>
                    <option value="40">40 minutes</option>
                    <option value="60">60 minutes</option>
                </select>
            </div>
            <div>
                <label for="date">Select date: <span class="required-field">*</span></label>
                <input type="date" id="date" name="date">
            </div>
            <div>
                <label for="expertise">Select expertise: <span class="required-field">*</span></label>
                <select id="expertise" name="expertise">
                    <option value="" selected disabled>Select an expertise</option>
                    <option value="Career Counsellor">Career Counsellor</option>
                    <option value="Psychologist">Psychologist</option>
                    <option value="Group Counsellor">Group Counsellor</option>
                </select>
            </div>
            <button type="submit" id="filter-btn">Submit</button>
        </div>
    </form>

    <div class="counsellors">
    <?php
    // Database connection
    $servername = 'localhost';
    $username = 'ollatoin_oneminduser';
    $password = 'ollato@2020';
    $dbname = 'ollatoin_onemind';

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Initialize variables
    $mode = $_POST['mode'] ?? '';
    $time_slot = $_POST['time_slot'] ?? '';
    $duration = $_POST['duration'] ?? '';
    $date = $_POST['date'] ?? '';
    $expertise = $_POST['expertise'] ?? '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Prepare SQL query
  $sql = "SELECT u.id, u.full_name, u.counselor_pic, u.professional_expertise as experience, u.total_experience as texp
          FROM useravailability ua 
          JOIN counsellor_registration u ON ua.user_id = u.id 
          WHERE ('$mode' = '' OR ua.mode='$mode') 
          AND ('$time_slot' = '' OR ua.time_slot='$time_slot') 
          AND ('$duration' = '' OR ua.duration='$duration') 
          AND ('$date' = '' OR ua.date='$date') 
          AND ('$expertise' = '' OR u.professional_expertise='$expertise')";


  // Execute query
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
  echo '<div class="counsellor-card">';
  echo '<img src="'. $row["counselor_pic"]. '" alt="Profile Picture">';
  echo '<h3>'. $row["full_name"]. '</h3>';
  echo '<button onclick="bookNow(this, '. $row["id"]. ', \''. $row["experience"]. '\', \''. $row["texp"]. '\', \''. $_POST['date']. '\', \''. $_POST['mode']. '\', \''. $_POST['duration']. '\')">Book Now</button>';
  echo '</div>';
}
  } else {
    echo '<p>No counselors found.</p>';
  }
}
/*
    // Prepare SQL query
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $sql = "SELECT DISTINCT u.id, u.full_name, u.counselor_pic 
                FROM useravailability ua 
                JOIN counsellor_registration u ON ua.user_id = u.id 
                WHERE ('$mode' = '' OR ua.mode='$mode') 
                AND ('$time_slot' = '' OR ua.time_slot='$time_slot') 
                AND ('$duration' = '' OR ua.duration='$duration') 
                AND ('$date' = '' OR ua.date='$date') 
                AND ('$expertise' = '' OR u.professional_expertise='$expertise')";
    } else {
        $sql = "SELECT DISTINCT u.id, u.full_name, u.counselor_pic, u.total_experience 
                FROM useravailability ua 
                JOIN counsellor_registration u ON ua.user_id = u.id";
    }
   

    // Execute query
    $result = $conn->query($sql);
    

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo '<div class="counsellor-card">';
            echo '<img src="' . $row["counselor_pic"] . '" alt="Profile Picture">';
            echo '<h3>' . $row["full_name"] . '</h3>';
            echo '<button onclick="bookNow(' . $row["id"] . ')">Book Now</button>';
            echo '</div>';
        }
    } else {
        echo '<p>No counselors found.</p>';
    }
*/
    // Close connection
    $conn->close();
 ?>
</div>


<div class="popup" id="popup">
    <button type="button" class="popup-close" onclick="closePopup()">&times;</button>
    <h2>Book Session Details</h2>
    <form method="post" action="pay.php">
      <div class="first-row">
        <input type="hidden" id="user_id" name="user_id" >
        <label class="poplabel" for="counsellor_name">Counsellor Name:</label>
        <input type="text" id="counsellor_name" name="counsellor_name" readonly >
        <label class="poplabel" for="counsellor_id">Counsellor ID:</label>
        <input type="text" id="counsellor_id" name="counsellor_id" readonly >
        <label class="poplabel" for="experience">Expertise:</label>
        <input type="text" id="experience" name="experience" readonly >
        <label class="poplabel" for="texp">Total Experience:</label>
        <input type="text" id="texp" name="texp" readonly >
        </div>
        
        <div class="other-details">
    <label for="date">Date:</label>
    <input type="text" id="booking_date" name="date" readonly value="<?php echo $_POST['date']; ?>" >
    <label for="mode">Mode:</label>
    <input type="text" id="booking_mode" name="mode" readonly value="<?php echo $_POST['mode']; ?>" >
    <label for="duration">Duration:</label>
    <input type="text" id="booking_duration" name="duration" readonly value="<?php echo $_POST['duration']; ?>" >
    <input type="hidden" name="time_slot" value="<?php echo $_POST['time_slot']; ?>">
</div>
<button type="submit">Pay Now (Rs. 800)</button>
    </form>
</div>


   

</div>

<script>
  var date, mode, duration;

 
var selectedCounselor = {};

function bookNow(button, userId, expertise, texp, date, mode, duration) {
  // Get the counselor details from the HTML elements
  var counselorName = button.parentNode.querySelector('h3').textContent;
  var counselorPic = button.parentNode.querySelector('img').src;

  // Store the details in the selectedCounselor object
  selectedCounselor = {
    userId: userId,
    counselorName: counselorName,
    counselorPic: counselorPic,
    expertise: expertise,
    texp: texp,
    date: date,
    mode: mode,
    duration: duration
  };

  // Populate the popup form
  document.getElementById('user_id').value = selectedCounselor.userId;
  document.getElementById('counsellor_name').value = selectedCounselor.counselorName;
  document.getElementById('counsellor_id').value = selectedCounselor.userId;
  document.getElementById('experience').value = selectedCounselor.expertise;
  document.getElementById('texp').value = selectedCounselor.texp;
  document.getElementById('booking_date').value = selectedCounselor.date;
  document.getElementById('booking_mode').value = selectedCounselor.mode;
  document.getElementById('booking_duration').value = selectedCounselor.duration;

  // Show the popup
  var popup = document.getElementById('popup');
  popup.style.display = 'block';
}
document.getElementById('filter-btn').addEventListener('click', function(event) {
  event.preventDefault(); // Prevent form submission

  // Get the selected values
  date = document.getElementById('date').value;
  mode = document.getElementById('mode').value;
  duration = document.getElementById('duration').value;

  // Submit the form
  document.getElementById('filter-form').submit();
});
function closePopup() {
    var popup = document.getElementById('popup');
    popup.style.display = 'none';
}

// Add event listener to logout button
document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('.logout').addEventListener('click', logout);
});

function logout() {
    window.location.href = 'logout.php';
}

        // Add event listener to logout button
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('.logout').addEventListener('click', logout);
        });
</script>

</body>
</html>