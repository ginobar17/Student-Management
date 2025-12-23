<?php
session_start();
if(!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

$result = mysqli_query($conn, "SELECT * FROM department");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Departments</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<header>
  <nav class="navbar">
    <div class="logo">Student <span>DBMS</span></div>
    <ul class="nav-links">
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="students.php">Students</a></li>
      <li><a href="department.php" class="active">Departments</a></li>
    </ul>
    <a href="logout.php" class="btn-outline">Logout</a>
  </nav>
</header>

<section class="features">
  <h2>Manage Departments</h2>

  <a href="add_department.php" class="btn-filled">Add Department</a>

  <table class="styled-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Department Name</th>
        <th>Actions</th>
      </tr>
    </thead>

<tbody>
<?php 
if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) { 
?>
    <tr>
        <td><?php echo $row['dept_id']; ?></td>
        <td><?php echo $row['dept_name']; ?></td>
        <td>
            <a href="edit_department.php?dept_id=<?php echo $row['dept_id']; ?>" class="btn-filled small">Edit</a>
            <a href="delete_department.php?dept_id=<?php echo $row['dept_id']; ?>" class="btn-outline small"
               onclick="return confirm('Delete this department?')">Delete</a>
        </td>
    </tr>
<?php 
    } 
} else { 
?>
    <tr>
        <td colspan="3" style="text-align:center;">No Departments Added Yet</td>
    </tr>
<?php 
} 
?>
</tbody>

  </table>
</section>

</body>
</html>
