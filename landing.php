<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HAWAK KAMAY - Empowering Dreams Through Education</title>
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
                    },
                    backgroundImage: {
                        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                        'gradient-conic': 'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
                        'mesh-gradient': 'linear-gradient(45deg, #667eea 0%, #764ba2 100%)',
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
            from { box-shadow: 0 0 20px #3b82f6; }
            to { box-shadow: 0 0 30px #3b82f6, 0 0 40px #3b82f6; }
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
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .mesh-bg {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
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
    </style>
</head>
<body class="font-sans antialiased overflow-x-hidden">

    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 glass transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <!-- <div class="w-10 h-10 bg-gradient-to-r from-purple-600 to-blue-600 rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-lg">HK</span>
                    </div> -->
                    <span class="text-white font-bold text-xl">HAWAK KAMAY</span>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-white/80 hover:text-white transition-colors duration-200 font-medium">Home</a>
                    <a href="#about" class="text-white/80 hover:text-white transition-colors duration-200 font-medium">About</a>
                    <a href="#features" class="text-white/80 hover:text-white transition-colors duration-200 font-medium">Features</a>
                    <a href="#testimonials" class="text-white/80 hover:text-white transition-colors duration-200 font-medium">Success</a>
                    <a href="#contact" class="text-white/80 hover:text-white transition-colors duration-200 font-medium">Contact</a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="Auth/login.php" class="px-6 py-2 text-white/90 hover:text-white transition-colors duration-200 font-medium">Login</a>
                    <a href="Auth/register.php" class="px-6 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-medium rounded-full hover:shadow-lg hover:shadow-purple-500/25 transition-all duration-200">Get Started</a>
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
                        Empowering
                        <span class="block bg-gradient-to-r from-yellow-400 via-pink-500 to-purple-600 bg-clip-text text-transparent">
                            Dreams
                        </span>
                        Through Education
                    </h1>
                </div>
                
                <div class="animate-fade-in" style="animation-delay: 0.3s;">
                    <p class="text-xl md:text-2xl text-white/90 mb-12 max-w-4xl mx-auto leading-relaxed">
                        Your pathway to scholarships and academic support. We're here to help you achieve your educational goals with cutting-edge technology and personalized assistance.
                    </p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center animate-fade-in" style="animation-delay: 0.6s;">
                    <a href="Auth/register.php" class="group px-8 py-4 bg-white text-purple-900 font-bold text-lg rounded-full hover:shadow-2xl hover:shadow-white/25 transition-all duration-300 transform hover:scale-105">
                        <span class="flex items-center">
                            Apply Now
                            <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </span>
                    </a>
                    <a href="#about" class="px-8 py-4 border-2 border-white/30 text-white font-bold text-lg rounded-full hover:bg-white/10 hover:border-white/50 transition-all duration-300">
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
                <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-purple-50 to-blue-50 border border-purple-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="text-5xl font-black bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent mb-4">500+</div>
                    <div class="text-gray-600 font-semibold text-lg">Scholarships Awarded</div>
                    <div class="mt-2 text-sm text-gray-500">And counting every month</div>
                </div>
                <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-green-50 to-emerald-50 border border-green-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="text-5xl font-black bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-4">95%</div>
                    <div class="text-gray-600 font-semibold text-lg">Success Rate</div>
                    <div class="mt-2 text-sm text-gray-500">Industry-leading approval rate</div>
                </div>
                <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-orange-50 to-red-50 border border-orange-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="text-5xl font-black bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent mb-4">₱5M+</div>
                    <div class="text-gray-600 font-semibold text-lg">Financial Aid Distributed</div>
                    <div class="mt-2 text-sm text-gray-500">Supporting Filipino students</div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-gradient-to-br from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">
                    About <span class="gradient-text">HAWAK KAMAY</span>
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-purple-600 to-blue-600 mx-auto mb-8"></div>
                <p class="text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed">
                    The HAWAK KAMAY Scholarship Program System is dedicated to revolutionizing how students access scholarships and educational resources through innovative technology and personalized support.
                </p>
            </div>
            
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-8">
                    <div class="glass p-8 rounded-2xl border border-white/20">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                            <span class="w-3 h-3 bg-purple-600 rounded-full mr-3"></span>
                            Our Mission
                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            To provide equal opportunities for education by connecting deserving students with financial support and resources 
                            that enable them to pursue their academic dreams without financial constraints.
                        </p>
                    </div>
                    
                    <div class="glass p-8 rounded-2xl border border-white/20">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                            <span class="w-3 h-3 bg-blue-600 rounded-full mr-3"></span>
                            Our Vision
                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            We envision a future where every talented and motivated student has access to quality education regardless of 
                            their financial background, creating a more educated and empowered society.
                        </p>
                    </div>
                </div>
                
                <div class="bg-white p-10 rounded-3xl shadow-2xl border border-gray-100">
                    <h3 class="text-3xl font-bold text-gray-900 mb-8 text-center">Why Choose Us?</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-start p-4 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                            <div class="bg-gradient-to-r from-purple-600 to-blue-600 p-3 rounded-xl mr-4 flex-shrink-0">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg mb-2">Bank-Level Security</h4>
                                <p class="text-gray-600">Your data is protected with military-grade encryption and security protocols.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start p-4 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                            <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-3 rounded-xl mr-4 flex-shrink-0">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg mb-2">Lightning Fast Processing</h4>
                                <p class="text-gray-600">AI-powered application processing with response times under 48 hours.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start p-4 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                            <div class="bg-gradient-to-r from-orange-500 to-red-500 p-3 rounded-xl mr-4 flex-shrink-0">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg mb-2">24/7 Expert Support</h4>
                                <p class="text-gray-600">Dedicated team of education specialists ready to guide your journey.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-50 to-blue-50 opacity-50"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">How It Works</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-purple-600 to-blue-600 mx-auto mb-8"></div>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Our revolutionary 3-step process makes applying for scholarships easier and faster than ever before
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="group relative">
                    <div class="bg-white p-10 rounded-3xl shadow-lg border border-gray-100 text-center hover:shadow-2xl transition-all duration-500 transform group-hover:-translate-y-4">
                        <div class="relative mb-8">
                            <div class="w-20 h-20 bg-gradient-to-r from-purple-600 to-blue-600 rounded-2xl flex items-center justify-center text-white text-3xl font-black mx-auto group-hover:animate-glow">1</div>
                            <div class="absolute -top-2 -right-2 w-6 h-6 bg-yellow-400 rounded-full animate-pulse"></div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Create Your Profile</h3>
                        <p class="text-gray-600 leading-relaxed">Sign up in seconds and complete your comprehensive academic profile with AI-assisted guidance.</p>
                    </div>
                </div>
                
                <div class="group relative">
                    <div class="bg-white p-10 rounded-3xl shadow-lg border border-gray-100 text-center hover:shadow-2xl transition-all duration-500 transform group-hover:-translate-y-4">
                        <div class="relative mb-8">
                            <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center text-white text-3xl font-black mx-auto group-hover:animate-glow">2</div>
                            <div class="absolute -top-2 -right-2 w-6 h-6 bg-yellow-400 rounded-full animate-pulse"></div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Smart Matching</h3>
                        <p class="text-gray-600 leading-relaxed">Our AI algorithm automatically matches you with scholarships that fit your profile and goals perfectly.</p>
                    </div>
                </div>
                
                <div class="group relative">
                    <div class="bg-white p-10 rounded-3xl shadow-lg border border-gray-100 text-center hover:shadow-2xl transition-all duration-500 transform group-hover:-translate-y-4">
                        <div class="relative mb-8">
                            <div class="w-20 h-20 bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl flex items-center justify-center text-white text-3xl font-black mx-auto group-hover:animate-glow">3</div>
                            <div class="absolute -top-2 -right-2 w-6 h-6 bg-yellow-400 rounded-full animate-pulse"></div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Apply & Win</h3>
                        <p class="text-gray-600 leading-relaxed">Submit applications with one click and track progress through your personalized dashboard in real-time.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-20 bg-gradient-to-br from-gray-900 via-purple-900 to-blue-900 text-white relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-20 left-10 w-64 h-64 bg-purple-600/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black mb-6">Success Stories</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-yellow-400 to-pink-500 mx-auto mb-8"></div>
                <p class="text-xl text-purple-200 max-w-3xl mx-auto">
                    Real students, real dreams achieved. Join thousands who've transformed their futures
                </p>
            </div>
            
            <div class="grid lg:grid-cols-2 gap-8">
                <div class="glass p-8 rounded-3xl border border-white/20 hover:border-white/40 transition-all duration-300">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-r from-pink-500 to-purple-600 rounded-2xl flex items-center justify-center text-white font-bold text-xl mr-6">MJ</div>
                        <div>
                            <h4 class="font-bold text-xl">Maria Johnson</h4>
                            <p class="text-purple-300">Computer Science • University of Iloilo</p>
                            <div class="flex mt-2">
                                <span class="text-yellow-400">★★★★★</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-purple-100 italic leading-relaxed text-lg">
                        "HAWAK KAMAY didn't just give me a scholarship – they gave me a future. The platform's AI matched me with 3 scholarships I never would have found. Now I'm graduating debt-free with a job at Google!"
                    </p>
                </div>
                
                <div class="glass p-8 rounded-3xl border border-white/20 hover:border-white/40 transition-all duration-300">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-teal-600 rounded-2xl flex items-center justify-center text-white font-bold text-xl mr-6">JD</div>
                        <div>
                            <h4 class="font-bold text-xl">John Dela Cruz</h4>
                            <p class="text-purple-300">Business Administration • University of Iloilo</p>
                            <div class="flex mt-2">
                                <span class="text-yellow-400">★★★★★</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-purple-100 italic leading-relaxed text-lg">
                        "I was ready to give up on college until I found HAWAK KAMAY. Within 2 weeks, I had a full scholarship. The support team guided me through everything. Now I'm class valedictorian!"
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-purple-600 via-blue-600 to-teal-600 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-4xl md:text-6xl font-black mb-8">Ready to Transform Your Future?</h2>
            <p class="text-2xl mb-12 max-w-4xl mx-auto text-purple-100 leading-relaxed">
                Join over 10,000 students who have already secured their education funding through our platform
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <a href="Auth/register.php" class="group px-10 py-5 bg-white text-purple-900 font-bold text-xl rounded-full hover:shadow-2xl hover:shadow-white/25 transition-all duration-300 transform hover:scale-105">
                    <span class="flex items-center justify-center">
                        Start Your Journey
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
                <div class="text-sm">🏆 Award-winning Platform</div>
                <div class="text-sm">🔒 Bank-level Security</div>
                <div class="text-sm">⚡ 48hr Processing</div>
                <div class="text-sm">🎯 95% Success Rate</div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-r from-purple-600 to-blue-600 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold text-xl">HK</span>
                        </div>
                        <span class="text-2xl font-bold">HAWAK KAMAY</span>
                    </div>
                    <p class="text-gray-400 mb-6 text-lg leading-relaxed max-w-md">
                        Empowering Filipino students through accessible education and innovative scholarship matching technology.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-12 h-12 bg-gray-800 rounded-xl flex items-center justify-center text-gray-400 hover:text-white hover:bg-blue-600 transition-all duration-200">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-12 h-12 bg-gray-800 rounded-xl flex items-center justify-center text-gray-400 hover:text-white hover:bg-blue-500 transition-all duration-200">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                            </svg>
                        </a>
                        <a href="#" class="w-12 h-12 bg-gray-800 rounded-xl flex items-center justify-center text-gray-400 hover:text-white hover:bg-red-500 transition-all duration-200">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.750.099.120.112.226.085.348-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001 12.017.001z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-12 h-12 bg-gray-800 rounded-xl flex items-center justify-center text-gray-400 hover:text-white hover:bg-blue-600 transition-all duration-200">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="font-bold text-lg mb-6 text-white">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="#home" class="text-gray-400 hover:text-white transition-colors duration-200 flex items-center">
                            <span class="w-2 h-2 bg-purple-500 rounded-full mr-3"></span>Home
                        </a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white transition-colors duration-200 flex items-center">
                            <span class="w-2 h-2 bg-purple-500 rounded-full mr-3"></span>About Us
                        </a></li>
                        <li><a href="#features" class="text-gray-400 hover:text-white transition-colors duration-200 flex items-center">
                            <span class="w-2 h-2 bg-purple-500 rounded-full mr-3"></span>How It Works
                        </a></li>
                        <li><a href="#testimonials" class="text-gray-400 hover:text-white transition-colors duration-200 flex items-center">
                            <span class="w-2 h-2 bg-purple-500 rounded-full mr-3"></span>Success Stories
                        </a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold text-lg mb-6 text-white">Resources</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-200 flex items-center">
                            <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>FAQ
                        </a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-200 flex items-center">
                            <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>Blog
                        </a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-200 flex items-center">
                            <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>Scholarship Guide
                        </a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-200 flex items-center">
                            <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>Application Tips
                        </a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-200 flex items-center">
                            <span class="w-2 h-2 bg-blue-500 rounded-full mr-3"></span>Contact Support
                        </a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-16 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-gray-400 text-center md:text-left mb-4 md:mb-0">
                        <p>&copy; 2025 HAWAK KAMAY Scholarship Program System. All Rights Reserved.</p>
                    </div>
                    <div class="flex space-x-6 text-sm">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">Privacy Policy</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">Terms of Service</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">Cookie Policy</a>
                    </div>
                </div>
                
                <!-- Contact Info -->
                <div class="mt-8 pt-8 border-t border-gray-800">
                    <div class="grid md:grid-cols-3 gap-6 text-center md:text-left">
                        <div class="flex items-center justify-center md:justify-start">
                            <svg class="h-5 w-5 text-purple-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-gray-400">Rizal St, Iloilo City Proper, Iloilo City, 5000 Iloilo</span>
                        </div>
                        <div class="flex items-center justify-center md:justify-start">
                            <svg class="h-5 w-5 text-purple-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-gray-400">info@hawakkamay.edu.ph</span>
                        </div>
                        <div class="flex items-center justify-center md:justify-start">
                            <svg class="h-5 w-5 text-purple-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span class="text-gray-400">+63 2 1234 5678</span>
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