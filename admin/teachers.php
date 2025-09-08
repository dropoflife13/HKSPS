<?php
require_once __DIR__ . '/../modals/admin/teachers.php';
showTeacherModals();
?>

<main class="flex-1 p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6 border-b pb-3">
        <h1 class="text-2xl font-bold text-gray-800">Teachers</h1>
    </div>

    <!-- Message -->
    <?php if (!empty($msg)): ?>
        <div class="mb-4 p-3 rounded bg-blue-100 text-blue-800">
            <?= $msg ?>
        </div>
    <?php endif; ?>

    <p class="mb-4 text-gray-600">View all registered teachers in the system.</p>

    <!-- Teachers Table -->
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">ID</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Full Name</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Email</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Teacher ID</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Department</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Created At</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if ($teachers->num_rows > 0): ?>
                    <?php while ($teacher = $teachers->fetch_assoc()): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-700"><?= htmlspecialchars($teacher['id']); ?></td>
                            <td class="px-4 py-2 text-sm text-gray-700"><?= htmlspecialchars($teacher['name']); ?></td>
                            <td class="px-4 py-2 text-sm text-gray-700"><?= htmlspecialchars($teacher['email']); ?></td>
                            <td class="px-4 py-2 text-sm text-gray-700"><?= htmlspecialchars($teacher['teacher_id']); ?></td>
                            <td class="px-4 py-2 text-sm text-gray-700"><?= htmlspecialchars($departments[$teacher['department_id']] ?? 'Unassigned'); ?></td>
                            <td class="px-4 py-2 text-sm text-gray-700"><?= htmlspecialchars($teacher['created_at']); ?></td>
                            <td class="px-4 py-2 space-x-2">
                                <button class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded shadow text-sm" onclick="openModal('editTeacherModal<?= $teacher['id'] ?>')">Edit</button>
                                <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded shadow text-sm" onclick="openModal('deleteTeacherModal<?= $teacher['id'] ?>')">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="px-4 py-3 text-center text-gray-500">No teachers found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
