<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

include "db.php";

$subjects = mysqli_query($conn, "
    SELECT s.subject_id, s.subject_name, d.dept_name 
    FROM subjects s
    LEFT JOIN department d ON s.dept_id = d.dept_id
");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Subjects</title>
    <link rel="stylesheet" href="style.css">

<style>
.btn-add {
    background:#4A90E2; padding:10px 15px; 
    color:white; border-radius:8px; text-decoration:none;
}
.actions a {
    margin-right:10px;
}
</style>

</head>

<body>

<header>
  <nav class="navbar">
    <div class="logo">Student <span>DBMS</span></div>
    <ul class="nav-links">
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="students.php">Students</a></li>
      <li><a href="department.php">Departments</a></li>
      <li><a href="admin_faculty.php">Faculty</a></li>
      <li><a href="admin_subjects.php" class="active">Subjects</a></li>
    </ul>
    <a href="logout.php" class="btn-outline">Logout</a>
  </nav>
</header>

<section class="features">
<h2>Subject Management</h2>

<a href="admin_add_subject.php" class="btn-add">+ Add Subject</a><br><br>

<table class="styled-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Subject Name</th>
            <th>Department</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php while($sub = mysqli_fetch_assoc($subjects)) { ?>
            <tr>
                <td><?= $sub['subject_id'] ?></td>
                <td><?= $sub['subject_name'] ?></td>
                <td><?= $sub['dept_name'] ?></td>
                <td class="actions">
                    <a href="admin_edit_subject.php?id=<?= $sub['subject_id'] ?>" class="btn-filled small">Edit</a>
                    <a href="admin_delete_subject.php?id=<?= $sub['subject_id'] ?>" 
                       onclick="return confirm('Delete this subject?')" 
                       class="btn-outline small">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

</section>

</body>
</html>
