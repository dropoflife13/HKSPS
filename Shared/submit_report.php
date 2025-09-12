<?php
session_start();
include '../config/conn.php'; // adjust path

$msg = "";

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    echo json_encode(['status' => 'error', 'message' => 'You must be logged in.']);
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
$allowed_roles = ['student', 'teacher'];

if (!in_array($role, $allowed_roles)) {
    echo json_encode(['status' => 'error', 'message' => 'Your role cannot submit reports.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    if (!empty($title) && !empty($description)) {
        $stmt = $conn->prepare("INSERT INTO reports (submitted_by, role, title, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $role, $title, $description);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Report submitted successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Something went wrong.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Title and description are required.']);
    }
}
?>
