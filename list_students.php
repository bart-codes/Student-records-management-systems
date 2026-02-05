<?php
session_start();

// Session timeout (30 minutes)
$timeout = 30 * 60;
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}
$_SESSION['last_activity'] = time();

if (!isset($_SESSION['username']) || $_SESSION['usertype'] != 'admin') {
    header('location:login.php');
    exit();
}

require_once 'db.php';

$students = [];
$error = '';
$success = '';

// Handle delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $student_id = (int)$_GET['delete'];
    $del_stmt = $conn->prepare('DELETE FROM user WHERE id = ? AND usertype = "student"');
    $del_stmt->bind_param('i', $student_id);
    if ($del_stmt->execute()) {
        $success = 'Student deleted successfully.';
    } else {
        $error = 'Error deleting student.';
    }
}

// Fetch all students
$stmt = $conn->prepare('SELECT id, username, created_at FROM user WHERE usertype = "student" ORDER BY created_at DESC');
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Students</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { padding-top: 90px; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container" style="margin-top: 80px; max-width: 1200px; margin-left: auto; margin-right: auto;">
    <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <h1 style="color: #1e3a8a; margin-bottom: 10px;">Manage Students</h1>
        
        <?php if ($error): ?>
            <div style="background: #fecaca; color: #991b1b; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div style="background: #bbf7d0; color: #166534; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>
        
        <a href="add_student.php" style="background: #2563eb; color: white; padding: 10px 16px; text-decoration: none; border-radius: 6px; display: inline-block; margin-bottom: 20px;">+ Add New Student</a>
        
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f1f5f9; border-bottom: 2px solid #e2e8f0;">
                    <th style="padding: 12px; text-align: left; color: #0f172a;">ID</th>
                    <th style="padding: 12px; text-align: left; color: #0f172a;">Username</th>
                    <th style="padding: 12px; text-align: left; color: #0f172a;">Joined</th>
                    <th style="padding: 12px; text-align: center; color: #0f172a;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 12px;"><?php echo $student['id']; ?></td>
                        <td style="padding: 12px;"><?php echo htmlspecialchars($student['username']); ?></td>
                        <td style="padding: 12px;"><?php echo date('M d, Y', strtotime($student['created_at'])); ?></td>
                        <td style="padding: 12px; text-align: center;">
                            <a href="edit_student.php?id=<?php echo $student['id']; ?>" style="color: #2563eb; text-decoration: none; margin-right: 10px;">Edit</a>
                            <a href="list_students.php?delete=<?php echo $student['id']; ?>" onclick="return confirm('Delete this student?');" style="color: #ef4444; text-decoration: none;">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <?php if (empty($students)): ?>
            <p style="text-align: center; color: #64748b; padding: 40px;">No students found.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
