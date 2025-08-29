<?php
$teacherId = $_SESSION['user_id'] ?? 0;

// Fetch filled (ongoing) duties posted by this teacher
$sql = "SELECT jp.id, jp.title, jp.description, jp.status, jp.posted_date, jp.deadline
        FROM job_postings jp
        WHERE jp.posted_by_id = ? AND jp.status = 'filled'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $teacherId);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mt-4">
    <h3>Ongoing Duties (Already Filled)</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Posted Date</th>
                <th>Deadline</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                
                <td><?= $row['posted_date'] ?></td>
                <td><?= $row['deadline'] ?></td>
                <td><span class="badge bg-secondary"><?= ucfirst($row['status']) ?></span></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>