<?php
require_once BASE_PATH . '/config/modal.php';

$msg = "";

// ---------------------------
// Handle Add/Edit/Delete Logic using button names
// ---------------------------

// UPDATE User
if (isset($_POST['update_user'])) {
    $id         = intval($_POST['id'] ?? 0);
    $student_id = trim($_POST['student_id'] ?? '');
    $name       = trim($_POST['name'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $role       = trim($_POST['role'] ?? '');

    if ($id && $name && $email && $role) {
        $stmt = $conn->prepare("UPDATE users SET student_id=?, name=?, email=?, role=? WHERE id=?");
        $stmt->bind_param("ssssi", $student_id, $name, $email, $role, $id);

        if ($stmt->execute()) {
            $msg = "✅ User updated successfully.";
        } else {
            $msg = "❌ Error updating user: " . $conn->error;
        }
    } else {
        $msg = "❌ All fields are required.";
    }
}

// DELETE User
if (isset($_POST['delete_user'])) {
    $delete_id = intval($_POST['delete_id'] ?? 0);

    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        $msg = "✅ User deleted successfully.";
    } else {
        $msg = "❌ Error deleting user: " . $conn->error;
    }
}

// Fetch all students
$students = $conn->query("SELECT * FROM users WHERE role='student' ORDER BY id ASC");

// ---------------------------
// Show All Modals
// ---------------------------
function showStudentModals() {
    global $students;
    while ($student = $students->fetch_assoc()): ?>
        <!-- Edit Student Modal -->
        <?php showModal("editUserModal{$student['id']}", "Edit User", '
            <form method="POST" class="space-y-4">
                <input type="hidden" name="id" value="'.$student['id'].'">
                <div>
                    <label class="block text-sm font-medium">Student ID</label>
                    <input type="text" name="student_id" value="'.htmlspecialchars($student['student_id'] ?? '', ENT_QUOTES).'" class="mt-1 block w-full border rounded-md px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Name</label>
                    <input type="text" name="name" value="'.htmlspecialchars($student['name'], ENT_QUOTES).'" class="mt-1 block w-full border rounded-md px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Email</label>
                    <input type="email" name="email" value="'.htmlspecialchars($student['email'], ENT_QUOTES).'" class="mt-1 block w-full border rounded-md px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Role</label>
                    <select name="role" class="mt-1 block w-full border rounded-md px-3 py-2" required>
                        <option value="student" '.($student['role']=='student'?'selected':'').'>Student</option>
                        <option value="teacher" '.($student['role']=='teacher'?'selected':'').'>Teacher</option>
                        <option value="admin" '.($student['role']=='admin'?'selected':'').'>Admin</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal(\'editUserModal'.$student['id'].'\')" class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
                    <button type="submit" name="update_user" class="bg-blue-600 text-white px-4 py-2 rounded">Update User</button>
                </div>
            </form>
        '); ?>

        <!-- Delete Student Modal -->
        <?php showModal("deleteUserModal{$student['id']}", "Delete User", '
            <p class="text-gray-700">Are you sure you want to delete this user?</p>
            <form method="POST" class="flex justify-end space-x-2 mt-4">
                <input type="hidden" name="delete_id" value="'.$student['id'].'">
                <button type="button" onclick="closeModal(\'deleteUserModal'.$student['id'].'\')" class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
                <button type="submit" name="delete_user" class="bg-red-600 text-white px-4 py-2 rounded">Delete</button>
            </form>
        '); ?>
    <?php endwhile;
    // Reset pointer so we can loop again in table
    $students->data_seek(0);
}
?>
