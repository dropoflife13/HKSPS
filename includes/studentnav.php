<?php
$studentName = $_SESSION['user_name'] ?? 'Student';
?>

<!-- Student Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold fs-4" href="index.php">Student Panel</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#studentNav" aria-controls="studentNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="studentNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>

           <li class="nav-item">
          <a class="nav-link" href="browse-duty.php">Browse</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="apply.php">Apply</a>
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

      <div class="d-flex align-items-center">
        <span class="navbar-text me-3 fw-semibold text-light">
          Welcome, <?= htmlspecialchars($studentName) ?>
        </span>
        <a href="../Auth/logout.php" class="btn btn-outline-light btn-sm fw-bold">Logout</a>
      </div>
    </div>
  </div>
</nav>

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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
