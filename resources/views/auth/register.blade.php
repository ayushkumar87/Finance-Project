@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden mt-10">
    <div class="bg-green-600 px-6 py-4">
        <h2 class="text-2xl font-bold text-white text-center">Register</h2>
    </div>
    
    <div class="p-6">
        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 shadow-sm">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 shadow-sm">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" name="password" id="password" required minlength="8"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 shadow-sm">
                <p class="text-xs text-gray-500 mt-1">Must be at least 8 characters long.</p>
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 shadow-sm">
            </div>

            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded shadow transition">
                Create Account
            </button>
        </form>
    </div>
    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 text-center">
        <p class="text-sm text-gray-600">Already have an account? <a href="{{ route('login') }}" class="text-green-600 hover:text-green-800 font-medium">Login here</a></p>
    </div>
</div>
@endsection
