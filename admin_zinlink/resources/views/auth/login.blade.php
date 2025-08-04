<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - zinlink tech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.3); }
            50% { box-shadow: 0 0 30px rgba(59, 130, 246, 0.6); }
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .floating { animation: float 3s ease-in-out infinite; }
        .pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }
        .slide-in { animation: slideIn 0.6s ease-out; }
        .gradient-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 25%, #3b82f6 50%, #1e40af 75%, #1e3a8a 100%);
            background-size: 400% 400%;
            animation: gradient-shift 8s ease infinite;
        }
        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
    </style>
</head>
<body class="min-h-screen gradient-bg flex items-center justify-center p-4">
    <!-- Animated Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-500/10 rounded-full floating"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-500/10 rounded-full floating" style="animation-delay: -1.5s;"></div>
        <div class="absolute top-1/2 left-1/4 w-60 h-60 bg-purple-500/10 rounded-full floating" style="animation-delay: -3s;"></div>
    </div>

    <div class="max-w-md w-full space-y-8 relative z-10 slide-in">
        <!-- Logo and Title -->
        <div class="text-center">
            <div class="mx-auto h-20 w-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mb-6 pulse-glow shadow-2xl">
                <i class="fas fa-laptop text-white text-3xl"></i>
            </div>
            <h2 class="text-4xl font-bold text-white mb-3 drop-shadow-lg">zinlink tech Admin</h2>
            <p class="text-blue-100 text-lg">Welcome back! Please sign in to continue</p>
        </div>
        
        <!-- Login Form Card -->
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-2xl p-8 border border-white/20">
            @if ($errors->any())
                <div class="mb-6 bg-red-500/20 border border-red-400/50 text-red-100 px-4 py-3 rounded-xl backdrop-blur-sm">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <span class="font-medium">Login failed</span>
                    </div>
                    <ul class="mt-2 text-sm">
                        @foreach ($errors->all() as $error)
                            <li class="flex items-center">
                                <i class="fas fa-times-circle mr-2 text-xs"></i>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                <!-- Email Field -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-semibold text-white/90">
                        Email Address
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-blue-300 group-focus-within:text-blue-400 transition-colors duration-300"></i>
                        </div>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            required 
                            value="{{ old('email') }}"
                            class="w-full pl-12 pr-4 py-4 bg-white/10 border border-white/20 rounded-xl text-white placeholder-blue-200/60 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-300 backdrop-blur-sm"
                            placeholder="Enter your email address"
                        >
                        <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-blue-500/20 to-indigo-500/20 opacity-0 group-focus-within:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                    </div>
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-semibold text-white/90">
                        Password
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-blue-300 group-focus-within:text-blue-400 transition-colors duration-300"></i>
                        </div>
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            required
                            class="w-full pl-12 pr-4 py-4 bg-white/10 border border-white/20 rounded-xl text-white placeholder-blue-200/60 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition-all duration-300 backdrop-blur-sm"
                            placeholder="Enter your password"
                        >
                        <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-blue-500/20 to-indigo-500/20 opacity-0 group-focus-within:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input 
                            id="remember" 
                            name="remember" 
                            type="checkbox" 
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-white/30 rounded bg-white/10"
                        >
                        <label for="remember" class="ml-3 block text-sm text-white/80">
                            Remember me
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button 
                        type="submit" 
                        class="group relative w-full flex justify-center py-4 px-6 border border-transparent text-lg font-semibold rounded-xl text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl"
                    >
                        <span class="absolute left-0 inset-y-0 flex items-center pl-4">
                            <i class="fas fa-sign-in-alt text-blue-200 group-hover:text-blue-100 transition-colors duration-300"></i>
                        </span>
                        <span class="flex items-center">
                            <span>Sign In</span>
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                        </span>
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Credentials Info -->
        <div class="text-center">
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                <p class="text-blue-100 text-sm font-medium mb-2">Default Admin Credentials</p>
                <div class="flex items-center justify-center space-x-4 text-xs">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-envelope text-blue-300"></i>
                        <span class="text-blue-200">admin@zinlinktech.com</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-key text-blue-300"></i>
                        <span class="text-blue-200">password</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center">
            <p class="text-blue-200/60 text-xs">
                Secure access to zinlink tech administration panel
            </p>
        </div>
    </div>
</body>
</html> 