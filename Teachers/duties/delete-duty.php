<?php
session_start();
include("../../config/conn.php"); // Adjust the path if needed

// Ensure teacher is logged in
if (!isset($_SESSION['user_name']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../../Auth/login.php");
    exit();
}

$teacherId = $_SESSION['user_id'];
$id = $_GET['id'] ?? 0;

if ($id) {
    // Delete the duty only if it belongs to this teacher
    $stmt = $conn->prepare("DELETE FROM job_postings WHERE id = ? AND posted_by_id = ?");
    $stmt->bind_param("ii", $id, $teacherId);

    if ($stmt->execute()) {
        $stmt->close();
        // Redirect to my-post.php after deletion
        header("Location: ../my-post.php?msg=deleted");
        exit();
    } else {
        echo "Error deleting duty: " . $stmt->error;
    }
} else {
    header("Location: ../my-post.php");
    exit();
}
