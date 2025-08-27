<?php
$studentName = $_SESSION['user_name'] ?? 'Student';
?>

<!-- Student Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Student Panel</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#studentNav" aria-controls="studentNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="studentNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="apply.php">Apply</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="browse-duty.php">Browse</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="my-application.php">Applications</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="submit-report.php">Report</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="profile.php">Profile</a>
        </li>

      </ul>

      <span class="navbar-text me-3">
        Welcome, <?= htmlspecialchars($studentName) ?>
      </span>
      <a href="../Auth/logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
  </div>
</nav>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
