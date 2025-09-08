<?php
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

<main class="flex-1 p-6 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Settings</h1>

    <?php if (!empty($msg)) : ?>
        <div class="mb-4 p-4 rounded bg-green-100 text-green-800">
            <?= $msg ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="space-y-6 bg-white p-6 rounded shadow">
        <!-- Site Name -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Site Name</label>
            <input type="text" name="site_name" value="<?= htmlspecialchars($settings['site_name']) ?>" required
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Admin Email -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Admin Email</label>
            <input type="email" name="admin_email" value="<?= htmlspecialchars($settings['admin_email']) ?>" required
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Reports Enabled -->
        <div class="flex items-center space-x-2">
            <input type="checkbox" name="reports_enabled" id="reports_enabled" <?= $settings['reports_enabled'] ? 'checked' : '' ?>
                class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
            <label for="reports_enabled" class="text-gray-700">Enable Report System</label>
        </div>

        <!-- Job Applications Enabled -->
        <div class="flex items-center space-x-2">
            <input type="checkbox" name="job_applications_enabled" id="job_applications_enabled" <?= $settings['job_applications_enabled'] ? 'checked' : '' ?>
                class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
            <label for="job_applications_enabled" class="text-gray-700">Enable Job Applications</label>
        </div>

        <!-- Save Button -->
        <div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md shadow">
                Save Settings
            </button>
        </div>
    </form>
</main>
