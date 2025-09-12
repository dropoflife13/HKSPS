<?php


    $teacherId = $_SESSION['user_id'] ?? 0;

    $sql = "SELECT a.id, u.name AS student_name, jp.title AS job_title, a.status, a.applied_date
            FROM applications a
            JOIN users u ON a.student_id = u.id
            JOIN job_postings jp ON a.job_id = jp.id
            WHERE jp.posted_by_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $teacherId);
    $stmt->execute();
    $result = $stmt->get_result();
    

     if (isset($_GET['success'])): ?>
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg mb-4">
            <?= htmlspecialchars($_GET['success']) ?>
        </div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="bg-red-100 text-red-800 px-4 py-3 rounded-lg mb-4">
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <!-- Table Header -->
            <div class="bg-gradient-to-r from-hk-green-50 to-hk-green-100 px-6 py-4 border-b border-hk-green-200">
                <h3 class="text-2xl font-bold text-gray-800">Applicants</h3>
                <p class="text-gray-600 mt-1">Manage student applications for your posted duties</p>
            </div>
            
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 text-left text-gray-600 font-medium text-sm">
                            <th class="px-6 py-4">Student</th>
                            <th class="px-6 py-4">Job Title</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Applied At</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr class="bg-white hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-5">
                                <div class="flex items-center">
                                    <div class="bg-hk-green-100 p-2 rounded-lg mr-4">
                                        <i class="fas fa-user-graduate text-hk-green-600"></i>
                                    </div>
                                    <div class="font-medium text-gray-800"><?= htmlspecialchars($row['student_name']) ?></div>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-gray-700"><?= htmlspecialchars($row['job_title']) ?></td>
                            <td class="px-6 py-5">
                                <?php 
                                $statusColor = 'bg-gray-100 text-gray-800';
                                if ($row['status'] === 'approved') $statusColor = 'bg-green-100 text-green-800';
                                if ($row['status'] === 'rejected') $statusColor = 'bg-red-100 text-red-800';
                                if ($row['status'] === 'pending') $statusColor = 'bg-yellow-100 text-yellow-800';
                                ?>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $statusColor ?>">
                                    <?= ucfirst($row['status']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-5 text-gray-600"><?= $row['applied_date'] ?></td>
                           <td class="px-6 py-5">
    <div class="flex justify-center space-x-2">
        <?php if($row['status'] === 'pending'): ?>
            <button 
                data-id="<?= $row['id'] ?>" 
                data-action="approved" 
                class="action-btn bg-hk-green-500 hover:bg-hk-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center">
                <i class="fas fa-check mr-2"></i> Accept
            </button>

            <button 
                data-id="<?= $row['id'] ?>" 
                data-action="rejected" 
                class="action-btn bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center">
                <i class="fas fa-times mr-2"></i> Deny
            </button>
        <?php else: ?>
            <span class="text-gray-400 text-sm">No actions available</span>
        <?php endif; ?>
    </div>
</td>

                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
                
                <!-- Empty State -->
                <?php if($result->num_rows === 0): ?>
                <div class="text-center py-12">
                    <div class="mx-auto w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center mb-6">
                        <i class="fas fa-user-friends text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No applicants yet</h3>
                    <p class="text-gray-500">Students haven't applied to your duties yet.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
document.querySelectorAll(".action-btn").forEach(btn => {
    btn.addEventListener("click", async () => {
        const appId = btn.getAttribute("data-id");
        const action = btn.getAttribute("data-action");

        const formData = new FormData();
        formData.append("id", appId);
        formData.append("action", action);

      const response = await fetch("/HKSPS/Teachers/action.php", {
    method: "POST",
    body: formData,
    credentials: 'same-origin'  // keep cookies/session
});


        const result = await response.json();

        if (result.success) {
            // Update row in table
            const row = btn.closest("tr");

            // Update status badge
            const statusCell = row.querySelector("td:nth-child(3) span");
            statusCell.textContent = action.charAt(0).toUpperCase() + action.slice(1);
            statusCell.className = "px-3 py-1 rounded-full text-xs font-semibold " +
                (action === "approved" ? "bg-green-100 text-green-800" :
                action === "rejected" ? "bg-red-100 text-red-800" : "bg-gray-100 text-gray-800");

            // Replace buttons with "No actions available"
            const actionsCell = row.querySelector("td:nth-child(5) div");
            actionsCell.innerHTML = '<span class="text-gray-400 text-sm">No actions available</span>';

            // Show notification
            showNotification(`Application ${action}`);
        } else {
            showNotification(result.error || "Something went wrong", true);
        }
    });
});

function showNotification(message, isError = false) {
    const notif = document.createElement("div");
    notif.className = `fixed top-5 right-5 px-4 py-3 rounded-lg shadow-lg z-50 text-white ${isError ? "bg-red-500" : "bg-green-500"}`;
    notif.textContent = message;
    document.body.appendChild(notif);

    setTimeout(() => notif.remove(), 3000);
}
</script>
