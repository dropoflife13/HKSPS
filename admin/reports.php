<?php
// Ensure only admin can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../Auth/login.php");
    exit();
}

$admin_id = $_SESSION['user_id'];

// Fetch all reports with submitter and resolver names
$reports = $conn->query("
    SELECT r.*, 
           u.name AS submitted_name, 
           res.name AS resolved_name
    FROM reports r
    JOIN users u ON r.submitted_by = u.id
    LEFT JOIN users res ON r.resolved_by = res.id
    ORDER BY r.created_at DESC
");

// Get counts for each status
$status_counts = [
    'all' => 0,
    'pending' => 0,
    'reviewed' => 0,
    'resolved' => 0
];

if ($reports->num_rows > 0) {
    // Reset pointer to beginning
    $reports->data_seek(0);
    
    while ($r = $reports->fetch_assoc()) {
        $status_counts['all']++;
        $status_counts[$r['status']]++;
    }
    
    // Reset pointer again for main display
    $reports->data_seek(0);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4e73df',
                        success: '#1cc88a',
                        info: '#36b9cc',
                        warning: '#f6c23e',
                        danger: '#e74a3b',
                        light: '#f8f9fc',
                        dark: '#5a5c69',
                    }
                }
            }
        }
    </script>
    <style>
       
        
        .stat-card {
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }

   
        .alert-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.3s ease;
        }
        
        .alert-notification.show {
            opacity: 1;
            transform: translateX(0);
        }
        
        .report-description {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .report-description.expanded {
            white-space: normal;
            overflow: visible;
        }
        
        .table-hover tbody tr:hover {
            background-color: #f8f9fc;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <div class="container mx-auto px-4 py-6">
        <!-- Page Header -->
        <div class="border-b border-gray-200 pb-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Reports Management</h1>
                    <p class="text-gray-600 mt-2">View and manage reports submitted by students and teachers.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <button class="bg-primary hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-sm flex items-center">
                        <i class="fas fa-download mr-2"></i> Export Reports
                    </button>
                </div>
            </div>
        </div>

  <!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <!-- Total Reports -->
    <div class="stat-card bg-white p-6 rounded-2xl shadow-md border border-gray-100 flex items-center gap-5 hover:shadow-lg transition">
        <div class="p-4 rounded-full bg-blue-100">
            <i class="fas fa-flag text-2xl text-blue-600"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Reports</p>
        <p class="text-2xl font-bold text-gray-900" id="count-all"><?php echo $status_counts['all']; ?></p>
        </div>
    </div>

    <!-- Pending Reports -->
    <div class="stat-card bg-white p-6 rounded-2xl shadow-md border border-gray-100 flex items-center gap-5 hover:shadow-lg transition">
        <div class="p-4 rounded-full bg-yellow-100">
            <i class="fas fa-clock text-2xl text-yellow-600"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Pending</p>
            <p class="text-2xl font-bold text-gray-900" id="count-pending"><?php echo $status_counts['pending']; ?></p>
        </div>
    </div>

    <!-- Reviewed Reports -->
    <div class="stat-card bg-white p-6 rounded-2xl shadow-md border border-gray-100 flex items-center gap-5 hover:shadow-lg transition">
        <div class="p-4 rounded-full bg-purple-100">
            <i class="fas fa-eye text-2xl text-purple-600"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Reviewed</p>
           <p class="text-2xl font-bold text-gray-900" id="count-reviewed"><?php echo $status_counts['reviewed']; ?></p>
        </div>
    </div>

    <!-- Resolved Reports -->
    <div class="stat-card bg-white p-6 rounded-2xl shadow-md border border-gray-100 flex items-center gap-5 hover:shadow-lg transition">
        <div class="p-4 rounded-full bg-green-100">
            <i class="fas fa-check-circle text-2xl text-green-600"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Resolved</p>
            <p class="text-2xl font-bold text-gray-900" id="count-resolved"><?php echo $status_counts['resolved']; ?></p>
        </div>
    </div>

</div>


      <!-- Filters and Search -->
<div class="bg-white rounded-lg shadow-sm  overflow-hidden">
    <div class="bg-gray-100 px-6 py-4 border-b border-gray-200">
        <h6 class="m-0 font-bold text-gray-700">Report Filters</h6>
    </div>
    <div class="p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex flex-wrap gap-2">
                <button class="filter-btn bg-primary text-white px-3 py-1.5 rounded-md text-sm font-medium" data-filter="all">
                    All
                </button>
                <button class="filter-btn bg-white border border-warning text-warning hover:bg-warning hover:text-white px-3 py-1.5 rounded-md text-sm font-medium" data-filter="pending">
                    Pending
                </button>
                <button class="filter-btn bg-white border border-info text-info hover:bg-info hover:text-white px-3 py-1.5 rounded-md text-sm font-medium" data-filter="reviewed">
                    Reviewed
                </button>
                <button class="filter-btn bg-white border border-success text-success hover:bg-success hover:text-white px-3 py-1.5 rounded-md text-sm font-medium" data-filter="resolved">
                    Resolved
                </button>
            </div>
            <div class="flex">
                <input type="text" class="flex-1 border border-gray-300 rounded-l-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Search reports..." id="searchInput">
                <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-r-md" id="searchButton">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</div>


        <!-- Reports Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="bg-gray-100 px-6 py-4 border-b border-gray-200">
                <h6 class="m-0 font-bold text-gray-700">All Reports</h6>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="reportsTable">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted By</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resolved By</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if ($reports->num_rows > 0): ?>
                            <?php while ($r = $reports->fetch_assoc()): ?>
                                <tr data-report-id="<?= $r['id'] ?>" data-status="<?= $r['status'] ?>" class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium">#<?= $r['id'] ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($r['submitted_name']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            <?= ucfirst($r['role']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($r['title']) ?></td>
                                    <td class="px-6 py-4">
                                        <div class="report-description" id="desc-<?= $r['id'] ?>">
                                            <?= htmlspecialchars($r['description']) ?>
                                        </div>
                                        <?php if (strlen($r['description']) > 50): ?>
                                            <span class="view-more-btn text-primary text-xs font-medium cursor-pointer" data-desc-id="desc-<?= $r['id'] ?>">View more</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php
                                        $status_class = '';
                                        if ($r['status'] == 'pending') {
                                            $status_class = 'bg-yellow-100 text-yellow-800';
                                        } elseif ($r['status'] == 'reviewed') {
                                            $status_class = 'bg-blue-100 text-blue-800';
                                        } elseif ($r['status'] == 'resolved') {
                                            $status_class = 'bg-green-100 text-green-800';
                                        }
                                        ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full <?= $status_class ?>">
                                            <?= ucfirst($r['status']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?= date('M j, Y', strtotime($r['created_at'])) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <select class="status-select border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                                <option value="pending" <?= $r['status']=='pending'?'selected':'' ?>>Pending</option>
                                                <option value="reviewed" <?= $r['status']=='reviewed'?'selected':'' ?>>Reviewed</option>
                                                <option value="resolved" <?= $r['status']=='resolved'?'selected':'' ?>>Resolved</option>
                                            </select>
                                            <button class="update-status bg-green-500 hover:bg-green-600 text-white p-1.5 rounded-md">
                                                <i class="fas fa-check text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap resolved_by"><?= $r['resolved_name'] ? htmlspecialchars($r['resolved_name']) : '-' ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="px-6 py-8 text-center">
                                    <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                    <p class="text-gray-500">No reports found.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Alert Notification -->
    <div class="alert-notification bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg" id="alertNotification" role="alert">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-3"></i>
            <span id="alert-message"></span>
        </div>
    </div>

    <script>
        // Show alert notification
        function showAlert(message, type = 'success') {
            const alertBox = document.getElementById('alertNotification');
            const alertMessage = document.getElementById('alert-message');
            
            alertMessage.textContent = message;
            
            // Change alert style based on type
            if(type === 'success') {
                alertBox.className = 'alert-notification bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center';
            } else {
                alertBox.className = 'alert-notification bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center';
            }
            
            // Show alert
            alertBox.classList.add('show');
            
            // Hide after 3 seconds
            setTimeout(() => {
                alertBox.classList.remove('show');
            }, 3000);
        }

        // Handle status update
        document.querySelectorAll('.update-status').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const reportId = row.getAttribute('data-report-id');
                const status = row.querySelector('.status-select').value;

                const formData = new FormData();
                formData.append('update_status', true);
                formData.append('report_id', reportId);
                formData.append('status', status);

                fetch('admin/update_report_ajax.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                  if (data.success) {
    const oldStatus = row.getAttribute('data-status');
    const newStatus = status;

    // Update status badge (already in your code)
    const statusBadge = row.querySelector('td:nth-child(6) span');
    statusBadge.classList.remove('bg-yellow-100', 'text-yellow-800', 'bg-blue-100', 'text-blue-800', 'bg-green-100', 'text-green-800');
    if(newStatus === 'pending') {
        statusBadge.classList.add('bg-yellow-100', 'text-yellow-800');
    } else if(newStatus === 'reviewed') {
        statusBadge.classList.add('bg-blue-100', 'text-blue-800');
    } else if(newStatus === 'resolved') {
        statusBadge.classList.add('bg-green-100', 'text-green-800');
    }
    statusBadge.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);

    // Update resolved by
    row.querySelector('.resolved_by').textContent = data.resolved_name || '-';

    // ✅ Update counts dynamically
    if (oldStatus !== newStatus) {
        // Decrease old status
        if (oldStatus && document.getElementById(`count-${oldStatus}`)) {
            document.getElementById(`count-${oldStatus}`).textContent =
                parseInt(document.getElementById(`count-${oldStatus}`).textContent) - 1;
        }

        // Increase new status
        if (document.getElementById(`count-${newStatus}`)) {
            document.getElementById(`count-${newStatus}`).textContent =
                parseInt(document.getElementById(`count-${newStatus}`).textContent) + 1;
        }
    }

    // Update data attribute for filtering
    row.setAttribute('data-status', newStatus);

    showAlert('Report status updated successfully!');


                    } else {
                        showAlert(data.error || 'Update failed. Please try again.', 'danger');
                    }
                })
                .catch(err => showAlert('An error occurred. Please try again.', 'danger'));
            });
        });

        // Filter functionality
        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.classList.remove('bg-primary', 'text-white');
                    if(!btn.classList.contains('bg-primary')) {
                        btn.classList.add('bg-white');
                        
                        // Reset border colors for non-active buttons
                        if(btn.getAttribute('data-filter') === 'pending') {
                            btn.classList.add('border-warning', 'text-warning');
                        } else if(btn.getAttribute('data-filter') === 'reviewed') {
                            btn.classList.add('border-info', 'text-info');
                        } else if(btn.getAttribute('data-filter') === 'resolved') {
                            btn.classList.add('border-success', 'text-success');
                        }
                    }
                });
                
                // Add active class to clicked button
                this.classList.remove('bg-white');
                this.classList.add('bg-primary', 'text-white');
                
                // Remove border colors for active button
                this.classList.remove('border-warning', 'border-info', 'border-success', 'text-warning', 'text-info', 'text-success');
                
                const filter = this.getAttribute('data-filter');
                const rows = document.querySelectorAll('#reportsTable tbody tr');
                
                rows.forEach(row => {
                    if (filter === 'all') {
                        row.style.display = '';
                    } else {
                        if (row.getAttribute('data-status') === filter) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    }
                });
            });
        });

        // Search functionality
        document.getElementById('searchButton').addEventListener('click', function() {
            const searchText = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#reportsTable tbody tr');
            
            rows.forEach(row => {
                let found = false;
                const cells = row.querySelectorAll('td');
                
                cells.forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(searchText)) {
                        found = true;
                    }
                });
                
                row.style.display = found ? '' : 'none';
            });
        });

        // View more functionality for descriptions
        document.querySelectorAll('.view-more-btn').forEach(button => {
            button.addEventListener('click', function() {
                const descId = this.getAttribute('data-desc-id');
                const descElement = document.getElementById(descId);
                
                if (descElement.classList.contains('expanded')) {
                    descElement.classList.remove('expanded');
                    this.textContent = 'View more';
                } else {
                    descElement.classList.add('expanded');
                    this.textContent = 'View less';
                }
            });
        });

        // Allow Enter key to trigger search
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('searchButton').click();
            }
        });
    </script>
</body>
</html>