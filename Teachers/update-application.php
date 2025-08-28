<?php
session_start();
include("../config/conn.php");

// Set JSON header
header('Content-Type: application/json');

$teacherId = $_SESSION['user_id'] ?? 0;
$appId = $_POST['application_id'] ?? 0;
$action = $_POST['action'] ?? '';

if (!$teacherId || !$appId || !in_array($action, ['approved','rejected'])) {
    echo json_encode(['status'=>'error','message'=>'Invalid input']);
    exit;
}

// Check application belongs to teacher
$stmtCheck = $conn->prepare("SELECT a.id FROM applications a
                             JOIN job_postings jp ON a.job_id = jp.id
                             WHERE a.id=? AND jp.posted_by_id=?");
$stmtCheck->bind_param("ii",$appId,$teacherId);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($resultCheck->num_rows === 0) {
    echo json_encode(['status'=>'error','message'=>'Unauthorized']);
    exit;
}

// Update status
$stmt = $conn->prepare("UPDATE applications SET status=? WHERE id=?");
$stmt->bind_param("si",$action,$appId);

if($stmt->execute()){
    echo json_encode(['status'=>'success','action'=>$action]);
} else {
    echo json_encode(['status'=>'error','message'=>$stmt->error]);
}

$stmtCheck->close();
$stmt->close();
$conn->close();


?>
