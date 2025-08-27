<?php
session_start();
include("../../config/con.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['code'], $_POST['name'])) {
    $code = strtoupper(trim($_POST['code']));
    $name = trim($_POST['name']);

    if ($code && $name) {
        $stmt = $conn->prepare("INSERT INTO departments (code, name) VALUES (?, ?)");
        $stmt->bind_param("ss", $code, $name);

        if ($stmt->execute()) {
            $msg = "✅ Department created successfully.";
        } else {
            $msg = "❌ Error: " . $conn->error;
        }
    } else {
        $msg = "❌ Both code and name are required.";
    }
}

// Fetch all departments
$departments = $conn->query("SELECT * FROM departments ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Departments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">

    <h2>Manage Departments</h2>

    <!-- Button to trigger modal -->
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createDeptModal">
        + Add Department
    </button>

    <!-- Display message -->
    <?php if (!empty($msg)) : ?>
        <div class="alert alert-info"><?= $msg ?></div>
    <?php endif; ?>

    <!-- Departments Table -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($dept = $departments->fetch_assoc()): ?>
                <tr>
                    <td><?= $dept['id'] ?></td>
                    <td><?= htmlspecialchars($dept['code']) ?></td>
                    <td><?= htmlspecialchars($dept['name']) ?></td>
                    <td>
                        <a href="update-department.php?id=<?= $dept['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="delete-department.php?id=<?= $dept['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="createDeptModal" tabindex="-1" aria-labelledby="createDeptModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
          <div class="modal-header">
              <h5 class="modal-title" id="createDeptModalLabel">Create Department</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div class="mb-3">
                  <label for="code" class="form-label">Department Code</label>
                  <input type="text" class="form-control" id="code" name="code" placeholder="e.g., CITE" required>
              </div>
              <div class="mb-3">
                  <label for="name" class="form-label">Department Name</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Full Department Name" required>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-success">Create Department</button>
          </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
