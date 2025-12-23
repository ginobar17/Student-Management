<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Students</title>
<link rel="stylesheet" href="style.css">

<style>

/* Header cleanup */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 40px;
    background: #4A90E2;
    color: white;
}

.navbar .logo {
    font-size: 22px;
    font-weight: bold;
}

/* Remove nav links completely */
.nav-links { 
    display: none; 
}

/* Center title */
.students-section h2 {
    text-align: center;
    margin-top: 20px;
    font-size: 28px;
}

/* Center the table container */
.table-container {
    width: 80%;
    margin: 30px auto;
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.1);
}

/* Reduce table width + center text */
.styled-table {
    width: 100%;
    border-collapse: collapse;
}

/* Header style */
.styled-table thead tr {
    background-color: #4A90E2;
    color: #ffffff;
    text-align: left;
    font-size: 16px;
}

/* Table cells */
.styled-table th, 
.styled-table td {
    padding: 12px;
    border-bottom: 1px solid #dddddd;
    text-align: center;
}

/* Row hover */
.styled-table tbody tr:hover {
    background-color: #f0f6ff;
}

/* Buttons */
.btn-filled, .btn-view, .btn-edit, .btn-delete {
    padding: 6px 14px;
    border-radius: 6px;
    color: white;
    text-decoration: none;
    font-size: 14px;
}

.btn-filled {
    background: #4A90E2;
}

.btn-view {
    background: #357ABD;
}

.btn-edit {
    background: #28a745;
}

.btn-delete {
    background: #d11a2a;
}

.action-row {
    text-align: center;
    margin-bottom: 10px;
}

</style>
</head>

<body>

<header>
    <nav class="navbar">
        <div class="logo">Student <span>DBMS</span></div>
        <a href="logout.php" class="btn-outline">Logout</a>
    </nav>
</header>

<section class="students-section">

    <h2>Student Records</h2>

    <div class="action-row">
        <a href="add.php" class="btn-filled">Add New Student</a>
    </div>

    <div class="table-container">

        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>Department</th>
                    <th>View Marks</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $sql = "SELECT s.*, d.dept_name 
                        FROM students s
                        LEFT JOIN department d ON s.dept_id = d.dept_id";
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        echo "<tr>";
                        echo "<td>".$row['id']."</td>";
                        echo "<td>".$row['name']."</td>";
                        echo "<td>".$row['email']."</td>";
                        echo "<td>".$row['course']."</td>";
                        echo "<td>".($row['dept_name'] ?? "Not Assigned")."</td>";

                        echo "<td><a class='btn-view' href='student_dashboard.php?id=".$row['id']."'>View Marks</a></td>";
                        echo "<td><a class='btn-edit' href='edit.php?id=".$row['id']."'>Edit</a></td>";
                        echo "<td><a class='btn-delete' href='delete.php?id=".$row['id']."'>Delete</a></td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No Records Found</td></tr>";
                }
                ?>
            </tbody>
        </table>

    </div>

</section>

</body>
</html>
