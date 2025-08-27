<?php
session_start();
include("../../config/conn.php");

// Ensure teacher is logged in
if (!isset($_SESSION['user_name']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../Auth/login.php");
    exit();
}

$teacherId = $_SESSION['user_id'];
$successMsg = '';
$errorMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $department_id = $_POST['department_id'];
    $description = $_POST['description'];
    $requirements = $_POST['requirements'] ?? '';
    $schedule = $_POST['schedule'];
    $location = $_POST['location'] ?? '';
    $status = $_POST['status'] ?? 'open';
    $max_applicants = $_POST['max_applicants'] ?? 1;

    $deptResult = $conn->query("SELECT code FROM departments WHERE id = $department_id LIMIT 1");
    $deptRow = $deptResult->fetch_assoc();
    $department_code = $deptRow['code'] ?? '';

    $stmt = $conn->prepare("
        INSERT INTO job_postings 
        (title, department_id, department, description, requirements, schedule, location, posted_by_id, posted_date, deadline, status, max_applicants)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, CURDATE(), CURDATE() + INTERVAL 7 DAY, ?, ?)
    ");
    $stmt->bind_param(
        "sisssssisi",
        $title,
        $department_id,
        $department_code,
        $description,
        $requirements,
        $schedule,
        $location,
        $teacherId,
        $status,
        $max_applicants
    );

    if ($stmt->execute()) {
        $successMsg = "Duty created successfully!";
    } else {
        $errorMsg = "Error creating duty: " . $stmt->error;
    }
}

// Fetch departments for dropdown
$departments = $conn->query("SELECT id, name FROM departments ORDER BY name");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Create Duty</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    main {
        margin-left: 250px;
        padding: 20px;
        max-width: 800px;
    }
    form .row > div {
        margin-bottom: 10px;
    }
    .card-form {
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
</style>
</head>
<body>


<main>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Create Duty</h1>
        <a href="../../Teachers/index.php" class="btn btn-secondary">Go Back</a>
    </div>

    <?php if ($successMsg): ?>
        <div class="alert alert-success"><?= $successMsg ?></div>
    <?php endif; ?>
    <?php if ($errorMsg): ?>
        <div class="alert alert-danger"><?= $errorMsg ?></div>
    <?php endif; ?>

    <div class="card card-form">
        <form method="POST">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Department</label>
                    <select name="department_id" class="form-select" required>
                        <?php while($dept = $departments->fetch_assoc()): ?>
                            <option value="<?= $dept['id'] ?>"><?= htmlspecialchars($dept['name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-6">
                    <label class="form-label">Schedule</label>
                    <input type="text" name="schedule" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control">
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="open">Open</option>
                        <option value="closed">Closed</option>
                        <option value="filled">Filled</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Max Applicants</label>
                    <input type="number" name="max_applicants" class="form-control" value="1" min="1">
                </div>
            </div>

            <div class="mt-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mt-2">
                <label class="form-label">Requirements</label>
                <textarea name="requirements" class="form-control" rows="2"></textarea>
            </div>

            <button type="submit" class="btn btn-success mt-3">Create Duty</button>
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
