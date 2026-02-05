<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home - Student Management System</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<style>
		body { padding-top: 90px; }
		.modal-backdrop.in { opacity: 0.5; }
	</style>
</head>
<body>
<?php session_start(); ?>
<?php include 'navbar.php'; ?>

	<div class="section1">
		<label class="img_text">Welcome to Our Institution</label>
		<img class="main_img" src="school1.jpg">
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<img class="welcome_img" src="school2.jpg">
			</div>
			<div class="col-md-8">
				<h1>Student Management System</h1>
				<p>Our institution provides a comprehensive student management system designed to streamline educational administration and enhance student success. We are committed to excellence in teaching and learning.</p>
				<p style="margin-top: 15px;">Explore our programs, meet our faculty, and learn about the opportunities available to our students.</p>
			</div>
		</div>
	</div>

	<center>
		<h1>Why Choose Us?</h1>
	</center>

	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<h3 style="color: #2563eb;">Quality Education</h3>
				<p>We provide world-class education with experienced faculty and modern curriculum designed for today's challenges.</p>
			</div>
			<div class="col-md-4">
				<h3 style="color: #2563eb;">Advanced Technology</h3>
				<p>Our digital platform ensures seamless enrollment, grade tracking, and student-faculty communication.</p>
			</div>
			<div class="col-md-4">
				<h3 style="color: #2563eb;">Student Support</h3>
				<p>We're committed to your success with comprehensive support services and mentorship programs.</p>
			</div>
		</div>
	</div>

	<center>
		<h1>Our Teachers</h1>
	</center>

	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<img class="teacher" src="teacher1.jpg">
				<p>"Teaching is the ultimate act of optimism because every lesson plan is an investment in a brighter tomorrow. I believe that effective classroom leadership starts with building a culture of empathy and mutual respect, where every voice feels heard. By fostering an inclusive learning environment, we empower students to embrace their unique strengths and develop the confidence needed to navigate an ever-changing world."</p>
			</div>
			<div class="col-md-4">
				<img class="teacher"  src="teacher2.jpg">
				<p>"True education isn't about filling a bucket; it's about lighting a fire that stays lit long after the final bell rings. As a teacher, my goal is to spark a lifelong passion for learning by showing students that every challenge is an opportunity for growth. When we prioritize student engagement and curiosity, we transform the classroom into a launchpad for the next generation of innovators and thinkers.</p>
			</div>
			<div class="col-md-4">
				<img class="teacher"  src="teacher3.jpg">
				<p>"Education is not the filling of a vessel, but the kindling of a flame. My role as an educator is to ignite curiosity and inspire students to pursue their passions with confidence and determination. I believe that every student has unique potential waiting to be unlocked, and it's my responsibility to create an environment where that potential can flourish."</p>
			</div>
		</div>
	</div>

	<center>
		<h1>Our Courses</h1>
	</center>

	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<img class="teacher" src="graphics.jpg">
				<h3>Graphics & Design</h3>
			</div>
			<div class="col-md-4">
				<img class="teacher"  src="marketing.jpg">
				<h3>Marketing</h3>
			</div>
			<div class="col-md-4">
				<img class="teacher"  src="web.jpg">
				<h3>Web Development</h3>
			</div>
		</div>
	</div>

	<center>
		<h1 class="adm">Get Started</h1>
	</center>

	<div style="text-align: center; margin: 40px 0;">
		<p style="font-size: 18px; margin-bottom: 20px;">Ready to join us? Apply for admission today!</p>
		<a href="admission.php" class="btn btn-primary" style="background: #2563eb; border: none; padding: 12px 30px; font-size: 16px; font-weight: 500; text-decoration: none; color: white; display: inline-block;">Apply Now</a>
	</div>

	<!-- Admission Modal -->
	<div class="modal fade" id="admissionModal" tabindex="-1" role="dialog" aria-labelledby="admissionLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="admissionLabel">Apply for Admission</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form method="POST" action="admission.php" style="display: flex; flex-direction: column;">
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

						<div style="display: flex; gap: 10px; margin-top: 20px;">
							<button type="submit" style="background: #2563eb; color: white; padding: 12px 16px; border: none; border-radius: 6px; font-weight: 500; cursor: pointer; flex: 1;">Submit Application</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal" style="flex: 1;">Cancel</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<?php include 'footer.php'; ?>
</body>
</html>
