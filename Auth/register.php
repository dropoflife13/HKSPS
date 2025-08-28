<?php
session_start();
require '../config/conn.php';

// Fetch departments for dropdown
$deptResult = $conn->query("SELECT id, name FROM departments ORDER BY name ASC");
$departments = $deptResult ? $deptResult->fetch_all(MYSQLI_ASSOC) : [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name       = trim($_POST['name']);
    $email      = trim($_POST['email']);
    $password   = trim($_POST['password']); // removed hashing
    $role       = $_POST['role'];
    $department_id = !empty($_POST['department']) ? $_POST['department'] : NULL;
    $student_id = ($role === 'student' && !empty($_POST['student_id'])) ? $_POST['student_id'] : NULL;
    $teacher_id = ($role === 'teacher' && !empty($_POST['teacher_id'])) ? $_POST['teacher_id'] : NULL;

    $sql = "INSERT INTO users (name, email, password, role, student_id, teacher_id, department_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $name, $email, $password, $role, $student_id, $teacher_id, $department_id);

    if ($stmt->execute()) {
        echo "✅ Registration successful!";
    } else {
        echo "❌ Error: " . $stmt->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - HAWAK KAMAY Scholarship Program</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'slide-up': 'slideUp 0.8s ease-out',
                        'fade-in': 'fadeIn 1s ease-out',
                        'pulse-glow': 'pulseGlow 2s ease-in-out infinite',
                    },
                }
            }
        }
    </script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        @keyframes slideUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes pulseGlow {
            0%, 100% { 
                box-shadow: 0 0 20px rgba(139, 92, 246, 0.3);
                transform: scale(1);
            }
            50% { 
                box-shadow: 0 0 40px rgba(139, 92, 246, 0.6);
                transform: scale(1.02);
            }
        }
        .glass {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .glass-strong {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .mesh-bg {
            background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #f5576c);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .input-glow:focus {
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1), 0 0 20px rgba(139, 92, 246, 0.2);
        }
        .floating-shape {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            backdrop-filter: blur(10px);
        }
        .field-group {
            display: none;
        }
        .field-group.active {
            display: block;
        }
    </style>
</head>
<body class="font-sans antialiased overflow-hidden">

    <!-- Animated Background -->
    <div class="fixed inset-0 mesh-bg"></div>
    
    <!-- Floating Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="floating-shape w-24 h-24 top-20 left-10 animate-float"></div>
        <div class="floating-shape w-16 h-16 top-40 right-20 animate-float" style="animation-delay: -2s;"></div>
        <div class="floating-shape w-20 h-20 bottom-32 left-1/4 animate-float" style="animation-delay: -4s;"></div>
        <div class="floating-shape w-32 h-32 bottom-20 right-10 animate-float" style="animation-delay: -1s;"></div>
    </div>

    <!-- Main Content -->
    <div class="min-h-screen flex items-center justify-center p-4 relative z-10 overflow-hidden">
        <div class="w-full max-w-md">
            <!-- Back to Home Button -->
            <div class="mb-4 animate-slide-up">
                <a href="../landing.php" class="inline-flex items-center text-white/80 hover:text-white transition-colors duration-200 group text-sm">
                    <svg class="w-4 h-4 mr-1 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Home
                </a>
            </div>

            <!-- Registration Card -->
            <div class="glass-strong rounded-2xl p-6 shadow-2xl animate-slide-up max-h-[85vh] overflow-hidden" style="animation-delay: 0.2s;">
                <!-- Logo and Title -->
                <div class="text-center mb-5">
                    <div class="flex items-center justify-center space-x-2 mb-2">
                        <div class="w-8 h-8 bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg flex items-center justify-center animate-pulse-glow">
                            <span class="text-white font-bold text-sm">HK</span>
                        </div>
                        <span class="text-lg font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">HAWAK KAMAY</span>
                    </div>
                    <h2 class="text-xl font-black text-gray-800 mb-1">Create Account</h2>
                    <p class="text-gray-600 text-xs">Join the scholarship program</p>
                </div>

                <!-- Error Message (PHP Integration) -->
                <?php if (!empty($error)): ?>
                    <div class="mb-4 p-2 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-red-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <span class="text-red-700 text-xs"><?php echo $error; ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Registration Form -->
                <form action="register.php" method="POST" class="space-y-3">
                    <!-- Full Name -->
                    <div class="space-y-1">
                        <label class="block text-gray-700 font-medium text-xs uppercase tracking-wider">Full Name</label>
                        <input type="text" name="name" required 
                               class="input-glow w-full px-3 py-2 rounded-lg border-2 border-gray-200 focus:border-purple-500 focus:outline-none transition-all duration-300 bg-white/80 backdrop-blur-sm text-sm"
                               placeholder="Enter your full name">
                    </div>

                    <!-- Email -->
                    <div class="space-y-1">
                        <label class="block text-gray-700 font-medium text-xs uppercase tracking-wider">Email</label>
                        <input type="email" name="email" required 
                               class="input-glow w-full px-3 py-2 rounded-lg border-2 border-gray-200 focus:border-purple-500 focus:outline-none transition-all duration-300 bg-white/80 backdrop-blur-sm text-sm"
                               placeholder="Enter your email">
                    </div>

                    <!-- Password -->
                    <div class="space-y-1">
                        <label class="block text-gray-700 font-medium text-xs uppercase tracking-wider">Password</label>
                        <div class="relative">
                            <input type="password" name="password" required id="password"
                                   class="input-glow w-full px-3 pr-10 py-2 rounded-lg border-2 border-gray-200 focus:border-purple-500 focus:outline-none transition-all duration-300 bg-white/80 backdrop-blur-sm text-sm"
                                   placeholder="Enter your password">
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg id="eye-icon" class="h-3 w-3 text-gray-400 hover:text-gray-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Role Selection -->
                    <div class="space-y-1">
                        <label class="block text-gray-700 font-medium text-xs uppercase tracking-wider">Role</label>
                        <select name="role" id="role" onchange="toggleFields()" required 
                                class="input-glow w-full px-3 py-2 rounded-lg border-2 border-gray-200 focus:border-purple-500 focus:outline-none transition-all duration-300 bg-white/80 backdrop-blur-sm text-sm">
                            <option value="">-- Select Role --</option>
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                        </select>
                    </div>

                    <!-- Student Fields -->
                    <div id="studentFields" class="field-group space-y-3">
                        <div class="space-y-1">
                            <label class="block text-gray-700 font-medium text-xs uppercase tracking-wider">Student ID</label>
                            <input type="text" name="student_id"
                                   class="input-glow w-full px-3 py-2 rounded-lg border-2 border-gray-200 focus:border-purple-500 focus:outline-none transition-all duration-300 bg-white/80 backdrop-blur-sm text-sm"
                                   placeholder="Enter your student ID">
                        </div>
                    </div>

                    <!-- Teacher Fields -->
                    <div id="teacherFields" class="field-group space-y-3">
                        <div class="space-y-1">
                            <label class="block text-gray-700 font-medium text-xs uppercase tracking-wider">Teacher ID</label>
                            <input type="text" name="teacher_id"
                                   class="input-glow w-full px-3 py-2 rounded-lg border-2 border-gray-200 focus:border-purple-500 focus:outline-none transition-all duration-300 bg-white/80 backdrop-blur-sm text-sm"
                                   placeholder="Enter your teacher ID">
                        </div>
                    </div>

                    <!-- Department -->
                    <div class="space-y-1">
                        <label class="block text-gray-700 font-medium text-xs uppercase tracking-wider">Department</label>
                        <select name="department" required 
                                class="input-glow w-full px-3 py-2 rounded-lg border-2 border-gray-200 focus:border-purple-500 focus:outline-none transition-all duration-300 bg-white/80 backdrop-blur-sm text-sm">
                            <option value="">-- Select Department --</option>
                            <!-- PHP departments loop would go here -->
                            <?php if (isset($departments)): ?>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?= htmlspecialchars($dept['id']) ?>"><?= htmlspecialchars($dept['name']) ?></option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <!-- Fallback options for demo -->
                                <option value="1">Computer Science</option>
                                <option value="2">Engineering</option>
                                <option value="3">Business Administration</option>
                                <option value="4">Liberal Arts</option>
                                <option value="5">Education</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Register Button -->
                    <button type="submit" 
                            class="group w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white font-bold py-2.5 px-4 rounded-lg hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-4 focus:ring-purple-300 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-lg text-sm mt-4">
                        <span class="flex items-center justify-center">
                            Create Account
                            <svg class="ml-2 w-3 h-3 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </span>
                    </button>
                </form>

                <!-- Login Link -->
                <div class="mt-4 text-center">
                    <p class="text-gray-600 mb-2 text-xs">Already have an account?</p>
                    <a href="login.php">
                        <button type="button" 
                                class="w-full bg-white/60 backdrop-blur-sm border-2 border-purple-200 text-purple-700 font-bold py-2.5 px-4 rounded-lg hover:bg-white/80 hover:border-purple-300 hover:shadow-md transition-all duration-300 transform hover:scale-[1.02] text-sm">
                            Sign In Instead
                        </button>
                    </a>
                </div>
            </div>

            <!-- Footer Links -->
            <div class="mt-3 text-center animate-fade-in" style="animation-delay: 0.4s;">
                <div class="flex justify-center space-x-4 text-xs text-white/80">
                    <a href="#" class="hover:text-white transition-colors duration-200">Privacy</a>
                    <a href="#" class="hover:text-white transition-colors duration-200">Terms</a>
                    <a href="#" class="hover:text-white transition-colors duration-200">Help</a>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Password visibility toggle
        function togglePassword() {
            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (password.type === 'password') {
                password.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                `;
            } else {
                password.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        }

        // Toggle role-specific fields
        function toggleFields() {
            const role = document.getElementById("role").value;
            const studentFields = document.getElementById("studentFields");
            const teacherFields = document.getElementById("teacherFields");
            
            // Reset all fields
            studentFields.classList.remove("active");
            teacherFields.classList.remove("active");
            
            // Show relevant fields with animation
            if (role === "student") {
                setTimeout(() => studentFields.classList.add("active"), 100);
                // Make student ID required
                document.querySelector('input[name="student_id"]').setAttribute('required', '');
                document.querySelector('input[name="teacher_id"]').removeAttribute('required');
            } else if (role === "teacher") {
                setTimeout(() => teacherFields.classList.add("active"), 100);
                // Make teacher ID required
                document.querySelector('input[name="teacher_id"]').setAttribute('required', '');
                document.querySelector('input[name="student_id"]').removeAttribute('required');
            } else {
                // Remove all requirements if no role selected
                document.querySelector('input[name="student_id"]').removeAttribute('required');
                document.querySelector('input[name="teacher_id"]').removeAttribute('required');
            }
        }

        // Initialize on page load
        window.addEventListener('load', function() {
            toggleFields();
            
            // Form animation
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input, select');
            
            inputs.forEach((input, index) => {
                input.style.animationDelay = `${0.05 * index}s`;
                input.classList.add('animate-slide-up');
            });
        });

        // Enhanced input focus effects
        document.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('focus', function() {
                this.classList.add('scale-105');
            });
            
            input.addEventListener('blur', function() {
                this.classList.remove('scale-105');
            });
        });

        // Form validation enhancement
        document.querySelector('form').addEventListener('submit', function(e) {
            const role = document.getElementById('role').value;
            const studentId = document.querySelector('input[name="student_id"]').value;
            const teacherId = document.querySelector('input[name="teacher_id"]').value;
            
            if (role === 'student' && !studentId.trim()) {
                e.preventDefault();
                alert('Please enter your Student ID');
                return;
            }
            
            if (role === 'teacher' && !teacherId.trim()) {
                e.preventDefault();
                alert('Please enter your Teacher ID');
                return;
            }
        });
    </script>

</body>
</html>