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
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    if ($username === '' || $password === '') {
        $error = 'Username and password are required.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        // Check if username already exists
        $check = $conn->prepare('SELECT id FROM user WHERE username = ?');
        $check->bind_param('s', $username);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $error = 'Username already exists.';
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare('INSERT INTO user (username, password, usertype) VALUES (?, ?, "student")');
            $stmt->bind_param('ss', $username, $hashed);
            if ($stmt->execute()) {
                $success = 'Student added successfully!';
                $_POST = [];
            } else {
                $error = 'Error adding student.';
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
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { padding-top: 90px; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container" style="margin-top: 80px; max-width: 600px; margin-left: auto; margin-right: auto;">
    <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <h1 style="color: #1e3a8a; margin-bottom: 10px;">Add New Student</h1>
        
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
            <input type="text" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 5px;">
            
            <label style="color: #0f172a; margin-top: 15px; font-weight: 500;">Password</label>
            <input type="password" name="password" required style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 5px;">
            
            <label style="color: #0f172a; margin-top: 15px; font-weight: 500;">Confirm Password</label>
            <input type="password" name="confirm_password" required style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 5px;">
            
            <button type="submit" style="background: #2563eb; color: white; padding: 10px 16px; border: none; border-radius: 6px; margin-top: 20px; cursor: pointer; font-weight: 500;">Add Student</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
