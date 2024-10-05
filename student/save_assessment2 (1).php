<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION["id"])) {
        $user_id = $_SESSION["id"];
        $questions = [];

        // Collect all question responses from POST data
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'q') === 0) {
                $questions[$key] = $value;
            }
        }

        if (count($questions) > 0) {
            // Prepare question numbers and answers
            $questionNumbers = array_keys($questions);
            $questionAnswers = array_values($questions);

            // Check if a record for the current user already exists
            $checkSql = "SELECT user_id FROM assessments WHERE user_id = ?";
            if ($stmt = mysqli_prepare($link, $checkSql)) {
                mysqli_stmt_bind_param($stmt, "s", $user_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) > 0) {
                    // Update existing record
                    $updateFields = [];
                    foreach ($questionNumbers as $questionNumber) {
                        $updateFields[] = "$questionNumber = ?";
                    }
                    $updateSql = "UPDATE assessments SET " . implode(", ", $updateFields) . " WHERE user_id = ?";
                    if ($updateStmt = mysqli_prepare($link, $updateSql)) {
                        $types = str_repeat("s", count($questionNumbers)) . "s";
                        $values = array_merge($questionAnswers, [$user_id]);
                        mysqli_stmt_bind_param($updateStmt, $types, ...$values);
                        if (mysqli_stmt_execute($updateStmt)) {
                            echo 'Data updated successfully';
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        mysqli_stmt_close($updateStmt);
                    } else {
                        echo "Error in SQL preparation: " . mysqli_error($link);
                    }
                } else {
                    // Insert new record
                    $columns = implode(", ", $questionNumbers);
                    $placeholders = implode(", ", array_fill(0, count($questionNumbers), "?"));
                    $insertSql = "INSERT INTO assessments (user_id, $columns) VALUES (?, $placeholders)";
                    if ($insertStmt = mysqli_prepare($link, $insertSql)) {
                        $types = "s" . str_repeat("s", count($questionNumbers));
                        $values = array_merge([$user_id], $questionAnswers);
                        mysqli_stmt_bind_param($insertStmt, $types, ...$values);
                        if (mysqli_stmt_execute($insertStmt)) {
                            echo 'Data stored successfully';
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        mysqli_stmt_close($insertStmt);
                    } else {
                        echo "Error in SQL preparation: " . mysqli_error($link);
                    }
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "Error in SQL preparation: " . mysqli_error($link);
            }
        } else {
            echo "No question data received.";
        }
    } else {
        echo "No user ID found in session.";
    }
}

mysqli_close($link);
?>
