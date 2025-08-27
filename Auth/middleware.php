<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Auth/login.php"); // redirect to login
    exit;
}

// Role-based middleware function
function requireRole($role) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
        // Redirect if role does not match
        header("Location: ../Auth/unauthorized.php");
        exit;
    }
}
?>
