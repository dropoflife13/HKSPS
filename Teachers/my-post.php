<?php

$teacherId = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT jp.*, d.name AS department_name,
           (SELECT COUNT(*) 
            FROM applications a 
            WHERE a.job_id = jp.id AND a.status = 'approved') AS accepted_applicants
    FROM job_postings jp
    LEFT JOIN departments d ON jp.department_id = d.id
    WHERE jp.posted_by_id = ?
    ORDER BY jp.posted_date DESC
");
$stmt->bind_param("i", $teacherId);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">My Duties</h1>
    <a href="index.php?page=duties/create-duty" 
       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow-md transition">
        + Create Duty
    </a>
</div>

<?php if ($result->num_rows === 0): ?>
    <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg shadow-sm">
        No duties posted yet.
    </div>
<?php else: ?>
    <div class="space-y-4">
        <?php while($duty = $result->fetch_assoc()): ?>
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 hover:shadow-md transition">
                <h2 class="text-xl font-semibold text-gray-800">
                    <?= htmlspecialchars($duty['title']) ?> 
                    <span class="text-sm text-gray-500">(<?= htmlspecialchars($duty['department_name']) ?>)</span>
                </h2>
                <p class="text-gray-600 mt-2"><?= htmlspecialchars($duty['description']) ?></p>

                <div class="mt-3 space-y-1 text-sm text-gray-700">
                    <p><span class="font-medium">Schedule:</span> <?= htmlspecialchars($duty['schedule']) ?></p>
                    <p><span class="font-medium">Status:</span> <?= htmlspecialchars($duty['status']) ?></p>
                    <p><span class="font-medium">Max Applicants:</span> <?= $duty['max_applicants'] ?></p>
                    <p><span class="font-medium">Accepted Applicants:</span> <?= $duty['accepted_applicants'] ?></p>
                </div>

                <div class="flex gap-3 mt-4">
                    <a href="index.php?page=duties/update-duty&id=<?= $duty['id'] ?>" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 text-sm rounded-lg shadow-sm transition">
                        Edit
                    </a>
                    <a href="index.php?page=duties/delete-duty&id=<?= $duty['id'] ?>" 
                       onclick="return confirm('Are you sure?')" 
                       class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 text-sm rounded-lg shadow-sm transition">
                        Delete
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>
