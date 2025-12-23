<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Select Role - Student DBMS</title>

<style>
    body {
        font-family: Arial;
        background: linear-gradient(135deg, #2d2f30ff, #514e54ff);
        margin: 0;
        padding: 0;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #fff;
    }

    .container {
        width: 90%;
        max-width: 900px;
        text-align: center;
    }

    h1 {
        margin-bottom: 20px;
        font-size: 36px;
        font-weight: bold;
    }

    .role-box {
        display: flex;
        justify-content: space-around;
        margin-top: 40px;
        flex-wrap: wrap;
    }

    .card {
        background: white;
        width: 250px;
        padding: 25px;
        margin: 10px;
        border-radius: 16px;
        color: black;
        text-align: center;
        box-shadow: 0 6px 18px rgba(0,0,0,0.2);
        transition: 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        display: block;
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.3);
    }

    .card img {
        width: 70px;
        margin-bottom: 15px;
    }

    .card h3 {
        margin: 10px 0;
        font-size: 22px;
        color: #333;
    }

    .card p {
        color: #555;
    }
</style>

</head>
<body>

<div class="container">
    <h1>Welcome to Student Database Management System</h1>
    <p>Please select your role to continue</p>

    <div class="role-box">

        <!-- Faculty -->
        <a href="faculty_login.php" class="card">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135810.png">
            <h3>Faculty</h3>
            <p>Record attendance and marks</p>
        </a>

        <!-- Student -->
        <a href="student_login.php" class="card">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png">
            <h3>Student</h3>
            <p>View profile, attendance & results</p>
        </a>
        
        <!-- Admin -->
        <a href="admin_login.php" class="card">
            <img src="https://cdn-icons-png.flaticon.com/512/1828/1828640.png">
            <h3>Admin</h3>
            <p>Manage system-wide configuration</p>
        </a>

    </div>
</div>

</body>
</html>
