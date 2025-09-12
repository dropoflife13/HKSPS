

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HAWAK KAMAY - Sidebar</title>
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
                    }
                }
            }
        }
    </script>
    <style>
        .hk-gradient-bg {
            background: linear-gradient(135deg, #081c15 0%, #40916c 100%);
        }
        .sidebar-item {
            transition: all 0.2s ease;
            position: relative;
        }
        .sidebar-item:hover {
            transform: translateX(5px);
            background: linear-gradient(135deg, #d8f3dc 0%, #b7e4c7 100%);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .active-nav-item {
            background: linear-gradient(135deg, #d8f3dc 0%, #b7e4c7 100%);
            border-left: 4px solid #40916c;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .notification-badge {
            position: absolute;
            top: 8px;
            right: 15px;
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 600;
        }
        .sidebar-footer {
            border-top: 1px solid #e5e7eb;
            padding-top: 1rem;
        }
        .mobile-sidebar-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 50;
            display: block;
            background: linear-gradient(135deg, #081c15 0%, #40916c 100%);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        @media (min-width: 768px) {
            .mobile-sidebar-toggle {
                display: none;
            }
        }
        .user-status {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #52b788;
            position: absolute;
            bottom: 0;
            right: 0;
            border: 2px solid white;
        }
        .sidebar-collapse {
            width: 80px !important;
        }
        .sidebar-expanded {
            width: 256px !important;
        }
        .sidebar-collapse .logo-text,
        .sidebar-collapse .role-panel,
        .sidebar-collapse .nav-text,
        .sidebar-collapse .quick-actions-title {
            display: none !important;
        }
        .sidebar-collapse .logo {
            margin-right: 0;
        }
        .sidebar-collapse .notification-badge {
            right: 5px;
        }
        .sidebar-collapse .quick-actions {
            flex-direction: column;
            gap: 0.5rem;
        }
        .sidebar-collapse .quick-actions a {
            width: 100%;
        }
        .admin-badge {
            background: linear-gradient(135deg, #1b4332 0%, #40916c 100%);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
        }
    </style>

 

</head>
<body class="font-sans bg-hk-green-50 min-h-screen flex">
    <!-- Mobile Toggle Button -->
    <button id="mobileToggle" class="mobile-sidebar-toggle md:hidden w-12 h-12 rounded-full text-white flex items-center justify-center">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <aside id="sidebar" class="bg-white w-64 p-6 border-r border-gray-200 flex flex-col justify-between fixed h-screen transform -translate-x-64 md:translate-x-0 transition-all duration-300 z-40 shadow-lg sidebar-expanded">
        <div>
            <!-- Logo and Collapse Toggle -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center">
                    <div class="logo w-12 h-12 hk-gradient-bg rounded-xl flex items-center justify-center mr-3">
                        <span class="text-white font-bold text-lg">HK</span>
                    </div>
                    <span class="logo-text text-2xl font-bold text-hk-green-800">HAWAK KAMAY</span>
                </div>
                <button id="collapseToggle" class="hidden md:block text-hk-green-600 hover:text-hk-green-800">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
                



                
                <!-- Navigation -->
                <nav class="flex flex-col space-y-2">
                    <?php if ($userRole === 'student'): ?>
                        <a href="index.php?page=dashboard" class="sidebar-item px-4 py-3 rounded-xl hover:bg-hk-green-50 text-hk-green-800 font-medium flex items-center relative">
                            <i class="fas fa-home mr-3 text-hk-green-600"></i>
                            <span class="nav-text">Home</span>
                            
                        </a>
                        <a href="index.php?page=browse-duty" class="sidebar-item px-4 py-3 rounded-xl hover:bg-hk-green-50 text-hk-green-800 font-medium flex items-center">
                        <i class="fas fa-search mr-3 text-hk-green-600"></i>
                        <span class="nav-text">Browse</span>
                    </a>
                  
                    <a href="index.php?page=my-application" class="sidebar-item px-4 py-3 rounded-xl hover:bg-hk-green-50 text-hk-green-800 font-medium flex items-center relative">
                        <i class="fas fa-file-alt mr-3 text-hk-green-600"></i>
                        <span class="nav-text">Applications</span>
                  
                    </a>
                    <a href="index.php?page=report" class="sidebar-item px-4 py-3 rounded-xl hover:bg-hk-green-50 text-hk-green-800 font-medium flex items-center">
                        <i class="fas fa-clipboard-list mr-3 text-hk-green-600"></i>
                        <span class="nav-text">Report</span>
                    </a>
                    <a href="index.php?page=profile" class="sidebar-item px-4 py-3 rounded-xl hover:bg-hk-green-50 text-hk-green-800 font-medium flex items-center">
                        <i class="fas fa-user mr-3 text-hk-green-600"></i>
                        <span class="nav-text">Profile</span>
                    </a>

                <?php elseif ($userRole === 'teacher'): ?>
                    <a href="index.php?page=dashboard" class="sidebar-item px-4 py-3 rounded-xl hover:bg-hk-green-50 text-hk-green-800 font-medium flex items-center">
                        <i class="fas fa-tachometer-alt mr-3 text-hk-green-600"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                    <a href="index.php?page=my-post" class="sidebar-item px-4 py-3 rounded-xl hover:bg-hk-green-50 text-hk-green-800 font-medium flex items-center relative">
                        <i class="fas fa-tasks mr-3 text-hk-green-600"></i>
                        <span class="nav-text">My Post</span>
                        
                    </a>
                    <a href="index.php?page=report" class="sidebar-item px-4 py-3 rounded-xl hover:bg-hk-green-50 text-hk-green-800 font-medium flex items-center">
                        <i class="fas fa-clipboard-list mr-3 text-hk-green-600"></i>
                        <span class="nav-text">Submit Report</span>
                    </a>
                    <a href="index.php?page=profile" class="sidebar-item px-4 py-3 rounded-xl hover:bg-hk-green-50 text-hk-green-800 font-medium flex items-center">
                        <i class="fas fa-user mr-3 text-hk-green-600"></i>
                        <span class="nav-text">Profile</span>
                    </a>
                    <a href="index.php?page=duties" class="sidebar-item px-4 py-3 rounded-xl hover:bg-hk-green-50 text-hk-green-800 font-medium flex items-center relative">
                        <i class="fas fa-list-alt mr-3 text-hk-green-600"></i>
                        <span class="nav-text">Ongoing Duties</span>
                    
                    </a>
                    <a href="index.php?page=applicants" class="sidebar-item px-4 py-3 rounded-xl hover:bg-hk-green-50 text-hk-green-800 font-medium flex items-center">
                        <i class="fas fa-users mr-3 text-hk-green-600"></i>
                        <span class="nav-text">Applicants</span>
                    </a>
                    <a href="index.php?page=facilitators" class="sidebar-item px-4 py-3 rounded-xl hover:bg-hk-green-50 text-hk-green-800 font-medium flex items-center">
                        <i class="fas fa-chalkboard-teacher mr-3 text-hk-green-600"></i>
                        <span class="nav-text">Facilitators</span>
                    </a>

                <?php elseif ($userRole === 'admin'): ?>
                    <a href="index.php?page=dashboard" class="sidebar-item px-4 py-3 rounded-xl hover:bg-hk-green-50 text-hk-green-800 font-medium flex items-center">
                        <i class="fas fa-tachometer-alt mr-3 text-hk-green-600"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                    <a href="index.php?page=manage-departments" class="sidebar-item px-4 py-3 rounded-xl hover:bg-hk-green-50 text-hk-green-800 font-medium flex items-center">
                        <i class="fas fa-building mr-3 text-hk-green-600"></i>
                        <span class="nav-text">Departments</span>
                    </a>
<a href="index.php?page=students" class="sidebar-item px-4 py-3 rounded-xl hover:bg-hk-green-50 text-hk-green-800 font-medium flex items-center relative">
    <i class="fas fa-user-graduate mr-3 text-hk-green-600"></i>
    <span class="nav-text">Students</span>

</a>

<a href="index.php?page=teachers" class="sidebar-item px-4 py-3 rounded-xl hover:bg-hk-green-50 text-hk-green-800 font-medium flex items-center relative">
    <i class="fas fa-chalkboard-teacher mr-3 text-hk-green-600"></i>
    <span class="nav-text">Teachers</span>
   
</a>

<a href="index.php?page=reports" class="sidebar-item px-4 py-3 rounded-xl hover:bg-hk-green-50 text-hk-green-800 font-medium flex items-center">
    <i class="fas fa-file-alt mr-3 text-hk-green-600"></i>
    <span class="nav-text">Reports</span>
</a>


                    <a href="index.php?page=settings" class="sidebar-item px-4 py-3 rounded-xl hover:bg-hk-green-50 text-hk-green-800 font-medium flex items-center">
                        <i class="fas fa-cog mr-3 text-hk-green-600"></i>
                        <span class="nav-text">Settings</span>
                    </a>
                <?php endif; ?>
            </nav>
        </div>
        
        <!-- Footer Section -->
        <div class="sidebar-footer">
            <!-- Quick Actions -->
            <div class="mb-4">
                <h3 class="quick-actions-title text-xs uppercase text-hk-green-600 font-semibold mb-2 pl-4">Quick Actions</h3>
                <div class="quick-actions flex space-x-2">
                    <a href="#" class="flex-1 text-center bg-hk-green-100 text-hk-green-700 py-2 rounded-lg text-sm hover:bg-hk-green-200 transition-colors">
                        <i class="fas fa-question-circle"></i>
                    </a>
                    <a href="#" class="flex-1 text-center bg-hk-green-100 text-hk-green-700 py-2 rounded-lg text-sm hover:bg-hk-green-200 transition-colors">
                        <i class="fas fa-cog"></i>
                    </a>
                    <a href="#" class="flex-1 text-center bg-hk-green-100 text-hk-green-700 py-2 rounded-lg text-sm hover:bg-hk-green-200 transition-colors">
                        <i class="fas fa-bell"></i>
                    </a>
                </div>
            </div>
            
            <!-- Logout Button -->
            <a href="logout.php" class="w-full px-4 py-3 rounded-xl bg-red-50 text-red-600 font-medium flex items-center justify-center hover:bg-red-100 transition-colors">
                <i class="fas fa-sign-out-alt mr-2"></i>
                <span class="nav-text">Logout</span>
            </a>
        </div>
    </aside>

   

    <script>
        // Mobile sidebar toggle
        document.getElementById('mobileToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-64');
            
            // Change icon based on state
            const icon = this.querySelector('i');
            if (sidebar.classList.contains('-translate-x-64')) {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            } else {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            }
        });
        
        // Sidebar collapse toggle
        document.getElementById('collapseToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            
            // Toggle the collapsed/expanded classes
            if (sidebar.classList.contains('sidebar-expanded')) {
                sidebar.classList.remove('sidebar-expanded');
                sidebar.classList.add('sidebar-collapse');
            } else {
                sidebar.classList.remove('sidebar-collapse');
                sidebar.classList.add('sidebar-expanded');
            }
            
            // Change icon based on state
            const icon = this.querySelector('i');
            if (sidebar.classList.contains('sidebar-collapse')) {
                icon.classList.remove('fa-chevron-left');
                icon.classList.add('fa-chevron-right');
            } else {
                icon.classList.remove('fa-chevron-right');
                icon.classList.add('fa-chevron-left');
            }
        });
        
        // Set active nav item based on current page
      document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const currentPage = (urlParams.get('page') || 'dashboard').toLowerCase();
    const navItems = document.querySelectorAll('.sidebar-item');
    
    navItems.forEach(item => {
        const href = item.getAttribute('href');
        if (href && href.toLowerCase().includes(`page=${currentPage}`)) {
            item.classList.add('active-nav-item');
        } else {
            item.classList.remove('active-nav-item');
        }
    });
});

    </script>
</body>
</html>