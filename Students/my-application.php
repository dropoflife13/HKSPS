<?php
session_start();
include("../config/conn.php");

// Make sure student is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../Auth/login.php");
    exit();
}

$studentId = $_SESSION['user_id'];

// Fetch all applications of this student
$stmt = $conn->prepare("
    SELECT 
        a.id AS application_id,
        j.title AS job_title,
        d.name AS department_name,
        a.status,
        a.created_at
    FROM applications a
    JOIN job_postings j ON a.job_id = j.id
    JOIN departments d ON j.department_id = d.id
    WHERE a.student_id = ?
    ORDER BY a.created_at DESC
");
$stmt->bind_param("i", $studentId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Applications</title>
</head>
<body>
    <h1>My Applications</h1>

    <?php if ($result->num_rows > 0): ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <tr>
                <th>Job Title</th>
                <th>Department</th>
                <th>Status</th>
                <th>Date Applied</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['job_title']); ?></td>
                    <td><?php echo htmlspecialchars($row['department_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>You have not applied for any jobs yet.</p>
    <?php endif; ?>
</body>
</html>
