<?php
session_start();
include("../config/conn.php"); // DB connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if ($password === $user['password']) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role']      = $user['role'];

            switch ($user['role']) {
                case "admin":
                    header("Location: ../index.php?page=dashboard");
                    break;
                case "teacher":
                    header("Location: ../index.php?page=dashboard");
                    break;
                default: // student
                    header("Location: ../index.php?page=dashboard");
                    break;
            }
            exit;
        } else {
            $error = "❌ Invalid password!";
        }
    } else {
        $error = "❌ No account found with that email!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HAWAK KAMAY Scholarship Program</title>
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
                        'glow': 'glow 2s ease-in-out infinite alternate',
                        'slide-up': 'slideUp 0.8s ease-out',
                        'fade-in': 'fadeIn 1s ease-out',
                        'bounce-subtle': 'bounceSubtle 2s ease-in-out infinite',
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
        @keyframes glow {
            from { box-shadow: 0 0 20px rgba(139, 92, 246, 0.5); }
            to { box-shadow: 0 0 30px rgba(139, 92, 246, 0.8), 0 0 40px rgba(139, 92, 246, 0.3); }
        }
        @keyframes slideUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes bounceSubtle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
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
            background: rgba(255, 255, 255, 0.9);
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
    </style>
</head>
<body class="font-sans antialiased overflow-hidden">

    <!-- Animated Background -->
    <div class="fixed inset-0 mesh-bg"></div>
    
    <!-- Floating Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="floating-shape w-32 h-32 top-20 left-10 animate-float"></div>
        <div class="floating-shape w-20 h-20 top-40 right-20 animate-float" style="animation-delay: -2s;"></div>
        <div class="floating-shape w-24 h-24 bottom-32 left-1/4 animate-float" style="animation-delay: -4s;"></div>
        <div class="floating-shape w-40 h-40 bottom-20 right-10 animate-float" style="animation-delay: -1s;"></div>
        <div class="floating-shape w-16 h-16 top-1/3 right-1/4 animate-float" style="animation-delay: -3s;"></div>
    </div>

    <!-- Main Content -->
    <div class="min-h-screen flex items-center justify-center p-3 relative z-10">
        <div class="w-full max-w-sm">
            <!-- Back to Home Button -->
        

            <!-- Login Card -->
             
            <div class="glass-strong rounded-2xl p-6 shadow-2xl animate-slide-up" style="animation-delay: 0.2s;">
                <!-- Logo and Title -->
                  <div class="mb-4 animate-slide-up">
                <a href="../landing.php" class="inline-flex items-center text-black hover:text-yellow transition-colors duration-200 group text-sm">
                    <svg class="w-4 h-4 mr-1 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Home
                </a>
      
                <div class="text-center mb-6">
                    <div class="flex items-center justify-center space-x-2 mb-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg flex items-center justify-center animate-pulse-glow">
                            <span class="text-white font-bold text-lg">HK</span>
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">HAWAK KAMAY</span>
                    </div>
                    <h2 class="text-2xl font-black text-gray-800 mb-1">Welcome Back</h2>
                    <p class="text-gray-600 text-sm">Sign in to continue your journey</p>
                </div>
                  </div>
                <!-- Error Message (PHP Integration) -->
                <?php if (!empty($error)): ?>
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-red-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <span class="text-red-700 text-sm"><?php echo $error; ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Login Form -->
                <form action="login.php" method="POST" class="space-y-4">
                    <!-- Email Field -->
                    <div class="space-y-1">
                        <label class="block text-gray-700 font-medium text-xs uppercase tracking-wider">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <input type="email" name="email" required 
                                   class="input-glow w-full pl-10 pr-3 py-3 rounded-lg border-2 border-gray-200 focus:border-purple-500 focus:outline-none transition-all duration-300 bg-white/80 backdrop-blur-sm text-sm"
                                   placeholder="Enter your email">
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-1">
                        <label class="block text-gray-700 font-medium text-xs uppercase tracking-wider">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <input type="password" name="password" required id="password"
                                   class="input-glow w-full pl-10 pr-10 py-3 rounded-lg border-2 border-gray-200 focus:border-purple-500 focus:outline-none transition-all duration-300 bg-white/80 backdrop-blur-sm text-sm"
                                   placeholder="Enter your password">
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg id="eye-icon" class="h-4 w-4 text-gray-400 hover:text-gray-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between text-xs">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                            <span class="ml-2 text-gray-600">Remember me</span>
                        </label>
                        <a href="#" class="text-purple-600 hover:text-purple-800 font-medium transition-colors duration-200">
                            Forgot password?
                        </a>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" 
                            class="group w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-4 focus:ring-purple-300 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-lg text-sm">
                        <span class="flex items-center justify-center">
                            Sign In to Your Account
                            <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </span>
                    </button>

                    <hr>

                    <a href="login.php">Login as Google</a>
                </form>

                <!-- Register Link -->
                <div class="mt-6 text-center">
                    <p class="text-gray-600 mb-3 text-sm">Don't have an account yet?</p>
                    <a href="register.php">
                        <button type="button" 
                                class="w-full bg-white/60 backdrop-blur-sm border-2 border-purple-200 text-purple-700 font-bold py-3 px-4 rounded-lg hover:bg-white/80 hover:border-purple-300 hover:shadow-md transition-all duration-300 transform hover:scale-[1.02] text-sm">
                            Create New Account
                        </button>
                    </a>
                </div>
            </div>

            <!-- Footer Links -->
            <div class="mt-4 text-center animate-fade-in" style="animation-delay: 0.4s;">
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

        // Form animation on load
        window.addEventListener('load', function() {
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input');
            
            inputs.forEach((input, index) => {
                input.style.animationDelay = `${0.1 * index}s`;
                input.classList.add('animate-slide-up');
            });
        });

        // Enhanced input focus effects
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('scale-105');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('scale-105');
            });
        });
    </script>

</body>
</html>   