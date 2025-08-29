<?php

$msg = "";

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

<h1 class="text-2xl font-bold text-indigo-700 mb-6">Submit a Report</h1>

<?php if (!empty($msg)): ?>
    <div class="mb-4 px-4 py-3 rounded-lg shadow-sm 
                <?= strpos($msg, '✅') !== false ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' ?>">
        <?= $msg ?>
    </div>
<?php endif; ?>

<form method="POST" class="bg-white shadow-md rounded-xl p-6 space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
        <input type="text" name="title" 
               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
               placeholder="Enter report title" required>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
        <textarea name="description" rows="5"
                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                  placeholder="Describe your issue" required></textarea>
    </div>

    <button type="submit" 
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg shadow-md transition">
        Submit Report
    </button>
</form>
