<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}
include "db.php";

$departments = mysqli_query($conn, "SELECT * FROM department");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name  = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $dept_id = $_POST['dept_id'];
    $password = $_POST['password'];

    mysqli_query($conn, "
        INSERT INTO students (name, email, course, dept_id, password)
        VALUES ('$name', '$email', '$course', '$dept_id', '$password')
    ");

    header("Location: students.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Student</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<h2 style="text-align:center;">Add New Student</h2><br>

<form method="POST" class="form-box" >

    <label>Name</label>
    <input type="text" name="name" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Course</label>
    <input type="text" name="course" required>

    <label>Department</label>
    <select name="dept_id" required>
        <option value="">Select Department</option>
        <?php while ($d = mysqli_fetch_assoc($departments)) { ?>
            <option value="<?= $d['dept_id'] ?>"><?= $d['dept_name'] ?></option>
        <?php } ?>
    </select>

    <label>Student Password</label>
    <input type="password" name="password" required>

    <button type="submit" class="btn-filled">Add Student</button>
</form>

</body>
</html>
