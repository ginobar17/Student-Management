<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}
include 'db.php';

// Count students
$countStudents = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM students"))['total'];

// Count departments
$countDepartments = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM department"))['total'];

// Count faculty
$countFaculty = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM faculty"))['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

<header>
  <nav class="navbar">
    <div class="logo">Student <span>DBMS</span></div>
    <ul class="nav-links">
      <li><a href="dashboard.php" class="active">Dashboard</a></li>
      <li><a href="students.php">Students</a></li>
      <li><a href="department.php">Departments</a></li>
      <li><a href="#">Faculty</a></li>
    </ul>
<a href="role_select.php" class="btn-outline">Logout</a>
  </nav>
</header>

<section class="features">
  <h2>Welcome Admin 👋</h2>
  <p>Overview of your system</p>

  <div class="cards">

    <a href="students.php" class="card-link">
      <div class="card card-blue">
        <h3>Students</h3>
        <h1><?php echo $countStudents; ?></h1>
        <p>Total Registered</p>
      </div>
    </a>

    <a href="department.php" class="card-link">
      <div class="card card-green">
        <h3>Departments</h3>
        <h1><?php echo $countDepartments; ?></h1>
        <p>Active Departments</p>
      </div>
    </a>

    <a href="admin_faculty.php" class="card-link">
      <div class="card card-orange">
        <h3>Faculty</h3>
        <h1><?php echo $countFaculty; ?></h1>
        <p>Staff Members</p>
      </div>
    </a>

  </div>
</section>

<footer>
  <p>© 2025 Student DBMS | Mini Project</p>
</footer>

</body>
</html>