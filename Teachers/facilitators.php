<?php

require_once __DIR__ . '/../config/conn.php';

// Check teacher session
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../Auth/login.php");
    exit;
}

$teacherId = $_SESSION['user_id'];

// Handle removal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_id'])) {
    $applicationId = intval($_POST['remove_id']);

    // Verify teacher owns this application
    $stmt = $conn->prepare("
        SELECT job_id FROM applications a
        JOIN job_postings j ON a.job_id = j.id
        WHERE a.id = ? AND j.posted_by_id = ?
    ");
    $stmt->bind_param("ii", $applicationId, $teacherId);
    $stmt->execute();
    $res = $stmt->get_result();
    $app = $res->fetch_assoc();

    if ($app) {
        $jobId = $app['job_id'];
        $del = $conn->prepare("DELETE FROM applications WHERE id = ?");
        $del->bind_param("i", $applicationId);
        $del->execute();

        // Update current applicants
        $upd = $conn->prepare("UPDATE job_postings SET current_applicants = GREATEST(current_applicants - 1, 0) WHERE id = ?");
        $upd->bind_param("i", $jobId);
        $upd->execute();

        $successMsg = "Facilitator removed successfully.";
    } else {
        $errorMsg = "Unauthorized or facilitator not found.";
    }
}

// Fetch facilitators
$stmt = $conn->prepare("
    SELECT a.id AS application_id, u.name AS student_name, j.title AS duty_title
    FROM applications a
    JOIN users u ON a.student_id = u.id
    JOIN job_postings j ON a.job_id = j.id
    WHERE a.status = 'approved' AND j.posted_by_id = ?
");
$stmt->bind_param("i", $teacherId);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">My Facilitators</h1>
        <p class="text-gray-600 mt-2">Students who have been accepted for your duties</p>
        <?php if (!empty($successMsg)) : ?>
            <p class="mt-2 text-green-600 font-medium"><?= htmlspecialchars($successMsg); ?></p>
        <?php endif; ?>
        <?php if (!empty($errorMsg)) : ?>
            <p class="mt-2 text-red-600 font-medium"><?= htmlspecialchars($errorMsg); ?></p>
        <?php endif; ?>
    </div>

    <?php if ($result->num_rows > 0): ?>
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-r from-hk-green-50 to-hk-green-100 px-6 py-4 border-b border-hk-green-200">
            <h2 class="text-xl font-semibold text-gray-800">Accepted Facilitators</h2>
        </div>
        <ul class="divide-y divide-gray-100">
            <?php while ($row = $result->fetch_assoc()): ?>
            <li class="p-6 hover:bg-gray-50 transition-colors duration-200">
                <div class="flex items-start justify-between">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 bg-hk-green-100 p-3 rounded-lg mr-4">
                            <i class="fas fa-user-graduate text-hk-green-600 text-xl"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($row['student_name']); ?></h3>
                            <p class="text-gray-600 mt-1">Assigned to: <?= htmlspecialchars($row['duty_title']); ?></p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">Accepted</span>
                        <form method="POST" onsubmit="return confirm('Are you sure you want to remove this facilitator?')">
                            <input type="hidden" name="remove_id" value="<?= $row['application_id']; ?>">
                            <button type="submit" class="px-3 py-1 bg-red-100 text-red-600 rounded-lg text-sm font-medium hover:bg-red-200 flex items-center">
                                <i class="fas fa-user-minus mr-1"></i> Remove
                            </button>
                        </form>
                    </div>
                </div>
            </li>
            <?php endwhile; ?>
        </ul>
    </div>
    <?php else: ?>
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 p-8 text-center">
        <div class="mx-auto w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
            <i class="fas fa-users text-gray-400 text-2xl"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No facilitators yet</h3>
        <p class="text-gray-500">Students you accept will appear here.</p>
    </div>
    <?php endif; ?>

    <div class="mt-6">
        <a href="index.php" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i> Go Back
        </a>
    </div>
</div>
