<?php
session_start();
include("../../config/con.php");

// Make sure 'id' is provided
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // sanitize input

    if ($conn->query("DELETE FROM departments WHERE id=$id")) {
        // Redirect back to manage departments
        header("Location: ../Admin/manage-departments.php");
        exit();
    } else {
        echo "❌ Error: " . $conn->error;
    }
} else {
    // If no id is provided, redirect back
    header("Location: ../Admin/manage-departments.php");
    exit();
}
?>
