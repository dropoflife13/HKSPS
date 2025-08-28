<?php
session_start();
if (!isset($_SESSION['user_name']) || !isset($_SESSION['role'])) {
    header("Location: ../Auth/login.php");
    exit();
}

$userName = htmlspecialchars($_SESSION['user_name']);
$userRole = $_SESSION['role']; // 'student', 'teacher', 'admin'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ucfirst($userRole) ?> Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">


    <?php include '../includes/sidebar.php' ?>
    <div class="flex min-h-screen">
        <!-- Overlay for mobile -->
        <div id="overlay" class="fixed inset-0 bg-black opacity-25 z-30 hidden md:hidden"></div>

        <!-- Main Content -->
        <main class="flex-1 ml-0 md:ml-64  transition-all duration-300">
            <?php include '../includes/header.php' ?>
            <div class="py-6 px-4 transition-all duration-300">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">Welcome to your Dashboard</h1>

                <!-- Example content -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white shadow rounded p-4">
                        <h2 class="font-semibold text-lg mb-2">Quick Links</h2>
                        <ul class="text-gray-600 space-y-1">
                            <li><a href="apply.php" class="hover:underline text-blue-500">Apply for Duty</a></li>
                            <li><a href="my-application.php" class="hover:underline text-blue-500">View Applications</a>
                            </li>
                        </ul>
                    </div>
                    <div class="bg-white shadow rounded p-4">
                        <h2 class="font-semibold text-lg mb-2">Recent Activities</h2>
                        <p class="text-gray-600">No recent activities yet.</p>
                    </div>
                    <div class="bg-white shadow rounded p-4">
                        <h2 class="font-semibold text-lg mb-2">Profile Info</h2>
                        <p class="text-gray-600">Name: <?= $userName ?></p>
                        <p class="text-gray-600">Role: <?= ucfirst($userRole) ?></p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-64');
            overlay.classList.toggle('hidden');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-64');
            overlay.classList.add('hidden');
        });
    </script>

</body>

</html>