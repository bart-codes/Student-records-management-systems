<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body background="school2.jpg" class="body_deg">

	<center>
		<div class="form_deg">
			<center class="title_deg">
				Login Form
				<h4>
					<?php
                    session_start();
                    error_reporting(0);
					if (isset($_SESSION['loginMessage'])) {
						echo "<span style='color:#ef4444; font-size:14px;'>".$_SESSION['loginMessage']."</span>";
						unset($_SESSION['loginMessage']);
					}
					?>
				</h4>
			</center>
			<?php
			// CSRF token generation
			if (empty($_SESSION)) { session_start(); }
			if (empty($_SESSION['csrf_token'])) {
			    $_SESSION['csrf_token'] = bin2hex(random_bytes(24));
			}
			?>
			<form action="login_check.php" method="POST" class="login_form">
				<input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
				<div>
					<label class="label_deg" for="username">Username</label>
					<input type="text" id="username" name="username" required placeholder="Enter username" class="form-input">
				</div>
				<div>
					<label class="label_deg" for="password">Password</label>
					<input type="password" id="password" name="password" required placeholder="Enter password" class="form-input">
				</div>
				<div>
					<input class="btn btn-primary" type="submit" name="submit" value="Login" style="width: 100%; cursor: pointer;">
				</div>
			</form>
		</div>
	</center>

</body>
</html>