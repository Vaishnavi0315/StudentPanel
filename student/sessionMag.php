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

$sql = "SELECT counsellor_id, b_time_slot, b_date, b_mode, b_duration 
        FROM session_management 
        WHERE student_id = (SELECT id FROM stdregistration WHERE email = ?)";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
mysqli_stmt_bind_result($stmt, $counsellor_id, $b_time_slot, $b_date, $b_mode, $b_duration);

$rescheduled_data = array();
$sr_no = 1;
while (mysqli_stmt_fetch($stmt)) {
    $rescheduled_data[] = array(
        'sr_no' => $sr_no,
        'counsellor_id' => $counsellor_id,
        'b_time_slot' => $b_time_slot,
        'b_date' => $b_date,
        'b_mode' => $b_mode,
        'b_duration' => $b_duration
    );
    $sr_no++;
}

mysqli_stmt_close($stmt);

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
   
    <title>Student Management Admin Portal</title>
    <link rel="stylesheet" href="sessionMag.css" />
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="uploads/ollato.png" alt="Logo" class="sidebar-logo">
            
        
        <ul>
                <li class="nav-tabs">Welcome!</li>
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
    
    <div class="main-content">
        <header>
                <div class="brand-name">Ollato's Mind Mapping Programme</div>
                <div class="user-profile">
                   <!-- <span><?php echo $full_name; ?></span>-->
                    <i class="fas fa-user profile-icon"></i>
                </div>
            </header>
            
            
        <h2>Session Management</h2>
        <div class="search">
            <div>
                <label for="search">Search:</label>
                <input type="text" id="search" placeholder="Search....">
            </div>
        </div>
        <div class="tabs">
            <a href="#booked" class="tab-link">Booked</a>
            <a href="#ongoing" class="tab-link">Ongoing</a>
            <a href="#pending" class="tab-link">Requested</a>
            <a href="#cancel" class="tab-link active">Cancel</a>
            <a href="#rescheduled" class="tab-link">Rescheduled</a>
            <a href="#completed" class="tab-link">Completed</a>
        </div>
        <div id="booked" class="tab-content">
            <h3>Booked session</h3>
        <div class="content">
        <table>
            <thead>
                <tr>
                    <th>SR No</th>
                    <th>COUNSELLORS ID</th>
                    <th>DATE & TIME</th>
                    <th>MODE</th>
                    <th>DURATION</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rescheduled_data as $row) { ?>
                <tr>
                    <td><?php echo $row['sr_no']; ?></td>
                    <td><?php echo $row['counsellor_id']; ?></td>
                    <td><?php echo $row['b_date']; ?> <?php echo $row['b_time_slot']; ?></td>
                    <td><?php echo $row['b_mode']; ?></td>
                    <td><?php echo $row['b_duration']; ?></td>
                    <td><button class="edit">Reschedule</button></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
        </div>
        <div id="ongoing" class="tab-content">Ongoing Content</div>
        <div id="pending" class="tab-content">Requested Sessions</div>
        <div id="rescheduled" class="tab-content">
    <h3>Rescheduled</h3>
    <div class="content">
        <table>
            <thead>
                <tr>
                    <th>SR No</th>
                    <th>COUNSELLORS ID</th>
                    <th>DATE & TIME</th>
                    <th>MODE</th>
                    <th>DURATION</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rescheduled_data as $row) { ?>
                <tr>
                    <td><?php echo $row['sr_no']; ?></td>
                    <td><?php echo $row['counsellor_id']; ?></td>
                    <td><?php echo $row['b_date']; ?> <?php echo $row['b_time_slot']; ?></td>
                    <td><?php echo $row['b_mode']; ?></td>
                    <td><?php echo $row['b_duration']; ?></td>
                    <!-- <td><button class="edit">Reschedule</button></td> -->
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>


        <div id="completed" class="tab-content">Completed Content</div>
       
    </div>
        <div id="cancel" class="tab-content active">
            <h3>Cancel Session</h3>
        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>SR No</th>
                        <th>COUNSELLOR ID</th>
                        <th>APPOINTMENT DATE</th>
                        <th>MODE</th>
                        <th>DURATION</th>
                        <th>FROM TIME</th>
                        <th>END TIME</th>
                        <th>STATUS</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>6</td>
                        <td>2</td>
                        <td>2022-08-16</td>
                        <td>CHAT</td>
                        <td>60</td>
                        <td>00:00:10</td>
                        <td>00:00:00</td>
                        <td>cancel</td>
                        <td><button class="edit">Edit</button></td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>2</td>
                        <td>2022-08-16</td>
                        <td>CHAT</td>
                        <td>60</td>
                        <td>00:00:10</td>
                        <td>00:00:00</td>
                        <td>cancel</td>
                        <td><button class="edit">Edit</button></td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>2</td>
                        <td>2022-08-16</td>
                        <td>CHAT</td>
                        <td>60</td>
                        <td>00:00:10</td>
                        <td>00:00:00</td>
                        <td>cancel</td>
                        <td><button class="edit">Edit</button></td>
                    </tr>
                </tbody>
            </table>
            
        </div>
        
   <div id="reschedule-popup" class="" style="display: none;">
    <!-- popup content will go here -->
    <h2>Reschedule Session</h2>
    <form>
        <!-- form fields will go here -->
        <label for="new-date">New Date:</label>
        <input type="date" id="new-date" name="new-date">
        <label for="new-time">New Time:</label>
        <input type="time" id="new-time" name="new-time">
        <button type="submit">Reschedule</button>
    </form>
</div>
    
    <script src="sessionMag.js"></script>
 
</body>
</html>