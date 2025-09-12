<?php
session_start();
include("../../config/conn.php");

// Only teachers allowed
if (!isset($_SESSION['user_name']) || $_SESSION['role'] !== 'teacher') {
    echo json_encode(["success" => false, "error" => "Unauthorized"]);
    exit();
}

$teacherId = $_SESSION['user_id'];
$id = $_POST['id'] ?? 0;

// Fetch duty
$stmt = $conn->prepare("SELECT * FROM job_postings WHERE id = ? AND posted_by_id = ?");
$stmt->bind_param("ii", $id, $teacherId);
$stmt->execute();
$result = $stmt->get_result();
$duty = $result->fetch_assoc();
$stmt->close();

if (!$duty) {
    echo json_encode(["success" => false, "error" => "Duty not found or access denied."]);
    exit();
}

// Handle update
$title          = $_POST['title'] ?? '';
$description    = $_POST['description'] ?? '';
$schedule       = $_POST['schedule'] ?? '';
$status         = $_POST['status'] ?? '';
$department_id  = (int)($_POST['department_id'] ?? 0);
$requirements   = $_POST['requirements'] ?? '';
$location       = $_POST['location'] ?? '';
$max_applicants = (int)($_POST['max_applicants'] ?? 0);
$deadline       = $_POST['deadline'] ?? null;

// Validate max applicants
if ($max_applicants < $duty['current_applicants']) {
    echo json_encode([
        "success" => false,
        "error" => "Max applicants cannot be less than current applicants ({$duty['current_applicants']})."
    ]);
    exit();
}

// Update DB
$stmt = $conn->prepare("
    UPDATE job_postings
    SET title=?, description=?, schedule=?, status=?, department_id=?, requirements=?, location=?, max_applicants=?, deadline=?
    WHERE id=? AND posted_by_id=?
");

$stmt->bind_param(
    "ssssisissii", 
    $title,
    $description,
    $schedule,
    $status,
    $department_id,
    $requirements,
    $location,
    $max_applicants,
    $deadline,
    $id,
    $teacherId
);

$success = $stmt->execute();
$stmt->close();

if ($success) {
    // Log update activity
    $activity = $conn->prepare("
        INSERT INTO activities (user_id, action_type, description, job_id)
        VALUES (?, 'Job Updated', ?, ?)
    ");
    $desc = "Updated duty: " . $title;
    $activity->bind_param("isi", $teacherId, $desc, $id);
    $activity->execute();
    $activity->close();

    // Fetch department CODE
    $deptCode = '';
    if ($department_id > 0) {
        $deptStmt = $conn->prepare("SELECT code FROM departments WHERE id = ?");
        $deptStmt->bind_param("i", $department_id);
        $deptStmt->execute();
        $deptStmt->bind_result($deptCode);
        $deptStmt->fetch();
        $deptStmt->close();
    }

    echo json_encode([
        "success" => true,
        "duty" => [
            "id"                => $id,
            "title"             => $title,
            "description"       => $description,
            "schedule"          => $schedule,
            "status"            => $status,
            "department_id"     => $department_id,
            "department_code"   => $deptCode,
            "requirements"      => $requirements,
            "location"          => $location,
            "max_applicants"    => $max_applicants,
            "deadline"          => $deadline,
            "current_applicants"=> $duty['current_applicants']
        ]
    ]);
} else {
    echo json_encode(["success" => false, "error" => "Database update failed."]);
}
?>
