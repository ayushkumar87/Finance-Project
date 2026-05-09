@extends('layouts.app')

@section('content')
<div class="mb-8">
    <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium mb-4 inline-block">&larr; Back to Dashboard</a>
    <h1 class="text-3xl font-bold text-gray-800">Add Transaction</h1>
    <p class="text-gray-500 mt-1">Record a new income or expense.</p>
</div>

<div class="bg-white shadow rounded-lg max-w-2xl mx-auto">
    <div class="p-8">
        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf

            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Transaction Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="e.g. Monthly Salary, Groceries" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 shadow-sm @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Amount -->
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Amount ($)</label>
                    <input type="number" name="amount" id="amount" step="0.01" min="0.01" value="{{ old('amount') }}" placeholder="0.00" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 shadow-sm @error('amount') border-red-500 @enderror">
                    @error('amount')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date -->
                <div>
                    <label for="transaction_date" class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                    <input type="date" name="transaction_date" id="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 shadow-sm @error('transaction_date') border-red-500 @enderror">
                    @error('transaction_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Type -->
            <div class="mb-8">
                <label class="block text-sm font-medium text-gray-700 mb-2">Transaction Type</label>
                <div class="flex space-x-6">
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="expense" class="form-radio text-indigo-600 h-5 w-5" {{ old('type', 'expense') === 'expense' ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-700">Expense</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="income" class="form-radio text-green-600 h-5 w-5" {{ old('type') === 'income' ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-700">Income</span>
                    </label>
                </div>
                @error('type')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <a href="{{ route('dashboard') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md shadow-sm hover:bg-gray-50 mr-4 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700 transition">
                    Save Transaction
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
