<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Student Management Sys</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>
<body>
	<nav>
		<label class ="logo">Student Management System</label>
		<ul>
			<li><a href="">Home</a></li>
			<li><a href="">Contact</a></li>
			<li><a href="">Admissions</a></li>
			<li><a href="login.php" class="btn btn-succes">login</a></li>
		</ul>
	</nav>

	<div class="section1">
		<label class="img_text">We Teach Students</label>
		<img src="main_img" src="school_management.jpg">
		 
	</div>
	<div class="container">

		<div class="row ">
			
			<div class="col-md-4">
				
				<img class="welcome_img" src="school2.jpg">
			</div>

			<div class="col-md-8">

				<h1>Welcome to Student Management System</h1>
				<p>paste paragraph</p>
				
			</div>
		</div>
		
	</div>
	<center>
		
		<h1>Our Teachers</h1>

	</center>


	<div class="container">
		
		<div class="row">

			<div class="col-md-4">
				
				<img class="teacher" src="teacher1">
				<p>placeholder</p>
			</div>
			
		</div>

		<div class="row">
			
			<div class="col-md-4">
				<img class="teacher"  src="teacher2">
				<p>placeholder</p>
				
			</div>
			
		</div>

		<div class="row">
			
			<div class="col-md-4">
				<img class="teacher"  src="teacher3">
				<p>placeholder</p>
				
			</div>
			
		</div>

	</div><center>
		
		<h1>Our courses</h1>

	</center>


	<div class="container">
		
		<div class="row">

			<div class="col-md-4">
				
				<img class="teacher" src="graphics.jpg">
				<h3>Graphics & Design</h3>
				
			</div>
			
		</div>

		<div class="row">
			
			<div class="col-md-4">
				<img class="marketing.jpg">
				<h3>Marketing</h3>
			</div>
			
		</div>

		<div class="row">
			
			<div class="col-md-4">
				<img class="teacher"  src="web.jpg">
				<h3>Web Development</h3>
			</div>
			
		</div>

	</div>

	<center>
		<h1 class="adm">Admission Form</h1>
	</center>

	<div align="center" class="admission_form">
		
		<form>
			
			
			<div class="adm_int"> 
				<label class="label_text">Name</label>
				<input class="input_deg" type="text" name="">
			</div>
			<div class="adm_int">
				<label class="label_text">Email</label>
				<input class="input_deg" type="text" name="">
			</div>
			<div class="adm_int">
				<label class="label_text">Phone</label>
				<input class="input_deg" type="text" name="">
			</div>
			<div class="adm_int">
				<label class="label_text">Message</label>
				<textarea class="input_txt"></textarea>
			</div>

			<div class="adm_int">
				
				<input class="btn btn-primary" id="submit" type="submit" value="apply">	
			</div>

		</form>
	</div>

	<footer class="footer_txt">
		<h3>
			all rights reserved
		</h3>
	</footer>

<?php include 'footer.php'; ?>

</body>
</html>