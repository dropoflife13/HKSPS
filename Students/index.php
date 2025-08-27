<?php
include("../Auth/middleware.php");  // include middleware
requireRole("student"); // only students allowed
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  <?php include '../includes/studentnav.php'; ?> <!-- sidebar -->

<h1>Welcome Student</h1>
<p>Hello, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>

</body>
</html>
