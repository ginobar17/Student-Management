<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include "db.php";

$id = $_GET['id'];

$student = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM students WHERE id='$id'"));
$departments = mysqli_query($conn, "SELECT * FROM department");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $dept_id = $_POST['dept_id'];
    $password = $_POST['password'];

    mysqli_query($conn, "
        UPDATE students 
        SET name='$name', email='$email', course='$course', dept_id='$dept_id', password='$password'
        WHERE id='$id'
    ");

    header("Location: students.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Student</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<h2 style="text-align:center;">Edit Student</h2>

<form method="POST" class="form-box">

    <label>Name</label>
    <input type="text" name="name" value="<?= $student['name'] ?>" required>

    <label>Email</label>
    <input type="email" name="email" value="<?= $student['email'] ?>" required>

    <label>Course</label>
    <input type="text" name="course" value="<?= $student['course'] ?>" required>

    <label>Department</label>
    <select name="dept_id" required>
        <?php while ($d = mysqli_fetch_assoc($departments)) { ?>
            <option value="<?= $d['dept_id'] ?>" <?= $d['dept_id']==$student['dept_id']?'selected':'' ?>>
                <?= $d['dept_name'] ?>
            </option>
        <?php } ?>
    </select>

    <label>Password</label>
    <input type="password" name="password" value="<?= $student['password'] ?>" required>

    <button type="submit" class="btn-filled">Update Student</button>
</form>

</body>
</html>
