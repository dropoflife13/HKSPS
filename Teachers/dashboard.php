<?php
// Teachers/dashboard.php
require_once 'chart.php'; // Using teacher-specific chart data
require_once 'fetch_activities.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard - Hawak Kamay Scholarship Program</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
<body class="bg-gray-50 font-sans">
    <!-- Dashboard Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <span class="mr-3">
                        <svg class="w-8 h-8 text-hk-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17.5v-5l-7-4m20 4l-7 4v5m-5-10l5 3m-5-3l-5 3"></path>
                        </svg>
                    </span>
                    Teacher Dashboard
                </h1>
                <p class="text-gray-600 mt-2 ml-11">Welcome back, Professor! Here's your teaching overview.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <div class="flex items-center space-x-2 bg-gray-50 rounded-lg p-3">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-hk-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900"><?php echo date('l, F j, Y'); ?></p>
                        <p class="text-xs text-gray-500">Current semester: Spring 2023</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-10 mb-10">
    <div class="stat-card bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center">
            <div class="p-3 rounded-lg bg-hk-green-100 text-hk-green-700 mr-4">
                <i class="fas fa-user-graduate text-lg"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Students</p>
                <h3 class="text-2xl font-bold text-gray-900"><?php echo $totalStudents; ?></h3>
            </div>
        </div>
    </div>

    <div class="stat-card bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center">
            <div class="p-3 rounded-lg bg-blue-100 text-blue-700 mr-4">
                <i class="fas fa-book text-lg"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Courses Teaching</p>
                <h3 class="text-2xl font-bold text-gray-900"><?php echo $totalCourses; ?></h3>
            </div>
        </div>
    </div>

    <div class="stat-card bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center">
            <div class="p-3 rounded-lg bg-yellow-100 text-yellow-700 mr-4">
                <i class="fas fa-briefcase text-lg"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Job Postings</p>
                <h3 class="text-2xl font-bold text-gray-900"><?php echo $jobPostings; ?></h3>
            </div>
        </div>
    </div>

    <div class="stat-card bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center">
            <div class="p-3 rounded-lg bg-purple-100 text-purple-700 mr-4">
                <i class="fas fa-file-alt text-lg"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Applications Received</p>
                <h3 class="text-2xl font-bold text-gray-900"><?php echo $applications; ?></h3>
            </div>
        </div>
    </div>
</div>


<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-10">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Recent Activities</h3>
        <a href="#" class="text-sm text-hk-green-600 hover:text-hk-green-700 font-medium">View all</a>
    </div>
    <?php if (!empty($recentActivities)) : ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($recentActivities as $act) : ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $act['action_type']; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $act['description']; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo date('M d, Y', strtotime($act['created_at'])); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-gray-500 text-center py-8">No recent activities</p>
    <?php endif; ?>
</div>

   <div class="chart-container bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Applicants per Job Posting</h3>
    <div class="h-80">
        <canvas id="applicantsChart"></canvas>
    </div>
</div>
<script>
    // Applicants per Job Posting Chart
    const applicantsCtx = document.getElementById('applicantsChart').getContext('2d');
    const applicantsChart = new Chart(applicantsCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($applicantsPerJob['labels']); ?>,
            datasets: [{
                label: 'Number of Applicants',
                data: <?php echo json_encode($applicantsPerJob['data']); ?>,
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
                        precision: 0
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
</script>
</body>
</html>
