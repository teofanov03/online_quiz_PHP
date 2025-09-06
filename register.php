<?php
include "connection.php";

$message = "";

if (isset($_POST["submit1"])) {
    $first_name = $_POST["first_name"];
    $last_name  = $_POST["last_name"];
    $username   = $_POST["username"];
    $password   = $_POST["password"];
    $email      = $_POST["email"];
    $contact    = $_POST["contact"];

    // Provera da li username ili email već postoje
    $checkQuery = "SELECT id FROM registration WHERE username = ? OR email = ?";
    $stmt = $link->prepare($checkQuery);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $message = '<div class="alert alert-danger" role="alert">
                        ❌ Username or email already exists!
                    </div>';
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $insertQuery = "INSERT INTO registration (first_name, last_name, username, password, email, contact) 
                        VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $link->prepare($insertQuery);
        $stmt->bind_param("ssssss", $first_name, $last_name, $username, $hashedPassword, $email, $contact);

        if ($stmt->execute()) {
            $message = '<div class="alert alert-success" role="alert">
                            ✅ Registration successful! Redirecting to login page...
                        </div>
                        <script>
                            setTimeout(function(){
                                window.location = "login.php";
                            }, 3000);
                        </script>';
        } else {
            $message = '<div class="alert alert-danger" role="alert">
                            ❌ Error! Please try again.
                        </div>';
        }
    }

    $stmt->close();
}
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>Register Now</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://fonts.googleapis.com/css?family=Play:400,700" rel="stylesheet">
<link rel="stylesheet" href="css1/bootstrap.min.css">
<link rel="stylesheet" href="css1/font-awesome.min.css">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="custom.css">


</head>

<body class="register-page">
<div class="register-container">
    <h3>Register Now</h3>

    <?php echo $message; ?>

    <form action="" method="post" name="form1">
        <input type="text" name="first_name" class="form-control" placeholder="Enter your first name" required>
        <input type="text" name="last_name" class="form-control" placeholder="Enter your last name" required>
        <input name="username" type="text" class="form-control" placeholder="Choose a username" required>
        <input name="password" type="password" class="form-control" placeholder="Enter password" required>
        <input name="email" type="email" class="form-control" placeholder="Enter your email" required>
        <input name="contact" type="text" class="form-control" placeholder="Enter contact number" required>
        <button type="submit" name="submit1" class="btn btn-success loginbtn">Register</button>
    </form>

    <!-- Link za login -->
    <a href="login.php" class="login-link">Already have an account? Login</a>
</div>

<script src="js/vendor/jquery-1.12.4.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
