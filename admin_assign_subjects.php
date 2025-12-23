<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

include "db.php";

// Fetch faculty list
$faculty_list = mysqli_query($conn, "
    SELECT faculty_id, name FROM faculty
");

// Fetch subjects
$subjects = mysqli_query($conn, "
    SELECT subject_id, subject_name, d.dept_name
    FROM subjects s
    LEFT JOIN department d ON s.dept_id = d.dept_id
");

// When form submitted
if (isset($_POST['assign'])) {

    $faculty_id = $_POST['faculty_id'];
    $subject_id = $_POST['subject_id'];

    // Prevent duplicate assignment
    $check = mysqli_query($conn, "
        SELECT * FROM faculty_subject
        WHERE faculty_id='$faculty_id'
        AND subject_id='$subject_id'
    ");

    if (mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "
            INSERT INTO faculty_subject (faculty_id, subject_id)
            VALUES ('$faculty_id', '$subject_id')
        ");
        $success = "Subject Assigned Successfully!";
    } else {
        $error = "This subject is already assigned to this faculty!";
    }
}

// Fetch all assignments for display
$assignments = mysqli_query($conn, "
    SELECT fs.id, f.name AS faculty, s.subject_name AS subject, d.dept_name AS dept
    FROM faculty_subject fs
    INNER JOIN faculty f ON fs.faculty_id = f.faculty_id
    INNER JOIN subjects s ON fs.subject_id = s.subject_id
    INNER JOIN department d ON s.dept_id = d.dept_id
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Assign Subjects to Faculty</title>
<link rel="stylesheet" href="style.css">

<style>
    .msg-success { background:#d4ffe0; padding:10px; border-left:5px solid green; }
    .msg-error { background:#ffe0e0; padding:10px; border-left:5px solid red; }
</style>
</head>

<body>

<header>
  <nav class="navbar">
    <div class="logo">Student <span>DBMS</span></div>
    <ul class="nav-links">
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="admin_faculty.php">Faculty</a></li>
      <li><a href="admin_subjects.php">Subjects</a></li>
      <li><a href="admin_assign_subjects.php" class="active">Assign Subjects</a></li>
    </ul>
    <a href="logout.php" class="btn-outline">Logout</a>
  </nav>
</header>

<section class="features">

<h2>Assign Subject to Faculty</h2>

<?php if(isset($success)) { ?>
    <p class="msg-success"><?= $success ?></p>
<?php } ?>

<?php if(isset($error)) { ?>
    <p class="msg-error"><?= $error ?></p>
<?php } ?>


<form method="POST" class="form-section">

<label>Select Faculty:</label>
<select name="faculty_id" required>
    <option value="">Select Faculty</option>
    <?php while($f = mysqli_fetch_assoc($faculty_list)) { ?>
        <option value="<?= $f['faculty_id'] ?>"><?= $f['name'] ?></option>
    <?php } ?>
</select>

<label>Select Subject:</label>
<select name="subject_id" required>
    <option value="">Select Subject</option>
    <?php while($s = mysqli_fetch_assoc($subjects)) { ?>
        <option value="<?= $s['subject_id'] ?>">
            <?= $s['subject_name'] ?> (<?= $s['dept_name'] ?>)
        </option>
    <?php } ?>
</select>

<button type="submit" name="assign" class="btn-filled">Assign Subject</button>

</form>


<!-- Assignment Table -->
<h2>Current Assignments</h2>

<table class="styled-table">
    <thead>
        <tr>
            <th>Faculty</th>
            <th>Subject</th>
            <th>Department</th>
        </tr>
    </thead>

    <tbody>
        <?php while($row = mysqli_fetch_assoc($assignments)) { ?>
            <tr>
                <td><?= $row['faculty'] ?></td>
                <td><?= $row['subject'] ?></td>
                <td><?= $row['dept'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

</section>

</body>
</html>
