<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['usertype'] != 'admin') {
    header('location:login.php');
    exit();
}

require_once 'db.php';

$courses = [];
$error = '';
$success = '';

// Handle delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $course_id = (int)$_GET['delete'];
    $del_stmt = $conn->prepare('DELETE FROM courses WHERE id = ?');
    $del_stmt->bind_param('i', $course_id);
    if ($del_stmt->execute()) {
        $success = 'Course deleted successfully.';
    } else {
        $error = 'Error deleting course.';
    }
}

// Fetch all courses
$stmt = $conn->prepare('SELECT id, course_name, course_code, instructor_name, credits FROM courses ORDER BY created_at DESC');
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Courses</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav style="display: flex; justify-content: space-between; align-items: center; padding: 0 40px;">
    <h2 style="color: white; margin: 0;">Bart Academy Admin</h2>
    <div>
        <a href="adminhome.php" style="color: white; text-decoration: none; margin-right: 20px;">← Back</a>
        <a href="logout.php" class="btn btn-danger" style="background: #ef4444; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px;">Logout</a>
    </div>
</nav>

<div class="container" style="margin-top: 80px; max-width: 1200px; margin-left: auto; margin-right: auto;">
    <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <h1 style="color: #1e3a8a; margin-bottom: 10px;">Manage Courses</h1>
        
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
        
        <a href="add_course.php" style="background: #2563eb; color: white; padding: 10px 16px; text-decoration: none; border-radius: 6px; display: inline-block; margin-bottom: 20px;">+ Add New Course</a>
        
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f1f5f9; border-bottom: 2px solid #e2e8f0;">
                    <th style="padding: 12px; text-align: left; color: #0f172a;">Course Name</th>
                    <th style="padding: 12px; text-align: left; color: #0f172a;">Code</th>
                    <th style="padding: 12px; text-align: left; color: #0f172a;">Instructor</th>
                    <th style="padding: 12px; text-align: center; color: #0f172a;">Credits</th>
                    <th style="padding: 12px; text-align: center; color: #0f172a;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course): ?>
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 12px;"><?php echo htmlspecialchars($course['course_name']); ?></td>
                        <td style="padding: 12px;"><?php echo htmlspecialchars($course['course_code']); ?></td>
                        <td style="padding: 12px;"><?php echo htmlspecialchars($course['instructor_name'] ?? 'N/A'); ?></td>
                        <td style="padding: 12px; text-align: center;"><?php echo $course['credits']; ?></td>
                        <td style="padding: 12px; text-align: center;">
                            <a href="edit_course.php?id=<?php echo $course['id']; ?>" style="color: #2563eb; text-decoration: none; margin-right: 10px;">Edit</a>
                            <a href="list_courses.php?delete=<?php echo $course['id']; ?>" onclick="return confirm('Delete this course?');" style="color: #ef4444; text-decoration: none;">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <?php if (empty($courses)): ?>
            <p style="text-align: center; color: #64748b; padding: 40px;">No courses found.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
