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

// Retrieve posted data
$user_id = $_POST['user_id'];
$date = $_POST['date'];
$mode = $_POST['mode'];
$duration = $_POST['duration'];
$time_slot = $_POST['time_slot'];
$expertise = $_POST['expertise'];

// Prepare and execute SQL query
$sql = "SELECT u.id, u.full_name, u.counselor_pic, u.professional_expertise as experience, u.total_experience as texp
        FROM useravailability ua
        JOIN counsellor_registration u ON ua.user_id = u.id
        WHERE u.id = ?
        AND ('$mode' = '' OR ua.mode='$mode') 
        AND ('$time_slot' = '' OR ua.time_slot='$time_slot') 
        AND ('$duration' = '' OR ua.duration='$duration') 
        AND ('$date' = '' OR ua.date='$date')
        AND ('$expertise' = '' OR u.professional_expertise='$expertise')";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the counsellor details
$counsellor = $result->fetch_assoc();

// Add the filtered date, mode, and duration to the counsellor details
$counsellor['date'] = $date;
$counsellor['mode'] = $mode;
$counsellor['duration'] = $duration;

// Return the counsellor details as JSON
echo json_encode($counsellor);

// Close connection
$conn->close();
?>
