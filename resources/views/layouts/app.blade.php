<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Manager</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

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
                        <a href="{{ route('news') }}" class="{{ request()->routeIs('news') ? 'text-white font-semibold' : 'text-indigo-200 hover:text-white transition' }}">Market News</a>
                        <a href="{{ route('literacy') }}" class="{{ request()->routeIs('literacy') ? 'text-white font-semibold' : 'text-indigo-200 hover:text-white transition' }}">Financial Literacy</a>
                        
                        <span class="border-l border-indigo-400 pl-6 text-indigo-200">Hi, {{ Auth::user()->name }}</span>
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
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm rounded" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center py-6 text-gray-500 text-sm mt-12">
        <p>&copy; {{ date('Y') }} Finance Manager. Built with Laravel and Tailwind CSS.</p>
    </footer>

</body>
</html>
