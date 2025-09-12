<?php
require_once 'admin/chart.php';

// Fetch all activities (students + teachers), large limit
$roles = ['student', 'teacher'];
$allActivities = $chartData->getRecentActivities(1000, $roles);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Activities - Hawak Kamay</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-6 font-sans">
<div class="max-w-7xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">All Activities</h1>

    <?php if (!empty($allActivities)) : ?>
        <div class="overflow-x-auto bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                    </tr>
                </thead>
                <tbody id="activities-body" class="bg-white divide-y divide-gray-200">
                    <?php foreach ($allActivities as $activity) : 
                        $initial = strtoupper(substr($activity['user_name'], 0, 1));
                        $roleClass = match ($activity['user_role']) {
                            'student' => 'bg-hk-green-100 text-hk-green-700',
                            'teacher' => 'bg-blue-100 text-blue-700',
                            'admin' => 'bg-purple-100 text-purple-700',
                            default => 'bg-gray-100 text-gray-700',
                        };
                    ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full <?php echo $roleClass; ?> flex items-center justify-center font-medium">
                                        <?php echo $initial; ?>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($activity['user_name']); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo ucfirst($activity['user_role']); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?php echo formatActivityDescription($activity); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo formatActivityTime($activity['created_at']); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <div class="text-center py-8 text-gray-500">
            No activity history found.
        </div>
    <?php endif; ?>
</div>
</body>
</html>
