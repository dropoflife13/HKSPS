<?php
session_start();

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

header("Location: landing.php");
exit;
?>
