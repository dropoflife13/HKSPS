<?php

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $role = $_SESSION['role'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    if (!empty($title) && !empty($description)) {
        $stmt = $conn->prepare("INSERT INTO reports (submitted_by, role, title, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $role, $title, $description);

        if ($stmt->execute()) {
            $msg = "<div style='color:green;'>✅ Report submitted successfully!</div>";
        } else {
            $msg = "<div style='color:red;'>❌ Something went wrong. Please try again.</div>";
        }
    } else {
        $msg = "<div style='color:red;'>❌ Title and description are required.</div>";
    }
}
?>

<h2>📢 Submit a Report</h2>

<?php if (!empty($msg)) echo $msg; ?>

<form method="POST" style="max-width:400px;">
    <input type="text" name="title" placeholder="Title" required style="width:100%; margin:5px 0; padding:8px;"><br>
    <textarea name="description" placeholder="Describe your issue" required style="width:100%; height:100px; margin:5px 0; padding:8px;"></textarea><br>
    <button type="submit" style="padding:8px 15px; cursor:pointer;">Submit</button>
</form>
