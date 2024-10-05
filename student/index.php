<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'config.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $sql = "SELECT id, email, password FROM stdregistration WHERE email = ?";
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $email);
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1){
                mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
                if(mysqli_stmt_fetch($stmt)){
                    if(password_verify($password, $hashed_password)){
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["email"] = $email;
                        
                        header("location: studentDashboard.php");
                    } else {
                       echo '<script>alert("Invalid email or password.")</script>';
                    }
                }
            } else {
               echo '<script>alert("Invalid email or password.")</script>';
        }
    } else {
        echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
    }
        mysqli_stmt_close($stmt);
    }
}
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <style>
        body {
            font-family: Arial, sans-serif;
             background-image: url(uploads/ollato-bg-img-2.png);
    background-color: #ffffff;
    background-repeat: no-repeat;
    background-position: center center;
    background-attachment: fixed;
    background-size: contain;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            width: 35%;
            margin: 50px auto;
            background-color: transparent;
            padding: 20px;
            flex: 1;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        form {
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
            display: flex;
            align-items: center;
            background-color: transparent;
            border: none;
            border-bottom: 2px solid rgb(173, 173, 173);
        }

        .form-group label {
            font-weight: bold;
            color: #555;
            margin: 10px 0 5px;
        }

        .form-group i {
            color: black;
            padding: 13px;
        }

        input[type="email"],
        input[type="password"] {
            padding: 10px;
            border: none;
            border-radius: 5px;
            width: calc(100% - 40px);
            box-sizing: border-box;
            background-color: white;
        }

        .inputField:focus {
            outline: none;
        }

        .password-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .password-toggle {
            position: relative;
            width: 100%;
        }

        .password-toggle input {
            width: calc(100% - 40px);
            border: none;
        }

        .toggle-password {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }

        .form-buttons {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            width: 100%;
        }

        .submit-btn {
            background-color: #644537;
    border: 2px solid #644537;
    padding: 7px 60px;
    color: #ede6e2;
        }

        .submit-btn:hover {
            background-color: #ede6e2;
            border: 2px solid #644537;
            color: #b75b2e;
        }

        .create-acc-text {
            margin-top: 20px;
            text-align: center;
        }

        .create-acc,
        a {
            color: #872C00;
            text-decoration: none;
        }

        .create-acc-text a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .form-group {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <!-- header  -->
    <header>
        <div class="container-fluid header" style="background-color: #ede6e2;
    color: #644537;">
            <div class="row p-3" style="justify-content: space-evenly">
                <div class="col-md-4 mb-1">
                    <div class="company-detail text-center">
                        <a href="/">
                            <img src="uploads/small.png" alt="logo" width="85" height="85" style="border-radius: 60px;" />
                        </a>
                    </div>
                    <div class="top-header">
                        <h3 class=" text-center mt-2 mb-2 fw-bold">Ollato Mind Mapping Programme</h3>
                    </div>
                </div>
            </div>
        </div>        
    </header>
      
    <!-- form  -->
    <div class="container">
        <h2>Student Login</h2>
        <form action="index.php" method="post" onsubmit="return validateLoginForm()">
            <div class="form-group">
                <i class="fas fa-envelope"></i>
                
                <input type="email" id="email" name="email" placeholder="Enter your email" class="inputField" required>
            </div>
            <div class="form-group password-toggle">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="Enter your password" class="inputField" required>
                <span class="toggle-password" onclick="togglePasswordVisibility('password')"><i class="fas fa-eye"></i></span>
            </div>
            <div class="form-buttons">
                <button type="submit" class="submit-btn">Login</button>
            </div>
            <div class="create-acc-text">
                <p><strong>New user? <a href="NewRegistrationForm.html" class="create-acc">Create an account</a></strong></p>

            </div>
        </form>
    </div>

    <!--Footer start -->
    <footer style="margin-top: auto;">
        <div class="container-fluid header" style="background-color:#ede6e2;color:#644537;">
            <div class="row justify-content-around">
                <div class="col-md-6 mt-3">
                    <div class="company-detail footer-text">
                        <ul style="list-style:none">
                            <li> <b>Serac Education Pvt. Ltd. </b></li>
                            <li>618, Nirmal Corporate Centre,.</li>
                            <li>LBS Road, Moti Nagar, Mulund West, Mumbai 400080.</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="company-detail text-end mob footer-text">
                        <ul style="list-style:none">
                            <li>Phone No : <a href="tel:%20+91%209967153586" class="text-decoration-none ">9967153586</a></li>
                            <li>Email : <a href="mailto:info@ollato.com" class=" text-decoration-none "> info@seracedu.com</a></li>
                            <li>Website : <a href="https://www.ollato.com/" target="_blank" style="text-decoration: none;"> Ollato.com </a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="company-detail text-center mob">
                    </div>
                </div>
            </div> 
        </div>
    </footer>

    <script>
        function togglePasswordVisibility(id) {
            var x = document.getElementById(id);
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        function validateLoginForm() {
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;

            if (email === "" || password === "") {
                alert("Please fill out all fields.");
                return false;
            }

            return true;
        }
    </script>
</body>

</html>
