<?php
session_start();
$_SESSION['user_name'] = $_SESSION['user_name'] ?? 'Admin';
require '../config/conn.php'; // Database connection

// Handle update form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'], $_POST['name'], $_POST['email'], $_POST['department_id'])) {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $department_id = $_POST['department_id'];

    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, department_id=? WHERE id=? AND role='teacher'");
    $stmt->bind_param("ssii", $name, $email, $department_id, $id);

    if ($stmt->execute()) {
        $msg = "✅ Teacher updated successfully.";
    } else {
        $msg = "❌ Error: " . $conn->error;
    }
}

// Fetch teachers from database
$teachersQuery = "SELECT id, name, email, teacher_id, department_id, created_at FROM users WHERE role='teacher'";
$teachersResult = $conn->query($teachersQuery);

// Fetch departments for dropdown
$departmentsQuery = "SELECT id, name, code FROM departments ORDER BY name ASC";
$departmentsResult = $conn->query($departmentsQuery);
$departments = [];
while ($row = $departmentsResult->fetch_assoc()) {
    $departments[$row['id']] = $row['name'] . " (" . $row['code'] . ")";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teachers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include '../includes/sidebar.php'; ?>

        <main class="col-md-10 ms-sm-auto px-md-4 mt-3">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">Teachers</h1>
            </div>

            <?php if (!empty($msg)) echo "<div class='alert alert-info'>$msg</div>"; ?>

            <p>View all registered teachers in the system.</p>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Teacher ID</th>
                        <th>Department</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($teachersResult->num_rows > 0): ?>
                        <?php while ($teacher = $teachersResult->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($teacher['id']); ?></td>
                                <td><?= htmlspecialchars($teacher['name']); ?></td>
                                <td><?= htmlspecialchars($teacher['email']); ?></td>
                                <td><?= htmlspecialchars($teacher['teacher_id']); ?></td>
                                <td><?= htmlspecialchars($departments[$teacher['department_id']] ?? 'Unassigned'); ?></td>
                                <td><?= htmlspecialchars($teacher['created_at']); ?></td>
                                <td>
                                    <!-- Trigger Edit Modal -->
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editTeacherModal<?= $teacher['id'] ?>">
                                        Edit
                                    </button>
                                    <!-- Delete (simple GET) -->
                                    <a href="delete-teacher.php?id=<?= $teacher['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">
                                        Delete
                                    </a>
                                </td>
                            </tr>

                            <!-- Edit Teacher Modal -->
                            <div class="modal fade" id="editTeacherModal<?= $teacher['id'] ?>" tabindex="-1" aria-labelledby="editTeacherModalLabel<?= $teacher['id'] ?>" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <form method="POST">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="editTeacherModalLabel<?= $teacher['id'] ?>">Edit Teacher</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                          <input type="hidden" name="id" value="<?= $teacher['id'] ?>">
                                          <div class="mb-3">
                                              <label class="form-label">Full Name</label>
                                              <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($teacher['name']) ?>" required>
                                          </div>
                                          <div class="mb-3">
                                              <label class="form-label">Email</label>
                                              <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($teacher['email']) ?>" required>
                                          </div>
                                          <div class="mb-3">
                                              <label class="form-label">Department</label>
                                              <select class="form-control" name="department_id">
                                                  <option value="">Unassigned</option>
                                                  <?php foreach ($departments as $dep_id => $dep_name): ?>
                                                      <option value="<?= $dep_id ?>" <?= ($teacher['department_id']==$dep_id)?'selected':'' ?>><?= $dep_name ?></option>
                                                  <?php endforeach; ?>
                                              </select>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                          <button type="submit" class="btn btn-success">Update Teacher</button>
                                      </div>
                                  </form>
                                </div>
                              </div>
                            </div>

                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No teachers found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
