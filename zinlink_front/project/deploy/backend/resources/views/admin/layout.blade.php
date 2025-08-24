<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'zinlink tech Admin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-900">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen">
        <!-- Sidebar - Fixed and Stable -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-800 shadow-lg lg:translate-x-0 transition-transform duration-300 ease-in-out" 
             :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <div class="flex items-center justify-between h-16 px-6 border-b border-gray-700">
                <h1 class="text-2xl font-extrabold bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 bg-clip-text text-transparent drop-shadow-lg tracking-tight font-display">
  <span style="padding-right:0.25rem;">zinlink</span><span style="background:rgba(0,0,0,0.3);color:white;padding:0.125rem 0.5rem;border-radius:0.375rem;margin-left:0.25rem;box-shadow:0 2px 8px rgba(0,0,0,0.15);">tech Admin</span>
</h1>
                <button @click="sidebarOpen = false" class="lg:hidden p-1 rounded-md hover:bg-gray-700">
                    <i class="fas fa-times text-gray-300"></i>
                </button>
            </div>
            
            <nav class="mt-6 overflow-y-auto h-full pb-20">
                <div class="px-4 space-y-2">
                    <!-- Main Navigation -->
                    <div class="mb-6">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-2">Main</h3>
                        
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : '' }}">
                            <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                            Dashboard
                        </a>
                        
                        <a href="{{ route('admin.products') }}" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.products*') ? 'bg-gray-700 text-white' : '' }}">
                            <i class="fas fa-box w-5 h-5 mr-3"></i>
                            Products
                        </a>
                        
                        <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-green-900 hover:text-green-200 transition-colors duration-200">
    <i class="fas fa-shopping-cart w-5 h-5 mr-3"></i>
    Orders
