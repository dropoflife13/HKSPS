<?php


// Handle form submission for updating a user
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'], $_POST['name'], $_POST['email'], $_POST['role'])) {
    $id    = $_POST['id'];
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $role  = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, role=? WHERE id=?");
    $stmt->bind_param("sssi", $name, $email, $role, $id);

    if ($stmt->execute()) {
        header("Location: students.php"); // Redirect after update
        exit();
    } else {
        $msg = "❌ Error: " . $conn->error;
    }
}

// Fetch all users
// Fetch only students
$users = $conn->query("SELECT * FROM users WHERE role = 'student' ORDER BY id ASC");

?>


        <main class="col-md-10 ms-sm-auto px-md-4 mt-3">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">Manage Users</h1>
            </div>

            <!-- Display message -->
            <?php if (!empty($msg)) : ?>
                <div class="alert alert-danger"><?= $msg ?></div>
            <?php endif; ?>

            <!-- Users Table -->
           <!-- Users Table -->
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Student ID</th> <!-- New column -->
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while($user = $users->fetch_assoc()): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['student_id'] ?? '') ?></td> <!-- Student ID -->
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['role']) ?></td>
                <td>
                    <!-- Trigger Edit Modal -->
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal<?= $user['id'] ?>">
                        Edit
                    </button>
                    <!-- Delete -->
                    <a href="students.php?delete_id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">
                        Delete
                    </a>
                </td>
            </tr>

            <!-- Edit User Modal -->
            <div class="modal fade" id="editUserModal<?= $user['id'] ?>" tabindex="-1" aria-labelledby="editUserModalLabel<?= $user['id'] ?>" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="POST">
                      <div class="modal-header">
                          <h5 class="modal-title" id="editUserModalLabel<?= $user['id'] ?>">Edit User</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                          <input type="hidden" name="id" value="<?= $user['id'] ?>">
                          <div class="mb-3">
                              <label class="form-label">Student ID</label>
                              <input type="text" class="form-control" name="student_id" value="<?= htmlspecialchars($user['student_id'] ?? '') ?>" required>
                          </div>
                          <div class="mb-3">
                              <label class="form-label">Name</label>
                              <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                          </div>
                          <div class="mb-3">
                              <label class="form-label">Email</label>
                              <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                          </div>
                          <div class="mb-3">
                              <label class="form-label">Role</label>
                              <select class="form-control" name="role" required>
                                  <option value="student" <?= $user['role']=='student'?'selected':'' ?>>Student</option>
                                  <option value="teacher" <?= $user['role']=='teacher'?'selected':'' ?>>Teacher</option>
                                  <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Admin</option>
                              </select>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-success">Update User</button>
                      </div>
                  </form>
                </div>
              </div>
            </div>

        <?php endwhile; ?>
    </tbody>
</table>

        </main>
    