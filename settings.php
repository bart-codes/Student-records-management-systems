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
    $current_password = isset($_POST['current_password']) ? $_POST['current_password'] : '';
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    if ($current_password === '' || $new_password === '') {
        $error = 'All fields are required.';
    } elseif ($new_password !== $confirm_password) {
        $error = 'New passwords do not match.';
    } else {
        // Verify current password
        $stmt = $conn->prepare('SELECT password FROM user WHERE username = ?');
        $stmt->bind_param('s', $_SESSION['username']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($current_password, $row['password'])) {
                $hashed = password_hash($new_password, PASSWORD_DEFAULT);
                $upd = $conn->prepare('UPDATE user SET password = ? WHERE username = ?');
                $upd->bind_param('ss', $hashed, $_SESSION['username']);
                if ($upd->execute()) {
                    $success = 'Password updated successfully!';
                    $_POST = [];
                } else {
                    $error = 'Error updating password.';
                }
            } else {
                $error = 'Current password is incorrect.';
            }
        } else {
            $error = 'User not found.';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Settings</title>
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

<div class="container" style="margin-top: 80px; max-width: 600px; margin-left: auto; margin-right: auto;">
    <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <h1 style="color: #1e3a8a; margin-bottom: 10px;">Admin Settings</h1>
        
        <div style="background: #f0f4f8; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
            <p style="margin: 0; color: #0f172a;"><strong>Username:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
            <p style="margin: 5px 0 0 0; color: #64748b; font-size: 14px;">Logged in as Admin</p>
        </div>
        
        <h2 style="color: #1e3a8a; font-size: 18px; margin: 30px 0 20px 0;">Change Password</h2>
        
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
            <label style="color: #0f172a; margin-top: 15px; font-weight: 500;">Current Password</label>
            <input type="password" name="current_password" required style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 5px;">
            
            <label style="color: #0f172a; margin-top: 15px; font-weight: 500;">New Password</label>
            <input type="password" name="new_password" required style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 5px;">
            
            <label style="color: #0f172a; margin-top: 15px; font-weight: 500;">Confirm New Password</label>
            <input type="password" name="confirm_password" required style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 5px;">
            
            <button type="submit" style="background: #2563eb; color: white; padding: 10px 16px; border: none; border-radius: 6px; margin-top: 20px; cursor: pointer; font-weight: 500;">Update Password</button>
        </form>
        
        <div style="border-top: 1px solid #e2e8f0; margin-top: 30px; padding-top: 30px;">
            <h2 style="color: #1e3a8a; font-size: 18px; margin-top: 0;">System Info</h2>
            <p style="color: #64748b; margin: 8px 0;"><strong>Database:</strong> MySQL / MariaDB</p>
            <p style="color: #64748b; margin: 8px 0;"><strong>Authentication:</strong> bcrypt hashing, CSRF protection</p>
            <p style="color: #64748b; margin: 8px 0;"><strong>Session Timeout:</strong> 30 minutes of inactivity</p>
        </div>
    </div>
</div>

</body>
</html>