</a>
                        
                        <a href="{{ route('admin.statistics') }}" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.statistics') ? 'bg-gray-700 text-white' : '' }}">
                            <i class="fas fa-chart-bar w-5 h-5 mr-3"></i>
                            Statistics
                        </a>
                        
                        <a href="{{ route('admin.reviews.index') }}" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.reviews*') ? 'bg-gray-700 text-white' : '' }}">
                            <i class="fas fa-star w-5 h-5 mr-3"></i>
                            Reviews
                        </a>
                    </div>

                    <!-- Inventory Management -->
                    <div class="mb-6">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-2">Inventory</h3>
                        
                        <a href="{{ route('admin.products') }}?stock_status=low_stock" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-yellow-900 hover:text-yellow-200 transition-colors duration-200">
                            <i class="fas fa-exclamation-triangle w-5 h-5 mr-3"></i>
                            Low Stock
                        </a>
                        
                        <a href="{{ route('admin.products') }}?stock_status=out_of_stock" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-red-900 hover:text-red-200 transition-colors duration-200">
                            <i class="fas fa-times-circle w-5 h-5 mr-3"></i>
                            Out of Stock
                        </a>
                        
                        <a href="{{ route('admin.products.create') }}" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-green-900 hover:text-green-200 transition-colors duration-200">
                            <i class="fas fa-plus w-5 h-5 mr-3"></i>
                            Add Product
                        </a>
                    </div>

                    <!-- Categories & Brands -->
                    <div class="mb-6">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-2">Categories</h3>
                        
                        <a href="{{ route('admin.products') }}?category=laptop" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-blue-900 hover:text-blue-200 transition-colors duration-200">
                            <i class="fas fa-laptop w-5 h-5 mr-3"></i>
                            Laptops
                        </a>
                        
                        <a href="{{ route('admin.products') }}?category=gaming-laptop" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-purple-900 hover:text-purple-200 transition-colors duration-200">
                            <i class="fas fa-gamepad w-5 h-5 mr-3"></i>
                            Gaming Laptops
                        </a>
                        
                        <a href="{{ route('admin.products') }}?category=business-laptop" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-indigo-900 hover:text-indigo-200 transition-colors duration-200">
                            <i class="fas fa-briefcase w-5 h-5 mr-3"></i>
                            Business Laptops
                        </a>
                    </div>

                    <!-- Popular Brands -->
                    <div class="mb-6">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-2">Brands</h3>
                        
                        <a href="{{ route('admin.products') }}?brand=Apple" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-gray-200 transition-colors duration-200">
                            <i class="fab fa-apple w-5 h-5 mr-3"></i>
                            Apple
                        </a>
                        
                        <a href="{{ route('admin.products') }}?brand=Dell" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-blue-900 hover:text-blue-200 transition-colors duration-200">
                            <i class="fas fa-desktop w-5 h-5 mr-3"></i>
                            Dell
                        </a>
                        
                        <a href="{{ route('admin.products') }}?brand=HP" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-red-900 hover:text-red-200 transition-colors duration-200">
                            <i class="fas fa-desktop w-5 h-5 mr-3"></i>
                            HP
                        </a>
                        
                        <a href="{{ route('admin.products') }}?brand=Lenovo" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-blue-900 hover:text-blue-200 transition-colors duration-200">
                            <i class="fas fa-desktop w-5 h-5 mr-3"></i>
                            Lenovo
                        </a>
                        
                        <a href="{{ route('admin.products') }}?brand=ASUS" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-orange-900 hover:text-orange-200 transition-colors duration-200">
                            <i class="fas fa-desktop w-5 h-5 mr-3"></i>
                            ASUS
                        </a>
                    </div>

                    <!-- Reports & Analytics -->
                    <div class="mb-6">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-2">Reports</h3>
                        
                        <a href="{{ route('admin.statistics') }}" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-green-900 hover:text-green-200 transition-colors duration-200">
                            <i class="fas fa-chart-line w-5 h-5 mr-3"></i>
                            Sales Analytics
                        </a>
                        
                        <a href="{{ route('admin.statistics') }}" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-blue-900 hover:text-blue-200 transition-colors duration-200">
                            <i class="fas fa-chart-pie w-5 h-5 mr-3"></i>
                            Inventory Report
                        </a>
                        
                        <a href="{{ route('admin.statistics') }}" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-purple-900 hover:text-purple-200 transition-colors duration-200">
                            <i class="fas fa-chart-area w-5 h-5 mr-3"></i>
                            Performance
                        </a>
                    </div>

                    <!-- Settings & Tools -->
                    <div class="mb-6">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-2">Settings</h3>
                        
                        <a href="{{ route('admin.features.index') }}" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.features*') ? 'bg-gray-700 text-white' : '' }}">
                            <i class="fas fa-cog w-5 h-5 mr-3"></i>
                            General Settings
                        </a>
                        
                        <a href="{{ route('admin.team.index') }}" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.team*') ? 'bg-gray-700 text-white' : '' }}">
                            <i class="fas fa-users w-5 h-5 mr-3"></i>
                            Team
                        </a>
                        
                        <a href="{{ route('admin.users.index') }}" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.users*') ? 'bg-gray-700 text-white' : '' }}">
                            <i class="fas fa-user-cog w-5 h-5 mr-3"></i>
                            User Management
                        </a>
                        
                        <a href="{{ route('admin.users.change-own-password') }}" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-gray-200 transition-colors duration-200">
                            <i class="fas fa-shield-alt w-5 h-5 mr-3"></i>
                            Change Password
                        </a>
                        
                        <a href="#" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-gray-200 transition-colors duration-200">
                            <i class="fas fa-database w-5 h-5 mr-3"></i>
                            Backup & Restore
                        </a>
                    </div>

                    <!-- Help & Support -->
                    <div class="mb-6">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-2">Support</h3>
                        
                        <a href="http://localhost:5173" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-green-900 hover:text-green-200 transition-colors duration-200">
                            <i class="fas fa-external-link-alt w-5 h-5 mr-3"></i>
                            Frontend
                        </a>
                        
                        <a href="#" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-blue-900 hover:text-blue-200 transition-colors duration-200">
                            <i class="fas fa-question-circle w-5 h-5 mr-3"></i>
                            Help Center
                        </a>
                        
                        <a href="#" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-green-900 hover:text-green-200 transition-colors duration-200">
                            <i class="fas fa-headset w-5 h-5 mr-3"></i>
                            Contact Support
                        </a>
                        
                        <a href="#" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-purple-900 hover:text-purple-200">
                            <i class="fas fa-book w-5 h-5 mr-3"></i>
                            Documentation
                        </a>
                    </div>

                    <!-- Hero Images -->
                    <div class="mb-6">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-2">Hero Images</h3>
                        
                        <a href="{{ route('admin.hero-images') }}" 
                           class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-purple-700 hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.hero-images*') ? 'bg-purple-700 text-white' : '' }}">
                            <i class="fas fa-images w-5 h-5 mr-3"></i>
                            Hero Images
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col ml-64">
            <!-- Top Navigation -->
            <header class="bg-gray-800 shadow-sm border-b border-gray-700">
                <div class="flex items-center justify-between h-16 px-6">
                    <button @click="sidebarOpen = true" class="lg:hidden text-gray-300 hover:text-white">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" placeholder="Search..." class="w-64 px-4 py-2 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-700 text-white placeholder-gray-400">
                        </div>
                        
                        <a href="http://localhost:5173" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center"
                        >
                            <i class="fas fa-external-link-alt mr-2"></i>
                            Frontend
                        </a>
                        
                        <div class="flex items-center space-x-3">
                            @auth
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-medium">A</span>
                                </div>
                                <span class="text-gray-300">{{ auth()->user()->name }}</span>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-gray-300 hover:text-red-400 transition-colors duration-200">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                                    <i class="fas fa-sign-in-alt mr-2"></i>
                                    Login
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-900">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-900 border border-green-700 text-green-200 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-900 border border-red-700 text-red-200 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile overlay -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"
         @click="sidebarOpen = false"
         style="display: none;"></div>
</body>
</html> 