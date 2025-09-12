<?php
require_once BASE_PATH . '/config/modal.php';

$msg = "";

// Fetch all students into an array
$studentsArray = [];
$studentsResult = $conn->query("SELECT * FROM users WHERE role='student' ORDER BY id ASC");
if ($studentsResult && $studentsResult->num_rows > 0) {
    while ($row = $studentsResult->fetch_assoc()) {
        $studentsArray[] = $row;
    }
}

// ---------------------------
// Show All Modals
// ---------------------------
function showStudentModals() {
    global $studentsArray;
    foreach ($studentsArray as $student):
        // Edit Modal
            showModal("editStudentModal{$student['id']}", "Edit User", '
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
                        <button type="button" onclick="closeModal(\'editStudentModal'.$student['id'].'\')" class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
                        <button type="submit" name="update_user" class="bg-blue-600 text-white px-4 py-2 rounded">Update User</button>
                    </div>
                </form>
            ');

        // Delete Modal
        showModal("deleteStudentModal{$student['id']}", "Delete User", '
            <p class="text-gray-700">Are you sure you want to delete this user?</p>
            <form method="POST" class="flex justify-end space-x-2 mt-4">
                <input type="hidden" name="delete_id" value="'.$student['id'].'">
                <button type="button" onclick="closeModal(\'deleteStudentModal'.$student['id'].'\')" class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
                <button type="submit" name="delete_user" class="bg-red-600 text-white px-4 py-2 rounded">Delete</button>
            </form>
        ');
    endforeach;
}
?>
