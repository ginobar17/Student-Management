<?php
session_start();
include "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");

    if (mysqli_num_rows($query) == 1) {
        $admin = mysqli_fetch_assoc($query);

        if ($password == $admin['password']) { // NOTE: later we convert to hashed password
            $_SESSION['admin'] = $admin['admin_id'];
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "Invalid Password";
        }
    } else {
        $error = "Admin Not Found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login - Student DBMS</title>
<link rel="stylesheet" href="style.css">

<style>
body {
    background: #e6f0ff;
    font-family: Arial, sans-serif;
}

.login-box {
    width: 350px;
    background: white;
    padding: 30px;
    margin: 120px auto;
    border-radius: 12px;
    box-shadow: 0 6px 25px rgba(0,0,255,0.2);
}

.login-box h2 {
    text-align: center;
    margin-bottom: 25px;
}

.input-group {
    margin-bottom: 15px;
}

.input-group label {
    font-weight: bold;
}

.input-group input {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border-radius: 8px;
    border: 1px solid #aaa;
}

.btn-login {
    width: 100%;
    background: #4A90E2;
    color: white;
    padding: 12px;
    border-radius: 8px;
    text-align: center;
    font-size: 18px;
    border: none;
    cursor: pointer;
}

.btn-login:hover {
    background: #357ABD;
}

.error {
    color: red;
    text-align: center;
    margin-bottom: 10px;
}
</style>
</head>

<body>

<div class="login-box">
    <h2>Admin Login</h2>

    <?php if ($error != "") { ?>
        <p class="error"><?= $error ?></p>
    <?php } ?>

    <form method="POST">
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit" class="btn-login">Login</button>
    </form>
</div>

</body>
</html>
