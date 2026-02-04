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

if (!isset($_SESSION['username']) || $_SESSION['usertype'] != 'student') {
	header("location:login.php");
	exit();
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Student Dashboard</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>

<nav style="display: flex; justify-content: space-between; align-items: center; padding: 0 40px;">
	<h2 style="color: white; margin: 0;">Bart Academy</h2>
	<a href="logout.php" class="btn btn-danger" style="background: #ef4444; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px;">Logout</a>
</nav>

<div class="container" style="margin-top: 80px; max-width: 900px; margin-left: auto; margin-right: auto;">
	<div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
		<h1 style="color: #1e3a8a; margin-bottom: 10px;">Student Dashboard</h1>
		<p style="color: #64748b; margin-bottom: 20px;">Welcome, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></p>
		
		<div style="border-top: 1px solid #e2e8f0; padding-top: 20px;">
			<h3 style="color: #2563eb; margin-bottom: 15px;">Quick Links</h3>
			<ul style="list-style: none; padding: 0;">
				<li style="margin: 8px 0;"><a href="#" style="color: #2563eb; text-decoration: none;">📚 View Courses</a></li>
				<li style="margin: 8px 0;"><a href="#" style="color: #2563eb; text-decoration: none;">📝 My Grades</a></li>
				<li style="margin: 8px 0;"><a href="#" style="color: #2563eb; text-decoration: none;">👤 Profile Settings</a></li>
			</ul>
		</div>
	</div>
</div>

</body>
</html>