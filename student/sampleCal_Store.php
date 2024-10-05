<?php
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

// Create new table if not exists
$sql = "CREATE TABLE IF NOT EXISTS user_assessment_summary (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE,
    never INT,
    rarely INT,
    sometimes INT,
    often INT,
    total INT
)";
if ($conn->query($sql) === FALSE) {
    die("Error creating table: " . $conn->error);
}

// Initialize variables to hold counts
$neverCount = 0;
$rarelyCount = 0;
$sometimesCount = 0;
$oftenCount = 0;
$totalCount = 0;

// Get distinct user IDs
$sql = "SELECT DISTINCT user_id FROM assessments";
$userResult = $conn->query($sql);

if ($userResult->num_rows > 0) {
    while ($userRow = $userResult->fetch_assoc()) {
        $user_id = $userRow['user_id'];
        $neverCount = 0;
        $rarelyCount = 0;
        $sometimesCount = 0;
        $oftenCount = 0;
        $totalCount = 0;

        // Iterate through each question column
        for ($i = 1; $i <= 100; $i++) {
            $q = 'q' . $i;
            $sql = "SELECT $q FROM assessments WHERE user_id = $user_id";
            $questionResult = $conn->query($sql);

            if ($questionResult->num_rows > 0) {
                while ($questionRow = $questionResult->fetch_assoc()) {
                    if ($questionRow[$q] == 'never') {
                        $neverCount++;
                    } elseif ($questionRow[$q] == 'rarely') {
                        $rarelyCount++;
                    } elseif ($questionRow[$q] == 'sometimes') {
                        $sometimesCount++;
                    } elseif ($questionRow[$q] == 'often') {
                        $oftenCount++;
                    }
                }
            }
        }

        // Calculate total count
        $totalCount = $neverCount + $rarelyCount + $sometimesCount + $oftenCount;

        // Check if user_id already exists in the summary table
        $checkSql = "SELECT * FROM user_assessment_summary WHERE user_id = $user_id";
        $checkResult = $conn->query($checkSql);

        if ($checkResult->num_rows > 0) {
            // Update existing record
            $sql = "UPDATE user_assessment_summary SET 
                        never = $neverCount, 
                        rarely = $rarelyCount, 
                        sometimes = $sometimesCount, 
                        often = $oftenCount,
                        total = $totalCount
                    WHERE user_id = $user_id";
        } else {
            // Insert new record
            $sql = "INSERT INTO user_assessment_summary (user_id, never, rarely, sometimes, often, total)
                    VALUES ($user_id, $neverCount, $rarelyCount, $sometimesCount, $oftenCount, $totalCount)";
        }

        if ($conn->query($sql) === FALSE) {
            die("Error updating data for user $user_id: " . $conn->error);
        }
    }
    echo "Data processed successfully!";
} else {
    echo "No users found in assessments table.";
}

$conn->close();
?>