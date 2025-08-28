<?php

if (!isset($_SESSION['user_name']) || !isset($_SESSION['role'])) {
    header("Location: ../Auth/login.php");
    exit();
}

$userName = htmlspecialchars($_SESSION['user_name']);
?>

<!-- Top Navbar -->
<header class="bg-green-600 text-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center p-4">
        <div class="flex items-center">
            <!-- Mobile menu button -->
            <button id="menu-toggle" class="md:hidden mr-3 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <a href="index.php" class="text-xl font-bold tracking-wide">Panel</a>
        </div>

        <div class="flex items-center space-x-4">
            <span class="font-semibold">Welcome, <?= $userName ?></span>
            <a href="../Auth/logout.php"
                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md font-semibold text-sm">Logout</a>
        </div>
    </div>
</header>