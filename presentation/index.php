<?php
/**
 * presentation/index.php
 *
 * Presentation Layer — Home Page
 * -------------------------------
 * This is the entry point for the application.
 * It does nothing but display navigation links.
 *
 * CONCEPT: The Presentation layer's job is purely to render HTML
 * and handle user input.  It does NOT contain SQL or business rules.
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP &amp; MySQL Training</title>
    <style>
        body        { font-family: Arial, sans-serif; margin: 40px; background: #f4f7f9; color: #333; }
        h1          { color: #2c5f8a; }
        .card       { background: #fff; border-radius: 8px; padding: 24px; max-width: 600px;
                      box-shadow: 0 2px 6px rgba(0,0,0,.12); margin-bottom: 20px; }
        a.btn       { display: inline-block; margin: 8px 8px 0 0; padding: 10px 20px;
                      background: #2c5f8a; color: #fff; text-decoration: none;
                      border-radius: 4px; }
        a.btn:hover { background: #1e4266; }
        .arch       { font-size: .9em; line-height: 1.8; background: #eef3f8;
                      padding: 12px 16px; border-radius: 4px; }
        code        { background: #dde6ef; padding: 2px 5px; border-radius: 3px; }
    </style>
</head>
<body>

<h1>PHP &amp; MySQL Training</h1>
<h2>Three-Tier Architecture Demo — Student Management</h2>

<div class="card">
    <h3>Architecture Layers Used in This Project</h3>
    <div class="arch">
        <strong>Presentation Layer</strong> (<code>presentation/</code>)<br>
        &nbsp;&nbsp;↕ calls<br>
        <strong>Business Logic Layer</strong> (<code>bll/StudentBLL.php</code>)<br>
        &nbsp;&nbsp;↕ calls<br>
        <strong>Data Access Layer</strong> (<code>dal/StudentDAL.php</code>)<br>
        &nbsp;&nbsp;↕ uses PDO<br>
        <strong>MySQL Database</strong> (<code>training_db.students</code>)
    </div>
</div>

<div class="card">
    <h3>Navigate</h3>
    <a class="btn" href="view_students.php">View All Students</a>
    <a class="btn" href="add_student.php">Add New Student</a>
</div>

</body>
</html>
