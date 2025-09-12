<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../config/conn.php';

$response = ["success" => false, "error" => "Unknown error"];

if (isset($_POST['update_status'])) {
    $report_id = intval($_POST['report_id']);
    $status = $_POST['status'];
    $resolved_by = $_SESSION['user_id'] ?? null;

    if ($report_id && in_array($status, ['pending', 'reviewed', 'resolved'])) {
        $stmt = $conn->prepare("UPDATE reports SET status = ?, resolved_by = ? WHERE id = ?");
        $stmt->bind_param("sii", $status, $resolved_by, $report_id);

        if ($stmt->execute()) {
            // Fetch resolver name if resolved
            $resolved_name = null;
            if ($status === 'resolved' && $resolved_by) {
                $u = $conn->query("SELECT name FROM users WHERE id = $resolved_by");
                if ($u && $row = $u->fetch_assoc()) {
                    $resolved_name = $row['name'];
                }
            }

            $response = [
                "success" => true,
                "resolved_name" => $resolved_name
            ];
        } else {
            $response["error"] = "Database update failed: " . $stmt->error;
        }
    } else {
        $response["error"] = "Invalid input.";
    }
}

echo json_encode($response);
exit;
