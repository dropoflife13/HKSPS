<?php
session_start();
include '../config/conn.php'; // database connection
  

if (!isset($_SESSION['user_name']) || $_SESSION['role'] !== 'student') {
    header("Location: ../Auth/login.php");
    exit();
}

$student_id = $_SESSION['user_id'];

$job_id = $_GET['job_id'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM job_postings WHERE id = ?");
$stmt->bind_param("i", $job_id);
$stmt->execute();
$job_result = $stmt->get_result();
$job = $job_result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cover_letter = $_POST['cover_letter'] ?? '';

    // Check if the student already applied for THIS job
    $check = $conn->prepare("SELECT id FROM applications WHERE student_id = ? AND job_id = ?");
    $check->bind_param("ii", $student_id, $job_id);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        echo "<p>Already submitted your application for this job!</p>";
    } else {
        $insert = $conn->prepare("INSERT INTO applications (job_id, student_id, applied_date, cover_letter) VALUES (?, ?, CURDATE(), ?)");
        $insert->bind_param("iis", $job_id, $student_id, $cover_letter);

        if ($insert->execute()) {
            echo "<p>Application submitted successfully!</p>";
        } else {
            echo "<p>Failed to submit application.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apply for Duty</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional Custom CSS -->
    <style>
        .navbar-nav .nav-link {
            font-weight: 500;
            margin-right: 10px;
            transition: background-color 0.3s, color 0.3s;
        }

        .navbar-nav .nav-link:hover {
            background-color: rgba(255,255,255,0.2);
            border-radius: 5px;
            color: #fff;
        }

        .navbar-brand {
            letter-spacing: 1px;
        }

        .navbar-text {
            font-size: 0.95rem;
        }
    </style>
</head>
<body>
    <?php include '../includes/studentnav.php'; ?> <!-- sidebar -->

    <div class="container mt-4">
        <h1>Apply for Duty: <?php echo htmlspecialchars($job['title'] ?? 'Job Not Found'); ?></h1>

        <?php if ($job): ?>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($job['description']); ?></p>
            <p><strong>Schedule:</strong> <?php echo htmlspecialchars($job['schedule']); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>

            <form method="POST">
                <label for="cover_letter">Cover Letter (optional):</label><br>
                <textarea name="cover_letter" id="cover_letter" rows="5" class="form-control mb-3"></textarea>

                <button type="submit" class="btn btn-success">Submit Application</button>
            </form>
        <?php else: ?>
            <p>Job not found.</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS (bundle includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
