<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

include "db.php";

$id = $_GET['id'];

$subject = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM subjects WHERE subject_id='$id'")
);

$departments = mysqli_query($conn, "SELECT * FROM department");

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $dept_id = $_POST['dept_id'];

    mysqli_query($conn,"
        UPDATE subjects
        SET subject_name='$name', dept_id='$dept_id'
        WHERE subject_id='$id'
    ");

    header("Location: admin_subjects.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Subject</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<section class="form-section">
<h2>Edit Subject</h2>

<form method="POST">

<label>Subject Name:</label>
<input type="text" name="name" value="<?= $subject['subject_name'] ?>" required>

<label>Department:</label>
<select name="dept_id" required>
    <?php while($d = mysqli_fetch_assoc($departments)) { ?>
        <option value="<?= $d['dept_id'] ?>"
            <?= ($subject['dept_id'] == $d['dept_id']) ? 'selected' : '' ?>>
            <?= $d['dept_name'] ?>
        </option>
    <?php } ?>
</select>

<button type="submit" class="btn-filled">Update Subject</button>

</form>

</section>

</body>
</html>
