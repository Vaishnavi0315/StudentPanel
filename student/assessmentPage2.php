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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Student Assessment Test</title>
    <style>
        /* Hide the assessment sections by default */
        .assessment {
            display: none;
        }

        /* Display active assessment sections */
        .assessment.active {
            display: block;
        }

        /* Table styles with increased width and rounded corners */
        .assessment table {
            width: 100%;
            top: 150px; 
            border-collapse: collapse;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            border-radius: 10px; /* Rounded corners */
            overflow: hidden; /* Ensures rounded corners display properly */
        }

        /* Header (th) and Cell (td) styles with increased text size */
        .assessment th, .assessment td {
             
            border: 1px solid #ddd;
            padding: 12px; /* Adjust padding as needed */
            text-align: left;
            font-size: 16px; /* Increase text size */
            position: relative; /* Added for full cell clickability */
        }

        /* Radio button styles */
        .assessment table input[type="radio"] {
            transform: scale(1.6); /* Increase radio button size */
            margin-right: 5px; /* Space between radio button and label */
        }

        /* Label styles to make entire cell clickable */
        .assessment table label {
            display: block;
            width: 100%;
            height: 100%;
            cursor: pointer; /* Change cursor to pointer to indicate clickability */
            padding: 12px; /* Same padding as cell */
            box-sizing: border-box;
        }

        /* Buttons container */
        .buttons {
            display: flex; /* Flexbox for button layout */
            justify-content: space-between; /* Space evenly between buttons */
            margin-top: 10px;/* Margin above buttons */
            
        }

        /* Save button style */
        .save_btn {
            padding: 10px 20px; /* Padding inside buttons */
            font-size: 16px; /* Button text size */
            background-color: #4CAF50; /* Button background color */
            color: white; /* Button text color */
            border: none; /* Remove button border */
            cursor: pointer; /* Cursor style */
            margin-bottom: 20px;
            border-radius: 10px;
        }
        
      
        /* Save button hover effect */
        .save_btn:hover {
            opacity: 0.8; /* Reduce opacity on hover */
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
     color: #1a1414;
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
    <link rel="stylesheet" href="newAssess.css">
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
                    <span><?php echo $name; ?></span>
                    <i class="fas fa-user profile-icon"></i>
                </div>
            </header>
        <!-- Progress bar container -->
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%" id="progressBar"></div>
        </div>
        <h2>Student Assessment Test</h2>
        <div class="boxx assessment active" id="assess1">
            <form id="assessment-form1" action="save_assessment2.php" method="post">
                <table id="questionsTable1" border="1">
                    <thead>
                        <tr>
                            <th>SR No</th>
                            <th>Question</th>
                            <th>Never</th>
                            <th>Rarely</th>
                            <th>Sometimes</th>
                            <th>Often</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Table body rows will be populated dynamically -->
                    </tbody>
                </table>
                <div class="buttons">
                    <input class="save_btn" type="button" value="Previous" id="prevBtn" onclick="Previous(1)">
                    <input class="save_btn" type="button" value="Save and Next" onclick="SaveNext(1)">
                </div>
            </form>
        </div>
    </div>

    <script>
        let totalQuestions = 0;
        let answeredQuestions = new Set();

        document.addEventListener('DOMContentLoaded', function() {
            fetchQuestionsAndPopulateTables();
        });

        function fetchQuestionsAndPopulateTables() {
            fetch('fetch_data.php')
                .then(response => response.json())
                .then(data => {
                    totalQuestions = data.length;
                    const maxQuestionsPerTable = 10;
                    const contentDiv = document.querySelector('.content');

                    let tableIndex = 1;
                    let questionCount = 0;
                    let totalTables = Math.ceil(totalQuestions / maxQuestionsPerTable);

                    data.forEach((question, index) => {
                        if (questionCount === 0) {
                            createNewTableSection(tableIndex, totalTables);
                            tableIndex++;
                        }

                        const tableId = 'questionsTable' + (tableIndex - 1);
                        const table = document.getElementById(tableId);
                        const row = table.insertRow();
                        row.insertCell(0).innerText = question.questionNo;
                        row.insertCell(1).innerText = question.questionText;
                        for (let i = 0; i < 4; i++) {
                            const cell = row.insertCell(i + 2);
                            const label = document.createElement('label');
                            const radio = document.createElement('input');
                            radio.type = 'radio';
                            radio.name = 'q' + question.questionNo;
                            radio.value = ['never', 'rarely', 'sometimes', 'often'][i];
                            radio.addEventListener('change', updateProgress);
                            label.appendChild(radio);
                            cell.appendChild(label);
                        }

                        questionCount++;
                        if (questionCount >= maxQuestionsPerTable) {
                            questionCount = 0;
                        }
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        function createNewTableSection(tableIndex, totalTables) {
            const newBox = document.createElement('div');
            newBox.classList.add('boxx', 'assessment');
            newBox.id = 'assess' + tableIndex;

            const newForm = document.createElement('form');
            newForm.id = 'assessment-form' + tableIndex;
            newForm.method = 'post';
            newForm.action = 'save_assessment2.php';

            const newTable = document.createElement('table');
            newTable.id = 'questionsTable' + tableIndex;
            newTable.border = '1';

            const headerRow = document.createElement('tr');
            ['SR No', 'Question', 'Never', 'Rarely', 'Sometimes', 'Often'].forEach(text => {
                const th = document.createElement('th');
                th.innerText = text;
                headerRow.appendChild(th);
            });
            newTable.appendChild(headerRow);

            newForm.appendChild(newTable);

            const buttonDiv = document.createElement('div');
            buttonDiv.classList.add('buttons');
            
            
            const prevButton = document.createElement('input');
            prevButton.classList.add('save_btn');
            prevButton.type = 'button';
            prevButton.value = 'Previous';
            prevButton.onclick = () => Previous(tableIndex);
            
            if (tableIndex === 1) {
                
                prevBtn.disabled = true; // Add this line to disable the button
                prevBtn.style.cursor = 'not-allowed'; // Add this line to change the cursor style
            } 

            const nextButton = document.createElement('input');
            nextButton.classList.add('save_btn');
            nextButton.type = 'button';

            if (tableIndex === totalTables) {
                nextButton.value = 'Save and End';
                nextButton.onclick = () => SaveEnd(tableIndex);
            } else {
                nextButton.value = 'Save and Next';
                nextButton.onclick = () => SaveNext(tableIndex);
            }

            buttonDiv.appendChild(prevButton);
            buttonDiv.appendChild(nextButton);
            newForm.appendChild(buttonDiv);

            newBox.appendChild(newForm);
            document.querySelector('.content').appendChild(newBox);
        }

        function Previous(currentIndex) {
            const currentDiv = document.getElementById('assess' + currentIndex);
            currentDiv.classList.remove('active');
            const prevIndex = currentIndex - 1;
            const prevDiv = document.getElementById('assess' + prevIndex);
            if (prevDiv) {
                prevDiv.classList.add('active');
            }
        }

        function SaveNext(currentIndex) {
    const formId = 'assessment-form' + currentIndex;
    const form = document.getElementById(formId);

    if (!form) {
        console.error(`Form element with ID '${formId}' not found.`);
        return;
    }

    const formData = new FormData(form);

    const tableId = 'questionsTable' + currentIndex;
    const table = document.getElementById(tableId);
    const radioButtons = table.querySelectorAll('input[type="radio"]');
    const answeredRadioButtons = Array.from(radioButtons).filter(radio => radio.checked);

   

    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // Check if all questions on the current page have been answered
    if (answeredRadioButtons.length < 10) { // Assuming 4 options per question
        alert('Please answer all questions on this page before proceeding.');
        return;
    }
        const currentDiv = document.getElementById('assess' + currentIndex);
        currentDiv.classList.remove('active');
        const nextIndex = currentIndex + 1;
        const nextDiv = document.getElementById('assess' + nextIndex);
        if (nextDiv) {
            nextDiv.classList.add('active');
              
            
        }
        
       
    })
    .catch(error => console.error('Error submitting form:', error));
}


function SaveEnd(currentIndex) {
    const formId = 'assessment-form' + currentIndex;
    const form = document.getElementById(formId);

    if (!form) {
        console.error(`Form element with ID '${formId}' not found.`);
        return;
    }

    const formData = new FormData(form);

    
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        

        alert("Assessment completed!");
        window.location.href = 'somepage.html'; // Redirect to a summary or another page
    })
    .catch(error => console.error('Error submitting form:', error));
}

        function updateProgress() {
            const answeredQuestions = new Set(
                Array.from(document.querySelectorAll('input[type="radio"]:checked'))
                .map(radio => radio.name)
            );

            const progressPercent = Math.round((answeredQuestions.size / totalQuestions) * 100);
            const progressBar = document.getElementById('progressBar');
            progressBar.style.width = progressPercent + '%';
            progressBar.setAttribute('aria-valuenow', progressPercent);
            progressBar.innerText = progressPercent + '%';
        }
    </script>
</body>
</html>