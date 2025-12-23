<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}
include "db.php";

$departments = mysqli_query($conn, "SELECT * FROM department");

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $dept_id = $_POST['dept_id'];

    mysqli_query($conn,"
        INSERT INTO subjects (subject_name, dept_id)
        VALUES ('$name', '$dept_id')
    ");

    header("Location: admin_subjects.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Subject</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<section class="form-section">
<h2>Add New Subject</h2>

<form method="POST">

<label>Subject Name:</label>
<input type="text" name="name" required>

<label>Department:</label>
<select name="dept_id" required>
    <option value="">Select Department</option>
    <?php while($d = mysqli_fetch_assoc($departments)) { ?>
        <option value="<?= $d['dept_id'] ?>"><?= $d['dept_name'] ?></option>
    <?php } ?>
</select>

<button type="submit" class="btn-filled">Add Subject</button>

</form>

</section>

</body>
</html>
