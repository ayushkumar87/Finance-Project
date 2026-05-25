<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Manager</title>
    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Theme Script to avoid flash of light mode -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased transition-colors duration-300">

    <!-- Navigation -->
    <nav class="bg-indigo-600 text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold flex items-center space-x-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Finance Manager</span>
                </a>
                <div class="flex space-x-6 items-center">
                    @auth
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'text-white font-semibold' : 'text-indigo-200 hover:text-white transition' }}">Dashboard</a>
                        <a href="{{ route('transactions.index') }}" class="{{ request()->routeIs('transactions.*') ? 'text-white font-semibold' : 'text-indigo-200 hover:text-white transition' }}">Transactions</a>
                        <a href="{{ route('calculators') }}" class="{{ request()->routeIs('calculators') ? 'text-white font-semibold' : 'text-indigo-200 hover:text-white transition' }}">Calculators</a>
                        <a href="{{ route('news') }}" class="{{ request()->routeIs('news') ? 'text-white font-semibold' : 'text-indigo-200 hover:text-white transition' }}">Market News</a>
                        <a href="{{ route('literacy') }}" class="{{ request()->routeIs('literacy') ? 'text-white font-semibold' : 'text-indigo-200 hover:text-white transition' }}">Financial Literacy</a>
                        
                        <span class="border-l border-indigo-400 pl-6 text-indigo-200 hidden md:inline">Hi, {{ Auth::user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="hover:text-white text-indigo-200 font-medium transition">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('news') }}" class="{{ request()->routeIs('news') ? 'text-white font-semibold' : 'text-indigo-200 hover:text-white transition' }}">Market News</a>
                        <a href="{{ route('literacy') }}" class="{{ request()->routeIs('literacy') ? 'text-white font-semibold' : 'text-indigo-200 hover:text-white transition' }}">Financial Literacy</a>
                        <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'text-white font-semibold' : 'text-indigo-200 hover:text-white font-medium transition' }}">Login</a>
                        <a href="{{ route('register') }}" class="bg-white text-indigo-600 px-4 py-1 rounded shadow hover:bg-gray-100 font-medium transition">Register</a>
                    @endauth

                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="p-2 text-indigo-200 hover:text-white rounded-full transition focus:outline-none" aria-label="Toggle theme">
                        <!-- Sun Icon -->
                        <svg id="theme-toggle-light-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14 12a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <!-- Moon Icon -->
                        <svg id="theme-toggle-dark-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm rounded dark:bg-indigo-950 dark:border-green-400 dark:text-green-300" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center py-6 text-gray-500 text-sm mt-12 border-t border-gray-100 dark:border-gray-800">
        <p>&copy; {{ date('Y') }} Finance Manager. Built with Laravel and Tailwind CSS.</p>
    </footer>

    <!-- Theme Script at bottom -->
    <script>
        const toggleBtn = document.getElementById('theme-toggle');
        const lightIcon = document.getElementById('theme-toggle-light-icon');
        const darkIcon = document.getElementById('theme-toggle-dark-icon');

        // Toggle visibility helper
        function updateIcons() {
            if (document.documentElement.classList.contains('dark')) {
                lightIcon.classList.remove('hidden');
                darkIcon.classList.add('hidden');
            } else {
                darkIcon.classList.remove('hidden');
                lightIcon.classList.add('hidden');
            }
        }

        // Set initial icon state
        updateIcons();

        toggleBtn.addEventListener('click', () => {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
            updateIcons();
        });
    </script>
</body>
</html>
