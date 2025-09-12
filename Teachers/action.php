<?php
session_start();

require_once __DIR__ . '/../config/conn.php';
header('Content-Type: application/json');

// Only teachers allowed
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    echo json_encode(["success" => false, "error" => "Unauthorized"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $action = $_POST['action'] ?? '';

    if (!$id || !in_array($action, ['approved','rejected'])) {
        echo json_encode(["success" => false, "error" => "Invalid request"]);
        exit;
    }

    // Get job_id first (so we can safely update job_postings later)
    $jobQuery = $conn->prepare("SELECT job_id, status FROM applications WHERE id = ?");
    $jobQuery->bind_param("i", $id);
    $jobQuery->execute();
    $result = $jobQuery->get_result();
    $application = $result->fetch_assoc();

    if (!$application) {
        echo json_encode(["success" => false, "error" => "Application not found"]);
        exit;
    }

    $jobId = $application['job_id'];
    $oldStatus = $application['status'];

    // Update application status
    $stmt = $conn->prepare("UPDATE applications SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $action, $id);

    if ($stmt->execute()) {
        // ✅ Adjust applicant count safely
        if ($oldStatus !== 'approved' && $action === 'approved') {
            // approving → increment
            $update = $conn->prepare("UPDATE job_postings SET current_applicants = current_applicants + 1 WHERE id = ?");
            $update->bind_param("i", $jobId);
            $update->execute();
        } elseif ($oldStatus === 'approved' && $action === 'rejected') {
            // rejecting a previously approved → decrement
            $update = $conn->prepare("UPDATE job_postings SET current_applicants = GREATEST(current_applicants - 1, 0) WHERE id = ?");
            $update->bind_param("i", $jobId);
            $update->execute();
        }

        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Database error"]);
    }
    exit;
}

echo json_encode(["success" => false, "error" => "Invalid method"]);
