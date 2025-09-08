<?php
require_once __DIR__ . '/../modals/admin/students.php';
showStudentModals();
$users = $conn->query("SELECT * FROM users WHERE role = 'student' ORDER BY id ASC");
?>

<main class="px-6 py-4">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manage Students</h1>
        <button 
            onclick="openModal('addUserModal')" 
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow-md transition">
            + Add Student
        </button>
    </div>

    <!-- Display message -->
    <?php if (!empty($msg)) : ?>
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4"><?= $msg ?></div>
    <?php endif; ?>

    <!-- Users Table -->
    <div class="overflow-x-auto bg-white rounded-xl shadow-md">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">ID</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Student ID</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Name</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Email</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Role</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php while($user = $users->fetch_assoc()): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2"><?= $user['id'] ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($user['student_id'] ?? '') ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($user['name']) ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($user['email']) ?></td>
                    <td class="px-4 py-2 capitalize"><?= htmlspecialchars($user['role']) ?></td>
                    <td class="px-4 py-2 flex space-x-2">
                        <button
                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded shadow-sm text-sm transition"
                            onclick="openModal('editUserModal<?= $user['id'] ?>')">
                            Edit
                        </button>
                        <button
                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded shadow-sm text-sm transition"
                            onclick="openModal('deleteUserModal<?= $user['id'] ?>')">
                            Delete
                        </button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>
