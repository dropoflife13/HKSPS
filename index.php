<?php
include 'config/init.php';

if (!isset($_SESSION['user_name']) || !isset($_SESSION['role'])) {
    header("Location: Auth/login.php");
    exit();
}

$roleFolders = [
    'student' => 'Students',
    'teacher' => 'Teachers',
    'admin' => 'Admin'
];

$userRole = $_SESSION['role'];
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

$folder = isset($roleFolders[$userRole]) ? $roleFolders[$userRole] : null;
$file = null;

if ($folder && file_exists(__DIR__ . "/{$folder}/{$page}.php")) {
    $file = __DIR__ . "/{$folder}/{$page}.php";
}
elseif (file_exists(__DIR__ . "/Shared/{$page}.php")) {
    $file = __DIR__ . "/Shared/{$page}.php";
}
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

    <?php include __DIR__ . '/includes/sidebar.php'; ?>

    <div class="flex min-h-screen">
        <div id="overlay" class="fixed inset-0 bg-black opacity-25 z-30 hidden md:hidden"></div>

        <main class="flex-1 ml-0 md:ml-64 transition-all duration-300">
            <?php include __DIR__ . '/includes/header.php'; ?>

            <div class="py-6 px-4 transition-all duration-300">
                <?php
                if ($file) {
                    include $file;
                } else {
                    echo "<h1 class='text-2xl font-bold text-red-600'>404 - Page not found</h1>";
                }
                ?>
            </div>
        </main>
    </div>

    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        if (menuToggle) {
            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-64');
                overlay.classList.toggle('hidden');
            });

            overlay.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-64');
                overlay.classList.add('hidden');
            });
        }
    </script>
</body>
</html>
