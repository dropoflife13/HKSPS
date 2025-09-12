<?php
session_start();
include("../../config/conn.php");

// Only teachers allowed
if (!isset($_SESSION['user_name']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../../Auth/login.php");
    exit();
}

$teacherId = $_SESSION['user_id'];
$id = $_GET['id'] ?? 0;

if ($id) {
    // Fetch duty before deletion to log activity
    $stmt = $conn->prepare("SELECT title FROM job_postings WHERE id = ? AND posted_by_id = ?");
    $stmt->bind_param("ii", $id, $teacherId);
    $stmt->execute();
    $result = $stmt->get_result();
    $duty = $result->fetch_assoc();
    $stmt->close();

    if ($duty) {
        // Delete the duty
        $stmt = $conn->prepare("DELETE FROM job_postings WHERE id = ? AND posted_by_id = ?");
        $stmt->bind_param("ii", $id, $teacherId);

        if ($stmt->execute()) {
            // Log deletion activity
            $activity = $conn->prepare("
                INSERT INTO activities (user_id, action_type, description, job_id)
                VALUES (?, 'Job deleted', ?, ?)
            ");
            $desc = "Deleted duty: " . $duty['title'];
            $activity->bind_param("isi", $teacherId, $desc, $id);
            $activity->execute();
            $activity->close();

            $stmt->close();
            header("Location: ../my-post.php?msg=deleted");
            exit();
        } else {
            echo "Error deleting duty: " . $stmt->error;
        }
    } else {
        header("Location: ../my-post.php?msg=notfound");
        exit();
    }
} else {
    header("Location: ../my-post.php");
    exit();
}
?>
