<?php
session_start();
if(!isset($_SESSION['faculty'])){
    header("Location: faculty_login.php");
    exit();
}

include "db.php";

$faculty_id = $_SESSION['faculty'];

// Fetch faculty name
$faculty = mysqli_fetch_assoc(mysqli_query($conn, 
    "SELECT name FROM faculty WHERE faculty_id='$faculty_id'"
))['name'];

// Fetch subjects assigned to this faculty
$subjectQuery = mysqli_query($conn, "
    SELECT fs.subject_id, s.subject_name, d.dept_name
    FROM faculty_subject fs
    INNER JOIN subjects s ON fs.subject_id = s.subject_id
    INNER JOIN department d ON s.dept_id = d.dept_id
    WHERE fs.faculty_id = '$faculty_id'
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Faculty Dashboard</title>
<link rel="stylesheet" href="style.css">

<style>
body {
    background: #f1f5f9;
    font-family: Arial, sans-serif;
}

.dashboard-container {
    padding: 30px;
    max-width: 1100px;
    margin: auto;
}

.welcome-box {
    background: #4A90E2;
    color: white;
    padding: 25px;
    border-radius: 15px;
    margin-bottom: 30px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.subject-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    grid-gap: 25px;
}

.subject-card {
    background: white;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: 0.3s;
    border-left: 6px solid #4A90E2;
}

.subject-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 7px 18px rgba(0,0,0,0.15);
}

.subject-card h3 {
    margin: 0;
    font-size: 22px;
    color: #333;
}

.subject-card p {
    font-size: 14px;
    margin: 8px 0;
    color: #555;
}

.btn-inline {
    display: inline-block;
    padding: 8px 12px;
    font-size: 14px;
    border-radius: 10px;
    text-decoration: none;
    margin-right: 10px;
    transition: 0.3s;
    color: white;
}

.btn-attendance {
    background: #22c55e;
}

.btn-attendance:hover {
    background: #16a34a;
}

.btn-marks {
    background: #3b82f6;
}

.btn-marks:hover {
    background: #2563eb;
}
</style>

</head>

<body>

<header>
  <nav class="navbar">
    <div class="logo">Faculty <span>Portal</span></div>
    <ul class="nav-links">
      <li><a href="faculty_dashboard.php" class="active">Dashboard</a></li>
    </ul>
    <a href="role_select.php" class="btn-outline">Logout</a>
  </nav>
</header>

<div class="dashboard-container">

    <div class="welcome-box">
        <h2>Welcome, <?= $faculty ?> 👋</h2>
        <p>Here are the subjects assigned to you:</p>
    </div>

    <div class="subject-grid">

    <?php 
    if (mysqli_num_rows($subjectQuery) > 0) {
        while ($sub = mysqli_fetch_assoc($subjectQuery)) {
            $sid = $sub['subject_id'];

            // Count number of students for this subject
            $countStudents = mysqli_fetch_assoc(mysqli_query($conn, "
                SELECT COUNT(*) AS total FROM students WHERE dept_id IN 
                (SELECT dept_id FROM subjects WHERE subject_id='$sid')
            "))['total'];
    ?>

        <div class="subject-card">
            <h3><?= $sub['subject_name'] ?></h3>
            <p><b>Department:</b> <?= $sub['dept_name'] ?></p>
            <p><b>Students:</b> <?= $countStudents ?></p>

            <a href="mark_attendance.php?subject_id=<?= $sid ?>" class="btn-inline btn-attendance">
                Mark Attendance
            </a>

            <a href="record_marks.php?subject_id=<?= $sid ?>" class="btn-inline btn-marks">
                Enter Marks
            </a>
        </div>

    <?php 
        }
    } else {
        echo "<p>No subjects assigned yet.</p>";
    }
    ?>

    </div>

</div>

<footer>
  <p style="text-align:center; padding:20px;">© 2025 Student DBMS | Faculty Panel</p>
</footer>

</body>
</html>
