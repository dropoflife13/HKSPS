<?php

$userId = $_SESSION['user_id'];
$successMsg = '';
$errorMsg = '';

// Handle profile update
if (isset($_POST['update_profile'])) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $department_id = $_POST['department_id'] ?? null;
    $id_code = $_POST['id_code'] ?? '';

    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, department_id=?, student_id=? WHERE id=?");
    $stmt->bind_param("ssisi", $name, $email, $department_id, $id_code, $userId);

    if ($stmt->execute()) {
        $successMsg = "✅ Profile updated successfully!";
    } else {
        $errorMsg = "❌ Failed to update profile: " . $stmt->error;
    }
}

// Fetch user info
$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Fetch departments
$departments = $conn->query("SELECT id, name FROM departments ORDER BY name ASC");

// Determine ID label and value
$idLabel = ($user['role'] === 'teacher') ? 'Teacher ID' : 'Student ID';
$idValue = ($user['role'] === 'teacher') ? $user['teacher_id'] : $user['student_id'];
?>

<h1 class="text-2xl font-bold text-gray-800 mb-6">My Profile</h1>

<?php if ($successMsg): ?>
    <div class="mb-4 p-3 rounded bg-green-100 text-green-700 border border-green-300">
        <?= $successMsg ?>
    </div>
<?php endif; ?>
<?php if ($errorMsg): ?>
    <div class="mb-4 p-3 rounded bg-red-100 text-red-700 border border-red-300">
        <?= $errorMsg ?>
    </div>
<?php endif; ?>

<form method="POST" class="bg-white shadow rounded-lg p-6 max-w-xl space-y-4">
    <!-- Name -->
    <div>
        <label class="block text-gray-700 font-medium mb-2">Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>"
               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
    </div>

    <!-- Email -->
    <div>
        <label class="block text-gray-700 font-medium mb-2">Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"
               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
    </div>

    <!-- Student/Teacher ID -->
    <div>
        <label class="block text-gray-700 font-medium mb-2"><?= $idLabel ?></label>
        <input type="text" name="id_code" value="<?= htmlspecialchars($idValue) ?>"
               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
    </div>

    <!-- Department -->
    <div>
        <label class="block text-gray-700 font-medium mb-2">Department</label>
        <select name="department_id" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
            <option value="">Select Department</option>
            <?php while ($dept = $departments->fetch_assoc()): ?>
                <option value="<?= $dept['id'] ?>" <?= ($user['department_id'] == $dept['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($dept['name']) ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <button type="submit" name="update_profile" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
        Update Profile
    </button>
</form>
