<?php
session_start();
include("../config/conn.php");
$_SESSION['user_name'] = $_SESSION['user_name'] ?? 'Admin';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $siteName = trim($_POST['site_name']);
    $adminEmail = trim($_POST['admin_email']);
    $reportsEnabled = isset($_POST['reports_enabled']) ? 1 : 0;
    $jobsEnabled = isset($_POST['job_applications_enabled']) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE settings SET site_name=?, admin_email=?, reports_enabled=?, job_applications_enabled=? WHERE id=1");
    $stmt->bind_param("ssii", $siteName, $adminEmail, $reportsEnabled, $jobsEnabled);

    if ($stmt->execute()) {
        $msg = "✅ Settings updated successfully.";
    } else {
        $msg = "❌ Error updating settings: " . $conn->error;
    }
}

// Fetch current settings
$settings = $conn->query("SELECT * FROM settings WHERE id=1")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include '../includes/sidebar.php'; ?>

        <main class="col-md-10 ms-sm-auto px-md-4 mt-3">
            <h1 class="h2 mb-3">Settings</h1>

            <?php if (!empty($msg)) : ?>
                <div class="alert alert-success"><?= $msg ?></div>
            <?php endif; ?>

            <form method="POST" class="w-50">
                <div class="mb-3">
                    <label class="form-label">Site Name</label>
                    <input type="text" class="form-control" name="site_name" value="<?= htmlspecialchars($settings['site_name']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Admin Email</label>
                    <input type="email" class="form-control" name="admin_email" value="<?= htmlspecialchars($settings['admin_email']) ?>" required>
                </div>

                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="reports_enabled" id="reports_enabled" <?= $settings['reports_enabled'] ? 'checked' : '' ?>>
                    <label class="form-check-label" for="reports_enabled">
                        Enable Report System
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="job_applications_enabled" id="job_applications_enabled" <?= $settings['job_applications_enabled'] ? 'checked' : '' ?>>
                    <label class="form-check-label" for="job_applications_enabled">
                        Enable Job Applications
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">Save Settings</button>
            </form>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
