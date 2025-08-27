<?php
session_start();
include("../../config/con.php"); // DB connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id    = $_POST['id'];
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $role  = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, role=? WHERE id=?");
    $stmt->bind_param("sssi", $name, $email, $role, $id);

    if ($stmt->execute()) {
        echo "✅ User updated successfully.";
    } else {
        echo "❌ Error: " . $conn->error;
    }
}

// Fetch user if ?id= is passed
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM users WHERE id=$id");
    $user = $result->fetch_assoc();
}
?>

<form method="POST">
    <input type="hidden" name="id" value="<?= $user['id'] ?? '' ?>">
    <input type="text" name="name" placeholder="Name" value="<?= $user['name'] ?? '' ?>" required>
    <input type="email" name="email" placeholder="Email" value="<?= $user['email'] ?? '' ?>" required>
    <input type="text" name="role" placeholder="Role" value="<?= $user['role'] ?? '' ?>" required>
    <button type="submit">Update User</button>
</form>
