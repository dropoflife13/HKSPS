    <?php
    // Include your initialization file
    include 'config/init.php';


    // Check if user is logged in
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
        header("Location: Auth/login.php");
        exit();
    }

    // Fetch user info
    $userId = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT u.*, d.name AS department_name FROM users u LEFT JOIN departments d ON u.department_id=d.id WHERE u.id=?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $role = $user['role'] ?? '';

    // Fetch departments
    $departments = $conn->query("SELECT id, name FROM departments ORDER BY name ASC");

    // Determine ID label
    $idLabel = $role === 'teacher' ? 'Teacher ID' : 'Student ID';
    $idValue = $role === 'teacher' ? $user['teacher_id'] : $user['student_id'];

    // Handle profile update
    $successMsg = $errorMsg = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
    // Ensure department is either a valid ID or NULL
    $department_id = !empty($_POST['department_id']) ? intval($_POST['department_id']) : null;

        $year_level = $role === 'student' ? trim($_POST['year_level'] ?? '') : null;
        $office_location = $role === 'teacher' ? trim($_POST['office_location'] ?? '') : null;

        $stmt = $conn->prepare("UPDATE users SET name=?, email=?, department_id=?, year_level=?, office_location=? WHERE id=?");
        $stmt->bind_param("ssissi", $name, $email, $department_id, $year_level, $office_location, $userId);
        if ($stmt->execute()) {
            $successMsg = "Profile updated successfully!";
            $user['name'] = $name;
            $user['email'] = $email;
            $user['department_id'] = $department_id;
            $user['year_level'] = $year_level;
            $user['office_location'] = $office_location;
            
            // Update session variables if needed
            $_SESSION['user_name'] = $name;
        } else {
            $errorMsg = "Failed to update profile.";
        }
    }

    // Set page variables for the template
    $userRole = $_SESSION['role'];
    $page = 'profile'; // This should match your profile page filename

    $roleFolders = [
        'student' => 'Students',
        'teacher' => 'Teachers',
        'admin' => 'Admin'
    ];

    $folder = isset($roleFolders[$userRole]) ? $roleFolders[$userRole] : null;

    $alertMessage = '';
    $alertType = '';
    if (!empty($successMsg)) {
        $alertMessage = $successMsg;
        $alertType = 'success';
    } elseif (!empty($errorMsg)) {
        $alertMessage = $errorMsg;
        $alertType = 'error';
    }

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body class="bg-gray-100 p-6">

    <?php if (isset($_GET['success'])): ?>
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg mb-4">
            <?= htmlspecialchars($_GET['success']) ?>
        </div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="bg-red-100 text-red-800 px-4 py-3 rounded-lg mb-4">
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>


    <div id="alert" class="fixed top-4 right-4 z-50 hidden">
        <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center alert-slide">
            <i class="fas fa-check-circle mr-3"></i>
            <span id="alert-message"></span>
        </div>
    </div>



        <div class="max-w-6xl mx-auto">
                        <div class="mb-8">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <div>
                                    <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                                        <span class="mr-3">
                                            <svg class="w-8 h-8 text-hk-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </span>
                                        My Profile
                                    </h1>
                                    <p class="text-gray-600 mt-2 ml-11">Manage your personal information and account settings</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <!-- Profile Picture Section -->
                            <div class="bg-white rounded-2xl shadow-lg p-6 profile-card">
                                <div class="flex flex-col items-center">
                                    <div class="relative mb-4">
                                        <img class="w-32 h-32 rounded-full object-cover border-4 border-hk-green-200" 
                                            src="<?= !empty($user['avatar']) ? htmlspecialchars($user['avatar']) : 'https://ui-avatars.com/api/?name='.urlencode($user['name']).'&background=40916c&color=fff&size=128' ?>" 
                                            alt="Profile picture">
                                        <button class="absolute bottom-0 right-0 bg-hk-green-500 text-white p-2 rounded-full shadow-md hover:bg-hk-green-600 transition-colors">
                                            <i class="fas fa-camera"></i>
                                        </button>
                                    </div>
                                    <h2 class="text-xl font-semibold text-gray-900"><?= htmlspecialchars($user['name']) ?></h2>
                                    <p class="text-gray-600"><?= ucfirst($role) ?></p>
                                    <p class="text-sm text-gray-500 mt-2"><?= htmlspecialchars($user['department_name'] ?? 'No department') ?></p>
                                    
                                    <button onclick="openModal()" class="mt-6 w-full bg-hk-green-500 text-white py-2 px-4 rounded-lg hover:bg-hk-green-600 transition-colors flex items-center justify-center">
                                        <i class="fas fa-edit mr-2"></i> Edit Profile
                                    </button>
                                </div>
                            </div>

    <!-- Profile Details Section -->
                            <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6 profile-card">
                                <h3 class="text-xl font-semibold text-gray-900 mb-6 border-b pb-2">Personal Information</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                        <p class="text-gray-900"><?= htmlspecialchars($user['name']) ?></p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                        <p class="text-gray-900"><?= htmlspecialchars($user['email']) ?></p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1"><?= $idLabel ?></label>
                                        <p class="text-gray-900"><?= htmlspecialchars($idValue) ?></p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                                        <p class="text-gray-900"><?= htmlspecialchars($user['department_name'] ?? 'Not assigned') ?></p>
                                    </div>
                                    <?php if($role === 'student'): ?>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Year Level</label>
                                        <p class="text-gray-900"><?= htmlspecialchars($user['year_level'] ?? 'Not specified') ?></p>
                                    </div>
                                    <?php elseif($role === 'teacher'): ?>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Office Location</label>
                                        <p class="text-gray-900"><?= htmlspecialchars($user['office_location'] ?? 'Not specified') ?></p>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                
                                <h3 class="text-xl font-semibold text-gray-900 mb-6 border-b pb-2">Account Details</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Account Status</label>
                                        <p class="text-green-600 font-medium">Active</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Member Since</label>
                                        <p class="text-gray-900"><?= date('F j, Y', strtotime($user['created_at'])) ?></p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Updated</label>
                                        <p class="text-gray-900"><?= date('F j, Y', strtotime($user['updated_at'])) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

    
    
    </div>

    <script>
    document.getElementById('profileForm').addEventListener('submit', function(e){
        e.preventDefault();

        const formData = new FormData(this);

        fetch('Shared/update_profile_ajax.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                showAlert('Profile updated successfully!', 'success');
                document.querySelector('h2.text-xl.font-semibold').textContent = data.profile.name;
                document.querySelector('p.text-gray-600').textContent = data.profile.role || '';
                closeModal();
            } else {
                showAlert(data.error || 'Update failed', 'error');
            }
        })
        .catch(err => showAlert('AJAX error: ' + err, 'error'));
    });

    function openModal() {
        document.getElementById('profileModal').classList.remove('hidden');
        document.getElementById('profileModal').classList.add('flex');
    }
    function closeModal() {
        document.getElementById('profileModal').classList.add('hidden');
        document.getElementById('profileModal').classList.remove('flex');
    }
    </script>

    </body>
    </html>
    <!-- Update Profile Modal -->
        <div id="profileModal" class="fixed inset-0 z-50 flex items-center justify-center hidden modal-overlay">
            <div class="fixed inset-0 bg-black opacity-50" onclick="closeModal()"></div>
            <div class="bg-white rounded-lg shadow-xl w-11/12 md:w-3/4 lg:w-1/2 max-w-2xl z-50 overflow-y-auto max-h-screen">
                <div class="p-6">
                    <div class="flex justify-between items-center pb-3">
                        <h3 class="text-2xl font-bold text-gray-900">Edit Profile</h3>
                        <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    
                    <form method="POST" action="">
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-hk-green-500 focus:ring focus:ring-hk-green-200 focus:ring-opacity-50 p-2 border">
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-hk-green-500 focus:ring focus:ring-hk-green-200 focus:ring-opacity-50 p-2 border">
                            </div>
                            
                            <div>
                                <label for="department_id" class="block text-sm font-medium text-gray-700">Department</label>
                                <select id="department_id" name="department_id" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-hk-green-500 focus:ring focus:ring-hk-green-200 focus:ring-opacity-50 p-2 border">
                                    <option value="">Select Department</option>
                                    <?php while($dept = $departments->fetch_assoc()): ?>
                                        <option value="<?= $dept['id'] ?>" <?= $user['department_id'] == $dept['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($dept['name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            
                            <?php if($role === 'student'): ?>
                            <div>
                                <label for="year_level" class="block text-sm font-medium text-gray-700">Year Level</label>
                                <input type="text" id="year_level" name="year_level" value="<?= htmlspecialchars($user['year_level'] ?? '') ?>" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-hk-green-500 focus:ring focus:ring-hk-green-200 focus:ring-opacity-50 p-2 border">
                            </div>
                            <?php elseif($role === 'teacher'): ?>
                            <div>
                                <label for="office_location" class="block text-sm font-medium text-gray-700">Office Location</label>
                                <input type="text" id="office_location" name="office_location" value="<?= htmlspecialchars($user['office_location'] ?? '') ?>" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-hk-green-500 focus:ring focus:ring-hk-green-200 focus:ring-opacity-50 p-2 border">
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="flex justify-end space-x-3 pt-6 mt-6 border-t">
                            <button type="button" onclick="closeModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-md transition-colors">
                                Cancel
                            </button>
                            <button type="submit" name="update_profile" class="px-4 py-2 text-sm font-medium text-white bg-hk-green-500 hover:bg-hk-green-600 rounded-md transition-colors">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>

            function showAlert(message, type = 'success') {
        const alertBox = document.getElementById('alert');
        const alertMessage = document.getElementById('alert-message');
        alertMessage.textContent = message;

        if(type === 'success') {
            alertBox.firstElementChild.classList.remove('bg-red-500');
            alertBox.firstElementChild.classList.add('bg-green-500');
        } else {
            alertBox.firstElementChild.classList.remove('bg-green-500');
            alertBox.firstElementChild.classList.add('bg-red-500');
        }

        alertBox.classList.remove('hidden');
        setTimeout(() => alertBox.classList.add('hidden'), 3000);
    }

            function openModal() {
                document.getElementById('profileModal').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
            
            function closeModal() {
                document.getElementById('profileModal').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        

    document.getElementById('profileForm').addEventListener('submit', function(e){
        e.preventDefault(); // Prevent page reload

        const formData = new FormData(this);

        fetch('update_profile_ajax.php', { // create this separate PHP file for AJAX
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                showAlert('Profile updated successfully!', 'success');
                
                // Optionally update fields on the page without reload
                document.querySelector('h2.text-xl.font-semibold').textContent = data.profile.name;
                document.querySelector('p.text-gray-600').textContent = data.profile.role || '';
                // Close modal
                closeModal();
            } else {
                showAlert(data.error || 'Update failed', 'error');
            }
        })
        .catch(err => showAlert('AJAX error: ' + err, 'error'));
    });

    </script>

        
    
    </body>
    </html>