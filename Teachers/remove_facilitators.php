<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../config/conn.php';
 // Important!
// Check teacher session
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    echo json_encode(["success" => false, "error" => "Unauthorized"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $applicationId = intval($_POST['id']);
    $teacherId = $_SESSION['user_id'];

    // Verify teacher owns this application
    $stmt = $conn->prepare("
        SELECT job_id FROM applications a
        JOIN job_postings j ON a.job_id = j.id
        WHERE a.id = ? AND j.posted_by_id = ?
    ");
    $stmt->bind_param("ii", $applicationId, $teacherId);
    $stmt->execute();
    $res = $stmt->get_result();
    $app = $res->fetch_assoc();

    if (!$app) {
        echo json_encode(["success" => false, "error" => "Unauthorized or facilitator not found"]);
        exit;
    }

    $jobId = $app['job_id'];

    // Remove facilitator
    $del = $conn->prepare("DELETE FROM applications WHERE id = ?");
    $del->bind_param("i", $applicationId);

    if ($del->execute()) {
        $upd = $conn->prepare("UPDATE job_postings SET current_applicants = GREATEST(current_applicants - 1, 0) WHERE id = ?");
        $upd->bind_param("i", $jobId);
        $upd->execute();

        echo json_encode(["success" => true]);
        exit;
    } else {
        echo json_encode(["success" => false, "error" => "Failed to remove facilitator"]);
        exit;
    }
}

echo json_encode(["success" => false, "error" => "Invalid request"]);
exit;
