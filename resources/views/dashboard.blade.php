@extends('layouts.app')

@section('content')
<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Financial Dashboard</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Real-time overview of your incomes, expenses, and financial health.</p>
    </div>
    <div class="flex gap-3">
        <button onclick="openQuickAddModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-5 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            Add Transaction
        </button>
    </div>
</div>

<!-- Summary Cards (4 Columns) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Balance Card -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-md p-6 border-t-4 border-indigo-500 transition-all duration-200">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-gray-400 text-xs uppercase font-bold tracking-wider mb-1">Total Balance</h2>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($balance, 2) }}</p>
            </div>
            <div class="p-2.5 bg-indigo-50 dark:bg-slate-900 text-indigo-600 dark:text-indigo-400 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Income Card -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-md p-6 border-t-4 border-green-500 transition-all duration-200">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-gray-400 text-xs uppercase font-bold tracking-wider mb-1">Total Income</h2>
                <p class="text-2xl font-bold text-green-600 dark:text-green-400">+${{ number_format($totalIncome, 2) }}</p>
            </div>
            <div class="p-2.5 bg-green-50 dark:bg-slate-900 text-green-600 dark:text-green-400 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
        </div>
    </div>

    <!-- Expense Card -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-md p-6 border-t-4 border-red-500 transition-all duration-200">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-gray-400 text-xs uppercase font-bold tracking-wider mb-1">Total Expenses</h2>
                <p class="text-2xl font-bold text-red-600 dark:text-red-400">-${{ number_format($totalExpense, 2) }}</p>
            </div>
            <div class="p-2.5 bg-red-50 dark:bg-slate-900 text-red-600 dark:text-red-400 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path></svg>
            </div>
        </div>
    </div>

    <!-- Savings Rate Card -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-md p-6 border-t-4 border-teal-500 transition-all duration-200">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-gray-400 text-xs uppercase font-bold tracking-wider mb-1">Savings Rate</h2>
                <p class="text-2xl font-bold {{ $savingsRate >= 0 ? 'text-teal-600 dark:text-teal-400' : 'text-orange-600 dark:text-orange-400' }}">
                    {{ $savingsRate }}%
                </p>
            </div>
            <div class="p-2.5 bg-teal-50 dark:bg-slate-900 text-teal-600 dark:text-teal-400 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5a2 2 0 10-2 2h2z"></path></svg>
            </div>
        </div>
        <p class="text-xs text-gray-500 mt-2">
            @if($savingsRate > 50)
                Excellent saving habits!
            @elseif($savingsRate > 20)
                Healthy savings rate.
            @elseif($savingsRate > 0)
                Consider reducing non-essential expenses.
            @else
                You spent more than you earned.
            @endif
        </p>
    </div>
</div>

