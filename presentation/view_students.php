<?php
/**
 * presentation/view_students.php
 *
 * Presentation Layer — View & Manage Students
 * --------------------------------------------
 * Lists all students from the database in an HTML table.
 * Also handles the "Delete" action when a delete link is clicked.
 *
 * CONCEPT: GET parameters (?action=delete&id=3)
 * When the user clicks a delete link, the browser sends a GET
 * request with the action and id in the URL query string.
 * We read these with $_GET and pass them to the BLL for processing.
 */

require_once __DIR__ . '/../bll/StudentBLL.php';

$bll        = new StudentBLL();
$message    = '';
$isError    = false;

// ---------------------------------------------------------------
// Handle delete action (POST form submission)
// Using POST prevents accidental deletion via link prefetching
// and is the correct HTTP method for operations that modify data.
// In a production app you would also verify a CSRF token here.
// ---------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['action'])
    && $_POST['action'] === 'delete'
    && isset($_POST['id'])
) {
    $result  = $bll->deleteStudent($_POST['id']);
    $message = $result['message'];
    $isError = !$result['success'];
}

// ---------------------------------------------------------------
// Fetch all students to display
// ---------------------------------------------------------------
$students = $bll->getAllStudents();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students — PHP &amp; MySQL Training</title>
    <style>
        body          { font-family: Arial, sans-serif; margin: 40px; background: #f4f7f9; color: #333; }
        h1            { color: #2c5f8a; }
        table         { border-collapse: collapse; width: 100%; background: #fff;
                        border-radius: 8px; overflow: hidden;
                        box-shadow: 0 2px 6px rgba(0,0,0,.12); }
        th            { background: #2c5f8a; color: #fff; padding: 12px 14px; text-align: left; }
        td            { padding: 10px 14px; border-bottom: 1px solid #e0e0e0; }
        tr:last-child td { border-bottom: none; }
        tr:hover td   { background: #eef3f8; }
        a             { color: #2c5f8a; }
        a.delete      { color: #c0392b; }
        .msg          { border-radius: 4px; padding: 10px 16px; margin-bottom: 16px;
                        display: inline-block; }
        .msg.ok       { background: #e6f4ea; border: 1px solid #66bb6a; }
        .msg.err      { background: #fde8e8; border: 1px solid #e57373; }
        .empty        { text-align: center; padding: 24px; color: #666; }
    </style>
</head>
<body>

<h1>All Students</h1>
<p><a href="index.php">← Home</a> | <a href="add_student.php">Add New Student</a></p>

<?php if ($message !== ''): ?>
    <div class="msg <?= $isError ? 'err' : 'ok' ?>">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<?php if (empty($students)): ?>
    <p class="empty">No students found. <a href="add_student.php">Add the first student</a>.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Age</th>
                <th>Course</th>
                <th>Enrolled On</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <!-- htmlspecialchars() escapes any special HTML characters in DB data -->
                    <td><?= htmlspecialchars((string) $student['student_id']) ?></td>
                    <td><?= htmlspecialchars($student['name']) ?></td>
                    <td><?= htmlspecialchars($student['email']) ?></td>
                    <td><?= htmlspecialchars((string) $student['age']) ?></td>
                    <td><?= htmlspecialchars($student['course']) ?></td>
                    <td><?= htmlspecialchars($student['enrolled_on']) ?></td>
                    <td>
                        <!--
                            Delete uses a POST form — not a plain link — because:
                            a) GET links can be prefetched/crawled by browsers, causing
                               accidental deletions.
                            b) Only POST (or DELETE) methods should modify server state.
                            In a production app a CSRF token would be included in the form.
                        -->
                        <form method="post" action="view_students.php"
                              onsubmit="return confirm('Delete <?= htmlspecialchars($student['name'], ENT_QUOTES) ?>?')"
                              style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id"
                                   value="<?= (int) $student['student_id'] ?>">
                            <button type="submit"
                                    style="background:none;border:none;color:#c0392b;
                                           cursor:pointer;padding:0;font-size:1em;">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>
