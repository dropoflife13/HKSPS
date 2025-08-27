<?php
session_start();
include("../config/conn.php");

// Ensure the user is logged in and is a teacher
if (!isset($_SESSION['user_name']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../Auth/login.php");
    exit();
}
$teacherName = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include '../includes/teachernav.php'; ?> <!-- sidebar -->

        <main class="col-md-10 ms-sm-auto px-md-4">
            <div class="pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Welcome, Prof. <?= htmlspecialchars($teacherName); ?>!</h1>
            </div>
            <p>Use the sidebar to navigate through your teacher dashboard.</p>

            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Quick Actions</h5>
                    <ul>
                        <li><a href="duties.php">View Duties</a></li>
                        <li><a href="create-duty.php">Create Duty</a></li>
                        <li><a href="my-post.php">My Job Postings</a></li>
                        <li><a href="submit-report.php">Submit Report</a></li>
                    </ul>
                </div>
            </div>
        </main>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
...
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
