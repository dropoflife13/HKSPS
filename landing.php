    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HAWAK KAMAY - Connecting Scholars & Faculty</title>
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
                        animation: {
                            'float': 'float 6s ease-in-out infinite',
                            'glow': 'glow 2s ease-in-out infinite alternate',
                            'slide-up': 'slideUp 0.8s ease-out',
                            'fade-in': 'fadeIn 1s ease-out',
                            'bounce-subtle': 'bounceSubtle 2s ease-in-out infinite',
                        },
                        backgroundImage: {
                            'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                            'gradient-conic': 'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
                        },
                    }
                }
            }
        </script>
        <style>
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
            }
            @keyframes glow {
                from { box-shadow: 0 0 20px #40916c; }
                to { box-shadow: 0 0 30px #40916c, 0 0 40px #40916c; }
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
            .scroll-indicator {
                position: absolute;
                bottom: 30px;
                left: 50%;
                transform: translateX(-50%);
                animation: bounceSubtle 2s ease-in-out infinite;
            }
            .feature-card {
                transition: all 0.3s ease;
            }
            .feature-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }
        </style>
    </head>
    <body class="font-sans antialiased overflow-x-hidden">

        <!-- Navigation -->
        <nav class="fixed top-0 w-full z-50 glass transition-all duration-300" id="navbar">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-3">
                        <span class="text-white font-bold text-xl">HAWAK KAMAY</span>
                    </div>
                    
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#home" class="text-white/80 hover:text-white transition-colors duration-200 font-medium">Home</a>
                        <a href="#about" class="text-white/80 hover:text-white transition-colors duration-200 font-medium">About</a>
                        <a href="#how-it-works" class="text-white/80 hover:text-white transition-colors duration-200 font-medium">How It Works</a>
                        <a href="#features" class="text-white/80 hover:text-white transition-colors duration-200 font-medium">Features</a>
                        <a href="#testimonials" class="text-white/80 hover:text-white transition-colors duration-200 font-medium">Testimonials</a>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <a href="Auth/login.php" class="px-6 py-2 text-white/90 hover:text-white transition-colors duration-200 font-medium">Login</a>
                        <a href="Auth/register.php" class="px-6 py-2 hk-gradient-bg text-white font-medium rounded-full hover:shadow-lg hover:shadow-green-500/25 transition-all duration-200">Get Started</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section id="home" class="min-h-screen mesh-bg relative flex items-center justify-center overflow-hidden">
            <!-- Floating Elements -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-20 left-10 w-32 h-32 bg-white/10 rounded-full animate-float"></div>
                <div class="absolute top-40 right-20 w-20 h-20 bg-white/10 rounded-full animate-float" style="animation-delay: -2s;"></div>
                <div class="absolute bottom-20 left-20 w-40 h-40 bg-white/10 rounded-full animate-float" style="animation-delay: -4s;"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center">
                    <div class="animate-slide-up">
                        <h1 class="text-5xl md:text-7xl font-black text-white mb-8 leading-tight">
                            Connecting
                            <span class="block bg-gradient-to-r from-hk-green-100 via-hk-green-300 to-hk-green-400 bg-clip-text text-transparent">
                                Scholars & Faculty
                            </span>
                            Through Service
                        </h1>
                    </div>
                    
                    <div class="animate-fade-in" style="animation-delay: 0.3s;">
                        <p class="text-xl md:text-2xl text-white/90 mb-12 max-w-4xl mx-auto leading-relaxed">
                            A centralized platform where scholars can find service opportunities and faculty can request assistance. Streamlining the process of fulfilling scholarship requirements while supporting academic activities.
                        </p>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-6 justify-center items-center animate-fade-in" style="animation-delay: 0.6s;">
                        <a href="Auth/register.php" class="group px-8 py-4 bg-white text-hk-green-700 font-bold text-lg rounded-full hover:shadow-2xl hover:shadow-white/25 transition-all duration-300 transform hover:scale-105">
                            <span class="flex items-center">
                                Join Now
                                <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </span>
                        </a>
                        <a href="#how-it-works" class="px-8 py-4 border-2 border-white/30 text-white font-bold text-lg rounded-full hover:bg-white/10 hover:border-white/50 transition-all duration-300">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Scroll Indicator -->
            <div class="scroll-indicator">
                <div class="w-6 h-10 border-2 border-white/50 rounded-full flex justify-center">
                    <div class="w-1 h-3 bg-white/70 rounded-full mt-2 animate-bounce"></div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-20 bg-white relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-hk-green-50 to-hk-green-100 border border-hk-green-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="text-5xl font-black hk-gradient-text mb-4">1,250+</div>
                        <div class="text-gray-600 font-semibold text-lg">Service Hours Completed</div>
                        <div class="mt-2 text-sm text-gray-500">This semester alone</div>
                    </div>
                    <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-hk-green-50 to-hk-green-100 border border-hk-green-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="text-5xl font-black hk-gradient-text mb-4">98%</div>
                        <div class="text-gray-600 font-semibold text-lg">Satisfaction Rate</div>
                        <div class="mt-2 text-sm text-gray-500">From both scholars and faculty</div>
                    </div>
                    <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-hk-green-50 to-hk-green-100 border border-hk-green-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="text-5xl font-black hk-gradient-text mb-4">200+</div>
                        <div class="text-gray-600 font-semibold text-lg">Active Faculty Users</div>
                        <div class="mt-2 text-sm text-gray-500">Requesting facilitator support</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-20 bg-gradient-to-br from-hk-green-50 to-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">
                        About <span class="hk-gradient-text">HAWAK KAMAY</span>
                    </h2>
                    <div class="w-24 h-1 hk-gradient-bg mx-auto mb-8"></div>
                    <p class="text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed">
                        The Hawak Kamay System is a web-based platform designed to simplify and improve the coordination between student scholars and faculty members, creating a seamless connection for service opportunities and academic support.
                    </p>
                </div>
                
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div class="space-y-8">
                        <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                            <h3 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                                <span class="w-3 h-3 bg-hk-green-600 rounded-full mr-3"></span>
                                Our Mission
                            </h3>
                            <p class="text-gray-600 leading-relaxed">
                                To create a centralized platform that efficiently connects scholars needing to complete service hours with faculty members requiring assistance, eliminating the traditional barriers of manual coordination.
                            </p>
                        </div>
                        
                        <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                            <h3 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                                <span class="w-3 h-3 bg-hk-green-500 rounded-full mr-3"></span>
                                Our Vision
                            </h3>
                            <p class="text-gray-600 leading-relaxed">
                                We envision an academic community where scholarship requirements are fulfilled seamlessly, faculty receive timely support, and the institution benefits from strengthened collaboration between students and teachers.
                            </p>
                        </div>
                    </div>
                    
                    <div class="bg-white p-10 rounded-3xl shadow-2xl border border-gray-100">
                        <h3 class="text-3xl font-bold text-gray-900 mb-8 text-center">Why Choose Us?</h3>
                        
                        <div class="space-y-6">
                            <div class="flex items-start p-4 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                                <div class="hk-gradient-bg p-3 rounded-xl mr-4 flex-shrink-0">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-lg mb-2">Streamlined Process</h4>
                                    <p class="text-gray-600">Eliminate the hassle of manual coordination and word-of-mouth requests.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start p-4 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                                <div class="hk-gradient-bg p-3 rounded-xl mr-4 flex-shrink-0">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-lg mb-2">Time Efficiency</h4>
                                    <p class="text-gray-600">Save valuable time for both scholars and faculty with our intuitive platform.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start p-4 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                                <div class="hk-gradient-bg p-3 rounded-xl mr-4 flex-shrink-0">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-lg mb-2">Transparent Tracking</h4>
                                    <p class="text-gray-600">Real-time monitoring of service hours and completed assignments.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 bg-white relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-hk-green-50 to-hk-green-100 opacity-50"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">How It Works</h2>
                <div class="w-24 h-1 hk-gradient-bg mx-auto mb-8"></div>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Our simple 3-step process connects scholars with faculty needing assistance
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="group relative">
                    <div class="bg-white p-10 rounded-3xl border border-gray-100 text-center transition-all duration-500 transform group-hover:-translate-y-4 
                            shadow-[0_10px_30px_rgba(0,0,0,0.05)] hover:shadow-[0_25px_50px_-12px_rgba(25,100,70,0.25)]
                            outline outline-2 outline-transparent hover:outline-hk-green-300/50 cursor-pointer">
                        <div class="relative mb-8">
                            <div class="w-20 h-20 hk-gradient-bg rounded-2xl flex items-center justify-center text-white text-3xl font-black mx-auto group-hover:animate-glow 
                                    shadow-[0_10px_20px_rgba(25,100,70,0.3)] group-hover:scale-110 transition-transform duration-300">1</div>
                            <div class="absolute -top-2 -right-2 w-6 h-6 bg-hk-green-400 rounded-full animate-pulse 
                                    shadow-[0_0_15px_rgba(25,100,70,0.5)]"></div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-hk-green-700 transition-colors duration-300">Faculty Post Requests</h3>
                        <p class="text-gray-600 leading-relaxed group-hover:text-gray-700 transition-colors duration-300">Teachers post requests for facilitators when they need assistance with classroom management</p>
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="text-xs text-hk-green-500 font-medium">Click to learn more</span>
                        </div>
                    </div>
                </div>
                
                <div class="group relative">
                    <div class="bg-white p-10 rounded-3xl border border-gray-100 text-center transition-all duration-500 transform group-hover:-translate-y-4 
                            shadow-[0_10px_30px_rgba(0,0,0,0.05)] hover:shadow-[0_25px_50px_-12px_rgba(25,100,70,0.25)]
                            outline outline-2 outline-transparent hover:outline-hk-green-300/50 cursor-pointer">
                        <div class="relative mb-8">
                            <div class="w-20 h-20 hk-gradient-bg rounded-2xl flex items-center justify-center text-white text-3xl font-black mx-auto group-hover:animate-glow 
                                    shadow-[0_10px_20px_rgba(25,100,70,0.3)] group-hover:scale-110 transition-transform duration-300">2</div>
                            <div class="absolute -top-2 -right-2 w-6 h-6 bg-hk-green-400 rounded-full animate-pulse 
                                    shadow-[0_0_15px_rgba(25,100,70,0.5)]"></div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-hk-green-700 transition-colors duration-300">Scholars Apply</h3>
                        <p class="text-gray-600 leading-relaxed group-hover:text-gray-700 transition-colors duration-300">Scholars browse available opportunities and apply for tasks that match their skills, interests, and schedule.</p>
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="text-xs text-hk-green-500 font-medium">Click to learn more</span>
                        </div>
                    </div>
                </div>
                
                <div class="group relative">
                    <div class="bg-white p-10 rounded-3xl border border-gray-100 text-center transition-all duration-500 transform group-hover:-translate-y-4 
                            shadow-[0_10px_30px_rgba(0,0,0,0.05)] hover:shadow-[0_25px_50px_-12px_rgba(25,100,70,0.25)]
                            outline outline-2 outline-transparent hover:outline-hk-green-300/50 cursor-pointer">
                        <div class="relative mb-8">
                            <div class="w-20 h-20 hk-gradient-bg rounded-2xl flex items-center justify-center text-white text-3xl font-black mx-auto group-hover:animate-glow 
                                    shadow-[0_10px_20px_rgba(25,100,70,0.3)] group-hover:scale-110 transition-transform duration-300">3</div>
                            <div class="absolute -top-2 -right-2 w-6 h-6 bg-hk-green-400 rounded-full animate-pulse 
                                    shadow-[0_0_15px_rgba(25,100,70,0.5)]"></div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-hk-green-700 transition-colors duration-300">Connect & Track</h3>
                        <p class="text-gray-600 leading-relaxed group-hover:text-gray-700 transition-colors duration-300">Faculty confirm assignments, scholars complete the duties, and the system automatically tracks service hours.</p>
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span class="text-xs text-hk-green-500 font-medium">Click to learn more</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
        <!-- Features Section -->
        <section id="features" class="py-20 bg-gradient-to-br from-hk-green-50 to-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">Key Features</h2>
                    <div class="w-24 h-1 hk-gradient-bg mx-auto mb-8"></div>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Designed to streamline the process of connecting scholars with service opportunities
                    </p>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="feature-card bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                        <div class="w-16 h-16 hk-gradient-bg rounded-2xl flex items-center justify-center text-white mb-6">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Centralized Portal</h3>
                        <p class="text-gray-600">One platform where scholars and teachers can connect for service opportunities.</p>
                    </div>
                    
                    <div class="feature-card bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                        <div class="w-16 h-16 hk-gradient-bg rounded-2xl flex items-center justify-center text-white mb-6">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Real-Time Updates</h3>
                        <p class="text-gray-600">Immediate posting and confirmation of duties with instant notifications.</p>
                    </div>
                    
                    <div class="feature-card bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                        <div class="w-16 h-16 hk-gradient-bg rounded-2xl flex items-center justify-center text-white mb-6">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Service Hour Tracking</h3>
                        <p class="text-gray-600">Automatic recording of completed hours for accountability and reporting.</p>
                    </div>
                    
                    <div class="feature-card bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                        <div class="w-16 h-16 hk-gradient-bg rounded-2xl flex items-center justify-center text-white mb-6">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">User-Friendly Interface</h3>
                        <p class="text-gray-600">Intuitive design accessible for both first-time users and experienced members.</p>
                    </div>
                    
                    <div class="feature-card bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                        <div class="w-16 h-16 hk-gradient-bg rounded-2xl flex items-center justify-center text-white mb-6">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Transparency & Records</h3>
                        <p class="text-gray-600">Clear documentation of assigned duties and fulfilled requirements.</p>
                    </div>
                    
                    <div class="feature-card bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                        <div class="w-16 h-16 hk-gradient-bg rounded-2xl flex items-center justify-center text-white mb-6">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Community Building</h3>
                        <p class="text-gray-600">Fosters stronger relationships between students, faculty, and the institution.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section id="testimonials" class="py-20 bg-gradient-to-br from-hk-green-400 via-hk-green-500 to-hk-green-600 text-white relative overflow-hidden">
            <div class="absolute inset-0">
                <div class="absolute top-20 left-10 w-64 h-64 bg-hk-green-500/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-20 right-10 w-96 h-96 bg-hk-green-400/20 rounded-full blur-3xl"></div>
            </div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-black mb-6">Success Stories</h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-hk-green-100 to-hk-green-300 mx-auto mb-8"></div>
                    <p class="text-xl text-hk-green-200 max-w-3xl mx-auto">
                        Real experiences from scholars and faculty using our platform
                    </p>
                </div>
                
                <div class="grid lg:grid-cols-2 gap-8">
                    <div class="glass p-8 rounded-3xl border border-white/20 hover:border-white/40 transition-all duration-300">
                        <div class="flex items-center mb-6">
                            <div class="w-16 h-16 bg-gradient-to-r from-hk-green-400 to-hk-green-600 rounded-2xl flex items-center justify-center text-white font-bold text-xl mr-6">MJ</div>
                            <div>
                                <h4 class="font-bold text-xl">Maria Johnson</h4>
                                <p class="text-hk-green-300">Biology Scholar • University of Iloilo</p>
                                <div class="flex mt-2">
                                    <span class="text-hk-green-100">★★★★★</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-hk-green-100 italic leading-relaxed text-lg">
                            "Hawak Kamay made fulfilling my scholarship requirements so much easier! I can now find service opportunities that actually match my schedule and interests, instead of relying on random requests from professors."
                        </p>
                    </div>
                    
                    <div class="glass p-8 rounded-3xl border border-white/20 hover:border-white/40 transition-all duration-300">
                        <div class="flex items-center mb-6">
                            <div class="w-16 h-16 bg-gradient-to-r from-hk-green-400 to-hk-green-600 rounded-2xl flex items-center justify-center text-white font-bold text-xl mr-6">PR</div>
                            <div>
                                <h4 class="font-bold text-xl">Prof. Rodriguez</h4>
                                <p class="text-hk-green-300">College of Education</p>
                                <div class="flex mt-2">
                                    <span class="text-hk-green-100">★★★★★</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-hk-green-100 italic leading-relaxed text-lg">
                            "As a faculty member, finding student facilitators used to be a time-consuming process. With Hawak Kamay, I can post my needs and have qualified scholars apply within hours. It's revolutionized how I manage classroom assistance!"
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 hk-gradient-bg text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <h2 class="text-4xl md:text-6xl font-black mb-8">Ready to Transform Your Experience?</h2>
                <p class="text-2xl mb-12 max-w-4xl mx-auto text-hk-green-100 leading-relaxed">
                    Join hundreds of scholars and faculty who have already benefited from our platform
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-6">
                    <a href="Auth/register.php" class="group px-10 py-5 bg-white text-hk-green-700 font-bold text-xl rounded-full hover:shadow-2xl hover:shadow-white/25 transition-all duration-300 transform hover:scale-105">
                        <span class="flex items-center justify-center">
                            Get Started Now
                            <svg class="ml-3 w-6 h-6 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </span>
                    </a>
                    <a href="#about" class="px-10 py-5 border-2 border-white/50 text-white font-bold text-xl rounded-full hover:bg-white/10 hover:border-white transition-all duration-300">
                        Learn More
                    </a>
                </div>
                
                <!-- Trust Indicators -->
                <div class="mt-16 flex flex-wrap justify-center items-center gap-8 opacity-70">
                    <div class="text-sm">🏆 Streamlined Process</div>
                    <div class="text-sm">🔒 Secure Platform</div>
                    <div class="text-sm">⚡ Real-Time Updates</div>
                    <div class="text-sm">🎯 98% Satisfaction Rate</div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-hk-green-900 text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-4 gap-8">
                    <div class="md:col-span-2">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="w-12 h-12 hk-gradient-bg rounded-xl flex items-center justify-center">
                                <span class="text-white font-bold text-xl">HK</span>
                            </div>
                            <span class="text-2xl font-bold">HAWAK KAMAY</span>
                        </div>
                        <p class="text-hk-green-300 mb-6 text-lg leading-relaxed max-w-md">
                            Empowering scholars and faculty through efficient service coordination and academic support.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="w-12 h-12 bg-hk-green-800 rounded-xl flex items-center justify-center text-hk-green-400 hover:text-white hover:bg-hk-green-600 transition-all duration-200">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-12 h-12 bg-hk-green-800 rounded-xl flex items-center justify-center text-hk-green-400 hover:text-white hover:bg-hk-green-600 transition-all duration-200">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                                </svg>
                            </a>
                            <a href="#" class="w-12 h-12 bg-hk-green-800 rounded-xl flex items-center justify-center text-hk-green-400 hover:text-white hover:bg-hk-green-600 transition-all duration-200">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.750.099.120.112.226.085.348-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.920-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001 12.017.001z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-12 h-12 bg-hk-green-800 rounded-xl flex items-center justify-center text-hk-green-400 hover:text-white hover:bg-hk-green-600 transition-all duration-200">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.370-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.920-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="font-bold text-lg mb-6 text-white">Quick Links</h4>
                        <ul class="space-y-3">
                            <li><a href="#home" class="text-hk-green-300 hover:text-white transition-colors duration-200 flex items-center">
                                <span class="w-2 h-2 bg-hk-green-400 rounded-full mr-3"></span>Home
                            </a></li>
                            <li><a href="#about" class="text-hk-green-300 hover:text-white transition-colors duration-200 flex items-center">
                                <span class="w-2 h-2 bg-hk-green-400 rounded-full mr-3"></span>About Us
                            </a></li>
                            <li><a href="#how-it-works" class="text-hk-green-300 hover:text-white transition-colors duration-200 flex items-center">
                                <span class="w-2 h-2 bg-hk-green-400 rounded-full mr-3"></span>How It Works
                            </a></li>
                            <li><a href="#features" class="text-hk-green-300 hover:text-white transition-colors duration-200 flex items-center">
                                <span class="w-2 h-2 bg-hk-green-400 rounded-full mr-3"></span>Features
                            </a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="font-bold text-lg mb-6 text-white">Resources</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-hk-green-300 hover:text-white transition-colors duration-200 flex items-center">
                                <span class="w-2 h-2 bg-hk-green-400 rounded-full mr-3"></span>FAQ
                            </a></li>
                            <li><a href="#" class="text-hk-green-300 hover:text-white transition-colors duration-200 flex items-center">
                                <span class="w-2 h-2 bg-hk-green-400 rounded-full mr-3"></span>Scholar Guide
                            </a></li>
                            <li><a href="#" class="text-hk-green-300 hover:text-white transition-colors duration-200 flex items-center">
                                <span class="w-2 h-2 bg-hk-green-400 rounded-full mr-3"></span>Faculty Guide
                            </a></li>
                            <li><a href="#" class="text-hk-green-300 hover:text-white transition-colors duration-200 flex items-center">
                                <span class="w-2 h-2 bg-hk-green-400 rounded-full mr-3"></span>Contact Support
                            </a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="border-t border-hk-green-800 mt-16 pt-8">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="text-hk-green-300 text-center md:text-left mb-4 md:mb-0">
                            <p>&copy; 2025 HAWAK KAMAY Scholarship Program System. All Rights Reserved.</p>
                        </div>
                        <div class="flex space-x-6 text-sm">
                            <a href="#" class="text-hk-green-300 hover:text-white transition-colors duration-200">Privacy Policy</a>
                            <a href="#" class="text-hk-green-300 hover:text-white transition-colors duration-200">Terms of Service</a>
                            <a href="#" class="text-hk-green-300 hover:text-white transition-colors duration-200">Cookie Policy</a>
                        </div>
                    </div>
                    
                    <!-- Contact Info -->
                    <div class="mt-8 pt-8 border-t border-hk-green-800">
                        <div class="grid md:grid-cols-3 gap-6 text-center md:text-left">
                            <div class="flex items-center justify-center md:justify-start">
                                <svg class="h-5 w-5 text-hk-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="text-hk-green-300">Rizal St, Iloilo City Proper, Iloilo City, 5000 Iloilo</span>
                            </div>
                            <div class="flex items-center justify-center md:justify-start">
                                <svg class="h-5 w-5 text-hk-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-hk-green-300">info@hawakkamay.edu.ph</span>
                            </div>
                            <div class="flex items-center justify-center md:justify-start">
                                <svg class="h-5 w-5 text-hk-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span class="text-hk-green-300">+63 2 1234 5678</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <script>
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            window.addEventListener('scroll', function() {
                const navbar = document.getElementById('navbar');
                if (window.scrollY > 100) {
                    navbar.classList.add('bg-black/80');
                    navbar.classList.remove('glass');
                } else {
                    navbar.classList.remove('bg-black/80');
                    navbar.classList.add('glass');
                }
            });

            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-slide-up');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('section').forEach(section => {
                observer.observe(section);
            });

            window.addEventListener('load', function() {
                document.body.classList.add('loaded');
            });
        </script>

    </body>
    </html>