<?php
session_start();
include("../../config/conn.php");

// Only teachers allowed
if (!isset($_SESSION['user_name']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../Auth/login.php");
    exit();
}

$teacherId = $_SESSION['user_id'];
$id = $_GET['id'] ?? 0;

// Fetch duty
$stmt = $conn->prepare("SELECT * FROM job_postings WHERE id = ? AND posted_by_id = ?");
$stmt->bind_param("ii", $id, $teacherId);
$stmt->execute();
$result = $stmt->get_result();
$duty = $result->fetch_assoc();

if (!$duty) die("Duty not found or access denied.");

// Handle update
$errorMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $schedule = $_POST['schedule'];
    $status = $_POST['status'];
    $department_id = $_POST['department_id'];
    $requirements = $_POST['requirements'];
    $location = $_POST['location'];
    $max_applicants = (int)$_POST['max_applicants'];

    // Validate max applicants
    if ($max_applicants < $duty['current_applicants']) {
        $errorMsg = "Max applicants cannot be less than current applicants ({$duty['current_applicants']}).";
    } else {
        $stmt = $conn->prepare("
            UPDATE job_postings
            SET title=?, description=?, schedule=?, status=?, department_id=?, requirements=?, location=?, max_applicants=?
            WHERE id=? AND posted_by_id=?
        ");
        $stmt->bind_param("ssssisiiii", $title, $description, $schedule, $status, $department_id, $requirements, $location, $max_applicants, $id, $teacherId);
        $stmt->execute();

        header("Location: ../post-duty.php");
        exit();
    }
}

// Fetch departments
$departments = $conn->query("SELECT id, name FROM departments ORDER BY name");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Update Duty</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<main style="margin-left:250px; padding:20px; max-width:800px;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4">Update Duty</h1>
        <a href="../post-duty.php" class="btn btn-secondary btn-sm">Go Back</a>
    </div>

    <?php if ($errorMsg): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errorMsg) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="row g-2 mb-3">
            <div class="col-md-6">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control form-control-sm" value="<?= htmlspecialchars($duty['title']) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Department</label>
                <select name="department_id" class="form-select form-select-sm" required>
                    <?php while($dept = $departments->fetch_assoc()): ?>
                        <option value="<?= $dept['id'] ?>" <?= $dept['id']==$duty['department_id']?'selected':'' ?>>
                            <?= htmlspecialchars($dept['name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>

        <div class="row g-2 mb-3">
            <div class="col-md-6">
                <label class="form-label">Schedule</label>
                <input type="text" name="schedule" class="form-control form-control-sm" value="<?= htmlspecialchars($duty['schedule']) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Location</label>
                <input type="text" name="location" class="form-control form-control-sm" value="<?= htmlspecialchars($duty['location']) ?>">
            </div>
        </div>

        <div class="row g-2 mb-3">
            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="open" <?= $duty['status']=='open'?'selected':'' ?>>Open</option>
                    <option value="closed" <?= $duty['status']=='closed'?'selected':'' ?>>Closed</option>
                    <option value="filled" <?= $duty['status']=='filled'?'selected':'' ?>>Filled</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Max Applicants</label>
                <input type="number" name="max_applicants" class="form-control form-control-sm" value="<?= $duty['max_applicants'] ?>" min="<?= $duty['current_applicants'] ?>">
                <small class="text-muted">Current applicants: <?= $duty['current_applicants'] ?></small>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control form-control-sm" rows="2" required><?= htmlspecialchars($duty['description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Requirements</label>
            <textarea name="requirements" class="form-control form-control-sm" rows="2"><?= htmlspecialchars($duty['requirements']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary btn-sm">Update Duty</button>
    </form>
</main>

</body>
</html>
