<?php
session_start();
include "db.php";

if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM faculty WHERE faculty_id='$id'");

header("Location: admin_faculty.php");
exit();
?>
