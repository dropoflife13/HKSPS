<?php
$studentId = $_SESSION['user_id'];
$department_id = $_GET['department_id'] ?? '';

$dept_result = $conn->query("SELECT * FROM departments ORDER BY name ASC");

$query = "
    SELECT jp.*, u.name AS teacher_name,
           (SELECT COUNT(*) FROM applications a WHERE a.job_id = jp.id AND a.status = 'approved') AS accepted_applicants
    FROM job_postings jp
    JOIN users u ON u.id = jp.posted_by_id
    LEFT JOIN applications a_student ON a_student.job_id = jp.id AND a_student.student_id = ?
    WHERE jp.status = 'open' 
      AND a_student.id IS NULL
";

$params = [$studentId];
$types = "i";

if ($department_id) {
    $query .= " AND jp.department_id = ?";
    $params[] = $department_id;
    $types .= "i";
}

$query .= " AND (SELECT COUNT(*) FROM applications a WHERE a.job_id = jp.id AND a.status = 'approved') < jp.max_applicants";

$query .= " ORDER BY jp.posted_date DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$duties_result = $stmt->get_result();
?>

<div class="py-6 px-4 transition-all duration-300">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Browse Duties</h1>

    <label for="department_id" class="block text-gray-700 font-semibold mb-2">Select Department:</label>
    <select name="department_id" id="department_id"
        class="border border-gray-300 rounded px-3 py-2 mb-6 focus:outline-none focus:ring focus:border-blue-300">
        <option value="">All Departments</option>
        <?php while ($dept = $dept_result->fetch_assoc()): ?>
            <option value="<?= htmlspecialchars($dept['id']) ?>" <?= ($department_id == $dept['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($dept['name']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <?php if ($duties_result->num_rows > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php while ($job = $duties_result->fetch_assoc()): ?>
                <?php
                    $accepted = (int)$job['accepted_applicants'];
                    $remaining = (int)$job['max_applicants'] - $accepted;
                    $urgent_class = ($remaining <= 1) ? 'border-l-4 border-red-500' : '';
                ?>
                <div class="bg-white shadow rounded p-4 <?= $urgent_class ?>">
                    <h2 class="font-semibold text-lg mb-2"><?= htmlspecialchars($job['title']) ?></h2>
                    <p class="text-gray-600"><strong>Teacher:</strong> <?= htmlspecialchars($job['teacher_name']) ?></p>
                    <p class="text-gray-600"><strong>Schedule:</strong> <?= htmlspecialchars($job['schedule']) ?></p>
                    <p class="text-gray-600"><strong>Location:</strong> <?= htmlspecialchars($job['location']) ?></p>
                    <p class="text-gray-600"><strong>Status:</strong> <?= htmlspecialchars(ucfirst($job['status'])) ?></p>
                    <p class="text-gray-600"><strong>Max Applicants:</strong> <?= (int)$job['max_applicants'] ?></p>
                    <p class="text-gray-600"><strong>Accepted:</strong> <?= $accepted ?> / <?= (int)$job['max_applicants'] ?></p>
                    <p class="text-gray-600"><strong>Description:</strong> <?= htmlspecialchars($job['description']) ?></p>
                    <p class="text-gray-600"><strong>Requirements:</strong> <?= htmlspecialchars($job['requirements']) ?></p>

                    <?php if ($accepted < (int)$job['max_applicants']): ?>
                        <a href="index.php?page=apply&job_id=<?= (int)$job['id'] ?>"
                           class="inline-block mt-3 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-semibold">
                           Apply
                        </a>
                    <?php else: ?>
                        <span class="inline-block mt-3 text-gray-500 font-semibold">Full</span>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="text-gray-600">No duties available.</p>
    <?php endif; ?>
</div>

<script>
document.getElementById('department_id').addEventListener('change', function() {
    const deptId = this.value;
    window.location.href = deptId ? `index.php?page=browse-duty&department_id=${deptId}` : 'index.php?page=browse-duty';
});
</script>
