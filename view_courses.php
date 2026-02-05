<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location:login.php');
    exit();
}
require_once 'db.php';

$courses = [];
$stmt = $conn->prepare('SELECT id, course_name, course_code, instructor_name, credits, description FROM courses ORDER BY course_name');
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Courses</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { padding-top: 90px; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container" style="margin-top: 80px; max-width: 1000px; margin-left: auto; margin-right: auto;">
    <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.06);">
        <h1 style="color: #1e3a8a; margin-bottom: 10px;">Available Courses</h1>
        <?php if (empty($courses)): ?>
            <p style="color: #64748b;">No courses available.</p>
        <?php else: ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fit,minmax(280px,1fr)); gap: 16px;">
                <?php foreach ($courses as $c): ?>
                    <div style="border: 1px solid #e6eef8; padding: 14px; border-radius: 8px; background: #fff;">
                        <h3 style="margin:0 0 8px 0; color: #0f172a"><?php echo htmlspecialchars($c['course_name']); ?></h3>
                        <p style="margin:0 0 6px 0; color: #64748b;"><strong>Code:</strong> <?php echo htmlspecialchars($c['course_code']); ?></p>
                        <p style="margin:0 0 6px 0; color: #64748b;"><strong>Instructor:</strong> <?php echo htmlspecialchars($c['instructor_name'] ?? 'N/A'); ?></p>
                        <p style="margin:0 0 6px 0; color: #64748b;"><strong>Credits:</strong> <?php echo (int)$c['credits']; ?></p>
                        <?php if (!empty($c['description'])): ?><p style="margin-top:8px; color:#475569"><?php echo nl2br(htmlspecialchars($c['description'])); ?></p><?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
