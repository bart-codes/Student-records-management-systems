<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['usertype'] != 'admin') {
    header('location:login.php');
    exit();
}

require_once 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = isset($_POST['course_name']) ? trim($_POST['course_name']) : '';
    $course_code = isset($_POST['course_code']) ? trim($_POST['course_code']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $instructor_name = isset($_POST['instructor_name']) ? trim($_POST['instructor_name']) : '';
    $credits = isset($_POST['credits']) && is_numeric($_POST['credits']) ? (int)$_POST['credits'] : 3;

    if ($course_name === '' || $course_code === '') {
        $error = 'Course name and code are required.';
    } else {
        // Check if course code already exists
        $check = $conn->prepare('SELECT id FROM courses WHERE course_code = ?');
        $check->bind_param('s', $course_code);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $error = 'Course code already exists.';
        } else {
            $stmt = $conn->prepare('INSERT INTO courses (course_name, course_code, description, instructor_name, credits) VALUES (?, ?, ?, ?, ?)');
            $stmt->bind_param('ssssi', $course_name, $course_code, $description, $instructor_name, $credits);
            if ($stmt->execute()) {
                $success = 'Course added successfully!';
                $_POST = [];
            } else {
                $error = 'Error adding course.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Course</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container" style="margin-top: 80px; max-width: 600px; margin-left: auto; margin-right: auto;">
    <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <h1 style="color: #1e3a8a; margin-bottom: 10px;">Add New Course</h1>
        
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
            <input type="text" name="course_name" value="<?php echo isset($_POST['course_name']) ? htmlspecialchars($_POST['course_name']) : ''; ?>" required style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 5px;">
            
            <label style="color: #0f172a; margin-top: 15px; font-weight: 500;">Course Code</label>
            <input type="text" name="course_code" value="<?php echo isset($_POST['course_code']) ? htmlspecialchars($_POST['course_code']) : ''; ?>" required style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 5px;">
            
            <label style="color: #0f172a; margin-top: 15px; font-weight: 500;">Description</label>
            <textarea name="description" style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 5px; height: 100px;"><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
            
            <label style="color: #0f172a; margin-top: 15px; font-weight: 500;">Instructor Name</label>
            <input type="text" name="instructor_name" value="<?php echo isset($_POST['instructor_name']) ? htmlspecialchars($_POST['instructor_name']) : ''; ?>" style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 5px;">
            
            <label style="color: #0f172a; margin-top: 15px; font-weight: 500;">Credits</label>
            <input type="number" name="credits" value="<?php echo isset($_POST['credits']) ? htmlspecialchars($_POST['credits']) : '3'; ?>" min="1" max="6" style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 5px;">
            
            <button type="submit" style="background: #2563eb; color: white; padding: 10px 16px; border: none; border-radius: 6px; margin-top: 20px; cursor: pointer; font-weight: 500;">Add Course</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
