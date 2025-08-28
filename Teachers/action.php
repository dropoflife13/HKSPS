<?php
session_start();
include("../config/conn.php");

$teacherId = $_SESSION['user_id'] ?? 0;
$appId = $_GET['id'] ?? 0;
$action = $_GET['action'] ?? '';

if (!$appId || !in_array($action, ['approved','rejected'])) {
    die('Invalid request');
}

// Ensure the application belongs to this teacher
$stmt = $conn->prepare("
    SELECT a.id 
    FROM applications a
    JOIN job_postings jp ON a.job_id = jp.id
    WHERE a.id = ? AND jp.posted_by_id = ?
");
$stmt->bind_param("ii", $appId, $teacherId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Unauthorized');
}

// Update status
$update = $conn->prepare("UPDATE applications SET status = ? WHERE id = ?");
$update->bind_param("si", $action, $appId);
$update->execute();

// Redirect back to applicants page
header("Location: applicants.php");
exit;
?>
