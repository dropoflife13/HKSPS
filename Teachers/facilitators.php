<?php
session_start();
include("../config/conn.php");

if (!isset($_SESSION['user_name']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../Auth/login.php");
    exit();
}

$teacherId = $_SESSION['user_id'];

// Fetch all accepted students for this teacher’s duties
$stmt = $conn->prepare("
    SELECT u.id, u.name AS student_name, j.title AS duty_title
    FROM applications a
    JOIN users u ON a.student_id = u.id
    JOIN job_postings j ON a.job_id = j.id
    WHERE a.status = 'accepted' AND j.posted_by_id = ?
");
$stmt->bind_param("i", $teacherId);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Facilitators</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Teacher Navbar -->
    <?php include '../includes/teachernav.php'; ?>

    <div class="container mt-4">
        <h1>My Facilitators</h1>

        <?php if ($result->num_rows > 0): ?>
            <ul class="list-group">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li class="list-group-item">
                        <strong><?php echo htmlspecialchars($row['student_name']); ?></strong> 
                        <br>
                        <small>Assigned to: <?php echo htmlspecialchars($row['duty_title']); ?></small>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <div class="alert alert-info mt-3">No facilitators yet.</div>
        <?php endif; ?>

        <a href="index.php" class="btn btn-secondary mt-3">⬅ Go Back</a>
    </div>

</body>
</html>
