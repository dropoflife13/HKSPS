<?php
session_start();
require '../config/conn.php';

// Fetch departments for dropdown
$deptResult = $conn->query("SELECT id, name FROM departments ORDER BY name ASC");
$departments = $deptResult ? $deptResult->fetch_all(MYSQLI_ASSOC) : [];

// Include modal functions
require_once '../config/modal.php';

$showSuccessModal = false;
$showErrorModal = false;
$modalMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name       = trim($_POST['name']);
    $email      = trim($_POST['email']);
    $password   = trim($_POST['password']);
    $student_id = !empty($_POST['student_id']) ? $_POST['student_id'] : NULL;
    $department_id = !empty($_POST['department']) ? $_POST['department'] : NULL;

    // Set default role to 'student'
    $role = 'student';

    $sql = "INSERT INTO users (name, email, password, role, student_id, department_id) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $email, $password, $role, $student_id, $department_id);

    if ($stmt->execute()) {
        $showSuccessModal = true;
        $modalMessage = 'Registration successful! You can now login with your credentials.';
    } else {
        $showErrorModal = true;
        $modalMessage = 'Error: ' . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - HAWAK KAMAY Scholarship Program</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">



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
                box-shadow: 0 0 20px rgba(64, 145, 108, 0.3);
                transform: scale(1);
            }
            50% { 
                box-shadow: 0 0 40px rgba(64, 145, 108, 0.6);
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
            background: linear-gradient(-45deg, #081c15, #1b4332, #40916c, #52b788);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .input-glow:focus {
            box-shadow: 0 0 0 3px rgba(64, 145, 108, 0.1), 0 0 20px rgba(64, 145, 108, 0.2);
        }
        .floating-shape {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            backdrop-filter: blur(10px);
        }
        .hk-gradient-bg {
            background: linear-gradient(135deg, #081c15 0%, #40916c 100%);
        }
        .hk-gradient-text {
            background: linear-gradient(135deg, #081c15 0%, #40916c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
          .icon-inset {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    font-size: 14px;
    pointer-events: none; /* so clicks go through */
    z-index: 10;
}

.right-icon {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    font-size: 12px;
    pointer-events: none;
    z-index: 10;
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
                        <div class="w-8 h-8 hk-gradient-bg rounded-lg flex items-center justify-center animate-pulse-glow">
                            <span class="text-white font-bold text-sm">HK</span>
                        </div>
                        <span class="text-lg font-bold hk-gradient-text">HAWAK KAMAY</span>
                    </div>
                    <h2 class="text-xl font-black text-gray-800 mb-1">Student Registration</h2>
                    <p class="text-gray-600 text-xs">Join the scholarship program</p>
                </div>

            <!-- Registration Form -->
<form action="register.php" method="POST" class="space-y-3">
    <!-- Full Name -->
    <div class="space-y-1">
        <label class="block text-gray-700 font-medium text-xs uppercase tracking-wider">Full Name</label>
        <div class="relative">
            <i class="fas fa-user icon-inset"></i>
            <input type="text" name="name" required
                   class="input-glow w-full pl-8 pr-3 py-2 rounded-lg border-2 border-gray-200
                          focus:border-hk-green-500 focus:outline-none transition-all duration-300
                          bg-white/80 backdrop-blur-sm text-sm"
                   placeholder="Enter your full name">
        </div>
    </div>

    <!-- Email -->
    <div class="space-y-1">
        <label class="block text-gray-700 font-medium text-xs uppercase tracking-wider">Email</label>
        <div class="relative">
            <i class="fas fa-envelope icon-inset"></i>
            <input type="email" name="email" required
                   class="input-glow w-full pl-8 pr-3 py-2 rounded-lg border-2 border-gray-200
                          focus:border-hk-green-500 focus:outline-none transition-all duration-300
                          bg-white/80 backdrop-blur-sm text-sm"
                   placeholder="Enter your email">
        </div>
    </div>

    <!-- Password -->
    <div class="space-y-1">
        <label class="block text-gray-700 font-medium text-xs uppercase tracking-wider">Password</label>
        <div class="relative">
            <i class="fas fa-lock icon-inset"></i>
            <input type="password" name="password" required id="password"
                   class="input-glow w-full pl-8 pr-10 py-2 rounded-lg border-2 border-gray-200
                          focus:border-hk-green-500 focus:outline-none transition-all duration-300
                          bg-white/80 backdrop-blur-sm text-sm"
                   placeholder="Enter your password">
            <button type="button" onclick="togglePassword()"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center">
                <i id="eye-icon" class="fas fa-eye text-gray-400 hover:text-gray-600 text-xs"></i>
            </button>
        </div>
    </div>

    <!-- Student ID -->
    <div class="space-y-1">
        <label class="block text-gray-700 font-medium text-xs uppercase tracking-wider">Student ID</label>
        <div class="relative">
            <i class="fas fa-id-card icon-inset"></i>
            <input type="text" name="student_id" required
                   class="input-glow w-full pl-8 pr-3 py-2 rounded-lg border-2 border-gray-200
                          focus:border-hk-green-500 focus:outline-none transition-all duration-300
                          bg-white/80 backdrop-blur-sm text-sm"
                   placeholder="Enter your student ID">
        </div>
    </div>

    <!-- Department -->
    <div class="space-y-1">
        <label class="block text-gray-700 font-medium text-xs uppercase tracking-wider">Department</label>
        <div class="relative">
            <i class="fas fa-building icon-inset"></i>
            <select name="department" required
                    class="input-glow w-full pl-8 pr-8 py-2 rounded-lg border-2 border-gray-200
                           focus:border-hk-green-500 focus:outline-none transition-all duration-300
                           bg-white/80 backdrop-blur-sm text-sm appearance-none">
                <option value="">-- Select Department --</option>
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
            <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 
                       pointer-events-none text-gray-400 text-xs"></i>
        </div>
    </div>

    <!-- Register Button -->
    <button type="submit"
            class="group w-full hk-gradient-bg text-white font-bold py-2.5 px-4 rounded-lg
                   hover:opacity-90 focus:outline-none focus:ring-4 focus:ring-hk-green-300
                   transition-all duration-300 transform hover:scale-[1.02] hover:shadow-lg
                   text-sm mt-4">
        <span class="flex items-center justify-center">
            Create Account
            <svg class="ml-2 w-3 h-3 group-hover:translate-x-1 transition-transform duration-200"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
            </svg>
        </span>
    </button>
</form>


                <!-- Login Link -->
                <div class="mt-4 text-center">
                    <p class="text-gray-600 mb-2 text-xs">Already have an account?</p>
                    <a href="login.php">
                        <button type="button" 
                                class="w-full bg-white/60 backdrop-blur-sm border-2 border-hk-green-200 text-hk-green-700 font-bold py-2.5 px-4 rounded-lg hover:bg-white/80 hover:border-hk-green-300 hover:shadow-md transition-all duration-300 transform hover:scale-[1.02] text-sm">
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

    <!-- Success Modal -->
    <?php if ($showSuccessModal): ?>
    <?php
    $successContent = '
        <div class="text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-gray-700 mb-2">' . $modalMessage . '</p>
            <p class="text-sm text-gray-500">You will be redirected to the login page shortly.</p>
        </div>
    ';
    
    $successButtons = [
        [
            'label' => 'Go to Login',
            'class' => 'bg-hk-green-500 hover:bg-hk-green-600 text-white px-4 py-2 rounded',
            'onclick' => 'window.location.href="login.php"'
        ]
    ];
    
    showModal('successModal', 'Registration Successful', $successContent, $successButtons);
    ?>
    <?php endif; ?>

    <!-- Error Modal -->
    <?php if ($showErrorModal): ?>
    <?php
    $errorContent = '
        <div class="text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <p class="text-gray-700">' . $modalMessage . '</p>
        </div>
    ';
    
    $errorButtons = [
        [
            'label' => 'Try Again',
            'class' => 'bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded',
            'onclick' => 'closeModal(\'errorModal\')'
        ]
    ];
    
    showModal('errorModal', 'Registration Failed', $errorContent, $errorButtons);
    ?>
    <?php endif; ?>

<!-- JavaScript -->
<script>
    // Password visibility toggle
    function togglePassword() {
        const password = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        
        if (password.type === 'password') {
            password.type = 'text';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 极
            `;
        } else {
            password.type = 'password';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-极
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            `;
        }
    }

    // Form animation on load
    window.addEventListener('load', function() {
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input, select');
        
        inputs.forEach((input, index) => {
            input.style.animationDelay = `${0.05 * index}s`;
            input.classList.add('animate-slide-up');
        });

        // AUTO-OPEN MODALS AFTER PAGE LOADS - THIS IS THE FIX
        <?php if ($showSuccessModal): ?>
        setTimeout(function() {
            openModal('successModal');
            // Auto-redirect after 5 seconds
            setTimeout(function() {
                window.location.href = 'login.php';
            }, 5000);
        }, 100);
        <?php endif; ?>

        <?php if ($showErrorModal): ?>
        setTimeout(function() {
            openModal('errorModal');
        }, 100);
        <?php endif; ?>
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

    // Form submission loading state
    document.querySelector('form').addEventListener('submit', function(e) {
        const submitButton = this.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;
        
        // Show loading state
        submitButton.innerHTML = `
            <span class="flex items-center justify-center">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width极
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 极
                </svg>
                Processing...
            </span>
        `;
        submitButton.disabled = true;
    });
</script>

</body>
</html>