<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Database Management System</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <!-- NAVIGATION BAR -->
  <header>
    <nav class="navbar">
      <div class="logo">Student <span>DBMS</span></div>
      <ul class="nav-links">
        <li><a href="#" onclick="scrollToSection('home')">Home</a></li>
        <li><a href="#" onclick="scrollToSection('features')">Features</a></li>
        <li><a href="#" onclick="scrollToSection('about')">About</a></li>
      </ul>
      <a href="dashboard.php" class="btn-outline">Admin Login</a>
    </nav>
  </header>

  <!-- HERO SECTION -->
  <section id="home" class="hero">
    <div class="hero-content">
      <h1>Student Database <span>Management System</span></h1>
      <p>A modern platform to manage academic records like Students, Faculty & Departments.</p><br>
      <a href="dashboard.php" class="btn-filled">Get Started</a>
    </div>
  </section>

  <!-- FEATURES SECTION -->
  <section id="features" class="features">
    <h2>Core Modules</h2>
    <div class="cards">

      <a href="students.php" style="text-decoration:none; color:black;">
        <div class="card">
          <img src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png">
          <h3>Students</h3>
          <p>Manage student personal and academic details.</p>
        </div>
      </a>

      <a href="department.php" style="text-decoration:none; color:black;">
        <div class="card">
          <img src="https://cdn-icons-png.flaticon.com/512/2920/2920259.png">
          <h3>Departments</h3>
          <p>Manage and organize academic branches.</p>
        </div>
      </a>

      <a href="#" style="text-decoration:none; color:black;">
        <div class="card">
          <img src="https://cdn-icons-png.flaticon.com/512/1048/1048941.png">
          <h3>Faculty</h3>
          <p>Assign faculty to departments and courses.</p>
        </div>
      </a>

    </div>
  </section>

  <!-- ABOUT SECTION -->
  <section id="about" class="about">
    <h2>About This System</h2>
    <p>This DBMS ensures efficient academic data management and enhances transparency between students and institutions.</p>
  </section>

  <!-- FOOTER -->
  <footer>
    <p>© 2025 Student DBMS | Mini Project</p>
  </footer>

  <script src="script.js"></script>
</body>
</html>
