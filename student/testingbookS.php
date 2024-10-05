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
        }

        .user-profile {
            display: flex;
            align-items: center;
            color: grey;
        }

        .user-profile span {
            margin-right: 10px;
        }

        .boxx {
            display: none;
        }

        .boxx.active {
            display: block;
        }

        .content {
            margin-left: 250px; /* Same as the sidebar width plus some space */
            padding: 20px;
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

        .popup {
            position: absolute;
            top: 50%;
            left: 50%;
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

        .popup form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .popup label {
            margin-bottom: 10px;
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

        .popup-close {
            background-color: #d9534f;
            color: #ffffff;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .popup-close:hover {
            background-color: #c9302c;
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
        <img src="ollato-logo.jpg" alt="Logo" class="sidebar-logo">
        <ul>
            <li class="nav-tabs">Dashboard</li>
            <li><a href="packages.html"><i class="fa-solid fa-gift"></i> Packages</a></li>
            <li><a href="lan.html"><i class="fas fa-tasks"></i> Assessment</a></li>
            <li><i class="fa-solid fa-cloud-arrow-down"></i> Download Summary</li>
            <li>Report</li>
            <li><a href="fetchExplm.php"><i class="fa fa-calendar-check-o"></i> Book Session</a></li>
            <li><a href="sessionMag.html"><i class="fa-solid fa-building"></i> Session Management</a></li>
            <li><a href="videocalling.html"><i class="fa fa-bell"></i> Notifications</a></li>
            <li><a href="feedbackform.html"><i class="fa-solid fa-comments"></i> FeedBack</a></li>
            <li><a href="updatePro.html"><i class="fa-solid fa-user"></i> Edit Profile</a></li>
            <button class="collapse-btn"><i class="fas fa-angle-left"></i></button>
            <button class="logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </ul>
    </div>
</div>

<div class="content">
    <header>
        <div class="brand-name">SERAC EDU PVT LTD</div>
        <div class="user-profile">
            <span>Rohini Divakar</span>
            <img src="path_to_your_image.jpg" alt="User Image" class="user-img" style="border-radius: 50%; width: 40px; height: 40px;">
        </div>
    </header>

    <h2>Book Session</h2>

    <div class="search-counsellor">
        <div class="filters">
            <div>
                <label for="counsellor-name">Counsellor Name:</label>
                <select id="counsellor-name">
                    <option value="Psychologist"></option>
                    <?php
                    include 'config.php';

                    $sql = "SELECT DISTINCT professtional_expertise FROM counsellor_registration";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['professtional_expertise'] . '">' . $row['professtional_expertise'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div>
                <label for="availability">Availability:</label>
                <input type="date" id="availability">
            </div>
            <div>
                <label for="location">Location:</label>
                <select id="location">
                    <option value="">All</option>
                    <?php
                    $sql = "SELECT DISTINCT location FROM counsellors";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['location'] . '">' . $row['location'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div>
                <label for="expertise">Expertise:</label>
                <select id="expertise">
                    <option value="">All</option>
                    <?php
                    $sql = "SELECT DISTINCT expertise FROM counsellors";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['expertise'] . '">' . $row['expertise'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div>
                <button id="filter-btn">Search</button>
            </div>
        </div>

        <div class="counsellors" id="counsellors-list">
            <?php
            // Retrieve counsellors from the database
            $sql = "SELECT id, full_name, availability, location, professtional_expertise  FROM counsellor_registration";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Check if the counsellor is available
                    if ($row['availability']) {
                        echo '<div class="counsellor-card">';
                        echo '<img src="path_to_counsellor_image.jpg" alt="Counsellor Image">';
                        echo '<h3>' . $row['name'] . '</h3>';
                        echo '<p>Availability: ' . $row['availability'] . '</p>';
                        echo '<p>Location: ' . $row['location'] . '</p>';
                        echo '<p>Expertise: ' . $row['expertise'] . '</p>';
                        echo '<button class="book-session-btn" data-counsellor-id="' . $row['id'] . '">Book Session</button>';
                        echo '</div>';
                    }
                }
            } else {
                echo 'No counsellors found.';
            }

            $conn->close();
            ?>
        </div>
    </div>

    <div class="popup" id="booking-popup">
        <h2>Book Session</h2>
        <form id="booking-form">
            <label for="student-name">Student Name:</label>
            <input type="text" id="student-name" required>
            <label for="booking-date">Booking Date:</label>
            <input type="date" id="booking-date" required>
            <button type="submit">Submit</button>
            <button type="button" class="popup-close">Close</button>
        </form>
    </div>
</div>

<script>
    // JavaScript to handle the filtering
    document.getElementById('filter-btn').addEventListener('click', function() {
        var name = document.getElementById('counsellor-name').value;
        var availability = document.getElementById('availability').value;
        var location = document.getElementById('location').value;
        var expertise = document.getElementById('expertise').value;

        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'fetch_counsellors.php?name=' + name + '&availability=' + availability + '&location=' + location + '&expertise=' + expertise, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('counsellors-list').innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    });

    // JavaScript to handle booking
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('book-session-btn')) {
            var counsellorId = event.target.getAttribute('data-counsellor-id');
            var bookingPopup = document.getElementById('booking-popup');
            bookingPopup.style.display = 'block';

            var bookingForm = document.getElementById('booking-form');
            bookingForm.addEventListener('submit', function(e) {
                e.preventDefault();
                var studentName = document.getElementById('student-name').value;
                var bookingDate = document.getElementById('booking-date').value;

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'book_session.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        alert('Session booked successfully!');
                        bookingPopup.style.display = 'none';
                    }
                };
                xhr.send('counsellor_id=' + counsellorId + '&student_name=' + studentName + '&booking_date=' + bookingDate);
            });
        }

        if (event.target.classList.contains('popup-close')) {
            document.getElementById('booking-popup').style.display = 'none';
        }
    });
</script>

</body>
</html>
