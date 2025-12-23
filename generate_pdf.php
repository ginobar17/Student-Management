<?php
session_start();
include "db.php";

// Determine which student's marksheet to generate
if (isset($_GET['id']) && isset($_SESSION['admin'])) {
    $student_id = intval($_GET['id']); // Admin request
} elseif (isset($_SESSION['student'])) {
    $student_id = intval($_SESSION['student']); // Student viewing own marksheet
} else {
    echo "Access Denied";
    exit();
}

// Load DOMPDF
require 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

// Fetch student details
$student_q = mysqli_query($conn, "
    SELECT s.*, d.dept_name 
    FROM students s
    LEFT JOIN department d ON s.dept_id = d.dept_id
    WHERE s.id = '$student_id'
    LIMIT 1
");

if (mysqli_num_rows($student_q) == 0) {
    echo "Student not found!";
    exit();
}

$student = mysqli_fetch_assoc($student_q);

// Fetch subjects for student's department
$subjects_q = mysqli_query($conn, "
    SELECT * FROM subjects WHERE dept_id = '".$student['dept_id']."'
");

// Fetch marks for the student
$marks_q = mysqli_query($conn, "
    SELECT m.*, s.subject_name 
    FROM marks m
    LEFT JOIN subjects s ON m.subject_id = s.subject_id
    WHERE m.student_id = '$student_id'
");

// Convert marks into an array for easy matching
$marks_arr = [];
while ($m = mysqli_fetch_assoc($marks_q)) {
    $marks_arr[$m['subject_id']] = $m;
}

// Attendance helper function
function getAttendance($conn, $student_id, $subject_id) {
    $total_q = mysqli_query($conn, "
        SELECT COUNT(*) AS total
        FROM attendance
        WHERE student_id='$student_id' AND subject_id='$subject_id'
    ");
    $total = intval(mysqli_fetch_assoc($total_q)['total']);

    if ($total == 0) return "No Data";

    $present_q = mysqli_query($conn, "
        SELECT COUNT(*) AS present
        FROM attendance
        WHERE student_id='$student_id' AND subject_id='$subject_id' AND status='Present'
    ");
    $present = intval(mysqli_fetch_assoc($present_q)['present']);

    $percent = round(($present / $total) * 100);
    return $percent . "%";
}

// Build HTML
$html = "
<style>
body { font-family: Arial, sans-serif; }
h2 { text-align: center; }
.table { width: 100%; border-collapse: collapse; margin-top: 20px; }
.table th, .table td { border: 1px solid #444; padding: 10px; text-align: left; }
.header-box {
    padding: 15px;
    background: #f0f4ff;
    border: 1px solid #ccc;
    border-radius: 8px;
}
</style>

<h2>Student Marksheet</h2>

<div class='header-box'>
<b>Name:</b> {$student['name']}<br>
<b>Email:</b> {$student['email']}<br>
<b>Course:</b> {$student['course']}<br>
<b>Department:</b> {$student['dept_name']}<br>
<b>Student ID:</b> {$student['id']}<br>
</div>

<h3>Subject-wise Marks & Attendance</h3>

<table class='table'>
<tr>
    <th>Subject</th>
    <th>Marks Obtained</th>
    <th>Max Marks</th>
    <th>Attendance %</th>
</tr>
";

// Fill table rows for each subject
while ($sub = mysqli_fetch_assoc($subjects_q)) {

    $sub_id = $sub['subject_id'];
    $subject_name = $sub['subject_name'];

    $obt_marks = isset($marks_arr[$sub_id]) ? $marks_arr[$sub_id]['marks_obtained'] : "N/A";
    $max_marks = isset($marks_arr[$sub_id]) ? $marks_arr[$sub_id]['max_marks'] : "N/A";

    $attendance = getAttendance($conn, $student_id, $sub_id);

    $html .= "
    <tr>
        <td>$subject_name</td>
        <td>$obt_marks</td>
        <td>$max_marks</td>
        <td>$attendance</td>
    </tr>
    ";
}

$html .= "</table>";

$pdf = new Dompdf();
$pdf->loadHtml($html);
$pdf->setPaper('A4', 'portrait');
$pdf->render();
$pdf->stream("marksheet_{$student_id}.pdf", ["Attachment" => true]);
?>
