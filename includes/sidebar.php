<?php
if (!isset($_SESSION['user_name']) || !isset($_SESSION['role'])) {
    header("Location: ../Auth/login.php");
    exit();
}

$userName = htmlspecialchars($_SESSION['user_name']);
$userRole = $_SESSION['role']; // 'student', 'teacher', 'admin'
?>

<!-- Sidebar -->
<aside id="sidebar"
    class="bg-white w-64 p-6 border-r border-gray-200 flex flex-col justify-between fixed h-screen transform -translate-x-64 md:translate-x-0 transition-transform duration-300 z-40">
    <div>
        <h2 class="text-center font-bold text-lg mb-6"><?= ucfirst($userRole) ?> Panel</h2>
        <nav class="flex flex-col space-y-2">
            <?php if ($userRole === 'student'): ?>
                <a href="index.php" class="px-3 py-2 rounded hover:bg-green-100 font-semibold text-gray-700">Home</a>
                <a href="browse-duty.php" class="px-3 py-2 rounded hover:bg-green-100 text-gray-700">Browse</a>
                <a href="apply.php" class="px-3 py-2 rounded hover:bg-green-100 text-gray-700">Apply</a>
                <a href="my-application.php" class="px-3 py-2 rounded hover:bg-green-100 text-gray-700">Applications</a>
                <a href="submit-report.php" class="px-3 py-2 rounded hover:bg-green-100 text-gray-700">Report</a>
                <a href="profile.php" class="px-3 py-2 rounded hover:bg-green-100 text-gray-700">Profile</a>
            <?php elseif ($userRole === 'teacher'): ?>
                <a href="index.php" class="px-3 py-2 rounded hover:bg-green-100 font-semibold text-gray-700">Dashboard</a>
                <a href="manage-posts.php" class="px-3 py-2 rounded hover:bg-green-100 text-gray-700">Manage Posts</a>
                <a href="reports.php" class="px-3 py-2 rounded hover:bg-green-100 text-gray-700">Reports</a>
            <?php elseif ($userRole === 'admin'): ?>
                <a href="index.php" class="px-3 py-2 rounded hover:bg-green-100 font-semibold text-gray-700">Dashboard</a>
                <a href="manage-departments.php" class="px-3 py-2 rounded hover:bg-green-100 text-gray-700">Departments</a>
                <a href="students.php" class="px-3 py-2 rounded hover:bg-green-100 text-gray-700">Students</a>
                <a href="teachers.php" class="px-3 py-2 rounded hover:bg-green-100 text-gray-700">Teachers</a>
                <a href="settings.php" class="px-3 py-2 rounded hover:bg-green-100 text-gray-700">Settings</a>
            <?php endif; ?>
        </nav>
    </div>
    <div class="text-center mt-6">
        <a href="../Auth/logout.php"
            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md font-semibold">Logout</a>
    </div>
</aside>