<?php
session_start();
include "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $student_id = $_POST["student_id"];
    $password   = $_POST["password"];

    // Fetch student record
    $query = mysqli_query($conn, 
        "SELECT * FROM students WHERE id='$student_id' LIMIT 1"
    );

    if (mysqli_num_rows($query) == 1) {

        $student = mysqli_fetch_assoc($query);

        if ($password == $student['password']) {  // Later: change to password_hash

            $_SESSION['student'] = $student['id'];
            $_SESSION['dept_id'] = $student['dept_id'];

            header("Location: student_dashboard.php");
            exit();

        } else {
            $error = "Wrong Password!";
        }

    } else {
        $error = "Student ID not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Login - Student DBMS</title>

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
    <h2>Student Login</h2>

    <?php if ($error != "") { ?>
        <p class="error"><?= $error ?></p>
    <?php } ?>

    <form method="POST">
        <div class="input-group">
            <label>Student ID</label>
            <input type="number" name="student_id" required>
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
