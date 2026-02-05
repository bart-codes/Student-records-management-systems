<?php
session_start();
// Admission page
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$first_name = $_POST['first_name'] ?? '';
	$last_name = $_POST['last_name'] ?? '';
	$email = $_POST['email'] ?? '';
	$phone = $_POST['phone'] ?? '';
	$course = $_POST['course'] ?? '';
	$message = $_POST['message'] ?? '';

	if (empty($first_name) || empty($last_name) || empty($email) || empty($phone) || empty($course)) {
		$error = 'All fields are required.';
	} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$error = 'Please enter a valid email address.';
	} else {
		// In production, store in database or send confirmation email
		$success = 'Thank you for your application! We will review your submission and contact you soon.';
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admissions - Student Management System</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<style>
		body { padding-top: 90px; }
	</style>
</head>
<body>
	<?php include 'navbar.php'; ?>

	<div class="container" style="padding: 40px; max-width: 800px; margin-bottom: 60px;">
		<h1 style="color: #1e3a8a; text-align: center; margin-bottom: 10px;">Apply for Admission</h1>
		<p style="text-align: center; color: #64748b; margin-bottom: 30px;">Join our institution and start your journey toward success</p>

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
				<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
					<div>
						<label style="color: #0f172a; font-weight: 500;">First Name *</label>
						<input type="text" name="first_name" required style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 6px; width: 100%;">
					</div>
					<div>
						<label style="color: #0f172a; font-weight: 500;">Last Name *</label>
						<input type="text" name="last_name" required style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 6px; width: 100%;">
					</div>
				</div>

				<label style="margin-top: 15px; color: #0f172a; font-weight: 500;">Email Address *</label>
				<input type="email" name="email" required style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 6px;">

				<label style="margin-top: 15px; color: #0f172a; font-weight: 500;">Phone Number *</label>
				<input type="tel" name="phone" required style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 6px;">

				<label style="margin-top: 15px; color: #0f172a; font-weight: 500;">Preferred Course *</label>
				<select name="course" required style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 6px;">
					<option value="">Select a course</option>
					<option value="Web Development">Introduction to Web Development</option>
					<option value="Database Design">Database Design</option>
					<option value="Graphics & Design">Graphics & Design</option>
				</select>

				<label style="margin-top: 15px; color: #0f172a; font-weight: 500;">Additional Message</label>
				<textarea name="message" rows="4" style="padding: 10px; border: 1px solid #06b6d4; border-radius: 6px; margin-top: 6px;"></textarea>

				<button type="submit" style="background: #2563eb; color: white; padding: 12px 16px; border: none; border-radius: 6px; margin-top: 20px; font-weight: 500; cursor: pointer;">Submit Application</button>
			</form>
		</div>

		<div style="background: #f0f4f8; padding: 20px; border-radius: 8px; margin-top: 30px;">
			<h3 style="color: #1e3a8a;">Admission Requirements</h3>
			<ul style="color: #0f172a; line-height: 1.8;">
				<li>High school diploma or equivalent</li>
				<li>Complete application form</li>
				<li>Official transcript</li>
				<li>Letter of recommendation (optional)</li>
				<li>Essay or statement of purpose (optional)</li>
			</ul>
		</div>
	</div>

	<?php include 'footer.php'; ?>
</body>
</html>
