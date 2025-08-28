<?php
session_start();
include '../config/conn.php';
include '../includes/studentnav.php'; // Navbar

// Only students allowed
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../Auth/login.php");
    exit();
}

$studentId = $_SESSION['user_id'];
$successMsg = '';
$errorMsg = '';

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $department_id = $_POST['department_id'] ?? null;
    $student_id_code = $_POST['student_id_code'] ?? '';

    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, department_id=?, student_id=? WHERE id=?");
    $stmt->bind_param("ssisi", $name, $email, $department_id, $student_id_code, $studentId);

    if ($stmt->execute()) {
        $successMsg = "Profile updated successfully!";
    } else {
        $errorMsg = "Failed to update profile: " . $stmt->error;
    }
}

// Fetch student info
$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $studentId);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

// Fetch departments
$departments = $conn->query("SELECT id, name FROM departments ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>My Profile</h2>

    <?php if ($successMsg): ?>
        <div class="alert alert-success"><?= $successMsg ?></div>
    <?php endif; ?>
    <?php if ($errorMsg): ?>
        <div class="alert alert-danger"><?= $errorMsg ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($student['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($student['email']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Student ID</label>
            <input type="text" name="student_id_code" class="form-control" value="<?= htmlspecialchars($student['student_id']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Department</label>
            <select name="department_id" class="form-select">
                <option value="">Select Department</option>
                <?php while ($dept = $departments->fetch_assoc()): ?>
                    <option value="<?= $dept['id'] ?>" <?= ($student['department_id'] == $dept['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($dept['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>
</body>
</html>
