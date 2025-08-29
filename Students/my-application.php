<?php
include("config/conn.php");

$stmt = $conn->prepare("
    SELECT 
        a.id AS application_id,
        j.title AS job_title,
        d.name AS department_name,
        a.status,
        a.created_at
    FROM applications a
    JOIN job_postings j ON a.job_id = j.id
    JOIN departments d ON j.department_id = d.id
    WHERE a.student_id = ?
    ORDER BY a.created_at DESC
");
$stmt->bind_param("i", $studentId);
$stmt->execute();
$result = $stmt->get_result();
?>

<h1 class="text-3xl font-bold text-gray-800 mb-6">My Applications</h1>

<div class="bg-white shadow rounded-lg p-6">
    <?php if ($result->num_rows > 0): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Job Title</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Department</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Date Applied</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm text-gray-600">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="px-4 py-2"><?php echo htmlspecialchars($row['job_title']); ?></td>
                            <td class="px-4 py-2"><?php echo htmlspecialchars($row['department_name']); ?></td>
                            <td class="px-4 py-2">
                                <?php 
                                    $statusColors = [
                                        "pending" => "bg-yellow-100 text-yellow-800",
                                        "approved" => "bg-green-100 text-green-800",
                                        "rejected" => "bg-red-100 text-red-800"
                                    ];
                                    $statusClass = $statusColors[strtolower($row['status'])] ?? "bg-gray-100 text-gray-800";
                                ?>
                                <span class="px-2 py-1 rounded-full text-xs font-medium <?php echo $statusClass; ?>">
                                    <?php echo ucfirst($row['status']); ?>
                                </span>
                            </td>
                            <td class="px-4 py-2"><?php echo date("M d, Y", strtotime($row['created_at'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-gray-500">You have not applied for any jobs yet.</p>
    <?php endif; ?>
</div>
