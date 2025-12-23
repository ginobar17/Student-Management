<?php
session_start();
include 'db.php';

if(isset($_POST['submit'])) {
    $dept_name = $_POST['dept_name'];
    mysqli_query($conn, "INSERT INTO department(dept_name) VALUES('$dept_name')");
    header("Location: department.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Department</title>
<link rel="stylesheet" href="style.css">
</head>

<body>
<section class="form-section">
  <div class="form-box">
    <h2>Add Department</h2>

    <form method="POST">
      <input type="text" name="dept_name" placeholder="Dept Name" required>
      <button class="btn-filled" type="submit" name="submit">Save</button>
    </form>

  </div>
</section>
</body>
</html>
