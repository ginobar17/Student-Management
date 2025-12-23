<?php
session_start();
include "db.php";

if (!isset($_SESSION['faculty'])) {
    header("Location: faculty_login.php");
    exit();
}

$faculty_id = $_SESSION['faculty'];
$dept_id = $_SESSION['dept_id'];  

// Fetch subjects taught by faculty
$subjects = mysqli_query($conn, "
    SELECT s.subject_id, s.subject_name
    FROM faculty_subject fs
    INNER JOIN subjects s ON fs.subject_id = s.subject_id
    WHERE fs.faculty_id = '$faculty_id'
");

// If form submitted, save attendance
if (isset($_POST['submit_attendance'])) {

    $subject_id = $_POST['subject'];
    $date = date("Y-m-d");

    foreach ($_POST['status'] as $student_id => $attendance_status) {

        mysqli_query($conn, "
            INSERT INTO attendance (student_id, subject_id, date, status, faculty_id)
            VALUES ('$student_id', '$subject_id', '$date', '$attendance_status', '$faculty_id')
        ");
    }

    $success = "Attendance has been saved successfully!";
}

// Fetch students in faculty's department
$students = mysqli_query($conn, "
    SELECT * FROM students WHERE dept_id = '$dept_id'
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Mark Attendance - Faculty</title>

<style>
body {
    background: #f3f6ff;
    font-family: Arial;
}

.container {
    width: 80%;
    margin: 30px auto;
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,255,0.1);
}

h2 {
    text-align: center;
}

select, button {
    padding: 10px;
    border-radius: 8px;
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

.present {
    color: green;
    font-weight: bold;
}

.absent {
    color: red;
    font-weight: bold;
}

.submit-btn {
    padding: 12px 20px;
    background: #4A90E2;
    color: white;
    border-radius: 8px;
    border: none;
    margin-top: 20px;
    cursor: pointer;
}

.submit-btn:hover {
    background: #357ABD;
}

.success {
    background: #d0ffd8;
    padding: 10px;
    border-left: 5px solid green;
    margin-bottom: 15px;
}
</style>

</head>
<body>

<div class="container">

    <h2>Mark Attendance</h2>

    <?php if (isset($success)) { ?>
        <p class="success"><?= $success ?></p>
    <?php } ?>

    <!-- Subject Select -->
    <form method="POST">
        <label><b>Select Subject:</b></label><br>
        <select name="subject" required>
            <option value="">-- Choose Subject --</option>

            <?php while($sub = mysqli_fetch_assoc($subjects)) { ?>
                <option value="<?= $sub['subject_id'] ?>">
                    <?= $sub['subject_name'] ?>
                </option>
            <?php } ?>

        </select>

        <!-- Students Table -->
        <table>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Attendance</th>
            </tr>

            <?php while($stu = mysqli_fetch_assoc($students)) { ?>
            <tr>
                <td><?= $stu['id'] ?></td>
                <td><?= $stu['name'] ?></td>
                <td>
                    <label><input type="radio" name="status[<?= $stu['id'] ?>]" value="Present" required> Present</label>
                    <label><input type="radio" name="status[<?= $stu['id'] ?>]" value="Absent" required> Absent</label>
                </td>
            </tr>
            <?php } ?>

        </table>

        <button type="submit" name="submit_attendance" class="submit-btn">Save Attendance</button>
        <a href="faculty_dashboard.php" class="submit-btn" style="background:#888; text-decoration:none; margin-left:10px;">
            Back to Dashboard
     </a>
    </form>
    

</div>

</body>
</html>
