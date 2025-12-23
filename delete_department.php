<?php
session_start();
include 'db.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM department WHERE id=$id");

header("Location: department.php");
exit();
?>
