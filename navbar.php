<?php
// Navbar component - include at the top of each page after session_start()
// Dynamically shows logout if logged in, home if not logged in
?>
<nav>
	<label class="logo">Student Management System</label>
	<ul>
		<?php if (isset($_SESSION['username'])): ?>
			<!-- User is logged in -->
			<?php if ($_SESSION['usertype'] === 'admin'): ?>
				<li><a href="adminhome.php">Dashboard</a></li>
			<?php else: ?>
				<li><a href="studenthome.php">Dashboard</a></li>
			<?php endif; ?>
			<li><a href="contact.php">Contact</a></li>
			<li><a href="logout.php" class="btn btn-danger" style="background: #ef4444; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px;">Logout</a></li>
		<?php else: ?>
			<!-- User is not logged in -->
			<li><a href="index.php">Home</a></li>
			<li><a href="contact.php">Contact</a></li>
			<li><a href="admission.php">Admissions</a></li>
			<li><a href="login.php" class="btn btn-succes">Login</a></li>
		<?php endif; ?>
	</ul>
</nav>
