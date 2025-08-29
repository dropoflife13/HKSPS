<?php
$teacherId = $_SESSION['user_id'];

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
