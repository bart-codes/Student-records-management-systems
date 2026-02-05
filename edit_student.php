<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['usertype'] != 'admin') {
    header('location:login.php');
    exit();
}

require_once 'db.php';

$student = null;
$error = '';
$success = '';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: list_students.php');
    exit();
}

$student_id = (int)$_GET['id'];

// Fetch student
$stmt = $conn->prepare('SELECT id, username FROM user WHERE id = ? AND usertype = "student"');
$stmt->bind_param('i', $student_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows !== 1) {
    header('Location: list_students.php');
    exit();
}
$student = $result->fetch_assoc();

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($username === '') {
        $error = 'Username is required.';
    } else {
        // Check if new username is unique
        $check = $conn->prepare('SELECT id FROM user WHERE username = ? AND id != ?');
        $check->bind_param('si', $username, $student_id);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $error = 'Username already taken.';
        } else {
            if ($password !== '') {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $upd = $conn->prepare('UPDATE user SET username = ?, password = ? WHERE id = ?');
                $upd->bind_param('ssi', $username, $hashed, $student_id);
            } else {
                $upd = $conn->prepare('UPDATE user SET username = ? WHERE id = ?');
                $upd->bind_param('si', $username, $student_id);
            }
            if ($upd->execute()) {
                $success = 'Student updated successfully!';
                $student['username'] = $username;
            } else {
                $error = 'Error updating student.';
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
    <title>Edit Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container" style="margin-top: 80px; max-width: 600px; margin-left: auto; margin-right: auto;">
    <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <h1 style="color: #1e3a8a; margin-bottom: 10px;">Edit Student</h1>
        
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
            <label style="color: #0f172a; margin-top: 15px; font-weight: 500;">Username</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($student['username']); ?>" required style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 5px;">
            
            <label style="color: #0f172a; margin-top: 15px; font-weight: 500;">New Password (leave blank to keep current)</label>
            <input type="password" name="password" style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 5px;">
            
            <button type="submit" style="background: #2563eb; color: white; padding: 10px 16px; border: none; border-radius: 6px; margin-top: 20px; cursor: pointer; font-weight: 500;">Update Student</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
