<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/conn.php';
require_once __DIR__ . '/modal.php';

if (!isset($_SESSION['user_name']) || !isset($_SESSION['role'])) {
    header("Location: Auth/login.php");
    exit();
}