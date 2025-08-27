<?php
session_start();
include("../../config/con.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];

    $stmt = $conn->prepare("UPDATE departments SET name=? WHERE id=?");
    $stmt->bind_param("si", $name, $id);

    if ($stmt->execute()) {
        echo "✅ Department updated successfully.";
    } else {
        echo "❌ Error: " . $conn->error;
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM departments WHERE id=$id");
    $dept = $result->fetch_assoc();
}
?>

<form method="POST">
    <input type="hidden" name="id" value="<?= $dept['id'] ?? '' ?>">
    <input type="text" name="name" value="<?= $dept['name'] ?? '' ?>" required>
    <button type="submit">Update Department</button>
</form>
