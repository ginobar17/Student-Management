<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}
include "db.php";

$departments = mysqli_query($conn, "SELECT * FROM department");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $dept_id = $_POST['dept_id'];
    $password = $_POST['password'];

    mysqli_query($conn, "
        INSERT INTO faculty (name, email, dept_id, password)
        VALUES ('$name', '$email', '$dept_id', '$password')
    ");

    header("Location: admin_faculty.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Faculty</title>
    <link rel="stylesheet" href="style.css">

    <style>

        .faculty-container {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-top: 70px;
        }

        .faculty-card {
            width: 520px;
            background: #fff;
            padding: 45px 40px;
            border-radius: 15px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.15);
            animation: fadeIn 0.3s ease;
        }

        .faculty-card h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 26px;
            color: #333;
            font-weight: 700;
        }

        .faculty-group {
            margin-bottom: 22px;
        }

        .faculty-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .faculty-group input,
        .faculty-group select {
            width: 100%;
            padding: 13px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
            background: #f9f9f9;
            box-sizing: border-box;
        }

        .faculty-group input:focus,
        .faculty-group select:focus {
            border-color: #0a66c2;
            background: #fff;
            box-shadow: 0 0 5px rgba(10,102,194,0.3);
        }

        .faculty-btn {
            width: 100%;
            padding: 15px;
            background: #0a66c2;
            color: white;
            border: none;
            font-size: 17px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
            font-weight: 600;
        }

        .faculty-btn:hover {
            background: #004a99;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

    </style>

</head>

<body>

<div class="faculty-container">
    <div class="faculty-card">
        <h2>Add Faculty</h2>

        <form method="POST">

            <div class="faculty-group">
                <label>Name</label>
                <input type="text" name="name" required>
            </div>

            <div class="faculty-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="faculty-group">
                <label>Department</label>
                <select name="dept_id" required>
                    <option value="">Select Department</option>
                    <?php while($d = mysqli_fetch_assoc($departments)) { ?>
                        <option value="<?= $d['dept_id'] ?>"><?= $d['dept_name'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="faculty-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="faculty-btn">Add Faculty</button>
        </form>
    </div>
</div>

</body>
</html>
