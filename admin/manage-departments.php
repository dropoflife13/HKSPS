<?php
require_once __DIR__ . '/../modals/department.php';
showDepartmentModals(); 

$departments = $conn->query("SELECT * FROM departments ORDER BY id ASC");
?>

<div class="px-6 py-4">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manage Departments</h1>
        <button onclick="openModal('addDeptModal')" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow-md transition">
            + Add Department
        </button>
    </div>

    <!-- Message -->
    <?php if (!empty($msg)) : ?>
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4"><?= $msg ?></div>
    <?php endif; ?>

    <!-- Departments Table -->
    <div class="overflow-x-auto bg-white rounded-xl shadow-md">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">ID</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Code</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Name</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Description</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php while($dept = $departments->fetch_assoc()): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2"><?= $dept['id'] ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($dept['code']) ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($dept['name']) ?></td>
                    <td class="px-4 py-2"><?= htmlspecialchars($dept['description']) ?></td>
                    <td class="px-4 py-2 space-x-2">
                        <!-- Edit Button -->
                        <button 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded shadow-sm text-sm transition"
                            onclick="
                                document.getElementById('editDeptId').value='<?= $dept['id'] ?>';
                                document.getElementById('editDeptCode').value='<?= htmlspecialchars($dept['code'], ENT_QUOTES) ?>';
                                document.getElementById('editDeptName').value='<?= htmlspecialchars($dept['name'], ENT_QUOTES) ?>';
                                document.getElementById('editDeptDesc').value='<?= htmlspecialchars($dept['description'], ENT_QUOTES) ?>';
                                openModal('editDeptModal');
                            ">
                            Edit
                        </button>
                        <button
    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded shadow-sm text-sm transition"
    onclick="
        document.getElementById('deleteDeptId').value='<?= $dept['id'] ?>';
        openModal('deleteDeptModal');
    ">
    Delete
</button>


                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
