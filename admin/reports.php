<?php
session_start();
include("../config/conn.php");

// Update report status
if (isset($_POST['update_status'])) {
    $stmt = $conn->prepare("UPDATE reports SET status=? WHERE id=?");
    $stmt->bind_param("si", $_POST['status'], $_POST['report_id']);
    $stmt->execute();
}

// Fetch all reports
$reports = $conn->query("SELECT r.*, u.name FROM reports r JOIN users u ON r.submitted_by = u.id ORDER BY r.created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include '../includes/sidebar.php'; ?>

        <main class="col-md-10 ms-sm-auto px-md-4 mt-3">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Reports</h1>
            </div>

            <p>View and manage reports submitted by students and teachers.</p>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Submitted By</th>
                            <th>Role</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($reports->num_rows > 0): ?>
                            <?php while ($r = $reports->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $r['id'] ?></td>
                                    <td><?= htmlspecialchars($r['name']) ?></td>
                                    <td><?= $r['role'] ?></td>
                                    <td><?= htmlspecialchars($r['title']) ?></td>
                                    <td><?= htmlspecialchars($r['description']) ?></td>
                                    <td><?= ucfirst($r['status']) ?></td>
                                    <td>
                                        <form method="POST" class="d-flex gap-1">
                                            <input type="hidden" name="report_id" value="<?= $r['id'] ?>">
                                            <select name="status" class="form-select form-select-sm">
                                                <option value="pending" <?= $r['status']=='pending'?'selected':'' ?>>Pending</option>
                                                <option value="reviewed" <?= $r['status']=='reviewed'?'selected':'' ?>>Reviewed</option>
                                                <option value="resolved" <?= $r['status']=='resolved'?'selected':'' ?>>Resolved</option>
                                            </select>
                                            <button type="submit" name="update_status" class="btn btn-sm btn-success">Update</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No reports found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
