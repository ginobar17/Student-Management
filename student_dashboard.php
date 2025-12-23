<?php
session_start();
if (!isset($_SESSION['student'])) {
    header("Location: student_login.php");
    exit();
}
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];  // admin viewing another student
} else {
    $student_id = $_SESSION['student']; // student viewing himself
}

include "db.php";

$student_id = $_SESSION['student'];

// Fetch student details
$student = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT * FROM students WHERE id='$student_id'"
));

$dept_id = $student['dept_id'];

// Fetch subjects of student's department
$subjects = mysqli_query($conn,
    "SELECT * FROM subjects WHERE dept_id='$dept_id'"
);

// Fetch marks
$marksResult = mysqli_query($conn,
    "SELECT s.subject_name, m.marks_obtained, m.max_marks, s.subject_id
     FROM marks m
     INNER JOIN subjects s ON m.subject_id = s.subject_id
     WHERE m.student_id='$student_id'"
);

// Convert marks to array for easy lookup
$marks = [];
while ($row = mysqli_fetch_assoc($marksResult)) {
    $marks[$row['subject_id']] = $row;
}

// Attendance fetch function
function getAttendance($conn, $student_id, $subject_id) {
    $total = mysqli_fetch_assoc(mysqli_query($conn,
        "SELECT COUNT(*) AS total FROM attendance 
         WHERE student_id='$student_id' AND subject_id='$subject_id'"
    ))['total'];

    $present = mysqli_fetch_assoc(mysqli_query($conn,
        "SELECT COUNT(*) AS present FROM attendance 
         WHERE student_id='$student_id' AND subject_id='$subject_id' 
         AND status='Present'"
    ))['present'];

    if ($total == 0) return "No Data";

    $percent = round(($present / $total) * 100);
    return $percent . "%";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Dashboard</title>
<link rel="stylesheet" href="style.css">

<style>
body {
    background: #eef3ff;
    font-family: Arial;
}

.dashboard-box {
    width: 85%;
    margin: 40px auto;
    background: #fff;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.15);
}

.profile-box {
    background: #4A90E2;
    color: white;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 25px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 25px;
}

table th, table td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
}

.btn-download {
    display: inline-block;
    padding: 12px 18px;
    background: #4A90E2;
    color: white;
    border-radius: 10px;
    text-decoration: none;
    margin-top: 20px;
}

.btn-download:hover {
    background: #357ABD;
}

h2, h3 { margin-bottom: 10px; }
</style>

</head>

<body>

<header>
  <nav class="navbar">
    <div class="logo">Student <span>DBMS</span></div>
    
    <a href="logout.php" class="btn-outline">Logout</a>
  </nav>
</header>


<div class="dashboard-box">

    <div class="profile-box">
        <h2>Welcome, <?= $student['name'] ?> 👋</h2>
        <p><b>Email:</b> <?= $student['email'] ?></p>
        <p><b>Course:</b> <?= $student['course'] ?></p>
    </div>

    <h3>Your Marks & Attendance</h3>

    <table class="styled-table">
        <thead>
            <tr>
                <th>Subject</th>
                <th>Marks</th>
                <th>Max Marks</th>
                <th>Attendance</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($sub = mysqli_fetch_assoc($subjects)) { 
                $sub_id = $sub['subject_id'];
            ?>
                <tr>
                    <td><?= $sub['subject_name'] ?></td>

                    <td>
                        <?= isset($marks[$sub_id]) ? $marks[$sub_id]['marks_obtained'] : "N/A" ?>
                    </td>

                    <td>
                        <?= isset($marks[$sub_id]) ? $marks[$sub_id]['max_marks'] : "N/A" ?>
                    </td>

                    <td>
                        <?= getAttendance($conn, $student_id, $sub_id) ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <a href="generate_pdf.php" class="btn-download">Download Report</a>

</div>

<footer>
    <p style="text-align:center; padding:20px;">© 2025 Student DBMS | Student Panel</p>
</footer>

</body>
</html>
