<?php
session_start();
include '../config/conn.php'; // DB connection
include '../includes/studentnav.php'; // navbar

if (!isset($_SESSION['user_name']) || $_SESSION['role'] !== 'student') {
    header("Location: ../Auth/login.php");
    exit();
}

$studentId = $_SESSION['user_id'];
$department_id = $_GET['department_id'] ?? '';

// Fetch all departments
$dept_result = $conn->query("SELECT * FROM departments ORDER BY name ASC");

// Fetch duties for students, exclude full duties and already applied jobs
$query = "
    SELECT jp.*, u.name AS teacher_name,
           (SELECT COUNT(*) FROM applications a WHERE a.job_id = jp.id AND a.status = 'approved') AS accepted_applicants
    FROM job_postings jp
    JOIN users u ON u.id = jp.posted_by_id
    LEFT JOIN applications a_student ON a_student.job_id = jp.id AND a_student.student_id = ?
    WHERE jp.status = 'open' 
      AND a_student.id IS NULL
";

$params = [$studentId];
$types = "i";

if ($department_id) {
    $query .= " AND jp.department_id = ?";
    $params[] = $department_id;
    $types .= "i";
}

$query .= " AND (SELECT COUNT(*) FROM applications a WHERE a.job_id = jp.id AND a.status = 'approved') < jp.max_applicants";

$query .= " ORDER BY jp.posted_date DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$duties_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Browse Duties</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .urgent { border-left: 5px solid #dc3545; padding-left: 10px; }
</style>
</head>
<body>
<div class="container mt-4">
    <h2>Browse Duties</h2>

    <label for="department_id" class="form-label">Select Department:</label>
    <select name="department_id" id="department_id" class="form-select w-auto d-inline-block mb-4">
        <option value="">All Departments</option>
        <?php while ($dept = $dept_result->fetch_assoc()): ?>
            <option value="<?= htmlspecialchars($dept['id']) ?>" <?= ($department_id == $dept['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($dept['name']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <?php if ($duties_result->num_rows > 0): ?>
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php while ($job = $duties_result->fetch_assoc()): ?>
            <?php
                $accepted = (int)$job['accepted_applicants'];
                $remaining = (int)$job['max_applicants'] - $accepted;
                $urgent_class = ($remaining <= 1) ? 'urgent' : '';
            ?>
            <div class="col">
                <div class="card <?= $urgent_class ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($job['title']) ?></h5>
                        <p><strong>Teacher:</strong> <?= htmlspecialchars($job['teacher_name']) ?></p>
                        <p><strong>Schedule:</strong> <?= htmlspecialchars($job['schedule']) ?></p>
                        <p><strong>Location:</strong> <?= htmlspecialchars($job['location']) ?></p>
                        <p><strong>Status:</strong> <?= htmlspecialchars(ucfirst($job['status'])) ?></p>
                        <p><strong>Max Applicants:</strong> <?= (int)$job['max_applicants'] ?></p>
                        <p><strong>Accepted:</strong> <?= $accepted ?> / <?= (int)$job['max_applicants'] ?></p>
                        <p><strong>Description:</strong> <?= htmlspecialchars($job['description']) ?></p>
                        <p><strong>Requirements:</strong> <?= htmlspecialchars($job['requirements']) ?></p>

                        <?php if ($accepted < (int)$job['max_applicants']): ?>
                            <a href="apply.php?job_id=<?= (int)$job['id'] ?>" class="btn btn-primary btn-sm">Apply</a>
                        <?php else: ?>
                            <span class="text-muted">Full</span>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer text-muted">
                        Posted on: <?= date('M d, Y', strtotime($job['posted_date'])) ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <?php else: ?>
        <p>No duties available.</p>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('department_id').addEventListener('change', function() {
    const deptId = this.value;
    window.location.href = deptId ? `?department_id=${deptId}` : 'browse-duty.php';
});
</script>
</body>
</html>
