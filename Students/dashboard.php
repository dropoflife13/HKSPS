<h1 class="text-3xl font-bold text-gray-800 mb-6">Welcome to your Dashboard</h1>

<!-- Example content -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="bg-white shadow rounded p-4">
        <h2 class="font-semibold text-lg mb-2">Quick Links</h2>
        <ul class="text-gray-600 space-y-1">
            <li><a href="apply.php" class="hover:underline text-blue-500">Apply for Duty</a></li>
            <li><a href="my-application.php" class="hover:underline text-blue-500">View Applications</a></li>
        </ul>
    </div>
    <div class="bg-white shadow rounded p-4">
        <h2 class="font-semibold text-lg mb-2">Recent Activities</h2>
        <p class="text-gray-600">No recent activities yet.</p>
    </div>
    <div class="bg-white shadow rounded p-4">
        <h2 class="font-semibold text-lg mb-2">Profile Info</h2>
        <p class="text-gray-600">Name: <?= $userName ?></p>
        <p class="text-gray-600">Role: <?= ucfirst($userRole) ?></p>
    </div>
</div>