<?php
include 'config/conn.php';

$student_id = $_SESSION['user_id'];
$job_id = $_GET['job_id'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM job_postings WHERE id = ?");
$stmt->bind_param("i", $job_id);
$stmt->execute();
$job_result = $stmt->get_result();
$job = $job_result->fetch_assoc();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cover_letter = trim($_POST['cover_letter'] ?? '');

    $check = $conn->prepare("SELECT id FROM applications WHERE student_id = ? AND job_id = ?");
    $check->bind_param("ii", $student_id, $job_id);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        $message = '<p class="text-red-500 font-semibold">⚠️ You already applied for this duty.</p>';
    } else {
        $insert = $conn->prepare("INSERT INTO applications (job_id, student_id, applied_date, cover_letter) VALUES (?, ?, CURDATE(), ?)");
        $insert->bind_param("iis", $job_id, $student_id, $cover_letter);

        if ($insert->execute()) {
            $message = '<p class="text-green-600 font-semibold">✅ Application submitted successfully!</p>';
        } else {
            $message = '<p class="text-red-500 font-semibold">❌ Failed to submit application. Please try again.</p>';
        }
    }
}
?>

<div class="py-6 px-4 transition-all duration-300">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Apply for Duty</h1>

    <?= $message ?>

    <?php if ($job): ?>
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-2">
                <?= htmlspecialchars($job['title']) ?>
            </h2>
            <p class="text-gray-600 mb-2"><strong>Description:</strong> <?= htmlspecialchars($job['description']) ?></p>
            <p class="text-gray-600 mb-2"><strong>Schedule:</strong> <?= htmlspecialchars($job['schedule']) ?></p>
            <p class="text-gray-600 mb-4"><strong>Location:</strong> <?= htmlspecialchars($job['location']) ?></p>

            <form method="POST" class="space-y-4">
                <div>
                    <label for="cover_letter" class="block text-gray-700 font-medium">Cover Letter (optional):</label>
                    <textarea name="cover_letter" id="cover_letter" rows="5"
                              class="w-full border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                </div>
                <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-md font-semibold">
                    Submit Application
                </button>
            </form>
        </div>
    <?php else: ?>
        <p class="text-red-500 font-semibold">Job not found.</p>
    <?php endif; ?>
</div>
