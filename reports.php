<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['usertype'] != 'admin') {
    header('location:login.php');
    exit();
}

require_once 'db.php';

// Get total students
$students_result = $conn->query('SELECT COUNT(*) as total FROM user WHERE usertype = "student"');
$students_count = $students_result->fetch_assoc()['total'] ?? 0;

// Get total courses
$courses_result = $conn->query('SELECT COUNT(*) as total FROM courses');
$courses_count = $courses_result->fetch_assoc()['total'] ?? 0;

// Get total enrollments
$enrollments_result = $conn->query('SELECT COUNT(*) as total FROM enrollments WHERE status = "active"');
$enrollments_count = $enrollments_result->fetch_assoc()['total'] ?? 0;

// Get enrollments by course
$course_stats = [];
$stmt = $conn->prepare('SELECT c.course_name, COUNT(e.id) as enrollment_count FROM courses c LEFT JOIN enrollments e ON c.id = e.course_id AND e.status = "active" GROUP BY c.id ORDER BY enrollment_count DESC LIMIT 10');
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $course_stats[] = $row;
}

// Get students with most enrollments
$student_enrollments = [];
$stmt = $conn->prepare('SELECT u.username, COUNT(e.id) as enrollment_count FROM user u LEFT JOIN enrollments e ON u.id = e.student_id AND e.status = "active" WHERE u.usertype = "student" GROUP BY u.id ORDER BY enrollment_count DESC LIMIT 10');
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $student_enrollments[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reports Dashboard</title>
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

<div class="container" style="margin-top: 80px; max-width: 1200px; margin-left: auto; margin-right: auto;">
    <h1 style="color: #1e3a8a; margin-bottom: 30px;">Reports & Analytics</h1>
    
    <!-- Stats Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-left: 4px solid #2563eb;">
            <h3 style="color: #64748b; font-size: 14px; margin: 0 0 10px 0;">Total Students</h3>
            <p style="color: #1e3a8a; font-size: 28px; font-weight: 700; margin: 0;"><?php echo $students_count; ?></p>
        </div>
        
        <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-left: 4px solid #06b6d4;">
            <h3 style="color: #64748b; font-size: 14px; margin: 0 0 10px 0;">Total Courses</h3>
            <p style="color: #1e3a8a; font-size: 28px; font-weight: 700; margin: 0;"><?php echo $courses_count; ?></p>
        </div>
        
        <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-left: 4px solid #f59e0b;">
            <h3 style="color: #64748b; font-size: 14px; margin: 0 0 10px 0;">Active Enrollments</h3>
            <p style="color: #1e3a8a; font-size: 28px; font-weight: 700; margin: 0;"><?php echo $enrollments_count; ?></p>
        </div>
    </div>
    
    <!-- Course Enrollments -->
    <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); margin-bottom: 30px;">
        <h2 style="color: #1e3a8a; margin-top: 0; margin-bottom: 20px;">Top Courses by Enrollment</h2>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f1f5f9; border-bottom: 2px solid #e2e8f0;">
                    <th style="padding: 12px; text-align: left; color: #0f172a;">Course Name</th>
                    <th style="padding: 12px; text-align: center; color: #0f172a;">Enrollments</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($course_stats as $stat): ?>
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 12px;"><?php echo htmlspecialchars($stat['course_name']); ?></td>
                        <td style="padding: 12px; text-align: center;">
                            <span style="background: #dbeafe; color: #1e40af; padding: 4px 8px; border-radius: 4px;">
                                <?php echo $stat['enrollment_count']; ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Students with Most Enrollments -->
    <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <h2 style="color: #1e3a8a; margin-top: 0; margin-bottom: 20px;">Top Students by Enrollment</h2>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f1f5f9; border-bottom: 2px solid #e2e8f0;">
                    <th style="padding: 12px; text-align: left; color: #0f172a;">Student</th>
                    <th style="padding: 12px; text-align: center; color: #0f172a;">Courses</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($student_enrollments as $stat): ?>
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 12px;"><?php echo htmlspecialchars($stat['username']); ?></td>
                        <td style="padding: 12px; text-align: center;">
                            <span style="background: #dcfce7; color: #166534; padding: 4px 8px; border-radius: 4px;">
                                <?php echo $stat['enrollment_count']; ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
