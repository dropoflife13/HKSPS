<?php
$teacherId = $_SESSION['user_id'] ?? 0;

$sql = "SELECT a.id, u.name AS student_name, jp.title AS job_title, a.status, a.applied_date
        FROM applications a
        JOIN users u ON a.student_id = u.id
        JOIN job_postings jp ON a.job_id = jp.id
        WHERE jp.posted_by_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $teacherId);
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="container mt-4">
    <h3>Applicants</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student</th>
                <th>Job Title</th>
                <th>Status</th>
                <th>Applied At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['student_name']) ?></td>
                <td><?= htmlspecialchars($row['job_title']) ?></td>
                <td><?= ucfirst($row['status']) ?></td>
                <td><?= $row['applied_date'] ?></td>
                <td>
                    <?php if($row['status'] === 'pending'): ?>
                        <a href="action.php?id=<?= $row['id'] ?>&action=approved" class="btn btn-success btn-sm">Accept</a>
                        <a href="action.php?id=<?= $row['id'] ?>&action=rejected" class="btn btn-danger btn-sm">Deny</a>
                    <?php else: ?>
                        <span class="text-muted">No actions</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
