<?php
session_start();
include 'db.php';

$id = $_GET['id'];
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM department WHERE id=$id"));

if(isset($_POST['submit'])) {
    $dept_name = $_POST['dept_name'];
    mysqli_query($conn, "UPDATE department SET dept_name='$dept_name' WHERE id=$id");
    header("Location: department.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Department</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<section class="form-section">
  <div class="form-box">
    <h2>Edit Department</h2>

    <form method="POST">
      <input type="text" name="dept_name" value="<?php echo $row['dept_name']; ?>" required>
      <button type="submit" name="submit" class="btn-filled">Update</button>
    </form>

  </div>
</section>

</body>
</html>
