<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['usertype'] != 'admin') {
    header('location:login.php');
    exit();
}

require_once 'db.php';

$course = null;
$error = '';
$success = '';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: list_courses.php');
    exit();
}

$course_id = (int)$_GET['id'];

// Fetch course
$stmt = $conn->prepare('SELECT id, course_name, course_code, description, instructor_name, credits FROM courses WHERE id = ?');
$stmt->bind_param('i', $course_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows !== 1) {
    header('Location: list_courses.php');
    exit();
}
$course = $result->fetch_assoc();

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = isset($_POST['course_name']) ? trim($_POST['course_name']) : '';
    $course_code = isset($_POST['course_code']) ? trim($_POST['course_code']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $instructor_name = isset($_POST['instructor_name']) ? trim($_POST['instructor_name']) : '';
    $credits = isset($_POST['credits']) && is_numeric($_POST['credits']) ? (int)$_POST['credits'] : 3;

    if ($course_name === '' || $course_code === '') {
        $error = 'Course name and code are required.';
    } else {
        $upd = $conn->prepare('UPDATE courses SET course_name = ?, course_code = ?, description = ?, instructor_name = ?, credits = ? WHERE id = ?');
        $upd->bind_param('ssssi', $course_name, $course_code, $description, $instructor_name, $credits, $course_id);
        if ($upd->execute()) {
            $success = 'Course updated successfully!';
            $course['course_name'] = $course_name;
            $course['course_code'] = $course_code;
            $course['description'] = $description;
            $course['instructor_name'] = $instructor_name;
            $course['credits'] = $credits;
        } else {
            $error = 'Error updating course.';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Course</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav style="display: flex; justify-content: space-between; align-items: center; padding: 0 40px;">
    <h2 style="color: white; margin: 0;">Bart Academy Admin</h2>
    <div>
        <a href="list_courses.php" style="color: white; text-decoration: none; margin-right: 20px;">← Back</a>
        <a href="logout.php" class="btn btn-danger" style="background: #ef4444; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px;">Logout</a>
    </div>
</nav>

<div class="container" style="margin-top: 80px; max-width: 600px; margin-left: auto; margin-right: auto;">
    <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <h1 style="color: #1e3a8a; margin-bottom: 10px;">Edit Course</h1>
        
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
        
        <form method="POST" style="display: flex; flex-direction: column;">
            <label style="color: #0f172a; margin-top: 15px; font-weight: 500;">Course Name</label>
            <input type="text" name="course_name" value="<?php echo htmlspecialchars($course['course_name']); ?>" required style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 5px;">
            
            <label style="color: #0f172a; margin-top: 15px; font-weight: 500;">Course Code</label>
            <input type="text" name="course_code" value="<?php echo htmlspecialchars($course['course_code']); ?>" required style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 5px;">
            
            <label style="color: #0f172a; margin-top: 15px; font-weight: 500;">Description</label>
            <textarea name="description" style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 5px; height: 100px;"><?php echo htmlspecialchars($course['description']); ?></textarea>
            
            <label style="color: #0f172a; margin-top: 15px; font-weight: 500;">Instructor Name</label>
            <input type="text" name="instructor_name" value="<?php echo htmlspecialchars($course['instructor_name']); ?>" style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 5px;">
            
            <label style="color: #0f172a; margin-top: 15px; font-weight: 500;">Credits</label>
            <input type="number" name="credits" value="<?php echo $course['credits']; ?>" min="1" max="6" style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 5px;">
            
            <button type="submit" style="background: #2563eb; color: white; padding: 10px 16px; border: none; border-radius: 6px; margin-top: 20px; cursor: pointer; font-weight: 500;">Update Course</button>
        </form>
    </div>
</div>

</body>
</html>
