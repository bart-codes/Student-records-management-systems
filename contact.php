<?php
session_start();
// Contact page
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$name = $_POST['name'] ?? '';
	$email = $_POST['email'] ?? '';
	$subject = $_POST['subject'] ?? '';
	$message = $_POST['message'] ?? '';

	if (empty($name) || empty($email) || empty($subject) || empty($message)) {
		$error = 'All fields are required.';
	} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$error = 'Please enter a valid email address.';
	} else {
		// In production, send email or store in database
		// For now, just show success message
		$success = 'Thank you for contacting us! We will get back to you soon.';
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Contact Us - Student Management System</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<style>
		body { padding-top: 90px; }
	</style>
</head>
<body>
	<?php include 'navbar.php'; ?>

	<div class="container" style="padding: 40px; max-width: 700px;">
		<h1 style="color: #1e3a8a; text-align: center; margin-bottom: 40px;">Contact Us</h1>

		<?php if ($success): ?>
			<div style="background: #bbf7d0; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
				<?php echo htmlspecialchars($success); ?>
			</div>
		<?php endif; ?>

		<?php if ($error): ?>
			<div style="background: #fecaca; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
				<?php echo htmlspecialchars($error); ?>
			</div>
		<?php endif; ?>

		<div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.06);">
			<form method="POST" style="display: flex; flex-direction: column;">
				<label style="margin-top: 12px; color: #0f172a; font-weight: 500;">Name</label>
				<input type="text" name="name" required style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 6px;">

				<label style="margin-top: 12px; color: #0f172a; font-weight: 500;">Email</label>
				<input type="email" name="email" required style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 6px;">

				<label style="margin-top: 12px; color: #0f172a; font-weight: 500;">Subject</label>
				<input type="text" name="subject" required style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 6px;">

				<label style="margin-top: 12px; color: #0f172a; font-weight: 500;">Message</label>
				<textarea name="message" required rows="6" style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 6px;"></textarea>

				<button type="submit" style="background: #2563eb; color: white; padding: 12px 16px; border: none; border-radius: 6px; margin-top: 20px; font-weight: 500; cursor: pointer;">Send Message</button>
			</form>

			<div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid #e2e8f0;">
				<h3 style="color: #1e3a8a; margin-bottom: 15px;">Get in Touch</h3>
				<p style="color: #64748b; margin: 8px 0;"><strong>Email:</strong> info@studentsystem.edu</p>
				<p style="color: #64748b; margin: 8px 0;"><strong>Phone:</strong> +1 (555) 123-4567</p>
				<p style="color: #64748b; margin: 8px 0;"><strong>Address:</strong> 123 Education Avenue, Learning City, LC 12345</p>
				<p style="color: #64748b; margin: 8px 0;"><strong>Hours:</strong> Monday - Friday, 9:00 AM - 5:00 PM</p>
			</div>
		</div>
	</div>

	<?php include 'footer.php'; ?>
</body>
</html>
