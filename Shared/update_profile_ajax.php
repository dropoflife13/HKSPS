<?php
session_start();
header('Content-Type: application/json');
include '../config/init.php'; // Adjust path if needed

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    echo json_encode(['success' => false, 'error' => 'You must be logged in.']);
    exit;
}

$userId = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Collect POST data safely
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$department_id = isset($_POST['department_id']) && $_POST['department_id'] !== '' ? intval($_POST['department_id']) : null;
$year_level = $role === 'student' ? trim($_POST['year_level'] ?? '') : null;
$office_location = $role === 'teacher' ? trim($_POST['office_location'] ?? '') : null;

// Basic validation
if ($name === '' || $email === '') {
    echo json_encode(['success' => false, 'error' => 'Name and email are required.']);
    exit;
}

// Validate department exists if not null
if ($department_id !== null) {
    $stmtDept = $conn->prepare("SELECT id FROM departments WHERE id=?");
    $stmtDept->bind_param("i", $department_id);
    $stmtDept->execute();
    $resultDept = $stmtDept->get_result();
    if ($resultDept->num_rows === 0) {
        echo json_encode(['success' => false, 'error' => 'Selected department is invalid.']);
        exit;
    }
}

// Perform the update
$stmt = $conn->prepare("UPDATE users SET name=?, email=?, department_id=?, year_level=?, office_location=? WHERE id=?");
$stmt->bind_param("ssissi", $name, $email, $department_id, $year_level, $office_location, $userId);

if ($stmt->execute()) {
    // Return updated profile data
    $profile = [
        'name' => htmlspecialchars($name),
        'email' => htmlspecialchars($email),
        'role' => $role
    ];
    echo json_encode(['success' => true, 'profile' => $profile]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to update profile.']);
}
?>
