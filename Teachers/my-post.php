<?php
session_start();
include("../config/conn.php");

if (!isset($_SESSION['user_name']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../Auth/login.php");
    exit();
}

$teacherId = $_SESSION['user_id'];

// Fetch teacher's duties
$stmt = $conn->prepare("
    SELECT jp.*, d.name AS department_name,
           (SELECT COUNT(*) FROM applications a WHERE a.job_id = jp.id AND a.status = 'approved') AS accepted_applicants
    FROM job_postings jp
    LEFT JOIN departments d ON jp.department_id = d.id
    WHERE jp.posted_by_id = ?
    ORDER BY jp.posted_date DESC
");
$stmt->bind_param("i", $teacherId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Duties</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include '../includes/teachernav.php'; ?>

<main style="margin-left:250px; padding:20px;">
    <div class="d-flex justify-content-between mb-3">
        <h1>My Duties</h1>
        <a href="./duties/create-duty.php" class="btn btn-success">+ Create Duty</a>
    </div>

    <?php if ($result->num_rows === 0): ?>
        <div class="alert alert-info">No duties posted yet.</div>
    <?php else: ?>
        <?php while($duty = $result->fetch_assoc()): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5><?= htmlspecialchars($duty['title']) ?> <small>(<?= htmlspecialchars($duty['department_name']) ?>)</small></h5>
                    <p><?= htmlspecialchars($duty['description']) ?></p>
                    <p><strong>Schedule:</strong> <?= htmlspecialchars($duty['schedule']) ?></p>
                    <p><strong>Status:</strong> <?= htmlspecialchars($duty['status']) ?></p>
                    <p><strong>Max Applicants:</strong> <?= $duty['max_applicants'] ?></p>
                    <p><strong>Accepted Applicants:</strong> <?= $duty['accepted_applicants'] ?></p>
                    <div class="d-flex gap-2">
                        <a href="duties/update-duty.php?id=<?= $duty['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                        <a href="duties/delete-duty.php?id=<?= $duty['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?> 
</main>
</body>
</html>
