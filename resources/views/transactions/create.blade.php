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
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Transaction Type</label>
                <div class="flex space-x-6">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="type" value="expense" class="form-radio text-indigo-600 h-5 w-5" {{ old('type', 'expense') === 'expense' ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Expense</span>
                    </label>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="type" value="income" class="form-radio text-green-600 h-5 w-5" {{ old('type') === 'income' ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-700 dark:text-gray-300">Income</span>
                    </label>
                </div>
                @error('type')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-8">
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Category</label>
                <select name="category" id="category" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 shadow-sm dark:bg-slate-900 dark:text-white dark:border-gray-700 @error('category') border-red-500 @enderror">
                    <!-- Javascript will populate this -->
                </select>
                @error('category')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <a href="{{ route('dashboard') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md shadow-sm hover:bg-gray-50 mr-4 transition dark:text-gray-300 dark:border-gray-700 dark:hover:bg-slate-800">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700 transition">
                    Save Transaction
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeRadios = document.querySelectorAll('input[name="type"]');
        const categorySelect = document.getElementById('category');

        const categories = {
            income: [
                { value: 'Salary', label: 'Salary' },
                { value: 'Freelance', label: 'Freelance' },
                { value: 'Investment', label: 'Investment' },
                { value: 'Gift', label: 'Gift' },
                { value: 'Refund', label: 'Refund' },
                { value: 'Other', label: 'Other' }
            ],
            expense: [
                { value: 'Food & Dining', label: 'Food & Dining' },
                { value: 'Rent & Housing', label: 'Rent & Housing' },
                { value: 'Utilities', label: 'Utilities' },
                { value: 'Shopping', label: 'Shopping' },
                { value: 'Transportation', label: 'Transportation' },
                { value: 'Entertainment', label: 'Entertainment' },
                { value: 'Healthcare', label: 'Healthcare' },
                { value: 'Education', label: 'Education' },
                { value: 'Other', label: 'Other' }
            ]
        };

        const oldCategory = "{{ old('category') }}";

        function updateCategories(type) {
            categorySelect.innerHTML = '';
            categories[type].forEach(cat => {
                const option = document.createElement('option');
                option.value = cat.value;
                option.textContent = cat.label;
                if (cat.value === oldCategory) {
                    option.selected = true;
                }
                categorySelect.appendChild(option);
            });
        }

        // Get currently selected radio type
        let selectedType = 'expense';
        typeRadios.forEach(radio => {
            if (radio.checked) {
                selectedType = radio.value;
            }
            radio.addEventListener('change', function() {
                updateCategories(this.value);
            });
        });

        // Initialize
        updateCategories(selectedType);
    });
</script>

@endsection
