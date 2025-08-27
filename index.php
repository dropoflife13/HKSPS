<?php
session_start();

// If user is logged in, redirect by role
if (isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 'admin':
            header("Location: Admin/index.php");
            exit;
        case 'teacher':
            header("Location: Teachers/index.php");
            exit;
        case 'student':
            header("Location: Students/index.php");
            exit;
    }
}

// Not logged in → show landing page
header("Location: landing.php");
exit;
?>
