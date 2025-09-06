<?php
include "../connection.php";
session_start();

$message = ""; 

if (isset($_POST['submit1'])) {
    $username = mysqli_real_escape_string($link,$_POST['username']);
    $password = mysqli_real_escape_string($link,$_POST['password']);

    $query = "SELECT * FROM admin_login WHERE username = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($password == $row['password']) {
            $_SESSION['admin_username'] = $row['username'];
            $_SESSION['admin_id'] = $row['id'];

            $message = '<div class="alert alert-success" role="alert">
                            ✅ Login successful! Redirecting...
                        </div>
                        <script>
                            setTimeout(function(){
                                window.location = "exam_category.php"; 
                            }, 1500);
                        </script>';
        } else {
            $message = '<div class="alert alert-danger" role="alert">
                            ❌ Incorrect password!
                        </div>';
        }
    } else {
        $message = '<div class="alert alert-danger" role="alert">
                        ❌ Username not found!
                    </div>';
    }
    $stmt->close();
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Admin Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

<style>
    /* Animated Gradient Background */
    body {
        height: 100vh;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Open Sans', sans-serif;
        background: linear-gradient(-45deg, #1d2b36, #0f4c75, #3282b8, #bbe1fa);
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;
    }

    @keyframes gradientBG {
        0% {background-position: 0% 50%;}
        50% {background-position: 100% 50%;}
        100% {background-position: 0% 50%;}
    }

    .login-content {
        width: 100%;
        max-width: 400px;
        background: rgba(255, 255, 255, 0.95);
        padding: 30px 25px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        backdrop-filter: blur(5px);
    }

    .login-logo {
        text-align: center;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 30px;
        color: #333;
    }

    .login-form .form-control {
        border-radius: 8px;
        padding: 12px 15px;
        border: 1px solid #ccc;
        transition: all 0.3s ease;
    }

    .login-form .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 8px rgba(0,123,255,0.3);
        outline: none;
    }

    .login-form button {
        border-radius: 8px;
        padding: 12px;
        font-weight: 600;
        background: #007bff;
        border: none;
        transition: all 0.3s ease;
    }

    .login-form button:hover {
        background: #0056b3;
    }

    .alert {
        font-size: 14px;
        padding: 10px 15px;
        margin-bottom: 15px;
        border-radius: 8px;
    }
</style>
</head>

<body>
<div class="login-content">
    <div class="login-logo">Admin Login</div>
    <div class="login-form">
        <?php if($message != "") { echo $message; } ?>
        <form name="form1" action="" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" placeholder="Enter username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>
            <button type="submit" name="submit1" class="btn btn-primary btn-block">Sign In</button>
        </form>
    </div>
</div>

<script src="vendors/jquery/dist/jquery.min.js"></script>
<script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
