<?php
require_once BASE_PATH . '/config/modal.php';

$_SESSION['user_name'] = $_SESSION['user_name'] ?? 'Admin';
$msg = "";

// ---------------------------
// Handle Add/Edit/Delete Logic using button names
// ---------------------------

// ADD Department
if (isset($_POST['add_department'])) {
    $code = strtoupper(trim($_POST['code'] ?? ''));
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($code && $name) {
        $stmt = $conn->prepare("INSERT INTO departments (code, name, description) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $code, $name, $description);
        if ($stmt->execute()) {
            $msg = "✅ Department created successfully.";
        } else {
            $msg = "❌ Error creating: " . $conn->error;
        }
    } else {
        $msg = "❌ Code and Name are required.";
    }
}

// EDIT Department
if (isset($_POST['update_department'])) {
    $id = intval($_POST['id'] ?? 0);
    $code = strtoupper(trim($_POST['code'] ?? ''));
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($id && $code && $name) {
        $stmt = $conn->prepare("UPDATE departments SET code=?, name=?, description=? WHERE id=?");
        $stmt->bind_param("sssi", $code, $name, $description, $id);
        if ($stmt->execute()) {
            $msg = "✅ Department updated successfully.";
        } else {
            $msg = "❌ Error updating: " . $conn->error;
        }
    } else {
        $msg = "❌ Code and Name are required.";
    }
}

// DELETE Department
if (isset($_POST['delete_department'])) {
    $delete_id = intval($_POST['delete_id'] ?? 0);

    // Check foreign key constraint
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM job_postings WHERE department_id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result['count'] > 0) {
        $msg = "❌ Cannot delete this department. It has related job postings.";
    } else {
        $stmt = $conn->prepare("DELETE FROM departments WHERE id = ?");
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute()) {
            $msg = "✅ Department deleted successfully.";
        } else {
            $msg = "❌ Error deleting: " . $conn->error;
        }
    }
}

// Fetch all departments
$departments = $conn->query("SELECT * FROM departments ORDER BY id ASC");

// ---------------------------
// Show All Modals
// ---------------------------
function showDepartmentModals() {
    global $departments;

    while ($dept = $departments->fetch_assoc()):
        // Edit Modal
        showModal("editDeptModal{$dept['id']}", "Edit Department", '
            <form method="POST" class="space-y-4">
                <input type="hidden" name="id" value="'.$dept['id'].'">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Department Code</label>
                    <input type="text" name="code" value="'.htmlspecialchars($dept['code'], ENT_QUOTES).'" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Department Name</label>
                    <input type="text" name="name" value="'.htmlspecialchars($dept['name'], ENT_QUOTES).'" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">'.htmlspecialchars($dept['description'], ENT_QUOTES).'</textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal(\'editDeptModal'.$dept['id'].'\')" class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
                    <button type="submit" name="update_department" class="bg-blue-600 text-white px-4 py-2 rounded">Update Department</button>
                </div>
            </form>
        ');

        // Delete Modal
        showModal("deleteDeptModal{$dept['id']}", "Delete Department", '
            <p class="text-gray-700">Are you sure you want to delete this department?</p>
            <form method="POST" class="flex justify-end space-x-2 mt-4">
                <input type="hidden" name="delete_id" value="'.$dept['id'].'">
                <button type="button" onclick="closeModal(\'deleteDeptModal'.$dept['id'].'\')" class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
                <button type="submit" name="delete_department" class="bg-red-600 text-white px-4 py-2 rounded">Delete</button>
            </form>
        ');

    endwhile;

    $departments->data_seek(0);
}
?>
