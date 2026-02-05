<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['usertype'] !== 'student') {
    header('location:login.php');
    exit();
}
require_once 'db.php';

$student_id_stmt = $conn->prepare('SELECT id FROM user WHERE username = ? LIMIT 1');
$student_id_stmt->bind_param('s', $_SESSION['username']);
$student_id_stmt->execute();
$res = $student_id_stmt->get_result();
$student = $res->fetch_assoc();
$student_id = $student['id'] ?? 0;

$grades = [];
$stmt = $conn->prepare('SELECT c.course_name, g.assignment_name, g.score, g.max_score, g.grade_date FROM grades g JOIN enrollments e ON g.enrollment_id = e.id JOIN courses c ON e.course_id = c.id WHERE e.student_id = ? ORDER BY g.grade_date DESC');
$stmt->bind_param('i', $student_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $grades[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Grades</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { padding-top: 90px; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container" style="margin-top: 80px; max-width: 900px; margin-left: auto; margin-right: auto;">
    <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.06);">
        <h1 style="color: #1e3a8a; margin-bottom: 10px;">My Grades</h1>
        <?php if (empty($grades)): ?>
            <p style="color: #64748b;">No grades available yet.</p>
        <?php else: ?>
            <table style="width:100%; border-collapse: collapse;">
                <thead>
                    <tr style="background:#f1f5f9;">
                        <th style="padding:10px; text-align:left; color:#0f172a">Course</th>
                        <th style="padding:10px; text-align:left; color:#0f172a">Assignment</th>
                        <th style="padding:10px; text-align:center; color:#0f172a">Score</th>
                        <th style="padding:10px; text-align:center; color:#0f172a">Max</th>
                        <th style="padding:10px; text-align:left; color:#0f172a">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($grades as $g): ?>
                        <tr style="border-bottom:1px solid #e6eef8;">
                            <td style="padding:8px; vertical-align: middle;"><?php echo htmlspecialchars($g['course_name']); ?></td>
                            <td style="padding:8px; vertical-align: middle;"><?php echo htmlspecialchars($g['assignment_name']); ?></td>
                            <td style="padding:8px; text-align:center; vertical-align: middle;"><?php echo htmlspecialchars($g['score']); ?></td>
                            <td style="padding:8px; text-align:center; vertical-align: middle;"><?php echo htmlspecialchars($g['max_score']); ?></td>
                            <td style="padding:8px; vertical-align: middle;"><?php echo htmlspecialchars($g['grade_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
