<?php
$userName = htmlspecialchars($_SESSION['user_name']);
$userRole = $_SESSION['role']; // 'teacher'
?>

<h1 class="text-3xl font-bold text-gray-800 mb-6">Teacher Dashboard</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Manage Section -->
    <div class="bg-white shadow rounded p-4">
        <h2 class="font-semibold text-lg mb-2">Class Management</h2>
        <ul class="text-gray-600 space-y-1">
            <li><a href="index.php?page=my-classes" class="hover:underline text-blue-500">My Classes</a></li>
            <li><a href="index.php?page=students-list" class="hover:underline text-blue-500">Students</a></li>
            <li><a href="index.php?page=gradebook" class="hover:underline text-blue-500">Gradebook</a></li>
        </ul>
    </div>

    <!-- Teacher Tasks -->
    <div class="bg-white shadow rounded p-4">
        <h2 class="font-semibold text-lg mb-2">My Tasks</h2>
        <p class="text-gray-600">Pending Lessons: ...</p>
        <p class="text-gray-600">Assignments to Grade: ...</p>
    </div>

    <!-- Profile Info -->
    <div class="bg-white shadow rounded p-4">
        <h2 class="font-semibold text-lg mb-2">Profile Info</h2>
        <p class="text-gray-600">Name: <?= $userName ?></p>
        <p class="text-gray-600">Role: <?= ucfirst($userRole) ?></p>
    </div>
</div>
