<?php
session_start();
include("../config/conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $role = $_SESSION['role'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    if ($title && $description) {
        $stmt = $conn->prepare("INSERT INTO reports (submitted_by, role, title, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $role, $title, $description);
        $stmt->execute();
        $msg = "✅ Report submitted successfully!";
    } else {
        $msg = "❌ Title and description are required.";
    }
}
?>

<h2>Submit a Report</h2>
<?php if (!empty($msg)) echo "<p>$msg</p>"; ?>
<form method="POST">
    <input type="text" name="title" placeholder="Title" required><br>
    <textarea name="description" placeholder="Describe your issue" required></textarea><br>
    <button type="submit">Submit</button>
</form>
