<?php
session_start();
include("../config/conn.php");

$teacherId = $_SESSION['user_id'] ?? 0;

// Fetch applicants for teacher's job postings
$sql = "SELECT a.id, u.name AS student_name, jp.title AS job_title, a.status, a.applied_date
        FROM applications a
        JOIN users u ON a.student_id = u.id
        JOIN job_postings jp ON a.job_id = jp.id
        WHERE jp.posted_by_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $teacherId);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Applicants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
     <?php include '../includes/teachernav.php'; ?>
<div class="container mt-4">
    <h3>Applicants</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student</th>
                <th>Job Title</th>
                <th>Status</th>
                <th>Applied At</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['student_name']) ?></td>
                <td><?= htmlspecialchars($row['job_title']) ?></td>
                <td><span class="badge bg-info"><?= ucfirst($row['status']) ?></span></td>
                <td><?= $row['applied_date'] ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
