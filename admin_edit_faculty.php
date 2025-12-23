<?php
session_start();
include "db.php";

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

$id = $_GET['id'];

$faculty = mysqli_fetch_assoc(mysqli_query($conn, 
    "SELECT * FROM faculty WHERE faculty_id='$id'"
));

$departments = mysqli_query($conn, "SELECT * FROM department");

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $dept_id = $_POST['dept_id'];

    mysqli_query($conn, "
        UPDATE faculty
        SET name='$name', email='$email', dept_id='$dept_id'
        WHERE faculty_id='$id'
    ");

    header("Location: admin_faculty.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Faculty</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<section class="form-section">
    <h2>Edit Faculty</h2>

    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" value="<?= $faculty['name'] ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?= $faculty['email'] ?>" required>

        <label>Department:</label>
        <select name="dept_id" required>
            <?php while($d = mysqli_fetch_assoc($departments)) { ?>
                <option value="<?= $d['dept_id'] ?>"
                    <?= ($d['dept_id'] == $faculty['dept_id']) ? 'selected' : '' ?>>
                    <?= $d['dept_name'] ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit" class="btn-filled">Update Faculty</button>
    </form>
</section>

</body>
</html>
