<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location:login.php');
    exit();
}
require_once 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($current_password === '' || $new_password === '') {
        $error = 'All fields are required.';
    } elseif ($new_password !== $confirm_password) {
        $error = 'New passwords do not match.';
    } else {
        $stmt = $conn->prepare('SELECT password FROM user WHERE username = ?');
        $stmt->bind_param('s', $_SESSION['username']);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows === 1) {
            $row = $res->fetch_assoc();
            if (password_verify($current_password, $row['password'])) {
                $hashed = password_hash($new_password, PASSWORD_DEFAULT);
                $upd = $conn->prepare('UPDATE user SET password = ? WHERE username = ?');
                $upd->bind_param('ss', $hashed, $_SESSION['username']);
                if ($upd->execute()) {
                    $success = 'Password updated successfully!';
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
    <title>Profile Settings</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { padding-top: 90px; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container" style="margin-top: 80px; max-width: 600px; margin-left: auto; margin-right: auto;">
    <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.06);">
        <h1 style="color:#1e3a8a; margin-bottom:10px;">Profile Settings</h1>
        <?php if ($error): ?>
            <div style="background:#fecaca; color:#991b1b; padding:10px; border-radius:6px; margin-bottom:12px"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div style="background:#bbf7d0; color:#166534; padding:10px; border-radius:6px; margin-bottom:12px"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="POST" style="display:flex; flex-direction:column;">
            <label style="margin-top:10px; color:#0f172a;">Current Password</label>
            <input type="password" name="current_password" required style="padding:8px; border:1px solid #06b6d4; border-radius:6px; margin-top:6px;">

            <label style="margin-top:10px; color:#0f172a;">New Password</label>
            <input type="password" name="new_password" required style="padding:8px; border:1px solid #06b6d4; border-radius:6px; margin-top:6px;">

            <label style="margin-top:10px; color:#0f172a;">Confirm New Password</label>
            <input type="password" name="confirm_password" required style="padding:8px; border:1px solid #06b6d4; border-radius:6px; margin-top:6px;">

            <button type="submit" style="background:#2563eb; color:white; padding:10px 14px; border:none; border-radius:6px; margin-top:12px;">Update Password</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
