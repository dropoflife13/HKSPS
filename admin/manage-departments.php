<?php
session_start();
include("../config/conn.php"); // DB connection
$_SESSION['user_name'] = $_SESSION['user_name'] ?? 'Admin';

// Handle form submission for creating a new department
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['code'], $_POST['name'])) {
    $code = strtoupper(trim($_POST['code']));
    $name = trim($_POST['name']);
    $description = trim($_POST['description'] ?? '');

    if ($code && $name) {
        $stmt = $conn->prepare("INSERT INTO departments (code, name, description) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $code, $name, $description);
        if ($stmt->execute()) {
            header("Location: manage-departments.php");
            exit();
        } else {
            $msg = "❌ Error: " . $conn->error;
        }
    } else {
        $msg = "❌ Code and Name are required.";
    }
}

// Handle deletion via GET
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $conn->query("DELETE FROM departments WHERE id=$delete_id");
    header("Location: manage-departments.php");
    exit();
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
<div class="container-fluid">
    <div class="row">
        <?php include '../includes/sidebar.php'; ?>

        <main class="col-md-10 ms-sm-auto px-md-4 mt-3">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">Manage Departments</h1>
            </div>

            <!-- Display message -->
            <?php if (!empty($msg)) : ?>
                <div class="alert alert-danger"><?= $msg ?></div>
            <?php endif; ?>

            <!-- Button to trigger modal -->
            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createDeptModal">
                + Add Department
            </button>

            <!-- Departments Table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($dept = $departments->fetch_assoc()): ?>
                        <tr>
                            <td><?= $dept['id'] ?></td>
                            <td><?= htmlspecialchars($dept['code']) ?></td>
                            <td><?= htmlspecialchars($dept['name']) ?></td>
                            <td><?= htmlspecialchars($dept['description']) ?></td>
                            <td>
                                <a href="update-department.php?id=<?= $dept['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="manage-departments.php?delete_id=<?= $dept['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </main>
    </div>
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
              <div class="mb-3">
                  <label for="description" class="form-label">Description</label>
                  <textarea class="form-control" id="description" name="description" placeholder="Optional description"></textarea>
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
