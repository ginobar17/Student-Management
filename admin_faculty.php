<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

include "db.php";

// Fetch faculty list
$faculty = mysqli_query($conn, "
    SELECT f.faculty_id, f.name, f.email, d.dept_name
    FROM faculty f
    LEFT JOIN department d ON f.dept_id = d.dept_id
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Faculty</title>
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
      <li><a href="admin_faculty.php" class="active">Faculty</a></li>
    </ul>
    <a href="logout.php" class="btn-outline">Logout</a>
  </nav>
</header>

<section class="features">
    <h2>Faculty Management</h2><br>

  <a href="admin_add_faculty.php" class="btn-add">+ Add New Faculty</a><br><br>

    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        <?php while($f = mysqli_fetch_assoc($faculty)) { ?>
            <tr>
                <td><?= $f['faculty_id'] ?></td>
                <td><?= $f['name'] ?></td>
                <td><?= $f['email'] ?></td>
                <td><?= $f['dept_name'] ?></td>
                <td class="actions">
                    <a href="admin_edit_faculty.php?id=<?= $f['faculty_id'] ?>" class="btn-filled small">Edit</a>
                    <a href="admin_delete_faculty.php?id=<?= $f['faculty_id'] ?>" onclick="return confirm('Delete this faculty?')" class="btn-outline small">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

</section>
</body>
</html>
