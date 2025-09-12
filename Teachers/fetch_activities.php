<?php

require_once 'chart.php'; // Contains $conn

// Ensure teacher is logged in
if (!isset($_SESSION['user_name']) || $_SESSION['role'] !== 'teacher') {
    return [];
}

$teacherId = $_SESSION['user_id'];

// Fetch latest 50 student applications for this teacher's job postings
$sql = "
    SELECT a.id, a.action_type, u.name AS student_name, jp.title AS job_title, a.created_at
    FROM activities a
    JOIN users u ON a.user_id = u.id
    JOIN job_postings jp ON a.job_id = jp.id
    WHERE a.action_type = 'application_submitted'
      AND u.role = 'student'
      AND jp.posted_by_id = ?
    ORDER BY a.created_at DESC
    LIMIT 50
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $teacherId);
$stmt->execute();
$result = $stmt->get_result();

$recentActivities = [];
while ($row = $result->fetch_assoc()) {
    $recentActivities[] = [
        'action_type' => $row['action_type'],
        'description' => $row['student_name'] . " applied for '" . $row['job_title'] . "'",
        'created_at'  => $row['created_at']
    ];
}

$stmt->close();
