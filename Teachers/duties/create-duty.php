<?php
session_start();
include("../../config/conn.php");

header('Content-Type: application/json');

// Only teachers allowed
if (!isset($_SESSION['user_name']) || $_SESSION['role'] !== 'teacher') {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$teacherId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $department_id = (int)($_POST['department_id'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $requirements = trim($_POST['requirements'] ?? '');
    $schedule = trim($_POST['schedule'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $status = $_POST['status'] ?? 'open';
    $max_applicants = (int)($_POST['max_applicants'] ?? 1);
    $deadline = $_POST['deadline'] ?? date('Y-m-d', strtotime('+7 days'));

    // Validate required fields
    if (empty($title) || empty($department_id) || empty($description) || empty($schedule)) {
        echo json_encode(['success' => false, 'error' => 'All required fields must be filled']);
        exit;
    }

    $stmt = $conn->prepare("
        INSERT INTO job_postings 
        (title, department_id, description, requirements, schedule, location, posted_by_id, posted_date, deadline, status, max_applicants, current_applicants)
        VALUES (?, ?, ?, ?, ?, ?, ?, CURDATE(), ?, ?, ?, 0)
    ");

    if (!$stmt) {
        echo json_encode(['success' => false, 'error' => $conn->error]);
        exit;
    }

    $stmt->bind_param(
        "sissssissi", // 10 placeholders → 10 values
        $title,            
        $department_id,    
        $description,      
        $requirements,     
        $schedule,         
        $location,         
        $teacherId,        
        $deadline,         
        $status,           
        $max_applicants    
    );

    if ($stmt->execute()) {
        $lastId = $conn->insert_id;

        // Fetch duty details to return
        $duty = $conn->query("
            SELECT jp.*, d.code AS department_code, d.name AS department_name 
            FROM job_postings jp 
            LEFT JOIN departments d ON jp.department_id = d.id 
            WHERE jp.id = $lastId
        ")->fetch_assoc();

        // Log activity
        $activity = $conn->prepare("
            INSERT INTO activities (user_id, action_type, description, job_id)
            VALUES (?, 'Job Posted', 'Posted a new duty', ?)
        ");
        $activity->bind_param("ii", $teacherId, $lastId);
        $activity->execute();
        $activity->close();

        echo json_encode(['success' => true, 'duty' => $duty]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    exit();
}

echo json_encode(['success' => false, 'error' => 'Invalid request']);
exit;
?>
