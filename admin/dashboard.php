<?php
// dashboard.php
require_once 'admin/chart.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Hawak Kamay Scholarship Program</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        'hk-green': {
                            50: '#eff1ed',
                            100: '#f0fff1',
                            200: '#d8f3dc',
                            300: '#b7e4c7',
                            400: '#52b788',
                            500: '#40916c',
                            600: '#1b4332',
                            700: '#081c15',
                            800: '#071a14',
                            900: '#051611',
                        }
                    },
                }
            }
        }
    </script>
    <style>
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .hk-gradient-text {
            background: linear-gradient(135deg, #081c15 0%, #40916c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hk-gradient-bg {
            background: linear-gradient(135deg, #081c15 0%, #40916c 100%);
        }
        .stat-card {
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .chart-container {
            transition: all 0.3s ease;
        }
        .chart-container:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>

         <!-- Enhanced Dashboard Header -->
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div class="flex items-center">
            <div class="mr-4 p-3 bg-hk-green-50 rounded-xl">
                <svg class="w-8 h-8 text-hk-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">System Dashboard</h1>
                <p class="text-gray-600 mt-1">Welcome back, <span class="font-medium text-hk-green-600">Admin</span>! Here's what's happening today.</p>
            </div>
        </div>
        <div class="mt-4 md:mt-0">
            <div class="flex items-center space-x-3 bg-white rounded-lg p-4 shadow-sm border border-gray-100">
                <div class="flex-shrink-0 p-2 bg-hk-green-50 rounded-lg">
                    <svg class="w-6 h-6 text-hk-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900"><?php echo date('l, F j, Y'); ?></p>
                    <div class="flex items-center text-xs text-gray-500">
                        <span class="flex h-2 w-2 mr-1 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        Last updated: Just now
                    </div>
                </div>
            </div>
        </div>
    </div>
           <!-- Dashboard Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-10 mb-10">

    <!-- Total Applications -->
   <div class="stat-card bg-white p-6 rounded-2xl shadow-md border border-gray-100 flex items-center gap-5 hover:shadow-lg transition">
        <div class="p-4 rounded-full bg-blue-100">
            <i class="fas fa-file-alt text-2xl text-hk-green-700"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Applications</p>
            <p class="text-2xl font-bold text-gray-900">
                <?php echo array_sum($applicationsByStatus['data']); ?>
            </p>
        </div>
    </div>

    <!-- Pending Applications -->
   <div class="stat-card bg-white p-6 rounded-2xl shadow-md border border-gray-100 flex items-center gap-5 hover:shadow-lg transition">
        <div class="p-4 rounded-full bg-yellow-100">
            <i class="fas fa-clock text-2xl text-yellow-600"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Pending Applications</p>
            <p class="text-2xl font-bold text-gray-900">
                <?php 
                    $pendingIndex = array_search('Pending', $applicationsByStatus['labels']);
                    echo $pendingIndex !== false ? $applicationsByStatus['data'][$pendingIndex] : 0;
                ?>
            </p>
        </div>
    </div>

    <!-- Approved Applications -->
   <div class="stat-card bg-white p-6 rounded-2xl shadow-md border border-gray-100 flex items-center gap-5 hover:shadow-lg transition">
        <div class="p-4 rounded-full bg-green-100">
            <i class="fas fa-check-circle text-2xl text-green-600"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Approved Applications</p>
            <p class="text-2xl font-bold text-gray-900">
                <?php 
                    $approvedIndex = array_search('Approved', $applicationsByStatus['labels']);
                    echo $approvedIndex !== false ? $applicationsByStatus['data'][$approvedIndex] : 0;
                ?>
            </p>
        </div>
    </div>

    <!-- Total Users -->
   <div class="stat-card bg-white p-6 rounded-2xl shadow-md border border-gray-100 flex items-center gap-5 hover:shadow-lg transition">
        <div class="p-4 rounded-full bg-blue-100">
            <i class="fas fa-users text-2xl text-blue-600"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Users</p>
            <p class="text-2xl font-bold text-gray-900">
                <?php echo array_sum($usersByRole['data']); ?>
            </p>
        </div>
    </div>

</div>

            
            <!-- Charts Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
                <div class="chart-container bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Applications by Status</h3>
                    <div class="h-80">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
                
                <div class="chart-container bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Job Applications Count</h3>
                    <div class="h-80">
                        <canvas id="jobChart"></canvas>
                    </div>
                </div>
                
                <div class="chart-container bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Users by Role</h3>
                    <div class="h-80">
                        <canvas id="roleChart"></canvas>
                    </div>
                </div>
                
                <div class="chart-container bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Applications Trend (Last 6 Months)</h3>
                    <div class="h-80">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>
    <!-- Recent Activity Section -->
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-10">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
        <a href="index.php?page=activities" class="text-sm text-hk-green-600 hover:text-hk-green-700 font-medium">View all activity</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                </tr>
            </thead>
            <tbody id="activities-body" class="bg-white divide-y divide-gray-200">
                <!-- Filled dynamically -->
            </tbody>
        </table>
        <div id="no-activity-msg" class="text-center py-8 text-gray-500 hidden">
            <div class="text-gray-400 mb-2"><i class="fas fa-history text-4xl"></i></div>
            <p>No recent activity found</p>
            <p class="text-sm text-gray-400 mt-2">Activities will appear here as users interact with the system</p>
        </div>
    </div>
</div>
    
    <?php if (!empty($recentActivities)) : ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($recentActivities as $activity) : 
                        $initial = strtoupper(substr($activity['user_name'], 0, 1));
                        $roleClass = '';
                        if ($activity['user_role'] === 'student') {
                            $roleClass = 'bg-hk-green-100 text-hk-green-700';
                        } elseif ($activity['user_role'] === 'teacher') {
                            $roleClass = 'bg-blue-100 text-blue-700';
                        } elseif ($activity['user_role'] === 'admin') {
                            $roleClass = 'bg-purple-100 text-purple-700';
                        } else {
                            $roleClass = 'bg-gray-100 text-gray-700';
                        }
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
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900"><?php echo formatActivityDescription($activity); ?></div>
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
        <div class="text-center py-8">
            <div class="text-gray-400 mb-2">
                <i class="fas fa-history text-4xl"></i>
            </div>
            <p class="text-gray-500">No recent activity found</p>
            <p class="text-sm text-gray-400 mt-2">Activities will appear here as users interact with the system</p>
        </div>
    <?php endif; ?>
</div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        // Applications by Status Chart (Doughnut)
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        const statusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($applicationsByStatus['labels']); ?>,
                datasets: [{
                    data: <?php echo json_encode($applicationsByStatus['data']); ?>,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
        
        // Job Applications Chart (Bar)
        const jobCtx = document.getElementById('jobChart').getContext('2d');
        const jobChart = new Chart(jobCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($jobApplicationsCount['labels']); ?>,
                datasets: [{
                    label: 'Number of Applications',
                    data: <?php echo json_encode($jobApplicationsCount['data']); ?>,
                    backgroundColor: 'rgba(64, 145, 108, 0.7)',
                    borderColor: 'rgba(64, 145, 108, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
        
        // Users by Role Chart (Pie)
        const roleCtx = document.getElementById('roleChart').getContext('2d');
        const roleChart = new Chart(roleCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($usersByRole['labels']); ?>,
                datasets: [{
                    data: <?php echo json_encode($usersByRole['data']); ?>,
                    backgroundColor: [
                        'rgba(64, 145, 108, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
        
        // Monthly Applications Chart (Line)
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        const monthlyChart = new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($applicationsByMonth['labels']); ?>,
                datasets: [{
                    label: 'Applications',
                    data: <?php echo json_encode($applicationsByMonth['data']); ?>,
                    fill: false,
                    backgroundColor: 'rgba(64, 145, 108, 0.7)',
                    borderColor: 'rgba(64, 145, 108, 1)',
                    tension: 0.1,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 10) {
                navbar.classList.add('shadow-lg');
            } else {
                navbar.classList.remove('shadow-lg');
            }
        });
async function fetchActivities() {
    try {
        const response = await fetch('fetch_recent_activities.php');
        const data = await response.json();
        const tbody = document.getElementById('activities-body');
        const noMsg = document.getElementById('no-activity-msg');
        tbody.innerHTML = '';

        if(data.length === 0){
            noMsg.classList.remove('hidden');
            return;
        } else {
            noMsg.classList.add('hidden');
        }

        data.forEach(activity => {
            const roleClass = activity.user_role === 'student' ? 'bg-hk-green-100 text-hk-green-700'
                            : activity.user_role === 'teacher' ? 'bg-blue-100 text-blue-700'
                            : 'bg-gray-100 text-gray-700';
            const initial = activity.user_name.charAt(0).toUpperCase();

            const row = `
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full ${roleClass} flex items-center justify-center font-medium">
                                    ${initial}
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">${activity.user_name}</div>
                                <div class="text-sm text-gray-500">${activity.user_role}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${activity.formatted_description}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${activity.formatted_time}</td>
                </tr>
            `;
            tbody.insertAdjacentHTML('beforeend', row);
        });
    } catch (err) {
        console.error('Error fetching activities:', err);
    }
}

// Initial fetch
fetchActivities();

// Refresh every 10 seconds
setInterval(fetchActivities, 10000);
</script>
</body>
</html>