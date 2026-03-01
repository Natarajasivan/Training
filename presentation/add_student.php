<?php
/**
 * presentation/add_student.php
 *
 * Presentation Layer — Add Student Form
 * --------------------------------------
 * Handles both displaying the HTML form (GET request) and
 * processing the submitted form data (POST request).
 *
 * CONCEPT: POST vs GET
 *  - GET  : Used to retrieve/display data (no side effects).
 *  - POST : Used to submit data that changes state (insert, update, delete).
 *
 * CONCEPT: htmlspecialchars()
 * Always escape output with htmlspecialchars() before printing it
 * in HTML.  This prevents XSS (Cross-Site Scripting) attacks where
 * a malicious user could inject <script> tags into the page.
 */

// Load the BLL — it will load the DAL and config automatically
require_once __DIR__ . '/../bll/StudentBLL.php';

$errors     = [];
$successMsg = '';
$formData   = ['name' => '', 'email' => '', 'age' => '', 'course' => ''];

// ---------------------------------------------------------------
// Handle form submission (POST)
// ---------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect raw input from the form
    $name   = $_POST['name']   ?? '';
    $email  = $_POST['email']  ?? '';
    $age    = $_POST['age']    ?? '';
    $course = $_POST['course'] ?? '';

    // Keep the submitted values so the form can be re-populated on error
    $formData = compact('name', 'email', 'age', 'course');

    // Delegate validation + insert to the BLL
    $bll    = new StudentBLL();
    $result = $bll->addStudent($name, $email, $age, $course);

    if ($result['success']) {
        $successMsg = 'Student added successfully! (ID: ' . $result['student_id'] . ')';
        $formData   = ['name' => '', 'email' => '', 'age' => '', 'course' => ''];
    } else {
        $errors = $result['errors'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student — PHP &amp; MySQL Training</title>
    <style>
        body          { font-family: Arial, sans-serif; margin: 40px; background: #f4f7f9; color: #333; }
        h1            { color: #2c5f8a; }
        .card         { background: #fff; border-radius: 8px; padding: 24px; max-width: 500px;
                        box-shadow: 0 2px 6px rgba(0,0,0,.12); }
        label         { display: block; margin-top: 14px; font-weight: bold; }
        input, select { width: 100%; padding: 8px; margin-top: 4px; box-sizing: border-box;
                        border: 1px solid #ccc; border-radius: 4px; }
        button        { margin-top: 18px; padding: 10px 24px; background: #2c5f8a;
                        color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        button:hover  { background: #1e4266; }
        .errors       { background: #fde8e8; border: 1px solid #e57373;
                        border-radius: 4px; padding: 12px 16px; margin-bottom: 16px; }
        .errors ul    { margin: 0; padding-left: 18px; }
        .success      { background: #e6f4ea; border: 1px solid #66bb6a;
                        border-radius: 4px; padding: 12px 16px; margin-bottom: 16px; }
        a             { color: #2c5f8a; }
    </style>
</head>
<body>

<h1>Add New Student</h1>
<p><a href="index.php">← Home</a> | <a href="view_students.php">View All Students</a></p>

<div class="card">

    <?php if ($successMsg !== ''): ?>
        <div class="success"><?= htmlspecialchars($successMsg) ?></div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="errors">
            <strong>Please fix the following errors:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!--
        The form uses method="post" so data is sent in the HTTP body,
        not visible in the URL (unlike method="get").
        action="" means the form submits to the same page.
    -->
    <form method="post" action="">

        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" maxlength="100" required
               value="<?= htmlspecialchars($formData['name']) ?>">

        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" maxlength="150" required
               value="<?= htmlspecialchars($formData['email']) ?>">

        <label for="age">Age</label>
        <!--
            Min/max values come from the BLL constants so the HTML
            form and business rules always stay in sync.
        -->
        <input type="number" id="age" name="age"
               min="<?= StudentBLL::MIN_AGE ?>" max="<?= StudentBLL::MAX_AGE ?>" required
               value="<?= htmlspecialchars($formData['age']) ?>">

        <label for="course">Course</label>
        <input type="text" id="course" name="course" maxlength="100" required
               value="<?= htmlspecialchars($formData['course']) ?>">

        <button type="submit">Add Student</button>
    </form>

</div>

</body>
</html>