<!-- Main Layout Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Left Panel (Col-span 2) -->
    <div class="lg:col-span-2 flex flex-col gap-8">
        
        <!-- 7-Day Trend Chart Card -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Weekly Transaction Trend</h2>
            <div class="h-[300px] w-full">
                <canvas id="weeklyTrendChart"></canvas>
            </div>
        </div>

        <!-- Recent Transactions Card -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Recent Transactions</h2>
                <a href="{{ route('transactions.index') }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm font-semibold flex items-center gap-1 transition">
                    View All
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>

            @if($transactions->count() > 0)
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($transactions as $transaction)
                        <div class="px-6 py-4.5 flex justify-between items-center hover:bg-gray-50/50 dark:hover:bg-slate-700/50 transition duration-150">
                            <div class="flex items-center gap-4">
                                <div class="p-2.5 rounded-full {{ $transaction->type === 'income' ? 'bg-green-50 text-green-600 dark:bg-slate-900 dark:text-green-400' : 'bg-red-50 text-red-600 dark:bg-slate-900 dark:text-red-400' }}">
                                    @if($transaction->type === 'income')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-gray-100">{{ $transaction->title }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('M d, Y') }}</span>
                                        <span class="text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded bg-gray-100 dark:bg-slate-700 text-gray-500 dark:text-gray-300">
                                            {{ $transaction->category ?? 'Other' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="font-bold text-lg {{ $transaction->type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $transaction->type === 'income' ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                                </span>
                                <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" onsubmit="return confirm('Delete this transaction?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors p-1" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-12 text-center text-gray-500">
                    <p class="font-medium text-lg">No transactions found.</p>
                    <p class="text-sm mt-1">Add transactions to see your records here.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Right Panel (Col-span 1) -->
    <div class="flex flex-col gap-8">

        <!-- Dynamic Budget Planner Widget -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Monthly Budget</h2>
                <button onclick="toggleBudgetEdit()" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline" id="budget-edit-btn">Edit</button>
            </div>
            
            <!-- Budget Input Row -->
            <div id="budget-edit-row" class="hidden mb-4 flex gap-2">
                <input type="number" id="budget-input" placeholder="Set Budget" min="0" class="w-full px-3 py-1.5 border border-gray-300 dark:border-gray-700 rounded-lg text-sm bg-gray-50 dark:bg-slate-900 focus:outline-none" />
                <button onclick="saveBudget()" class="bg-indigo-600 text-white text-xs font-semibold px-4 py-2 rounded-lg hover:bg-indigo-700">Save</button>
            </div>

            <!-- Budget Info -->
            <div class="flex justify-between items-end mb-2">
                <div>
                    <p class="text-xs text-gray-400">Total Spent</p>
                    <p class="text-xl font-extrabold text-gray-900 dark:text-white">${{ number_format($totalExpense, 2) }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-400">Limit</p>
                    <p class="text-lg font-bold text-gray-600 dark:text-gray-300" id="budget-limit-display">$0.00</p>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="w-full bg-gray-100 dark:bg-slate-700 rounded-full h-3 mb-4 overflow-hidden">
                <div id="budget-progress-bar" class="h-full bg-green-500 rounded-full transition-all duration-500" style="width: 0%"></div>
            </div>

            <!-- Remaining / Warning Notification -->
            <div id="budget-alert" class="p-3.5 rounded-lg text-xs font-semibold hidden">
                <!-- Javascript will inject messages here -->
            </div>
        </div>

        <!-- Financial Health Doughnut Card -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6 flex flex-col items-center">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white w-full mb-6 pb-2 border-b border-gray-50 dark:border-gray-700">Financial Ratio</h2>
            @if($totalIncome > 0 || $totalExpense > 0)
                <div class="w-full max-w-[200px] mb-4">
                    <canvas id="financeRatioChart"></canvas>
                </div>
            @else
                <div class="text-center text-gray-500 py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-300 dark:text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    <p class="text-sm">Not enough data to calculate ratio.</p>
                </div>
            @endif
        </div>

        <!-- Expense Category Breakdown Card -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6 pb-2 border-b border-gray-50 dark:border-gray-700">Expense Allocations</h2>
            @if($categoryBreakdown->count() > 0)
                <div>
                    @foreach($categoryBreakdown as $breakdown)
                        @php
                            $percentage = $totalExpense > 0 ? round(($breakdown->total / $totalExpense) * 100) : 0;
                            
                            // Visual color matching for bars
                            $barColor = 'bg-slate-500';
                            if (str_contains($breakdown->category, 'Food')) $barColor = 'bg-orange-500';
                            elseif (str_contains($breakdown->category, 'Housing') || str_contains($breakdown->category, 'Rent')) $barColor = 'bg-blue-500';
                            elseif (str_contains($breakdown->category, 'Utilities')) $barColor = 'bg-yellow-500';
                            elseif (str_contains($breakdown->category, 'Shopping')) $barColor = 'bg-pink-500';
                            elseif (str_contains($breakdown->category, 'Transportation') || str_contains($breakdown->category, 'Travel')) $barColor = 'bg-teal-500';
                            elseif (str_contains($breakdown->category, 'Entertainment')) $barColor = 'bg-purple-500';
                            elseif (str_contains($breakdown->category, 'Healthcare')) $barColor = 'bg-red-500';
                            elseif (str_contains($breakdown->category, 'Education')) $barColor = 'bg-green-500';
                        @endphp
                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-1.5">
                                <span class="font-medium text-gray-700 dark:text-gray-300">{{ $breakdown->category }}</span>
                                <span class="font-semibold text-gray-900 dark:text-white">${{ number_format($breakdown->total, 2) }} ({{ $percentage }}%)</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-slate-700 rounded-full h-2">
                                <div class="{{ $barColor }} h-2 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-gray-500 py-12">
                    <p class="text-sm">No expenses recorded yet.</p>
                </div>
            @endif
        </div>

    </div>
</div>

<!-- Glassmorphic Quick-Add Overlay Modal -->
<div id="quick-add-modal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div id="modal-container" class="bg-white dark:bg-slate-800 rounded-xl shadow-2xl max-w-lg w-full overflow-hidden transform scale-95 opacity-0 transition-all duration-300">
        
        <!-- Header -->
        <div class="px-6 py-4 bg-indigo-600 text-white flex justify-between items-center">
            <h3 class="font-bold text-lg">Quick-Add Transaction</h3>
            <button onclick="closeQuickAddModal()" class="text-white hover:text-gray-200 p-1 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Body -->
        <div class="p-6">
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                
                <!-- Title -->
                <div class="mb-5">
                    <label for="modal-title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Transaction Title</label>
                    <input type="text" name="title" id="modal-title" placeholder="e.g. Salary, Electricity bill, Dinner" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-slate-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Row 1: Amount & Date -->
                <div class="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label for="modal-amount" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Amount ($)</label>
                        <input type="number" name="amount" id="modal-amount" step="0.01" min="0.01" placeholder="0.00" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-slate-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label for="modal-date" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Date</label>
                        <input type="date" name="transaction_date" id="modal-date" value="{{ date('Y-m-d') }}" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-slate-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <!-- Row 2: Type -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Transaction Type</label>
                    <div class="flex gap-6">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="type" value="expense" checked class="modal-type-radio form-radio text-indigo-600 h-5 w-5">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300 font-medium">Expense</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="type" value="income" class="modal-type-radio form-radio text-green-600 h-5 w-5">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300 font-medium">Income</span>
                        </label>
                    </div>
                </div>

                <!-- Row 3: Category -->
                <div class="mb-6">
                    <label for="modal-category" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Category</label>
                    <select name="category" id="modal-category" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-slate-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <!-- Populated by JS -->
                    </select>
                </div>

                <!-- Actions -->
                <div class="flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700 pt-5">
                    <button type="button" onclick="closeQuickAddModal()" class="px-5 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-semibold hover:bg-gray-50 dark:hover:bg-slate-700">Cancel</button>
                    <button type="submit" class="px-5 py-2 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 shadow-md">Add Transaction</button>
                </div>
            </form>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // -------------------------------------------------------------
    // 1. Modal Logic & Category Switching
    // -------------------------------------------------------------
    const modal = document.getElementById('quick-add-modal');
    const container = document.getElementById('modal-container');
    const categorySelect = document.getElementById('modal-category');
    const typeRadios = document.querySelectorAll('.modal-type-radio');

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

    function updateModalCategories(type) {
        categorySelect.innerHTML = '';
        categories[type].forEach(cat => {
            const option = document.createElement('option');
            option.value = cat.value;
            option.textContent = cat.label;
            categorySelect.appendChild(option);
        });
    }

    function openQuickAddModal() {
        modal.classList.remove('hidden');
        setTimeout(() => {
            container.classList.remove('scale-95', 'opacity-0');
            container.classList.add('scale-100', 'opacity-100');
        }, 10);
        
        let selected = 'expense';
        typeRadios.forEach(radio => {
            if(radio.checked) selected = radio.value;
        });
        updateModalCategories(selected);
    }

    function closeQuickAddModal() {
        container.classList.remove('scale-100', 'opacity-100');
        container.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    typeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            updateModalCategories(this.value);
        });
    });

    // -------------------------------------------------------------
    // 2. Budget Widget Logic
    // -------------------------------------------------------------
    let totalExpense = {{ $totalExpense }};
    let monthlyBudget = parseFloat(localStorage.getItem('monthly_budget')) || 0;

    const budgetEditRow = document.getElementById('budget-edit-row');
    const budgetInput = document.getElementById('budget-input');
    const budgetLimitDisplay = document.getElementById('budget-limit-display');
    const budgetProgressBar = document.getElementById('budget-progress-bar');
    const budgetAlert = document.getElementById('budget-alert');
    const budgetEditBtn = document.getElementById('budget-edit-btn');

    function toggleBudgetEdit() {
        if(budgetEditRow.classList.contains('hidden')) {
            budgetEditRow.classList.remove('hidden');
            budgetInput.value = monthlyBudget || '';
            budgetEditBtn.textContent = 'Cancel';
        } else {
            budgetEditRow.classList.add('hidden');
            budgetEditBtn.textContent = 'Edit';
        }
    }

    function saveBudget() {
        let amt = parseFloat(budgetInput.value) || 0;
        localStorage.setItem('monthly_budget', amt);
        monthlyBudget = amt;
        budgetEditRow.classList.add('hidden');
        budgetEditBtn.textContent = 'Edit';
        updateBudgetWidget();
    }

    function updateBudgetWidget() {
        budgetLimitDisplay.textContent = '$' + monthlyBudget.toFixed(2);
        
        if (monthlyBudget <= 0) {
            budgetProgressBar.style.width = '0%';
            budgetAlert.classList.add('hidden');
            return;
        }

        let percent = (totalExpense / monthlyBudget) * 100;
        let cappedPercent = Math.min(100, percent);
        budgetProgressBar.style.width = cappedPercent + '%';

        // Update colors
        budgetProgressBar.className = 'h-full rounded-full transition-all duration-500 ';
        if (percent > 90) {
            budgetProgressBar.classList.add('bg-red-500');
        } else if (percent > 70) {
            budgetProgressBar.classList.add('bg-yellow-500');
        } else {
            budgetProgressBar.classList.add('bg-green-500');
        }

        budgetAlert.classList.remove('hidden', 'bg-green-50', 'text-green-700', 'bg-red-50', 'text-red-700', 'bg-yellow-50', 'text-yellow-700', 'dark:bg-red-950/20', 'dark:text-red-400');
        
        if(percent > 100) {
            let diff = totalExpense - monthlyBudget;
            budgetAlert.classList.add('bg-red-50', 'text-red-700', 'dark:bg-red-950/20', 'dark:text-red-400');
            budgetAlert.innerHTML = `⚠️ Budget Exceeded by $${diff.toFixed(2)}!`;
        } else {
            let diff = monthlyBudget - totalExpense;
            budgetAlert.classList.add('bg-green-50', 'text-green-700', 'dark:bg-slate-900', 'dark:text-green-400');
            budgetAlert.innerHTML = `👍 Good job! $${diff.toFixed(2)} remaining.`;
        }
    }

    // Initialize Budget Widget
    updateBudgetWidget();

    // -------------------------------------------------------------
    // 3. Chart.js Graphs Setup
    // -------------------------------------------------------------
    document.addEventListener('DOMContentLoaded', function() {
        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#9ca3af' : '#6b7280';
        const gridColor = isDark ? '#374151' : '#f3f4f6';

        // 3a. 7-Day Trend Chart
        const trendCtx = document.getElementById('weeklyTrendChart').getContext('2d');
        const trendChart = new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($days) !!},
                datasets: [
                    {
                        label: 'Income',
                        data: {!! json_encode($dailyIncome) !!},
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16, 185, 129, 0.05)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.35,
                        pointRadius: 3,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Expense',
                        data: {!! json_encode($dailyExpense) !!},
                        borderColor: '#EF4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.05)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.35,
                        pointRadius: 3,
                        pointHoverRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: textColor,
                            font: { family: 'sans-serif', size: 12, weight: '600' }
                        }
                    },
                    tooltip: {
                        padding: 10,
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#334155',
                        borderWidth: 1
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: textColor }
                    },
                    y: {
                        grid: { color: gridColor },
                        ticks: { color: textColor }
                    }
                }
            }
        });

        // 3b. Finance Ratio (Doughnut) Chart
        const ratioEl = document.getElementById('financeRatioChart');
        if (ratioEl) {
            const ratioCtx = ratioEl.getContext('2d');
            const ratioChart = new Chart(ratioCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Income', 'Expenses'],
                    datasets: [{
                        data: [{{ $totalIncome }}, {{ $totalExpense }}],
                        backgroundColor: ['#10B981', '#EF4444'],
                        borderWidth: 0,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: textColor,
                                padding: 12,
                                font: { family: 'sans-serif', size: 12, weight: '600' }
                            }
                        }
                    }
                }
            });
        }

        // Listen for theme toggle to update grid lines and labels dynamically
        const toggleBtn = document.getElementById('theme-toggle');
        if(toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                const nextDark = document.documentElement.classList.contains('dark');
                const nextText = nextDark ? '#9ca3af' : '#6b7280';
                const nextGrid = nextDark ? '#374151' : '#f3f4f6';

                // Update scales & legends
                trendChart.options.scales.x.ticks.color = nextText;
                trendChart.options.scales.y.ticks.color = nextText;
                trendChart.options.scales.y.grid.color = nextGrid;
                trendChart.options.plugins.legend.labels.color = nextText;
                trendChart.update();
            });
        }
    });
</script>
@endsection
