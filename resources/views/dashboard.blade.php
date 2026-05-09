@extends('layouts.app')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-500 mt-1">Overview of your financial status.</p>
    </div>
    <a href="{{ route('transactions.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded shadow transition">
        + Add Transaction
    </a>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <!-- Balance Card -->
    <div class="bg-white rounded-lg shadow p-6 border-t-4 border-indigo-500">
        <h2 class="text-gray-500 text-sm uppercase font-semibold tracking-wider mb-2">Total Balance</h2>
        <p class="text-3xl font-bold text-gray-800">${{ number_format($balance, 2) }}</p>
    </div>

    <!-- Income Card -->
    <div class="bg-white rounded-lg shadow p-6 border-t-4 border-green-500">
        <h2 class="text-gray-500 text-sm uppercase font-semibold tracking-wider mb-2">Total Income</h2>
        <p class="text-3xl font-bold text-green-600">+${{ number_format($totalIncome, 2) }}</p>
    </div>

    <!-- Expense Card -->
    <div class="bg-white rounded-lg shadow p-6 border-t-4 border-red-500">
        <h2 class="text-gray-500 text-sm uppercase font-semibold tracking-wider mb-2">Total Expenses</h2>
        <p class="text-3xl font-bold text-red-600">-${{ number_format($totalExpense, 2) }}</p>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Chart Section -->
    <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center justify-center">
        <h2 class="text-lg font-semibold text-gray-800 w-full mb-4 border-b border-gray-100 pb-2">Financial Health</h2>
        @if($totalIncome > 0 || $totalExpense > 0)
            <div class="w-full max-w-[250px]">
                <canvas id="financeChart"></canvas>
            </div>
        @else
            <div class="text-center text-gray-500 py-10">
                <svg class="mx-auto h-10 w-10 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                <p class="text-sm">Not enough data to generate chart.</p>
            </div>
        @endif
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-lg shadow overflow-hidden lg:col-span-2">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">Recent Transactions</h2>
            <a href="{{ route('transactions.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">View All &rarr;</a>
        </div>
        
        @if($transactions->count() > 0)
            <ul class="divide-y divide-gray-100">
                @foreach($transactions as $transaction)
                    <li class="px-6 py-4 flex justify-between items-center hover:bg-gray-50 transition">
                        <div class="flex items-center">
                            <div class="p-2 rounded-full mr-4 {{ $transaction->type === 'income' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                @if($transaction->type === 'income')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                @endif
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $transaction->title }}</p>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="font-semibold {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $transaction->type === 'income' ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="p-8 text-center text-gray-500">
                <p>No transactions found.</p>
                <p class="text-sm mt-2">Click "Add Transaction" to get started.</p>
            </div>
        @endif
    </div>
</div>

<!-- Chart.js Script -->
@if($totalIncome > 0 || $totalExpense > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('financeChart').getContext('2d');
        const financeChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Income', 'Expenses'],
                datasets: [{
                    data: [{{ $totalIncome }}, {{ $totalExpense }}],
                    backgroundColor: [
                        '#10B981', // Tailwind green-500
                        '#EF4444'  // Tailwind red-500
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
                                family: "'Inter', sans-serif",
                                size: 14
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endif
@endsection
