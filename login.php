<?php
session_start();
include "connection.php";

$message = ""; 

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT * FROM registration WHERE username = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['last_name'] = $row['last_name'];

            $message = '<div class="alert alert-success fade show" role="alert">
                            ✅ Login successful! Redirecting...
                        </div>
                        <script>setTimeout(function(){ window.location = "select_exam.php"; }, 1500);</script>';
        } else {
            $message = '<div class="alert alert-danger fade show" role="alert">❌ Incorrect password!</div>';
        }
    } else {
        $message = '<div class="alert alert-danger fade show" role="alert">❌ Username not found!</div>';
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="custom.css";

</head>
<body class="login-page">

<div class="login-container">
    <center>
    <h3>Login</h3>
    </center>
    <?php echo $message; ?>
    <form method="post" action="">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" id="username" name="username" class="form-control" placeholder="Enter username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required>
                
            </div>
        </div>
        <button type="submit" name="login" class="btn btn-login w-100">Login</button>
        <a href="register.php" class="btn btn-secondary w-100 mt-2">Register</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
// Show/Hide password
const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#password');

togglePassword.addEventListener('click', function () {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.innerHTML = type === 'password' ? '<i class="fa fa-eye"></i>' : '<i class="fa fa-eye-slash"></i>';
});
</script>
</body>
</html>
