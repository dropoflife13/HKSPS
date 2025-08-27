<?php
$teacherName = $_SESSION['user_name'] ?? 'Teacher';
?>

<?php
$teacherName = $_SESSION['user_name'] ?? 'Teacher';
?>

<!-- Teacher Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Teacher Panel</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#teacherNav" aria-controls="teacherNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="teacherNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <li class="nav-item">
          <a class="nav-link" href="index.php">Dashboard</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="my-post.php">My Post</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="submit-report.php">Submit Report</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="profile.php">Profile</a>
        </li>

        <!-- Duties Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dutiesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Duties
          </a>
          <ul class="dropdown-menu" aria-labelledby="dutiesDropdown">
            <li><a class="dropdown-item" href="../Teachers/duties.php">Ongoing Duties</a></li>
            <li><a class="dropdown-item" href="../Teachers/applicants.php">Applicants</a></li>
            <li><a class="dropdown-item" href="../Teachers/facilitators.php">Facilitators</a></li>
          </ul>
        </li>

      </ul>

      <span class="navbar-text me-3">
        Welcome, <?= htmlspecialchars($teacherName) ?>
      </span>
      <a href="../Auth/logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
  </div>
</nav>
    

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
