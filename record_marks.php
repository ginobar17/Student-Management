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

// When marks form is submitted
if (isset($_POST['submit_marks'])) {

    $subject_id = $_POST['subject'];
    $max_marks = $_POST['max_marks'];

    foreach ($_POST['marks'] as $student_id => $obtained_marks) {

        // Insert or update marks in your table structure
        mysqli_query($conn, "
            INSERT INTO marks (student_id, subject_id, marks_obtained, faculty_id)
            VALUES ('$student_id', '$subject_id', '$obtained_marks', '$faculty_id')
            ON DUPLICATE KEY UPDATE marks_obtained='$obtained_marks'
        ");
    }

    $success = "Marks recorded successfully!";
}

// Fetch students of this faculty’s department
$students = mysqli_query($conn, "SELECT * FROM students WHERE dept_id = '$dept_id'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Record Marks</title>

<style>
body {
    background: #eef3ff;
    font-family: Arial;
}
.container {
    width: 80%;
    margin: 30px auto;
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}
h2 {
    text-align: center;
    margin-bottom: 20px;
}
select, input[type=number] {
    padding: 10px;
    width: 200px;
    border-radius: 8px;
    border: 1px solid #bbb;
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

    <h2>Record Marks</h2>

    <?php if (isset($success)) { ?>
        <p class="success"><?= $success ?></p>
    <?php } ?>

    <form method="POST">

        <!-- Subject selection -->
        <label><b>Select Subject:</b></label><br>
        <select name="subject" required>
            <option value="">-- Choose Subject --</option>
            <?php while($sub = mysqli_fetch_assoc($subjects)) { ?>
                <option value="<?= $sub['subject_id'] ?>">
                    <?= $sub['subject_name'] ?>
                </option>
            <?php } ?>
        </select>
        <br><br>

        <!-- Maximum marks -->
        <label><b>Enter Maximum Marks:</b></label><br>
        <input type="number" name="max_marks" required min="1" max="500">
        <br><br>

        <!-- Students list -->
        <table>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Marks Obtained</th>
            </tr>

            <?php while($stu = mysqli_fetch_assoc($students)) { ?>
            <tr>
                <td><?= $stu['id'] ?></td>
                <td><?= $stu['name'] ?></td>
                <td>
                    <input type="number"
                           name="marks[<?= $stu['id'] ?>]"
                           min="0"
                           max="500"
                           required>
                </td>
            </tr>
            <?php } ?>

        </table>

        <button type="submit" name="submit_marks" class="submit-btn">
            Save Marks
        </button>
       <a href="faculty_dashboard.php" class="submit-btn" style="background:#888; text-decoration:none; margin-left:10px;">
            Back to Dashboard
            </a>
    </form>

</div>

</body>
</html>
