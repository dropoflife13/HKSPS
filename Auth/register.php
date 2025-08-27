<?php
session_start();
require '../config/conn.php';

// Fetch departments for dropdown
$deptResult = $conn->query("SELECT id, name FROM departments ORDER BY name ASC");
$departments = $deptResult ? $deptResult->fetch_all(MYSQLI_ASSOC) : [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name       = trim($_POST['name']);
    $email      = trim($_POST['email']);
    $password   = trim($_POST['password']); // removed hashing
    $role       = $_POST['role'];
    $department_id = !empty($_POST['department']) ? $_POST['department'] : NULL;
    $student_id = ($role === 'student' && !empty($_POST['student_id'])) ? $_POST['student_id'] : NULL;
    $teacher_id = ($role === 'teacher' && !empty($_POST['teacher_id'])) ? $_POST['teacher_id'] : NULL;

    $sql = "INSERT INTO users (name, email, password, role, student_id, teacher_id, department_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $name, $email, $password, $role, $student_id, $teacher_id, $department_id);

    if ($stmt->execute()) {
        echo "✅ Registration successful!";
    } else {
        echo "❌ Error: " . $stmt->error;
    }
}
?>


<form action="register.php" method="POST">
    <label>Full Name</label>
    <input type="text" name="name" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <label>Role</label>
    <select name="role" id="role" onchange="toggleFields()" required>
        <option value="student">Student</option>
        <option value="teacher">Teacher</option>
    </select>

    <div id="studentFields">
        <label>Student ID</label>
        <input type="text" name="student_id">
    </div>

    <div id="teacherFields">
        <label>Teacher ID</label>
        <input type="text" name="teacher_id">
    </div>

    <label>Department</label>
    <select name="department" required>
        <option value="">-- Select Department --</option>
        <?php foreach ($departments as $dept): ?>
            <option value="<?= htmlspecialchars($dept['id']) ?>"><?= htmlspecialchars($dept['name']) ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Register</button>
</form>

<!-- Back to Login Button -->
<p>Already have an account?</p>
<a href="login.php"><button type="button">Login</button></a>

<script>
function toggleFields() {
    const role = document.getElementById("role").value;
    document.getElementById("studentFields").style.display = (role === "student") ? "block" : "none";
    document.getElementById("teacherFields").style.display = (role === "teacher") ? "block" : "none";
}
toggleFields(); // run on page load
</script>
