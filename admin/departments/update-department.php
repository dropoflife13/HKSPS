<?php
require_once __DIR__ . '/../../config/init.php';

$dept = null;

// If editing, fetch department data
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM departments WHERE id=$id");
    $dept = $result->fetch_assoc();
}

// If submitting update
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);

    $stmt = $conn->prepare("UPDATE departments SET name=? WHERE id=?");
    $stmt->bind_param("si", $name, $id);

    if ($stmt->execute()) {
        header("Location: ../Admin/manage-departments.php"); // redirect after update
        exit();
    } else {
        echo "❌ Error: " . $conn->error;
    }
}
?>

<form method="POST">
    <input type="hidden" name="id" value="<?= $dept['id'] ?? '' ?>">
    <input type="text" name="name" value="<?= $dept['name'] ?? '' ?>" required>
    <button type="submit">Update Department</button>
</form>
