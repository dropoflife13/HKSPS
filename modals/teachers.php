<?php
require_once BASE_PATH . '/config/modal.php';

$msg = "";

// ---------------------------
// Handle Update/Delete Teacher
// ---------------------------
// UPDATE Teacher
if (isset($_POST['update_teacher'])) {
    $id = intval($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $department_id = intval($_POST['department_id'] ?? 0);

    if ($id && $name && $email) {
        $stmt = $conn->prepare("UPDATE users SET name=?, email=?, department_id=? WHERE id=? AND role='teacher'");
        $stmt->bind_param("ssii", $name, $email, $department_id, $id);

        if ($stmt->execute()) {
            $msg = "✅ Teacher updated successfully.";
        } else {
            $msg = "❌ Error updating teacher: " . $conn->error;
        }
    } else {
        $msg = "❌ All fields are required.";
    }
}

// DELETE Teacher
if (isset($_POST['delete_teacher'])) {
    $delete_id = intval($_POST['delete_id'] ?? 0);
    $stmt = $conn->prepare("DELETE FROM users WHERE id=? AND role='teacher'");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        $msg = "✅ Teacher deleted successfully.";
    } else {
        $msg = "❌ Error deleting teacher: " . $conn->error;
    }
}


// ---------------------------
// Fetch Teachers & Departments
// ---------------------------
$teachers = $conn->query("SELECT * FROM users WHERE role='teacher' ORDER BY id ASC");

$departmentsResult = $conn->query("SELECT id, name, code FROM departments ORDER BY name ASC");
$departments = [];
while ($row = $departmentsResult->fetch_assoc()) {
    $departments[$row['id']] = $row['name'] . " (" . $row['code'] . ")";
}

// ---------------------------
// Generate Modals Dynamically
// ---------------------------
function showTeacherModals() {
    global $teachers, $departments;
    while ($teacher = $teachers->fetch_assoc()): ?>
        <!-- Edit Teacher Modal -->
        <?php showModal("editTeacherModal{$teacher['id']}", "Edit Teacher", '
            <form method="POST" class="space-y-4">
                <input type="hidden" name="id" value="'.$teacher['id'].'">
                <div>
                    <label class="block text-sm font-medium">Full Name</label>
                    <input type="text" name="name" value="'.htmlspecialchars($teacher['name'], ENT_QUOTES).'" class="mt-1 block w-full border rounded-md px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Email</label>
                    <input type="email" name="email" value="'.htmlspecialchars($teacher['email'], ENT_QUOTES).'" class="mt-1 block w-full border rounded-md px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Department</label>
                    <select name="department_id" class="mt-1 block w-full border rounded-md px-3 py-2">
                        <option value="">Unassigned</option>
                        '.implode('', array_map(function($id, $name) use ($teacher) {
                            $selected = ($teacher['department_id']==$id)?'selected':'';
                            return "<option value=\"$id\" $selected>$name</option>";
                        }, array_keys($departments), $departments)).'
                    </select>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal(\'editTeacherModal'.$teacher['id'].'\')" class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
                    <button type="submit" name="update_teacher" class="bg-blue-600 text-white px-4 py-2 rounded">Update Teacher</button>
                </div>
            </form>
        '); ?>

        <!-- Delete Teacher Modal -->
        <?php showModal("deleteTeacherModal{$teacher['id']}", "Delete Teacher", '
            <p class="text-gray-700">Are you sure you want to delete this teacher?</p>
            <form method="POST" class="flex justify-end space-x-2 mt-4">
                <input type="hidden" name="delete_id" value="'.$teacher['id'].'">
                <button type="button" onclick="closeModal(\'deleteTeacherModal'.$teacher['id'].'\')" class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
                <button type="submit" name="delete_teacher" class="bg-red-600 text-white px-4 py-2 rounded">Delete</button>
            </form>
        '); ?>
    <?php endwhile;

    // Reset pointer to reuse in table
    $teachers->data_seek(0);
}


function showAddTeacherModal() {
    global $departments;
    showModal("addTeacherModal", "Add Teacher", '
        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium">Full Name</label>
                <input type="text" name="name" class="mt-1 block w-full border rounded-md px-3 py-2" required>
            </div>
           
               <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" class="mt-1 block w-full border rounded-md px-3 py-2" required>
            </div>
             <div>
                <label class="block text-sm font-medium">Teacher ID</label>
               <input type="text" name="teacher_id" class="mt-1 block w-full border rounded-md px-3 py-2" required>

            </div>  
            <div>
                <label class="block text-sm font-medium">Department</label>
                <select name="department_id" class="mt-1 block w-full border rounded-md px-3 py-2">
                    <option value="">Unassigned</option>
                    '.implode("", array_map(function($id, $name){
                        return "<option value=\"$id\">$name</option>";
                    }, array_keys($departments), $departments)).'
                </select>
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeModal(\'addTeacherModal\')" class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
                <button type="submit" name="add_teacher" class="bg-green-600 text-white px-4 py-2 rounded">Add Teacher</button>
            </div>
        </form>
    ');
}
if (isset($_POST['add_teacher'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $teacher_id = trim($_POST['teacher_id'] ?? '');
    $department_id = intval($_POST['department_id'] ?? 0);

    if ($name && $email && $teacher_id) {
        $stmt = $conn->prepare("
            INSERT INTO users (name, email, teacher_id, department_id, role) 
            VALUES (?, ?, ?, ?, 'teacher')
        ");
        $stmt->bind_param("sssi", $name, $email, $teacher_id, $department_id);
        if ($stmt->execute()) {
            $msg = "✅ Teacher added successfully.";
        } else {
            $msg = "❌ Error adding teacher: " . $conn->error;
        }
    } else {
        $msg = "❌ All fields are required.";
    }
}

?>
