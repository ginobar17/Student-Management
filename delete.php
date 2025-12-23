<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include "db.php";

$id = $_GET['id'];

// DELETE CHILD TABLES FIRST
mysqli_query($conn, "DELETE FROM attendance WHERE student_id='$id'");
mysqli_query($conn, "DELETE FROM marks WHERE student_id='$id'");

// NOW DELETE THE STUDENT
mysqli_query($conn, "DELETE FROM students WHERE id='$id'");

// Redirect
header("Location: students.php");
exit();
?>
