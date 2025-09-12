<?php


// Default values if session variables are missing
$userName = $_SESSION['user_name'] ?? 'Guest';
$role = $_SESSION['role'] ?? 'guest';
$departmentName = $_SESSION['department_name'] ?? '';
$studentId = $_SESSION['student_id'] ?? '';

$userName = htmlspecialchars($_SESSION['user_name']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HAWAK KAMAY - Header</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        'hk-green': {
                            50: '#eff1ed',
                            100: '#f0fff1',
                            200: '#d8f3dc',
                            300: '#b7e4c7',
                            400: '#52b788',
                            500: '#40916c',
                            600: '#1b4332',
                            700: '#081c15',
                            800: '#071a14',
                            900: '#051611',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .hk-gradient-bg {
            background: linear-gradient(135deg, #081c15 0%, #40916c 100%);
        }
        .header-shadow {
            box-shadow: 0 4px 20px rgba(6, 78, 59, 0.15);
        }
    </style>
</head>
<body class="font-sans bg-hk-green-50 min-h-screen">
<header class="hk-gradient-bg text-white header-shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-3">
            <div class="flex items-center">
                <!-- Mobile menu button -->
                <button id="menu-toggle" class="md:hidden mr-4 focus:outline-none p-1 rounded-lg hover:bg-hk-green-700 transition-colors">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-lg">HK</span>
                    </div>
                    <a href="index.php" class="text-xl font-bold tracking-wide flex items-center">
                        <span class="text-white">HAWAK</span>
                        <span class="text-hk-green-200">KAMAY</span>
                    </a>
                </div>
            </div>

            <div class="flex items-center space-x-5">
                <!-- Notifications -->
                <div class="relative hidden md:block">
                    <button class="p-2 rounded-full hover:bg-hk-green-700 transition-colors">
                        <i class="far fa-bell text-hk-green-100"></i>
                    </button>
                    <span class="absolute top-0 right-0 w-4 h-4 bg-red-400 rounded-full text-xs flex items-center justify-center text-white">3</span>
                </div>

                <!-- Messages -->
                <div class="relative hidden md:block">
                    <button class="p-2 rounded-full hover:bg-hk-green-700 transition-colors">
                        <i class="far fa-envelope text-hk-green-100"></i>
                    </button>
                    <span class="absolute top-0 right-0 w-4 h-4 bg-blue-400 rounded-full text-xs flex items-center justify-center text-white">5</span>
                </div>

                <!-- User info -->
                <div class="flex items-center space-x-3 pl-3 border-l border-hk-green-400">
                    <div class="hidden md:flex flex-col items-end">
                        <span class="font-semibold text-white">Welcome, <?= htmlspecialchars($userName) ?></span>
                        <span class="text-xs text-hk-green-200">
                            <?php
                            switch ($role) {
                                case 'admin':
                                    echo 'Administrator';
                                    break;
                                case 'teacher':
                                    echo 'Teacher' . ($departmentName ? ' - ' . htmlspecialchars($departmentName) : '');
                                    break;
                                case 'student':
                                    echo 'Student' . ($studentId ? ' - ' . htmlspecialchars($studentId) : '');
                                    break;
                                default:
                                    echo 'Guest';
                            }
                            ?>
                        </span>
                    </div>

                    <!-- User avatar -->
                    <div class="w-10 h-10 rounded-full bg-hk-green-700 flex items-center justify-center text-white font-semibold border-2 border-hk-green-300">
                        <?= strtoupper(substr($userName, 0, 1)) ?>
                    </div>

                    <!-- Logout button -->
                    <a href="./landing.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-semibold text-sm flex items-center transition-colors">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>



    <script>
        // Mobile menu toggle functionality
        document.getElementById('menu-toggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-64');
        });
    </script>
</body>
</html>