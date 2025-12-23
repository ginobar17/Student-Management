<?php
session_start();
session_destroy();
header("Location: role_select.php");
exit();
?>