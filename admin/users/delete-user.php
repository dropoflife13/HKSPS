<?php
session_start();
include("../../config/con.php"); // DB connection

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($conn->query("DELETE FROM users WHERE id=$id")) {
        echo "✅ User deleted successfully.";
    } else {
        echo "❌ Error: " . $conn->error;
    }
}
?>
