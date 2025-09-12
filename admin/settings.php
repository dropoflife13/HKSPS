<?php
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $siteName = trim($_POST['site_name']);
    $adminEmail = trim($_POST['admin_email']);
    $reportsEnabled = isset($_POST['reports_enabled']) ? 1 : 0;
    $jobsEnabled = isset($_POST['job_applications_enabled']) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE settings SET site_name=?, admin_email=?, reports_enabled=?, job_applications_enabled=? WHERE id=1");
    $stmt->bind_param("ssii", $siteName, $adminEmail, $reportsEnabled, $jobsEnabled);

    if ($stmt->execute()) {
        $msg = "✅ Settings updated successfully.";
    } else {
        $msg = "❌ Error updating settings: " . $conn->error;
    }
}

// Fetch current settings
$settings = $conn->query("SELECT * FROM settings WHERE id=1")->fetch_assoc();
?>


    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        green: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                        }
                    }
                }
            }
        }
    </script>

 
            <!-- Settings Header -->
            <div class="bg-gradient-to-r from-green-50 to-blue-50 px-6 py-5 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-cog mr-3 text-green-600"></i>
                            System Settings
                        </h2>
                        <p class="text-gray-600 mt-1">Manage your application settings and preferences</p>
                    </div>
                    <div class="hidden md:block">
                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Admin</span>
                    </div>
                </div>
            </div>
            
            <!-- Settings Tabs -->
            <div class="border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500">
                    <li class="mr-2">
                        <a href="#" class="inline-flex items-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 group active-tab">
                            <i class="fas fa-globe mr-2 text-green-600"></i>
                            General
                        </a>
                    </li>
                    <li class="mr-2">
                        <a href="#" class="inline-flex items-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 group">
                            <i class="fas fa-bell mr-2 text-blue-500"></i>
                            Notifications
                        </a>
                    </li>
                    <li class="mr-2">
                        <a href="#" class="inline-flex items-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 group">
                            <i class="fas fa-shield-alt mr-2 text-purple-500"></i>
                            Security
                        </a>
                    </li>
                    <li class="mr-2">
                        <a href="#" class="inline-flex items-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 group">
                            <i class="fas fa-users mr-2 text-amber-500"></i>
                            User Management
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Success Message -->
            <div class="mx-6 mt-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-800 flex items-start">
                <i class="fas fa-check-circle mr-3 mt-0.5 text-green-600"></i>
                <div>
                    <p class="font-medium">Settings updated successfully</p>
                    <p class="text-sm mt-1">Your changes have been saved and applied to the system.</p>
                </div>
                <button class="ml-auto text-green-700 hover:text-green-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <!-- Settings Form -->
            <form class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Site Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-signature mr-2 text-blue-500"></i>
                            Site Name
                        </label>
                        <div class="relative">
                            <input type="text" value="Scholarship Portal" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <i class="fas fa-signature absolute left-3 top-3.5 text-gray-400"></i>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">The name displayed throughout the application</p>
                    </div>

                    <!-- Admin Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-blue-500"></i>
                            Admin Email
                        </label>
                        <div class="relative">
                            <input type="email" value="admin@scholarship.org" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <i class="fas fa-envelope absolute left-3 top-3.5 text-gray-400"></i>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Where system notifications will be sent</p>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-toggle-on mr-2 text-green-600"></i>
                        Feature Toggles
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Reports Enabled -->
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div>
                                <p class="font-medium text-gray-900">Report System</p>
                                <p class="text-sm text-gray-500">Enable generation of system reports</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="reports_enabled" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                            </label>
                        </div>

                        <!-- Job Applications Enabled -->
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div>
                                <p class="font-medium text-gray-900">Job Applications</p>
                                <p class="text-sm text-gray-500">Allow users to apply for jobs</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="job_applications_enabled" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                            </label>
                        </div>
                        
                        <!-- New Setting 1 -->
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div>
                                <p class="font-medium text-gray-900">User Registration</p>
                                <p class="text-sm text-gray-500">Allow new users to register</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="user_registration" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                            </label>
                        </div>
                        
                        <!-- New Setting 2 -->
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div>
                                <p class="font-medium text-gray-900">Email Notifications</p>
                                <p class="text-sm text-gray-500">Send email notifications to users</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="email_notifications" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-sliders-h mr-2 text-green-600"></i>
                        Additional Settings
                    </h3>
                   <div class="grid grid-cols-2 gap-6 mb-4">
    <!-- Timezone -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-clock mr-2 text-blue-500"></i>
            Timezone
        </label>
        <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            <option>(UTC-08:00) Pacific Time</option>
            <option selected>(UTC-05:00) Eastern Time</option>
            <option>(UTC+00:00) Greenwich Mean Time</option>
            <option>(UTC+01:00) Central European Time</option>
        </select>
    </div>

    <!-- Date Format -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            <i class="fas fa-calendar mr-2 text-blue-500"></i>
            Date Format
        </label>
        <div class="grid grid-cols-1 gap-3">
            <label class="flex items-center p-2 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                <input type="radio" name="date_format" class="mr-2 text-blue-600" checked>
                <span>MM/DD/YYYY</span>
            </label>
         
        </div>
    </div>
</div>

                <!-- Save Button -->
                <div class="flex justify-end pt-6 border-t border-gray-200">
                    <button type="button" class="px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition mr-3">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow transition duration-200 flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

    